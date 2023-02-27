<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Setting extends Model
{
    use HasFactory, HasApiTokens;

    protected $table = 'settings';
    protected $fillable = [
        'site_name',
        'default_currency',
        'logo',
        'favicon',
        'allow_brands',
        'facebook_url',
        'instagram_url',
        'twitter_url',
        'linkedin_url',
        'youtube_url',
        'address',
        'ntn_number',
        'about_us',
        'privacy_policy',
        'terms_and_conditions',
        'refund_policy',
        'allow_refund_policy',
        'contact_number',
        'contact_email',
        'dark_mode',
        'about_us',
        'privacy_policy',
        'terms_and_conditions',
        'refund_policy',
        'delivery_charges',
        'delivery_time',
        'allow_billu_points',
        'allow_points',
        'allow_points_on_price',
        'amount_to_be_used_on_points',
        'allow_promo_code'
    ];

     public function banners () {
         return $this->hasMany(Banner::class, 'setting_id');
     }
}
