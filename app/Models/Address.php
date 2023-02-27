<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $table = 'user_address';
    protected $fillable = ['user_id', 'address', 'city_id', 'active', 'receiver_name', 'contact_number', 'delivery_instruction', 'city_obj', 'labels'];
}
