<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FareEstimateResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'provider' => $this->provider,
            'estimated_fare' => $this->estimated_fare,
            'estimated_eta' => $this->estimated_eta,
            'deep_link_url' => $this->deep_link_url,
        ];
    }
}
