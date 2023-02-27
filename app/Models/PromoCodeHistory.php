<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoCodeHistory extends Model
{
    use HasFactory;
    protected $table = 'promo_codes_usage_history';
    protected $fillable = ['user_id', 'promo_code_id', 'order_id', 'promo_code_discount'];
}
