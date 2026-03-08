<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ride;
use App\Models\FareEstimate;
use App\Http\Resources\RideResource;

class RideController extends Controller
{
    public function store(Request $request)
    {
        // 1️⃣ Validate request
        $validated = $request->validate([
            'pickup_location' => 'required|string',
            'dropoff_location' => 'required|string',
            'pickup_lat' => 'required|numeric',
            'pickup_lng' => 'required|numeric',
            'dropoff_lat' => 'required|numeric',
            'dropoff_lng' => 'required|numeric',
        ]);

        // 2️⃣ Create ride
            $ride = Ride::create([
    'user_id' => auth()->id(),
    'pickup_location' => $validated['pickup_location'],
    'dropoff_location' => $validated['dropoff_location'],
    'pickup_lat' => $validated['pickup_lat'],
    'pickup_lng' => $validated['pickup_lng'],
    'dropoff_lat' => $validated['dropoff_lat'],
    'dropoff_lng' => $validated['dropoff_lng'],
    'status' => Ride::STATUS_SEARCHING,
]);

        // 3️⃣ Simulate fare estimates
        $providers = [
            ['name' => 'Uber', 'fare' => rand(40, 60), 'eta' => rand(5, 10)],
            ['name' => 'Bolt', 'fare' => rand(35, 55), 'eta' => rand(4, 9)],
            ['name' => 'InDrive', 'fare' => rand(30, 50), 'eta' => rand(6, 12)],
        ];

        foreach ($providers as $provider) {
            FareEstimate::create([
                'ride_id' => $ride->id,
                'provider' => $provider['name'],
                'estimated_fare' => $provider['fare'],
                'estimated_eta' => $provider['eta'],
                'deep_link_url' => 'https://example.com/deeplink',
            ]);
        }

        // ✅ Return ride with sorted estimates
        return new RideResource(
    $ride->load([
        'fareEstimates' => function ($query) {
            $query->orderBy('estimated_fare', 'asc');
        }
    ])
);
    }

    public function index()
    {
        $rides = Ride::where('user_id', auth()->id())
            ->with('fareEstimates')
            ->latest()
            ->get();

        return RideResource::collection($rides);
    }

    public function selectProvider(Request $request, Ride $ride)
{
    // 1️⃣ Check ownership
    if ($ride->user_id !== auth()->id()) {
        return response()->json([
            'message' => 'Unauthorized'
        ], 403);
    }

    // 2️⃣ Validate request
    $validated = $request->validate([
        'provider' => 'required|string',
    ]);

    // 3️⃣ Check if provider exists for this ride
    $estimate = FareEstimate::where('ride_id', $ride->id)
        ->where('provider', $validated['provider'])
        ->first();

    if (!$estimate) {
        return response()->json([
            'message' => 'Invalid provider'
        ], 400);
    }

    // 4️⃣ Update ride
    $ride->update([
        'selected_provider' => $validated['provider'],
        'status' => Ride::STATUS_ACCEPTED,
    ]);

    return new RideResource(
    $ride->load('fareEstimates')
);
}

    public function completeRide(Ride $ride)
{
    if ($ride->user_id !== auth()->id()) {
        return response()->json([
            'message' => 'Unauthorized'
        ], 403);
    }

    if ($ride->status !== Ride::STATUS_ACCEPTED) {
        return response()->json([
            'message' => 'Only accepted rides can be completed'
        ], 400);
    }

    $ride->update([
        'status' => Ride::STATUS_COMPLETED
    ]);

    return new RideResource($ride);
}

    public function cancel(Ride $ride)
{
    // 1️⃣ Check ownership
    if ($ride->user_id !== auth()->id()) {
        return response()->json([
            'message' => 'Unauthorized'
        ], 403);
    }

    // 2️⃣ Prevent cancelling completed rides
    if ($ride->status === Ride::STATUS_COMPLETED) {
        return response()->json([
            'message' => 'Completed rides cannot be cancelled.'
        ], 400);
    }

    // 3️⃣ Update status
    $ride->update([
        'status' => Ride::STATUS_CANCELLED
    ]);

    return new RideResource($ride);
}
}
