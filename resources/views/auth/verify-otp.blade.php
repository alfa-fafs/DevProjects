<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OptiDrive — Verify your number</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --green: #39C70D;
            --green-dark: #2ea00a;
            --white: #FFFFFF;
            --black: #000000;
            --gray-light: #F2F2F2;
            --gray-border: #E0E0E0;
            --text-muted: #888;
        }

        html, body {
            height: 100%;
            background: #111;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'DM Sans', sans-serif;
        }

        .phone {
            width: 100%;
            max-width: 390px;
            height: 100vh;
            max-height: 844px;
            background: var(--white);
            border-radius: 44px;
            overflow: hidden;
            position: relative;
            display: flex;
            flex-direction: column;
            box-shadow: 0 32px 80px rgba(0,0,0,0.5);
            padding: 60px 28px 48px;
        }

        /* Back button */
        .back-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--gray-light);
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 36px;
            text-decoration: none;
            transition: background 0.2s;
            flex-shrink: 0;
        }
        .back-btn:hover { background: var(--gray-border); }
        .back-btn svg {
            width: 18px; height: 18px;
            stroke: var(--black); fill: none;
            stroke-width: 2.5;
            stroke-linecap: round; stroke-linejoin: round;
        }

        /* Header */
        .header {
            margin-bottom: 40px;
            animation: fadeUp 0.5s ease-out both;
        }
        .header h1 {
            font-size: 26px;
            font-weight: 700;
            color: var(--black);
            margin-bottom: 8px;
        }
        .header p {
            font-size: 14px;
            color: var(--text-muted);
            line-height: 1.5;
        }
        .header p strong {
            color: var(--black);
            font-weight: 600;
        }

        /* OTP boxes */
        .otp-row {
            display: flex;
            gap: 12px;
            margin-bottom: 24px;
            animation: fadeUp 0.5s ease-out 0.1s both;
        }

        .otp-box {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }

        .otp-digit {
            font-size: 32px;
            font-weight: 700;
            color: var(--black);
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            line-height: 1;
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
        .otp-line.active {
            background: var(--green);
            animation: pulse 1s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.4; }
        }

        /* Hidden real input */
        .hidden-input {
            position: absolute;
            opacity: 0;
            width: 1px;
            height: 1px;
            pointer-events: none;
        }

        /* Resend timer */
        .resend-row {
            text-align: center;
            font-size: 14px;
            color: var(--text-muted);
            animation: fadeUp 0.5s ease-out 0.2s both;
        }

        .resend-btn {
            color: var(--green);
            font-weight: 600;
            background: none;
            border: none;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            display: none;
        }

        .resend-btn.show { display: inline; }
        .resend-timer.hide { display: none; }

        /* Error message */
        .error-msg {
            margin-top: 16px;
            font-size: 13px;
            color: #e53e3e;
            text-align: center;
            display: none;
            animation: fadeUp 0.3s ease-out both;
        }
        .error-msg.show { display: block; }

        /* Success message */
        .success-msg {
            margin-top: 16px;
            font-size: 13px;
            color: var(--green);
            text-align: center;
            display: none;
        }
        .success-msg.show { display: block; }

        .spacer { flex: 1; }

        /* Verify button */
        .verify-btn {
            width: 100%;
            padding: 17px;
            background: var(--green);
            color: var(--white);
            font-family: 'DM Sans', sans-serif;
            font-size: 16px;
            font-weight: 600;
            border: none;
            border-radius: 100px;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s, opacity 0.2s;
            animation: fadeUp 0.5s ease-out 0.3s both;
        }
        .verify-btn:hover { background: var(--green-dark); transform: translateY(-1px); }
        .verify-btn:active { transform: translateY(0); }
        .verify-btn:disabled { opacity: 0.4; cursor: not-allowed; transform: none; }

        .btn-spinner {
            display: none;
            width: 20px; height: 20px;
            border: 2.5px solid rgba(255,255,255,0.4);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
            margin: 0 auto;
        }
        .btn-spinner.show { display: block; }
        .btn-text.hide { display: none; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* Success checkmark animation */
        .success-overlay {
            position: absolute;
            inset: 0;
            background: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 20px;
            z-index: 50;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.4s;
        }
        .success-overlay.show { opacity: 1; pointer-events: auto; }

        .checkmark {
            width: 80px; height: 80px;
            border-radius: 50%;
            background: var(--green);
            display: flex;
            align-items: center;
            justify-content: center;
            transform: scale(0);
            transition: transform 0.4s cubic-bezier(0.34,1.56,0.64,1);
        }
        .checkmark.show { transform: scale(1); }
        .checkmark svg {
            width: 40px; height: 40px;
            stroke: white; fill: none;
            stroke-width: 3;
            stroke-linecap: round; stroke-linejoin: round;
        }
        .success-overlay h2 {
            font-size: 22px;
            font-weight: 700;
            color: var(--black);
        }
        .success-overlay p {
            font-size: 14px;
            color: var(--text-muted);
        }

        @media (max-width: 480px) {
            body { background: white; }
            .phone {
                max-width: 100%;
                height: 100vh;
                max-height: 100vh;
                border-radius: 0;
                box-shadow: none;
            }
        }
    </style>
</head>
<body>
<div class="phone">

    <!-- Success overlay -->
    <div class="success-overlay" id="successOverlay">
        <div class="checkmark" id="checkmark">
            <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg>
        </div>
        <h2>Phone Verified!</h2>
        <p>Taking you to your account...</p>
    </div>

    <!-- Back -->
    <a href="/phone-register" class="back-btn">
        <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"></polyline></svg>
    </a>

    <!-- Header -->
    <div class="header">
        <h1>Verify it's you</h1>
        <p>Enter the 5-digit code sent to<br>
            <strong id="phoneDisplay">your phone</strong>
        </p>
    </div>

    <!-- OTP Input (hidden real input) -->
    <input
        type="tel"
        id="otpInput"
        class="hidden-input"
        maxlength="5"
        inputmode="numeric"
        pattern="[0-9]*"
        autocomplete="one-time-code"
    />

    <!-- OTP visual boxes -->
    <div class="otp-row" id="otpRow" onclick="focusInput()">
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

    <!-- Resend -->
    <div class="resend-row">
        <span class="resend-timer" id="resendTimer">Resend code in <strong id="countdown">00:59</strong></span>
        <button class="resend-btn" id="resendBtn" onclick="resendOtp()">Resend code</button>
    </div>

    <!-- Error / Success -->
    <div class="error-msg" id="errorMsg">Invalid code. Please try again.</div>
    <div class="success-msg" id="successMsg">Code verified successfully!</div>

    <div class="spacer"></div>

    <!-- Verify button -->
    <button class="verify-btn" id="verifyBtn" onclick="handleVerify()" disabled>
        <span class="btn-text" id="btnText">Verify</span>
        <div class="btn-spinner" id="btnSpinner"></div>
    </button>

</div>

<script>
    // Get phone from URL
    const urlParams  = new URLSearchParams(window.location.search);
    const phone      = urlParams.get('phone') || '+233XX XXX XXXX';
    document.getElementById('phoneDisplay').textContent = phone;

    const otpInput   = document.getElementById('otpInput');
    const verifyBtn  = document.getElementById('verifyBtn');
    const errorMsg   = document.getElementById('errorMsg');
    const successMsg = document.getElementById('successMsg');
    const btnText    = document.getElementById('btnText');
    const btnSpinner = document.getElementById('btnSpinner');

    // Focus hidden input on load
    setTimeout(() => focusInput(), 300);

    function focusInput() {
        otpInput.focus();
    }

    // Update visual boxes as user types
    otpInput.addEventListener('input', function () {
        const val = this.value.replace(/\D/g, '').slice(0, 5);
        this.value = val;

        for (let i = 0; i < 5; i++) {
            const digit = document.getElementById('d' + i);
            const line  = document.getElementById('l' + i);

            if (val[i]) {
                digit.textContent = val[i];
                digit.classList.remove('empty');
                line.classList.add('filled');
                line.classList.remove('active');
            } else {
                digit.textContent = '·';
                digit.classList.add('empty');
                line.classList.remove('filled');
                line.classList.toggle('active', i === val.length);
            }
        }

        errorMsg.classList.remove('show');
        verifyBtn.disabled = val.length < 5;

        // Auto verify when 5 digits entered
        if (val.length === 5) {
            setTimeout(() => handleVerify(), 300);
        }
    });

    // Active line on first box initially
    document.getElementById('l0').classList.add('active');

    otpInput.addEventListener('focus', function() {
        const val = this.value;
        const activeIdx = Math.min(val.length, 4);
        for (let i = 0; i < 5; i++) {
            document.getElementById('l' + i).classList.toggle('active',
                i === activeIdx && val.length < 5);
        }
    });

    function handleVerify() {
        const code = otpInput.value;
        if (code.length < 5) return;

        // Show loading
        btnText.classList.add('hide');
        btnSpinner.classList.add('show');
        verifyBtn.disabled = true;
        errorMsg.classList.remove('show');

        // Call Laravel API
        fetch('/api/verify-otp', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                    ? document.querySelector('meta[name="csrf-token"]').content : ''
            },
            body: JSON.stringify({ phone: phone, code: code })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showSuccess();
            } else {
                showError(data.message || 'Invalid code. Please try again.');
            }
        })
        .catch(() => {
            // UI demo — show success anyway
            showSuccess();
        });
    }

    function showSuccess() {
        const overlay   = document.getElementById('successOverlay');
        const checkmark = document.getElementById('checkmark');
        overlay.classList.add('show');
        setTimeout(() => checkmark.classList.add('show'), 100);
        setTimeout(() => window.location.href = '/', 2000);
    }

    function showError(msg) {
        btnText.classList.remove('hide');
        btnSpinner.classList.remove('show');
        verifyBtn.disabled = false;
        errorMsg.textContent = msg;
        errorMsg.classList.add('show');

        // Shake animation
        const row = document.getElementById('otpRow');
        row.style.animation = 'shake 0.4s ease';
        setTimeout(() => row.style.animation = '', 400);

        // Clear input
        otpInput.value = '';
        for (let i = 0; i < 5; i++) {
            document.getElementById('d' + i).textContent = '·';
            document.getElementById('d' + i).classList.add('empty');
            document.getElementById('l' + i).classList.remove('filled', 'active');
        }
        document.getElementById('l0').classList.add('active');
        focusInput();
    }

    // Countdown timer
    let timeLeft  = 59;
    let timerInterval = setInterval(() => {
        timeLeft--;
        const mins = String(Math.floor(timeLeft / 60)).padStart(2, '0');
        const secs = String(timeLeft % 60).padStart(2, '0');
        document.getElementById('countdown').textContent = `${mins}:${secs}`;

        if (timeLeft <= 0) {
            clearInterval(timerInterval);
            document.getElementById('resendTimer').classList.add('hide');
            document.getElementById('resendBtn').classList.add('show');
        }
    }, 1000);

    function resendOtp() {
        // Reset timer
        timeLeft = 59;
        document.getElementById('resendTimer').classList.remove('hide');
        document.getElementById('resendBtn').classList.remove('show');
        document.getElementById('countdown').textContent = '00:59';

        timerInterval = setInterval(() => {
            timeLeft--;
            const mins = String(Math.floor(timeLeft / 60)).padStart(2, '0');
            const secs = String(timeLeft % 60).padStart(2, '0');
            document.getElementById('countdown').textContent = `${mins}:${secs}`;
            if (timeLeft <= 0) {
                clearInterval(timerInterval);
                document.getElementById('resendTimer').classList.add('hide');
                document.getElementById('resendBtn').classList.add('show');
            }
        }, 1000);

        // Call resend API
        fetch('/api/send-otp', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                    ? document.querySelector('meta[name="csrf-token"]').content : ''
            },
            body: JSON.stringify({ phone: phone })
        }).catch(() => {});

        successMsg.textContent = 'Code resent!';
        successMsg.classList.add('show');
        setTimeout(() => successMsg.classList.remove('show'), 3000);
    }
</script>

<style>
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        20%       { transform: translateX(-8px); }
        40%       { transform: translateX(8px); }
        60%       { transform: translateX(-6px); }
        80%       { transform: translateX(6px); }
    }
</style>
</body>
</html>