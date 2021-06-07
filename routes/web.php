<?php

use App\Http\Controllers\Front\BookingController;
use App\Http\Controllers\Front\CabPageController;
use App\Http\Controllers\Front\CitySearchController;
use App\Http\Controllers\Front\HomePageController;
use App\Http\Controllers\Front\HotelBookingController;
use App\Http\Controllers\Front\HotelSearchController;
use App\Http\Controllers\Front\LoginController;
use App\Http\Controllers\Front\MyAccountController;
use App\Http\Controllers\Front\SampleController;
use App\Http\Middleware\CheckProfile;
use App\Models\Hotel;
use App\Models\HotelBooking;
use App\Models\HotelRoom;
use App\Xstudioz\Facades\AppSettingFacade;
use App\Xstudioz\HotelFilter;
use Arcanedev\LaravelSettings\Models\Setting;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('login', function () { })->name('login');
Route::match(['get', 'post'], 'cab-booking', [CabPageController::class, 'index'])->name('booking.cab');
Route::match(['get', 'post'], 'cabs/search', [CabPageController::class, 'search'])->name('booking.cab.search');
Route::get('cab/book/{slug}', [CabPageController::class, 'book'])->name('booking.cab.book');

Route::post('login/send-otp', [LoginController::class, 'sendOtp'])->name('login.otp');
Route::post('login/verify-otp', [LoginController::class, 'verifyOtp'])->name('login.verify-otp');

Route::match(['get', 'post'], '/', HomePageController::class)->name('home');
Route::get('/cities', CitySearchController::class);
Route::get('/hotels-in-{city}', HotelSearchController::class)->name('hotel.search'); //
Route::get('/hotels-in-{city}/{hotel}', HotelBookingController::class)->name('hotel.single'); //
Route::get('/page/{slug}', HotelBookingController::class)->name('pages'); //

Route::middleware('auth:web')->group(function () {
  Route::post('booking/create', [BookingController::class, 'create'])->name('booking.create');
  Route::get('my-account', [MyAccountController::class, 'editProfile'])->name('account.edit')->withoutMiddleware([CheckProfile::class]);
  Route::post('my-account', [MyAccountController::class, 'updateProfile'])->name('account.update')->withoutMiddleware([CheckProfile::class]);


  Route::get('my-account/bookings', [MyAccountController::class, 'bookings'])->name('account.bookings');
  Route::get('my-account/bookings/{guid}', [MyAccountController::class, 'viewBooking'])->name('booking.view');
  Route::get('my-account/reviews', [MyAccountController::class, 'reviews'])->name('account.reviews');
  Route::get('my-account/logout', [MyAccountController::class, 'logout'])->name('account.logout')->withoutMiddleware([CheckProfile::class]);
});

Route::post('booking/calculate', [BookingController::class, 'calculate'])->name('booking.calculate.web');
Route::get('booking/review', [BookingController::class, 'review'])->name('booking.review');
Route::post('booking/apply-coupon', [BookingController::class, 'applyCoupon'])->name('booking.coupon.web');
Route::match(['get', 'post'], 'booking/payment-callback/{guid?}', [BookingController::class, 'paymentCallback'])->name('booking.payment.callback');
