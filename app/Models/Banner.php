<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'setting_id',
        'title',
        'path',
        'show_on_home',
        'deal_id',
        'content_heading',
        'content',
        'redirect_to_deal',
        'position',
        'home_page_banner',
        'slider_banner'
    ];
}
