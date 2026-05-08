@extends('layouts.dashboard.app')
@section('title', __('dashboard.reply'))
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-9 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block">{{ __('dashboard.faq_questions') }}</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('dashboard.index') }}">{{ __('dashboard.dashboard') }}</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('dashboard.faq.questions.index') }}">{{ __('dashboard.faq_questions') }}</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    <a href="javascript:void(0)">{{ __('dashboard.reply') }}</a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
                @include('dashboard.includes.button-header')
            </div>

            <div class="row" style="display: flex; justify-content: center;">
                <div class="col-md-11">
                    <div class="content-body">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{ __('dashboard.reply') }}</h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        <li><a data-action="close"><i class="ft-x"></i></a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="card-content">
                                <div class="card-body">

                                    @include('dashboard.includes.validations-errors')

                                    {{-- Already Replied --}}
                                    @if($question->reply)

                                        <div class="alert alert-success">
                                            <i class="la la-check-circle"></i>
                                            {{ __('dashboard.already_replied') }}
                                        </div>

                                        <div class="form-group">
                                            <label>{{ __('dashboard.question') }}</label>
                                            <div class="p-2 border rounded bg-light">
                                                {{ $question->message }}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>{{ __('dashboard.reply') }}</label>
                                            <div class="p-2 border rounded bg-light text-success">
                                                {{ $question->reply }}
                                            </div>
                                        </div>

                                        <div class="form-actions left">
                                            <a href="{{ route('dashboard.faq.questions.index') }}" class="btn btn-warning mr-1">
                                                <i class="ft-x"></i> {{ __('dashboard.back') }}
                                            </a>
                                        </div>

                                    {{-- Not Yet Replied --}}
                                    @else

                                        <p class="card-text">{{ __('dashboard.form_edit') }}.</p>

                                        <form class="form"
                                              action="{{ route('dashboard.faq.questions.reply', $question->id) }}"
                                              method="POST">
                                            @csrf
                                            @method('PUT')

                                            <div class="form-body">

                                                <div class="form-group">
                                                    <label>{{ __('dashboard.question') }}</label>
                                                    <div class="p-2 border rounded bg-light">
                                                        {{ $question->message }}
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="reply">{{ __('dashboard.reply') }}</label>
                                                    <textarea
                                                        name="reply"
                                                        id="reply"
                                                        rows="6"
                                                        class="form-control @error('reply') is-invalid @enderror"
                                                        placeholder="{{ __('dashboard.write_reply') }}">{{ old('reply') }}</textarea>
                                                    @error('reply')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                            </div>

                                            <div class="form-actions left">
                                                <a href="{{ url()->previous() }}" class="btn btn-warning mr-1">
                                                    <i class="ft-x"></i> {{ __('dashboard.cancel') }}
                                                </a>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="la la-paper-plane"></i> {{ __('dashboard.send_reply') }}
                                                </button>
                                            </div>

                                        </form>

                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
