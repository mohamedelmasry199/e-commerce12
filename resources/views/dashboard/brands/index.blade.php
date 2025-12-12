@extends('layouts.dashboard.app')


@section('title')
    {{ __('dashboard.brands') }}
@endsection

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block">{{ __('dashboard.brands_table') }}</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a
                                        href="{{ route('dashboard.index') }}">{{ __('dashboard.dashboard') }}</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('dashboard.brands.index') }}">
                                        {{ __('dashboard.brands') }}</a>
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
                                <h4 class="card-title" id="basic-layout-colored-form-control">
                                    {{ __('dashboard.brands') }}
                                </h4>
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
                                    {{-- <a href="{{ route('dashboard.brands.create') }}" class="btn btn-outline-success ">{{ __('dashboard.create_brand') }}</a> --}}
<button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#createBrandModal" data-whatever="@mdo">{{ __('dashboard.create_brand') }}</button>
@include('dashboard.brands._create_modal')
                                    {{-- alert --}}
                                    @include('dashboard.includes.tostar-success')
                                    @include('dashboard.includes.tostar-error')


                                    <p class="card-text">{{ __('dashboard.table_yajra_paragraph') }}.</p>
                                    <table id="yajra_table" class="table table-striped table-bordered language-file">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{ __('dashboard.name') }}</th>
                                                <th>{{ __('dashboard.status') }}</th>
                                                <th>{{ __('dashboard.products_count') }}</th>
                                                <th>{{ __('dashboard.logo') }}</th>
                                                <th>{{ __('dashboard.created_at') }}</th>
                                                <th>{{ __('dashboard.actions') }}</th>
                                            </tr>
                                        </thead>

                                        <body>
                                            {{-- empty --}}
                                        </body>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>{{ __('dashboard.name') }}</th>
                                                <th>{{ __('dashboard.status') }}</th>
                                                <th>{{ __('dashboard.products_count') }}</th>
                                                <th>{{ __('dashboard.logo') }}</th>
                                                <th>{{ __('dashboard.created_at') }}</th>
                                                <th>{{ __('dashboard.actions') }}</th>
                                            </tr>
                                        </tfoot>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
@if($errors->any())
<script>
        $(document).ready(function() {
           $('#createBrandModal').modal('show');
        });
</script>
@endif
    <script>
    $(document).ready(function() {

        let lang = "{{ app()->getLocale() }}";

        $('#yajra_table').DataTable({
            processing: true,
            serverSide: true,
scrollX: true,
            fixedHeader: true,
            colReorder: true,
            rowReorder: false,
            responsive:true,
           select:true,


            responsive: {
                details: {
                    display: DataTable.Responsive.display.modal({
                        header: function (row) {
                            var data = row.data();
                            return (lang === 'ar')
                                ? 'تفاصيل الصنف: ' + data[1]
                                : 'Details for: ' + data[1];
                        }
                    }),
                    renderer: DataTable.Responsive.renderer.tableAll({
                        tableClass: 'table'
                    })
                }
            },

            ajax: "{{ route('dashboard.brands.all') }}",

            columns: [
                { data: 'DT_RowIndex', searchable: false, orderable: false },
                { data: 'name', name: 'name' },
                { data: 'status', name: 'status' },
                { data: 'products_count', name: 'products_count' },
                { data: 'logo', name: 'logo' },
                { data: 'created_at', name: 'created_at' },
                { data: 'action', searchable: false, orderable: false },
            ],

            /** ----------------------------------------------------
             *  ✔ Buttons for DataTables v1.13
             * ---------------------------------------------------- */
            dom: 'Bfrtip',
           buttons: [
    {
        extend: 'colvis',
        text: '<i class="la la-columns"></i> ' + (lang === 'ar' ? 'الأعمدة' : 'Columns'),
        init: function(api, node) {
            $(node).css({
                background: '#4e73df',
                color: '#fff',
                border: 'none',
                padding: '8px 16px',
                borderRadius: '8px',
                fontSize: '13px',
                marginRight: '6px',
                transition: '0.25s',
            });
        }
    },
    {
        extend: 'copy',
        text: '<i class="la la-copy"></i> ' + (lang === 'ar' ? 'نسخ' : 'Copy'),
        init: function(api, node) {
            $(node).css({
                background: '#1cc88a',
                color: '#fff',
                border: 'none',
                padding: '8px 16px',
                borderRadius: '8px',
                fontSize: '13px',
                marginRight: '6px',
                transition: '0.25s',
            });
        }
    },
    {
        extend: 'excel',
        text: '<i class="la la-file-excel-o"></i> ' + (lang === 'ar' ? 'إكسل' : 'Excel'),
        init: function(api, node) {
            $(node).css({
                background: '#36b9cc',
                color: '#fff',
                border: 'none',
                padding: '8px 16px',
                borderRadius: '8px',
                fontSize: '13px',
                marginRight: '6px',
                transition: '0.25s',
            });
        }
    },
    {
        extend: 'pdf',
        text: '<i class="la la-file-pdf-o"></i> ' + (lang === 'ar' ? 'PDF' : 'PDF'),
        init: function(api, node) {
            $(node).css({
                background: '#e74a3b',
                color: '#fff',
                border: 'none',
                padding: '8px 16px',
                borderRadius: '8px',
                fontSize: '13px',
                marginRight: '6px',
                transition: '0.25s',
            });
        }
    },
    {
        extend: 'print',
        text: '<i class="la la-print"></i> ' + (lang === 'ar' ? 'طباعة' : 'Print'),
        init: function(api, node) {
            $(node).css({
                background: '#858796',
                color: '#fff',
                border: 'none',
                padding: '8px 16px',
                borderRadius: '8px',
                fontSize: '13px',
                marginRight: '6px',
                transition: '0.25s',
            });
        }
    },
],
            /** ----------------------------------------------------
             *  ✔ Language Support
             * ---------------------------------------------------- */
            language: lang === "ar" ? {
                url: "//cdn.datatables.net/plug-ins/1.13.8/i18n/ar.json"
            } : {
                url: "//cdn.datatables.net/plug-ins/1.13.8/i18n/en-GB.json"
            },

        });

    });
</script>

@endpush
