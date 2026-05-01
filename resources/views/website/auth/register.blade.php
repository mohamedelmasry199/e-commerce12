@extends('layouts.website.app')
@section('title', __('auth.register'))

@section('content')
<section class="login account footer-padding">
<div class="container">
<div class="login-section account-section">
<div class="review-form">

<h5 class="comment-title">{{ __('auth.create_account') }}</h5>

<form method="POST" action="{{ route('register') }}">
@csrf

{{-- Name --}}
<div class="account-inner-form">
    <div class="review-form-name">
        <label class="form-label">{{ __('auth.name') }}*</label>

        <input
            type="text"
            name="name"
            class="form-control @error('name') is-invalid @enderror"
            placeholder="{{ __('auth.full_name') }}"
            value="{{ old('name') }}"
            required
        >

        @error('name')
            <span class="invalid-feedback d-block">{{ $message }}</span>
        @enderror
    </div>
</div>

{{-- Email + Phone --}}
<div class="account-inner-form">

    <div class="review-form-name">
        <label class="form-label">{{ __('auth.email') }}*</label>

        <input
            type="email"
            name="email"
            class="form-control @error('email') is-invalid @enderror"
            placeholder="user@gmail.com"
            value="{{ old('email') }}"
            required
        >

        @error('email')
            <span class="invalid-feedback d-block">{{ $message }}</span>
        @enderror
    </div>

    <div class="review-form-name">
        <label class="form-label">{{ __('auth.phone') }}*</label>

        <input
            type="text"
            name="phone"
            class="form-control @error('phone') is-invalid @enderror"
            placeholder="01xxxxxxxxx"
            value="{{ old('phone') }}"
            required
        >

        @error('phone')
            <span class="invalid-feedback d-block">{{ $message }}</span>
        @enderror
    </div>

</div>

{{-- Address --}}
<div class="review-form-name">
    @livewire('general.adress-drop-down-dependent')
</div>

{{-- Password --}}
<div class="account-inner-form">

    <div class="review-form-name">
        <label class="form-label">{{ __('auth.password') }}*</label>

        <input
            type="password"
            name="password"
            class="form-control @error('password') is-invalid @enderror"
            required
        >

        @error('password')
            <span class="invalid-feedback d-block">{{ $message }}</span>
        @enderror
    </div>

    <div class="review-form-name">
        <label class="form-label">{{ __('auth.confirm_password') }}*</label>

        <input
            type="password"
            name="password_confirmation"
            class="form-control"
            required
        >
    </div>

</div>

{{-- Terms --}}
<div class="review-form-name checkbox">
    <div class="checkbox-item">
        <input type="checkbox" required>

        <p class="remember">
            {{ __('auth.agree_terms') }}
        </p>
    </div>
</div>

{{-- Submit --}}
<div class="login-btn text-center">
    <button type="submit" class="shop-btn">
        {{ __('auth.create_account_btn') }}
    </button>

    <span class="shop-account">
        {{ __('auth.already_have_account') }}
        <a href="{{ route('login') }}">
            {{ __('auth.login') }}
        </a>
    </span>
</div>

</form>

</div>
</div>
</div>
</section>
@endsection
