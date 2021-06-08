<?php

namespace App\View\Components;

use App\Models\Booking;
use Illuminate\View\Component;

class UserBookingCard extends Component
{
  public Booking $booking;

  public function __construct(Booking $booking) { $this->booking = $booking; }

  public function render()
  {
    return view('components.user-booking-card');
  }
}
