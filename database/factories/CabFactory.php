<?php

namespace Database\Factories;

use App\Models\Cab;
use Arr;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CabFactory extends Factory
{
  protected $model = Cab::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'name' => Arr::random(['Innova', 'Maruti', 'Traveller', 'Truck', 'Thar', 'Jeep']),
      'distance_price' => $this->faker->randomFloat(0, 10, 15),
      'halting_charges' => 100,
      'content' => $this->faker->paragraphs(5, true),
      'banner' => Arr::random([
        "public/misc/elwpQsBOAYOvP5nxENXSd8qIqUEcFJKh88JI00Zx.jpg",
        "public/misc/pLFHBIPtsoHTIWGOiryQ9ji5xAz1MugnXyb35GwR.jpg",
        "public/misc/EmCaMQgLpudUNp1oEoWTshjWK2Vjn2j5WddH1NuV.jpg"
      ]),
      'created_at' => Carbon::now(),
      'updated_at' => Carbon::now(),
      'capacity' => rand(1, 10)
    ];
  }
}
