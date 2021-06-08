<?php


namespace App\Xstudioz\Booking;


class TaxCalculator
{
  static function calculate($amount, $taxRate = 18): float
  {
    return round($amount * $taxRate / 100, 2);
  }
}
