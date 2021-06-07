<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

class HotelFactory extends Factory
{
  protected $model = Hotel::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition(): array
  {

    $nearByPlaces = [];
    for ($i = 0; $i < 6; $i++) {
      $nearByPlaces[] = ['name' => $this->faker->name, 'distance' => rand(10, 20), 'detail' => null];
    }

    return [
      'name' => $this->faker->name,
      'content' => $this->faker->paragraphs(4, true),
      'policy' => $this->faker->paragraphs(4, true),
      'manager_email' => $this->faker->unique()->safeEmail,
      'contact_information' => $this->faker->word,
      'nearby_places' => $nearByPlaces,
      'banner' => Arr::random([
        "public/misc/elwpQsBOAYOvP5nxENXSd8qIqUEcFJKh88JI00Zx.jpg",
        "public/misc/pLFHBIPtsoHTIWGOiryQ9ji5xAz1MugnXyb35GwR.jpg",
        "public/misc/EmCaMQgLpudUNp1oEoWTshjWK2Vjn2j5WddH1NuV.jpg"
      ]),
      'available' => true,
      'couple_friendly' => true,
      'city_id' => (City::query())->inRandomOrder()->first()->id,
      'map_location' => ['lat' => $this->faker->latitude, 'lng' => $this->faker->longitude],
      'address' => $this->faker->address,
      'rating' => 1,
      'status' => $this->faker->word,
      'deleted_at' => null,
      'created_at' => Carbon::now(),
      'updated_at' => Carbon::now(),
    ];
  }
}
