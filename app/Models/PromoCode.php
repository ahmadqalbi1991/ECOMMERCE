<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    use HasFactory;
    protected $table = 'promo_codes';
    protected $fillable = ['title', 'code', 'validity_from', 'validity_to', 'is_active', 'is_published', 'description', 'consumption', 'for_all_users'];

    public function users() {
        return $this->hasMany(PromoCodeUser::class, 'promo_code_id');
    }
}
