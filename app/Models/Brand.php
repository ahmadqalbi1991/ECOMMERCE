<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'image', 'slug'];

    public function products () {
        return $this->hasMany(Product::class, 'brand_id');
    }
}
