<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FareEstimate extends Model
{
    use HasFactory;

    protected $fillable = [
        'ride_id',
        'provider',
        'estimated_fare',
        'estimated_eta',
        'deep_link_url',
    ];

        protected $casts = [
        'estimated_fare' => 'float',
    ];

    public function ride()
    {
        return $this->belongsTo(Ride::class);
    }
}

