<?php

namespace Database\Factories;

use App\Models\Coupon;
use Arr;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Str;

class CouponFactory extends Factory
{
  protected $model = Coupon::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'code' => Str::random(10),
      'type' => Arr::random(['amount', 'percent']),
      'value' => $this->faker->randomFloat(),
      'settings' => $this->faker->word,
      'user_id' => $this->faker->randomNumber(),
      'users_per_user' => $this->faker->randomFloat(),
      'total_uses' => $this->faker->randomNumber(),
      'total_used' => $this->faker->randomNumber(),
      'created_at' => Carbon::now(),
      'updated_at' => Carbon::now(),
      'uses_per_user' => $this->faker->randomFloat(),
      'valid_from' => Carbon::now(),
      'valid_to' => Carbon::now(),
      'enabled' => $this->faker->randomNumber(),
    ];
  }
}
