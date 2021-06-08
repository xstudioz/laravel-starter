<?php


namespace App\Xstudioz\Cab;


use App\Models\Cab;
use App\Xstudioz\CabFilter;

class CabPriceCalculator
{
  private Cab $cab;
  private CabFilter $cabFilter;
  //
  private int $days;
  private float $baseAmount;
  private float $distanceAmount;

  public function getDays(): int
  {
    return $this->days;
  }


  public function __construct(Cab $cab, CabFilter $cabFilter)
  {
    $this->cab = $cab;
    $this->cabFilter = $cabFilter;
    $this->calculate();
  }

  public function getBaseAmount(): float
  {
    return $this->baseAmount;
  }

  public function getDistanceAmount(): float
  {
    return $this->distanceAmount;
  }

  public function calculate()
  {
    $distanceInKm = round($this->cabFilter->getDistance() / 1000, 2);
    $this->days = $this->isRoundTrip() ? $this->cabFilter->getPickupTimestamp()->diffInDays($this->cabFilter->getDropTimestamp()) + 1 : 1;
    $this->baseAmount = $this->days * $this->cab->halting_charges;
    $this->distanceAmount = $distanceInKm * $this->cab->distance_price * ($this->isRoundTrip() ? 2 : 1);
    return $this->baseAmount + $this->distanceAmount;
  }

  private function isRoundTrip(): bool
  {
    return $this->cabFilter->getTripType() === 'round';
  }


}
