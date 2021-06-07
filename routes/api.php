<?php

use App\Http\Controllers\BackendLoginController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\FilterItems;
use App\Http\Controllers\Front\BookingController;
use App\Http\Controllers\Front\LoginController;
use App\Http\Controllers\SettingController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
  return $request->user();
});

@include_once 'app-routes.php';
Route::group(['prefix' => 'backend'], function () {
  Route::post('login', [BackendLoginController::class, 'login']);
  Route::post('logout', [BackendLoginController::class, 'logout']);
  Route::get('list-items/{type}', FilterItems::class);

  Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('settings', SettingController::class);
    //
    Route::post('city/index', [App\Http\Controllers\CityController::class, 'index']);
    Route::post('city/create', [App\Http\Controllers\CityController::class, 'create']);
    Route::post('city/destroy', [App\Http\Controllers\CityController::class, 'destroy']);
    Route::post('hotel/index', [App\Http\Controllers\HotelController::class, 'index']);
    Route::post('hotel/create', [App\Http\Controllers\HotelController::class, 'create']);
    Route::post('hotel/destroy', [App\Http\Controllers\HotelController::class, 'destroy']);
    Route::post('amenity/index', [App\Http\Controllers\AmenityController::class, 'index']);
    Route::post('amenity/create', [App\Http\Controllers\AmenityController::class, 'create']);
    Route::post('amenity/destroy', [App\Http\Controllers\AmenityController::class, 'destroy']);
    Route::post('user/index', [App\Http\Controllers\UserController::class, 'index']);
    Route::post('user/create', [App\Http\Controllers\UserController::class, 'create']);
    Route::post('user/destroy', [App\Http\Controllers\UserController::class, 'destroy']);
    Route::post('room/index', [App\Http\Controllers\RoomController::class, 'index']);
    Route::post('room/create', [App\Http\Controllers\RoomController::class, 'create']);
    Route::post('room/destroy', [App\Http\Controllers\RoomController::class, 'destroy']);
    Route::post('hotel-room/index', [App\Http\Controllers\HotelRoomController::class, 'index']);
    Route::post('hotel-room/create', [App\Http\Controllers\HotelRoomController::class, 'create']);
    Route::post('hotel-room/destroy', [App\Http\Controllers\HotelRoomController::class, 'destroy']);
    Route::post('hotel-booking/index', [App\Http\Controllers\HotelBookingController::class, 'index']);
    Route::post('hotel-booking/create', [App\Http\Controllers\HotelBookingController::class, 'create']);
    Route::post('hotel-booking/destroy', [App\Http\Controllers\HotelBookingController::class, 'destroy']);
    Route::post('transaction/index', [App\Http\Controllers\TransactionController::class, 'index']);
    Route::post('transaction/create', [App\Http\Controllers\TransactionController::class, 'create']);
    Route::post('transaction/destroy', [App\Http\Controllers\TransactionController::class, 'destroy']);
    Route::post('cab-booking/index', [App\Http\Controllers\CabBookingController::class, 'index']);
    Route::post('cab-booking/create', [App\Http\Controllers\CabBookingController::class, 'create']);
    Route::post('cab-booking/destroy', [App\Http\Controllers\CabBookingController::class, 'destroy']);
    Route::post('coupon/index', [App\Http\Controllers\CouponController::class, 'index']);
    Route::post('coupon/create', [App\Http\Controllers\CouponController::class, 'create']);
    Route::post('coupon/destroy', [App\Http\Controllers\CouponController::class, 'destroy']);
    Route::post('cab/index', [App\Http\Controllers\CabController::class, 'index']);
    Route::post('cab/create', [App\Http\Controllers\CabController::class, 'create']);
    Route::post('cab/destroy', [App\Http\Controllers\CabController::class, 'destroy']);
    Route::post('page/index', [App\Http\Controllers\PageController::class, 'index']);
    Route::post('page/create', [App\Http\Controllers\PageController::class, 'create']);
    Route::post('page/destroy', [App\Http\Controllers\PageController::class, 'destroy']);
//admin

  });
});
Route::post('upload/{type?}', FileUploadController::class)->name('upload');
Route::post('booking/calculate', [BookingController::class, 'calculate'])->name('booking.calculate.api');
