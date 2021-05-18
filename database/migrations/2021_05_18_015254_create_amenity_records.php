<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmenityRecords extends Migration
{
    public function up()
    {
        Schema::create('amenity_records', function (Blueprint $table) {
            $table->unsignedInteger('amenity_id');
            $table->unsignedInteger('amenity_records_id');
            $table->string('amenity_records_type');
            //
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('amenity_records');
    }
}
