<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ride extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_SEARCHING = 'searching';
    public const STATUS_ACCEPTED = 'accepted';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';

    public const STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_SEARCHING,
        self::STATUS_ACCEPTED,
        self::STATUS_COMPLETED,
        self::STATUS_CANCELLED,
    ];

    protected $fillable = [
        'user_id',
        'pickup_location',
        'dropoff_location',
        'pickup_lat',
        'pickup_lng',
        'dropoff_lat',
        'dropoff_lng',
        'status',
        'selected_provider',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fareEstimates()
    {
        return $this->hasMany(FareEstimate::class);
    }
}