<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Garment Tag - #{{ $order->order_id }}</title>
    <style>
        @page { size: 80mm 150mm; margin: 5mm; }
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #000; margin: 0; padding: 0; font-size: 11px; }
        .tag-container { width: 100%; border: 2px solid #006A67; padding: 8px; box-sizing: border-box; text-align: center; }
        .brand { font-size: 18px; font-weight: 800; color: #006A67; letter-spacing: 1px; margin-bottom: 2px; }
        .sub-brand { font-size: 9px; text-transform: uppercase; color: #555; margin-bottom: 8px; border-bottom: 1px solid #006A67; padding-bottom: 4px; }
        .order-num { font-size: 20px; font-weight: 900; background: #006A67; color: #fff; padding: 4px 8px; margin: 6px 0; border-radius: 4px; display: inline-block; }
        .customer-info { text-align: left; margin: 10px 0; font-size: 11px; }
        .info-row { margin-bottom: 4px; }
        .label { font-weight: bold; color: #333; }
        .val { font-weight: 600; color: #006A67; }
        .meas-box { background: #F4F7F6; border: 1px dashed #006A67; padding: 6px; text-align: left; margin: 8px 0; border-radius: 4px; }
        .meas-title { font-weight: 800; font-size: 10px; color: #006A67; text-transform: uppercase; margin-bottom: 4px; text-align: center; }
        .meas-grid { display: table; width: 100%; }
        .meas-row { display: table-row; }
        .meas-cell { display: table-cell; width: 50%; font-size: 10px; padding: 2px 0; }
        .qr-placeholder { margin: 10px 0; }
        .footer-note { font-size: 8.5px; color: #666; margin-top: 6px; border-top: 1px solid #ddd; padding-top: 4px; }
    </style>
</head>
<body>
    <div class="tag-container">
        <div class="brand">DARZIDESK</div>
        <div class="sub-brand">Bespoke Atelier Garment Tag</div>

        <div class="order-num">#{{ $order->order_id }}</div>

        <div class="customer-info">
            <div class="info-row"><span class="label">Customer:</span> <span class="val">{{ $order->customers->name ?? 'N/A' }}</span></div>
            <div class="info-row"><span class="label">Phone:</span> {{ $order->customers->phone_number ?? 'N/A' }}</div>
            <div class="info-row"><span class="label">Garment:</span> <span class="val">{{ $order->clothTypes->title ?? $order->febric ?? 'Custom Suit' }}</span></div>
            <div class="info-row"><span class="label">Fabric:</span> {{ $order->febric ?? 'Standard' }} ({{ $order->febric_color ?? 'Default' }})</div>
            <div class="info-row"><span class="label">DueDate:</span> <strong>{{ $order->deadline_date ?? 'To Be Scheduled' }}</strong></div>
        </div>

        @if(!empty($order->measurement))
        <div class="meas-box">
            <div class="meas-title">ATELIER MEASUREMENTS</div>
            <div class="meas-grid">
                @php
                    $measData = is_array($order->measurement) ? $order->measurement : json_decode($order->measurement, true);
                @endphp
                @if(is_array($measData))
                    @foreach(array_slice($measData, 0, 8, true) as $k => $v)
                    <div class="meas-row">
                        <span class="label">{{ ucfirst(str_replace('_', ' ', $k)) }}:</span> 
                        <span class="val">{{ is_array($v) ? implode(', ', $v) : $v }}</span>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
        @endif

        @if(!empty($order->notes))
        <div style="font-size: 9px; text-align: left; background: #fff3cd; padding: 4px; border-radius: 3px; margin: 4px 0;">
            <strong>Tailor Notes:</strong> {{ $order->notes }}
        </div>
        @endif

        <div class="footer-note">
            Scan QR code or barcode to view live fitting history & audit trail.<br>
            www.darzidesk.shop
        </div>
    </div>
</body>
</html>
