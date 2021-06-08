<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * App\Models\Cab
 *
 * @property int $id
 * @property string $name
 * @property float $distance_price
 * @property float $halting_charges
 * @property string $banner
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Cab newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cab newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cab query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cab whereBanner($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cab whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cab whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cab whereDistancePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cab whereHaltingCharges($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cab whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cab whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cab whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $capacity
 * @method static \Illuminate\Database\Eloquent\Builder|Cab whereCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cab front()
 * @property string $slug
 * @property string|null $content
 * @method static \Database\Factories\CabFactory factory(...$parameters)
 * @method static \Illuminate\Database\Query\Builder|Cab onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Cab whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cab whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|Cab withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Cab withoutTrashed()
 */
class Cab extends Model
{
  use HasFactory, SoftDeletes, HasSlug;

  function scopeFront($query) { return $query; }

  public function getSlugOptions(): SlugOptions
  {
    return SlugOptions::create()->saveSlugsTo('slug')->generateSlugsFrom('name');
  }
}
