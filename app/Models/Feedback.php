<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = "feedbacks";
    protected $fillable = ['rating', 'review', 'user_id', 'published'];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
