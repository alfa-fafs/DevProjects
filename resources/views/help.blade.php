@extends('layouts.app')

@section('title', 'OptiDrive — Help & Support')

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

    .help-wrapper {
        max-width: 600px;
        margin: 0 auto;
        padding: 40px 24px;
    }

    /* Header */
    .help-header {
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        margin-bottom: 28px;
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

    .help-title {
        font-size: 20px;
        font-weight: 700;
        color: var(--black);
        letter-spacing: -0.3px;
    }

    /* Search bar */
    .search-wrap {
        position: relative;
        margin-bottom: 32px;
        animation: fadeUp 0.5s ease-out 0.1s both;
    }

    .search-icon {
        position: absolute;
        left: 14px; top: 50%;
        transform: translateY(-50%);
        width: 18px; height: 18px;
        stroke: var(--text-muted); fill: none;
        stroke-width: 2; stroke-linecap: round;
    }

    .search-input {
        width: 100%;
        height: 48px;
        background: var(--white);
        border: 1.5px solid var(--gray-border);
        border-radius: 12px;
        padding: 0 16px 0 44px;
        font-size: 14px;
        font-family: 'DM Sans', sans-serif;
        color: var(--black);
        outline: none;
        transition: border-color 0.2s;
        box-shadow: 0 1px 6px rgba(0,0,0,0.04);
    }

    .search-input::placeholder { color: #bbb; }
    .search-input:focus { border-color: var(--green); }

    /* Section label */
    .section-label {
        font-size: 15px;
        font-weight: 700;
        color: var(--black);
        margin-bottom: 14px;
        letter-spacing: -0.2px;
    }

    /* Quick links grid */
    .quick-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        margin-bottom: 32px;
        animation: fadeUp 0.5s ease-out 0.15s both;
    }

    .quick-card {
        background: var(--white);
        border-radius: 16px;
        padding: 20px 16px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
        cursor: pointer;
        border: 1.5px solid transparent;
        box-shadow: 0 1px 8px rgba(0,0,0,0.05);
        transition: border-color 0.2s, box-shadow 0.2s, transform 0.2s;
        text-decoration: none;
    }

    .quick-card:hover {
        border-color: var(--green);
        box-shadow: 0 4px 16px rgba(57,199,13,0.1);
        transform: translateY(-2px);
    }

    .quick-card-icon {
        width: 52px; height: 52px;
        background: var(--gray-bg);
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 26px;
    }

    .quick-card-label {
        font-size: 13px;
        font-weight: 600;
        color: var(--black);
        text-align: center;
    }

    /* Support list */
    .support-list {
        background: var(--white);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 1px 8px rgba(0,0,0,0.05);
        margin-bottom: 32px;
        animation: fadeUp 0.5s ease-out 0.2s both;
    }

    .support-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 20px;
        border-bottom: 1px solid var(--gray-border);
        cursor: pointer;
        transition: background 0.15s;
        text-decoration: none;
    }

    .support-row:last-child { border-bottom: none; }
    .support-row:hover { background: var(--green-light); }

    .support-row-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .support-icon {
        width: 36px; height: 36px;
        border-radius: 10px;
        background: var(--gray-bg);
        display: flex; align-items: center; justify-content: center;
        font-size: 18px;
    }

    .support-label {
        font-size: 15px;
        font-weight: 500;
        color: var(--black);
    }

    .support-arrow {
        width: 16px; height: 16px;
        stroke: var(--gray-border); fill: none;
        stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;
    }

    /* Contact card */
    .contact-card {
        background: var(--black);
        border-radius: 20px;
        padding: 28px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        animation: fadeUp 0.5s ease-out 0.25s both;
        position: relative;
        overflow: hidden;
    }

    .contact-card::before {
        content: '';
        position: absolute;
        top: -40px; right: -40px;
        width: 120px; height: 120px;
        background: var(--green);
        border-radius: 50%;
        opacity: 0.1;
    }

    .contact-card-text h3 {
        font-size: 16px;
        font-weight: 700;
        color: white;
        margin-bottom: 4px;
    }

    .contact-card-text p {
        font-size: 13px;
        color: rgba(255,255,255,0.6);
    }

    .contact-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        background: var(--green);
        color: white;
        font-family: 'DM Sans', sans-serif;
        font-size: 13px;
        font-weight: 600;
        padding: 10px 18px;
        border-radius: 100px;
        text-decoration: none;
        white-space: nowrap;
        flex-shrink: 0;
        transition: background 0.2s;
        position: relative; z-index: 1;
    }

    .contact-btn:hover { background: var(--green-dark); }

    /* FAQ section */
    .faq-list {
        margin-top: 32px;
        animation: fadeUp 0.5s ease-out 0.3s both;
    }

    .faq-item {
        background: var(--white);
        border-radius: 12px;
        margin-bottom: 8px;
        overflow: hidden;
        box-shadow: 0 1px 6px rgba(0,0,0,0.04);
    }

    .faq-question {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 20px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
        color: var(--black);
        transition: background 0.15s;
    }

    .faq-question:hover { background: var(--green-light); }

    .faq-chevron {
        width: 16px; height: 16px;
        stroke: var(--text-muted); fill: none;
        stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;
        transition: transform 0.3s;
        flex-shrink: 0;
    }

    .faq-item.open .faq-chevron { transform: rotate(180deg); }

    .faq-answer {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease;
        font-size: 13px;
        color: var(--text-muted);
        line-height: 1.6;
    }

    .faq-item.open .faq-answer { max-height: 200px; }

    .faq-answer-inner { padding: 0 20px 16px; }

    @keyframes fadeUp { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
</style>

<div class="help-wrapper">

    <!-- Header -->
    <div class="help-header">
        <a href="{{ url()->previous() }}" class="back-btn">
            <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"></polyline></svg>
        </a>
        <h1 class="help-title">Help & Support</h1>
    </div>

    <!-- Search -->
    <div class="search-wrap">
        <svg class="search-icon" viewBox="0 0 24 24">
            <circle cx="11" cy="11" r="8"></circle>
            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
        </svg>
        <input
            type="text"
            class="search-input"
            placeholder="Search For Help"
            id="searchInput"
            oninput="filterFAQ(this.value)"
        />
    </div>

    <!-- Quick Links -->
    <div class="section-label">Quick Links</div>
    <div class="quick-grid">
        <a href="#ride-issues" class="quick-card">
            <div class="quick-card-icon">🚗</div>
            <div class="quick-card-label">Ride Issues</div>
        </a>
        <a href="{{ route('payment.index') }}" class="quick-card">
            <div class="quick-card-icon">💳</div>
            <div class="quick-card-label">Payment</div>
        </a>
        <a href="#account" class="quick-card">
            <div class="quick-card-icon">👤</div>
            <div class="quick-card-label">Account</div>
        </a>
        <a href="#safety" class="quick-card">
            <div class="quick-card-icon">🛡️</div>
            <div class="quick-card-label">Safety</div>
        </a>
    </div>

    <!-- Support List -->
    <div class="support-list">
        <a href="#" class="support-row">
            <div class="support-row-left">
                <div class="support-icon">🛡️</div>
                <span class="support-label">Safety Center</span>
            </div>
            <svg class="support-arrow" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
        </a>

        <a href="#" class="support-row">
            <div class="support-row-left">
                <div class="support-icon">📋</div>
                <span class="support-label">Community Guidelines</span>
            </div>
            <svg class="support-arrow" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
        </a>

        <a href="#contact" class="support-row">
            <div class="support-row-left">
                <div class="support-icon">💬</div>
                <span class="support-label">Contact Support</span>
            </div>
            <svg class="support-arrow" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
        </a>
    </div>

    <!-- Contact Card -->
    <div class="contact-card" id="contact">
        <div class="contact-card-text">
            <h3>Still need help?</h3>
            <p>Our support team is available 24/7</p>
        </div>
        <a href="mailto:support@optidrive.app" class="contact-btn">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                <polyline points="22,6 12,13 2,6"></polyline>
            </svg>
            Email Us
        </a>
    </div>

    <!-- FAQ -->
    <div class="faq-list" id="faqList">
        <div class="section-label" style="margin-top:0; margin-bottom:12px;">Frequently Asked Questions</div>

        <div class="faq-item" data-question="how do prices work">
            <div class="faq-question" onclick="toggleFAQ(this)">
                How does price comparison work?
                <svg class="faq-chevron" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="faq-answer">
                <div class="faq-answer-inner">
                    OptiDrive fetches real-time pricing from Bolt, Uber, inDrive and local taxis simultaneously. We calculate fares based on your route distance and duration, then display them ranked from cheapest to most expensive.
                </div>
            </div>
        </div>

        <div class="faq-item" data-question="is optidrive free">
            <div class="faq-question" onclick="toggleFAQ(this)">
                Is OptiDrive free to use?
                <svg class="faq-chevron" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="faq-answer">
                <div class="faq-answer-inner">
                    Yes! OptiDrive is completely free. We never charge you to compare rides. You only pay the ride provider directly when you book.
                </div>
            </div>
        </div>

        <div class="faq-item" data-question="payment refund">
            <div class="faq-question" onclick="toggleFAQ(this)">
                How do I get a refund?
                <svg class="faq-chevron" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="faq-answer">
                <div class="faq-answer-inner">
                    Refunds are handled directly by the ride provider (Bolt, Uber, inDrive or Taxi). Contact their support team with your booking reference. OptiDrive does not process payments directly.
                </div>
            </div>
        </div>

        <div class="faq-item" data-question="cancel ride booking">
            <div class="faq-question" onclick="toggleFAQ(this)">
                How do I cancel a ride?
                <svg class="faq-chevron" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="faq-answer">
                <div class="faq-answer-inner">
                    Once you select a provider and are redirected to their app, cancellation is handled within that app. Each provider has their own cancellation policy and fees.
                </div>
            </div>
        </div>

    </div>

</div>

<script>
    function toggleFAQ(el) {
        const item = el.parentElement;
        item.classList.toggle('open');
    }

    function filterFAQ(query) {
        const items = document.querySelectorAll('.faq-item');
        const q = query.toLowerCase();
        items.forEach(item => {
            const text = item.dataset.question + ' ' + item.textContent.toLowerCase();
            item.style.display = text.includes(q) ? 'block' : 'none';
        });
    }
</script>

@endsection