<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointsHistory extends Model
{
    use HasFactory;
    protected $table = 'points_history';
    protected $fillable = ['user_id', 'points', 'action', 'order_session_id'];
}
