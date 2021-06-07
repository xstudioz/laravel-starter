<?php

namespace App\Http\Middleware;

use App\Models\City;
use App\Xstudioz\Booking\BookingFromSession;
use App\Xstudioz\CabFilter;
use App\Xstudioz\HotelFilter;
use Barryvdh\Debugbar\Facade;
use Carbon\Carbon;
use Closure;
use Faker\Provider\da_DK\Payment;
use Illuminate\Support\Facades\App;
use Session;
use stdClass;
use Str;
use View;

class SearchInterceptor
{
  /**
   * Handle an incoming request.
   *
   * @param \Illuminate\Http\Request $request
   * @param \Closure $next
   * @return mixed
   */
  private function parseToCarbon($dateString)
  {
    return Carbon::rawParse($dateString);
  }

  public function handle($request, Closure $next)
  {
    /** @var HotelFilter $filter */
    $filter = App::make(HotelFilter::class);
    /** @var CabFilter $cabFilter */
    $cabFilter = App::make(CabFilter::class);

    if ($request->combo == '1') {
      $booking = BookingFromSession::getBooking();
      $booking->setCombo(true);

    }

    if (request()->isMethod('post') && $request->input('cab') == 1) {
      $request->request->add([
        'pickupTimestamp' => $this->parseToCarbon($request->pickupTimestamp),
        'dropTimestamp' => $this->parseToCarbon($request->dropTimestamp)
      ]);
      $cabFilter->updateFromArray($request->all());
      $cabFilter->setPickupTimestamp($request->pickupTimestamp);
      $cabFilter->setDropTimestamp($request->dropTimestamp);
      $cabFilter->save();
      return redirect()->route('booking.cab.search');
      //redirect o searc page
    }

    //hotel filter
    if (request()->isMethod('post') && request()->hotel_search == "1") {

      $city = City::where('slug', Str::slug(request()->input('city')))->first();
      if (empty($city)) {
        return redirect()->back()->with('message', ['type' => 'danger', 'message' => 'City not found']);
      }
      $checkOutDate = Carbon::parseFromLocale($request->check_out_date, null, 'Asia/Kolkata');
      $checkInDate = Carbon::parseFromLocale($request->check_in_date, null, 'Asia/Kolkata');
      $filter->setCheckInDate($checkInDate);
      $filter->setCheckOutDate($checkOutDate);
      $filter->setCity($city);
      $filter->setRooms(json_decode(request()->input('rooms')));
      $filter->save();
      return redirect()->route('hotel.search', ['city' => $city->slug]);
    }


    if ($request->action == 'dates_update') {
      $in = Carbon::parse($request->d1);
      $out = Carbon::parse($request->d2);
      $filter->setCheckInDate($in);
      $filter->setCheckOutDate($out);
      $filter->save();
      return redirect()->back()->with('message', ['type' => 'success', 'message' => 'Check in and check out dates updated']);
    }


    View::share('hotelFilter', $filter);
    View::share('cabFilter', $cabFilter);
    View::share('booking', BookingFromSession::getBooking());
    return $next($request);
  }

  function checkInDateToCarbon($da)
  {
    $d = explode(' - ', $da);
    $d[0] = Carbon::createFromFormat('D, d M Y', trim($d[0]));
    $d[1] = Carbon::createFromFormat('D, d M Y', trim($d[1]));
    return $d;
  }
}
