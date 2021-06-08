<?php

namespace Database\Seeders;

use App\Models\Cab;
use Illuminate\Database\Seeder;

class CabSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Cab::factory(10)->create();   //
  }
}
