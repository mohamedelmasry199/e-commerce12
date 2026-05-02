<?php $__env->startSection('title'); ?>
    <?php echo e(__('dashboard.sliders')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block"><?php echo e(__('dashboard.sliders_table')); ?></h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a
                                        href="<?php echo e(route('dashboard.index')); ?>"><?php echo e(__('dashboard.dashboard')); ?></a>
                                </li>
                                <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard.sliders.index')); ?>">
                                        <?php echo e(__('dashboard.sliders')); ?></a>
                                </li>


                            </ol>
                        </div>
                    </div>
                </div>
                <?php echo $__env->make('dashboard.includes.button-header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
            <div class="row" style="display: flex; justify-content: center;">
                <div class="col-md-11">
                    <div class="content-body">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title" id="basic-layout-colored-form-control">
                                    <?php echo e(__('dashboard.sliders')); ?>

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
                                    
                                    <button type="button" class="btn btn-outline-success" data-toggle="modal"
                                        data-target="#createSliderModal">
                                        <?php echo e(__('dashboard.create_slider')); ?>

                                    </button>

                                    
                                    <?php echo $__env->make('dashboard.sliders._create', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                    

                                    <p class="card-text"><?php echo e(__('dashboard.table_yajra_paragraph')); ?>.</p>
                                    <table id="yajra_table" class="table table-striped table-bordered language-file">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th><?php echo e(__('dashboard.image')); ?></th>
                                                <th><?php echo e(__('dashboard.note')); ?></th>
                                                <th><?php echo e(__('dashboard.created_at')); ?></th>
                                                <th><?php echo e(__('dashboard.actions')); ?></th>
                                            </tr>
                                        </thead>

                                        <body>
                                            
                                        </body>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
        <script>
            $(document).ready(function() {
                $('#createSliderModal').modal('show');
            });
        </script>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <script>
        var lang = "<?php echo e(app()->getLocale()); ?>";


        $('#yajra_table').DataTable({
            processing: true,
            serverSide: true,
            fixedHeader: true,
            colReorder: true,
            select: true,
            responsive: {
                details: {
                    display: DataTable.Responsive.display.modal({
                        header: function(row) {
                            var data = row.data();
                            return 'Details for ' + data[0] + ' ' + data[1];
                        }
                    }),
                    renderer: DataTable.Responsive.renderer.tableAll({
                        tableClass: 'table'
                    })
                }
            },
            ajax: "<?php echo e(route('dashboard.sliders.all')); ?>",
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    orderable: false,
                },
                {
                    data: 'file_name',
                    name: 'file_name',
                },
                {
                    data: 'note',
                    name: 'note',
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                },
                {
                    data: 'action',
                    searchable: false,
                    orderable: false,
                },

            ],
            layout: {
                topStart: {
                    buttons: ['colvis', 'copy']
                }
            },


            language: lang === 'ar' ? {
                url: '//cdn.datatables.net/plug-ins/2.1.8/i18n/ar.json',
            } : {},


        });


        // delete slider
        $(document).on('click', '.delete_confirm_btn', function(e) {
            e.preventDefault();
            var slider_id = $(this).attr('slider-id');

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
                        url: "<?php echo e(route('dashboard.sliders.delete', 'id')); ?>".replace('id',
                            slider_id),
                        type: "GET",
                        success: function(response) {
                            if (response.status == 'success') {
                                Swal.fire({
                                    title: response.status,
                                    text: response.message,
                                    icon: "success"
                                });
                                $('#yajra_table').DataTable().ajax.reload();
                            } else {
                                Swal.fire({
                                    title: response.status,
                                    text: response.message,
                                    icon: "error"
                                });
                            }
                        }
                    });

                }
            });

        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.dashboard.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\my laravel projects\e-commerce paid\e-commerce12\resources\views/dashboard/sliders/index.blade.php ENDPATH**/ ?>