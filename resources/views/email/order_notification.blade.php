<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }} - DarziDesk</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f4f7f6; color: #333; margin: 0; padding: 40px 0; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .header { background: #006A67; color: #ffffff; padding: 25px 30px; }
        .header h1 { margin: 0; font-size: 22px; }
        .content { padding: 30px; }
        .order-card { background: #F8F9FA; border-left: 4px solid #006A67; padding: 18px; margin: 20px 0; border-radius: 0 8px 8px 0; }
        .detail-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px dashed #e0e0e0; }
        .detail-label { font-weight: 600; color: #555; }
        .detail-val { color: #111; font-weight: 500; }
        .footer { background: #fafafa; padding: 20px; text-align: center; font-size: 12px; color: #888888; border-top: 1px solid #eeeeee; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>DarziDesk</h1>
            <p style="margin: 4px 0 0 0; font-size: 13px; opacity: 0.9;">Bespoke Order Update</p>
        </div>
        <div class="content">
            <h2>{{ $title }}</h2>
            <p>Dear Valued Customer,</p>
            <p>{{ $customMessage ?: 'Your bespoke order details have been updated by our atelier.' }}</p>

            <div class="order-card">
                <div class="detail-row">
                    <span class="detail-label">Order Number:</span>
                    <span class="detail-val">#{{ $order->order_id }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Garment Type:</span>
                    <span class="detail-val">{{ $order->clothTypes->title ?? $order->febric ?? 'Custom Suit' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Fabric / Color:</span>
                    <span class="detail-val">{{ $order->febric ?? 'Standard' }} ({{ $order->febric_color ?? 'Default' }})</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Status:</span>
                    <span class="detail-val" style="color: #006A67; font-weight: 700;">{{ strtoupper($order->status) }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Estimated Delivery:</span>
                    <span class="detail-val">{{ $order->deadline_date ?? 'To be scheduled' }}</span>
                </div>
            </div>

            <p style="text-align: center; margin-top: 25px;">
                <a href="{{ config('app.url') }}/api/orders/track/{{ $order->tracking_token ?? $order->order_id }}" style="background: #006A67; color: #fff; text-decoration: none; padding: 12px 24px; border-radius: 6px; font-weight: 600; display: inline-block;">Track Order Status</a>
            </p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} DarziDesk TMS. All rights reserved.
        </div>
    </div>
</body>
</html>
