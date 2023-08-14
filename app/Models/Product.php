<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_title',
        'sku_code',
        'product_type',
        'price',
        'cost_price',
        'short_description',
        'long_description',
        'allergy_info',
        'storage_info',
        'category_id',
        'brand_id',
        'slug',
        'apply_discount',
        'discount_type',
        'discount_value',
        'unit_id',
        'unit_value',
        'quantity',
        'allow_add_to_cart_when_out_of_stock',
        'default_image',
        'is_active',
        'is_everyday_essential'
    ];

    public function category () {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function brand () {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function unit () {
        return $this->belongsTo(ProductUnit::class, 'unit_id');
    }

    public function images() {
        return $this->hasMany(ProductImage::class, 'product_id');
    }
}
