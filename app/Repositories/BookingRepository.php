<?php


namespace App\Repositories;


use App\Models\Coupon;
use App\Models\Hotel;
use App\Models\HotelRoom;
use App\Xstudioz\Booking\BookingModel;
use App\Xstudioz\Booking\HotelItem;
use App\Xstudioz\Booking\HotelRoomItem;
use App\Xstudioz\Booking\TaxCalculator;
use App\Xstudioz\HotelFilter;
use Illuminate\Support\Carbon;
use Session;

class BookingRepository
{

  function getBookingModel(): BookingModel
  {
    $booking = new BookingModel();

    if (request()->hotel) {
      $hotelId = request()->input('hotel.id');
      $hotel = Hotel::where(['id' => $hotelId])->first(['id', 'name', 'slug', 'city_id']);
      $in = Carbon::createFromFormat('d-m-y', request()->input('hotel.check_in_date'), 'Asia/Kolkata');// $hotelFilter->getCheckInDate();
      $out = Carbon::createFromFormat('d-m-y', request()->input('hotel.check_out_date'), 'Asia/Kolkata');//$hotelFilter->getCheckOutDate();
      $rooms = [];
      foreach (request()->input('hotel.rooms') as $room) {
        $roomModel = HotelRoom::findOrFail($room['id']);
        $rooms[] = new HotelRoomItem($room['id'], $room['number_of_rooms'], $roomModel->price, $roomModel->name);
      }
      $hotelItem = new HotelItem($hotel, $in, $out, $rooms);
      $hotelItem->hotel = $hotel;
      $booking->setHotelItem($hotelItem);
    }
    if (request()->cab) {
    }

    return $booking;
  }

  function applyCoupon(Coupon $coupon, float $amount)
  {

    if ($coupon->type == 'AMOUNT') {
      return $coupon->value;
    } else {
      return round($amount * $coupon->value / 100, 2);
    }
  }
}
