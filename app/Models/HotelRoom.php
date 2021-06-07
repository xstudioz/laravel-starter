<?php

namespace App\Models;

use Arr;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * App\Models\HotelRoom
 *
 * @property int $id
 * @property string $name
 * @property string $hotel_id
 * @property float $price
 * @property float $number_of_rooms
 * @property int $capacity
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|HotelRoom newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HotelRoom newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HotelRoom query()
 * @method static \Illuminate\Database\Eloquent\Builder|HotelRoom whereCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HotelRoom whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HotelRoom whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HotelRoom whereHotelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HotelRoom whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HotelRoom whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HotelRoom whereNumberOfRooms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HotelRoom wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HotelRoom whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property array|null $images
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Amenity[] $amenities
 * @property-read int|null $amenities_count
 * @method static \Illuminate\Database\Eloquent\Builder|HotelRoom whereImages($value)
 * @property-read \App\Models\Hotel $hotel
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\HotelBooking[] $hotelBookings
 * @property-read int|null $hotel_bookings_count
 */
class HotelRoom extends Model
{
  use HasFactory;

  protected $fillable = ['name', 'capacity', 'hotel_id', 'number_of_rooms', 'price', 'images'];

  protected $casts = [
    'images' => 'array'
  ];

  public function amenities(): MorphToMany { return $this->morphToMany(Amenity::class, 'amenity_records'); }

  public function hotel(): BelongsTo { return $this->belongsTo(Hotel::class); }

  public function hotelBookings(): HasMany { return $this->hasMany(HotelBooking::class); }

  public function roomImages($w, $h = 0): array
  {
    return array_map(function ($i) use ($w, $h) {
      return resizeImage($i, $w, $h);
    }, $this->images);
  }

}
