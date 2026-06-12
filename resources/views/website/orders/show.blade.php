@extends('layouts.website.app')

@section('title', __('orders.show.title', ['number' => str_pad($order->id, 6, '0', STR_PAD_LEFT)]))

@section('content')

<div class="container" style="padding-top:60px;padding-bottom:80px">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">

            {{-- ── Back link ────────────────────────────────────────── --}}
            <a href="{{ route('orders.index') }}"
               style="display:inline-flex;align-items:center;gap:6px;font-size:0.875rem;
                      color:#6b7280;text-decoration:none;margin-bottom:28px"
               onmouseover="this.style.color='#111827'"
               onmouseout="this.style.color='#6b7280'">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6"/>
                </svg>
                {{ __('orders.back_to_orders') }}
            </a>

            {{-- ── Page header ──────────────────────────────────────── --}}
            <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
                <div>
                    <h1 class="fw-semibold mb-1" style="font-size:1.4rem">
                        {{ __('orders.show.heading') }}
                        <span style="color:#6b7280">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span>
                    </h1>
                    <p class="mb-0 text-muted" style="font-size:0.875rem">
                        {{ __('orders.placed_on') }}
                        {{ $order->created_at->format('d M Y, h:i A') }}
                    </p>
                </div>

                {{-- Status badge --}}
                @php
                    $statusStyles = [
                        'pending'   => 'background:#fffbeb;color:#b45309;border:1px solid #fde68a',
                        'paid'      => 'background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0',
                        'cancelled' => 'background:#fef2f2;color:#b91c1c;border:1px solid #fecaca',
                        'delivered' => 'background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe',
                    ];
                    $style = $statusStyles[$order->status] ?? 'background:#f3f4f6;color:#374151;border:1px solid #e5e7eb';
                @endphp
                <span style="{{ $style }};padding:6px 16px;border-radius:20px;
                             font-size:0.8rem;font-weight:500;text-transform:capitalize">
                    {{ __('orders.status.' . $order->status) }}
                </span>
            </div>

            {{-- ── Order items ──────────────────────────────────────── --}}
            <div class="mb-3" style="border:1px solid #e5e7eb;border-radius:12px;overflow:hidden">
                <div style="padding:16px 20px;border-bottom:1px solid #f3f4f6;
                            background:#fafafa">
                    <p class="mb-0 text-uppercase text-muted"
                       style="font-size:10px;font-weight:600;letter-spacing:.08em">
                        {{ __('checkout.order_summary') }}
                        <span style="color:#9ca3af;font-weight:400;text-transform:none;letter-spacing:0">
                            — {{ $order->items->count() }} {{ __('orders.items') }}
                        </span>
                    </p>
                </div>

                <div style="padding:20px">
                    <div class="d-flex flex-column" style="gap:16px">
                        @foreach($order->items as $item)
                            <div class="d-flex gap-3 align-items-center">

                                {{-- Image --}}
                                <div style="width:60px;height:60px;flex-shrink:0;border-radius:8px;
                                            overflow:hidden;background:#f9fafb;border:1px solid #f3f4f6">
                                    @if($item->product)
                                        <img src="{{ $item->product->getFirstImage() }}"
                                             alt="{{ $item->product_name }}"
                                             style="width:100%;height:100%;object-fit:cover">
                                    @else
                                        <div style="width:100%;height:100%;background:#e5e7eb;
                                                    display:flex;align-items:center;justify-content:center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                 fill="none" viewBox="0 0 24 24" stroke="#9ca3af" stroke-width="1.5">
                                                <rect x="3" y="3" width="18" height="18" rx="2"/>
                                                <circle cx="8.5" cy="8.5" r="1.5"/>
                                                <polyline points="21 15 16 10 5 21"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                {{-- Info --}}
                                <div class="flex-grow-1" style="min-width:0">
                                    <p class="mb-0 fw-medium"
                                       style="font-size:0.875rem;white-space:nowrap;
                                              overflow:hidden;text-overflow:ellipsis">
                                        {{ $item->product_name }}
                                    </p>

                                    @if($item->attributes)
                                        <p class="mb-0" style="font-size:11px;color:#9ca3af;margin-top:2px">
                                            {{ collect($item->attributes)->map(fn($v,$k) => "$k: $v")->implode(' · ') }}
                                        </p>
                                    @endif

                                    <p class="mb-0" style="font-size:11px;color:#9ca3af;margin-top:2px">
                                        {{ __('checkout.qty') }}: {{ $item->product_quantity }}
                                        &nbsp;×&nbsp;
                                        {{ number_format($item->product_price, 2) }} {{ __('common.currency') }}
                                    </p>
                                </div>

                                {{-- Line total --}}
                                <div class="text-end flex-shrink-0">
                                    <span class="fw-semibold" style="font-size:0.9rem">
                                        {{ number_format($item->product_price * $item->product_quantity, 2) }}
                                        {{ __('common.currency') }}
                                    </span>
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- ── Bottom two columns ───────────────────────────────── --}}
            <div class="row g-3 mb-3">

                {{-- Payment summary --}}
                <div class="col-md-6">
                    <div style="border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;height:100%">
                        <div style="padding:16px 20px;border-bottom:1px solid #f3f4f6;background:#fafafa">
                            <p class="mb-0 text-uppercase text-muted"
                               style="font-size:10px;font-weight:600;letter-spacing:.08em">
                                {{ __('checkout.payment_details') }}
                            </p>
                        </div>
                        <div style="padding:18px 20px">
                            <div class="d-flex flex-column" style="gap:10px">

                                <div class="d-flex justify-content-between"
                                     style="font-size:0.875rem">
                                    <span class="text-muted">{{ __('checkout.subtotal') }}</span>
                                    <span>{{ number_format($order->price, 2) }} {{ __('common.currency') }}</span>
                                </div>

                                @if($order->coupon_discount > 0)
                                <div class="d-flex justify-content-between"
                                     style="font-size:0.875rem">
                                    <span style="color:#16a34a">
                                        {{ __('checkout.discount') }}
                                        @if($order->coupon)
                                            <span style="background:#f0fdf4;color:#15803d;font-size:10px;
                                                         padding:1px 7px;border-radius:20px;margin-left:4px;
                                                         border:1px solid #bbf7d0">
                                                {{ $order->coupon }}
                                            </span>
                                        @endif
                                    </span>
                                    <span style="color:#16a34a">
                                        -{{ number_format($order->coupon_discount, 2) }} {{ __('common.currency') }}
                                    </span>
                                </div>
                                @endif

                                <div class="d-flex justify-content-between"
                                     style="font-size:0.875rem">
                                    <span class="text-muted">{{ __('checkout.shipping') }}</span>
                                    <span>{{ number_format($order->shipping_price, 2) }} {{ __('common.currency') }}</span>
                                </div>

                                <div style="border-top:1px solid #f3f4f6;padding-top:10px"
                                     class="d-flex justify-content-between fw-semibold">
                                    <span>{{ __('checkout.total') }}</span>
                                    <span>{{ number_format($order->total_price, 2) }} {{ __('common.currency') }}</span>
                                </div>

                                @if($order->transaction)
                                <div class="d-flex justify-content-between"
                                     style="font-size:0.8rem;color:#9ca3af">
                                    <span>{{ __('checkout.payment_method') }}</span>
                                    <span class="text-capitalize">
                                        {{ $order->transaction->payment_method }}
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between"
                                     style="font-size:0.8rem;color:#9ca3af">
                                    <span>{{ __('orders.transaction_id') }}</span>
                                    <span style="font-family:monospace;font-size:11px">
                                        {{ $order->transaction->transaction_id }}
                                    </span>
                                </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>

                {{-- Shipping address --}}
                <div class="col-md-6">
                    <div style="border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;height:100%">
                        <div style="padding:16px 20px;border-bottom:1px solid #f3f4f6;background:#fafafa">
                            <p class="mb-0 text-uppercase text-muted"
                               style="font-size:10px;font-weight:600;letter-spacing:.08em">
                                {{ __('checkout.shipping_address') }}
                            </p>
                        </div>
                        <div style="padding:18px 20px;font-size:0.875rem;
                                    line-height:1.9;color:#374151">
                            <p class="fw-semibold mb-1" style="font-size:0.9rem">
                                {{ $order->user_name }}
                            </p>
                            <p class="mb-0 text-muted">
                                {{ $order->street }}<br>
                                {{ $order->city }}, {{ $order->governorate }}<br>
                                {{ $order->country }}
                            </p>
                            <a href="tel:{{ $order->user_phone }}"
                               style="display:inline-block;margin-top:8px;font-size:0.85rem;
                                      color:#6b7280;text-decoration:none"
                               onmouseover="this.style.color='#111827'"
                               onmouseout="this.style.color='#6b7280'">
                                {{ $order->user_phone }}
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            {{-- ── Note ─────────────────────────────────────────────── --}}
            @if($order->note)
            <div class="mb-3" style="border:1px solid #e5e7eb;border-radius:12px;overflow:hidden">
                <div style="padding:16px 20px;border-bottom:1px solid #f3f4f6;background:#fafafa">
                    <p class="mb-0 text-uppercase text-muted"
                       style="font-size:10px;font-weight:600;letter-spacing:.08em">
                        {{ __('orders.order_note') }}
                    </p>
                </div>
                <div style="padding:16px 20px;font-size:0.875rem;color:#6b7280;line-height:1.7">
                    {{ $order->note }}
                </div>
            </div>
            @endif

            {{-- ── Actions ──────────────────────────────────────────── --}}
            <div class="d-flex gap-3 flex-wrap">
                <a href="{{ route('website.home') }}"
                   style="display:inline-flex;align-items:center;gap:8px;padding:12px 28px;
                          background:#111827;color:#fff;border-radius:8px;font-size:0.875rem;
                          font-weight:500;text-decoration:none;transition:background .2s"
                   onmouseover="this.style.background='#1f2937'"
                   onmouseout="this.style.background='#111827'">
                    {{ __('checkout.success.continue_shopping') }}
                </a>

                {{-- Show retry button only if order is still pending --}}
                @if($order->status === 'pending')
                    <a href="{{ route('checkout.index') }}"
                       style="display:inline-flex;align-items:center;gap:8px;padding:12px 28px;
                              background:transparent;color:#111827;border:1px solid #d1d5db;
                              border-radius:8px;font-size:0.875rem;font-weight:500;
                              text-decoration:none;transition:all .2s"
                       onmouseover="this.style.background='#f9fafb'"
                       onmouseout="this.style.background='transparent'">
                        {{ __('orders.retry_payment') }}
                    </a>
                @endif
            </div>

        </div>
    </div>
</div>

@endsection
