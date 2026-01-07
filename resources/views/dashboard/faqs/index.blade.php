@extends('layouts.dashboard.app')

@section('title')
    {{ __('dashboard.faqs') }}
@endsection

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block">{{ __('dashboard.faqs_table') }}</h3>

                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('dashboard.index') }}">{{ __('dashboard.dashboard') }}</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    {{ __('dashboard.faqs') }}
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
                                <h4 class="card-title">{{ __('dashboard.faqs') }}</h4>
                            </div>

                            <div class="card-content">
                                <div class="card-body">
                                    <button type="button" class="btn btn-outline-success mb-1 ml-1" data-toggle="modal"
                                        data-target="#createfaqModal">
                                        {{ __('dashboard.create_faq') }}
                                    </button>
                                    <div>

                                        @forelse ($faqs as $faq)
                                            <div id="faq_div_{{ $faq->id }}">
                                                <div class="card" id="headingCollapse51_{{ $faq->id }}">
                                                    <div role="tabpanel" class="card-header border-success">
                                                        <a data-toggle="collapse" href="#collapse51_{{ $faq->id }}"
                                                            aria-expanded="true"
                                                            aria-controls="collapse51_{{ $faq->id }}"
                                                            class="font-medium-1 success">{{ $faq->question }}</a>
                                                        <a faq-id="{{ $faq->id }}" class="delete_confirm_btn"
                                                            href=""><i class="la la-trash float-right"></i></a>
                                                        <a data-target="#editfaqModal{{ $faq->id }}"
                                                            data-toggle="modal" href=""><i
                                                                class="la la-edit float-right"></i></a>
                                                    </div>
                                                </div>
                                                <div id="collapse51_{{ $faq->id }}" role="tabpanel"
                                                    aria-labelledby="headingCollapse51_{{ $faq->id }}"
                                                    class="card-collapse collapse @if($loop->index == 0) show @endif" aria-expanded="true">
                                                    <div class="card-body">
                                                        {{ $faq->answer }}
                                                    </div>
                                                </div>

                                            </div>
                                            @include('dashboard.faqs._edit_modal')
                                        @empty
                                            <div class="alert alert-info">{{ __('dashboard.no_data') }}</div>
                                    </div>
                                    @endforelse


                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>
    </div>
    @include('dashboard.faqs._create_modal')
@endsection

@push('js')
    @if ($errors->any())
        <script>
            $(document).ready(function() {
                $('#createfaqModal').modal('show');
            });
        </script>
    @endif


    <script>
        $(document).ready(function() {

            let lang = "{{ app()->getLocale() }}";

            $('#createfaq').on('submit', function(e) {
                e.preventDefault();
                var currentPage = $('#yajra_table').DataTable().page(); // get the current page number
                $.ajax({
                    url: "{{ route('dashboard.faqs.store') }}",
                    method: 'post',
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        if (data.status == 'success') {
                            $('#createfaq')[0].reset();
                            $('#yajra_table').DataTable().page(currentPage).draw(false);
                            $('#createfaqModal').modal('hide');
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

            $(document).on('click', '.ajax_delete_btn', function(e) {
                e.preventDefault();
                var faq_id = $(this).attr('faq-id');
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: "btn btn-success",
                        cancelButton: "btn btn-danger"
                    },
                    buttonsStyling: false
                });
                swalWithBootstrapButtons.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel!",
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('dashboard.faqs.destroy', ':id') }}".replace(
                                ':id',
                                faq_id),
                            method: 'delete',
                            data: {
                                _token: "{{ csrf_token() }}"
                            },

                            success: function(data) {
                                if (data.status == 'success') {
                                    $('#yajra_table').DataTable().ajax.reload();
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
                                    $.each(data.responseJSON.errors, function(key,
                                        value) {

                                        $('#error_list').append('<li>' + value[
                                            0] + '</li>');
                                        $('#error_div').show();
                                    });
                                }
                            }
                        });


                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire({
                            title: "Cancelled",
                            text: "Your imaginary file is safe :)",
                            icon: "error"
                        });
                    }
                });

            })

        });
    </script>
    <script>
        /* ===============================
               Fill Edit Modal
            ================================ */
        $(document).on('click', '.edit-faq-btn', function() {

            let btn = $(this);

            $('#edit_id').val(btn.data('id'));
            $('#edit_code').val(btn.data('code'));
            $('#edit_discount').val(btn.data('discount'));
            $('#edit_start').val(btn.data('start'));
            $('#edit_end').val(btn.data('end'));
            $('#edit_limit').val(btn.data('limit'));
            $('#edit_used').val(btn.data('used'));

            if (btn.data('active') == 1) {
                $('#edit_active').prop('checked', true);
            } else {
                $('#edit_inactive').prop('checked', true);
            }
        });


        /* ===============================
           Update faq (AJAX)
        ================================ */
        $(document).on('click', '.update_faq_btn', function(e) {
            e.preventDefault();

            let form = $('#updatefaq')[0];
            let formData = new FormData(form);
            let faqId = $('#edit_id').val();

            $('#edit_error_list').html('');
            $('#edit_error_div').addClass('d-none');

            Swal.fire({
                title: "Are you sure?",
                text: "faq will be updated",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, update",
                cancelButtonText: "Cancel"
            }).then((result) => {

                if (result.isConfirmed) {

                    $.ajax({
                        url: "{{ route('dashboard.faqs.update', ':id') }}".replace(':id', faqId),
                        method: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },

                        success: function(data) {

                            if (data.status === 'success') {

                                $('#editfaqModal').modal('hide');
                                $('#yajra_table').DataTable().ajax.reload(null, false);

                                Swal.fire({
                                    icon: "success",
                                    title: data.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            }
                        },

                        error: function(xhr) {

                            if (xhr.responseJSON?.errors) {
                                $.each(xhr.responseJSON.errors, function(key, value) {
                                    $('#edit_error_list').append('<li>' + value[0] +
                                        '</li>');
                                });
                                $('#edit_error_div').removeClass('d-none');
                            }
                        }
                    });
                }
            });
        });
    </script>


@endpush
