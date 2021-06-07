<?php

namespace Database\Seeders;

use App\Models\Amenity;
use App\Models\Hotel;
use App\Models\HotelRoom;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class HotelSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    \App\Models\Hotel::factory(50)->create()->each(function (Hotel $hotel) {

      $hotel->amenities()->sync(Amenity::inRandomOrder()->get()->pluck(['id']));

      for ($i = 0; $i < 3; $i++) {
        $r = new HotelRoom();
        $r->name = Arr::random(['Dulux', 'Corporate Suite', 'Economy']);
        $r->hotel_id = $hotel->id;
        $r->capacity = 2;
        $r->price = 1000;
        $r->number_of_rooms = 50;
        $r->images = [
          "public/misc/elwpQsBOAYOvP5nxENXSd8qIqUEcFJKh88JI00Zx.jpg",
          "public/misc/pLFHBIPtsoHTIWGOiryQ9ji5xAz1MugnXyb35GwR.jpg",
          "public/misc/EmCaMQgLpudUNp1oEoWTshjWK2Vjn2j5WddH1NuV.jpg"
        ];
        $r->save();
        $r->amenities()->sync(Amenity::inRandomOrder()->get()->pluck(['id']));
      }
    });
  }
}
