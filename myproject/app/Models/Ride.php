<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ride extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'pickup_location',
        'dropoff_location',
        'pickup_lat',
        'pickup_lng',
        'dropoff_lat',
        'dropoff_lng',
        'provider',
        'estimated_fare',
        'estimated_eta',
        'booking_status',
        'deep_link_url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
