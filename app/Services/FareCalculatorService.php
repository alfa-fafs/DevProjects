<?php

namespace App\Services;

class FareCalculatorService
{
    /**
     * Calculate fares for all providers given distance and duration.
     *
     * @param  float  $distanceKm
     * @param  float  $durationMin
     * @return array
     */
    public function calculate(float $distanceKm, float $durationMin): array
    {
        $providers = config('ride_providers.providers');
        $fares     = [];

        foreach ($providers as $provider) {
            $fare = $provider['base_fare']
                  + ($provider['per_km']  * $distanceKm)
                  + ($provider['per_min'] * $durationMin);

            $fares[] = [
                'name'     => $provider['name'],
                'type'     => $provider['type'],
                'logo'     => $provider['logo'],
                'color'    => $provider['color'],
                'currency' => $provider['currency'],
                'fare'     => round($fare, 2),
            ];
        }

        // Sort cheapest first
        usort($fares, fn($a, $b) => $a['fare'] <=> $b['fare']);

        // Tag the cheapest and most expensive
        $fares[0]['badge']                       = 'CHEAPEST';
        $fares[count($fares) - 1]['badge_last']  = 'MOST EXPENSIVE';

        return $fares;
    }
}