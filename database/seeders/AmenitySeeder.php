<?php

namespace Database\Seeders;

use App\Models\Amenity;
use Illuminate\Database\Seeder;

class AmenitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $amenities = [array(1, 'fa fa-home', 'Hotel Rooms'),
            array(2, 'fa fa-male', 'Happy customers every year'),
            array(3, 'fa fa-cutlery', 'Restorans Inside'),
            array(4, 'fa fa-rocket', 'Elevator in building'),
            array(5, 'fa fa-wifi', 'Free Wi Fi'),
            array(6, 'fa fa-motorcycle', 'Free Parking'),
            array(7, 'fa fa-cloud', 'Air Conditioned'),
            array(8, 'fa fa-shopping-cart', 'Online Ordering'),
            array(9, 'fa fa-paw', 'Pet Friendly'),
            array(10, 'fa fa-tree', 'Outdoor Seating'),
            array(11, 'fa fa-wheelchair', 'Wheelchair Friendly')
        ];

        foreach ($amenities as $amenity) {
            $newAmenity = new Amenity();
            $newAmenity->name = $amenity[2];
            $newAmenity->type = 'icon';
            $newAmenity->icon = $amenity[1];
            $newAmenity->save();
        }
    }
}
