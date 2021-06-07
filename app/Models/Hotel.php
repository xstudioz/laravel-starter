<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * App\Models\Hotel
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $content
 * @property string|null $banner
 * @property int $available
 * @property int $couple_friendly
 * @property int|null $city_id
 * @property string|null $map_location
 * @property string|null $address
 * @property float $rating
 * @property string $status
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Hotel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Hotel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Hotel query()
 * @method static \Illuminate\Database\Eloquent\Builder|Hotel whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hotel whereAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hotel whereBanner($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hotel whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hotel whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hotel whereCoupleFriendly($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hotel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hotel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hotel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hotel whereMapLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hotel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hotel whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hotel whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hotel whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hotel whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\City|null $city
 * @method static \Illuminate\Database\Query\Builder|Hotel onlyTrashed()
 * @method static \Illuminate\Database\Query\Builder|Hotel withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Hotel withoutTrashed()
 * @property string|null $policy
 * @property string|null $nearby_places
 * @method static \Illuminate\Database\Eloquent\Builder|Hotel whereNearbyPlaces($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hotel wherePolicy($value)
 * @property string|null $manager_email
 * @property string|null $contact_information
 * @method static \Illuminate\Database\Eloquent\Builder|Hotel whereContactInformation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hotel whereManagerEmail($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Amenity[] $amenities
 * @property-read int|null $amenities_count
 * @property array|null $seo
 * @method static \Illuminate\Database\Eloquent\Builder|Hotel whereSeo($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\HotelRoom[] $rooms
 * @property-read int|null $rooms_count
 * @method static \Database\Factories\HotelFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Hotel front()
 * @property-read mixed $web_link
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\HotelBooking[] $hotelBookings
 * @property-read int|null $hotel_bookings_count
 */
class Hotel extends Model
{
  use SoftDeletes, HasSlug, HasFactory;

  protected $casts = [
    'available' => 'boolean',
    'couple_friendly' => 'boolean',
    'map_location' => 'array',
    'nearby_places' => 'array',
    'seo' => 'array'
  ];

  protected $appends = [
    'web_link'
  ];

  public function getSlugOptions(): SlugOptions { return SlugOptions::create()->generateSlugsFrom('name')->saveSlugsTo('slug'); }

  public function city(): BelongsTo { return $this->belongsTo(City::class); }

  public function amenities(): MorphToMany { return $this->morphToMany(Amenity::class, 'amenity_records'); }

  public function hotelBookings(): HasMany { return $this->hasMany(HotelBooking::class); }

  public function rooms(): HasMany { return $this->hasMany(HotelRoom::class); }

  public function scopeFront($query) { return $query->with(['city']); }

  public function getWebLinkAttribute() { return route('hotel.single', ['city' => $this->city->slug, 'hotel' => $this->slug]); }

  // extra function
  public function getRoomImages(): array
  {
    $images = [];
    foreach ($this->rooms as $room) {
      $images = [...$images, ...$room->images];
    }
    return $images;
  }

}
