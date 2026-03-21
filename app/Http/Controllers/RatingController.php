<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
use App\Models\Ride;

class RatingController extends Controller
{
    // Show rating form
    public function create($rideId)
    {
        $ride = Ride::where('id', $rideId)
                    ->where('user_id', auth()->id())
                    ->firstOrFail();

        // Check if already rated
        $existing = Rating::where('ride_id', $rideId)
                          ->where('user_id', auth()->id())
                          ->first();

        return view('rating.create', compact('ride', 'existing'));
    }

    // Save rating
    public function store(Request $request, $rideId)
    {
        $request->validate([
            'stars'   => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        $ride = Ride::where('id', $rideId)
                    ->where('user_id', auth()->id())
                    ->firstOrFail();

        Rating::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'ride_id' => $rideId,
            ],
            [
                'stars'    => $request->stars,
                'comment'  => $request->comment,
                'provider' => $ride->provider,
            ]
        );

        return redirect()->route('history.index')
                         ->with('success', 'Thanks for your feedback!');
    }
}