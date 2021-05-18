<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * App\Models\Amenity
 *
 * @property int $id
 * @property string $name
 * @property string $icon
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Amenity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Amenity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Amenity query()
 * @method static \Illuminate\Database\Eloquent\Builder|Amenity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Amenity whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Amenity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Amenity whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Amenity whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Amenity whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\HotelRoom[] $hotelRooms
 * @property-read int|null $hotel_rooms_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Hotel[] $hotels
 * @property-read int|null $hotels_count
 */
class Amenity extends Model
{

    public function hotels(): MorphToMany { return $this->morphedByMany(Hotel::class, 'amenity_records'); }

    public function hotelRooms(): MorphToMany { return $this->morphedByMany(HotelRoom::class, 'amenity_records'); }
}
