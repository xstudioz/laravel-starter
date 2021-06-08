<?php


namespace App\Xstudioz\Booking;


class BookingFromSession
{


  static public function getBooking(): BookingModel
  {
    return session()->get('booking') ?? new BookingModel();
  }

  static public function save(BookingModel $bookingModel): BookingModel
  {
    $bookingModel->finalizeCalculations();
    session()->put('booking', $bookingModel);
    return $bookingModel;
  }

  public static function clear()
  {
    session()->forget('booking');
  }

}
