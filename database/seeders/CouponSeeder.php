<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CouponSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $c = new Coupon();
    $c->type = 'AMOUNT';
    $c->code = Str::random(6);
    $c->value = 100;
    $c->user_id = 1;
    $c->enabled = true;
    $c->valid_from = Carbon::now();
    $c->valid_to = Carbon::now()->addMonth();
    $c->save();

    $c = new Coupon();
    $c->type = 'PERCENT';
    $c->code = Str::random(6);
    $c->value = 10;
    $c->user_id = 1;
    $c->enabled = true;
    $c->valid_from = Carbon::now();
    $c->valid_to = Carbon::now()->addMonth();
    $c->save();
  }
}
