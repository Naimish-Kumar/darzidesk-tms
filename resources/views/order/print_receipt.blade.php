<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Thermal Receipt - Order #{{ $order->order_id }}</title>
    <style>
        @page { size: 80mm auto; margin: 0; }
        body {
            width: 78mm;
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            margin: 0 auto;
            padding: 10px;
            color: #000;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .bold { font-weight: bold; }
        .line { border-bottom: 1px dashed #000; margin: 8px 0; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { text-align: left; padding: 3px 0; }
        .qr-container { text-align: center; margin: 10px 0; }
        .qr-container img { width: 120px; height: 120px; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 10px; text-align: center;">
        <button onclick="window.print()" style="padding: 8px 16px; background: #059669; color: white; border: none; border-radius: 4px; cursor: pointer;">🖨️ Print Receipt</button>
    </div>

    <div class="text-center">
        <h2 style="margin: 0; font-size: 16px;">{{ settings()['app_name'] ?? 'DarziDesk' }}</h2>
        <div>{{ settings()['company_address'] ?? 'Custom Tailoring Studio' }}</div>
        <div>Ph: {{ settings()['company_phone'] ?? '-' }}</div>
    </div>

    <div class="line"></div>

    <div>
        <div><span class="bold">Order #:</span> {{ $order->order_id }}</div>
        <div><span class="bold">Date:</span> {{ $order->order_date }}</div>
        <div><span class="bold">Customer:</span> {{ $order->customers->name ?? 'Guest' }}</div>
        <div><span class="bold">Phone:</span> {{ $order->customers->phone_number ?? '-' }}</div>
        <div><span class="bold">Deadline:</span> {{ $order->deadline_date }}</div>
    </div>

    <div class="line"></div>

    <table class="table">
        <thead>
            <tr>
                <th>Item / Garment</th>
                <th class="text-right">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $order->clothTypes->title ?? 'Stitching Work' }}</td>
                <td class="text-right">{{ settings()['CURRENCY_SYMBOL'] ?? '₹' }}{{ number_format($order->total_amount, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="line"></div>

    <div class="text-right">
        <div><span class="bold">Total Amount:</span> {{ settings()['CURRENCY_SYMBOL'] ?? '₹' }}{{ number_format($order->total_amount, 2) }}</div>
        <div><span class="bold">Advance Paid:</span> {{ settings()['CURRENCY_SYMBOL'] ?? '₹' }}{{ number_format($order->advance_payment ?? 0, 2) }}</div>
        <div><span class="bold">Balance Due:</span> {{ settings()['CURRENCY_SYMBOL'] ?? '₹' }}{{ number_format(($order->total_amount - ($order->advance_payment ?? 0)), 2) }}</div>
    </div>

    <div class="line"></div>

    <div class="qr-container">
        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode($order->tracking_token ?? $order->order_id) }}" alt="QR Code">
        <div style="font-size: 10px; margin-top: 4px;">Scan to Track Order</div>
    </div>

    <div class="text-center" style="font-size: 10px; margin-top: 10px;">
        Thank you for your business!<br>
        {{ settings()['invoice_footer_notes'] ?? 'Please bring receipt for pickup.' }}
    </div>

    <script>
        window.onload = function() {
            if (window.location.search.includes('autoprint=1')) {
                window.print();
            }
        };
    </script>
</body>
</html>
