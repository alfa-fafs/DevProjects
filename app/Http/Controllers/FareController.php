<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FareCalculatorService;

class FareController extends Controller
{
    public function calculate(Request $request, FareCalculatorService $calculator)
    {
        $request->validate([
            'distance_km'  => 'required|numeric|min:0',
            'duration_min' => 'required|numeric|min:0',
        ]);

        $fares = $calculator->calculate(
            (float) $request->distance_km,
            (float) $request->duration_min
        );

        // Calculate best deal savings vs most expensive
        $maxFare  = max(array_column($fares, 'fare'));
        $minFare  = $fares[0]['fare'];
        $savings  = round($maxFare - $minFare, 2);
        $savingsPct = round((($maxFare - $minFare) / $maxFare) * 100);

        return response()->json([
            'fares'        => $fares,
            'best_savings' => $savings,
            'savings_pct'  => $savingsPct,
            'provider'     => $fares[0]['name'],
        ]);
    }
}