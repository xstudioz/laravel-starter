<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Coupon
 *
 * @property int $id
 * @property string $code
 * @property string $type
 * @property float $value
 * @property string|null $settings
 * @property int $user_id
 * @property float $users_per_user
 * @property int $total_uses
 * @property int $total_used
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder|Coupon newModelQuery()
 * @method static Builder|Coupon newQuery()
 * @method static Builder|Coupon query()
 * @method static Builder|Coupon whereCode($value)
 * @method static Builder|Coupon whereCreatedAt($value)
 * @method static Builder|Coupon whereId($value)
 * @method static Builder|Coupon whereSettings($value)
 * @method static Builder|Coupon whereTotalUsed($value)
 * @method static Builder|Coupon whereTotalUses($value)
 * @method static Builder|Coupon whereType($value)
 * @method static Builder|Coupon whereUpdatedAt($value)
 * @method static Builder|Coupon whereUserId($value)
 * @method static Builder|Coupon whereUsersPerUser($value)
 * @method static Builder|Coupon whereValue($value)
 * @mixin \Eloquent
 * @property float $uses_per_user
 * @property \Illuminate\Support\Carbon $valid_from
 * @property \Illuminate\Support\Carbon $valid_to
 * @property int $enabled
 * @method static Builder|Coupon active()
 * @method static Builder|Coupon whereEnabled($value)
 * @method static Builder|Coupon whereUsesPerUser($value)
 * @method static Builder|Coupon whereValidFrom($value)
 * @method static Builder|Coupon whereValidTo($value)
 * @method static \Database\Factories\CouponFactory factory(...$parameters)
 */
class Coupon extends Model
{
  use HasFactory;

  protected $casts = [
    'settings' => 'array'
  ];
  protected $dates = ['valid_from', 'valid_to'];

  function setCodeAttribute($value) { $this->attributes['code'] = strtoupper($value); }

  function scopeActive(Builder $query)
  {
    return $query->where(['enabled' => true]);
  }
}
