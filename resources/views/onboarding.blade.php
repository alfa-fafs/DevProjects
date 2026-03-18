<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OptiDrive — Welcome</title>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@700&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --green: #39C70D;
            --green-dark: #2ea00a;
            --white: #FFFFFF;
            --black: #000000;
            --gray: #D9D9D9;
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

        /* Phone shell */
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
        }

        /* Skip button */
        .skip-btn {
            position: absolute;
            top: 20px;
            right: 24px;
            z-index: 20;
            background: rgba(0,0,0,0.06);
            color: #555;
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            font-weight: 500;
            border: none;
            border-radius: 20px;
            padding: 6px 16px;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.2s;
        }

        .skip-btn:hover { background: rgba(0,0,0,0.1); }

        /* Slides wrapper */
        .slides-track {
            display: flex;
            width: 300%;
            height: 100%;
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Individual slide */
        .slide {
            width: 33.333%;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            padding: 60px 28px 48px;
            position: relative;
        }

        /* Illustration area */
        .illustration {
            width: 100%;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f7f7f7;
            border-radius: 24px;
            overflow: hidden;
            margin-bottom: 32px;
            min-height: 280px;
        }

        .illustration img {
            width: 85%;
            height: 85%;
            object-fit: contain;
        }

        /* Slide text */
        .slide-text {
            width: 100%;
            text-align: left;
            flex-shrink: 0;
        }

        .slide-text h2 {
            font-size: 22px;
            font-weight: 700;
            color: var(--black);
            line-height: 1.3;
            margin-bottom: 10px;
        }

        .slide-text p {
            font-size: 14px;
            color: var(--text-muted);
            line-height: 1.6;
        }

        /* Last slide CTA */
        .slide-cta {
            width: 100%;
            margin-top: 32px;
        }

        .btn-green {
            display: block;
            width: 100%;
            padding: 16px;
            background: var(--green);
            color: var(--white);
            font-family: 'DM Sans', sans-serif;
            font-size: 16px;
            font-weight: 600;
            border: none;
            border-radius: 14px;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
        }

        .btn-green:hover { background: var(--green-dark); transform: translateY(-1px); }
        .btn-green:active { transform: translateY(0); }

        /* Bottom nav — dots + next */
        .bottom-nav {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 16px 28px 36px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 10;
            background: white;
        }

        /* Dots */
        .dots {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .dot {
            width: 8px;
            height: 8px;
            border-radius: 4px;
            background: var(--gray);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .dot.active {
            width: 24px;
            background: var(--green);
        }

        /* Next button */
        .next-btn {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: var(--green);
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s, transform 0.1s;
            box-shadow: 0 4px 16px rgba(57, 199, 13, 0.35);
        }

        .next-btn:hover { background: var(--green-dark); transform: scale(1.05); }
        .next-btn:active { transform: scale(0.97); }

        .next-btn svg {
            width: 20px;
            height: 20px;
            fill: none;
            stroke: white;
            stroke-width: 2.5;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        /* Progress bar at top */
        .progress-bar {
            position: absolute;
            top: 0;
            left: 0;
            height: 3px;
            background: var(--green);
            transition: width 0.5s ease;
            z-index: 20;
            border-radius: 0 2px 2px 0;
        }

        /* Auto-advance timer ring around next btn */
        .timer-ring {
            position: absolute;
            top: 0; left: 0;
            width: 52px;
            height: 52px;
        }

        .timer-ring circle {
            fill: none;
            stroke: rgba(255,255,255,0.4);
            stroke-width: 3;
            stroke-dasharray: 138;
            stroke-dashoffset: 138;
            transform: rotate(-90deg);
            transform-origin: center;
            transition: stroke-dashoffset 0.1s linear;
        }

        /* Full screen on actual mobile */
        @media (max-width: 480px) {
            body { background: white; padding: 0; }
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

    <!-- Progress bar -->
    <div class="progress-bar" id="progressBar" style="width: 33%"></div>

    <!-- Skip -->
    <a href="{{ route('register') }}" class="skip-btn">Skip</a>

    <!-- Slides -->
    <div class="slides-track" id="slidesTrack">

        <!-- Slide 1: Compare Multiple Ride Apps -->
        <div class="slide">
            <div class="illustration">
                <img src="https://cdn-icons-png.flaticon.com/512/4062/4062401.png" alt="Compare rides illustration" />
            </div>
            <div class="slide-text">
                <h2>Compare Multiple Ride Apps</h2>
                <p>See all available rides in your area from top providers in one view</p>
            </div>
        </div>

        <!-- Slide 2: Find Fastest and Cheapest -->
        <div class="slide">
            <div class="illustration">
                <img src="https://cdn-icons-png.flaticon.com/512/2331/2331970.png" alt="Find cheapest ride illustration" />
            </div>
            <div class="slide-text">
                <h2>Find fastest and cheapest ride</h2>
                <p>Filter by price or arrival time to get the best deal every single time</p>
            </div>
        </div>

        <!-- Slide 3: Ready to ride -->
        <div class="slide">
            <div class="illustration">
                <img src="https://cdn-icons-png.flaticon.com/512/3176/3176366.png" alt="Ready to ride illustration" />
            </div>
            <div class="slide-text">
                <h2>Ready to ride?</h2>
                <p>Join thousands of users saving time and money on every trip</p>
            </div>
            <div class="slide-cta">
                <a href="{{ route('phone.register') }}" class="btn-green">Get Started</a>
            </div>
        </div>

    </div>

    <!-- Bottom nav -->
    <div class="bottom-nav" id="bottomNav">
        <div class="dots">
            <div class="dot active" onclick="goTo(0)"></div>
            <div class="dot" onclick="goTo(1)"></div>
            <div class="dot" onclick="goTo(2)"></div>
        </div>

        <button class="next-btn" id="nextBtn" onclick="nextSlide()">
            <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
            <svg class="timer-ring" id="timerRing" viewBox="0 0 52 52" style="position:absolute;top:0;left:0;">
                <circle cx="26" cy="26" r="22" id="timerCircle"/>
            </svg>
        </button>
    </div>

</div>

<script>
    const totalSlides = 3;
    let current = 0;
    let autoTimer = null;
    let timerInterval = null;
    const autoDelay = 3500; // 3.5 seconds per slide

    const track       = document.getElementById('slidesTrack');
    const dots        = document.querySelectorAll('.dot');
    const progressBar = document.getElementById('progressBar');
    const timerCircle = document.getElementById('timerCircle');
    const circumference = 2 * Math.PI * 22; // ~138

    function goTo(index) {
        current = index;
        track.style.transform = `translateX(-${(100 / 3) * current}%)`;

        // Update dots
        dots.forEach((d, i) => {
            d.classList.toggle('active', i === current);
        });

        // Update progress bar
        const pct = ((current + 1) / totalSlides) * 100;
        progressBar.style.width = pct + '%';

        // Hide next btn on last slide
        document.getElementById('nextBtn').style.opacity = current === totalSlides - 1 ? '0' : '1';
        document.getElementById('nextBtn').style.pointerEvents = current === totalSlides - 1 ? 'none' : 'auto';

        // Restart timer
        resetTimer();
    }

    function nextSlide() {
        if (current < totalSlides - 1) {
            goTo(current + 1);
        }
    }

    function resetTimer() {
        // Clear existing timers
        clearTimeout(autoTimer);
        clearInterval(timerInterval);

        if (current === totalSlides - 1) return;

        // Animate the ring
        let elapsed = 0;
        const step  = 50; // ms
        timerCircle.style.strokeDashoffset = circumference;

        timerInterval = setInterval(() => {
            elapsed += step;
            const progress = elapsed / autoDelay;
            const offset   = circumference * (1 - progress);
            timerCircle.style.strokeDashoffset = Math.max(0, offset);
        }, step);

        // Auto advance
        autoTimer = setTimeout(() => {
            clearInterval(timerInterval);
            if (current < totalSlides - 1) {
                goTo(current + 1);
            }
        }, autoDelay);
    }

    // Touch/swipe support
    let touchStartX = 0;
    track.addEventListener('touchstart', e => {
        touchStartX = e.touches[0].clientX;
    });

    track.addEventListener('touchend', e => {
        const diff = touchStartX - e.changedTouches[0].clientX;
        if (Math.abs(diff) > 50) {
            if (diff > 0 && current < totalSlides - 1) goTo(current + 1);
            if (diff < 0 && current > 0) goTo(current - 1);
        }
    });

    // Start
    goTo(0);
</script>
</body>
</html>