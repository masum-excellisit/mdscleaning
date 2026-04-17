<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $order->order_number }}</title>
    <style>
        @page { margin: 24mm 16mm; }
        body { font-family: DejaVu Sans, sans-serif; color:#16324a; font-size:11px; line-height:1.5; }
        .header { display:table; width:100%; margin-bottom:24px; }
        .brand-block, .meta-block { display:table-cell; vertical-align:top; }
        .brand-block { width:60%; }
        .meta-block { width:40%; text-align:right; }
        .brand-name { font-size:24px; font-weight:bold; color:#79afe3; letter-spacing:1px; }
        .brand-tagline { font-size:10px; color:#607487; }
        .meta-block h2 { margin:0; font-size:18px; }
        .meta-block p { margin:2px 0; font-size:10px; }
        .addresses { display:table; width:100%; margin-bottom:18px; }
        .addr-block { display:table-cell; width:50%; vertical-align:top; padding-right:16px; }
        .addr-block h4 { margin:0 0 6px; font-size:11px; text-transform:uppercase; color:#607487; letter-spacing:.5px; }
        .addr-block p { margin:0; line-height:1.45; font-size:11px; }
        table.items { width:100%; border-collapse:collapse; margin:18px 0; }
        table.items th { background:#16324a; color:#fff; text-align:left; padding:8px 10px; font-size:11px; }
        table.items td { padding:8px 10px; border-bottom:1px solid #eaf2fb; font-size:11px; vertical-align:top; }
        table.items td.num { text-align:right; white-space:nowrap; }
        .totals { width:42%; margin-left:58%; margin-top:6px; }
        .totals td { padding:4px 8px; }
        .totals .total-row td { border-top:2px solid #16324a; font-weight:bold; font-size:13px; padding-top:8px; }
        .badge { display:inline-block; padding:2px 8px; border-radius:10px; font-size:10px; font-weight:bold; }
        .badge-paid { background:#d1f2dc; color:#157347; }
        .badge-unpaid { background:#fff3cd; color:#664d03; }
        .footer { margin-top:30px; text-align:center; font-size:10px; color:#607487; border-top:1px solid #d7e6f5; padding-top:12px; }
    </style>
</head>
<body>

<div class="header">
    <div class="brand-block">
        <div class="brand-name">{{ setting('site_name', 'CSTEES') }}</div>
        <div class="brand-tagline">{{ setting('site_tagline', 'Wear the Story') }}</div>
        <p style="margin-top:6px; font-size:10px;">
            {{ setting('site_address', 'Kolkata, India') }}<br>
            {{ setting('site_email', 'support@cstees.com') }}
            @if($p = setting('site_phone'))&nbsp;&middot;&nbsp;{{ $p }}@endif
        </p>
    </div>
    <div class="meta-block">
        <h2>INVOICE</h2>
        <p><strong>{{ $order->order_number }}</strong></p>
        <p>Date: {{ $order->created_at->format('d M Y') }}</p>
        <p>Payment:
            <span class="badge {{ $order->payment_status === 'paid' ? 'badge-paid' : 'badge-unpaid' }}">{{ strtoupper($order->payment_status) }}</span>
        </p>
        <p>Method: {{ strtoupper($order->payment_method) }}</p>
    </div>
</div>

<div class="addresses">
    @php
        $bill = $order->addresses->firstWhere('type', 'billing');
        $ship = $order->addresses->firstWhere('type', 'shipping');
    @endphp
    <div class="addr-block">
        <h4>Bill To</h4>
        @if($bill)
            <p><strong>{{ $bill->name }}</strong><br>
            {{ $bill->line1 }}@if($bill->line2)<br>{{ $bill->line2 }}@endif<br>
            {{ $bill->city }}, {{ $bill->state }} {{ $bill->zip }}<br>
            {{ $bill->country }}<br>
            {{ $bill->phone }}</p>
        @endif
    </div>
    <div class="addr-block">
        <h4>Ship To</h4>
        @if($ship)
            <p><strong>{{ $ship->name }}</strong><br>
            {{ $ship->line1 }}@if($ship->line2)<br>{{ $ship->line2 }}@endif<br>
            {{ $ship->city }}, {{ $ship->state }} {{ $ship->zip }}<br>
            {{ $ship->country }}<br>
            {{ $ship->phone }}</p>
        @endif
    </div>
</div>

<table class="items">
    <thead>
        <tr>
            <th style="width:48%;">Item</th>
            <th style="width:18%;">SKU</th>
            <th class="num" style="width:8%;">Qty</th>
            <th class="num" style="width:13%;">Price</th>
            <th class="num" style="width:13%;">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($order->items as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->sku ?? '—' }}</td>
                <td class="num">{{ $item->qty }}</td>
                <td class="num">{{ format_price($item->price) }}</td>
                <td class="num">{{ format_price($item->total) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<table class="totals">
    <tr><td>Subtotal</td><td class="num">{{ format_price($order->subtotal) }}</td></tr>
    @if($order->discount > 0)
        <tr><td>Discount</td><td class="num">−{{ format_price($order->discount) }}</td></tr>
    @endif
    @if($order->shipping_fee > 0)
        <tr><td>Shipping</td><td class="num">{{ format_price($order->shipping_fee) }}</td></tr>
    @else
        <tr><td>Shipping</td><td class="num">FREE</td></tr>
    @endif
    @if($order->tax > 0)
        <tr><td>{{ setting('tax_label', 'Tax') }} ({{ setting('tax_rate', config('cstees.tax.rate')) }}%)</td><td class="num">{{ format_price($order->tax) }}</td></tr>
    @endif
    <tr class="total-row"><td>TOTAL</td><td class="num">{{ format_price($order->total) }}</td></tr>
</table>

@if($order->notes)
    <div style="margin-top:30px; padding:12px; background:#f5fafe; border-left:3px solid #79afe3;">
        <strong>Notes:</strong><br>{{ $order->notes }}
    </div>
@endif

<div class="footer">
    Thank you for shopping with {{ setting('site_name', 'cstees') }}!<br>
    For support, contact {{ setting('site_email', 'support@cstees.com') }}.
</div>

</body>
</html>
