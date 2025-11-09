@extends('layouts.dashboard.app')
@section('title')
    {{ __('dashboard.categories') }}
@endsection

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block">Categories Table</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a
                                        href="{{ route('dashboard.index') }}">{{ __('dashboard.dashboard') }}</a>
                                </li>
                                <li class="breadcrumb-item"><a
                                        href="{{ route('dashboard.categories.index') }}">{{ __('dashboard.categories') }} &
                                        {{ __('dashboard.categories') }}</a>
                                </li>

                            </ol>
                        </div>
                    </div>
                </div>
                @include('dashboard.includes.button-header')
            </div>
            <div class="content-body">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="basic-layout-colored-form-control">{{ __('dashboard.categories') }} </h4>
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
                            {{-- alert --}}
                            @include('dashboard.includes.tostar-success')
                            @include('dashboard.includes.tostar-error')

                            <p class="card-text">Events assigned to the table can be exceptionally useful for
                                user interaction, however you must be aware that DataTables
                                will add and remove rows from the DOM as they are needed (i.e.
                                when paging only the visible elements are actually available
                                in the DOM). As such, this can lead to the odd hiccup when
                                working with events.</p>
                            <table id="yajra_table" class="table table-striped table-bordered dom-jQuery-events">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>name</th>
                                        <th>status</th>
                                        <th>created at</th>
                                        <th>action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>

                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                         <th>#</th>
                                        <th>name</th>
                                        <th>status</th>
                                        <th>created at</th>
                                        <th>action</th>

                                    </tr>
                                </tfoot>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('css')
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/2.3.4/css/dataTables.dataTables.min.css">
@endpush
@push('js')
    <script src="//cdn.datatables.net/2.3.4/js/dataTables.min.js" type="text/javascript"></script>

    <script>
        var lang = "{{ app()->getLocale() }}";
        $('#yajra_table').DataTable({
        Processing:true,
        serverSide:true,
        ajax:"{{ route('dashboard.categories.all') }}",
        columns:[
            {data:'DT_RowIndex',
                searchable:false,
                orderable:false,
            },
            {data:'name',
                name:'name'
            },
            {data:'status',
                name:'status'
            },
            {data:'created_at',
                name:'created_at'
            },
            {data:'action',
                searchable:false,
                orderable:false,
            }
        ],
          language: lang ==='ar'? {
        url: '//cdn.datatables.net/plug-ins/2.3.4/i18n/ar.json',
    } : {},

        });
    </script>
@endpush
