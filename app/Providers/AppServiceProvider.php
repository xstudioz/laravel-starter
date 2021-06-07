<?php

namespace App\Providers;

use App\Xstudioz\Booking\BookingFromSession;
use App\Xstudioz\Booking\BookingModel;
use App\Xstudioz\CabFilter;
use App\Xstudioz\HotelFilter;
use App\Xstudioz\AppSettings;
use Arcanedev\LaravelSettings\SettingsManager;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    App::singleton(HotelFilter::class, function ($app) {
      return (new HotelFilter())->load();
    });
    App::singleton(CabFilter::class, function ($app) {
      return (new CabFilter())->load();
    });


  }

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
    Schema::defaultStringLength(191);
    SettingsManager::$runsMigrations = false;


  }
}
