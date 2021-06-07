<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\HotelBooking;
use App\Models\HotelRoom;
use App\Repositories\HotelRepository;
use App\Xstudioz\Booking\BookingFromSession;
use App\Xstudioz\Booking\HotelItem;
use App\Xstudioz\HotelFilter;
use DebugBar\DebugBar;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use function PHPUnit\Framework\throwException;

class HotelBookingController extends Controller
{
  public function __invoke($city, $hotelSlug, HotelFilter $hotelFilter, HotelRepository $hotelRepository)
  {

    $hotel = $hotelRepository->hotelBySlug($hotelSlug, $hotelFilter->getCheckInDate(), $hotelFilter->getCheckOutDate());
    $seo = $hotel->seo;
    $roomImages = $hotel ? $hotel->getRoomImages() : [];
    $booking = BookingFromSession::getBooking();
    $similarHotels = $hotelRepository->similarHotels($hotel->city_id, [$hotel->id]);
    if ($booking->hotelItem && $booking->hotelItem->hotel->id === $hotel->id) {
      //same hotel exist
    } else {
      $hotelItem = new HotelItem($hotel, $hotelFilter->getCheckInDate(), $hotelFilter->getCheckOutDate(), []);
      $booking->setHotelItem($hotelItem);
    }
    $booking = BookingFromSession::save($booking);
    return view('pages.hotel-single', compact('hotel', 'seo', 'roomImages', 'similarHotels', 'booking'));
  }
}

