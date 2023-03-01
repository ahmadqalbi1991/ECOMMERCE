<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['category', 'parent_id', 'is_active', 'slug', 'image', 'is_nav', 'level'];

    public function parent_category () {
        return $this->belongsTo(Category::class, 'id', 'parent_id');
    }

    public function sub_categories () {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products () {
        return $this->hasMany(Product::class, 'category_id');
    }
}
