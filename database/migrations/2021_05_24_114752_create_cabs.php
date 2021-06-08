<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCabs extends Migration
{
  public function up()
  {
    Schema::create('cabs', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('name');
      $table->string('slug');
      $table->longText('content')->nullable();
      $table->float('distance_price');
      $table->float('halting_charges');
      $table->string('banner')->nullable();
      $table->unsignedInteger('capacity')->default(1);
      //
      $table->timestamps();
      $table->softDeletes();
    });
  }

  public function down()
  {
    Schema::dropIfExists('cabs');
  }
}
