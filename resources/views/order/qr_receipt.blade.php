<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Garment Tag & Receipt #{{ orderPrefix() . $order->order_id }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; width: 350px; margin: 0 auto; padding: 20px; border: 1px dashed #ccc; }
        .text-center { text-align: center; }
        .fw-bold { font-weight: bold; }
        .text-muted { color: #666; font-size: 12px; }
        .divider { border-top: 1px solid #ddd; margin: 15px 0; }
        .table { width: 100%; border-collapse: collapse; font-size: 13px; }
        .table td { padding: 4px 0; }
        .qr-img { margin-top: 10px; border: 1px solid #eee; padding: 5px; }
        @media print {
            body { border: none; padding: 0; width: 100%; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="text-center no-print" style="margin-bottom: 15px;">
        <button onclick="window.print()" style="padding: 8px 16px; background: #3b82f6; color: white; border: none; border-radius: 4px; cursor: pointer;">🖨️ Print Receipt Tag</button>
    </div>

    <div class="text-center">
        <h2 style="margin: 0; font-size: 20px;">DARZIDESK TAILORS</h2>
        <p class="text-muted" style="margin: 3px 0 10px;">Tailoring Order Slip & Tag</p>
    </div>

    <div class="divider"></div>

    <table class="table">
        <tr>
            <td class="text-muted">Order ID:</td>
            <td class="fw-bold text-center" style="font-size: 16px;">{{ orderPrefix() . $order->order_id }}</td>
        </tr>
        <tr>
            <td class="text-muted">Customer:</td>
            <td class="fw-bold">{{ $order->customers->name ?? '-' }}</td>
        </tr>
        <tr>
            <td class="text-muted">Order Date:</td>
            <td>{{ dateFormat($order->order_date) }}</td>
        </tr>
        <tr>
            <td class="text-muted">Target Trial / Due:</td>
            <td class="fw-bold">{{ dateFormat($order->deadline_date) }}</td>
        </tr>
        <tr>
            <td class="text-muted">Garment:</td>
            <td class="fw-bold">{{ $order->clothTypes->title ?? 'Garment' }} (Qty: {{ $order->quantity }})</td>
        </tr>
        <tr>
            <td class="text-muted">Fabric:</td>
            <td>{{ $order->febric ?? 'Customer Cloth' }} ({{ $order->febric_color ?? '-' }})</td>
        </tr>
    </table>

    <div class="divider"></div>

    <div class="text-center">
        <img class="qr-img" src="https://api.qrserver.com/v1/create-qr-code/?size=140x140&data={{ urlencode($trackingUrl) }}" alt="Order QR Code">
        <p class="text-muted" style="margin-top: 8px;">Scan to check live status online</p>
    </div>

    <div class="divider"></div>

    <div class="text-center text-muted" style="font-size: 11px;">
        Thank you for choosing DarziDesk!
    </div>
</body>
</html>
