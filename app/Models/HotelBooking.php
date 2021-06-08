<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\HotelBooking
 *
 * @property int $id
 * @property int $user_id
 * @property int $booking_id
 * @property int $hotel_id
 * @property int $hotel_room_id
 * @property int $number_of_rooms
 * @property string $check_in
 * @property string $check_out
 * @property int $total_days
 * @property string $room_type
 * @property float $room_price
 * @property float $tax_rate
 * @property float $tax_amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|HotelBooking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HotelBooking newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HotelBooking query()
 * @method static \Illuminate\Database\Eloquent\Builder|HotelBooking whereBookingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HotelBooking whereCheckIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HotelBooking whereCheckOut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HotelBooking whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HotelBooking whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HotelBooking whereHotelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HotelBooking whereHotelRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HotelBooking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HotelBooking whereNumberOfRooms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HotelBooking whereRoomPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HotelBooking whereRoomType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HotelBooking whereTaxAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HotelBooking whereTaxRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HotelBooking whereTotalDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HotelBooking whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HotelBooking whereUserId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Hotel $hotel
 * @method static Builder|HotelBooking booked(\Carbon\Carbon $checkInDate, \Carbon\Carbon $checkOutDate)
 * @property-read \App\Models\Booking $booking
 */
class HotelBooking extends Model
{
  protected $dates = ['check_in', 'check_out'];
  use HasFactory;

  function hotel(): BelongsTo { return $this->belongsTo(Hotel::class); }

  function booking(): BelongsTo { return $this->belongsTo(Booking::class); }

  function scopeBooked(Builder $query, Carbon $checkInDate, Carbon $checkOutDate)
  {
    $query->where(function ($query) use ($checkInDate, $checkOutDate) {
      $query->whereBetween('check_in', [$checkInDate, $checkOutDate]);
      $query->orWhereBetween('check_out', [$checkInDate, $checkOutDate]);
    }); // booked rooms based on dates
    $query->whereHas('booking', function ($query) {
      $query->whereIn('status', ['paid', 'booked']);
    }); //only booked and paid bookings are counted
  }

}
