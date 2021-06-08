<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Transaction
 *
 * @property int $id
 * @property string $trx_id
 * @property string $gateway
 * @property int $user_id
 * @property int $booking_id
 * @property string|null $gateway_response
 * @property string|null $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereBookingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereGateway($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereGatewayResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereTrxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereUserId($value)
 * @mixin \Eloquent
 * @property string|null $hash
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereHash($value)
 * @property-read \App\Models\Booking $booking
 */
class Transaction extends Model
{
  use HasFactory;

  protected $casts = [
    'gateway_response' => 'array'
  ];
  protected $fillable = [
    'booking_id', 'trx_id', 'gateway', 'gateway_response', 'status', 'hash', 'user_id'
  ];

  /**
   * Transaction constructor.
   * @param string $trx_id
   * @param string $gateway
   * @param int $user_id
   * @param int $booking_id
   * @param ?string $gateway_response
   * @param string $status
   * @param string $hash
   */

  public function booking(): BelongsTo { return $this->belongsTo(Booking::class); }


}
