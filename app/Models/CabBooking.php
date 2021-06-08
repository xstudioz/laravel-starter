<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\CabBooking
 *
 * @property int $id
 * @property int $user_id
 * @property int $booking_id
 * @property int $cab_id
 * @property string $trip_type
 * @property string $number_of_passengers
 * @property string $pickup_location
 * @property string $drop_location
 * @property Carbon $pickup_time
 * @property Carbon|null $return_pickup_time
 * @property float $distance
 * @property int $days
 * @property string $cab_type
 * @property float $distance_charge
 * @property float $halting_charge
 * @property float $tax_rate
 * @property float $tax_amount
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CabBooking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CabBooking newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CabBooking query()
 * @method static \Illuminate\Database\Eloquent\Builder|CabBooking whereBookingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CabBooking whereCabId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CabBooking whereCabType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CabBooking whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CabBooking whereDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CabBooking whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CabBooking whereDistance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CabBooking whereDistanceCharge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CabBooking whereDropLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CabBooking whereHaltingCharge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CabBooking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CabBooking whereNumberOfPassengers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CabBooking wherePickupLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CabBooking wherePickupTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CabBooking whereReturnPickupTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CabBooking whereTaxAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CabBooking whereTaxRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CabBooking whereTripType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CabBooking whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CabBooking whereUserId($value)
 * @mixin \Eloquent
 * @property-read mixed $total_distance
 */
class CabBooking extends Model
{
  const ROUND_TRIP = 'round';
  const ONE_WAY = 'single';

  use HasFactory;

  protected $dates = [
    'pickup_time', 'return_pickup_time'
  ];

  protected $appends = ['total_distance', 'total_amount'];

  public function getTotalDistanceAttribute()
  {
    $d = $this->distance;
    $Multiplier = $this->trip_type === self::ROUND_TRIP ? 2 : 1;
    return $Multiplier * $d;
  }

  public function getTotalAmount()
  {
    return ($this->distance_charge * $this->getTotalDistanceAttribute() / 1000) + ($this->halting_charge * $this->days);
  }


}
