@extends('layouts.dashboard.app')
@section('title')
    {{ __('dashboard.products') }}
@endsection

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block">{{ __('dashboard.products_table') }}</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a
                                        href="{{ route('dashboard.index') }}">{{ __('dashboard.dashboard') }}</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('dashboard.products.index') }}">
                                        {{ __('dashboard.products') }}</a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
                @include('dashboard.includes.button-header')
            </div>

            {{-- ============================================================
                 CUSTOM STYLES
            ============================================================ --}}
            <style>
                /* ── Table wrapper ───────────────────────────────────────── */
                #yajra_table_wrapper {
                    font-size: 0.875rem;
                    width: 100% !important;
                    overflow-x: auto;
                }

                /* Force the wrapper div DataTables injects to scroll, not overflow */
                .dataTables_scrollBody,
                div.dataTables_wrapper {
                    overflow-x: auto !important;
                    width: 100% !important;
                }

                #yajra_table {
                    width: 100% !important;
                    table-layout: fixed;
                }

                /* Column width budgets — total ~100% */
                #yajra_table thead th:nth-child(1)  { width: 42px;  }  /* # */
                #yajra_table thead th:nth-child(2)  { width: 130px; }  /* name */
                #yajra_table thead th:nth-child(3)  { width: 70px;  }  /* has_variants */
                #yajra_table thead th:nth-child(4)  { width: 120px; }  /* images */
                #yajra_table thead th:nth-child(5)  { width: 80px;  }  /* status */
                #yajra_table thead th:nth-child(6)  { width: 90px;  }  /* sku */
                #yajra_table thead th:nth-child(7)  { width: 90px;  }  /* available_for */
                #yajra_table thead th:nth-child(8)  { width: 90px;  }  /* category */
                #yajra_table thead th:nth-child(9)  { width: 80px;  }  /* brand */
                #yajra_table thead th:nth-child(10) { width: 70px;  }  /* price */
                #yajra_table thead th:nth-child(11) { width: 60px;  }  /* quantity */
                #yajra_table thead th:nth-child(12) { width: 180px; }  /* actions */

                /* Clip overflowing text in tight columns */
                #yajra_table td {
                    overflow: hidden;
                    text-overflow: ellipsis;
                    white-space: nowrap;
                    vertical-align: middle;
                    padding: 10px 8px;
                }

                /* Let images column and actions column wrap naturally */
                #yajra_table td:nth-child(4),
                #yajra_table td:nth-child(12) {
                    white-space: normal;
                    overflow: visible;
                }

                #yajra_table thead th {
                    background: #2d3a4a;
                    color: #fff;
                    font-weight: 600;
                    letter-spacing: 0.03em;
                    white-space: nowrap;
                    vertical-align: middle;
                    border-bottom: none;
                    padding: 12px 8px;
                    overflow: hidden;
                    text-overflow: ellipsis;
                }

                #yajra_table tbody tr:hover {
                    background-color: #f0f6ff;
                    transition: background 0.15s ease;
                }

                /* ── Action buttons inside table ─────────────────────────── */
                .product-actions {
                    display: flex;
                    flex-wrap: wrap;
                    gap: 4px;
                }

                .product-actions .btn {
                    padding: 4px 7px;
                    font-size: 0.72rem;
                    border-radius: 5px;
                    white-space: nowrap;
                    display: inline-flex;
                    align-items: center;
                    gap: 3px;
                    transition: all 0.2s ease;
                    font-weight: 500;
                    line-height: 1.3;
                }

                .product-actions .btn i {
                    font-size: 0.9rem;
                    line-height: 1;
                }

                /* ── Product carousel in table ───────────────────────────── */
                .product-carousel-wrap {
                    width: 110px;
                    border-radius: 8px;
                    overflow: hidden;
                    box-shadow: 0 2px 8px rgba(0,0,0,0.12);
                }

                .product-carousel-wrap .carousel-item img {
                    width: 110px;
                    height: 80px;
                    object-fit: cover;
                    display: block;
                }

                .product-carousel-wrap .carousel-control-prev,
                .product-carousel-wrap .carousel-control-next {
                    width: 24px;
                    background: rgba(0,0,0,0.35);
                    border-radius: 4px;
                    opacity: 0;
                    transition: opacity 0.2s;
                }

                .product-carousel-wrap:hover .carousel-control-prev,
                .product-carousel-wrap:hover .carousel-control-next {
                    opacity: 1;
                }

                .product-carousel-wrap .carousel-control-prev-icon,
                .product-carousel-wrap .carousel-control-next-icon {
                    width: 14px;
                    height: 14px;
                }

                /* ── Responsive modal override ───────────────────────────── */
                /* DataTables responsive detail modal */
                div.dtr-modal div.dtr-modal-display {
                    border-radius: 12px;
                    padding: 0;
                    overflow: hidden;
                    box-shadow: 0 20px 60px rgba(0,0,0,0.25);
                    max-width: 520px;
                    width: 92%;
                }

                div.dtr-modal div.dtr-modal-content {
                    padding: 0;
                }

                /* Modal header injected by DataTables */
                div.dtr-modal div.dtr-modal-content h2 {
                    background: #2d3a4a;
                    color: #fff;
                    margin: 0;
                    padding: 16px 20px;
                    font-size: 1rem;
                    font-weight: 600;
                    letter-spacing: 0.02em;
                    border-radius: 0;
                }

                /* Modal close button */
                div.dtr-modal div.dtr-modal-close {
                    position: absolute;
                    top: 12px;
                    right: 16px;
                    background: transparent;
                    border: none;
                    color: #fff;
                    font-size: 1.4rem;
                    cursor: pointer;
                    line-height: 1;
                    z-index: 10;
                    transition: transform 0.15s ease;
                }

                div.dtr-modal div.dtr-modal-close:hover {
                    transform: scale(1.2);
                }

                /* Inner table inside responsive modal */
                div.dtr-modal table.dtr-details {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 0;
                }

                div.dtr-modal table.dtr-details td {
                    padding: 10px 20px;
                    border-bottom: 1px solid #f0f0f0;
                    font-size: 0.855rem;
                    vertical-align: middle;
                }

                div.dtr-modal table.dtr-details tr:last-child td {
                    border-bottom: none;
                }

                div.dtr-modal table.dtr-details td.dtr-title {
                    font-weight: 600;
                    color: #2d3a4a;
                    width: 38%;
                    background: #f8f9fb;
                }

                div.dtr-modal table.dtr-details td.dtr-data {
                    color: #444;
                }

                /* Overlay */
                div.dtr-modal-background {
                    background: rgba(0,0,0,0.5);
                    backdrop-filter: blur(3px);
                }

                /* ── Inline child row (non-modal fallback) ───────────────── */
                tr.child td.child {
                    padding: 0 !important;
                }

                ul.dtr-details {
                    margin: 0;
                    padding: 10px 16px;
                    list-style: none;
                    background: #f8f9fb;
                    border-left: 3px solid #2d3a4a;
                }

                ul.dtr-details li {
                    padding: 6px 0;
                    border-bottom: 1px solid #eee;
                    font-size: 0.855rem;
                    display: flex;
                    gap: 8px;
                    align-items: flex-start;
                }

                ul.dtr-details li:last-child {
                    border-bottom: none;
                }

                ul.dtr-details span.dtr-title {
                    font-weight: 600;
                    color: #2d3a4a;
                    min-width: 130px;
                }

                ul.dtr-details span.dtr-data {
                    color: #444;
                }

                /* ── DataTables toolbar buttons ──────────────────────────── */
                .dt-buttons .dt-button {
                    border-radius: 6px !important;
                    font-size: 0.8rem !important;
                    padding: 5px 12px !important;
                    font-weight: 500 !important;
                    border: 1px solid #cbd5e0 !important;
                    background: #fff !important;
                    color: #2d3a4a !important;
                    transition: all 0.15s ease !important;
                    margin-right: 4px !important;
                    box-shadow: 0 1px 3px rgba(0,0,0,0.06) !important;
                }

                .dt-buttons .dt-button:hover {
                    background: #2d3a4a !important;
                    color: #fff !important;
                    border-color: #2d3a4a !important;
                }

                /* ── Search & length select ──────────────────────────────── */
                div.dataTables_filter input,
                div.dataTables_length select {
                    border: 1px solid #d1d5db;
                    border-radius: 6px;
                    padding: 5px 10px;
                    font-size: 0.855rem;
                    outline: none;
                    transition: border-color 0.2s;
                }

                div.dataTables_filter input:focus,
                div.dataTables_length select:focus {
                    border-color: #2d3a4a;
                    box-shadow: 0 0 0 3px rgba(45,58,74,0.1);
                }

                /* ── Status badge ────────────────────────────────────────── */
                .badge-status {
                    display: inline-block;
                    padding: 3px 10px;
                    border-radius: 20px;
                    font-size: 0.75rem;
                    font-weight: 600;
                    letter-spacing: 0.04em;
                }
                .badge-status.active   { background: #d1fae5; color: #065f46; }
                .badge-status.inactive { background: #fee2e2; color: #991b1b; }
            </style>

            <div class="row" style="display: flex; justify-content: center;">
                <div class="col-md-11">
                    <div class="content-body">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title" id="basic-layout-colored-form-control">
                                    {{ __('dashboard.products') }}
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

                                    <a href="{{ route('dashboard.products.create') }}" class="btn btn-outline-success mb-2">
                                        <i class="la la-plus mr-1"></i>{{ __('dashboard.create_product') }}
                                    </a>

                                    <p class="card-text text-muted small">{{ __('dashboard.table_yajra_paragraph') }}.</p>

                                    <table id="yajra_table" class="table table-striped table-bordered language-file">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{ __('dashboard.product_name') }}</th>
                                                <th>{{ __('dashboard.has_variants') }}</th>
                                                <th>{{ __('dashboard.images') }}</th>
                                                <th>{{ __('dashboard.status') }}</th>
                                                <th>{{ __('dashboard.sku') }}</th>
                                                <th>{{ __('dashboard.available_for') }}</th>
                                                <th>{{ __('dashboard.category') }}</th>
                                                <th>{{ __('dashboard.brand') }}</th>
                                                <th>{{ __('dashboard.price') }}</th>
                                                <th>{{ __('dashboard.quantity') }}</th>
                                                <th>{{ __('dashboard.actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- populated by DataTables --}}
                                        </tbody>
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
    <script>
        var lang = "{{ app()->getLocale() }}";

        var table = $('#yajra_table').DataTable({
            processing: true,
            serverSide: true,
            fixedHeader: true,
            colReorder: true,
            rowReorder: {
                update: false,
                selector: "td:not(:first-child):not(:nth-child(4))",
            },
            select: true,
            responsive: {
                details: {
                    display: DataTable.Responsive.display.modal({
                        header: function(row) {
                            var data = row.data();
                            return '<i class="la la-box mr-1"></i> ' + data['name'];
                        }
                    }),
                    renderer: DataTable.Responsive.renderer.tableAll()
                }
            },
            ajax: "{{ route('dashboard.products.all') }}",
            columns: [
                { data: 'DT_RowIndex',  searchable: false, orderable: false },
                { data: 'name',         name: 'name' },
                { data: 'has_variants', name: 'has_variants' },
                { data: 'images',       name: 'images' },
                { data: 'status',       name: 'status' },
                { data: 'sku',          name: 'sku' },
                { data: 'available_for',name: 'available_for' },
                { data: 'category',     name: 'category' },
                { data: 'brand',        name: 'brand' },
                { data: 'price',        name: 'price' },
                { data: 'quantity',     name: 'quantity' },
                { data: 'action',       searchable: false, orderable: false },
            ],
            layout: {
                topStart: {
                    buttons: ['colvis', 'copy', 'print', 'excel', 'pdf']
                }
            },
            language: lang === 'ar' ? {
                url: '//cdn.datatables.net/plug-ins/2.1.8/i18n/ar.json',
            } : {},
        });

        $('table').on('mousedown', 'button', function() { table.rowReorder.disable(); });
        $('table').on('mouseup',   'button', function() { table.rowReorder.enable(); });

        // ── Status toggle ────────────────────────────────────────────────
        $(document).on('click', '.status_btn', function(e) {
            e.preventDefault();
            var currentPage = table.page();
            var product_id  = $(this).attr('product-id');

            $.ajax({
                url: "{{ route('dashboard.products.status') }}",
                method: "POST",
                data: { _token: "{{ csrf_token() }}", id: product_id },
                success: function(data) {
                    table.page(currentPage).draw(false);
                    Swal.fire({
                        position: "top-center",
                        icon: data.status === 'success' ? "success" : "error",
                        title: data.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
        });

        // ── Delete ───────────────────────────────────────────────────────
        $(document).on('click', '.delete_confirm_btn', function(e) {
            e.preventDefault();
            var product_id = $(this).attr('product-id');

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('dashboard.products.destroy', ':id') }}".replace(':id', product_id),
                        type: "DELETE",
                        data: { _token: "{{ csrf_token() }}" },
                        success: function(response) {
                            Swal.fire({
                                title: response.status,
                                text: response.message,
                                icon: response.status === 'success' ? "success" : "error"
                            });
                            if (response.status === 'success') table.ajax.reload();
                        }
                    });
                }
            });
        });
    </script>
@endpush
