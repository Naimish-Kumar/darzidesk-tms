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
        --pos-bg-card: #0B2239;
        --pos-border: #29435D;
        --pos-inner-bg: #102B45;
        --pos-pill-bg: #081726;
        --pos-text-title: #FFFFFF;
        --pos-text-sub: #8FA1B5;
        --dd-gold: #D9A441;
        --dd-gold-hover: #F4C861;
        --dd-gold-light: rgba(217, 164, 65, 0.15);
        --font-code: 'JetBrains Mono', monospace;
    }

    .pos-grid-layout {
        display: grid;
        grid-template-columns: 1fr 420px;
        gap: 24px;
    }

    .catalog-filter-bar {
        background: var(--pos-bg-card);
        border: 1px solid var(--pos-border);
        border-radius: 16px;
        padding: 16px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
        color: var(--pos-text-title);
    }

    .filter-pills {
        display: flex;
        gap: 8px;
        font-size: 13px;
        font-weight: 700;
    }

    .filter-pill {
        padding: 8px 18px;
        border-radius: 10px;
        color: var(--pos-text-sub);
        background: var(--pos-pill-bg);
        cursor: pointer;
        transition: all 0.2s ease;
        user-select: none;
        border: 1px solid transparent;
    }

    .filter-pill:hover {
        background: var(--pos-inner-bg);
        color: var(--pos-text-title);
    }

    .filter-pill.active {
        background: var(--dd-gold-light);
        color: var(--dd-gold);
        border-color: rgba(217, 164, 65, 0.4);
        font-weight: 800;
    }

    .catalog-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
        margin-bottom: 24px;
    }

    .product-card {
        background: var(--pos-bg-card);
        border: 1.5px solid var(--pos-border);
        border-radius: 16px;
        overflow: hidden;
        cursor: pointer;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        color: var(--pos-text-title);
    }

    .product-card:hover {
        border-color: var(--dd-gold);
        transform: translateY(-3px);
        box-shadow: 0 10px 24px rgba(0, 0, 0, 0.12);
    }

    .product-img {
        width: 100%;
        height: 135px;
        object-fit: cover;
        background: var(--pos-inner-bg);
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
        color: var(--pos-text-title);
        margin-bottom: 3px;
    }

    .prod-desc {
        font-size: 11px;
        color: var(--pos-text-sub);
        margin-bottom: 12px;
        line-height: 1.35;
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
        color: var(--dd-gold);
    }

    .btn-add-cart-icon {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: var(--dd-gold-light);
        color: var(--dd-gold);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border: 1px solid rgba(217, 164, 65, 0.3);
        transition: all 0.2s ease;
    }

    .btn-add-cart-icon:hover {
        background: var(--dd-gold);
        color: #03111F;
        transform: scale(1.08);
    }

    .cart-card {
        background: var(--pos-bg-card);
        border: 1px solid var(--pos-border);
        border-radius: 18px;
        padding: 22px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
        color: var(--pos-text-title);
    }

    .customer-info-box {
        background: var(--pos-inner-bg);
        border: 1px solid var(--pos-border);
        border-radius: 14px;
        padding: 14px;
        margin-bottom: 18px;
        color: var(--pos-text-title);
    }

    .cust-avatar-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--dd-gold-light);
        color: var(--dd-gold);
        font-size: 14px;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(217, 164, 65, 0.3);
    }

    .cart-item-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px dashed var(--pos-border);
    }

    .cart-item-name {
        font-size: 13.5px;
        font-weight: 800;
        color: var(--pos-text-title);
    }

    .cart-item-price {
        font-family: var(--font-code);
        font-size: 13px;
        font-weight: 800;
        color: var(--dd-gold);
    }

    .qty-controls {
        display: flex;
        align-items: center;
        gap: 8px;
        background: var(--pos-pill-bg);
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 800;
        color: var(--pos-text-title);
    }

    .qty-btn {
        cursor: pointer;
        user-select: none;
        color: var(--pos-text-sub);
        font-size: 14px;
        line-height: 1;
        width: 18px;
        text-align: center;
    }

    .qty-btn:hover {
        color: var(--dd-gold);
    }

    .payment-method-pills {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 8px;
        margin-bottom: 16px;
    }

    .pm-pill {
        border: 1px solid var(--pos-border);
        background: var(--pos-inner-bg);
        border-radius: 10px;
        padding: 8px 4px;
        text-align: center;
        cursor: pointer;
        font-size: 11px;
        font-weight: 700;
        color: var(--pos-text-sub);
        transition: all 0.2s ease;
        user-select: none;
    }

    .pm-pill:hover {
        border-color: var(--dd-gold);
    }

    .pm-pill.active {
        background: var(--dd-gold-light);
        color: var(--dd-gold);
        border-color: var(--dd-gold);
        font-weight: 800;
    }

    .financial-summary-stack {
        border-top: 1px solid var(--pos-border);
        padding-top: 16px;
        margin-bottom: 16px;
    }

    .summary-line {
        display: flex;
        justify-content: space-between;
        font-size: 13px;
        margin-bottom: 8px;
        color: var(--pos-text-sub);
    }

    .total-line {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-top: 12px;
        padding-top: 12px;
        border-top: 2px solid var(--pos-border);
    }

    .total-val {
        font-family: var(--font-code);
        font-size: 26px;
        font-weight: 800;
        color: var(--dd-gold);
    }

    .btn-proceed-pay {
        background: var(--dd-gold);
        color: #03111F;
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
        box-shadow: 0 6px 16px rgba(0, 106, 103, 0.35);
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
                <input type="text" id="posSearchInput" placeholder="{{ __('Search garments...') }}" onkeyup="searchCatalog()" class="form-control form-control-sm border-0" style="width: 200px; font-weight:600; background: var(--pos-inner-bg); color: var(--pos-text-title);">
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
                            <div class="d-flex justify-content-between align-items-start mb-1">
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
                <div class="col-12 text-center text-muted py-5 border rounded-4" style="background: var(--pos-bg-card); border-color: var(--pos-border) !important;">
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
                <a href="{{ route('customer.create') }}" class="fw-bold fs-8 text-decoration-none" style="color: var(--dd-gold);"><i class="ti ti-user-plus me-1"></i>{{ __('New Customer') }}</a>
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

                <div class="d-flex align-items-center gap-3 mt-3 pt-3 border-top" id="custDetailDisplay" style="border-color: var(--pos-border) !important;">
                    <div class="cust-avatar-circle" id="custAvatar">C</div>
                    <div>
                        <h6 class="mb-0 fw-bold fs-7" id="custNameDisplay" style="color: var(--pos-text-title);">{{ __('Walk-in Client') }}</h6>
                        <small class="fs-8 d-block" id="custContactDisplay" style="color: var(--pos-text-sub);">{{ __('Standard Counter POS') }}</small>
                    </div>
                </div>
            </div>

            <!-- Cart Items Stack -->
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="fw-bold fs-7" style="color: var(--pos-text-title);">{{ __('Active Cart') }} <small id="cartItemsCount" style="color: var(--pos-text-sub);">(0 items)</small></span>
                <button type="button" class="btn btn-sm text-danger p-0 fw-bold border-0 bg-transparent fs-8" onclick="clearCart()">{{ __('Clear All') }}</button>
            </div>

            <div class="cart-items-stack" id="cartItemsStack" style="max-height: 240px; overflow-y: auto;">
                <div class="text-center py-4 fs-7" style="color: var(--pos-text-sub);">
                    <i class="ti ti-shopping-cart-x fs-2 d-block mb-1" style="color: var(--pos-text-sub);"></i>
                    {{ __('Cart is empty. Click garment + button to add.') }}
                </div>
            </div>
        </div>

        <!-- Financial Calculation & Submit -->
        <div>
            <!-- Payment Method Selection Pills -->
            <div class="mb-2">
                <label class="form-label fs-8 fw-bold text-uppercase mb-1" style="color: var(--pos-text-sub);">{{ __('Payment Method') }}</label>
                <div class="payment-method-pills" id="pmPills">
                    <div class="pm-pill active" onclick="setPaymentMethod('Cash', this)">
                        <i class="ti ti-cash d-block fs-6 mb-1"></i> Cash
                    </div>
                    <div class="pm-pill" onclick="setPaymentMethod('UPI', this)">
                        <i class="ti ti-qrcode d-block fs-6 mb-1"></i> UPI / QR
                    </div>
                    <div class="pm-pill" onclick="setPaymentMethod('Card', this)">
                        <i class="ti ti-credit-card d-block fs-6 mb-1"></i> Card
                    </div>
                    <div class="pm-pill" onclick="setPaymentMethod('Bank Transfer', this)">
                        <i class="ti ti-building-bank d-block fs-6 mb-1"></i> Bank
                    </div>
                </div>
            </div>

            <div class="financial-summary-stack">
                <div class="summary-line">
                    <span style="color: var(--pos-text-sub);">{{ __('Subtotal') }}</span>
                    <span id="summarySubtotal" class="fw-bold" style="color: var(--pos-text-title);">{{ subscriptionPaymentSettings()['CURRENCY_SYMBOL'] }}0.00</span>
                </div>
                <div class="summary-line d-flex align-items-center justify-content-between">
                    <span style="color: var(--pos-text-sub);">{{ __('Discount / Adjustment') }}</span>
                    <div class="input-group input-group-sm" style="width: 110px;">
                        <span class="input-group-text border-0 py-0" style="background: var(--pos-pill-bg); color: var(--pos-text-title);">{{ subscriptionPaymentSettings()['CURRENCY_SYMBOL'] }}</span>
                        <input type="number" step="0.01" min="0" class="form-control form-control-sm border-0 fw-bold text-end" id="posDiscountInput" placeholder="0.00" onkeyup="calculateTotals()" onchange="calculateTotals()" style="background: var(--pos-pill-bg); color: var(--pos-text-title);">
                    </div>
                </div>
                <div class="total-line">
                    <span class="fw-bold fs-7" style="color: var(--pos-text-title);">{{ __('TOTAL AMOUNT') }}</span>
                    <span class="total-val" id="summaryTotal">{{ subscriptionPaymentSettings()['CURRENCY_SYMBOL'] }}0.00</span>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fs-8 fw-bold text-uppercase mb-1" style="color: var(--pos-text-sub);">{{ __('Advance Payment Received') }}</label>
                <div class="input-group">
                    <span class="input-group-text border-0 fw-bold" style="background: var(--pos-pill-bg); color: var(--pos-text-title);">{{ subscriptionPaymentSettings()['CURRENCY_SYMBOL'] }}</span>
                    <input type="number" step="0.01" min="0" class="form-control form-control-sm border-0 fw-bold" id="posAdvanceInput" placeholder="0.00" style="background: var(--pos-pill-bg); color: var(--pos-text-title);">
                </div>
            </div>

            <button type="button" class="btn-proceed-pay" id="btnSubmitPos" onclick="submitPosInvoice()">
                <i class="ti ti-check fs-5"></i> {{ __('Complete & Generate POS Invoice') }}
            </button>
        </div>
    </div>
</div>

<!-- Interactive Success Receipt Modal -->
<div class="modal fade" id="posSuccessModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-body text-center p-4">
                <div class="avtar avtar-xl bg-light-success text-success rounded-circle mx-auto mb-3" style="width: 70px; height: 70px;">
                    <i class="ti ti-circle-check fs-1"></i>
                </div>
                <h4 class="font-weight-bold mb-1" style="color: #FFFFFF;">{{ __('POS Checkout Complete!') }}</h4>
                <p class="fs-7 mb-3" style="color: #8FA1B5;">{{ __('Invoice has been successfully generated and recorded.') }}</p>

                <div class="p-3 rounded-3 mb-4 text-start" style="background: #102B45;">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted fs-7">{{ __('Invoice Number') }}:</span>
                        <strong class="font-monospace" id="modalInvoiceNum" style="color: #F4C861;">#INV-1001</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted fs-7">{{ __('Customer') }}:</span>
                        <strong id="modalCustName" style="color: #FFFFFF;">Walk-in Client</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted fs-7">{{ __('Total Paid / Invoiced') }}:</span>
                        <strong class="font-monospace fs-6" id="modalTotalAmt" style="color: #D9A441;">{{ subscriptionPaymentSettings()['CURRENCY_SYMBOL'] }}0.00</strong>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <a id="btnPrintReceipt" href="#" target="_blank" class="btn btn-primary d-flex align-items-center justify-content-center gap-2 rounded-3 py-2 fw-bold">
                        <i class="ti ti-printer fs-5"></i> {{ __('View & Print Receipt') }}
                    </a>
                    <a id="btnWhatsappShare" href="#" target="_blank" class="btn btn-success d-flex align-items-center justify-content-center gap-2 rounded-3 py-2 fw-bold d-none">
                        <i class="ti ti-brand-whatsapp fs-5"></i> {{ __('Send WhatsApp Invoice') }}
                    </a>
                    <button type="button" class="btn btn-light-secondary rounded-3 py-2 fw-bold" onclick="resetPosConsole()">
                        <i class="ti ti-plus fs-5"></i> {{ __('Start Next Sale') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('script-page')
<script>
    let cart = [];
    let selectedPaymentMethod = 'Cash';
    const currencySymbol = "{!! subscriptionPaymentSettings()['CURRENCY_SYMBOL'] !!}";
    let createdInvoiceEncryptedId = '';

    $(document).ready(function() {
        updateSelectedCustomer();
    });

    function setPaymentMethod(method, el) {
        selectedPaymentMethod = method;
        document.querySelectorAll('#pmPills .pm-pill').forEach(p => p.classList.remove('active'));
        el.classList.add('active');
    }

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
        toastrs('Added', `${name} added to cart`, 'success');
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
        const rawSubtotal = cart.reduce((acc, i) => acc + (i.price * i.qty), 0);
        const discount = parseFloat(document.getElementById('posDiscountInput').value) || 0;
        const total = Math.max(0, rawSubtotal - discount);

        document.getElementById('summarySubtotal').textContent = currencySymbol + rawSubtotal.toFixed(2);
        document.getElementById('summaryTotal').textContent = currencySymbol + total.toFixed(2);
    }

    function submitPosInvoice() {
        const customerId = $('#posCustomerSelect').val();

        if (cart.length === 0) {
            show_toastr('Error', 'Please add at least one garment to cart.', 'error');
            return;
        }

        const advance = $('#posAdvanceInput').val() || 0;
        const discount = $('#posDiscountInput').val() || 0;

        const payload = {
            customer_id: customerId,
            advance_payment: advance,
            payment_method: selectedPaymentMethod,
            payment_notes: `POS Checkout (${selectedPaymentMethod})`,
            items: cart.map(item => ({
                cloth_type_id: item.id,
                quantity: item.qty,
                amount: Math.max(0, item.price - (discount / cart.length))
            }))
        };

        $('#btnSubmitPos').prop('disabled', true).html('<i class="ti ti-spin ti-spinner me-1"></i> Processing POS Checkout...');

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
                // Populate Success Modal
                document.getElementById('modalInvoiceNum').textContent = data.invoice_number || '#INV';
                document.getElementById('modalCustName').textContent = data.customer_name || 'Walk-in Client';
                document.getElementById('modalTotalAmt').textContent = currencySymbol + data.total_amount;

                const printUrl = "{{ url('/invoice') }}/" + data.encrypted_id;
                document.getElementById('btnPrintReceipt').setAttribute('href', printUrl);

                if (data.customer_phone) {
                    const waMsg = encodeURIComponent(`Hello ${data.customer_name}, thank you for your order with DarziDesk! Your invoice ${data.invoice_number} of ${currencySymbol}${data.total_amount} has been generated. View details: ${printUrl}`);
                    const waUrl = `https://api.whatsapp.com/send?phone=${data.customer_phone}&text=${waMsg}`;
                    const waBtn = document.getElementById('btnWhatsappShare');
                    waBtn.setAttribute('href', waUrl);
                    waBtn.classList.remove('d-none');
                }

                // Show Success Modal
                const modal = new bootstrap.Modal(document.getElementById('posSuccessModal'));
                modal.show();
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

    function resetPosConsole() {
        const modalEl = document.getElementById('posSuccessModal');
        const modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();

        clearCart();
        $('#posAdvanceInput').val('');
        $('#posDiscountInput').val('');
        $('#posCustomerSelect').val('');
        updateSelectedCustomer();
    }
</script>
@endpush
@endsection
