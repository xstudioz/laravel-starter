<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviews extends Migration
{
  public function up()
  {
    Schema::create('reviews', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->unsignedInteger('reviewable_id');
      $table->string('reviewable_type');
      $table->unsignedInteger('user_id');
      $table->longText('review')->nullable();
      $table->string('status')->default('publish');
      //
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('reviews');
  }
}
