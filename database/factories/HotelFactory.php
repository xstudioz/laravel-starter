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
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'content' => $this->faker->paragraphs(4, true),
            'banner' => Arr::random([
                "public/misc/elwpQsBOAYOvP5nxENXSd8qIqUEcFJKh88JI00Zx.jpg",
                "public/misc/pLFHBIPtsoHTIWGOiryQ9ji5xAz1MugnXyb35GwR.jpg",
                "public/misc/EmCaMQgLpudUNp1oEoWTshjWK2Vjn2j5WddH1NuV.jpg"
            ]),
            'available' => rand(0, 1),
            'couple_friendly' => rand(0, 1),
            'map_location' => $this->faker->word,
            'address' => $this->faker->address,
            'rating' => 1,
            'status' => $this->faker->word,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'policy' => $this->faker->paragraphs(4, true),
            'nearby_places' => $this->faker->word,
            'manager_email' => $this->faker->unique()->safeEmail,
            'contact_information' => $this->faker->word,
            'seo' => $this->faker->words(),
            'city_id' => (City::query())->inRandomOrder()->first()->id
        ];
    }
}
