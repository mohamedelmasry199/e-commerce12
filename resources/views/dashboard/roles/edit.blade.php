@extends('layouts.dashboard.app')

@section('title')
    {{ __('dashboard.edit_role') }}
@endsection

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">

            {{-- =================== Page Header =================== --}}
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block">{{ __('dashboard.edit_role') }}</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('dashboard.index') }}">{{ __('dashboard.dashboard') }}</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('dashboard.roles.index') }}">{{ __('dashboard.roles') }}</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    {{ __('dashboard.edit_role') }}
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            {{-- =================== Content Body =================== --}}
            <div class="content-body">
                <div class="card">
                    <div class="card shadow-lg rounded">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">
                                <i class="la la-shield-alt"></i> {{ __('dashboard.edit_role_details') }}
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

                                <form class="form" action="{{ route('dashboard.roles.update', $role->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="id" value="{{ $role->id }}">

                                    <div class="form-body">
                                        {{-- Role Names (EN + AR) --}}
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <div class="form-group">
                                                    <label for="role_en">{{ __('dashboard.role_name_en') }}</label>
                                                    <input type="text" id="role_en" name="role[en]"
                                                           class="form-control border-primary"
                                                           value="{{ $role->getTranslation('role', 'en') }}"
                                                           placeholder="{{ __('dashboard.enter_role_name_en') }}">
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-2">
                                                <div class="form-group">
                                                    <label for="role_ar">{{ __('dashboard.role_name_ar') }}</label>
                                                    <input type="text" id="role_ar" name="role[ar]"
                                                           class="form-control border-primary"
                                                           value="{{ $role->getTranslation('role', 'ar') }}"
                                                           placeholder="{{ __('dashboard.enter_role_name_ar') }}">
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Permissions --}}
                                        <h5 class="mt-3 mb-2 font-weight-bold">
                                            <i class="la la-key"></i> {{ __('dashboard.permissions') }}
                                        </h5>
                                        <div class="row mt-2">
                                            @php
                                                $permissions = Config::get('app.locale') === 'ar'
                                                    ? config('permessions_ar')
                                                    : config('permessions_en');
                                            @endphp
                                            @foreach ($permissions as $key => $value)
                                                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12 mb-2">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox"
                                                               class="custom-control-input"
                                                               id="perm_{{ $key }}"
                                                               name="permessions[]"
                                                               value="{{ $key }}"
                                                               @checked(in_array($key, $role->permession))>
                                                        <label class="custom-control-label" for="perm_{{ $key }}">
                                                            {{ $value }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    {{-- Form Buttons --}}
                                    <div class="form-actions text-right mt-3">
                                        <a href="{{ route('dashboard.roles.index') }}" class="btn btn-warning mr-1">
                                            <i class="ft-x"></i> {{ __('dashboard.cancel') }}
                                        </a>
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
@endsection
