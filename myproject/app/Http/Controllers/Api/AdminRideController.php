<?php

namespace App\Http\Controllers\Api;

// This controller handles admin-specific actions related to rides, such as listing all rides with optional status filtering, updating ride status, and viewing ride details. It uses the AdminMiddleware to ensure that only authenticated admin users can access these routes.
use App\Http\Controllers\Controller;
use App\Models\Ride;
use Illuminate\Http\Request;

// This controller handles admin-specific actions related to rides, such as listing all rides with optional status filtering, updating ride status, and viewing ride details. It uses the AdminMiddleware to ensure that only authenticated admin users can access these routes.
class AdminRideController extends Controller
{
    // Admin route to list all rides with optional status filter
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

     // Admin route to view ride details
    public function show($id)
{
    $ride = Ride::with(['user', 'fareEstimates'])->findOrFail($id);

    return response()->json([
        'ride' => $ride
    ]);
}

    // Admin route to update ride status
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