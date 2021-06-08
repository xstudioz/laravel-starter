<?php

namespace App\Http\Controllers;

use App\Xstudioz\Booking\BookingFromSession;
use Faker\Provider\Uuid;
use Razorpay\Api\Api;

class PaymentController extends Controller
{
  public function __invoke(Api $api)
  {
    $booking = BookingFromSession::getBooking();
    $prices = $booking->finalizeCalculations();
    $payload = [
      'receipt' => Uuid::uuid(),
      'currency' => 'INR',
      'amount' => $prices['finalAmount'] * 100
    ];
    $x = $api->order->create($payload);
    session()->put('ap', $x);
  }
}
