@extends('layouts.app')

@section('title', 'OptiDrive — Payment Methods')

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

    .payment-wrapper {
        max-width: 600px;
        margin: 0 auto;
        padding: 40px 24px;
    }

    /* Header */
    .payment-header {
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        margin-bottom: 36px;
        animation: fadeUp 0.5s ease-out both;
    }

    .back-btn {
        position: absolute;
        left: 0;
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
        stroke-width: 2.5;
        stroke-linecap: round; stroke-linejoin: round;
    }

    .payment-title {
        font-size: 20px;
        font-weight: 700;
        color: var(--black);
        letter-spacing: -0.3px;
    }

    /* Flash message */
    .flash-msg {
        background: var(--green-light);
        border: 1px solid rgba(57,199,13,0.3);
        border-radius: 12px;
        padding: 12px 16px;
        font-size: 13px;
        color: var(--green-dark);
        font-weight: 500;
        margin-bottom: 20px;
        text-align: center;
        animation: fadeUp 0.3s ease-out both;
    }

    /* Payment methods list */
    .methods-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-bottom: 24px;
    }

    /* Method card */
    .method-card {
        background: var(--white);
        border-radius: 16px;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 1px 8px rgba(0,0,0,0.05);
        border: 1.5px solid transparent;
        transition: border-color 0.2s, box-shadow 0.2s;
        animation: fadeUp 0.5s ease-out both;
        cursor: pointer;
    }

    .method-card:hover { border-color: var(--green); box-shadow: 0 4px 16px rgba(57,199,13,0.1); }
    .method-card.selected { border-color: var(--green); }

    /* Payment icon */
    .method-icon {
        width: 52px; height: 40px;
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        font-size: 20px;
        overflow: hidden;
    }

    .method-icon.visa {
        background: #1a1f71;
        color: white;
        font-size: 13px;
        font-weight: 800;
        letter-spacing: 1px;
    }

    .method-icon.mastercard {
        background: white;
        border: 1px solid var(--gray-border);
        font-size: 24px;
    }

    .method-icon.mobile_money {
        background: #fff8e1;
        font-size: 24px;
    }

    .method-icon.cash {
        background: #e8f5e9;
        font-size: 24px;
    }

    /* Method info */
    .method-info { flex: 1; }

    .method-label {
        font-size: 15px;
        font-weight: 600;
        color: var(--black);
    }

    .method-type {
        font-size: 12px;
        color: var(--text-muted);
        margin-top: 2px;
        text-transform: capitalize;
    }

    .default-badge {
        font-size: 10px;
        font-weight: 700;
        background: var(--green-light);
        color: var(--green-dark);
        padding: 2px 8px;
        border-radius: 10px;
        margin-left: 8px;
    }

    /* Radio circle */
    .method-radio {
        width: 24px; height: 24px;
        border-radius: 50%;
        border: 2px solid var(--gray-border);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        transition: border-color 0.2s, background 0.2s;
        cursor: pointer;
    }

    .method-radio.selected {
        border-color: var(--green);
        background: var(--green);
    }

    .method-radio.selected::after {
        content: '';
        width: 8px; height: 8px;
        background: white;
        border-radius: 50%;
    }

    /* Delete button */
    .method-delete {
        width: 28px; height: 28px;
        border-radius: 50%;
        background: none; border: none;
        cursor: pointer; opacity: 0;
        display: flex; align-items: center; justify-content: center;
        transition: opacity 0.2s, background 0.2s;
        flex-shrink: 0;
    }

    .method-card:hover .method-delete { opacity: 1; }
    .method-delete:hover { background: #fee2e2; }

    .method-delete svg {
        width: 14px; height: 14px;
        stroke: #e53e3e; fill: none;
        stroke-width: 2; stroke-linecap: round;
    }

    /* Add payment method button */
    .add-method-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 16px;
        background: transparent;
        border: 2px dashed var(--gray-border);
        border-radius: 16px;
        font-family: 'DM Sans', sans-serif;
        font-size: 14px;
        font-weight: 600;
        color: var(--green);
        cursor: pointer;
        transition: border-color 0.2s, background 0.2s;
        margin-bottom: 32px;
        animation: fadeUp 0.5s ease-out 0.3s both;
    }

    .add-method-btn:hover { border-color: var(--green); background: var(--green-light); }

    /* Add payment modal */
    .modal-overlay {
        position: fixed; inset: 0;
        background: rgba(0,0,0,0.4);
        z-index: 50;
        display: flex; align-items: flex-end; justify-content: center;
        opacity: 0; pointer-events: none;
        transition: opacity 0.3s;
    }

    .modal-overlay.open { opacity: 1; pointer-events: auto; }

    .modal-sheet {
        background: var(--white);
        border-radius: 24px 24px 0 0;
        padding: 24px 24px 48px;
        width: 100%; max-width: 600px;
        transform: translateY(100%);
        transition: transform 0.35s cubic-bezier(0.4,0,0.2,1);
    }

    .modal-overlay.open .modal-sheet { transform: translateY(0); }

    .modal-handle {
        width: 40px; height: 4px;
        background: var(--gray-border);
        border-radius: 2px;
        margin: 0 auto 24px;
    }

    .modal-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--black);
        margin-bottom: 20px;
        text-align: center;
    }

    /* Type selector */
    .type-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
        margin-bottom: 20px;
    }

    .type-option {
        padding: 14px;
        border: 1.5px solid var(--gray-border);
        border-radius: 12px;
        text-align: center;
        cursor: pointer;
        transition: border-color 0.2s, background 0.2s;
    }

    .type-option:hover { border-color: var(--green); }
    .type-option.selected { border-color: var(--green); background: var(--green-light); }
    .type-option .type-icon { font-size: 28px; margin-bottom: 6px; }
    .type-option .type-name { font-size: 13px; font-weight: 600; color: var(--black); }

    .modal-input {
        width: 100%; height: 50px;
        background: #f5f5f5;
        border: 1.5px solid var(--gray-border);
        border-radius: 12px;
        padding: 0 16px;
        font-size: 15px;
        font-family: 'DM Sans', sans-serif;
        color: var(--black);
        outline: none;
        margin-bottom: 16px;
        transition: border-color 0.2s;
    }

    .modal-input:focus { border-color: var(--green); background: white; }

    .modal-submit {
        width: 100%; padding: 15px;
        background: var(--green); color: white;
        font-family: 'DM Sans', sans-serif;
        font-size: 15px; font-weight: 600;
        border: none; border-radius: 100px;
        cursor: pointer;
        transition: background 0.2s;
        box-shadow: 0 4px 14px rgba(57,199,13,0.3);
    }

    .modal-submit:hover { background: var(--green-dark); }

    @keyframes fadeUp { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
</style>

<!-- Add Payment Modal -->
<div class="modal-overlay" id="modalOverlay" onclick="closeModal(event)">
    <div class="modal-sheet">
        <div class="modal-handle"></div>
        <div class="modal-title">Add Payment Method</div>

        <form method="POST" action="{{ route('payment.store') }}">
            @csrf

            <!-- Type selector -->
            <div class="type-grid">
                <div class="type-option" data-type="visa" onclick="selectType('visa')">
                    <div class="type-icon">💳</div>
                    <div class="type-name">Visa</div>
                </div>
                <div class="type-option" data-type="mastercard" onclick="selectType('mastercard')">
                    <div class="type-icon">💳</div>
                    <div class="type-name">Mastercard</div>
                </div>
                <div class="type-option" data-type="mobile_money" onclick="selectType('mobile_money')">
                    <div class="type-icon">📱</div>
                    <div class="type-name">Mobile Money</div>
                </div>
                <div class="type-option" data-type="cash" onclick="selectType('cash')">
                    <div class="type-icon">💵</div>
                    <div class="type-name">Cash</div>
                </div>
            </div>

            <input type="hidden" name="type" id="selectedType" value="">

            <input
                type="text"
                name="label"
                class="modal-input"
                placeholder="e.g. ****4242 or MTN MoMo"
                required
            />

            <button type="submit" class="modal-submit">Add Method</button>
        </form>
    </div>
</div>

<div class="payment-wrapper">

    @if(session('success'))
        <div class="flash-msg">✅ {{ session('success') }}</div>
    @endif

    <!-- Header -->
    <div class="payment-header">
        <a href="{{ url()->previous() }}" class="back-btn">
            <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"></polyline></svg>
        </a>
        <h1 class="payment-title">Payment Methods</h1>
    </div>

    <!-- Methods List -->
    <div class="methods-list">
        @foreach($methods as $index => $method)
            <div class="method-card {{ $method->is_default ? 'selected' : '' }}"
                 style="animation-delay: {{ $index * 0.05 }}s"
                 onclick="setDefault({{ $method->id }})">

                <!-- Icon -->
                <div class="method-icon {{ $method->type }}">
                    @if($method->type === 'visa')
                        VISA
                    @elseif($method->type === 'mastercard')
                        🔴🟠
                    @elseif($method->type === 'mobile_money')
                        📱
                    @else
                        {{ $method->icon }}
                    @endif
                </div>

                <!-- Info -->
                <div class="method-info">
                    <div class="method-label">
                        {{ $method->label }}
                        @if($method->is_default)
                            <span class="default-badge">Default</span>
                        @endif
                    </div>
                    <div class="method-type">{{ str_replace('_', ' ', $method->type) }}</div>
                </div>

                <!-- Radio -->
                <div class="method-radio {{ $method->is_default ? 'selected' : '' }}"></div>

                <!-- Delete -->
                <form method="POST" action="{{ route('payment.destroy', $method->id) }}"
                      onclick="event.stopPropagation()">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="method-delete">
                        <svg viewBox="0 0 24 24">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </form>
            </div>
        @endforeach
    </div>

    <!-- Add Method Button -->
    <button class="add-method-btn" onclick="openModal()">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
            <line x1="12" y1="5" x2="12" y2="19"></line>
            <line x1="5" y1="12" x2="19" y2="12"></line>
        </svg>
        Add Payment Method
    </button>

</div>

<script>
    // Set default via form submission
    function setDefault(id) {
        fetch(`/payment-methods/${id}/default`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            }
        }).then(() => window.location.reload());
    }

    // Modal
    function openModal() {
        document.getElementById('modalOverlay').classList.add('open');
    }

    function closeModal(e) {
        if (e.target === document.getElementById('modalOverlay')) {
            document.getElementById('modalOverlay').classList.remove('open');
        }
    }

    // Type selector
    function selectType(type) {
        document.querySelectorAll('.type-option').forEach(el => el.classList.remove('selected'));
        document.querySelector(`[data-type="${type}"]`).classList.add('selected');
        document.getElementById('selectedType').value = type;
    }
</script>

@endsection