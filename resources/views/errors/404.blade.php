<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OptiDrive — Page Not Found</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --green: #39C70D;
            --green-dark: #2ea00a;
            --green-light: #f0fde8;
            --white: #ffffff;
            --gray-bg: #f5f5f5;
            --black: #0a0a0a;
            --text-muted: #888;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--gray-bg);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 24px;
            position: relative;
            overflow: hidden;
        }

        /* Background decoration */
        .bg-circle-1 {
            position: fixed;
            top: -120px; right: -120px;
            width: 400px; height: 400px;
            background: var(--green);
            border-radius: 50%;
            opacity: 0.06;
            pointer-events: none;
        }

        .bg-circle-2 {
            position: fixed;
            bottom: -100px; left: -100px;
            width: 300px; height: 300px;
            background: var(--green);
            border-radius: 50%;
            opacity: 0.05;
            pointer-events: none;
        }

        /* Logo */
        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 48px;
            text-decoration: none;
            animation: fadeDown 0.6s ease-out both;
        }

        .logo-icon {
            width: 40px; height: 40px;
            background: white;
            border: 2px solid var(--green);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
        }

        .logo-dot {
            width: 20px; height: 20px;
            background: var(--green);
            border-radius: 50%;
        }

        .logo-text {
            font-size: 20px;
            font-weight: 700;
            color: var(--black);
        }

        /* Main content */
        .content {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            max-width: 480px;
            animation: fadeUp 0.6s ease-out 0.1s both;
        }

        /* 404 number */
        .error-number {
            font-size: clamp(100px, 20vw, 160px);
            font-weight: 800;
            letter-spacing: -8px;
            line-height: 1;
            margin-bottom: 16px;
            position: relative;
        }

        .error-number .four-left {
            color: var(--black);
        }

        .error-number .zero {
            color: var(--green);
            position: relative;
            display: inline-block;
        }

        /* Car inside the zero */
        .error-number .zero::after {
            content: '🚗';
            position: absolute;
            font-size: 40px;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            letter-spacing: 0;
            animation: carBounce 2s ease-in-out infinite;
        }

        @keyframes carBounce {
            0%, 100% { transform: translate(-50%, -50%); }
            50% { transform: translate(-50%, -60%); }
        }

        .error-number .four-right {
            color: var(--black);
        }

        /* Text */
        .error-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--black);
            margin-bottom: 12px;
            letter-spacing: -0.3px;
        }

        .error-desc {
            font-size: 15px;
            color: var(--text-muted);
            line-height: 1.7;
            margin-bottom: 36px;
        }

        /* Buttons */
        .btn-group {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--green);
            color: white;
            font-family: 'DM Sans', sans-serif;
            font-size: 15px;
            font-weight: 600;
            padding: 14px 28px;
            border-radius: 100px;
            text-decoration: none;
            transition: background 0.2s, transform 0.15s;
            box-shadow: 0 6px 20px rgba(57,199,13,0.35);
        }

        .btn-primary:hover { background: var(--green-dark); transform: translateY(-2px); }
        .btn-primary:active { transform: translateY(0); }

        .btn-primary svg {
            width: 16px; height: 16px;
            stroke: white; fill: none;
            stroke-width: 2.5;
            stroke-linecap: round; stroke-linejoin: round;
        }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: white;
            color: var(--black);
            font-family: 'DM Sans', sans-serif;
            font-size: 15px;
            font-weight: 500;
            padding: 14px 28px;
            border-radius: 100px;
            text-decoration: none;
            border: 1.5px solid #e0e0e0;
            transition: border-color 0.2s, transform 0.15s;
        }

        .btn-secondary:hover { border-color: var(--green); transform: translateY(-2px); }

        .btn-secondary svg {
            width: 16px; height: 16px;
            stroke: currentColor; fill: none;
            stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;
        }

        /* Quick links */
        .quick-links {
            margin-top: 48px;
            display: flex;
            gap: 24px;
            flex-wrap: wrap;
            justify-content: center;
            animation: fadeUp 0.6s ease-out 0.2s both;
        }

        .quick-link {
            font-size: 13px;
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }

        .quick-link:hover { color: var(--green); }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeDown {
            from { opacity: 0; transform: translateY(-20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    <!-- Background decorations -->
    <div class="bg-circle-1"></div>
    <div class="bg-circle-2"></div>

    <!-- Logo -->
    <a href="/" class="logo">
        <div class="logo-icon"><div class="logo-dot"></div></div>
        <span class="logo-text">OptiDrive</span>
    </a>

    <!-- Main content -->
    <div class="content">
        <!-- 404 -->
        <div class="error-number">
            <span class="four-left">4</span><span class="zero">0</span><span class="four-right">4</span>
        </div>

        <h1 class="error-title">Oops! This ride went off route</h1>
        <p class="error-desc">
            The page you're looking for doesn't exist or has been moved.
            Let's get you back on track!
        </p>

        <!-- Buttons -->
        <div class="btn-group">
            <a href="/" class="btn-primary">
                <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                Go Home
            </a>
            <a href="javascript:history.back()" class="btn-secondary">
                <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"></polyline></svg>
                Go Back
            </a>
        </div>
    </div>

    <!-- Quick links -->
    <div class="quick-links">
        <a href="/" class="quick-link">Compare Rides</a>
        <a href="/history" class="quick-link">Ride History</a>
        <a href="/help" class="quick-link">Help & Support</a>
        <a href="/settings" class="quick-link">Settings</a>
    </div>

</body>
</html>