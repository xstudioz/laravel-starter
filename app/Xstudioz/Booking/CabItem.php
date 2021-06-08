<?php


namespace App\Xstudioz\Booking;


use App\Models\Cab;
use App\Xstudioz\Cab\CabPriceCalculator;
use Carbon\Carbon;

class CabItem
{
  private Cab $cab;
  private string $tripType;
  private float $distance;
  private Carbon $startDateTime;
  private ?Carbon $returnDateTime;
  private ?string $pickupLocation;
  private ?string $dropLocation;
  private int $journeyTime;
  private int $passengers;

  private float $baseAmount = 0;
  private float $distanceAmount = 0;
  private int $days = 1;
  private $distanceMultiplier = 1;

  /**
   * @return Cab
   */
  public function getCab(): Cab
  {
    return $this->cab;
  }

  /**
   * @return string
   */
  public function getTripType(): string
  {
    return $this->tripType;
  }

  /**
   * @return float
   */
  public function getDistance(): float
  {
    return $this->distance;
  }

  /**
   * @return Carbon
   */
  public function getStartDateTime(): Carbon
  {
    return $this->startDateTime;
  }

  /**
   * @return Carbon|mixed|null
   */
  public function getReturnDateTime()
  {
    return $this->returnDateTime;
  }

  /**
   * @return string|null
   */
  public function getPickupLocation(): ?string
  {
    return $this->pickupLocation;
  }

  /**
   * @return string|null
   */
  public function getDropLocation(): ?string
  {
    return $this->dropLocation;
  }

  /**
   * @return int
   */
  public function getJourneyTime(): int
  {
    return $this->journeyTime;
  }

  /**
   * @return int
   */
  public function getDays(): int
  {
    return $this->days;
  }

  /**
   * CabItem constructor.
   */
  public function __construct($pickupLocation, $dropLocation, $cab, $tripType, $distance, Carbon $startDateTime, $journeyTime, $passengers, ?Carbon $returnDateTime = null)
  {
    $this->cab = $cab;
    $this->tripType = $tripType;
    $this->startDateTime = $startDateTime;
    $this->returnDateTime = $returnDateTime;
    $this->distance = $distance;
    $this->pickupLocation = $pickupLocation;
    $this->dropLocation = $dropLocation;
    $this->journeyTime = $journeyTime;
    $this->passengers = $passengers;

    $this->days = $tripType === 'round' ? $startDateTime->diffInDays($returnDateTime) + 1 : 1;

    $this->calculate();

  }

  public function getPrice(): float
  {
    return $this->baseAmount + $this->distanceAmount;
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
    $distanceInKm = round($this->distance / 1000, 2);
    $this->days = $this->isRoundTrip() ? $this->startDateTime->diffInDays($this->returnDateTime) + 1 : 1;
    $this->baseAmount = $this->days * $this->cab->halting_charges;
    $this->distanceAmount = $distanceInKm * $this->cab->distance_price * $this->distanceMultiplier;

    return $this;
  }

  private function isRoundTrip(): bool
  {
    return $this->tripType === 'round';
  }

  /**
   * @return int
   */
  public function getPassengers(): int
  {
    return $this->passengers;
  }

  /**
   * @return int
   */
  public function getDistanceMultiplier(): int
  {
    return $this->tripType == 'single' ? 1 : 2;
  }

}
