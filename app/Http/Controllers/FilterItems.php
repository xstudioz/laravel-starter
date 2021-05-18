<?php

namespace App\Http\Controllers;

use App\Repositories\AmenityRepository;
use App\Repositories\CityRepository;

class FilterItems extends Controller
{
    public function __invoke($model): array
    {
        $data = [];
        switch ($model) {
            case 'hotel':
                $data = [
                    'amenities' => (new AmenityRepository())->getAmenities(),
                    'cities' => (new CityRepository())->getCities(),
                ];
                break;
        }
        return $data;
    }
}
