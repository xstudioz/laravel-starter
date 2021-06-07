<?php

namespace App\Http\Controllers\Front;

use App\Repositories\HotelRepository;
use App\Xstudioz\HotelFilter;
use Illuminate\Routing\Controller;

class HotelSearchController extends Controller
{
  public function __invoke(HotelRepository $hotelRepository, HotelFilter $filter)
  {
    $hotels = $hotelRepository->search($filter);

    $templateData = [
      'title' => 'Hotels in ',
      'hotels' => $hotels
    ];
    return view('pages.hotel-listing', $templateData);
  }
}
