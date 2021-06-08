<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Cab;
use App\Repositories\CabRepository;
use App\Xstudioz\Booking\BookingFromSession;
use App\Xstudioz\Booking\CabItem;
use App\Xstudioz\Cab\CabPriceCalculator;
use App\Xstudioz\CabFilter;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CabPageController extends Controller
{
  public function index()
  {
    $title = 'Cab Booking';
    return view('pages.cab', compact('title'));
  }

  public function book($slug, CabFilter $cf)
  {
    if (empty($cf->getPickup())) return redirect(route('booking.cab'));

    $title = 'Cab Booking';
    $cab = Cab::front()->where(['slug' => $slug])->first();
    if (empty($cab)) throw new NotFoundHttpException();
    $cabPriceCalculator = new CabPriceCalculator($cab, $cf);
    $booking = BookingFromSession::getBooking();
    $cabItem = new CabItem($cf->getPickup(), $cf->getDrop(), $cab, $cf->getTripType(), $cf->getDistance(), $cf->getPickupTimestamp(), $cf->getJourneyTime(), $cf->getPassengers(), $cf->getDropTimestamp());
    $booking->setCabItem($cabItem);
    return view('pages.cabs.book', compact('title', 'booking', 'cab', 'cabPriceCalculator', 'booking'));
  }

  public function search(CabRepository $cabRepository, CabFilter $cabFilter)
  {
    $title = 'Cab Search';
    $cabs = $cabRepository->search($cabFilter);
    return view('pages.cabs.search', compact('title', 'cabs'));
  }
}
