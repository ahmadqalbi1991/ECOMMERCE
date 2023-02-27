<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderSession extends Model
{
    use HasFactory;
    protected $table = 'order_sessions';
    protected $fillable = ['user_id', 'cart_items', 'order_status', 'payment_method', 'shipping_details', 'sub_total', 'tax', 'delivery_charges', 'points_earned', 'points_discount', 'promo_code_discount'];

    public function items() {
        return $this->hasMany(OrderItem::class, 'order_id', 'id')->with(['product']);
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
