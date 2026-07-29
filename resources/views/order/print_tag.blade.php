<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Garment Tag - Order #{{ $order->order_id }}</title>
    <style>
        @page { size: 58mm 40mm; margin: 0; }
        body {
            width: 56mm;
            height: 38mm;
            font-family: Arial, sans-serif;
            font-size: 10px;
            margin: 0 auto;
            padding: 4px;
            box-sizing: border-box;
            border: 1px dashed #000;
        }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #000; padding-bottom: 2px; }
        .order-id { font-weight: bold; font-size: 12px; }
        .content { display: flex; margin-top: 4px; }
        .info { flex: 1; }
        .qr { width: 45px; text-align: right; }
        .qr img { width: 45px; height: 45px; }
        .bold { font-weight: bold; }
        @media print {
            .no-print { display: none; }
            body { border: none; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 5px; text-align: center;">
        <button onclick="window.print()" style="padding: 4px 10px; background: #2563EB; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 11px;">🖨️ Print Tag</button>
    </div>

    <div class="header">
        <span class="order-id">#{{ $order->order_id }}</span>
        <span>{{ $order->deadline_date }}</span>
    </div>

    <div class="content">
        <div class="info">
            <div><span class="bold">Cust:</span> {{ Str::limit($order->customers->name ?? 'Guest', 14) }}</div>
            <div><span class="bold">Type:</span> {{ $order->clothTypes->title ?? '-' }}</div>
            <div><span class="bold">Stage:</span> {{ $order->productionStage->name ?? 'Pending' }}</div>
        </div>
        <div class="qr">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data={{ urlencode($order->tracking_token ?? $order->order_id) }}" alt="QR">
        </div>
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
