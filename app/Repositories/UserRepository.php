<?php


namespace App\Repositories;


use App\Models\Booking;

class UserRepository
{
  function bookings($userId)
  {
    return Booking::with(['cabBooking', 'hotelBooking'])->where(['user_id' => $userId])->get();
  }
}
