<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\CityRepository;

class CityController extends Controller
{
  public function __invoke(CityRepository $cityRepository)
  {
    return $cityRepository->filterCities(request()->input('city'));
  }
}
