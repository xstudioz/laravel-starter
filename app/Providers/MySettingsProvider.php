<?php

namespace App\Providers;

use App\Xstudioz\AppSettings;
use App\Xstudioz\Booking\BookingFromSession;
use App\Xstudioz\Booking\BookingModel;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class MySettingsProvider extends ServiceProvider
{
  /**
   * Register services.
   */
  public function register()
  {
    App::singleton(AppSettings::class, function ($app) {
      return new AppSettings();
    });

  }

  /**
   * Bootstrap services.
   */
  public function boot()
  {
    //start a fresh booking session
  }
}
