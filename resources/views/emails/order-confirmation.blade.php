<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Confirmation</title>
    <style>
        body { font-family: -apple-system, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; background:#edf6ff; margin:0; padding:24px; color:#16324a; }
        .wrap { max-width:640px; margin:0 auto; background:#fff; border-radius:14px; overflow:hidden; box-shadow:0 6px 30px rgba(22,50,74,.08); }
        .head { background:#79afe3; color:#fff; padding:24px 28px; }
        .head h1 { margin:0; font-size:22px; }
        .body { padding:24px 28px; }
        h2 { font-size:16px; margin:24px 0 12px; color:#16324a; border-bottom:1px solid #d7e6f5; padding-bottom:8px; }
        table { width:100%; border-collapse:collapse; }
        td { padding:8px 0; border-bottom:1px solid #eaf2fb; vertical-align:top; font-size:14px; }
        .totals td { border:0; padding:4px 0; }
        .total-row td { font-weight:700; font-size:16px; padding-top:10px; border-top:2px solid #16324a; }
        .pill { display:inline-block; background:#d9ebff; color:#16324a; padding:4px 10px; border-radius:999px; font-size:12px; font-weight:600; }
        .foot { background:#f5fafe; padding:20px 28px; text-align:center; font-size:12px; color:#607487; }
        .btn { display:inline-block; background:#79afe3; color:#fff; padding:12px 22px; border-radius:8px; text-decoration:none; font-weight:600; }
        a { color:#4e87c3; }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="head">
            <h1>Thanks for your order, {{ $order->user->name }}!</h1>
            <p style="margin:6px 0 0; opacity:.95;">Order <strong>{{ $order->order_number }}</strong> — placed {{ $order->created_at->format('d M Y') }}</p>
        </div>

        <div class="body">
            <p>Hi {{ $order->user->name }},</p>
            <p>We've received your order and we're getting it ready. You'll get another email once it ships.</p>
            <p><span class="pill">{{ ucfirst($order->status) }}</span> &nbsp; <span class="pill">{{ ucfirst($order->payment_status) }}</span></p>

            <h2>Items</h2>
            <table>
                @foreach($order->items as $item)
                    <tr>
                        <td>
                            <strong>{{ $item->name }}</strong><br>
                            <span style="color:#607487; font-size:12px;">SKU: {{ $item->sku ?? '—' }} &middot; Qty: {{ $item->qty }}</span>
                        </td>
                        <td style="text-align:right; white-space:nowrap;">{{ format_price($item->total) }}</td>
                    </tr>
                @endforeach
            </table>

            <h2>Order Total</h2>
            <table class="totals">
                <tr><td>Subtotal</td><td style="text-align:right;">{{ format_price($order->subtotal) }}</td></tr>
                @if($order->discount > 0)
                    <tr><td>Discount</td><td style="text-align:right;">−{{ format_price($order->discount) }}</td></tr>
                @endif
                @if($order->shipping_fee > 0)
                    <tr><td>Shipping</td><td style="text-align:right;">{{ format_price($order->shipping_fee) }}</td></tr>
                @else
                    <tr><td>Shipping</td><td style="text-align:right; color:#157347;">FREE</td></tr>
                @endif
                @if($order->tax > 0)
                    <tr><td>{{ setting('tax_label', 'Tax') }}</td><td style="text-align:right;">{{ format_price($order->tax) }}</td></tr>
                @endif
                <tr class="total-row"><td>Total</td><td style="text-align:right;">{{ format_price($order->total) }}</td></tr>
            </table>

            <h2>Shipping To</h2>
            @php $ship = $order->addresses->firstWhere('type', 'shipping'); @endphp
            @if($ship)
                <p style="line-height:1.6;">
                    <strong>{{ $ship->name }}</strong><br>
                    {{ $ship->line1 }}<br>
                    @if($ship->line2){{ $ship->line2 }}<br>@endif
                    {{ $ship->city }}, {{ $ship->state }} — {{ $ship->zip }}<br>
                    {{ $ship->country }}<br>
                    Phone: {{ $ship->phone }}
                </p>
            @endif

            <p style="text-align:center; margin:30px 0 10px;">
                <a class="btn" href="{{ url('/') }}/account/orders/{{ $order->order_number }}">View Order Online</a>
            </p>

            <p style="margin-top:24px;">Questions? Reply to this email or reach us at <a href="mailto:{{ setting('site_email', 'support@cstees.com') }}">{{ setting('site_email', 'support@cstees.com') }}</a>.</p>
            <p>— The {{ setting('site_name', 'cstees') }} team</p>
        </div>

        <div class="foot">
            &copy; {{ date('Y') }} {{ setting('site_name', 'cstees') }}. All rights reserved.<br>
            {{ setting('site_address', 'Kolkata, India') }}
        </div>
    </div>
</body>
</html>
