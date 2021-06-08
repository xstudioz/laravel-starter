<?php


namespace App\Xstudioz;


use Arcanedev\LaravelSettings\Models\Setting;
use Illuminate\Support\Facades\Facade;

class AppSettings
{
  public $settings;

  public function __construct()
  {
    $this->settings = settings()->all();
  }

  function get($key, $default)
  {
    return $this->settings->{$key} ?? $default;
  }

  function currency()
  {
    return settings()->get('currency', 'INR');
  }

  function taxRate()
  {
    return settings()->get('tax', 18);
  }
}
