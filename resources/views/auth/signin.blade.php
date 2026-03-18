@extends('layouts.app')

@section('title', 'OptiDrive — Sign In')

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

    .signin-wrapper {
        min-height: calc(100vh - 68px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 48px 24px;
    }

    .signin-card {
        background: var(--white);
        border-radius: 24px;
        padding: 48px 44px;
        width: 100%;
        max-width: 460px;
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

    /* Password field wrapper */
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

    .password-toggle svg { width: 18px; height: 18px; stroke: currentColor; fill: none; stroke-width: 2; }

    /* Remember + Forgot row */
    .form-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 28px;
    }

    .remember-label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: var(--text-muted);
        cursor: pointer;
    }

    .remember-label input[type="checkbox"] {
        width: 16px; height: 16px;
        accent-color: var(--green);
        cursor: pointer;
    }

    .forgot-link {
        font-size: 13px;
        color: var(--green);
        font-weight: 600;
        text-decoration: none;
    }

    .forgot-link:hover { color: var(--green-dark); }

    /* Error message */
    .error-msg {
        font-size: 12px;
        color: #e53e3e;
        margin-top: 6px;
        display: none;
    }
    .error-msg.show { display: block; }

    /* Session error banner */
    .session-error {
        background: #fff5f5;
        border: 1px solid #fed7d7;
        border-radius: 10px;
        padding: 12px 16px;
        font-size: 13px;
        color: #c53030;
        margin-bottom: 20px;
        display: none;
    }
    .session-error.show { display: block; }

    /* Submit button */
    .signin-btn {
        width: 100%;
        padding: 15px;
        background: var(--green);
        color: white;
        font-family: 'DM Sans', sans-serif;
        font-size: 15px;
        font-weight: 600;
        border: none;
        border-radius: 100px;
        cursor: pointer;
        transition: background 0.2s, transform 0.1s;
        display: flex; align-items: center; justify-content: center; gap: 8px;
        box-shadow: 0 4px 14px rgba(57,199,13,0.3);
        margin-bottom: 20px;
    }

    .signin-btn:hover { background: var(--green-dark); transform: translateY(-1px); }
    .signin-btn:active { transform: translateY(0); }

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

    /* Phone login option */
    .phone-btn {
        display: flex; align-items: center; justify-content: center; gap: 10px;
        width: 100%;
        padding: 14px;
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

    @keyframes fadeUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes spin { to { transform: rotate(360deg); } }
</style>

<div class="signin-wrapper">
    <div class="signin-card">

        <!-- Logo -->
        <div class="card-logo">
            <div class="logo-icon"><div class="logo-dot"></div></div>
            <span class="logo-text">OptiDrive</span>
        </div>

        <!-- Header -->
        <div class="card-header">
            <h1>Welcome back 👋</h1>
            <p>Sign in to your account to compare rides and save money</p>
        </div>

        <!-- Session error (shown by Laravel on failed login) -->
        @if (session('status'))
            <div class="session-error show">{{ session('status') }}</div>
        @endif

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}" id="loginForm">
            @csrf

            <div class="field-group">
                <!-- Email -->
                <div>
                    <label class="field-label" for="email">Email address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="field-input {{ $errors->has('email') ? 'error' : '' }}"
                        placeholder="you@example.com"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="email"
                    />
                    @error('email')
                        <div class="error-msg show">{{ $message }}</div>
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
                            placeholder="Enter your password"
                            required
                            autocomplete="current-password"
                        />
                        <button type="button" class="password-toggle" onclick="togglePassword()">
                            <svg id="eyeIcon" viewBox="0 0 24 24">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <div class="error-msg show">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Remember + Forgot -->
            <div class="form-meta">
                <label class="remember-label">
                    <input type="checkbox" name="remember" id="remember">
                    Remember me
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
                @endif
            </div>

            <!-- Submit -->
            <button type="submit" class="signin-btn" id="signinBtn">
                <span class="btn-label" id="btnLabel">Sign In</span>
                <div class="btn-spinner" id="btnSpinner"></div>
            </button>
        </form>

        <!-- Divider -->
        <div class="divider">
            <div class="divider-line"></div>
            <span class="divider-text">or sign in with</span>
            <div class="divider-line"></div>
        </div>

        <!-- Phone login option -->
        <a href="{{ route('login') }}" class="phone-btn">
            <svg viewBox="0 0 24 24">
                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.44 2 2 0 0 1 3.6 1.25h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.96a16 16 0 0 0 6.29 6.29l.91-.91a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"></path>
            </svg>
            Sign in with Phone Number
        </a>

        <!-- Bottom link -->
        <div class="bottom-link">
            Don't have an account? <a href="{{ route('register') }}">Create one free</a>
        </div>

    </div>
</div>

<script>
    // Password toggle
    function togglePassword() {
        const input = document.getElementById('password');
        const icon  = document.getElementById('eyeIcon');
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

    // Loading state on submit
    document.getElementById('loginForm').addEventListener('submit', function() {
        document.getElementById('btnLabel').classList.add('hide');
        document.getElementById('btnSpinner').classList.add('show');
        document.getElementById('signinBtn').disabled = true;
    });
</script>

@endsection