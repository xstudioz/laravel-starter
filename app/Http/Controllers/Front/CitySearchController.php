<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Repositories\CityRepository;

class CitySearchController extends Controller
{
  public function __invoke(CityRepository $cityRepository)
  {
    return $cityRepository->filterCities(request()->city);
  }
}
