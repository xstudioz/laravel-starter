<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoupons extends Migration
{
  public function up()
  {
    Schema::create('coupons', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('code');
      $table->string('type')->default('amount');
      $table->float('value')->default(0);
      $table->text('settings')->nullable();
      $table->unsignedBigInteger('user_id');
      $table->float('uses_per_user')->default(1);
      $table->unsignedInteger('total_uses')->default(1);
      $table->unsignedInteger('total_used')->default(0);
      $table->timestamp('valid_from');
      $table->timestamp('valid_to');
      $table->boolean('enabled')->default(true);
      //
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('coupons');
  }
}
