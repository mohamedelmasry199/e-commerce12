@extends('layouts.dashboard.app')

@section('title')
    {{ __('dashboard.coupons') }}
@endsection

@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
                <h3 class="content-header-title mb-0 d-inline-block">{{ __('dashboard.coupons_table') }}</h3>

                <div class="row breadcrumbs-top d-inline-block">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard.index') }}">{{ __('dashboard.dashboard') }}</a>
                            </li>
                            <li class="breadcrumb-item active">
                                {{ __('dashboard.coupons') }}
                            </li>
                        </ol>
                    </div>
                </div>
            </div>

            @include('dashboard.includes.button-header')
        </div>

        <div class="row" style="display:flex; justify-content:center;">
            <div class="col-md-11">
                <div class="content-body">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{ __('dashboard.coupons') }}</h4>
                        </div>

                        <div class="card-content">
                            <div class="card-body">

                                <button type="button" class="btn btn-outline-success"
                                        data-toggle="modal" data-target="#createcouponModal">
                                    {{ __('dashboard.create_coupon') }}
                                </button>

                                @include('dashboard.coupons._create_modal')
                                @include('dashboard.includes.tostar-success')
                                @include('dashboard.includes.tostar-error')

                                <table id="yajra_table"
                                       class="table table-striped table-bordered"
                                       style="width:100%; white-space: nowrap;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('dashboard.coupon_code') }}</th>
                                            <th>{{ __('dashboard.discount_percentage') }}</th>
                                            <th>{{ __('dashboard.start_date') }}</th>
                                            <th>{{ __('dashboard.end_date') }}</th>
                                            <th>{{ __('dashboard.usage_limit') }}</th>
                                            <th>{{ __('dashboard.time_used') }}</th>
                                            <th>{{ __('dashboard.status') }}</th>
                                            <th>{{ __('dashboard.created_at') }}</th>
                                            <th>{{ __('dashboard.actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
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
$(document).ready(function () {
    $('#createcouponModal').modal('show');
});
</script>
@endif


<script>
$(document).ready(function () {

    let lang = "{{ app()->getLocale() }}";

   var table = $('#yajra_table').DataTable({
    processing: true,
    serverSide: true,

    // FIX: sync header & body without blank space
    scrollX: true,
    scrollCollapse: true,
    fixedHeader: true,

    responsive: false,  // keep all columns visible
    colReorder: true,
    select: true,

    ajax: "{{ route('dashboard.coupons.all') }}",

    columns: [
        { data: 'DT_RowIndex', orderable: false, searchable: false },
        { data: 'code', name: 'code' },
        { data: 'discount_precentage', name: 'discount_precentage' },
        { data: 'start_date', name: 'start_date' },
        { data: 'end_date', name: 'end_date' },
        { data: 'limit', name: 'limit' },
        { data: 'time_used', name: 'time_used' },
        { data: 'status', name: 'status' },
        { data: 'created_at', name: 'created_at' },
        { data: 'action', orderable: false, searchable: false },
    ],

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

    language: lang === 'ar'
        ? { url: "//cdn.datatables.net/plug-ins/1.13.8/i18n/ar.json" }
        : { url: "//cdn.datatables.net/plug-ins/1.13.8/i18n/en-GB.json" },
});


  $('#createCoupon').on('submit', function(e) {
            e.preventDefault();
            var currentPage = $('#yajra_table').DataTable().page(); // get the current page number
            $.ajax({
                url: "{{ route('dashboard.coupons.store') }}",
                method: 'post',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.status == 'success') {
                        $('#createCoupon')[0].reset();
                        $('#yajra_table').DataTable().page(currentPage).draw(false);
                        $('#createcouponModal').modal('hide');
                        Swal.fire({
                            position: "top-center",
                            icon: "success",
                            title: data.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else {
                        Swal.fire({
                            position: "top-center",
                            icon: "error",
                            title: data.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }

                },
                error: function(data) {
                    if (data.responseJSON.errors) {
                        $.each(data.responseJSON.errors, function(key, value) {

                            $('#error_list').append('<li>' + value[0] + '</li>');
                            $('#error_div').show();
                        });
                    }
                }
            });
        })

});

</script>


@endpush
