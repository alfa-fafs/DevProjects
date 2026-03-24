@extends('layouts.app')

@section('title', 'Ride History')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    :root {
        --green: #39C70D;
        --green-light: #f0fde8;
        --white: #ffffff;
        --gray-bg: #f2f2f2;
        --gray-border: #e8e8e8;
        --black: #0a0a0a;
        --text-muted: #888;
    }
    body { font-family: 'DM Sans', sans-serif; background: var(--gray-bg); }
</style>

<div class="max-w-3xl mx-auto px-4 py-8">

    {{-- Header --}}
    <div style="display:flex; align-items:center; justify-content:center; position:relative; margin-bottom:32px;">
        <a href="/" style="
            position:absolute; left:0;
            width:38px; height:38px; border-radius:50%;
            background:white; border:1.5px solid #e8e8e8;
            display:flex; align-items:center; justify-content:center;
            text-decoration:none; transition:border-color 0.2s;"
            onmouseover="this.style.borderColor='#39C70D'"
            onmouseout="this.style.borderColor='#e8e8e8'">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#0a0a0a" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="15 18 9 12 15 6"></polyline>
            </svg>
        </a>
        <h1 style="font-size:20px; font-weight:700; color:#0a0a0a; letter-spacing:-0.3px;">
            Ride History
        </h1>
    </div>

    @if($rides->isEmpty())
        {{-- Empty state --}}
        <div style="background:white; border-radius:20px; padding:48px 24px; text-align:center; box-shadow:0 2px 16px rgba(0,0,0,0.06);">
            <div style="font-size:56px; margin-bottom:16px;">🚕</div>
            <p style="font-size:18px; font-weight:700; color:#0a0a0a; margin-bottom:8px;">No ride comparisons yet</p>
            <p style="font-size:14px; color:#888; margin-bottom:24px;">Compare rides to see your history here</p>
            <a href="/" style="
                display:inline-block;
                background:#39C70D; color:white;
                font-family:'DM Sans',sans-serif;
                font-size:14px; font-weight:600;
                padding:12px 28px; border-radius:100px;
                text-decoration:none;">
                Compare Rides
            </a>
        </div>
    @else
        <div style="display:flex; flex-direction:column; gap:12px;">
            @foreach($rides as $ride)
            <div style="
                background:white;
                border-radius:20px;
                padding:20px 20px 16px;
                box-shadow:0 2px 12px rgba(0,0,0,0.05);
                border:1.5px solid transparent;
                transition:border-color 0.2s, box-shadow 0.2s;"
                onmouseover="this.style.borderColor='#39C70D'; this.style.boxShadow='0 4px 20px rgba(57,199,13,0.1)'"
                onmouseout="this.style.borderColor='transparent'; this.style.boxShadow='0 2px 12px rgba(0,0,0,0.05)'">

                {{-- Top row: date + price --}}
                <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:12px;">
                    <p style="font-size:12px; color:#888; font-weight:500;">
                        {{ $ride->created_at->format('M d, Y • h:i A') }}
                    </p>
                    <p style="font-size:20px; font-weight:800; color:#39C70D; letter-spacing:-0.5px;">
                        GH₵ {{ number_format($ride->price, 2) }}
                    </p>
                </div>

                {{-- Route --}}
                <div style="display:flex; flex-direction:column; gap:4px; margin-bottom:12px;">
                    <div style="display:flex; align-items:center; gap:8px;">
                        <div style="width:10px; height:10px; border-radius:50%; background:#4A80F0; flex-shrink:0;"></div>
                        <p style="font-size:14px; font-weight:600; color:#0a0a0a;">{{ $ride->pickup_address }}</p>
                    </div>
                    <div style="width:1px; height:12px; background:#e8e8e8; margin-left:4px;"></div>
                    <div style="display:flex; align-items:center; gap:8px;">
                        <div style="width:10px; height:10px; border-radius:50%; background:#39C70D; flex-shrink:0;"></div>
                        <p style="font-size:14px; font-weight:600; color:#0a0a0a;">{{ $ride->dropoff_address }}</p>
                    </div>
                </div>

                {{-- Provider + status + rate button --}}
                <div style="display:flex; align-items:center; justify-content:space-between; padding-top:12px; border-top:1px solid #f0f0f0;">
                    <div style="display:flex; align-items:center; gap:8px;">
                        {{-- Provider icon --}}
                        <div style="
                            width:32px; height:32px; border-radius:50%;
                            background:#f5f5f5;
                            display:flex; align-items:center; justify-content:center;
                            font-size:16px;">
                            @if($ride->provider === 'Bolt') ⚡
                            @elseif($ride->provider === 'Uber') 🚗
                            @elseif($ride->provider === 'inDrive' || $ride->provider === 'indrive') 🚙
                            @else 🚕
                            @endif
                        </div>
                        <div>
                            <p style="font-size:13px; font-weight:700; color:#0a0a0a;">{{ $ride->provider }}</p>
                            <p style="font-size:11px; color:#888;">{{ $ride->vehicle_type !== $ride->provider ? $ride->vehicle_type : 'Standard' }}</p>
                        </div>
                        <span style="
                            font-size:10px; font-weight:700;
                            background:#f0fde8; color:#2ea00a;
                            padding:3px 10px; border-radius:100px;
                            margin-left:4px;">
                            {{ ucfirst($ride->booking_status) }}
                        </span>
                    </div>

                    <a href="{{ route('rides.rate', $ride->id) }}"
                       style="
                        display:inline-flex; align-items:center; gap:6px;
                        background:#39C70D; color:white;
                        font-family:'DM Sans',sans-serif;
                        font-size:12px; font-weight:600;
                        padding:8px 14px; border-radius:100px;
                        text-decoration:none;
                        transition:background 0.2s;"
                       onmouseover="this.style.background='#2ea00a'"
                       onmouseout="this.style.background='#39C70D'">
                        ⭐ Rate Ride
                    </a>
                </div>

            </div>
            @endforeach
        </div>
    @endif

</div>
@endsection