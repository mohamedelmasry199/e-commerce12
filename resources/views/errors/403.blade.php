@extends('layouts.dashboard.app')

@section('title')
    {{ __('errors.403_title', ['code' => 403]) }}
@endsection

@section('content')
<div class="app-content content">
    <div class="content-wrapper">

        {{-- ========== Page Header / Breadcrumb ========== --}}
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
                <h3 class="content-header-title mb-0 d-inline-block">{{ __('errors.403_title', ['code' => 403]) }}</h3>
                <div class="row breadcrumbs-top d-inline-block">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard.index') }}">{{ __('dashboard.dashboard') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard.roles.index') }}">Roles</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <a href="#">403 Error</a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="content-header-right col-md-6 col-12">
                <div class="dropdown float-md-right">
                    <button class="btn btn-danger dropdown-toggle round btn-glow px-2" id="dropdownBreadcrumbButton"
                        type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Actions
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownBreadcrumbButton">
                        <a class="dropdown-item" href="#"><i class="la la-calendar-check-o"></i> Calender</a>
                        <a class="dropdown-item" href="#"><i class="la la-cart-plus"></i> Cart</a>
                        <a class="dropdown-item" href="#"><i class="la la-life-ring"></i> Support</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#"><i class="la la-cog"></i> Settings</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- ========== Content Body ========== --}}
        <div class="content-body">
            <div class="card">
                <div class="card-body d-flex align-items-center justify-content-center" style="min-height: 70vh;">
                    <div class="text-center">

                        {{-- Big status code --}}
                        <h1 class="display-1 fw-bolder text-danger mb-3">403</h1>

                        {{-- Main message --}}
                        <h2 class="fw-bold fs-2 mb-3">
                            {{ __('errors.403_message') ?? "Forbidden — You don't have permission to access this page." }}
                        </h2>

                        {{-- Description --}}
                        <p class="text-gray-600 fw-semibold fs-6 mb-4">
                            {{ __('errors.403_description') ?? "If you believe this is a mistake, please contact the administrator or try again with the required permissions." }}
                        </p>

                        {{-- Action buttons --}}
                        <div class="d-flex flex-wrap justify-content-center gap-2">
                            <a href="{{ url('/') }}" class="btn btn-primary px-4 py-2">
                                <i class="la la-home mr-1"></i> {{ __('errors.back_home') ?? 'Back to Home' }}
                            </a>

                            @guest
                                <a href="{{ route('login') }}" class="btn btn-light px-4 py-2">
                                    <i class="la la-sign-in mr-1"></i> {{ __('errors.login') ?? 'Log in' }}
                                </a>
                            @else
                                <a href="{{ url()->previous() ?? route('dashboard') }}" class="btn btn-light px-4 py-2">
                                    <i class="la la-arrow-left mr-1"></i> {{ __('errors.go_back') ?? 'Go back' }}
                                </a>
                            @endguest
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
