<?php


namespace App\Repositories;


use App\Models\City;

class CityRepository
{

  public function getCities($limit = 100)
  {
    return City::activeOnly()->limit($limit)->get();
  }

  public function filterCities($search)
  {
    if (empty(trim($search))) {
      return $this->getCities();
    }
    return City::activeOnly()->where('name', 'LIKE', "%$search%")->get();

  }
}
