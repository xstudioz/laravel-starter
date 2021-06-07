<?php


namespace App\Http\Controllers\Front;


use App;
use App\Models\Booking;
use App\Models\CabBooking;
use App\Models\Coupon;
use App\Models\Hotel;
use App\Models\HotelBooking;
use App\Models\HotelRoom;
use App\Models\Transaction;
use App\Repositories\BookingRepository;
use App\Xstudioz\Booking\BookingFromSession;
use App\Xstudioz\Booking\BookingModel;
use App\Xstudioz\Booking\HotelItem;
use App\Xstudioz\Booking\HotelRoomItem;
use App\Xstudioz\Booking\RazorpayOrderModel;
use App\Xstudioz\Booking\TaxCalculator;
use App\Xstudioz\CabFilter;
use App\Xstudioz\HotelFilter;
use App\Xstudioz\ResponseHelper;
use Auth;
use Exception;
use Faker\Provider\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Log;
use MyAppSettings;
use Razorpay\Api\Api;
use Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use function PHPUnit\Framework\throwException;

class BookingController
{
  function calculate(BookingRepository $bookingRepository)
  {
    $booking = BookingFromSession::getBooking() ?? $bookingRepository->getBookingModel();
    $updatedRooms = request()->input('hotel.rooms', []);
    if ($booking->hotelItem) $booking->hotelItem->addOrUpdateRooms($updatedRooms);
    $booking = BookingFromSession::save($booking);
    return $booking->finalizeCalculations();

  }

  function applyCoupon()
  {
    $booking = BookingFromSession::getBooking();
    $remove = request()->input('remove');
    if ($remove) {
      $booking->setCoupon(null);
      BookingFromSession::save($booking);
      return response()->json([]);
    }
    $couponCode = request()->input('code');
    $coupon = Coupon::active()->where(['code' => $couponCode])->first(); //todo  update validation
    if ($coupon) {
      $booking->setCoupon($coupon);
      $booking = BookingFromSession::save($booking);
      return response()->json([$booking], 201);
    }
    return ResponseHelper::error(__("Invalid Coupon Code"), 404);

  }

  function create(Api $api): array
  {
    $isOnlinePayment = request()->payment_mode === 'online';
    $booking = BookingFromSession::getBooking();
    $prices = $booking->finalizeCalculations();
    try {
      DB::beginTransaction();
      $b = new Booking();
      $b->user_id = Auth::id();
      $b->guid = Uuid::uuid();
      $b->coupon_code = $booking->coupon ? $booking->coupon->code : null;
      $b->amount = $booking->getBasePrice();
      $b->discount_amount = $booking->getDiscount();
      $b->tax_rate = MyAppSettings::taxRate();
      $b->tax_amount = $booking->getTax();
      $b->payment_mode = request()->payment_mode;
      $b->status = $isOnlinePayment ? 'pending' : 'booked';
      $b->save();
      //add items
      if ($booking->hotelItem) {
        foreach ($booking->hotelItem->rooms as $room) {
          $hotelBooking = new HotelBooking();
          $hotelBooking->user_id = Auth::id();
          $hotelBooking->booking_id = $b->id;
          $hotelBooking->hotel_id = $booking->hotelItem->hotel->id;
          $hotelBooking->hotel_room_id = $room->roomId;
          $hotelBooking->check_in = $booking->hotelItem->in;
          $hotelBooking->check_out = $booking->hotelItem->out;
          $hotelBooking->total_days = $hotelBooking->check_in->diffInDays($hotelBooking->check_out);
          $hotelBooking->room_type = $room->name;
          $hotelBooking->room_price = $room->price;
          $hotelBooking->tax_rate = MyAppSettings::taxRate();
          $hotelBooking->tax_amount = 0;//MyAppSettings::taxRate();
          $hotelBooking->save();
        }
      }
      if ($booking->cabItem) {
        //todo add cab logic
        $cabBooking = new CabBooking();
        $cabBooking->booking_id = $b->id;
        $cabBooking->user_id = Auth::id();
        $cabBooking->trip_type = $booking->cabItem->getTripType();
        $cabBooking->number_of_passengers = $booking->cabItem->getPassengers();
        $cabBooking->pickup_location = $booking->cabItem->getPickupLocation();
        $cabBooking->drop_location = $booking->cabItem->getDropLocation();
        $cabBooking->pickup_time = $booking->cabItem->getStartDateTime();
        $cabBooking->return_pickup_time = $booking->cabItem->getReturnDateTime();
        $cabBooking->distance = $booking->cabItem->getDistance();
        $cabBooking->days = $booking->cabItem->getDays();
        $cabBooking->cab_id = $booking->cabItem->getCab()->id;
        $cabBooking->cab_type = $booking->cabItem->getCab()->name;
        $cabBooking->distance_charge = $booking->cabItem->getCab()->distance_price;
        $cabBooking->halting_charge = $booking->cabItem->getCab()->halting_charges;
        $cabBooking->tax_rate = MyAppSettings::taxRate();
        $cabBooking->save();
      }
      DB::commit();

      if (!$isOnlinePayment) {
        return ['guid' => $b->guid];
      }
      //
      $payload = [
        'receipt' => Uuid::uuid(),
        'currency' => 'INR',
        'amount' => $booking->getFinalPrice() * 100,
        'notes' => [
          'booking_id' => $b->id
        ]
      ];
      $orderFromRazorpay = $api->order->create($payload);
      $RazorpayOrder = RazorpayOrderModel::fromArray($orderFromRazorpay->toArray());
      //
      return [
        'key' => config('razorpay.key'),
        'amount' => $RazorpayOrder->amount,
        'currency' => $RazorpayOrder->currency,
        'name' => config('app.name'),
        'description' => '',
        'order_id' => $RazorpayOrder->id
      ];
    } catch (Exception $e) {
      DB::rollBack();
      Log::error($e->getMessage(), $e);
      throwException($e);
    }

  }

  function review()
  {
    $booking = BookingFromSession::getBooking();
    return view('pages.booking.review', compact('booking'));
  }

  function paymentCallback($guid = null, Api $api, CabFilter $cabFilter, HotelFilter $hotelFilter)
  {

    $title = "Payment Status";
    $booking = null;
    if ($guid) {
      $booking = Booking::whereGuid($guid)->first();
      $booking->status = 'booked';
      $booking->save();
      $payment = null;
      if (empty($booking)) throw new NotFoundHttpException();
    } else {
      //
      $paymentId = request()->razorpay_payment_id;
      $signature = request()->razorpay_signature;
      $payment = $api->payment->fetch($paymentId);
      $bookingId = $payment->notes['booking_id'];
      try {
        DB::beginTransaction();
        $trx = Transaction::where(['hash' => $signature])->first();
        if ($trx) { //already processed
          $booking = $trx->booking;
        } else {
          $booking = Booking::findOrFail($bookingId);
          if ($payment->captured === true) { //payment ok
            $booking->createTransaction(Auth::id(), $paymentId, 'paid', 'razorpay', null, $signature);
            $booking->status = 'paid';
          } else {        //payment failed
            $booking->createTransaction(Auth::id(), $paymentId, 'failed', 'razorpay', null, $signature);
            $booking->status = 'failed';
          }
          $booking->save();
          DB::commit();
        }

      } catch (Exception $e) {
        DB::rollBack();
        Log::error($e->getMessage(), ['stack' => $e]);
        dd($e);
      } catch (Throwable $e) {
        dd($e);
      }
    }
    if ($booking->confirmed()) {
      BookingFromSession::clear();
      $cabFilter->clear();
      $hotelFilter->clear();
    }
    return view('pages.payments.status', compact('title', 'payment', 'booking'));

  }

}
