<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelRoomsTable extends Migration
{
    public function up()
    {
        Schema::create('hotel_rooms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('hotel_id');
            $table->float('price')->default(0);
            $table->longText('images')->nullable();
            $table->float('number_of_rooms')->default(0);
            $table->unsignedInteger('capacity')->default(0);
            //
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hotel_rooms');
    }
}
