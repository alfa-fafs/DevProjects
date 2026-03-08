<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Ride;

class RideResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'pickup_location' => $this->pickup_location,
            'dropoff_location' => $this->dropoff_location,
            'selected_provider' => $this->selected_provider,
            'status' => $this->statusLabel(),
            'fare_estimates' => FareEstimateResource::collection($this->whenLoaded('fareEstimates')),
            'created_at' => $this->created_at,
        ];
    }

    private function statusLabel()
{
    return match ($this->status) {
        Ride::STATUS_PENDING => 'pending',
        Ride::STATUS_SEARCHING => 'searching',
        Ride::STATUS_ACCEPTED => 'accepted',
        Ride::STATUS_COMPLETED => 'completed',
        Ride::STATUS_CANCELLED => 'cancelled',
        default => 'unknown'
    };
}
}
