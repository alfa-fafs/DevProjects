@extends('layouts.app')

@section('title', 'OptiDrive — Compare Rides Instantly')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">

<style>
    :root {
        --green: #39C70D;
        --green-dark: #2ea00a;
        --green-light: #f0fde8;
        --black: #0a0a0a;
        --gray: #f4f4f4;
        --text-muted: #666;
        --white: #ffffff;
    }

    * { box-sizing: border-box; }
    body { font-family: 'DM Sans', sans-serif; background: var(--white); color: var(--black); margin: 0; }

    /* ── NAVBAR ── */
    .landing-nav {
        display: flex; align-items: center; justify-content: space-between;
        padding: 0 48px; height: 68px; background: var(--white);
        border-bottom: 1px solid #f0f0f0; position: sticky; top: 0; z-index: 100;
    }
    .nav-logo { display: flex; align-items: center; gap: 10px; text-decoration: none; }
    .nav-logo-icon {
        width: 40px; height: 40px; background: var(--white);
        border: 2px solid var(--green); border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
    }
    .nav-logo-dot { width: 20px; height: 20px; background: var(--green); border-radius: 50%; }
    .nav-logo-text { font-size: 20px; font-weight: 700; color: var(--black); letter-spacing: -0.3px; }
    .nav-links { display: flex; align-items: center; gap: 32px; }
    .nav-link { font-size: 14px; font-weight: 500; color: var(--text-muted); text-decoration: none; transition: color 0.2s; }
    .nav-link:hover { color: var(--green); }
    .nav-cta {
        background: var(--green); color: var(--white); font-family: 'DM Sans', sans-serif;
        font-size: 14px; font-weight: 600; padding: 10px 24px; border-radius: 100px;
        text-decoration: none; border: none; cursor: pointer;
        transition: background 0.2s, transform 0.1s;
        box-shadow: 0 4px 14px rgba(57,199,13,0.3);
    }
    .nav-cta:hover { background: var(--green-dark); transform: translateY(-1px); }

    /* ── HERO ── */
    .hero {
        display: grid; grid-template-columns: 1fr 1fr;
        min-height: 420px; margin: 32px 48px;
        border-radius: 24px; overflow: hidden;
        box-shadow: 0 8px 40px rgba(0,0,0,0.08);
        animation: fadeUp 0.6s ease-out both;
    }
    .hero-left {
        background: var(--white); padding: 56px 48px;
        display: flex; flex-direction: column; justify-content: center; gap: 20px;
        border: 1px solid #f0f0f0; border-right: none; border-radius: 24px 0 0 24px;
    }
    .hero-eyebrow {
        display: inline-flex; align-items: center; gap: 6px;
        background: var(--green-light); color: var(--green-dark);
        font-size: 12px; font-weight: 600; padding: 5px 12px;
        border-radius: 100px; width: fit-content;
        letter-spacing: 0.3px; text-transform: uppercase;
    }
    .hero-eyebrow::before { content: ''; width: 6px; height: 6px; background: var(--green); border-radius: 50%; }
    .hero-headline { font-size: clamp(32px, 4vw, 48px); font-weight: 800; color: var(--black); line-height: 1.15; letter-spacing: -1px; }
    .hero-headline .accent { color: var(--green); }
    .hero-desc { font-size: 15px; color: var(--text-muted); line-height: 1.7; max-width: 380px; }
    .hero-cta {
        display: inline-flex; align-items: center; gap: 8px;
        background: var(--green); color: var(--white);
        font-family: 'DM Sans', sans-serif; font-size: 15px; font-weight: 600;
        padding: 14px 28px; border-radius: 100px; text-decoration: none; width: fit-content;
        transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
        box-shadow: 0 6px 20px rgba(57,199,13,0.35);
    }
    .hero-cta:hover { background: var(--green-dark); transform: translateY(-2px); box-shadow: 0 10px 28px rgba(57,199,13,0.4); }
    .hero-cta svg { width: 16px; height: 16px; stroke: white; fill: none; stroke-width: 2.5; transition: transform 0.2s; }
    .hero-cta:hover svg { transform: translateX(3px); }

    .hero-stats { display: flex; gap: 28px; margin-top: 8px; }
    .stat { display: flex; flex-direction: column; gap: 2px; }
    .stat-num { font-size: 22px; font-weight: 800; color: var(--black); letter-spacing: -0.5px; }
    .stat-label { font-size: 11px; color: var(--text-muted); font-weight: 500; }
    .stat-divider { width: 1px; background: #e8e8e8; align-self: stretch; }

    .hero-right {
        background: var(--green); position: relative;
        display: flex; align-items: center; justify-content: center;
        overflow: hidden; border-radius: 0 24px 24px 0;
    }
    .hero-right::before {
        content: ''; position: absolute; inset: 0;
        background-image: radial-gradient(circle at 20% 50%, rgba(255,255,255,0.08) 0%, transparent 60%);
    }
    .hero-car {
        width: 90%; max-width: 420px; object-fit: contain;
        position: relative; z-index: 2;
        filter: drop-shadow(0 20px 40px rgba(0,0,0,0.2));
        animation: floatCar 4s ease-in-out infinite;
    }
    @keyframes floatCar {
        0%, 100% { transform: translateY(0px); }
        50%       { transform: translateY(-10px); }
    }
    .car-shadow {
        position: absolute; bottom: 24px; left: 50%; transform: translateX(-50%);
        width: 60%; height: 16px; background: rgba(0,0,0,0.15);
        border-radius: 50%; filter: blur(8px);
        animation: shadowPulse 4s ease-in-out infinite; z-index: 1;
    }
    @keyframes shadowPulse {
        0%, 100% { transform: translateX(-50%) scaleX(1); opacity: 0.15; }
        50%       { transform: translateX(-50%) scaleX(0.85); opacity: 0.1; }
    }
    .provider-badges {
        position: absolute; top: 24px; left: 24px;
        display: flex; flex-direction: column; gap: 8px; z-index: 3;
    }
    .provider-badge {
        background: rgba(255,255,255,0.92); backdrop-filter: blur(8px);
        border-radius: 20px; padding: 6px 12px 6px 8px;
        display: flex; align-items: center; gap: 6px;
        font-size: 12px; font-weight: 600; color: var(--black);
        box-shadow: 0 2px 12px rgba(0,0,0,0.1);
        animation: badgeFloat 0.5s ease-out both;
    }
    .provider-badge:nth-child(1) { animation-delay: 0.8s; }
    .provider-badge:nth-child(2) { animation-delay: 1.0s; }
    .provider-badge:nth-child(3) { animation-delay: 1.2s; }
    @keyframes badgeFloat {
        from { opacity: 0; transform: translateX(-12px); }
        to   { opacity: 1; transform: translateX(0); }
    }
    .badge-dot { width: 8px; height: 8px; border-radius: 50%; }
    .badge-price { color: var(--green-dark); font-weight: 700; }

    /* ── PROVIDERS STRIP ── */
    .providers-strip {
        background: var(--gray); padding: 28px 48px;
        display: flex; align-items: center; justify-content: center;
        gap: 48px; flex-wrap: wrap;
    }
    .providers-strip .label { font-size: 13px; color: var(--text-muted); font-weight: 500; white-space: nowrap; }
    .provider-pill {
        display: flex; align-items: center; gap: 8px;
        background: white; border-radius: 100px; padding: 8px 16px;
        font-size: 14px; font-weight: 600; color: var(--black);
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }

    /* ── WHY SECTION ── */
    .why-section { padding: 64px 48px; text-align: center; animation: fadeUp 0.6s ease-out 0.2s both; }
    .why-section h2 { font-size: clamp(24px, 3vw, 36px); font-weight: 800; color: var(--black); letter-spacing: -0.5px; margin-bottom: 12px; }
    .why-section .subtitle { font-size: 15px; color: var(--text-muted); max-width: 600px; margin: 0 auto 48px; line-height: 1.7; }
    .features-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; max-width: 900px; margin: 0 auto; }
    .feature-card {
        background: var(--white); border: 1.5px solid #eeeeee;
        border-radius: 20px; padding: 32px 28px; text-align: left;
        transition: border-color 0.2s, box-shadow 0.2s, transform 0.2s;
    }
    .feature-card:hover { border-color: var(--green); box-shadow: 0 8px 32px rgba(57,199,13,0.1); transform: translateY(-4px); }
    .feature-icon {
        width: 48px; height: 48px; background: var(--green-light);
        border-radius: 14px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;
    }
    .feature-icon svg { width: 22px; height: 22px; stroke: var(--green); fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
    .feature-card h3 { font-size: 17px; font-weight: 700; color: var(--black); margin-bottom: 10px; letter-spacing: -0.2px; }
    .feature-card p { font-size: 13px; color: var(--text-muted); line-height: 1.65; }

    /* ── CTA BANNER ── */
    .cta-banner {
        margin: 0 48px 64px; background: var(--black); border-radius: 24px;
        padding: 52px 56px; display: flex; align-items: center;
        justify-content: space-between; gap: 32px; position: relative; overflow: hidden;
    }
    .cta-banner::before {
        content: ''; position: absolute; top: -60px; right: -60px;
        width: 240px; height: 240px; background: var(--green); border-radius: 50%; opacity: 0.12;
    }
    .cta-banner-text h2 { font-size: 28px; font-weight: 800; color: white; letter-spacing: -0.5px; margin-bottom: 8px; }
    .cta-banner-text p { font-size: 14px; color: rgba(255,255,255,0.6); line-height: 1.6; }
    .cta-banner-btn {
        display: inline-flex; align-items: center; gap: 8px;
        background: var(--green); color: white; font-family: 'DM Sans', sans-serif;
        font-size: 15px; font-weight: 600; padding: 14px 28px; border-radius: 100px;
        text-decoration: none; white-space: nowrap; flex-shrink: 0;
        transition: background 0.2s, transform 0.15s;
        box-shadow: 0 6px 20px rgba(57,199,13,0.35); position: relative; z-index: 2;
    }
    .cta-banner-btn:hover { background: var(--green-dark); transform: translateY(-1px); }

    /* ── FOOTER ── */
    .landing-footer {
        border-top: 1px solid #f0f0f0; padding: 24px 48px;
        display: flex; align-items: center; justify-content: space-between;
    }
    .footer-logo { display: flex; align-items: center; gap: 8px; font-size: 15px; font-weight: 700; color: var(--black); text-decoration: none; }
    .footer-dot { width: 16px; height: 16px; background: var(--green); border-radius: 50%; }
    .footer-copy { font-size: 12px; color: #bbb; }

    @keyframes fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

    @media (max-width: 768px) {
        .landing-nav { padding: 0 20px; }
        .nav-links { display: none; }
        .hero { grid-template-columns: 1fr; margin: 16px; }
        .hero-right { min-height: 220px; border-radius: 0 0 24px 24px; }
        .hero-left { border-radius: 24px 24px 0 0; padding: 36px 24px; }
        .why-section { padding: 40px 20px; }
        .features-grid { grid-template-columns: 1fr; }
        .providers-strip { padding: 20px; gap: 16px; }
        .cta-banner { margin: 0 16px 40px; padding: 32px 24px; flex-direction: column; }
        .landing-footer { padding: 20px; flex-direction: column; gap: 8px; text-align: center; }
    }
</style>

<!-- NAVBAR -->
<nav class="landing-nav">
    <a href="/" class="nav-logo">
        <div class="nav-logo-icon"><div class="nav-logo-dot"></div></div>
        <span class="nav-logo-text">OptiDrive</span>
    </a>
    <div class="nav-links">
        <a href="#why" class="nav-link">Why OptiDrive</a>
        <a href="#providers" class="nav-link">Providers</a>
        @auth
            <a href="{{ route('history.index') }}" class="nav-link">History</a>
            <a href="{{ route('home') }}" class="nav-link">Compare Rides</a>
        @endauth
    </div>
    @auth
        <form method="POST" action="{{ route('logout') }}" style="display:inline">
            @csrf
            <button type="submit" class="nav-cta">Logout</button>
        </form>
    @else
        <a href="{{ route('login') }}" class="nav-cta">Get Started</a>
    @endauth
</nav>

<!-- HERO -->
<section class="hero">
    <div class="hero-left">
        <div class="hero-eyebrow">Ghana's #1 Ride Aggregator</div>
        <h1 class="hero-headline">
            Compare Multiple<br>
            <span class="accent">Ride Apps</span>
        </h1>
        <p class="hero-desc">
            Find the best rates and fastest pickups across all your favourite
            ride-sharing platforms in one place. Save time and money on every trip.
        </p>
        <a href="{{ route('register') }}" class="hero-cta">
            Get Started Now
            <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
        </a>
        <div class="hero-stats">
            <div class="stat">
                <span class="stat-num">4+</span>
                <span class="stat-label">Providers</span>
            </div>
            <div class="stat-divider"></div>
            <div class="stat">
                <span class="stat-num">30%</span>
                <span class="stat-label">Avg Savings</span>
            </div>
            <div class="stat-divider"></div>
            <div class="stat">
                <span class="stat-num">Free</span>
                <span class="stat-label">Always</span>
            </div>
        </div>
    </div>

    <div class="hero-right">
        <div class="provider-badges">
            <div class="provider-badge">
                <div class="badge-dot" style="background:#34d186"></div>
                Bolt &nbsp;<span class="badge-price">GH₵</span>
            </div>
            <div class="provider-badge">
                <div class="badge-dot" style="background:#000"></div>
                Uber &nbsp;<span class="badge-price">GH₵</span>
            </div>
            <div class="provider-badge">
                <div class="badge-dot" style="background:#1a73e8"></div>
                inDrive &nbsp;<span class="badge-price">GH₵</span>
            </div>
             <div class="provider-badge">
                <div class="badge-dot" style="background:#ff6b6b"></div>
                Taxi &nbsp;<span class="badge-price">GH₵</span>
            </div>
        </div>
        <img
            src="https://www.freepnglogos.com/uploads/white-car-png/white-car-png-all-wheel-drive-cars-mazda-14.png"
            alt="White car"
            class="hero-car"
            onerror="this.style.display='none'"
        />
        <div class="car-shadow"></div>
    </div>
</section>

<!-- PROVIDERS STRIP -->
<div class="providers-strip" id="providers">
    <span class="label">Compare prices from</span>
    <div class="provider-pill">⚡ Bolt</div>
    <div class="provider-pill">🚗 Uber</div>
    <div class="provider-pill">🚙 inDrive</div>
    <div class="provider-pill">🚕 Taxi</div>
</div>

<!-- WHY SECTION -->
<section class="why-section" id="why">
    <h2>Why Choose OptiDrive?</h2>
    <p class="subtitle">
        The smartest way to navigate the urban jungle. We aggregate every major
        ride-sharing provider so you don't have to app-switch.
    </p>
    <div class="features-grid">
        <div class="feature-card">
            <div class="feature-icon">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
            </div>
            <h3>Real-Time Pricing</h3>
            <p>Instantly compare the prices from Uber, Bolt and local taxis in one unified view</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">
                <svg viewBox="0 0 24 24"><polygon points="5 3 19 12 5 21 5 3"></polygon><polyline points="19 3 19 21"></polyline></svg>
            </div>
            <h3>Fastest Routes</h3>
            <p>Our algorithms calculate traffic and arrival times across all fleets to get you there faster</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">
                <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
            </div>
            <h3>Single Interface</h3>
            <p>Book and manage all your trips through our secure, encrypted platform. No more switching apps</p>
        </div>
    </div>
</section>

<!-- CTA BANNER -->
<div class="cta-banner">
    <div class="cta-banner-text">
        <h2>Ready to save on your next ride?</h2>
        <p>Join thousands of commuters in Accra already saving with OptiDrive every day.</p>
    </div>
    <a href="{{ route('register') }}" class="cta-banner-btn">
        Start Comparing Free
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
    </a>
</div>

<!-- FOOTER -->
<footer class="landing-footer">
    <a href="/" class="footer-logo">
        <div class="footer-dot"></div>
        OptiDrive
    </a>
    <span class="footer-copy">© {{ date('Y') }} OptiDrive. Built for Accra.</span>
</footer>

@endsection