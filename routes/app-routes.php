<?php

use App\Http\Controllers\Api\CityController;

Route::prefix('app')->group(function () {
  Route::get('cities', CityController::class);
});
