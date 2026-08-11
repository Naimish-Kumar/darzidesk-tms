@extends('layouts.app')

@section('page-title')
    {{ __('POS & Invoicing Console') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
    </li>
    <li class="breadcrumb-item active">
        {{ __('POS Billing') }}
    </li>
@endsection

@section('content')
<style>
    :root {
        --primary-teal: #006A67;
        --accent-teal: #26A69A;
        --dark-navy: #0B1C30;
        --card-border: #E2E8F0;
        --text-dark: #1E293B;
        --text-muted: #64748B;
        --font-code: 'JetBrains Mono', monospace;
    }

    .pos-grid-layout {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 24px;
    }

    .catalog-filter-bar {
        background: #FFFFFF;
        border: 1px solid var(--card-border);
        border-radius: 14px;
        padding: 12px 18px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .filter-pills {
        display: flex;
        gap: 10px;
        font-size: 12.5px;
        font-weight: 700;
    }

    .filter-pill {
        padding: 6px 16px;
        border-radius: 8px;
        color: var(--text-muted);
        cursor: pointer;
        transition: all 0.2s ease;
        user-select: none;
    }

    .filter-pill.active {
        background: #E6FFFA;
        color: var(--primary-teal);
        font-weight: 800;
    }

    .catalog-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
        margin-bottom: 24px;
    }

    .product-card {
        background: #FFFFFF;
        border: 1.5px solid var(--card-border);
        border-radius: 16px;
        overflow: hidden;
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .product-card:hover {
        border-color: var(--primary-teal);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 106, 103, 0.08);
    }

    .product-img {
        width: 100%;
        height: 140px;
        object-fit: cover;
        background: #F8FAFC;
    }

    .product-body {
        padding: 14px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        flex: 1;
    }

    .prod-title {
        font-size: 14px;
        font-weight: 800;
        color: var(--dark-navy);
        margin-bottom: 2px;
    }

    .prod-desc {
        font-size: 11px;
        color: var(--text-muted);
        margin-bottom: 12px;
        line-height: 1.3;
    }

    .prod-price-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto;
    }

    .price-num {
        font-family: var(--font-code);
        font-size: 16px;
        font-weight: 800;
        color: var(--primary-teal);
    }

    .btn-add-cart-icon {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #E6FFFA;
        color: var(--primary-teal);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border: none;
        transition: all 0.2s ease;
    }

    .btn-add-cart-icon:hover {
        background: var(--primary-teal);
        color: #FFFFFF;
    }

    .cart-card {
        background: #FFFFFF;
        border: 1px solid var(--card-border);
        border-radius: 18px;
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .customer-info-box {
        background: #F8FAFC;
        border: 1px solid var(--card-border);
        border-radius: 14px;
        padding: 14px;
        margin-bottom: 20px;
    }

    .cust-avatar-circle {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: #E6FFFA;
        color: var(--primary-teal);
        font-size: 13px;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .cart-item-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px dashed var(--card-border);
    }

    .cart-item-name {
        font-size: 13px;
        font-weight: 800;
        color: var(--dark-navy);
    }

    .cart-item-price {
        font-family: var(--font-code);
        font-size: 13px;
        font-weight: 800;
        color: var(--primary-teal);
    }

    .qty-controls {
        display: flex;
        align-items: center;
        gap: 8px;
        background: #F1F5F9;
        padding: 3px 10px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 800;
    }

    .qty-btn {
        cursor: pointer;
        user-select: none;
        color: var(--text-muted);
    }

    .qty-btn:hover {
        color: var(--primary-teal);
    }

    .financial-summary-stack {
        border-top: 1px solid var(--card-border);
        padding-top: 16px;
        margin-bottom: 20px;
    }

    .summary-line {
        display: flex;
        justify-content: space-between;
        font-size: 12.5px;
        margin-bottom: 8px;
    }

    .total-line {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-top: 12px;
        padding-top: 12px;
        border-top: 1px solid var(--card-border);
    }

    .total-val {
        font-family: var(--font-code);
        font-size: 26px;
        font-weight: 800;
        color: var(--primary-teal);
    }

    .btn-proceed-pay {
        background: var(--primary-teal);
        color: #FFFFFF;
        border: none;
        border-radius: 12px;
        padding: 14px;
        font-size: 14px;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-proceed-pay:hover {
        background: #004D40;
    }

    @media (max-width: 1100px) {
        .pos-grid-layout { grid-template-columns: 1fr; }
        .catalog-grid { grid-template-columns: repeat(2, 1fr); }
    }
</style>

<div class="pos-grid-layout">
    <!-- Left Section: Catalog Grid -->
    <div>
        <!-- Filter Bar & Search -->
        <div class="catalog-filter-bar">
            <div class="filter-pills">
                <span class="filter-pill active" onclick="filterCategory('all', this)">{{ __('All Items') }}</span>
                <span class="filter-pill" onclick="filterCategory('Male', this)">{{ __('Male') }}</span>
                <span class="filter-pill" onclick="filterCategory('Female', this)">{{ __('Female') }}</span>
            </div>

            <div class="d-flex align-items-center gap-2">
                <i class="ti ti-search text-muted"></i>
                <input type="text" id="posSearchInput" placeholder="{{ __('Search garments...') }}" onkeyup="searchCatalog()" class="form-control form-control-sm border-0 bg-light" style="width: 180px; font-weight:600;">
            </div>
        </div>

        <!-- Dynamic Catalog Items Grid -->
        <div class="catalog-grid" id="posCatalogGrid">
            @forelse($clothTypes as $cloth)
                @php
                    $clothImg = asset('assets/images/bespoke_tailor_atelier_hero.jpg');
                    if (str_contains(strtolower($cloth->title), 'shirt')) {
                        $clothImg = asset('assets/images/onboarding_tailor.jpg');
                    } elseif (str_contains(strtolower($cloth->title), 'alter')) {
                        $clothImg = asset('assets/images/hero_tailor_atelier.jpg');
                    }
                @endphp
                <div class="product-card" data-gender="{{ $cloth->gender }}" data-title="{{ strtolower($cloth->title) }}">
                    <img src="{{ $clothImg }}" class="product-img" alt="{{ $cloth->title }}">
                    <div class="product-body">
                        <div>
                            <div class="d-flex justify-content-between align-items-start">
                                <h6 class="prod-title">{{ $cloth->title }}</h6>
                                <span class="badge bg-light-primary text-primary px-2 py-1 fs-8 rounded-pill">{{ $cloth->gender ?: 'Unisex' }}</span>
                            </div>
                            <p class="prod-desc">{{ $cloth->note ?: __('Bespoke tailor crafted item') }}</p>
                        </div>
                        <div class="prod-price-row">
                            <div>
                                <small class="text-muted d-block fw-bold fs-8">{{ __('PRICE') }}</small>
                                <span class="price-num">{{ subscriptionPaymentSettings()['CURRENCY_SYMBOL'] . number_format($cloth->amount, 2) }}</span>
                            </div>
                            <button class="btn-add-cart-icon" onclick="addToCart({{ $cloth->id }}, '{{ addslashes($cloth->title) }}', {{ $cloth->amount }}, '{{ $clothImg }}', '{{ $cloth->gender }}')">
                                <i class="ti ti-shopping-cart-plus fs-5"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted py-5 bg-white border rounded-4">
                    <i class="ti ti-hanger fs-1 text-muted d-block mb-2"></i>
                    {{ __('No garments or cloth types found in your inventory.') }}
                </div>
            @endforelse
        </div>
    </div>

    <!-- Right Section: Active POS Cart -->
    <div class="cart-card">
        <div>
            <!-- Dynamic Customer Select -->
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-muted fw-bold text-uppercase fs-8">{{ __('CUSTOMER SELECTION') }}</span>
                <a href="{{ route('customer.create') }}" class="text-teal fw-bold fs-8 text-decoration-none"><i class="ti ti-user-plus me-1"></i>{{ __('New Customer') }}</a>
            </div>

            <div class="customer-info-box">
                <select class="form-select border-0 bg-transparent fw-bold" id="posCustomerSelect" onchange="updateSelectedCustomer()">
                    <option value="" data-name="{{ __('Walk-in Client') }}" data-email="walkin@darzidesk.local" data-phone="0000000000">
                        {{ __('Walk-in Client (Default Counter Customer)') }}
                    </option>
                    @foreach($customers as $c)
                        <option value="{{ $c->id }}" data-name="{{ $c->name }}" data-email="{{ $c->email }}" data-phone="{{ $c->phone_number }}">
                            {{ $c->name }} ({{ $c->phone_number ?: $c->email }})
                        </option>
                    @endforeach
                </select>

                <div class="d-flex align-items-center gap-3 mt-3 pt-3 border-top" id="custDetailDisplay">
                    <div class="cust-avatar-circle" id="custAvatar">C</div>
                    <div>
                        <h6 class="mb-0 fw-bold text-dark fs-7" id="custNameDisplay">{{ __('Walk-in Client') }}</h6>
                        <small class="text-muted fs-8 d-block" id="custContactDisplay">{{ __('Standard Counter POS') }}</small>
                    </div>
                </div>
            </div>

            <!-- Cart Items Stack -->
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="fw-bold text-dark fs-7">{{ __('Active Cart') }} <small id="cartItemsCount" class="text-muted">(0 items)</small></span>
                <button type="button" class="btn btn-sm text-danger p-0 fw-bold border-0 bg-transparent fs-8" onclick="clearCart()">{{ __('Clear All') }}</button>
            </div>

            <div class="cart-items-stack" id="cartItemsStack" style="max-height: 280px; overflow-y: auto;">
                <div class="text-center py-4 text-muted fs-7">
                    <i class="ti ti-shopping-cart-x fs-2 d-block mb-1 text-muted"></i>
                    {{ __('Cart is empty. Click garment + button to add.') }}
                </div>
            </div>
        </div>

        <!-- Financial Calculation & Submit -->
        <div>
            <div class="financial-summary-stack">
                <div class="summary-line">
                    <span class="text-muted">{{ __('Subtotal') }}</span>
                    <span id="summarySubtotal" class="fw-bold">{{ subscriptionPaymentSettings()['CURRENCY_SYMBOL'] }}0.00</span>
                </div>
                <div class="summary-line">
                    <span class="text-muted">{{ __('Tax') }}</span>
                    <span id="summaryTax" class="fw-bold">{{ subscriptionPaymentSettings()['CURRENCY_SYMBOL'] }}0.00</span>
                </div>
                <div class="total-line">
                    <span class="fw-bold text-dark fs-7">{{ __('TOTAL AMOUNT') }}</span>
                    <span class="total-val" id="summaryTotal">{{ subscriptionPaymentSettings()['CURRENCY_SYMBOL'] }}0.00</span>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label text-muted fs-8 fw-bold text-uppercase mb-1">{{ __('Advance Payment Received') }}</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-0 fw-bold">{{ subscriptionPaymentSettings()['CURRENCY_SYMBOL'] }}</span>
                    <input type="number" step="0.01" min="0" class="form-control form-control-sm border-0 bg-light fw-bold" id="posAdvanceInput" placeholder="0.00">
                </div>
            </div>

            <button type="button" class="btn-proceed-pay" id="btnSubmitPos" onclick="submitPosInvoice()">
                <i class="ti ti-check fs-5"></i> {{ __('Complete & Generate POS Invoice') }}
            </button>
        </div>
    </div>
</div>

@push('script-page')
<script>
    let cart = [];
    const currencySymbol = "{!! subscriptionPaymentSettings()['CURRENCY_SYMBOL'] !!}";

    $(document).ready(function() {
        updateSelectedCustomer();
    });

    function updateSelectedCustomer() {
        const select = document.getElementById('posCustomerSelect');
        if (!select || !select.options.length) return;
        const opt = select.options[select.selectedIndex];
        if (!opt) return;

        const name = opt.getAttribute('data-name') || 'Walk-in Client';
        const contact = opt.getAttribute('data-phone') || opt.getAttribute('data-email') || '';

        document.getElementById('custNameDisplay').textContent = name;
        document.getElementById('custContactDisplay').textContent = contact || 'Standard Counter POS';
        document.getElementById('custAvatar').textContent = name.charAt(0).toUpperCase();
    }

    function filterCategory(gender, el) {
        document.querySelectorAll('.filter-pill').forEach(p => p.classList.remove('active'));
        el.classList.add('active');

        const cards = document.querySelectorAll('#posCatalogGrid .product-card');
        cards.forEach(card => {
            const cardGender = card.getAttribute('data-gender');
            if (gender === 'all' || cardGender === gender) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }

    function searchCatalog() {
        const query = document.getElementById('posSearchInput').value.toLowerCase();
        const cards = document.querySelectorAll('#posCatalogGrid .product-card');

        cards.forEach(card => {
            const title = card.getAttribute('data-title') || '';
            if (title.includes(query)) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }

    function renderCart() {
        const stack = document.getElementById('cartItemsStack');
        const count = document.getElementById('cartItemsCount');

        if (cart.length === 0) {
            stack.innerHTML = `<div class="text-center py-4 text-muted fs-7"><i class="ti ti-shopping-cart-x fs-2 d-block mb-1 text-muted"></i>{{ __('Cart is empty. Click garment + button to add.') }}</div>`;
            count.textContent = '(0 items)';
            calculateTotals();
            return;
        }

        let totalQty = 0;
        stack.innerHTML = cart.map(item => {
            totalQty += item.qty;
            const lineTotal = (item.price * item.qty).toFixed(2);
            return `
                <div class="cart-item-row">
                    <div>
                        <div class="cart-item-name">${item.name}</div>
                        <small class="text-muted fs-8">${item.gender || 'Bespoke'}</small>
                        <div class="cart-item-price">${currencySymbol}${lineTotal}</div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="qty-controls">
                            <span class="qty-btn" onclick="updateQty(${item.id}, -1)">-</span>
                            <span>${item.qty}</span>
                            <span class="qty-btn" onclick="updateQty(${item.id}, 1)">+</span>
                        </div>
                        <i class="ti ti-trash text-danger ms-1" style="cursor:pointer;" onclick="removeCartItem(${item.id})"></i>
                    </div>
                </div>
            `;
        }).join('');

        count.textContent = `(${totalQty} items)`;
        calculateTotals();
    }

    function addToCart(id, name, price, img, gender) {
        const existing = cart.find(i => i.id === id);
        if (existing) {
            existing.qty++;
        } else {
            cart.push({ id, name, price: parseFloat(price), qty: 1, img, gender });
        }
        renderCart();
    }

    function updateQty(id, delta) {
        const item = cart.find(i => i.id === id);
        if (!item) return;
        item.qty += delta;
        if (item.qty <= 0) {
            cart = cart.filter(i => i.id !== id);
        }
        renderCart();
    }

    function removeCartItem(id) {
        cart = cart.filter(i => i.id !== id);
        renderCart();
    }

    function clearCart() {
        cart = [];
        renderCart();
    }

    function calculateTotals() {
        const subtotal = cart.reduce((acc, i) => acc + (i.price * i.qty), 0);
        const total = subtotal;

        document.getElementById('summarySubtotal').textContent = currencySymbol + subtotal.toFixed(2);
        document.getElementById('summaryTotal').textContent = currencySymbol + total.toFixed(2);
    }

    function submitPosInvoice() {
        const customerId = $('#posCustomerSelect').val();

        if (cart.length === 0) {
            show_toastr('Error', 'Please add at least one garment to cart.', 'error');
            return;
        }

        const advance = $('#posAdvanceInput').val() || 0;
        const payload = {
            customer_id: customerId,
            advance_payment: advance,
            payment_method: 'Cash',
            items: cart.map(item => ({
                cloth_type_id: item.id,
                quantity: item.qty,
                amount: item.price
            }))
        };

        $('#btnSubmitPos').prop('disabled', true).html('<i class="ti ti-spin ti-spinner me-1"></i> Processing...');

        fetch("{{ route('pos.store') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(data => {
            $('#btnSubmitPos').prop('disabled', false).html('<i class="ti ti-check fs-5"></i> {{ __("Complete & Generate POS Invoice") }}');
            if (data.success) {
                show_toastr('Success', data.message, 'success');
                clearCart();
                $('#posAdvanceInput').val('');
                setTimeout(() => window.location.href = "{{ route('invoice.index') }}", 1200);
            } else {
                show_toastr('Error', data.message || 'Payment failed', 'error');
            }
        })
        .catch(err => {
            $('#btnSubmitPos').prop('disabled', false).html('<i class="ti ti-check fs-5"></i> {{ __("Complete & Generate POS Invoice") }}');
            show_toastr('Error', 'An unexpected error occurred.', 'error');
            console.error(err);
        });
    }
</script>
@endpush
@endsection
