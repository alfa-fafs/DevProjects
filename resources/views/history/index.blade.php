@extends('layouts.app')

@section('title', 'Ride History')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">🕘 Your Ride History</h1>

    @if($rides->isEmpty())
        <div class="bg-white rounded-xl shadow p-8 text-center text-gray-500">
            <div class="text-5xl mb-4">🚕</div>
            <p class="text-lg font-medium">No ride comparisons yet</p>
            <p class="text-sm mt-1">Compare rides to see your history here</p>
            <a href="/" class="mt-4 inline-block bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
                Compare Rides
            </a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($rides as $ride)
            <div class="bg-white rounded-xl shadow p-4">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-gray-500">{{ $ride->created_at->format('M d, Y • h:i A') }}</p>
                        <p class="font-medium text-gray-800 mt-1">
                            📍 {{ $ride->pickup_address }}
                        </p>
                        <p class="font-medium text-gray-800">
                            🎯 {{ $ride->dropoff_address }}
                        </p>
                        <p class="text-sm text-gray-600 mt-1">
                            {{ $ride->provider }} — {{ $ride->vehicle_type }}
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="text-xl font-bold text-green-600">
                            GH₵ {{ number_format($ride->price, 2) }}
                        </p>
                        <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-full">
                            {{ ucfirst($ride->booking_status) }}
                        </span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection