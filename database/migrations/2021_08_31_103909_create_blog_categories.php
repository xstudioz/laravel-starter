<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogCategories extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug');
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('blog_category', function (Blueprint $table) {
            $table->bigInteger('blog_id');
            $table->bigInteger('category_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
