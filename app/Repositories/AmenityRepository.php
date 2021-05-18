<?php


namespace App\Repositories;


use App\Models\Amenity;

class AmenityRepository
{
    function getAmenities() { return Amenity::get(); }
}
