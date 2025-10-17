@extends('layouts.dashboard.app')

@section('title')
    {{ __('dashboard.create_role') }}
@endsection

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <!-- ======================= Breadcrumb ======================= -->
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block">
                        {{ __('dashboard.basic_forms') }}
                    </h3>
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
                                    <a href="#">{{ __('dashboard.create_role') }}</a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>

                <div class="content-header-right col-md-6 col-12">
                    <div class="dropdown float-md-right">
                        <button class="btn btn-danger dropdown-toggle round btn-glow px-2" id="dropdownBreadcrumbButton"
                            type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ __('dashboard.actions') }}
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownBreadcrumbButton">
                            <a class="dropdown-item" href="#"><i class="la la-calendar-check-o"></i> {{ __('dashboard.calendar') }}</a>
                            <a class="dropdown-item" href="#"><i class="la la-cart-plus"></i> {{ __('dashboard.cart') }}</a>
                            <a class="dropdown-item" href="#"><i class="la la-life-ring"></i> {{ __('dashboard.support') }}</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#"><i class="la la-cog"></i> {{ __('dashboard.settings') }}</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ======================= Form Section ======================= -->
            <div class="content-body">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="card-title">
                            <i class="la la-user-plus"></i> {{ __('dashboard.create_role') }}
                        </h4>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                <li><a data-action="close"><i class="ft-x"></i></a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-content collapse show">
                        <div class="card-body">
                            @include('dashboard.includes.validations-errors')
                            <form class="form" action="{{ route('dashboard.roles.store') }}" method="POST">
                                @csrf
                                <div class="form-body">
                                    <h4 class="form-section"><i class="la la-edit"></i> {{ __('dashboard.role_info') }}</h4>
                                    <div class="row">
                                        <!-- Role English -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="role_en">{{ __('dashboard.role_name_en') }}</label>
                                                <input type="text" id="role_en" name="role[en]"
                                                    class="form-control border-primary"
                                                    placeholder="{{ __('dashboard.enter_name_en') }}">
                                            </div>
                                        </div>

                                        <!-- Role Arabic -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="role_ar">{{ __('dashboard.role_name_ar') }}</label>
                                                <input type="text" id="role_ar" name="role[ar]"
                                                    class="form-control border-primary"
                                                    placeholder="{{ __('dashboard.enter_name_ar') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Permissions Section -->
                                    <h4 class="form-section"><i class="la la-lock"></i> {{ __('dashboard.permissions') }}</h4>
                                    <div class="row">
                                        @if (Config::get('app.locale') == 'ar')
                                            @foreach (config('permessions_ar') as $key => $value)
                                                <div class="col-md-3 col-sm-6 mb-2">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="permessions[]" value="{{ $key }}"
                                                            class="custom-control-input" id="perm-{{ $key }}">
                                                        <label class="custom-control-label" for="perm-{{ $key }}">
                                                            {{ $value }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            @foreach (config('permessions_en') as $key => $value)
                                                <div class="col-md-3 col-sm-6 mb-2">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="permessions[]" value="{{ $key }}"
                                                            class="custom-control-input" id="perm-{{ $key }}">
                                                        <label class="custom-control-label" for="perm-{{ $key }}">
                                                            {{ $value }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                                <!-- ======================= Buttons ======================= -->
                                <div class="form-actions text-right">
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
@endsection
