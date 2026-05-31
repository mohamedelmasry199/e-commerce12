@extends('layouts.website.app')

@section('title', __('checkout.success.title'))

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">

            {{-- ── Success header ────────────────────────────────── --}}
            <div class="text-center mb-5">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-success bg-opacity-10 mb-3"
                     style="width:72px;height:72px">
                    <i class="ti ti-check text-success" style="font-size:36px"></i>
                </div>
                <h1 class="h4 fw-semibold mb-1">{{ __('checkout.success.heading') }}</h1>
                <p class="text-muted mb-0">{{ __('checkout.success.subheading') }}</p>
                <p class="text-muted small mt-1">
                    {{ __('checkout.success.order_number') }}
                    <strong>#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</strong>
                </p>
            </div>

            {{-- ── Order items ────────────────────────────────────── --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h2 class="h6 fw-semibold mb-3 text-muted text-uppercase" style="letter-spacing:.05em;font-size:11px">
                        {{ __('checkout.order_summary') }}
                    </h2>

                    <div class="d-flex flex-column gap-3">
                        @foreach($order->items as $item)
                            <div class="d-flex gap-3 align-items-center">
                                <div style="width:52px;height:52px;flex-shrink:0;border-radius:8px;overflow:hidden;background:#f5f5f5">
                                    @if($item->product)
                                        <img src="{{ $item->product->getFirstImage() }}"
                                             alt="{{ $item->product_name }}"
                                             style="width:100%;height:100%;object-fit:cover">
                                    @else
                                        <div class="w-100 h-100 bg-secondary opacity-25"></div>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-0 fw-medium small">{{ $item->product_name }}</p>
                                    @if($item->attributes)
                                        <p class="mb-0 text-muted" style="font-size:11px">
                                            {{ collect($item->attributes)->map(fn($v,$k)=>"$k: $v")->implode(' · ') }}
                                        </p>
                                    @endif
                                    <p class="mb-0 text-muted" style="font-size:11px">
                                        {{ __('checkout.qty') }}: {{ $item->product_quantity }}
                                    </p>
                                </div>
                                <div class="text-end">
                                    <span class="small fw-medium">
                                        {{ number_format($item->product_price * $item->product_quantity, 2) }}
                                        {{ __('common.currency') }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- ── Order totals ────────────────────────────────────── --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h2 class="h6 fw-semibold mb-3 text-muted text-uppercase" style="letter-spacing:.05em;font-size:11px">
                        {{ __('checkout.payment_details') }}
                    </h2>

                    <div class="d-flex flex-column gap-2">
                        <div class="d-flex justify-content-between small">
                            <span class="text-muted">{{ __('checkout.subtotal') }}</span>
                            <span>{{ number_format($order->price, 2) }} {{ __('common.currency') }}</span>
                        </div>

                        @if($order->coupon_discount > 0)
                        <div class="d-flex justify-content-between small">
                            <span class="text-success">
                                {{ __('checkout.discount') }}
                                @if($order->coupon)
                                    <span class="badge bg-success bg-opacity-10 text-success ms-1" style="font-size:10px">
                                        {{ $order->coupon }}
                                    </span>
                                @endif
                            </span>
                            <span class="text-success">-{{ number_format($order->coupon_discount, 2) }} {{ __('common.currency') }}</span>
                        </div>
                        @endif

                        <div class="d-flex justify-content-between small">
                            <span class="text-muted">{{ __('checkout.shipping') }}</span>
                            <span>{{ number_format($order->shapping_price, 2) }} {{ __('common.currency') }}</span>
                        </div>

                        <hr class="my-2">

                        <div class="d-flex justify-content-between fw-semibold">
                            <span>{{ __('checkout.total') }}</span>
                            <span>{{ number_format($order->total_price, 2) }} {{ __('common.currency') }}</span>
                        </div>

                        @if($order->transaction)
                        <div class="d-flex justify-content-between small text-muted mt-1">
                            <span>{{ __('checkout.payment_method') }}</span>
                            <span class="text-capitalize">{{ $order->transaction->payment_method }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- ── Shipping address ────────────────────────────────── --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h2 class="h6 fw-semibold mb-3 text-muted text-uppercase" style="letter-spacing:.05em;font-size:11px">
                        {{ __('checkout.shipping_address') }}
                    </h2>
                    <p class="mb-0 small">
                        {{ $order->user_name }}<br>
                        {{ $order->street }}, {{ $order->city }}<br>
                        {{ $order->governorate }}, {{ $order->country }}<br>
                        <a href="tel:{{ $order->user_phone }}" class="text-muted">{{ $order->user_phone }}</a>
                    </p>
                </div>
            </div>

            {{-- ── Actions ─────────────────────────────────────────── --}}
            <div class="d-flex gap-3">
                <a href="{{ route('website.home') }}" class="btn btn-dark flex-grow-1 py-3 fw-semibold">
                    {{ __('checkout.success.continue_shopping') }}
                </a>
                <a href="{{ route('website.orders.show', $order) }}" class="btn btn-outline-secondary flex-grow-1 py-3 fw-semibold">
                    {{ __('checkout.success.view_order') }}
                </a>
            </div>

            {{-- Email note --}}
            <p class="text-center text-muted mt-4" style="font-size:12px">
                <i class="ti ti-mail me-1"></i>
                {{ __('checkout.success.email_note', ['email' => $order->user_email]) }}
            </p>

        </div>
    </div>
</div>
@endsection
