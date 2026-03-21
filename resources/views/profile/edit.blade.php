@extends('layouts.app')

@section('title', 'OptiDrive — Edit Profile')

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

    .profile-wrapper {
        max-width: 600px;
        margin: 0 auto;
        padding: 40px 24px;
    }

    /* Header */
    .profile-header {
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        margin-bottom: 36px;
        animation: fadeUp 0.5s ease-out both;
    }

    .back-btn {
        position: absolute; left: 0;
        width: 38px; height: 38px;
        border-radius: 50%;
        background: var(--white);
        border: 1.5px solid var(--gray-border);
        display: flex; align-items: center; justify-content: center;
        text-decoration: none;
        transition: background 0.2s, border-color 0.2s;
    }

    .back-btn:hover { background: var(--gray-bg); border-color: var(--green); }

    .back-btn svg {
        width: 16px; height: 16px;
        stroke: var(--black); fill: none;
        stroke-width: 2.5; stroke-linecap: round; stroke-linejoin: round;
    }

    .profile-title {
        font-size: 20px;
        font-weight: 700;
        color: var(--black);
        letter-spacing: -0.3px;
    }

    /* Avatar section */
    .avatar-section {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
        margin-bottom: 36px;
        animation: fadeUp 0.5s ease-out 0.1s both;
    }

    .avatar-wrap {
        position: relative;
        width: 90px; height: 90px;
    }

    .avatar-circle {
        width: 90px; height: 90px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--green), #2ea00a);
        display: flex; align-items: center; justify-content: center;
        font-size: 36px;
        font-weight: 700;
        color: white;
        border: 3px solid white;
        box-shadow: 0 4px 16px rgba(57,199,13,0.3);
    }

    .avatar-edit {
        position: absolute;
        bottom: 0; right: 0;
        width: 28px; height: 28px;
        border-radius: 50%;
        background: var(--green);
        border: 2px solid white;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        transition: background 0.2s;
    }

    .avatar-edit:hover { background: var(--green-dark); }

    .avatar-edit svg {
        width: 12px; height: 12px;
        stroke: white; fill: none;
        stroke-width: 2.5; stroke-linecap: round; stroke-linejoin: round;
    }

    .avatar-name {
        font-size: 20px;
        font-weight: 700;
        color: var(--black);
    }

    .avatar-email {
        font-size: 13px;
        color: var(--text-muted);
        margin-top: -8px;
    }

    /* Card */
    .profile-card {
        background: var(--white);
        border-radius: 20px;
        padding: 28px 24px;
        box-shadow: 0 2px 16px rgba(0,0,0,0.06);
        margin-bottom: 16px;
        animation: fadeUp 0.5s ease-out 0.15s both;
    }

    .card-section-label {
        font-size: 11px;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin-bottom: 20px;
    }

    /* Form fields */
    .field-group {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .field-wrap { position: relative; }

    .field-label {
        font-size: 12px;
        font-weight: 600;
        color: var(--text-muted);
        margin-bottom: 6px;
        display: block;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }

    .field-input {
        width: 100%;
        height: 50px;
        background: var(--gray-input);
        border: 1.5px solid transparent;
        border-radius: 12px;
        padding: 0 16px;
        font-size: 15px;
        font-family: 'DM Sans', sans-serif;
        color: var(--black);
        outline: none;
        transition: border-color 0.2s, background 0.2s;
    }

    .field-input::placeholder { color: #bbb; }
    .field-input:focus { border-color: var(--green); background: white; }
    .field-input.error { border-color: #e53e3e; }
    .field-input:disabled { opacity: 0.6; cursor: not-allowed; }

    .field-icon {
        position: absolute;
        right: 14px; top: 50%;
        transform: translateY(-50%);
        width: 16px; height: 16px;
        stroke: var(--text-muted); fill: none;
        stroke-width: 2; stroke-linecap: round;
    }

    .error-msg {
        font-size: 12px;
        color: #e53e3e;
        margin-top: 5px;
        display: block;
    }

    /* Phone field with country code */
    .phone-row {
        display: flex;
        gap: 10px;
    }

    .country-pill {
        display: flex; align-items: center; gap: 6px;
        background: var(--gray-input);
        border: 1.5px solid transparent;
        border-radius: 12px;
        padding: 0 14px;
        height: 50px;
        font-size: 14px; font-weight: 600;
        color: var(--black);
        flex-shrink: 0;
        white-space: nowrap;
    }

    /* Stats strip */
    .stats-strip {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        margin-bottom: 16px;
        animation: fadeUp 0.5s ease-out 0.2s both;
    }

    .stat-card {
        background: var(--white);
        border-radius: 16px;
        padding: 16px;
        text-align: center;
        box-shadow: 0 2px 12px rgba(0,0,0,0.05);
    }

    .stat-num {
        font-size: 22px;
        font-weight: 800;
        color: var(--green);
        letter-spacing: -0.5px;
    }

    .stat-label {
        font-size: 11px;
        color: var(--text-muted);
        font-weight: 500;
        margin-top: 4px;
    }

    /* Save button */
    .save-btn {
        width: 100%;
        padding: 15px;
        background: var(--green);
        color: white;
        font-family: 'DM Sans', sans-serif;
        font-size: 15px; font-weight: 600;
        border: none; border-radius: 100px;
        cursor: pointer;
        transition: background 0.2s, transform 0.1s;
        box-shadow: 0 4px 14px rgba(57,199,13,0.3);
        display: flex; align-items: center; justify-content: center; gap: 8px;
        animation: fadeUp 0.5s ease-out 0.3s both;
    }

    .save-btn:hover { background: var(--green-dark); transform: translateY(-1px); }
    .save-btn:active { transform: translateY(0); }

    .btn-spinner {
        display: none; width: 18px; height: 18px;
        border: 2px solid rgba(255,255,255,0.4);
        border-top-color: white; border-radius: 50%;
        animation: spin 0.7s linear infinite;
    }

    .btn-spinner.show { display: block; }
    .btn-label.hide { display: none; }

    /* Delete account */
    .delete-section {
        margin-top: 24px;
        text-align: center;
        animation: fadeUp 0.5s ease-out 0.35s both;
    }

    .delete-btn {
        background: none; border: none;
        font-family: 'DM Sans', sans-serif;
        font-size: 13px; font-weight: 600;
        color: #e53e3e; cursor: pointer;
        padding: 8px 16px;
        border-radius: 8px;
        transition: background 0.2s;
    }

    .delete-btn:hover { background: #fff5f5; }

    /* Flash messages */
    .flash-success {
        background: var(--green-light);
        border: 1px solid rgba(57,199,13,0.3);
        border-radius: 12px;
        padding: 12px 16px;
        font-size: 13px;
        color: var(--green-dark);
        font-weight: 500;
        margin-bottom: 20px;
        text-align: center;
        animation: fadeUp 0.3s ease-out both;
    }

    .flash-error {
        background: #fff5f5;
        border: 1px solid #fed7d7;
        border-radius: 12px;
        padding: 12px 16px;
        font-size: 13px;
        color: #c53030;
        margin-bottom: 20px;
        animation: fadeUp 0.3s ease-out both;
    }

    @keyframes fadeUp { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes spin { to { transform: rotate(360deg); } }
</style>

<div class="profile-wrapper">

    @if(session('status') === 'profile-updated')
        <div class="flash-success">✅ Profile updated successfully!</div>
    @endif

    @if($errors->any())
        <div class="flash-error">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <!-- Header -->
    <div class="profile-header">
        <a href="{{ route('settings') }}" class="back-btn">
            <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"></polyline></svg>
        </a>
        <h1 class="profile-title">Edit Profile</h1>
    </div>

    <!-- Avatar -->
    <div class="avatar-section">
        <div class="avatar-wrap">
            <div class="avatar-circle">
                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
            </div>
            <div class="avatar-edit">
                <svg viewBox="0 0 24 24">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                </svg>
            </div>
        </div>
        <div class="avatar-name">{{ auth()->user()->name ?? 'User' }}</div>
        <div class="avatar-email">{{ auth()->user()->email ?? '' }}</div>
    </div>

    <!-- Stats Strip -->
    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-num">{{ auth()->user()->rides()->count() ?? 0 }}</div>
            <div class="stat-label">Total Rides</div>
        </div>
        <div class="stat-card">
            <div class="stat-num">
                GH₵ {{ number_format(auth()->user()->rides()->sum('price') ?? 0, 0) }}
            </div>
            <div class="stat-label">Total Spent</div>
        </div>
        <div class="stat-card">
            <div class="stat-num">
                {{ (int) auth()->user()->created_at->diffInDays(now()) }}
            </div>
            <div class="stat-label">Days with Us</div>
        </div>
    </div>

    <!-- Profile Form -->
    <div class="profile-card">
        <div class="card-section-label">Personal Information</div>

        <form method="POST" action="{{ route('profile.update') }}" id="profileForm">
            @csrf
            @method('patch')

            <div class="field-group">
                <!-- Name -->
                <div>
                    <label class="field-label" for="name">Full Name</label>
                    <div class="field-wrap">
                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="field-input {{ $errors->has('name') ? 'error' : '' }}"
                            value="{{ old('name', auth()->user()->name) }}"
                            placeholder="Your full name"
                            required
                        />
                        <svg class="field-icon" viewBox="0 0 24 24">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    @error('name')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="field-label" for="email">Email Address</label>
                    <div class="field-wrap">
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="field-input {{ $errors->has('email') ? 'error' : '' }}"
                            value="{{ old('email', auth()->user()->email) }}"
                            placeholder="your@email.com"
                            required
                        />
                        <svg class="field-icon" viewBox="0 0 24 24">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                    </div>
                    @error('email')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label class="field-label" for="phone">Phone Number</label>
                    <div class="phone-row">
                        <div class="country-pill">🇬🇭 +233</div>
                        <input
                            type="tel"
                            id="phone"
                            name="phone"
                            class="field-input"
                            value="{{ old('phone', auth()->user()->phone) }}"
                            placeholder="XX XXX XXXX"
                            style="flex:1"
                        />
                    </div>
                </div>

                <!-- Default Pickup -->
                <div>
                    <label class="field-label" for="default_pickup">Default Pickup Location</label>
                    <div class="field-wrap">
                        <input
                            type="text"
                            id="default_pickup"
                            name="default_pickup"
                            class="field-input"
                            value="{{ old('default_pickup', auth()->user()->default_pickup) }}"
                            placeholder="e.g. East Legon, Accra"
                        />
                        <svg class="field-icon" viewBox="0 0 24 24">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Preferences Card -->
    <div class="profile-card" style="animation-delay: 0.2s">
        <div class="card-section-label">Ride Preferences</div>
        <div class="field-group">
            <div>
                <label class="field-label">Preferred Providers</label>
                <div style="display:flex; gap:8px; flex-wrap:wrap; margin-top:4px">
                    @php
                        $preferred = auth()->user()->preferred_providers ?? [];
                        $providers = ['Bolt', 'Uber', 'inDrive', 'Taxi'];
                    @endphp
                    @foreach($providers as $provider)
                        <label style="display:flex; align-items:center; gap:6px; cursor:pointer;
                            background: {{ in_array($provider, $preferred) ? '#f0fde8' : '#f5f5f5' }};
                            border: 1.5px solid {{ in_array($provider, $preferred) ? '#39C70D' : '#e8e8e8' }};
                            border-radius: 100px; padding: 8px 16px;
                            font-size: 13px; font-weight: 600;
                            transition: all 0.2s;">
                            <input
                                type="checkbox"
                                form="profileForm"
                                name="preferred_providers[]"
                                value="{{ $provider }}"
                                {{ in_array($provider, $preferred) ? 'checked' : '' }}
                                style="accent-color: #39C70D"
                                onchange="updateProviderStyle(this)"
                            />
                            {{ $provider }}
                        </label>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Save Button -->
    <button type="submit" form="profileForm" class="save-btn" id="saveBtn">
        <span class="btn-label" id="btnLabel">Save Changes</span>
        <div class="btn-spinner" id="btnSpinner"></div>
    </button>

    <!-- Delete Account -->
    <div class="delete-section">
        <form method="POST" action="{{ route('profile.destroy') }}"
              onsubmit="return confirm('Are you sure you want to delete your account? This cannot be undone.')">
            @csrf
            @method('delete')
            <input type="hidden" name="password" value="">
            <button type="submit" class="delete-btn">Delete Account</button>
        </form>
    </div>

</div>

<script>
    // Loading state on submit
    document.getElementById('profileForm').addEventListener('submit', function() {
        document.getElementById('btnLabel').classList.add('hide');
        document.getElementById('btnSpinner').classList.add('show');
        document.getElementById('saveBtn').disabled = true;
    });

    // Update provider pill style on checkbox change
    function updateProviderStyle(checkbox) {
        const label = checkbox.parentElement;
        if (checkbox.checked) {
            label.style.background = '#f0fde8';
            label.style.borderColor = '#39C70D';
        } else {
            label.style.background = '#f5f5f5';
            label.style.borderColor = '#e8e8e8';
        }
    }
</script>

@endsection