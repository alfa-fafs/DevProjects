@extends('layouts.app')

@section('title', 'OptiDrive — Notifications')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    :root {
        --green: #39C70D;
        --green-dark: #2ea00a;
        --green-light: #f0fde8;
        --white: #ffffff;
        --gray-bg: #f2f2f2;
        --gray-border: #e8e8e8;
        --black: #0a0a0a;
        --text-muted: #888;
    }

    * { box-sizing: border-box; }
    body { font-family: 'DM Sans', sans-serif; background: var(--gray-bg); margin: 0; min-height: 100vh; }

    .notif-wrapper {
        max-width: 640px;
        margin: 0 auto;
        padding: 40px 24px;
    }

    /* Header */
    .notif-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 32px;
        animation: fadeUp 0.5s ease-out both;
    }

    .notif-header-left {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .back-btn {
        width: 38px; height: 38px;
        border-radius: 50%;
        background: var(--white);
        border: 1.5px solid var(--gray-border);
        display: flex; align-items: center; justify-content: center;
        text-decoration: none;
        transition: background 0.2s, border-color 0.2s;
        flex-shrink: 0;
    }

    .back-btn:hover { background: var(--gray-bg); border-color: var(--green); }

    .back-btn svg {
        width: 16px; height: 16px;
        stroke: var(--black); fill: none;
        stroke-width: 2.5;
        stroke-linecap: round; stroke-linejoin: round;
    }

    .notif-title {
        font-size: 22px;
        font-weight: 700;
        color: var(--black);
        letter-spacing: -0.3px;
    }

    .mark-all-btn {
        font-size: 13px;
        font-weight: 600;
        color: var(--green);
        background: none;
        border: none;
        cursor: pointer;
        text-decoration: none;
        padding: 6px 12px;
        border-radius: 20px;
        transition: background 0.2s;
    }

    .mark-all-btn:hover { background: var(--green-light); }

    /* Notification list */
    .notif-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    /* Notification card */
    .notif-card {
        background: var(--white);
        border-radius: 16px;
        padding: 16px 20px;
        display: flex;
        align-items: flex-start;
        gap: 14px;
        box-shadow: 0 1px 8px rgba(0,0,0,0.05);
        position: relative;
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
        animation: fadeUp 0.5s ease-out both;
    }

    .notif-card:hover { transform: translateY(-2px); box-shadow: 0 4px 16px rgba(0,0,0,0.08); }

    /* Unread green left border */
    .notif-card.unread::before {
        content: '';
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 4px;
        background: var(--green);
        border-radius: 4px 0 0 4px;
    }

    .notif-card.unread { padding-left: 24px; }

    /* Icon */
    .notif-icon {
        width: 44px; height: 44px;
        border-radius: 12px;
        background: var(--gray-bg);
        display: flex; align-items: center; justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }

    .notif-icon.promo   { background: #fff8e1; }
    .notif-icon.driver  { background: #e8f5e9; }
    .notif-icon.system  { background: #e3f2fd; }
    .notif-icon.general { background: var(--gray-bg); }

    /* Content */
    .notif-content { flex: 1; min-width: 0; }

    .notif-content-title {
        font-size: 15px;
        font-weight: 700;
        color: var(--black);
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .unread-dot {
        width: 7px; height: 7px;
        background: var(--green);
        border-radius: 50%;
        flex-shrink: 0;
    }

    .notif-content-msg {
        font-size: 13px;
        color: var(--text-muted);
        line-height: 1.5;
    }

    .notif-time {
        font-size: 11px;
        color: #bbb;
        margin-top: 6px;
    }

    /* Delete button */
    .notif-delete {
        width: 28px; height: 28px;
        border-radius: 50%;
        background: none;
        border: none; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        opacity: 0;
        transition: opacity 0.2s, background 0.2s;
        flex-shrink: 0;
    }

    .notif-card:hover .notif-delete { opacity: 1; }
    .notif-delete:hover { background: #fee2e2; }

    .notif-delete svg {
        width: 14px; height: 14px;
        stroke: #e53e3e; fill: none;
        stroke-width: 2;
        stroke-linecap: round; stroke-linejoin: round;
    }

    /* Section label */
    .section-label {
        font-size: 11px;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin-bottom: 8px;
        margin-top: 24px;
        padding: 0 4px;
    }

    .section-label:first-child { margin-top: 0; }

    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 64px 24px;
        animation: fadeUp 0.5s ease-out both;
    }

    .empty-icon {
        font-size: 56px;
        margin-bottom: 16px;
    }

    .empty-state h3 {
        font-size: 18px;
        font-weight: 700;
        color: var(--black);
        margin-bottom: 8px;
    }

    .empty-state p {
        font-size: 14px;
        color: var(--text-muted);
        line-height: 1.6;
    }

    /* Flash message */
    .flash-msg {
        background: var(--green-light);
        border: 1px solid rgba(57,199,13,0.3);
        border-radius: 12px;
        padding: 12px 16px;
        font-size: 13px;
        color: var(--green-dark);
        font-weight: 500;
        margin-bottom: 20px;
        text-align: center;
    }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="notif-wrapper">

    @if(session('success'))
        <div class="flash-msg">{{ session('success') }}</div>
    @endif

    <!-- Header -->
    <div class="notif-header">
        <div class="notif-header-left">
            <a href="{{ url()->previous() }}" class="back-btn">
                <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"></polyline></svg>
            </a>
            <h1 class="notif-title">Notifications</h1>
        </div>
        @if($notifications->where('is_read', false)->count() > 0)
            <span class="mark-all-btn">All read</span>
        @endif
    </div>

    @if($notifications->isEmpty())
        <!-- Empty state -->
        <div class="empty-state">
            <div class="empty-icon">🔔</div>
            <h3>No notifications yet</h3>
            <p>We'll notify you about promos, ride updates and important information here</p>
        </div>
    @else
        <!-- Unread notifications -->
        @php $unread = $notifications->where('is_read', false); @endphp
        @if($unread->count() > 0)
            <div class="section-label">New</div>
            <div class="notif-list">
                @foreach($unread as $notif)
                    <div class="notif-card unread" style="animation-delay: {{ $loop->index * 0.05 }}s">
                        <div class="notif-icon {{ $notif->type }}">{{ $notif->icon }}</div>
                        <div class="notif-content">
                            <div class="notif-content-title">
                                {{ $notif->title }}
                                <span class="unread-dot"></span>
                            </div>
                            <div class="notif-content-msg">{{ $notif->message }}</div>
                            <div class="notif-time">{{ $notif->created_at->diffForHumans() }}</div>
                        </div>
                        <form method="POST" action="{{ route('notifications.destroy', $notif->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="notif-delete">
                                <svg viewBox="0 0 24 24">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Read notifications -->
        @php $read = $notifications->where('is_read', true); @endphp
        @if($read->count() > 0)
            <div class="section-label">Earlier</div>
            <div class="notif-list">
                @foreach($read as $notif)
                    <div class="notif-card" style="animation-delay: {{ $loop->index * 0.05 }}s">
                        <div class="notif-icon {{ $notif->type }}" style="opacity:0.7">{{ $notif->icon }}</div>
                        <div class="notif-content">
                            <div class="notif-content-title" style="color:#555">{{ $notif->title }}</div>
                            <div class="notif-content-msg">{{ $notif->message }}</div>
                            <div class="notif-time">{{ $notif->created_at->diffForHumans() }}</div>
                        </div>
                        <form method="POST" action="{{ route('notifications.destroy', $notif->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="notif-delete">
                                <svg viewBox="0 0 24 24">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif
    @endif

</div>

@endsection