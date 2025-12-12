<!-- BEGIN VENDOR JS -->
<script src="{{ asset('assets/dashboard/vendors/js/vendors.min.js') }}"></script>
<!-- END VENDOR JS -->

<!-- BEGIN PAGE VENDOR JS -->
<script src="{{ asset('assets/dashboard/vendors/js/charts/chartist.min.js') }}"></script>
<script src="{{ asset('assets/dashboard/vendors/js/charts/chartist-plugin-tooltip.min.js') }}"></script>
<script src="{{ asset('assets/dashboard/vendors/js/charts/raphael-min.js') }}"></script>
<script src="{{ asset('assets/dashboard/vendors/js/charts/morris.min.js') }}"></script>
<script src="{{ asset('assets/dashboard/vendors/js/timeline/horizontal-timeline.js') }}"></script>
<!-- END PAGE VENDOR JS -->

<!-- BEGIN MODERN JS -->
<script src="{{ asset('assets/dashboard/js/core/app-menu.js') }}"></script>
<script src="{{ asset('assets/dashboard/js/core/app.js') }}"></script>
<script src="{{ asset('assets/dashboard/js/scripts/customizer.js') }}"></script>
<!-- END MODERN JS -->

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let title = "{{ __('dashboard.are_you_sure') }}";

    $(document).on('click', '.delete_confirm', function(e) {
        e.preventDefault();
        form = $(this).closest('form');

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-danger"
            },
            buttonsStyling: true
        });

        swalWithBootstrapButtons.fire({
            title: title,
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
                swalWithBootstrapButtons.fire({
                    title: "Deleted!",
                    text: "Your file has been deleted.",
                    icon: "success"
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire({
                    title: "Cancelled",
                    text: "Your imaginary file is safe :)",
                    icon: "error"
                });
            }
        });
    });
</script>

<!-- =============================================== -->
<!-- FIXED ✔ DataTables 1.13.x + Bootstrap 5 Support -->
<!-- =============================================== -->

<!-- Core DataTables -->
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

<!-- Buttons -->
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<script src="{{ asset('vendor/datatables/excel/jszip.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/pdf/pdfmake.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/pdf/vfs_fonts.js') }}"></script>

<!-- Responsive -->
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<!-- ColReorder / RowReorder -->
<script src="https://cdn.datatables.net/colreorder/1.7.0/js/dataTables.colReorder.min.js"></script>
<script src="https://cdn.datatables.net/rowreorder/1.5.0/js/dataTables.rowReorder.min.js"></script>

<!-- Select -->
<script src="https://cdn.datatables.net/select/1.7.0/js/dataTables.select.min.js"></script>

<!-- FixedHeader -->
<script src="https://cdn.datatables.net/fixedheader/3.4.0/js/dataTables.fixedHeader.min.js"></script>

<!-- Scroller -->
<script src="https://cdn.datatables.net/scroller/2.2.0/js/dataTables.scroller.min.js"></script>


<!-- FileInput -->
<script src="{{ asset('vendor/file-input/js/fileinput.min.js') }}"></script>
<script src="{{ asset('vendor/file-input/themes/fa5/theme.min.js') }}"></script>

@if(app()->getLocale() == 'ar')
    <script src="{{ asset('vendor/file-input/js/locales/LANG.js') }}"></script>
    <script src="{{ asset('vendor/file-input/js/locales/ar.js') }}"></script>
@endif

<script>
    var lang = "{{ app()->getLocale() }}";

    $('#single-image').fileinput({
        theme: 'fa5',
        language: lang,
        allowedFileTypes: ['image'],
        maxFileCount: 1,
        showUpload: false
    });
</script>
