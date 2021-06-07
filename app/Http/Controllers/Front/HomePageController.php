<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Repositories\HotelRepository;
use App\Xstudioz\HotelFilter;
use OpenGraph;

class HomePageController extends Controller
{
  public function __invoke(HotelRepository $hotelRepository, HotelFilter $hotelFilter)
  {
    $og = OpenGraph::title('sample');

    $hotels = Hotel::with(['city', 'amenities'])->first();
    $topRated = $hotelRepository->topHotels();
    $templateData = [
      'title' => 'same',
      'hotel' => $hotels,
      'topRated' => $topRated,
      'hotelFilter' => $hotelFilter,
      'og' => $og
    ];

    return view('pages.home', $templateData);
  }
}
