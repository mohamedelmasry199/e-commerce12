<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #f4f4f5;
            color: #18181b;
            font-size: 14px;
            line-height: 1.6;
        }

        .wrapper {
            max-width: 580px;
            margin: 32px auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e4e4e7;
        }

        /* ── Header ─────────────────────────────── */
        .header {
            background: #18181b;
            padding: 32px 40px;
            text-align: center;
        }
        .header .logo {
            color: #ffffff;
            font-size: 20px;
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        /* ── Hero ───────────────────────────────── */
        .hero {
            padding: 36px 40px 28px;
            text-align: center;
            border-bottom: 1px solid #f4f4f5;
        }
        .hero-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 56px;
            height: 56px;
            background: #f0fdf4;
            border-radius: 50%;
            margin-bottom: 16px;
            font-size: 26px;
        }
        .hero h1 {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 6px;
            color: #18181b;
        }
        .hero p {
            color: #71717a;
            font-size: 13px;
        }
        .order-number {
            display: inline-block;
            background: #f4f4f5;
            border-radius: 6px;
            padding: 4px 12px;
            font-size: 12px;
            font-weight: 500;
            color: #52525b;
            margin-top: 10px;
            letter-spacing: 0.02em;
        }

        /* ── Body ───────────────────────────────── */
        .body { padding: 28px 40px; }

        /* ── Section title ──────────────────────── */
        .section-title {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #a1a1aa;
            margin-bottom: 12px;
        }

        /* ── Items ──────────────────────────────── */
        .items-section { margin-bottom: 28px; }
        .item-row {
            display: flex;
            gap: 14px;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f4f4f5;
        }
        .item-row:last-child { border-bottom: none; }
        .item-image {
            width: 48px;
            height: 48px;
            border-radius: 8px;
            object-fit: cover;
            background: #f4f4f5;
            flex-shrink: 0;
        }
        .item-info { flex: 1; min-width: 0; }
        .item-name {
            font-size: 13px;
            font-weight: 500;
            color: #18181b;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .item-meta {
            font-size: 11px;
            color: #a1a1aa;
            margin-top: 2px;
        }
        .item-price {
            font-size: 13px;
            font-weight: 500;
            color: #18181b;
            white-space: nowrap;
        }

        /* ── Totals ─────────────────────────────── */
        .totals-section {
            background: #fafafa;
            border-radius: 10px;
            padding: 16px 18px;
            margin-bottom: 28px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            padding: 4px 0;
        }
        .total-row .label { color: #71717a; }
        .total-row .value { color: #18181b; }
        .total-row.discount .label,
        .total-row.discount .value { color: #16a34a; }
        .total-row.grand { padding-top: 10px; margin-top: 6px; border-top: 1px solid #e4e4e7; }
        .total-row.grand .label,
        .total-row.grand .value { font-weight: 600; font-size: 14px; color: #18181b; }

        /* ── Address ────────────────────────────── */
        .address-section { margin-bottom: 28px; }
        .address-box {
            background: #fafafa;
            border-radius: 10px;
            padding: 16px 18px;
            font-size: 13px;
            color: #52525b;
            line-height: 1.7;
        }
        .address-name { font-weight: 500; color: #18181b; }

        /* ── CTA Button ─────────────────────────── */
        .cta-section { text-align: center; margin-bottom: 28px; }
        .cta-btn {
            display: inline-block;
            background: #18181b;
            color: #ffffff !important;
            text-decoration: none;
            padding: 12px 32px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
        }

        /* ── Footer ─────────────────────────────── */
        .footer {
            padding: 20px 40px 28px;
            border-top: 1px solid #f4f4f5;
            text-align: center;
        }
        .footer p {
            font-size: 11px;
            color: #a1a1aa;
            line-height: 1.6;
        }
        .footer a { color: #71717a; text-decoration: none; }
    </style>
</head>
<body>
<div class="wrapper">

    {{-- Header --}}
    <div class="header">
        <div class="logo">{{ config('app.name') }}</div>
    </div>

    {{-- Hero --}}
    <div class="hero">
        <div class="hero-icon">✓</div>
        <h1>{{ __('mail.order_confirmation.heading') }}</h1>
        <p>{{ __('mail.order_confirmation.subheading', ['name' => $order->user_name]) }}</p>
        <div class="order-number">
            {{ __('checkout.success.order_number') }} #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
        </div>
    </div>

    {{-- Body --}}
    <div class="body">

        {{-- Items --}}
        <div class="items-section">
            <p class="section-title">{{ __('checkout.order_summary') }}</p>
            @foreach($order->items as $item)
            <div class="item-row">
                @if($item->product)
                    <img class="item-image"
                         src="{{ $item->product->getFirstImage() }}"
                         alt="{{ $item->product_name }}">
                @else
                    <div class="item-image"></div>
                @endif
                <div class="item-info">
                    <div class="item-name">{{ $item->product_name }}</div>
                    <div class="item-meta">
                        @if($item->attributes)
                            {{ collect($item->attributes)->map(fn($v,$k)=>"$k: $v")->implode(' · ') }} ·
                        @endif
                        {{ __('checkout.qty') }}: {{ $item->product_quantity }}
                    </div>
                </div>
                <div class="item-price">
                    {{ number_format($item->product_price * $item->product_quantity, 2) }}
                    {{ __('common.currency') }}
                </div>
            </div>
            @endforeach
        </div>

        {{-- Totals --}}
        <div class="totals-section">
            <div class="total-row">
                <span class="label">{{ __('checkout.subtotal') }}</span>
                <span class="value">{{ number_format($order->price, 2) }} {{ __('common.currency') }}</span>
            </div>

            @if($order->coupon_discount > 0)
            <div class="total-row discount">
                <span class="label">
                    {{ __('checkout.discount') }}
                    @if($order->coupon) ({{ $order->coupon }}) @endif
                </span>
                <span class="value">-{{ number_format($order->coupon_discount, 2) }} {{ __('common.currency') }}</span>
            </div>
            @endif

            <div class="total-row">
                <span class="label">{{ __('checkout.shipping') }}</span>
                <span class="value">{{ number_format($order->shipping_price, 2) }} {{ __('common.currency') }}</span>
            </div>

            <div class="total-row grand">
                <span class="label">{{ __('checkout.total') }}</span>
                <span class="value">{{ number_format($order->total_price, 2) }} {{ __('common.currency') }}</span>
            </div>
        </div>

        {{-- Shipping address --}}
        <div class="address-section">
            <p class="section-title">{{ __('checkout.shipping_address') }}</p>
            <div class="address-box">
                <div class="address-name">{{ $order->user_name }}</div>
                {{ $order->street }}, {{ $order->city }}<br>
                {{ $order->governorate }}, {{ $order->country }}<br>
                {{ $order->user_phone }}
            </div>
        </div>

        {{-- CTA --}}
        <div class="cta-section">
            <a href="{{ route('orders.show', $order) }}" class="cta-btn">
                {{ __('mail.order_confirmation.view_order') }}
            </a>
        </div>

    </div>

    {{-- Footer --}}
    <div class="footer">
        <p>
            {{ __('mail.order_confirmation.footer_note') }}<br>
            <a href="{{ route('website.home') }}">{{ config('app.url') }}</a>
        </p>
    </div>

</div>
</body>
</html>
