<?php


namespace App\Repositories;


use App\Models\City;

class CityRepository
{

    public function getCities()
    {
        return City::activeOnly()->get();
    }
}
