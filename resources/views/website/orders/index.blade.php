@extends('layouts.website.app')

@section('title', __('orders.index.title'))

@section('content')

<div class="container" style="padding-top:60px;padding-bottom:80px">
    <div class="row justify-content-center">
        <div class="col-lg-9 col-md-11">

            {{-- ── Page header ──────────────────────────────────────── --}}
            <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
                <div>
                    <h1 class="fw-semibold mb-1" style="font-size:1.4rem">
                        {{ __('orders.index.heading') }}
                    </h1>
                    <p class="mb-0 text-muted" style="font-size:0.875rem">
                        {{ __('orders.index.subheading', ['count' => $orders->total()]) }}
                    </p>
                </div>
                <a href="{{ route('website.home') }}"
                   style="display:inline-flex;align-items:center;gap:6px;padding:10px 20px;
                          background:#111827;color:#fff;border-radius:8px;font-size:0.875rem;
                          font-weight:500;text-decoration:none;transition:background .2s"
                   onmouseover="this.style.background='#1f2937'"
                   onmouseout="this.style.background='#111827'">
                    {{ __('checkout.success.continue_shopping') }}
                </a>
            </div>

            {{-- ── Empty state ──────────────────────────────────────── --}}
            @if($orders->isEmpty())
                <div class="text-center" style="padding:80px 20px">
                    <div class="mx-auto mb-4 d-flex align-items-center justify-content-center"
                         style="width:80px;height:80px;border-radius:50%;background:#f9fafb;
                                border:1px solid #e5e7eb">
                        <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" fill="none"
                             viewBox="0 0 24 24" stroke="#9ca3af" stroke-width="1.5"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
                            <line x1="3" y1="6" x2="21" y2="6"/>
                            <path d="M16 10a4 4 0 0 1-8 0"/>
                        </svg>
                    </div>
                    <h2 class="fw-semibold mb-2" style="font-size:1.1rem">
                        {{ __('orders.index.empty_title') }}
                    </h2>
                    <p class="text-muted mb-4" style="font-size:0.875rem">
                        {{ __('orders.index.empty_sub') }}
                    </p>
                    <a href="{{ route('website.home') }}"
                       style="display:inline-flex;align-items:center;padding:11px 28px;
                              background:#111827;color:#fff;border-radius:8px;font-size:0.875rem;
                              font-weight:500;text-decoration:none">
                        {{ __('orders.index.start_shopping') }}
                    </a>
                </div>

            @else

            {{-- ── Orders list ───────────────────────────────────────── --}}
            <div class="d-flex flex-column" style="gap:12px">
                @foreach($orders as $order)

                @php
                    $statusStyles = [
                        'pending'   => 'background:#fffbeb;color:#b45309;border:1px solid #fde68a',
                        'paid'      => 'background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0',
                        'cancelled' => 'background:#fef2f2;color:#b91c1c;border:1px solid #fecaca',
                        'delivered' => 'background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe',
                    ];
                    $statusStyle = $statusStyles[$order->status]
                        ?? 'background:#f3f4f6;color:#374151;border:1px solid #e5e7eb';
                @endphp

                <div style="border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;
                            transition:box-shadow .2s"
                     onmouseover="this.style.boxShadow='0 4px 16px rgba(0,0,0,.06)'"
                     onmouseout="this.style.boxShadow='none'">

                    {{-- Order card header --}}
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2"
                         style="padding:14px 20px;background:#fafafa;
                                border-bottom:1px solid #f3f4f6">

                        <div class="d-flex align-items-center flex-wrap gap-3">
                            {{-- Order number --}}
                            <span class="fw-semibold" style="font-size:0.9rem">
                                #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
                            </span>

                            {{-- Date --}}
                            <span class="text-muted" style="font-size:0.8rem">
                                {{ $order->created_at->format('d M Y') }}
                            </span>

                            {{-- Status --}}
                            <span style="{{ $statusStyle }};padding:3px 12px;border-radius:20px;
                                         font-size:0.75rem;font-weight:500">
                                {{ __('orders.status.' . $order->status) }}
                            </span>
                        </div>

                        {{-- View button --}}
                        <a href="{{ route('orders.show', $order) }}"
                           style="display:inline-flex;align-items:center;gap:5px;font-size:0.8rem;
                                  color:#374151;text-decoration:none;font-weight:500;
                                  padding:5px 12px;border:1px solid #e5e7eb;border-radius:6px;
                                  background:#fff;transition:all .15s"
                           onmouseover="this.style.background='#f9fafb';this.style.borderColor='#d1d5db'"
                           onmouseout="this.style.background='#fff';this.style.borderColor='#e5e7eb'">
                            {{ __('orders.view_details') }}
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="9 18 15 12 9 6"/>
                            </svg>
                        </a>
                    </div>

                    {{-- Order card body --}}
                    <div style="padding:16px 20px">
                        <div class="row align-items-center g-3">

                            {{-- Product thumbnails --}}
                            <div class="col-md-7">
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    @foreach($order->items->take(4) as $item)
                                        <div style="width:48px;height:48px;border-radius:8px;
                                                    overflow:hidden;background:#f9fafb;
                                                    border:1px solid #f3f4f6;flex-shrink:0"
                                             title="{{ $item->product_name }}">
                                            @if($item->product)
                                                <img src="{{ $item->product->getFirstImage() }}"
                                                     alt="{{ $item->product_name }}"
                                                     style="width:100%;height:100%;object-fit:cover">
                                            @else
                                                <div style="width:100%;height:100%;background:#e5e7eb"></div>
                                            @endif
                                        </div>
                                    @endforeach

                                    {{-- +N more --}}
                                    @if($order->items->count() > 4)
                                        <div style="width:48px;height:48px;border-radius:8px;
                                                    background:#f3f4f6;border:1px solid #e5e7eb;
                                                    display:flex;align-items:center;justify-content:center;
                                                    font-size:11px;font-weight:600;color:#6b7280">
                                            +{{ $order->items->count() - 4 }}
                                        </div>
                                    @endif

                                    {{-- Item count label --}}
                                    <span class="text-muted" style="font-size:0.8rem;margin-left:4px">
                                        {{ $order->items->count() }}
                                        {{ __('orders.items') }}
                                    </span>
                                </div>
                            </div>

                            {{-- Total --}}
                            <div class="col-md-5 text-md-end">
                                <p class="mb-0 text-muted" style="font-size:0.75rem">
                                    {{ __('checkout.total') }}
                                </p>
                                <p class="mb-0 fw-semibold" style="font-size:1rem">
                                    {{ number_format($order->total_price, 2) }}
                                    {{ __('common.currency') }}
                                </p>

                                {{-- Payment method if paid --}}
                                @if($order->transaction)
                                    <p class="mb-0 text-muted text-capitalize"
                                       style="font-size:0.75rem;margin-top:2px">
                                        {{ $order->transaction->payment_method }}
                                    </p>
                                @endif
                            </div>

                        </div>
                    </div>

                </div>
                @endforeach
            </div>

            {{-- ── Pagination ───────────────────────────────────────── --}}
            @if($orders->hasPages())
                <div class="d-flex justify-content-center mt-5">
                    {{ $orders->links() }}
                </div>
            @endif

            @endif {{-- end empty check --}}

        </div>
    </div>
</div>

@endsection
