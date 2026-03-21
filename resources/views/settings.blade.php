@extends('layouts.app')

@section('title', 'OptiDrive — Settings')

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

    .settings-wrapper {
        max-width: 600px;
        margin: 0 auto;
        padding: 40px 24px;
    }

    /* Header */
    .settings-header {
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

    .settings-title {
        font-size: 20px;
        font-weight: 700;
        color: var(--black);
        letter-spacing: -0.3px;
    }

    /* Section label */
    .section-label {
        font-size: 11px;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin-bottom: 10px;
        padding: 0 4px;
    }

    /* Settings group */
    .settings-group {
        background: var(--white);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 1px 8px rgba(0,0,0,0.05);
        margin-bottom: 24px;
        animation: fadeUp 0.5s ease-out 0.1s both;
    }

    /* Setting row */
    .setting-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 20px;
        border-bottom: 1px solid var(--gray-border);
        transition: background 0.15s;
    }

    .setting-row:last-child { border-bottom: none; }
    .setting-row:hover { background: #fafafa; }

    .setting-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .setting-icon {
        width: 36px; height: 36px;
        border-radius: 10px;
        background: var(--gray-bg);
        display: flex; align-items: center; justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .setting-label {
        font-size: 15px;
        font-weight: 500;
        color: var(--black);
    }

    .setting-desc {
        font-size: 12px;
        color: var(--text-muted);
        margin-top: 2px;
    }

    .setting-right {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .setting-value {
        font-size: 14px;
        font-weight: 600;
        color: var(--green);
    }

    /* Toggle switch */
    .toggle {
        position: relative;
        width: 48px; height: 28px;
        cursor: pointer;
    }

    .toggle input { opacity: 0; width: 0; height: 0; }

    .toggle-slider {
        position: absolute; inset: 0;
        background: var(--gray-border);
        border-radius: 28px;
        transition: background 0.3s;
    }

    .toggle-slider::before {
        content: '';
        position: absolute;
        width: 22px; height: 22px;
        left: 3px; bottom: 3px;
        background: white;
        border-radius: 50%;
        transition: transform 0.3s;
        box-shadow: 0 1px 4px rgba(0,0,0,0.2);
    }

    .toggle input:checked + .toggle-slider { background: var(--green); }
    .toggle input:checked + .toggle-slider::before { transform: translateX(20px); }

    /* Language selector */
    .lang-select {
        background: none;
        border: none;
        font-family: 'DM Sans', sans-serif;
        font-size: 14px;
        font-weight: 600;
        color: var(--green);
        cursor: pointer;
        outline: none;
        appearance: none;
        padding-right: 4px;
    }

    /* Arrow for language */
    .setting-arrow {
        width: 16px; height: 16px;
        stroke: var(--gray-border); fill: none;
        stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;
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

    /* Danger zone */
    .danger-group {
        background: var(--white);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 1px 8px rgba(0,0,0,0.05);
        margin-bottom: 24px;
        animation: fadeUp 0.5s ease-out 0.3s both;
    }

    .danger-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 20px;
        cursor: pointer;
        transition: background 0.15s;
    }

    .danger-row:hover { background: #fff5f5; }

    .danger-label {
        font-size: 15px;
        font-weight: 500;
        color: #e53e3e;
    }

    .danger-row svg {
        width: 16px; height: 16px;
        stroke: #e53e3e; fill: none;
        stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;
    }

    /* Version info */
    .version-info {
        text-align: center;
        font-size: 12px;
        color: #bbb;
        margin-top: 8px;
        animation: fadeUp 0.5s ease-out 0.4s both;
    }

    @keyframes fadeUp { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
</style>

<div class="settings-wrapper">

    @if(session('success'))
        <div class="flash-msg">✅ {{ session('success') }}</div>
    @endif

    <!-- Header -->
    <div class="settings-header">
        <a href="{{ url()->previous() }}" class="back-btn">
            <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"></polyline></svg>
        </a>
        <h1 class="settings-title">Settings</h1>
    </div>

    <!-- Preferences -->
    <div class="section-label">Preferences</div>
    <div class="settings-group">

        <!-- Language -->
        <div class="setting-row">
            <div class="setting-left">
                <div class="setting-icon">🌐</div>
                <div>
                    <div class="setting-label">Language</div>
                    <div class="setting-desc">App display language</div>
                </div>
            </div>
            <div class="setting-right">
                <select class="lang-select" onchange="saveSetting('language', this.value)">
                    <option value="en" selected>English</option>
                    <option value="tw">Twi</option>
                    <option value="ga">Ga</option>
                    <option value="fr">French</option>
                </select>
                <svg class="setting-arrow" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </div>
        </div>

        <!-- Notifications -->
        <div class="setting-row">
            <div class="setting-left">
                <div class="setting-icon">🔔</div>
                <div>
                    <div class="setting-label">Notifications</div>
                    <div class="setting-desc">Ride updates & promos</div>
                </div>
            </div>
            <label class="toggle">
                <input type="checkbox" checked onchange="saveSetting('notifications', this.checked)">
                <span class="toggle-slider"></span>
            </label>
        </div>

        <!-- Dark Mode -->
        <div class="setting-row">
            <div class="setting-left">
                <div class="setting-icon">🌙</div>
                <div>
                    <div class="setting-label">Dark Mode</div>
                    <div class="setting-desc">Switch to dark theme</div>
                </div>
            </div>
            <label class="toggle">
                <input type="checkbox" id="darkModeToggle" onchange="toggleDarkMode(this.checked)">
                <span class="toggle-slider"></span>
            </label>
        </div>

    </div>

    <!-- Account -->
    <div class="section-label">Account</div>
    <div class="settings-group">

        <!-- Profile -->
        <a href="{{ route('profile.edit') }}" class="setting-row" style="text-decoration:none">
            <div class="setting-left">
                <div class="setting-icon">👤</div>
                <div>
                    <div class="setting-label">Edit Profile</div>
                    <div class="setting-desc">Name, email, phone</div>
                </div>
            </div>
            <svg class="setting-arrow" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
        </a>

        <!-- Payment Methods -->
        <a href="{{ route('payment.index') }}" class="setting-row" style="text-decoration:none">
            <div class="setting-left">
                <div class="setting-icon">💳</div>
                <div>
                    <div class="setting-label">Payment Methods</div>
                    <div class="setting-desc">Manage your payment options</div>
                </div>
            </div>
            <svg class="setting-arrow" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
        </a>

        <!-- Change Password -->
        <a href="{{ route('password.request') }}" class="setting-row" style="text-decoration:none">
            <div class="setting-left">
                <div class="setting-icon">🔒</div>
                <div>
                    <div class="setting-label">Change Password</div>
                    <div class="setting-desc">Update your password</div>
                </div>
            </div>
            <svg class="setting-arrow" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
        </a>

    </div>

    <!-- About -->
    <div class="section-label">About</div>
    <div class="settings-group">
    
      <a href="{{ route('help') }}" class="setting-row" style="text-decoration:none">
    <div class="setting-left">
        <div class="setting-icon">❓</div>
        <div><div class="setting-label">Help & Support</div></div>
    </div>
    <svg class="setting-arrow" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
</a>
        <div class="setting-row">
            <div class="setting-left">
                <div class="setting-icon">📋</div>
                <div><div class="setting-label">Terms of Service</div></div>
            </div>
            <svg class="setting-arrow" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
        </div>

        <div class="setting-row">
            <div class="setting-left">
                <div class="setting-icon">🔐</div>
                <div><div class="setting-label">Privacy Policy</div></div>
            </div>
            <svg class="setting-arrow" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
        </div>

        <div class="setting-row">
            <div class="setting-left">
                <div class="setting-icon">⭐</div>
                <div><div class="setting-label">Rate OptiDrive</div></div>
            </div>
            <svg class="setting-arrow" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
        </div>

    </div>

    <!-- Danger Zone -->
    <div class="section-label">Danger Zone</div>
    <div class="danger-group">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="danger-row" style="width:100%;background:none;border:none;cursor:pointer;font-family:inherit;">
                <span class="danger-label">Sign Out</span>
                <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
            </button>
        </form>
    </div>

    <div class="version-info">OptiDrive v1.0.0 · Built for Accra 🇬🇭</div>

</div>

<script>
    function saveSetting(key, value) {
        localStorage.setItem('setting_' + key, value);
        console.log('Saved:', key, value);
    }

    function toggleDarkMode(enabled) {
        if (enabled) {
            document.body.style.background = '#1a1a1a';
            document.body.style.color = '#fff';
        } else {
            document.body.style.background = '';
            document.body.style.color = '';
        }
        saveSetting('dark_mode', enabled);
    }

    // Restore dark mode on load
    if (localStorage.getItem('setting_dark_mode') === 'true') {
        document.getElementById('darkModeToggle').checked = true;
        toggleDarkMode(true);
    }
</script>

@endsection