<?php

use App\Http\Controllers\BackendLoginController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\FilterItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::group(['prefix' => 'backend'], function () {
    Route::post('login', BackendLoginController::class);
    Route::get('list-items/{type}', FilterItems::class);

    Route::middleware(['auth:sanctum'])->group(function () {
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
Route::post('hotel-booking/index',[App\Http\Controllers\HotelBookingController::class,'index']);
Route::post('hotel-booking/create',[App\Http\Controllers\HotelBookingController::class,'create']);
Route::post('hotel-booking/destroy',[App\Http\Controllers\HotelBookingController::class,'destroy']);
Route::post('transaction/index',[App\Http\Controllers\TransactionController::class,'index']);
Route::post('transaction/create',[App\Http\Controllers\TransactionController::class,'create']);
Route::post('transaction/destroy',[App\Http\Controllers\TransactionController::class,'destroy']);
Route::post('cab-booking/index',[App\Http\Controllers\CabBookingController::class,'index']);
Route::post('cab-booking/create',[App\Http\Controllers\CabBookingController::class,'create']);
Route::post('cab-booking/destroy',[App\Http\Controllers\CabBookingController::class,'destroy']);
//admin

    });
});
Route::post('upload', FileUploadController::class);
