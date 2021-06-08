<?php

namespace App\Http\Controllers;

use App\Xstudioz\ResponseHelper;
use Auth;
use Illuminate\Validation\UnauthorizedException;

class SettingController extends Controller
{
  public function __invoke()
  {
    if (!Auth::user()->hasPermissionTo('settings:save')) {
      throw new UnauthorizedException();
    }

    $settings = request()->all();
    settings()->set($settings)->save();
    return ResponseHelper::success("Settings Saved");
  }
}
