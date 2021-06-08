<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('users', function (Blueprint $table) {
      $table->id();
      $table->string('username')->nullable();
      $table->string('email')->unique()->nullable();
      $table->timestamp('email_verified_at')->nullable();
      $table->string('password');
      $table->string('name')->nullable();
      $table->string('phone')->nullable()->unique();
      $table->string('status')->default(true);
      $table->string('otp')->nullable();
      $table->string('profile_image')->nullable();
      $table->rememberToken();
      $table->timestamps();
    });

    Schema::create('user_metas', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('user_id');
      $table->string('meta_key');
      $table->text('meta_value');
      $table->timestamps();

      $table->foreign('user_id')
        ->references('id')
        ->on('users')
        ->cascadeOnDelete();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('users');
  }
}
