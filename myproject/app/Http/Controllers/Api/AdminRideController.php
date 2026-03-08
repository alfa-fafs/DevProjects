<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ride;
use Illuminate\Http\Request;

class AdminRideController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'status' => 'nullable|in:searching,completed,cancelled'
        ]);

        $query = Ride::with('user')->latest();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $rides = $query->paginate(10);

        return response()->json($rides);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:searching,completed,cancelled'
        ]);

        $ride = Ride::findOrFail($id);

        $ride->status = $request->status;
        $ride->save();

        return response()->json([
            'message' => 'Ride status updated successfully 🔥',
            'ride' => $ride
        ]);
    }
}