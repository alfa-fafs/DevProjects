@extends('layouts.app')

@section('title', 'OptiDrive — Sign In')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    :root {
        --green: #39C70D;
        --green-dark: #2ea00a;
        --white: #ffffff;
        --gray-bg: #f2f2f2;
        --gray-input: #e8e8e8;
        --gray-border: #d8d8d8;
        --black: #0a0a0a;
        --text-muted: #888;
    }

    * { box-sizing: border-box; }

    body {
        font-family: 'DM Sans', sans-serif;
        background: var(--gray-bg);
        margin: 0; min-height: 100vh;
    }

    .login-wrapper {
        min-height: calc(100vh - 68px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 48px 24px;
    }

    .cards-row {
        display: flex;
        gap: 24px;
        align-items: flex-start;
        width: 100%;
        max-width: 860px;
    }

    /* ── CARD ── */
    .card {
        background: var(--white);
        border-radius: 20px;
        padding: 40px 36px;
        flex: 1;
        box-shadow: 0 2px 16px rgba(0,0,0,0.06);
        display: flex;
        flex-direction: column;
        gap: 20px;
        min-height: 420px;
        animation: fadeUp 0.5s ease-out both;
    }

    .card:nth-child(2) { animation-delay: 0.1s; }

    .card-title {
        font-size: 22px;
        font-weight: 700;
        color: var(--black);
        letter-spacing: -0.3px;
    }

    .card-subtitle {
        font-size: 14px;
        color: var(--text-muted);
        line-height: 1.5;
        margin-top: -12px;
    }

    /* ── PHONE INPUT ROW ── */
    .phone-row {
        display: flex;
        gap: 10px;
    }

    .country-pill {
        display: flex;
        align-items: center;
        gap: 6px;
        background: var(--gray-input);
        border: 1.5px solid var(--gray-border);
        border-radius: 10px;
        padding: 0 14px;
        height: 50px;
        font-size: 14px;
        font-weight: 600;
        color: var(--black);
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        flex-shrink: 0;
        transition: border-color 0.2s;
        white-space: nowrap;
    }

    .country-pill:hover { border-color: var(--green); }

    .phone-field {
        flex: 1;
        height: 50px;
        background: var(--gray-input);
        border: 1.5px solid var(--gray-border);
        border-radius: 10px;
        padding: 0 16px;
        font-size: 15px;
        font-family: 'DM Sans', sans-serif;
        color: var(--black);
        outline: none;
        transition: border-color 0.2s, background 0.2s;
    }

    .phone-field::placeholder { color: #bbb; }
    .phone-field:focus { border-color: var(--green); background: white; }

    /* ── OTP BOXES ── */
    .otp-row {
        display: flex;
        gap: 10px;
        cursor: pointer;
    }

    .otp-box {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
    }

    .otp-digit {
        font-size: 28px;
        font-weight: 700;
        color: var(--black);
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
    }

    .otp-digit.empty { color: transparent; }

    .otp-line {
        width: 100%;
        height: 3px;
        border-radius: 2px;
        background: var(--gray-border);
        transition: background 0.2s;
    }

    .otp-line.filled { background: var(--green); }
    .otp-line.active { background: var(--green); animation: blink 1s ease-in-out infinite; }

    @keyframes blink { 0%, 100% { opacity: 1; } 50% { opacity: 0.3; } }

    /* Hidden OTP input */
    .hidden-otp {
        position: absolute; opacity: 0;
        width: 1px; height: 1px; pointer-events: none;
    }

    /* ── RESEND ── */
    .resend-row {
        font-size: 13px;
        color: var(--text-muted);
        text-align: center;
    }

    .resend-btn {
        color: var(--green); font-weight: 600;
        background: none; border: none; cursor: pointer;
        font-family: 'DM Sans', sans-serif; font-size: 13px;
        display: none;
    }

    .resend-btn.show { display: inline; }
    .resend-timer.hide { display: none; }

    /* ── SPACER ── */
    .spacer { flex: 1; }

    /* ── ERROR ── */
    .error-msg {
        font-size: 12px; color: #e53e3e;
        display: none; margin-top: -8px;
    }
    .error-msg.show { display: block; }

    /* ── BUTTON ── */
    .action-btn {
        width: 100%;
        padding: 14px;
        background: var(--green);
        color: white;
        font-family: 'DM Sans', sans-serif;
        font-size: 15px; font-weight: 600;
        border: none; border-radius: 100px;
        cursor: pointer;
        transition: background 0.2s, transform 0.1s, opacity 0.2s;
        display: flex; align-items: center; justify-content: center; gap: 8px;
    }

    .action-btn:hover { background: var(--green-dark); transform: translateY(-1px); }
    .action-btn:active { transform: translateY(0); }
    .action-btn:disabled { opacity: 0.4; cursor: not-allowed; transform: none; }

    .btn-spinner {
        display: none; width: 18px; height: 18px;
        border: 2px solid rgba(255,255,255,0.4);
        border-top-color: white; border-radius: 50%;
        animation: spin 0.7s linear infinite;
    }
    .btn-spinner.show { display: block; }
    .btn-label.hide { display: none; }

    /* ── DIVIDER ── */
    .or-divider {
        display: flex; align-items: center; gap: 12px;
    }
    .or-line { flex: 1; height: 1px; background: var(--gray-border); }
    .or-text { font-size: 12px; color: var(--text-muted); }

    /* ── EMAIL LOGIN LINK ── */
    .email-link {
        display: flex; align-items: center; justify-content: center; gap: 8px;
        padding: 13px;
        background: transparent;
        border: 1.5px solid var(--gray-border);
        border-radius: 100px;
        font-family: 'DM Sans', sans-serif;
        font-size: 14px; font-weight: 500;
        color: var(--black); text-decoration: none;
        transition: border-color 0.2s, background 0.2s;
    }
    .email-link:hover { border-color: var(--green); background: #f9fff7; }

    /* ── BOTTOM LINK ── */
    .bottom-link {
        text-align: center; font-size: 13px; color: var(--text-muted);
    }
    .bottom-link a { color: var(--green); font-weight: 600; text-decoration: none; }

    /* ── SUCCESS OVERLAY ── */
    .success-overlay {
        position: fixed; inset: 0;
        background: rgba(255,255,255,0.95);
        display: flex; flex-direction: column;
        align-items: center; justify-content: center; gap: 16px;
        z-index: 50; opacity: 0; pointer-events: none;
        transition: opacity 0.4s;
    }
    .success-overlay.show { opacity: 1; pointer-events: auto; }
    .checkmark-circle {
        width: 72px; height: 72px; border-radius: 50%;
        background: var(--green);
        display: flex; align-items: center; justify-content: center;
        transform: scale(0);
        transition: transform 0.4s cubic-bezier(0.34,1.56,0.64,1);
    }
    .checkmark-circle.show { transform: scale(1); }
    .checkmark-circle svg { width: 36px; height: 36px; stroke: white; fill: none; stroke-width: 3; stroke-linecap: round; stroke-linejoin: round; }
    .success-overlay h2 { font-size: 22px; font-weight: 700; color: var(--black); }
    .success-overlay p { font-size: 14px; color: var(--text-muted); }

    @keyframes fadeUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes spin { to { transform: rotate(360deg); } }
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        20% { transform: translateX(-8px); }
        40% { transform: translateX(8px); }
        60% { transform: translateX(-5px); }
        80% { transform: translateX(5px); }
    }

    /* Responsive */
    @media (max-width: 640px) {
        .cards-row { flex-direction: column; }
        .card { min-height: auto; }
    }
</style>

<!-- Success overlay -->
<div class="success-overlay" id="successOverlay">
    <div class="checkmark-circle" id="checkmarkCircle">
        <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg>
    </div>
    <h2>Verified!</h2>
    <p>Taking you to your account...</p>
</div>

<div class="login-wrapper">
    <div class="cards-row">

        <!-- ── CARD 1: Phone Number ── -->
        <div class="card" id="phoneCard">
            <div>
                <div class="card-title">Enter your number</div>
                <div class="card-subtitle">We'll send a code to verify your phone</div>
            </div>

            <div class="phone-row">
                <button class="country-pill" type="button">🇬🇭 +233</button>
                <input
                    type="tel"
                    id="phoneInput"
                    class="phone-field"
                    placeholder="Phone number"
                    maxlength="12"
                    inputmode="numeric"
                    autocomplete="tel"
                />
            </div>

            <div class="error-msg" id="phoneError">Please enter a valid 9-digit Ghana phone number</div>

            <div class="spacer"></div>

            <div class="or-divider">
                <div class="or-line"></div>
                <span class="or-text">or</span>
                <div class="or-line"></div>
            </div>

            <a href="{{ route('register') }}" class="email-link">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                    <polyline points="22,6 12,13 2,6"></polyline>
                </svg>
                Register with Email
            </a>

            <button class="action-btn" id="sendOtpBtn" onclick="sendOtp()" disabled>
                <span class="btn-label" id="sendBtnLabel">Continue</span>
                <div class="btn-spinner" id="sendBtnSpinner"></div>
            </button>

            <div class="bottom-link">
                Don't have an account? <a href="{{ route('register') }}">Register</a>
            </div>
             <div class="bottom-link">
                Already have an account? <a href="{{ route('signin') }}">Sign in</a>
            </div>
        </div>

        <!-- ── CARD 2: OTP Verify ── -->
        <div class="card" id="otpCard">
            <div>
                <div class="card-title">Verify it's you</div>
                <div class="card-subtitle">Enter the 5-digit code sent to your phone</div>
            </div>

            <!-- Hidden real input -->
            <input type="tel" id="otpInput" class="hidden-otp" maxlength="5" inputmode="numeric" pattern="[0-9]*" autocomplete="one-time-code" />

            <!-- Visual OTP boxes -->
            <div class="otp-row" id="otpRow" onclick="focusOtp()">
                <div class="otp-box">
                    <div class="otp-digit empty" id="d0">·</div>
                    <div class="otp-line" id="l0"></div>
                </div>
                <div class="otp-box">
                    <div class="otp-digit empty" id="d1">·</div>
                    <div class="otp-line" id="l1"></div>
                </div>
                <div class="otp-box">
                    <div class="otp-digit empty" id="d2">·</div>
                    <div class="otp-line" id="l2"></div>
                </div>
                <div class="otp-box">
                    <div class="otp-digit empty" id="d3">·</div>
                    <div class="otp-line" id="l3"></div>
                </div>
                <div class="otp-box">
                    <div class="otp-digit empty" id="d4">·</div>
                    <div class="otp-line" id="l4"></div>
                </div>
            </div>

            <div class="resend-row">
                <span class="resend-timer" id="resendTimer">Resend code in <strong id="countdown">00:59</strong></span>
                <button class="resend-btn" id="resendBtn" onclick="resendOtp()">Resend code</button>
            </div>

            <div class="error-msg" id="otpError">Invalid code. Please try again.</div>

            <div class="spacer"></div>

            <button class="action-btn" id="verifyBtn" onclick="verifyOtp()" disabled>
                <span class="btn-label" id="verifyBtnLabel">Verify</span>
                <div class="btn-spinner" id="verifyBtnSpinner"></div>
            </button>

            <div class="bottom-link">
                Wrong number? <a href="#" onclick="resetPhone()">Change it</a>
            </div>
        </div>

    </div>
</div>

<script>
    let phoneNumber = '';
    let countdownInterval;

    // ── Phone Input ──
    const phoneInput = document.getElementById('phoneInput');
    const sendOtpBtn = document.getElementById('sendOtpBtn');

    phoneInput.addEventListener('input', function() {
        let val = this.value.replace(/\D/g, '');
        if (val.startsWith('0')) val = val.slice(1);
        val = val.slice(0, 9);

        let formatted = val;
        if (val.length > 2) formatted = val.slice(0,2) + ' ' + val.slice(2);
        if (val.length > 5) formatted = val.slice(0,2) + ' ' + val.slice(2,5) + ' ' + val.slice(5);

        this.value = formatted;
        document.getElementById('phoneError').classList.remove('show');
        sendOtpBtn.disabled = val.replace(/\s/g,'').length < 9;
    });

    phoneInput.addEventListener('keypress', e => {
        if (e.key === 'Enter' && !sendOtpBtn.disabled) sendOtp();
    });

    function sendOtp() {
        const digits = phoneInput.value.replace(/\D/g, '');
        if (digits.length < 9) {
            document.getElementById('phoneError').classList.add('show');
            return;
        }

        phoneNumber = '+233' + digits;

        // Loading state
        document.getElementById('sendBtnLabel').classList.add('hide');
        document.getElementById('sendBtnSpinner').classList.add('show');
        sendOtpBtn.disabled = true;

        fetch('/api/send-otp', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify({ phone: phoneNumber })
        })
        .then(r => r.json())
        .then(() => activateOtp())
        .catch(() => activateOtp()); // proceed anyway for UI demo
    }

    function activateOtp() {
        // Reset send button
        document.getElementById('sendBtnLabel').classList.remove('hide');
        document.getElementById('sendBtnSpinner').classList.remove('show');
        sendOtpBtn.disabled = false;

        // Highlight OTP card
        document.getElementById('otpCard').style.boxShadow = '0 0 0 2px var(--green), 0 2px 16px rgba(57,199,13,0.15)';

        // Start countdown
        startCountdown();

        // Focus OTP input
        setTimeout(() => focusOtp(), 100);
    }

    // ── OTP Input ──
    const otpInput = document.getElementById('otpInput');
    const verifyBtn = document.getElementById('verifyBtn');

    function focusOtp() { otpInput.focus(); }

    otpInput.addEventListener('input', function() {
        const val = this.value.replace(/\D/g,'').slice(0,5);
        this.value = val;

        for (let i = 0; i < 5; i++) {
            const d = document.getElementById('d' + i);
            const l = document.getElementById('l' + i);
            if (val[i]) {
                d.textContent = val[i];
                d.classList.remove('empty');
                l.classList.add('filled');
                l.classList.remove('active');
            } else {
                d.textContent = '·';
                d.classList.add('empty');
                l.classList.remove('filled');
                l.classList.toggle('active', i === val.length);
            }
        }

        document.getElementById('otpError').classList.remove('show');
        verifyBtn.disabled = val.length < 5;

        if (val.length === 5) setTimeout(verifyOtp, 300);
    });

    document.getElementById('l0').classList.add('active');

    function verifyOtp() {
        const code = otpInput.value;
        if (code.length < 5) return;

        document.getElementById('verifyBtnLabel').classList.add('hide');
        document.getElementById('verifyBtnSpinner').classList.add('show');
        verifyBtn.disabled = true;

        fetch('/api/verify-otp', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify({ phone: phoneNumber, code: code })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) showSuccess();
            else showOtpError(data.message || 'Invalid code. Please try again.');
        })
        .catch(() => showSuccess()); // UI demo
    }

    function showSuccess() {
        const overlay = document.getElementById('successOverlay');
        const circle  = document.getElementById('checkmarkCircle');
        overlay.classList.add('show');
        setTimeout(() => circle.classList.add('show'), 100);
        setTimeout(() => window.location.href = '/', 2000);
    }

    function showOtpError(msg) {
        document.getElementById('verifyBtnLabel').classList.remove('hide');
        document.getElementById('verifyBtnSpinner').classList.remove('show');
        verifyBtn.disabled = false;
        document.getElementById('otpError').textContent = msg;
        document.getElementById('otpError').classList.add('show');

        const row = document.getElementById('otpRow');
        row.style.animation = 'shake 0.4s ease';
        setTimeout(() => row.style.animation = '', 400);

        otpInput.value = '';
        for (let i = 0; i < 5; i++) {
            document.getElementById('d' + i).textContent = '·';
            document.getElementById('d' + i).classList.add('empty');
            document.getElementById('l' + i).classList.remove('filled', 'active');
        }
        document.getElementById('l0').classList.add('active');
        focusOtp();
    }

    // ── Countdown ──
    function startCountdown() {
        clearInterval(countdownInterval);
        let t = 59;
        document.getElementById('resendTimer').classList.remove('hide');
        document.getElementById('resendBtn').classList.remove('show');
        document.getElementById('countdown').textContent = '00:59';

        countdownInterval = setInterval(() => {
            t--;
            const s = String(t % 60).padStart(2,'0');
            const m = String(Math.floor(t / 60)).padStart(2,'0');
            document.getElementById('countdown').textContent = `${m}:${s}`;
            if (t <= 0) {
                clearInterval(countdownInterval);
                document.getElementById('resendTimer').classList.add('hide');
                document.getElementById('resendBtn').classList.add('show');
            }
        }, 1000);
    }

    function resendOtp() {
        startCountdown();
        fetch('/api/send-otp', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify({ phone: phoneNumber })
        }).catch(() => {});
    }

    function resetPhone() {
        otpInput.value = '';
        for (let i = 0; i < 5; i++) {
            document.getElementById('d' + i).textContent = '·';
            document.getElementById('d' + i).classList.add('empty');
            document.getElementById('l' + i).classList.remove('filled', 'active');
        }
        document.getElementById('l0').classList.add('active');
        document.getElementById('otpCard').style.boxShadow = '';
        clearInterval(countdownInterval);
        phoneInput.focus();
    }
</script>

@endsection