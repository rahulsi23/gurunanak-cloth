<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Order Alert - Gurunanak Cloth House</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f1f5f9; /* Slate 100 */
            color: #0f172a; /* Slate 900 */
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border: 1px solid #cbd5e1;
            border-top: 4px solid #8b5cf6; /* Violet 500 */
        }
        .header {
            padding: 20px;
            border-bottom: 1px solid #e2e8f0;
        }
        .header h2 {
            margin: 0;
            color: #0f172a;
        }
        .content {
            padding: 20px;
        }
        .meta-box {
            background: #f8fafc;
            padding: 15px;
            border: 1px solid #e2e8f0;
            margin-bottom: 20px;
        }
        .total-amount {
            font-size: 24px;
            font-weight: bold;
            color: #10b981; /* Emerald 500 */
        }
        .customer-info {
            margin-bottom: 20px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #0f172a;
            color: #ffffff;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>New Order Received! 🛍️</h2>
        </div>
        
        <div class="content">
            <div class="meta-box">
                <div class="total-amount">${{ number_format($order->total_amount, 2) }}</div>
                <p style="margin: 5px 0 0 0; color: #64748b;">Order #{{ $order->order_number }}</p>
            </div>
            
            <div class="customer-info">
                <strong>Customer Details:</strong><br>
                Name: {{ $order->customer_name }}<br>
                Email: {{ $order->customer_email }}<br>
                Phone: {{ $order->customer_phone }}<br>
                Address: {{ $order->shipping_address }}
            </div>

            <p>Please log in to the admin panel to process this order and print the shipping label.</p>
            
            <a href="{{ url('/admin/orders') }}" class="btn">View Order in Dashboard</a>
        </div>
    </div>
</body>
</html>
