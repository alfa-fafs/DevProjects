@extends('layouts.app')

@section('title', 'OptiDrive — Rate Your Ride')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    :root {
        --green: #39C70D;
        --green-dark: #2ea00a;
        --green-light: #f0fde8;
        --white: #ffffff;
        --gray-bg: #f2f2f2;
        --gray-input: #e8e8e8;
        --gray-border: #d8d8d8;
        --black: #0a0a0a;
        --text-muted: #888;
    }

    * { box-sizing: border-box; }
    body { font-family: 'DM Sans', sans-serif; background: var(--gray-bg); margin: 0; min-height: 100vh; }

    .rating-wrapper {
        min-height: calc(100vh - 68px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 48px 24px;
    }

    .rating-card {
        background: var(--white);
        border-radius: 24px;
        padding: 48px 44px;
        width: 100%;
        max-width: 520px;
        box-shadow: 0 2px 24px rgba(0,0,0,0.07);
        animation: fadeUp 0.5s ease-out both;
        position: relative;
    }

    /* Back button */
    .back-btn {
        position: absolute;
        top: 24px; left: 24px;
        width: 36px; height: 36px;
        border-radius: 50%;
        background: var(--gray-bg);
        border: none; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        text-decoration: none;
        transition: background 0.2s;
    }

    .back-btn:hover { background: var(--gray-border); }

    .back-btn svg {
        width: 18px; height: 18px;
        stroke: var(--black); fill: none;
        stroke-width: 2.5;
        stroke-linecap: round; stroke-linejoin: round;
    }

    /* Illustration */
    .illustration {
        display: flex;
        justify-content: center;
        margin-bottom: 24px;
        margin-top: 16px;
    }

    .illustration img {
        width: 100px;
        height: 100px;
        object-fit: contain;
    }

    .illustration-placeholder {
        width: 100px; height: 100px;
        background: var(--green-light);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 48px;
    }

    /* Header */
    .rating-header {
        text-align: center;
        margin-bottom: 32px;
    }

    .rating-header h1 {
        font-size: 24px;
        font-weight: 700;
        color: var(--black);
        margin-bottom: 8px;
        letter-spacing: -0.3px;
    }

    .rating-header p {
        font-size: 14px;
        color: var(--text-muted);
    }

    .rating-header .provider-name {
        color: var(--green);
        font-weight: 600;
    }

    /* Ride info strip */
    .ride-info {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: var(--gray-bg);
        border-radius: 12px;
        padding: 10px 16px;
        margin-bottom: 32px;
        font-size: 13px;
        color: var(--text-muted);
    }

    .ride-info .route {
        font-weight: 600;
        color: var(--black);
    }

    /* Stars */
    .stars-section {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin-bottom: 12px;
    }

    .star-btn {
        background: none;
        border: none;
        cursor: pointer;
        padding: 4px;
        transition: transform 0.15s;
        line-height: 1;
    }

    .star-btn:hover { transform: scale(1.2); }
    .star-btn:active { transform: scale(0.95); }

    .star-btn svg {
        width: 40px; height: 40px;
        transition: fill 0.15s, stroke 0.15s;
    }

    .star-btn.filled svg {
        fill: var(--green);
        stroke: var(--green);
    }

    .star-btn.empty svg {
        fill: #e0e0e0;
        stroke: #e0e0e0;
    }

    .star-btn.hover-fill svg {
        fill: var(--green);
        stroke: var(--green);
        opacity: 0.6;
    }

    /* Star label */
    .star-label {
        text-align: center;
        font-size: 13px;
        font-weight: 600;
        color: var(--green);
        height: 20px;
        margin-bottom: 24px;
        transition: opacity 0.2s;
    }

    /* Comment area */
    .comment-area {
        width: 100%;
        min-height: 100px;
        background: var(--white);
        border: 1.5px solid var(--green);
        border-radius: 12px;
        padding: 14px 16px;
        font-size: 14px;
        font-family: 'DM Sans', sans-serif;
        color: var(--black);
        outline: none;
        resize: vertical;
        transition: border-color 0.2s;
        margin-bottom: 8px;
    }

    .comment-area::placeholder { color: #bbb; }
    .comment-area:focus { border-color: var(--green-dark); }

    .char-count {
        text-align: right;
        font-size: 11px;
        color: var(--text-muted);
        margin-bottom: 28px;
    }

    /* Already rated banner */
    .already-rated {
        background: var(--green-light);
        border: 1px solid rgba(57,199,13,0.3);
        border-radius: 12px;
        padding: 12px 16px;
        font-size: 13px;
        color: var(--green-dark);
        font-weight: 500;
        text-align: center;
        margin-bottom: 20px;
        display: none;
    }

    .already-rated.show { display: block; }

    /* Submit button */
    .submit-btn {
        width: 100%;
        padding: 15px;
        background: var(--green);
        color: white;
        font-family: 'DM Sans', sans-serif;
        font-size: 15px; font-weight: 600;
        border: none; border-radius: 100px;
        cursor: pointer;
        transition: background 0.2s, transform 0.1s, opacity 0.2s;
        display: flex; align-items: center; justify-content: center; gap: 8px;
        box-shadow: 0 4px 14px rgba(57,199,13,0.3);
    }

    .submit-btn:hover { background: var(--green-dark); transform: translateY(-1px); }
    .submit-btn:active { transform: translateY(0); }
    .submit-btn:disabled { opacity: 0.4; cursor: not-allowed; transform: none; }

    .btn-spinner {
        display: none; width: 18px; height: 18px;
        border: 2px solid rgba(255,255,255,0.4);
        border-top-color: white; border-radius: 50%;
        animation: spin 0.7s linear infinite;
    }

    .btn-spinner.show { display: block; }
    .btn-label.hide { display: none; }

    /* Success overlay */
    .success-overlay {
        position: fixed; inset: 0;
        background: rgba(255,255,255,0.96);
        display: flex; flex-direction: column;
        align-items: center; justify-content: center; gap: 16px;
        z-index: 50; opacity: 0; pointer-events: none;
        transition: opacity 0.4s;
    }

    .success-overlay.show { opacity: 1; pointer-events: auto; }

    .checkmark-circle {
        width: 80px; height: 80px; border-radius: 50%;
        background: var(--green);
        display: flex; align-items: center; justify-content: center;
        transform: scale(0);
        transition: transform 0.4s cubic-bezier(0.34,1.56,0.64,1);
    }

    .checkmark-circle.show { transform: scale(1); }

    .checkmark-circle svg {
        width: 40px; height: 40px;
        stroke: white; fill: none; stroke-width: 3;
        stroke-linecap: round; stroke-linejoin: round;
    }

    .success-overlay h2 { font-size: 22px; font-weight: 700; color: var(--black); }
    .success-overlay p { font-size: 14px; color: var(--text-muted); }

    /* Session success message */
    .flash-success {
        background: var(--green-light);
        border: 1px solid rgba(57,199,13,0.3);
        border-radius: 12px;
        padding: 12px 16px;
        font-size: 13px;
        color: var(--green-dark);
        font-weight: 500;
        text-align: center;
        margin-bottom: 20px;
    }

    @keyframes fadeUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes spin { to { transform: rotate(360deg); } }
</style>

<!-- Success overlay -->
<div class="success-overlay" id="successOverlay">
    <div class="checkmark-circle" id="checkmarkCircle">
        <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg>
    </div>
    <h2>Thanks for your feedback!</h2>
    <p>Your rating helps improve the experience for everyone</p>
</div>

<div class="rating-wrapper">
    <div class="rating-card">

        <!-- Back button -->
        <a href="{{ route('history.index') }}" class="back-btn">
            <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"></polyline></svg>
        </a>

        <!-- Illustration -->
        <div class="illustration">
            <div class="illustration-placeholder">🚗</div>
        </div>

        <!-- Header -->
        <div class="rating-header">
            <h1>How was your ride?</h1>
            <p>Rate your experience with
                <span class="provider-name">{{ $ride->provider }}</span>
            </p>
        </div>

        <!-- Ride info -->
        <div class="ride-info">
            <span>📍</span>
            <span class="route">{{ $ride->pickup_address }}</span>
            <span>→</span>
            <span class="route">{{ $ride->dropoff_address }}</span>
            <span>·</span>
            <span>GH₵ {{ number_format($ride->price, 2) }}</span>
        </div>

        @if(session('success'))
            <div class="flash-success">{{ session('success') }}</div>
        @endif

        @if($existing)
            <div class="already-rated show">
                ✅ You already rated this ride {{ $existing->stars }} star{{ $existing->stars > 1 ? 's' : '' }}. You can update your rating below.
            </div>
        @endif

        <!-- Rating Form -->
        <form method="POST" action="{{ route('rides.rate.store', $ride->id) }}" id="ratingForm">
            @csrf

            <!-- Hidden stars input -->
            <input type="hidden" name="stars" id="starsInput" value="{{ $existing->stars ?? 0 }}">

            <!-- Star buttons -->
            <div class="stars-section" id="starsRow">
                @for($i = 1; $i <= 5; $i++)
                    <button
                        type="button"
                        class="star-btn {{ $existing && $i <= $existing->stars ? 'filled' : 'empty' }}"
                        data-star="{{ $i }}"
                        onclick="setRating({{ $i }})"
                        onmouseover="hoverRating({{ $i }})"
                        onmouseout="resetHover()"
                    >
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                        </svg>
                    </button>
                @endfor
            </div>

            <!-- Star label -->
            <div class="star-label" id="starLabel">
                @if($existing)
                    {{ ['', 'Poor', 'Fair', 'Good', 'Great', 'Excellent!'][$existing->stars] }}
                @endif
            </div>

            <!-- Comment -->
            <textarea
                name="comment"
                id="comment"
                class="comment-area"
                placeholder="Write a comment (optional)"
                maxlength="500"
                oninput="updateCharCount(this)"
            >{{ $existing->comment ?? '' }}</textarea>

            <div class="char-count">
                <span id="charCount">{{ strlen($existing->comment ?? '') }}</span>/500
            </div>

            <!-- Submit -->
            <button
                type="submit"
                class="submit-btn"
                id="submitBtn"
                {{ !$existing && 0 == 0 ? 'disabled' : '' }}
            >
                <span class="btn-label" id="btnLabel">Submit Feedback</span>
                <div class="btn-spinner" id="btnSpinner"></div>
            </button>
        </form>

    </div>
</div>

<script>
    const labels   = ['', 'Poor 😕', 'Fair 😐', 'Good 😊', 'Great 😄', 'Excellent! 🌟'];
    let currentRating = {{ $existing->stars ?? 0 }};

    function setRating(star) {
        currentRating = star;
        document.getElementById('starsInput').value = star;
        document.getElementById('starLabel').textContent = labels[star];
        document.getElementById('submitBtn').disabled = false;
        updateStars(star);
    }

    function hoverRating(star) {
        updateStars(star, true);
    }

    function resetHover() {
        updateStars(currentRating);
    }

    function updateStars(upTo, isHover = false) {
        document.querySelectorAll('.star-btn').forEach((btn, i) => {
            const starNum = i + 1;
            btn.className = 'star-btn ' + (starNum <= upTo
                ? (isHover ? 'hover-fill' : 'filled')
                : 'empty');
        });
    }

    function updateCharCount(el) {
        document.getElementById('charCount').textContent = el.value.length;
    }

    // Loading state on submit
    document.getElementById('ratingForm').addEventListener('submit', function() {
        const stars = parseInt(document.getElementById('starsInput').value);
        if (stars < 1) {
            alert('Please select a star rating first!');
            return false;
        }
        document.getElementById('btnLabel').classList.add('hide');
        document.getElementById('btnSpinner').classList.add('show');
        document.getElementById('submitBtn').disabled = true;
    });

    // Initialize stars if already rated
    @if($existing)
        updateStars({{ $existing->stars }});
    @endif
</script>

@endsection