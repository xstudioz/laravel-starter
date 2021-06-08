<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookings extends Migration
{
  public function up()
  {
    Schema::create('bookings', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->bigInteger('user_id');
      $table->string('guid');
      $table->string('coupon_code')->nullable();
      $table->float('amount')->default(0);
      $table->float('discount_amount')->default(0);
      $table->float('tax_rate')->nullable();
      $table->float('tax_amount');
      $table->string('payment_mode');
      $table->string('status');
      //
      $table->softDeletes();
      $table->timestamps();
    });

    Schema::create('hotel_bookings', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->integer('user_id');
      $table->integer('booking_id');

      $table->integer('hotel_id');
      $table->integer('hotel_room_id');
      $table->integer('number_of_rooms')->default(1);

      $table->timestamp('check_in');
      $table->timestamp('check_out');
      $table->integer('total_days')->default(1);
      $table->string('room_type');
      $table->float('room_price');
      $table->float('tax_rate')->default(18);
      $table->float('tax_amount')->default(0);

      //
      $table->timestamps();
      $table->softDeletes();
    });

    Schema::create('cab_bookings', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->bigInteger('user_id');
      $table->bigInteger('booking_id');
      //
      $table->bigInteger('cab_id');
      $table->string('trip_type');
      $table->string('number_of_passengers')->default(1);
      $table->string('pickup_location');
      $table->string('drop_location');
      $table->timestamp('pickup_time');
      $table->timestamp('return_pickup_time')->nullable();
      $table->integer('distance');
      $table->integer('days')->default(1);
      $table->string('cab_type')->nullable();
      //cab price details
      $table->float('distance_charge')->nullable();
      $table->float('halting_charge')->nullable();
      $table->float('tax_rate')->default(18);
      $table->float('tax_amount')->nullable();

      //
      $table->softDeletes();
      $table->timestamps();
    });


    Schema::create('transactions', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('trx_id');
      $table->string('gateway');
      $table->bigInteger('user_id');
      $table->bigInteger('booking_id');
      $table->longText('gateway_response')->nullable();
      $table->string('status')->nullable();
      $table->string('hash')->nullable();
      //
      $table->timestamps();
      $table->softDeletes();
    });
  }

  public function down()
  {
    Schema::dropIfExists('bookings');
    Schema::dropIfExists('hotel_bookings');
    Schema::dropIfExists('cab_bookings');
    Schema::dropIfExists('transactions');
  }
}
