@extends('layouts.app')

@section('title', 'OptiDrive — Create Account')

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

    .register-wrapper {
        min-height: calc(100vh - 68px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 48px 24px;
    }

    .register-card {
        background: var(--white);
        border-radius: 24px;
        padding: 48px 44px;
        width: 100%;
        max-width: 480px;
        box-shadow: 0 2px 24px rgba(0,0,0,0.07);
        animation: fadeUp 0.5s ease-out both;
    }

    /* Logo */
    .card-logo {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 32px;
    }

    .logo-icon {
        width: 36px; height: 36px;
        background: var(--white);
        border: 2px solid var(--green);
        border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
    }

    .logo-dot {
        width: 18px; height: 18px;
        background: var(--green);
        border-radius: 50%;
    }

    .logo-text {
        font-size: 18px;
        font-weight: 700;
        color: var(--black);
    }

    /* Header */
    .card-header { margin-bottom: 32px; }

    .card-header h1 {
        font-size: 26px;
        font-weight: 700;
        color: var(--black);
        letter-spacing: -0.3px;
        margin-bottom: 8px;
    }

    .card-header p {
        font-size: 14px;
        color: var(--text-muted);
        line-height: 1.5;
    }

    /* Form fields */
    .field-group {
        display: flex;
        flex-direction: column;
        gap: 16px;
        margin-bottom: 24px;
    }

    .field-label {
        font-size: 13px;
        font-weight: 600;
        color: var(--black);
        margin-bottom: 6px;
        display: block;
    }

    .field-input {
        width: 100%;
        height: 50px;
        background: var(--gray-input);
        border: 1.5px solid var(--gray-border);
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

    /* Password wrapper */
    .password-wrap { position: relative; }

    .password-toggle {
        position: absolute;
        right: 14px; top: 50%;
        transform: translateY(-50%);
        background: none; border: none;
        cursor: pointer; padding: 4px;
        color: var(--text-muted);
        display: flex; align-items: center;
    }

    .password-toggle svg {
        width: 18px; height: 18px;
        stroke: currentColor; fill: none; stroke-width: 2;
    }

    /* Error message */
    .error-msg {
        font-size: 12px;
        color: #e53e3e;
        margin-top: 6px;
        display: block;
    }

    /* Password strength */
    .password-strength {
        margin-top: 8px;
        display: none;
    }

    .strength-bar {
        height: 4px;
        border-radius: 2px;
        background: var(--gray-border);
        overflow: hidden;
        margin-bottom: 4px;
    }

    .strength-fill {
        height: 100%;
        border-radius: 2px;
        transition: width 0.3s, background 0.3s;
        width: 0%;
    }

    .strength-text {
        font-size: 11px;
        color: var(--text-muted);
    }

    /* Terms */
    .terms-row {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 24px;
        font-size: 13px;
        color: var(--text-muted);
    }

    .terms-row input[type="checkbox"] {
        width: 16px; height: 16px;
        accent-color: var(--green);
        cursor: pointer;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .terms-row a {
        color: var(--green);
        font-weight: 600;
        text-decoration: none;
    }

    /* Register button */
    .register-btn {
        width: 100%;
        padding: 15px;
        background: var(--green);
        color: white;
        font-family: 'DM Sans', sans-serif;
        font-size: 15px; font-weight: 600;
        border: none; border-radius: 100px;
        cursor: pointer;
        transition: background 0.2s, transform 0.1s;
        display: flex; align-items: center; justify-content: center; gap: 8px;
        box-shadow: 0 4px 14px rgba(57,199,13,0.3);
        margin-bottom: 20px;
    }

    .register-btn:hover { background: var(--green-dark); transform: translateY(-1px); }
    .register-btn:active { transform: translateY(0); }

    .btn-spinner {
        display: none; width: 18px; height: 18px;
        border: 2px solid rgba(255,255,255,0.4);
        border-top-color: white; border-radius: 50%;
        animation: spin 0.7s linear infinite;
    }

    .btn-spinner.show { display: block; }
    .btn-label.hide { display: none; }

    /* Divider */
    .divider {
        display: flex; align-items: center; gap: 12px;
        margin-bottom: 20px;
    }

    .divider-line { flex: 1; height: 1px; background: var(--gray-border); }
    .divider-text { font-size: 12px; color: var(--text-muted); }

    /* Phone option */
    .phone-btn {
        display: flex; align-items: center; justify-content: center; gap: 10px;
        width: 100%; padding: 14px;
        background: transparent;
        border: 1.5px solid var(--gray-border);
        border-radius: 100px;
        font-family: 'DM Sans', sans-serif;
        font-size: 14px; font-weight: 500;
        color: var(--black); text-decoration: none;
        transition: border-color 0.2s, background 0.2s;
        margin-bottom: 24px;
    }

    .phone-btn:hover { border-color: var(--green); background: var(--green-light); }
    .phone-btn svg { width: 18px; height: 18px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

    /* Bottom link */
    .bottom-link {
        text-align: center;
        font-size: 13px;
        color: var(--text-muted);
    }

    .bottom-link a { color: var(--green); font-weight: 600; text-decoration: none; }
    .bottom-link a:hover { color: var(--green-dark); }

    /* Perks strip */
    .perks-strip {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-bottom: 28px;
        flex-wrap: wrap;
    }

    .perk {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        color: var(--text-muted);
        font-weight: 500;
    }

    .perk-dot {
        width: 6px; height: 6px;
        background: var(--green);
        border-radius: 50%;
        flex-shrink: 0;
    }

    @keyframes fadeUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes spin { to { transform: rotate(360deg); } }

    @media (max-width: 520px) {
        .register-card { padding: 36px 24px; }
    }
</style>

<div class="register-wrapper">
    <div class="register-card">

        <!-- Logo -->
        <div class="card-logo">
            <div class="logo-icon"><div class="logo-dot"></div></div>
            <span class="logo-text">OptiDrive</span>
        </div>

        <!-- Header -->
        <div class="card-header">
            <h1>Create your account</h1>
            <p>Join thousands of commuters saving money on every ride in Accra</p>
        </div>

        <!-- Perks -->
        <div class="perks-strip">
            <div class="perk"><div class="perk-dot"></div> Free forever</div>
            <div class="perk"><div class="perk-dot"></div> Real-time prices</div>
            <div class="perk"><div class="perk-dot"></div> Save up to 30%</div>
        </div>

        <!-- Register Form -->
        <form method="POST" action="{{ route('register') }}" id="registerForm">
            @csrf

            <div class="field-group">
                <!-- Name -->
                <div>
                    <label class="field-label" for="name">Full Name</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="field-input {{ $errors->has('name') ? 'error' : '' }}"
                        placeholder="e.g. Kwame Mensah"
                        value="{{ old('name') }}"
                        required
                        autofocus
                        autocomplete="name"
                    />
                    @error('name')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="field-label" for="email">Email Address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="field-input {{ $errors->has('email') ? 'error' : '' }}"
                        placeholder="you@example.com"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                    />
                    @error('email')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label class="field-label" for="password">Password</label>
                    <div class="password-wrap">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="field-input {{ $errors->has('password') ? 'error' : '' }}"
                            placeholder="Min. 8 characters"
                            required
                            autocomplete="new-password"
                            oninput="checkStrength(this.value)"
                        />
                        <button type="button" class="password-toggle" onclick="togglePassword('password', 'eye1')">
                            <svg id="eye1" viewBox="0 0 24 24">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                    </div>
                    <!-- Password strength indicator -->
                    <div class="password-strength" id="strengthIndicator">
                        <div class="strength-bar">
                            <div class="strength-fill" id="strengthFill"></div>
                        </div>
                        <span class="strength-text" id="strengthText"></span>
                    </div>
                    @error('password')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="field-label" for="password_confirmation">Confirm Password</label>
                    <div class="password-wrap">
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="field-input"
                            placeholder="Repeat your password"
                            required
                            autocomplete="new-password"
                        />
                        <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation', 'eye2')">
                            <svg id="eye2" viewBox="0 0 24 24">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Terms -->
            <div class="terms-row">
                <input type="checkbox" id="terms" required>
                <label for="terms">
                    I agree to OptiDrive's <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
                </label>
            </div>

            <!-- Submit -->
            <button type="submit" class="register-btn" id="registerBtn">
                <span class="btn-label" id="btnLabel">Create Account</span>
                <div class="btn-spinner" id="btnSpinner"></div>
            </button>
        </form>

        <!-- Divider -->
        <div class="divider">
            <div class="divider-line"></div>
            <span class="divider-text">or sign up with</span>
            <div class="divider-line"></div>
        </div>

        <!-- Phone option -->
        <a href="{{ route('login') }}" class="phone-btn">
            <svg viewBox="0 0 24 24">
                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.44 2 2 0 0 1 3.6 1.25h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.96a16 16 0 0 0 6.29 6.29l.91-.91a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"></path>
            </svg>
            Sign up with Phone Number
        </a>

        <!-- Bottom link -->
        <div class="bottom-link">
            Already have an account? <a href="{{ route('signin') }}">Sign in</a>
        </div>

    </div>
</div>

<script>
    // Password toggle
    function togglePassword(fieldId, iconId) {
        const input = document.getElementById(fieldId);
        const icon  = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.innerHTML = `
                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                <line x1="1" y1="1" x2="23" y2="23"></line>`;
        } else {
            input.type = 'password';
            icon.innerHTML = `
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                <circle cx="12" cy="12" r="3"></circle>`;
        }
    }

    // Password strength checker
    function checkStrength(val) {
        const indicator = document.getElementById('strengthIndicator');
        const fill      = document.getElementById('strengthFill');
        const text      = document.getElementById('strengthText');

        if (!val) { indicator.style.display = 'none'; return; }
        indicator.style.display = 'block';

        let score = 0;
        if (val.length >= 8)              score++;
        if (/[A-Z]/.test(val))            score++;
        if (/[0-9]/.test(val))            score++;
        if (/[^A-Za-z0-9]/.test(val))     score++;

        const levels = [
            { pct: '25%', color: '#e53e3e', label: 'Weak' },
            { pct: '50%', color: '#dd6b20', label: 'Fair' },
            { pct: '75%', color: '#d69e2e', label: 'Good' },
            { pct: '100%', color: '#39C70D', label: 'Strong' },
        ];

        const level = levels[score - 1] || levels[0];
        fill.style.width     = level.pct;
        fill.style.background = level.color;
        text.textContent     = level.label;
        text.style.color     = level.color;
    }

    // Loading state on submit
    document.getElementById('registerForm').addEventListener('submit', function() {
        document.getElementById('btnLabel').classList.add('hide');
        document.getElementById('btnSpinner').classList.add('show');
        document.getElementById('registerBtn').disabled = true;
    });
</script>

@endsection