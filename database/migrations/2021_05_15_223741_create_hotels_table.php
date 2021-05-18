<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelsTable extends Migration
{
    public function up()
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug');
            $table->longText('content')->nullable();
            $table->longText('policy')->nullable();
            $table->longText('manager_email')->nullable();
            $table->longText('contact_information')->nullable();
            $table->longText('nearby_places')->nullable();
            $table->string('banner')->nullable();
            //boolean
            $table->boolean('available')->default(true);
            $table->boolean('couple_friendly')->default(true);
            //
            $table->bigInteger('city_id')->nullable();
            $table->string('map_location')->nullable();
            $table->string('address')->nullable();
            $table->float('rating')->default(0);
            $table->string('status')->default('publish');
            $table->text('seo')->nullable();
            //
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hotels');
    }
}
