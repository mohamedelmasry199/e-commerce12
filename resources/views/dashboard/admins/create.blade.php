@extends('layouts.dashboard.app')

@section('title')
    {{ __('dashboard.create_admin') }}
@endsection

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">

            {{-- =================== Page Header =================== --}}
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block">{{ __('dashboard.create_admin') }}</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('dashboard.index') }}">{{ __('dashboard.dashboard') }}</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('dashboard.admins.index') }}">{{ __('dashboard.admins') }}</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    {{ __('dashboard.create_admin') }}
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
                @include('dashboard.includes.button-header')
            </div>

            {{-- =================== Content Body =================== --}}
            <div class="content-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow-lg rounded">
                            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                <h4 class="card-title mb-0">
                                    <i class="la la-user-plus"></i> {{ __('dashboard.create_admin') }}
                                </h4>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus text-white"></i></a></li>
                                        <li><a data-action="reload"><i class="ft-rotate-cw text-white"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize text-white"></i></a></li>
                                        <li><a data-action="close"><i class="ft-x text-white"></i></a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="card-content collapse show">
                                <div class="card-body p-4">
                                    @include('dashboard.includes.validations-errors')

                                    <form class="form" action="{{ route('dashboard.admins.store') }}" method="POST">
                                        @csrf
                                        <div class="form-body">
                                            {{-- ========== Row 1 (Name & Email) ========== --}}
                                            <div class="row">
                                                <div class="col-md-6 mb-2">
                                                    <label for="name">{{ __('dashboard.admin_name') }}</label>
                                                    <input type="text" id="name" name="name"
                                                        class="form-control border-primary"
                                                        value="{{ old('name') }}"
                                                        placeholder="{{ __('dashboard.enter_name') }}">
                                                </div>
                                                <div class="col-md-6 mb-2">
                                                    <label for="email">{{ __('dashboard.admin_email') }}</label>
                                                    <input type="email" id="email" name="email"
                                                        class="form-control border-primary"
                                                        value="{{ old('email') }}"
                                                        placeholder="{{ __('dashboard.enter_email') }}">
                                                </div>
                                            </div>

                                            {{-- ========== Row 2 (Password & Confirm) ========== --}}
                                            <div class="row">
                                                <div class="col-md-6 mb-2">
                                                    <label for="password">{{ __('dashboard.password') }}</label>
                                                    <input type="password" id="password" name="password"
                                                        class="form-control border-primary"
                                                        placeholder="{{ __('dashboard.enter_password') }}">
                                                </div>
                                                <div class="col-md-6 mb-2">
                                                    <label for="password_confirmation">{{ __('dashboard.password_confirmation') }}</label>
                                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                                        class="form-control border-primary"
                                                        placeholder="{{ __('dashboard.confirm_password') }}">
                                                </div>
                                            </div>

                                            {{-- ========== Row 3 (Role & Status) ========== --}}
                                            <div class="row">
                                                <div class="col-md-6 mb-2">
                                                    <label for="role_id">{{ __('dashboard.select_role') }}</label>
                                                    <select class="form-control border-primary" name="role_id" id="role_id">
                                                        <optgroup label="{{ __('dashboard.select_role') }}">
                                                            @foreach ($roles as $role)
                                                                <option value="{{ $role->id }}">{{ $role->role }}</option>
                                                            @endforeach
                                                        </optgroup>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-2">
                                                    <label for="status">{{ __('dashboard.select_status') }}</label>
                                                    <select class="form-control border-primary" name="status" id="status">
                                                        <optgroup label="{{ __('dashboard.select_status') }}">
                                                            <option value="1">{{ __('dashboard.active') }}</option>
                                                            <option value="0">{{ __('dashboard.inactive') }}</option>
                                                        </optgroup>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- ========== Buttons ========== --}}
                                        <div class="form-actions text-right mt-3">
                                            <button type="reset" class="btn btn-warning mr-1">
                                                <i class="ft-x"></i> {{ __('dashboard.cancel') }}
                                            </button>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="la la-check-square-o"></i> {{ __('dashboard.save') }}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
