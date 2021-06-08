<?php

namespace App\Http\Middleware;

use App\Xstudioz\Booking\BookingFromSession;
use App\Xstudioz\Booking\BookingModel;
use Closure;

class EmptyBookingInit
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

    return $next($request);
  }
}
