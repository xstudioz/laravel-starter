<?php


namespace App\Xstudioz;


use App\Xstudioz\Traits\FromArray;
use Carbon\Carbon;
use Session;

class CabFilter
{
  use FromArray;

  private $drop;
  private $pickup;
  private Carbon $pickupTimestamp;
  private Carbon $dropTimestamp;
  private $passengers;
  private $tripType;
  private $distance;
  private $journeyTime;
  private $combo;
  private string $filterKey = 'cab-filter';

  function clear()
  {
    Session::forget($this->filterKey);
  }

  /**
   * @return mixed
   */
  public function getDrop()
  {
    return $this->drop;
  }

  /**
   * @return mixed
   */
  public function getPickup()
  {
    return $this->pickup;
  }

  /**
   * @return Carbon
   */
  public function getPickupTimestamp()
  {
    return $this->pickupTimestamp ?? Carbon::now();
  }

  /**
   * @return Carbon
   */
  public function getDropTimestamp()
  {
    return $this->dropTimestamp ?? Carbon::now();
  }

  /**
   * @return mixed
   */
  public function getPassengers()
  {
    return $this->passengers;
  }

  /**
   * @return mixed
   */
  public function getTripType()
  {
    return $this->tripType;
  }

  /**
   * @return mixed
   */
  public function getDistance()
  {
    return $this->distance;
  }

  /**
   * @return mixed
   */
  public function getJourneyTime()
  {
    return $this->journeyTime;
  }

  /**
   * @return string
   */
  public function getFilterKey(): string
  {
    return $this->filterKey;
  }

  function save()
  {
    session()->put($this->filterKey, $this);
  }

  function load()
  {
    return Session::get($this->filterKey, $this);
  }

  /**
   * @return mixed
   */
  public function isCombo()
  {
    return $this->combo ?? false;
  }

  /**
   * @param Carbon $dropTimestamp
   * @return CabFilter
   */
  public function setDropTimestamp(Carbon $dropTimestamp): CabFilter
  {
    $this->dropTimestamp = $dropTimestamp;
    return $this;
  }

  /**
   * @param Carbon $pickupTimestamp
   * @return CabFilter
   */
  public function setPickupTimestamp(Carbon $pickupTimestamp): CabFilter
  {
    $this->pickupTimestamp = $pickupTimestamp;
    return $this;
  }


}
