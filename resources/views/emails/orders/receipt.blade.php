<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Your Order Receipt - Gurunanak Cloth House</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #fcfbf9;
            color: #1c1917;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border: 1px solid #eae4d8;
        }
        .header {
            text-align: center;
            padding: 40px 20px;
            background: #0f172a; /* Slate 900 */
            color: #ffffff;
        }
        .brand {
            font-size: 24px;
            font-weight: 700;
            letter-spacing: 4px;
            margin: 0;
            text-transform: uppercase;
        }
        .subtitle {
            font-size: 10px;
            color: #8b7355;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-top: 5px;
        }
        .content {
            padding: 40px;
        }
        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
        }
        .order-meta {
            background: #f5efe6;
            padding: 15px;
            border-left: 3px solid #8b7355;
            margin-bottom: 30px;
            font-size: 14px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .items-table th {
            text-align: left;
            border-bottom: 1px solid #eae4d8;
            padding-bottom: 10px;
            font-size: 12px;
            text-transform: uppercase;
            color: #786451;
        }
        .items-table td {
            padding: 15px 0;
            border-bottom: 1px solid #eae4d8;
            font-size: 14px;
        }
        .totals {
            width: 100%;
            border-collapse: collapse;
        }
        .totals td {
            padding: 5px 0;
            text-align: right;
            font-size: 14px;
        }
        .totals .grand-total {
            font-size: 18px;
            font-weight: bold;
            color: #9a3412;
            border-top: 2px solid #1c1917;
            padding-top: 10px;
            margin-top: 10px;
        }
        .footer {
            text-align: center;
            padding: 30px;
            font-size: 12px;
            color: #786451;
            border-top: 1px solid #eae4d8;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 class="brand">Gurunanak</h1>
            <div class="subtitle">Cloth House</div>
        </div>
        
        <div class="content">
            <div class="greeting">
                Hello {{ $order->customer_name }},
            </div>
            <p>Thank you for shopping with us. We have received your order and our atelier is preparing it for dispatch.</p>
            
            <div class="order-meta">
                <strong>Order Number:</strong> {{ $order->order_number }}<br>
                <strong>Order Date:</strong> {{ $order->created_at->format('F j, Y') }}<br>
                <strong>Shipping To:</strong> {{ $order->shipping_address }}
            </div>

            <table class="items-table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th style="text-align: right;">Qty</th>
                        <th style="text-align: right;">Price</th>
                    </tr>
                </thead>
                <tbody>
                    @php $items = is_string($order->items) ? json_decode($order->items, true) : $order->items; @endphp
                    @foreach($items as $item)
                    <tr>
                        <td>
                            <strong>{{ $item['title'] ?? 'Product' }}</strong><br>
                            <span style="font-size: 12px; color: #786451;">Size: {{ $item['size'] ?? 'N/A' }} | Color: {{ $item['color'] ?? 'N/A' }}</span>
                        </td>
                        <td style="text-align: right;">{{ $item['qty'] ?? 1 }}</td>
                        <td style="text-align: right;">${{ number_format(($item['price'] ?? 0) * ($item['qty'] ?? 1), 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <table class="totals">
                <tr>
                    <td style="width: 70%;">Subtotal:</td>
                    <td>${{ number_format($order->total_amount, 2) }}</td>
                </tr>
                <tr>
                    <td class="grand-total">Total:</td>
                    <td class="grand-total">${{ number_format($order->total_amount, 2) }}</td>
                </tr>
            </table>
        </div>

        <div class="footer">
            If you have any questions, please reply to this email or contact our support.<br>
            &copy; {{ date('Y') }} Gurunanak Cloth House. All rights reserved.
        </div>
    </div>
</body>
</html>
