<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OptiDrive — Enter your number</title>
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
            width: 18px;
            height: 18px;
            stroke: var(--black);
            fill: none;
            stroke-width: 2.5;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        /* Header */
        .header {
            margin-bottom: 36px;
            flex-shrink: 0;
            animation: fadeUp 0.5s ease-out both;
        }

        .header h1 {
            font-size: 26px;
            font-weight: 700;
            color: var(--black);
            margin-bottom: 8px;
            line-height: 1.2;
        }

        .header p {
            font-size: 14px;
            color: var(--text-muted);
            line-height: 1.5;
        }

        /* Phone input row */
        .input-row {
            display: flex;
            gap: 10px;
            margin-bottom: 16px;
            animation: fadeUp 0.5s ease-out 0.1s both;
        }

        /* Country code pill */
        .country-code {
            display: flex;
            align-items: center;
            gap: 6px;
            background: var(--gray-light);
            border: 1.5px solid var(--gray-border);
            border-radius: 12px;
            padding: 0 16px;
            height: 56px;
            cursor: pointer;
            flex-shrink: 0;
            transition: border-color 0.2s;
            font-size: 15px;
            font-weight: 600;
            color: var(--black);
            font-family: 'DM Sans', sans-serif;
        }

        .country-code:hover { border-color: var(--green); }

        .country-flag {
            font-size: 20px;
        }

        .country-chevron {
            width: 14px;
            height: 14px;
            stroke: #999;
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        /* Phone number input */
        .phone-input {
            flex: 1;
            height: 56px;
            background: var(--gray-light);
            border: 1.5px solid var(--gray-border);
            border-radius: 12px;
            padding: 0 18px;
            font-size: 16px;
            font-family: 'DM Sans', sans-serif;
            color: var(--black);
            outline: none;
            transition: border-color 0.2s, background 0.2s;
        }

        .phone-input::placeholder { color: #bbb; }

        .phone-input:focus {
            border-color: var(--green);
            background: white;
        }

        /* Error message */
        .error-msg {
            font-size: 12px;
            color: #e53e3e;
            margin-bottom: 12px;
            display: none;
            animation: fadeUp 0.3s ease-out both;
        }

        .error-msg.show { display: block; }

        /* Helper text */
        .helper-text {
            font-size: 12px;
            color: var(--text-muted);
            line-height: 1.5;
            animation: fadeUp 0.5s ease-out 0.2s both;
        }

        .helper-text a {
            color: var(--green);
            text-decoration: none;
            font-weight: 500;
        }

        /* Spacer */
        .spacer { flex: 1; }

        /* Continue button */
        .continue-btn {
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

        .continue-btn:hover { background: var(--green-dark); transform: translateY(-1px); }
        .continue-btn:active { transform: translateY(0); }
        .continue-btn:disabled {
            opacity: 0.45;
            cursor: not-allowed;
            transform: none;
        }

        /* Loading spinner inside button */
        .btn-spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 2.5px solid rgba(255,255,255,0.4);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
            margin: 0 auto;
        }

        .btn-spinner.show { display: block; }
        .btn-text.hide { display: none; }

        /* Keyboard number pad hint */
        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 24px 0;
            animation: fadeUp 0.5s ease-out 0.25s both;
        }

        .divider-line {
            flex: 1;
            height: 1px;
            background: var(--gray-border);
        }

        .divider span {
            font-size: 12px;
            color: var(--text-muted);
        }

        /* Social auth options */
        .social-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            padding: 14px;
            background: transparent;
            border: 1.5px solid var(--gray-border);
            border-radius: 12px;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 500;
            color: var(--black);
            cursor: pointer;
            transition: border-color 0.2s, background 0.2s;
            text-decoration: none;
            animation: fadeUp 0.5s ease-out 0.35s both;
            margin-bottom: 12px;
        }

        .social-btn:hover {
            border-color: var(--green);
            background: #f9fff7;
        }

        .social-btn img {
            width: 20px;
            height: 20px;
        }

        /* Sign in link */
        .signin-link {
            text-align: center;
            font-size: 13px;
            color: var(--text-muted);
            margin-top: 16px;
            animation: fadeUp 0.5s ease-out 0.4s both;
        }

        .signin-link a {
            color: var(--green);
            font-weight: 600;
            text-decoration: none;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Full screen on mobile */
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

    <!-- Back -->
    <a href="{{ route('onboarding') }}" class="back-btn">
        <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"></polyline></svg>
    </a>

    <!-- Header -->
    <div class="header">
        <h1>Enter your number</h1>
        <p>We'll send a code to verify your phone</p>
    </div>

    <!-- Phone input -->
    <div class="input-row">
        <button class="country-code" type="button" id="countryBtn">
            <span class="country-flag">🇬🇭</span>
            <span>+233</span>
            <svg class="country-chevron" viewBox="0 0 24 24">
                <polyline points="6 9 12 15 18 9"></polyline>
            </svg>
        </button>
        <input
            type="tel"
            id="phoneInput"
            class="phone-input"
            placeholder="XX XXX XXXX"
            maxlength="10"
            inputmode="numeric"
            pattern="[0-9]*"
            autocomplete="tel"
        />
    </div>

    <!-- Error -->
    <div class="error-msg" id="errorMsg">
        Please enter a valid 9-digit Ghana phone number
    </div>

    <!-- Helper -->
    <p class="helper-text">
        By continuing, you agree to our
        <a href="#">Terms of Service</a> and
        <a href="#">Privacy Policy</a>
    </p>

    <div class="spacer"></div>

    <!-- Divider -->
    <div class="divider">
        <div class="divider-line"></div>
        <span>or continue with</span>
        <div class="divider-line"></div>
    </div>

    <!-- Email login option -->
    <a href="{{ route('login') }}" class="social-btn">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
            <polyline points="22,6 12,13 2,6"></polyline>
        </svg>
        Continue with Email
    </a>

    <!-- Continue button -->
    <button class="continue-btn" id="continueBtn" onclick="handleContinue()">
        <span class="btn-text" id="btnText">Continue</span>
        <div class="btn-spinner" id="btnSpinner"></div>
    </button>

    <!-- Sign in link -->
    <div class="signin-link">
        Already have an account? <a href="{{ route('login') }}">Sign in</a>
    </div>

</div>

<script>
    const phoneInput  = document.getElementById('phoneInput');
    const continueBtn = document.getElementById('continueBtn');
    const errorMsg    = document.getElementById('errorMsg');
    const btnText     = document.getElementById('btnText');
    const btnSpinner  = document.getElementById('btnSpinner');

    // Format input as user types
    phoneInput.addEventListener('input', function () {
        // Strip non-digits
        let val = this.value.replace(/\D/g, '');

        // Remove leading 0 for display (Ghana numbers)
        if (val.startsWith('0')) val = val.slice(1);

        // Limit to 9 digits
        val = val.slice(0, 9);

        // Format: XX XXX XXXX
        let formatted = val;
        if (val.length > 2)  formatted = val.slice(0,2) + ' ' + val.slice(2);
        if (val.length > 5)  formatted = val.slice(0,2) + ' ' + val.slice(2,5) + ' ' + val.slice(5);

        this.value = formatted;

        // Hide error on input
        errorMsg.classList.remove('show');

        // Enable/disable button
        const digits = val.replace(/\s/g, '');
        continueBtn.disabled = digits.length < 9;
    });

    // Initially disabled
    continueBtn.disabled = true;

    function handleContinue() {
        const digits = phoneInput.value.replace(/\D/g, '');

        if (digits.length < 9) {
            errorMsg.classList.add('show');
            phoneInput.focus();
            return;
        }

        // Show loading
        btnText.classList.add('hide');
        btnSpinner.classList.add('show');
        continueBtn.disabled = true;

        // Simulate sending OTP — replace with actual Laravel call
        const fullPhone = '+233' + digits;

        fetch('/api/send-otp', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]') 
                    ? document.querySelector('meta[name="csrf-token"]').content 
                    : ''
            },
            body: JSON.stringify({ phone: fullPhone })
        })
        .then(res => res.json())
        .then(data => {
            // Redirect to OTP verification screen
            window.location.href = '/verify-otp?phone=' + encodeURIComponent(fullPhone);
        })
        .catch(err => {
            // For now just redirect (OTP not wired yet)
            window.location.href = '/verify-otp?phone=' + encodeURIComponent(fullPhone);
        });
    }

    // Allow Enter key
    phoneInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') handleContinue();
    });
</script>
</body>
</html>