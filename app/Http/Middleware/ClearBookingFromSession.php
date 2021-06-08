<?php

namespace App\Http\Middleware;

use App;
use App\Xstudioz\Booking\BookingFromSession;
use Closure;

class ClearBookingFromSession
{
  /**
   * Handle an incoming request.
   *
   * @param \Illuminate\Http\Request $request
   * @param \Closure $next
   * @return mixed
   */
  public function handle($request, Closure $next)
  {
    if ($request->isMethod('get') && $request->has('clear')) {
      $booking = BookingFromSession::getBooking();
      $hotelFilter = App::make(App\Xstudioz\HotelFilter::class);
      if ($request->clear == 'hotel') {
        $booking->setHotelItem(null);
        $booking->setCombo(false);
      }
      if ($request->clear == 'cab') {
        $booking->setCabItem(null);
        $booking->setCombo(false);
      }
      BookingFromSession::save($booking);

    }
    return $next($request);
  }
}
