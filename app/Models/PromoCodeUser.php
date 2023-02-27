<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoCodeUser extends Model
{
    use HasFactory;

    protected $table = 'promo_codes_users';
    protected $fillable = ['user_id', 'promo_code_id'];
}
