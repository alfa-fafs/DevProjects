<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OptiDrive — Compare Rides, Save Money</title>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@700&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --green: #39C70D;
            --green-dark: #2ea00a;
            --white: #FFFFFF;
            --gray: #D9D9D9;
        }

        html, body {
            min-height: 100%;
             background: #111;
            display: flex;
            align-items: center;
            justify-content: center;
         padding: 20px 0;
         }
        .phone {
            width: 100%;
            max-width: 390px;
            height: 100vh;
            max-height: 844px;
            background: var(--green);
            border-radius: 44px;
            overflow: hidden;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            padding: 80px 28px 0;
            box-shadow: 0 32px 80px rgba(0,0,0,0.5);
        }

        /* Glow at top */
        .phone::before {
            content: '';
            position: absolute;
            top: -80px;
            left: 50%;
            transform: translateX(-50%);
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(255,255,255,0.12) 0%, transparent 70%);
            pointer-events: none;
        }

        /* Top Section */
        .top {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 16px;
            z-index: 2;
            animation: fadeDown 0.7s ease-out both;
        }

        .logo-box {
            width: 88px;
            height: 88px;
            background: white;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 30px rgba(0,0,0,0.15);
            animation: popIn 0.6s cubic-bezier(0.34,1.56,0.64,1) 0.15s both;
        }

        .logo-circle {
            width: 46px;
            height: 46px;
            background: var(--green);
            border-radius: 50%;
        }

        .app-name {
            font-family: 'Caveat', cursive;
            font-size: 44px;
            font-weight: 700;
            color: white;
            text-align: center;
            animation: fadeDown 0.6s ease-out 0.25s both;
        }

        .app-tagline {
            font-family: 'DM Sans', sans-serif;
            font-size: 15px;
            color: rgba(255,255,255,0.85);
            text-align: center;
            margin-top: -10px;
            animation: fadeDown 0.6s ease-out 0.35s both;
        }

        /* Car */
        .car-wrap {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: flex-end;
            animation: slideUp 0.9s cubic-bezier(0.22,1,0.36,1) 0.4s both;
            position: relative;
            z-index: 2;
            margin-bottom: -8px;
        }

        .car-wrap::before {
            content: '';
            position: absolute;
            bottom: 4px;
            left: 50%;
            transform: translateX(-50%);
            width: 260px;
            height: 20px;
            background: rgba(0,0,0,0.18);
            border-radius: 50%;
            filter: blur(10px);
        }

        .car-img {
            width: 92%;
            max-width: 360px;
            object-fit: contain;
            position: relative;
            z-index: 1;
        }

        /* Bottom Card */
        .bottom-card {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            border-radius: 32px 32px 0 0;
            padding: 32px 24px 44px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            animation: slideUpCard 0.8s cubic-bezier(0.22,1,0.36,1) 0.5s both;
            z-index: 10;
        }

        .bottom-card h2 {
            font-family: 'DM Sans', sans-serif;
            font-size: 20px;
            font-weight: 700;
            color: #000;
            text-align: center;
        }

        .bottom-card p {
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            color: #888;
            text-align: center;
            line-height: 1.6;
            margin-bottom: 4px;
        }

        .btn-green {
            display: block;
            width: 100%;
            padding: 15px;
            background: var(--green);
            color: white;
            font-family: 'DM Sans', sans-serif;
            font-size: 15px;
            font-weight: 600;
            border: none;
            border-radius: 12px;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
        }

        .btn-green:hover { background: var(--green-dark); transform: translateY(-1px); }
        .btn-green:active { transform: translateY(0); }

        .btn-outline {
            display: block;
            width: 100%;
            padding: 15px;
            background: transparent;
            color: #000;
            font-family: 'DM Sans', sans-serif;
            font-size: 15px;
            font-weight: 500;
            border: 2px solid var(--gray);
            border-radius: 12px;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            transition: border-color 0.2s, color 0.2s;
        }

        .btn-outline:hover { border-color: var(--green); color: var(--green); }

        .signin-hint {
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            color: #aaa;
            text-align: center;
            margin-top: 2px;
        }

        .signin-hint a {
            color: var(--green);
            font-weight: 600;
            text-decoration: none;
        }

        /* Animations */
        @keyframes fadeDown {
            from { opacity: 0; transform: translateY(-16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes popIn {
            from { opacity: 0; transform: scale(0.4); }
            to   { opacity: 1; transform: scale(1); }
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(50px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideUpCard {
            from { transform: translateY(100%); }
            to   { transform: translateY(0); }
        }

        /* Full screen on actual mobile */
        @media (max-width: 480px) {
            body { background: var(--green); }
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

    <!-- Logo + Name -->
    <div class="top">
        <div class="logo-box">
            <div class="logo-circle"></div>
        </div>
        <div>
            <div class="app-name">OptiDrive</div>
            <div class="app-tagline">Compare Rides, Save Money</div>
        </div>
    </div>

    <!-- Car Image -->
    <div class="car-wrap">
        {{-- Replace src with your actual car image path --}}
        <img
            src="https://www.freepnglogos.com/uploads/white-car-png/white-car-png-all-wheel-drive-cars-mazda-14.png"
            alt="Car"
            class="car-img"
        />
    </div>

    <!-- Bottom CTA Card -->
    <div class="bottom-card">
        <h2>Your Smartest Ride Starts Here</h2>
        <p>Compare Bolt, Uber, inDrive & Taxis in seconds. Always get the best price.</p>

        <a href="{{ route('onboarding') }}" class="btn-green">
            Get Started
        </a>

        <a href="{{ route('login') }}" class="btn-outline">
            I already have an account
        </a>

        <div class="signin-hint">
            By continuing you agree to our
            <a href="#">Terms</a> &amp; <a href="#">Privacy Policy</a>
        </div>
    </div>

</div>
</body>
</html>