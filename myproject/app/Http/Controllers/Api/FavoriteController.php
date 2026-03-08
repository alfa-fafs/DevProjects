<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Favorite;

class FavoriteController extends Controller
{
    // ✅ Get all user favorites
    public function index()
    {
        $favorites = auth()->user()->favorites()->latest()->get();

        return response()->json([
            'data' => $favorites
        ]);
    }

    // ✅ Store a new favorite
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nickname' => 'required|string|max:255',
            'pickup_location' => 'required|string',
            'dropoff_location' => 'required|string',
            'pickup_lat' => 'required|numeric',
            'pickup_lng' => 'required|numeric',
            'dropoff_lat' => 'required|numeric',
            'dropoff_lng' => 'required|numeric',
        ]);

        $favorite = Favorite::create([
            'user_id' => auth()->id(),
            ...$validated
        ]);

        return response()->json([
            'message' => 'Favorite saved successfully',
            'data' => $favorite
        ], 201);
    }

    // ✅ Delete a favorite
    public function destroy(Favorite $favorite)
    {
        if ($favorite->user_id !== auth()->id()) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }

        $favorite->delete();

        return response()->json([
            'message' => 'Favorite deleted successfully'
        ]);
    }
}