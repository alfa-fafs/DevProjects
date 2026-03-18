<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ride;

class RideHistoryController extends Controller
{
    // Save a ride comparison
    public function store(Request $request)
    {
        // Only save if user is logged in
        if (!auth()->check()) {
            return response()->json(['message' => 'unauthenticated'], 401);
        }

        $request->validate([
            'pickup_address'  => 'required|string',
            'dropoff_address' => 'required|string',
            'pickup_lat'      => 'required|numeric',
            'pickup_lng'      => 'required|numeric',
            'dropoff_lat'     => 'required|numeric',
            'dropoff_lng'     => 'required|numeric',
            'provider'        => 'required|string',
            'vehicle_type'    => 'required|string',
            'price'           => 'required|numeric',
        ]);

        $ride = Ride::create([
            'user_id'         => auth()->id(),
            'pickup_address'  => $request->pickup_address,
            'dropoff_address' => $request->dropoff_address,
            'pickup_lat'      => $request->pickup_lat,
            'pickup_lng'      => $request->pickup_lng,
            'dropoff_lat'     => $request->dropoff_lat,
            'dropoff_lng'     => $request->dropoff_lng,
            'provider'        => $request->provider,
            'vehicle_type'    => $request->vehicle_type,
            'price'           => $request->price,
            'booking_status'  => 'compared',
        ]);

        return response()->json(['message' => 'saved', 'ride' => $ride]);
    }

    // Show ride history page
    public function index()
    {
        $rides = Ride::where('user_id', auth()->id())
                     ->latest()
                     ->get();

        return view('history.index', compact('rides'));
    }
}