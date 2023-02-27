<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $table = 'profile';

    protected $fillable = [
        'full_name',
        'user_id',
        'contact_number',
        'national_id_card_number',
        'profile_image'
    ];
}
