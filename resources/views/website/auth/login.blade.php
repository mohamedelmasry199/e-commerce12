@extends('layouts.website.app')
@section('title', __('website.login'))

@section('content')
<section class="login footer-padding">
  <div class="container">
    <div class="login-section">
      <div class="review-form">

        <h5 class="comment-title">{{ __('website.login') }}</h5>

        <form method="POST" action="{{ route('login') }}">
          @csrf

          <div class="review-inner-form">

            {{-- Email --}}
            <div class="review-form-name">
              <label for="email" class="form-label">
                {{ __('auth.email_address') }}
              </label>

              <input
                type="email"
                id="email"
                name="email"
                class="form-control @error('email') is-invalid @enderror"
                placeholder="{{ __('auth.email_placeholder') }}"
                value="{{ old('email') }}"
                required
                autofocus
              />

              @error('email')
                <span class="invalid-feedback d-block">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>

            {{-- Password --}}
            <div class="review-form-name">
              <label for="password" class="form-label">
                {{ __('auth.password') }}
              </label>

              <input
                type="password"
                id="password"
                name="password"
                class="form-control @error('password') is-invalid @enderror"
                placeholder="{{ __('auth.password_placeholder') }}"
                required
              />

              @error('password')
                <span class="invalid-feedback d-block">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>

            {{-- Remember Me --}}
            <div class="review-form-name checkbox">
              <div class="checkbox-item">
                <input
                  type="checkbox"
                  name="remember"
                  id="remember"
                  {{ old('remember') ? 'checked' : '' }}
                />

                <span class="address">
                  {{ __('auth.remember_me') }}
                </span>
              </div>

              <div class="forget-pass">
                @if (Route::has('password.request'))
                  <a href="{{ route('password.request') }}">
                    {{ __('auth.forgot_password') }}
                  </a>
                @endif
              </div>
            </div>

          </div>

          {{-- Submit --}}
          <div class="login-btn text-center">
            <button type="submit" class="shop-btn">
              {{ __('auth.login_button') }}
            </button>

            <span class="shop-account">
              {{ __('auth.dont_have_account') }}
              <a href="{{ route('register') }}">
                {{ __('auth.register') }}
              </a>
            </span>
          </div>

        </form>

      </div>
    </div>
  </div>
</section>
@endsection
