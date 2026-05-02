<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Receipt - {{ invoicePrefix() . $invoice->invoice_id }}</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; color: #333; margin: 0; padding: 0; font-size: 12px; }
        .receipt-box { width: 100%; padding: 20px; }
        .header { border-bottom: 2px solid #1a73e8; padding-bottom: 10px; margin-bottom: 20px; }
        .logo { font-size: 28px; font-weight: bold; color: #1a73e8; float: left; }
        .invoice-info { float: right; text-align: right; }
        .clear { clear: both; }
        .details { margin-bottom: 30px; margin-top: 20px; }
        .details table { width: 100%; border-collapse: collapse; }
        .details th { text-align: left; background: #f0f4f8; padding: 8px; border: 1px solid #dee2e6; }
        .details td { padding: 8px; border: 1px solid #dee2e6; }
        .totals-container { margin-top: 20px; }
        .totals { float: right; width: 250px; }
        .totals table { width: 100%; border-collapse: collapse; }
        .totals td { padding: 5px; border: none; }
        .total-row { font-weight: bold; font-size: 16px; color: #1a73e8; border-top: 2px solid #1a73e8 !important; }
        .footer { clear: both; margin-top: 100px; text-align: center; color: #666; font-size: 10px; border-top: 1px solid #eee; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="receipt-box">
        <div class="header">
            <div class="logo">DarziDesk</div>
            <div class="invoice-info">
                <div><strong>INVOICE:</strong> {{ invoicePrefix() . $invoice->invoice_id }}</div>
                <div><strong>DATE:</strong> {{ dateFormat($invoice->invoice_date) }}</div>
            </div>
            <div class="clear"></div>
        </div>

        <div class="details">
            <div><strong>To:</strong></div>
            <div>{{ $invoice->customers->name }}</div>
            <div>{{ $invoice->customers->phone_number }}</div>
        </div>

        <div class="details">
            <table>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoice->items as $item)
                    <tr>
                        <td>{{ $item->clothType->title ?? 'Tailoring Service' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ priceFormat($item->amount) }}</td>
                        <td>{{ priceFormat($item->amount * $item->quantity) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="totals-container">
            <div class="totals">
                <table>
                    <tr>
                        <td>Subtotal:</td>
                        <td>{{ priceFormat($invoice->getInvoiceSubTotalAmount()) }}</td>
                    </tr>
                    <tr>
                        <td>Tax:</td>
                        <td>{{ priceFormat($invoice->getInvoiceTotalTax()) }}</td>
                    </tr>
                    <tr class="total-row">
                        <td>Grand Total:</td>
                        <td>{{ priceFormat($invoice->getInvoiceTotalAmount()) }}</td>
                    </tr>
                </table>
            </div>
            <div class="clear"></div>
        </div>

        <div class="footer">
            <p>Thank you for choosing DarziDesk!</p>
            <p>{{ settings()['company_name'] }} • {{ settings()['company_phone'] }}</p>
        </div>
    </div>
</body>
</html>
