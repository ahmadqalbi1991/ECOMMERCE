<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealsProduct extends Model
{
    use HasFactory;
    protected $table = 'deals_products';
    protected $fillable = ['deal_id', 'product_id'];

    public function detail() {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
