<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'deep_link_url',
        'api_available',
        'is_active',
        'base_fare',
        'per_km_rate',
        'per_minute_rate',
    ];
}