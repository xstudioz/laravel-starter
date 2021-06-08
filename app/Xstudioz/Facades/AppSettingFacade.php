<?php


namespace App\Xstudioz\Facades;


use App\Xstudioz\AppSettings;
use Barryvdh\Debugbar\Facade;

class AppSettingFacade extends Facade
{
  protected static function getFacadeAccessor(): string { return AppSettings::class; }


}
