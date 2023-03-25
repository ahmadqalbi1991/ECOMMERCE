<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    use HasFactory;

    protected $table = 'deals';
    protected $fillable = ['title', 'description', 'validity_from', 'validity_to'];

    public function products() {
        return $this->hasMany(DealsProduct::class, 'deal_id');
    }

    public function banner() {
        return $this->belongsTo(Banner::class, 'id', 'deal_id');
    }
}
