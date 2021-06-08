<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserMeta extends Model
{
  protected $fillable = ['user_id', 'meta_key', 'meta_value'];


  function user(): BelongsTo { return $this->belongsTo(User::class); }

  static function getValue($metaKey, $userId)
  {
    return UserMeta::where(['meta_key' => $metaKey, 'user_id' => $userId])->first('meta_value')->meta_value;
  }
}
