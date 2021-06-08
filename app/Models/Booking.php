<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Booking
 *
 * @property int $id
 * @property int $user_id
 * @property string $guid
 * @property string|null $coupon_code
 * @property float $discount_amount
 * @property string $payment_mode
 * @property string $status
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Booking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Booking newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Booking query()
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereCouponCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereDiscountAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereGuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking wherePaymentMode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereUserId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\CabBooking|null $cabBooking
 * @property-read \App\Models\HotelBooking|null $hotelBooking
 * @property float $amount
 * @property float|null $tax_rate
 * @property float $tax_amount
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereTaxAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereTaxRate($value)
 * @property-read mixed $final_price
 * @property-read int|null $hotel_booking_count
 */
class Booking extends Model
{
  protected $appends = ['finalPrice'];
  use HasFactory;

  public function createTransaction($userId, $trxId, $status, $gateway, $gatewayResponse, $hash)
  {
    return Transaction::create([
      'booking_id' => $this->id,
      'trx_id' => $trxId,
      'user_id' => $userId,
      'gateway' => $gateway,
      'gateway_response' => $gatewayResponse,
      'status' => strtolower($status),
      'hash' => $hash
    ]);
  }

  public function confirmed(): bool
  {
    return in_array($this->status, ['paid', 'booked']);
  }

  public function cabBooking(): HasOne { return $this->hasOne(CabBooking::class); }

  public function hotelBooking(): HasMany { return $this->hasMany(HotelBooking::class); }

  public function getFinalPriceAttribute() { return $this->amount - $this->discount_amount + $this->tax_amount; }

  public function getHotelTotal()
  {
    $total = 0;
    $this->hotelBooking->each(function ($r) use (&$total) {
      $total += $r->room_price;
    });
    return $total;
  }
}
