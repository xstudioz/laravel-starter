<?php

namespace App\Providers;

use App;
use Illuminate\Support\ServiceProvider;
use Razorpay\Api\Api;

class RazorpayProvider extends ServiceProvider
{
  /**
   * Register services.
   */
  public function register()
  {
    App::singleton(Api::class, function ($app) {
      $key = config('razorpay.key');
      $secret = config('razorpay.secret');
      return new Api($key, $secret);
    });
  }

  /**
   * Bootstrap services.
   */
  public function boot()
  {
    //
  }
}
