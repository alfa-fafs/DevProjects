<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ride extends Model
{
    use HasFactory;

    protected $table = 'rides';

    protected $fillable = [
        'user_id',
        'pickup_address',
        'pickup_lat',
        'pickup_lng',
        'dropoff_address',
        'dropoff_lat',
        'dropoff_lng',
        'provider',
        'vehicle_type',
        'distance_km',
        'duration_minutes',
        'eta',
        'price',
        'booking_status',
        'booking_reference',
        'booked_at',
        'completed_at',
    ];

    protected $casts = [
        'booked_at'    => 'datetime',
        'completed_at' => 'datetime',
        'pickup_lat'   => 'float',
        'pickup_lng'   => 'float',
        'dropoff_lat'  => 'float',
        'dropoff_lng'  => 'float',
    ];

    // A ride belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}