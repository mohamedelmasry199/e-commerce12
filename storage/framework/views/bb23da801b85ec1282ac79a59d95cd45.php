<?php $__env->startSection('title'); ?>
    <?php echo e(__('dashboard.faqs')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block"><?php echo e(__('dashboard.faqs_table')); ?></h3>

                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="<?php echo e(route('dashboard.index')); ?>"><?php echo e(__('dashboard.dashboard')); ?></a>
                                </li>
                                <li class="breadcrumb-item active">
                                    <?php echo e(__('dashboard.faqs')); ?>

                                </li>
                            </ol>
                        </div>
                    </div>
                </div>

                <?php echo $__env->make('dashboard.includes.button-header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>

            <div class="row" style="display:flex; justify-content:center;">
                <div class="col-md-11">
                    <div class="content-body">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"><?php echo e(__('dashboard.faqs')); ?></h4>
                            </div>

                            <div class="card-content">
                                <div class="card-body">
                                    <button type="button" class="btn btn-outline-success mb-1 ml-1" data-toggle="modal"
                                        data-target="#createfaqModal">
                                        <?php echo e(__('dashboard.create_faq')); ?>

                                    </button>
                                    <div>
                                        <div class="card faq_row" id="headingCollapse51">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <div id="faq_div_<?php echo e($faq->id); ?>">
                                                    <div role="tabpanel" class="card-header border-success">
                                                        <a id="question_<?php echo e($faq->id); ?>" data-toggle="collapse"
                                                            href="#collapse51_<?php echo e($faq->id); ?>" aria-expanded="true"
                                                            aria-controls="collapse51_<?php echo e($faq->id); ?>"
                                                            class="font-medium-1 success"><?php echo e($faq->question); ?></a>
                                                        <a faq-id="<?php echo e($faq->id); ?>" class="delete_confirm_btn"
                                                            href=""><i class="la la-trash float-right"></i></a>
                                                        <a faq-id="<?php echo e($faq->id); ?>"
                                                            data-target="#editfaqModal<?php echo e($faq->id); ?>"
                                                            data-toggle="modal" href=""><i
                                                                class="la la-edit float-right"></i></a>
                                                    </div>
                                                    <div id="collapse51_<?php echo e($faq->id); ?>" role="tabpanel"
                                                        aria-labelledby="headingCollapse51_<?php echo e($faq->id); ?>"
                                                        class="card-collapse collapse <?php if($loop->index == 0): ?> show <?php endif; ?>"
                                                        aria-expanded="true">
                                                        <div id="answer_<?php echo e($faq->id); ?>" class="card-body">
                                                            <?php echo e($faq->answer); ?>

                                                        </div>
                                                    </div>

                                                </div>
                                                <?php echo $__env->make('dashboard.faqs._edit_modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <div class="alert alert-info"><?php echo e(__('dashboard.no_data')); ?></div>
                                        </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>


                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>
    </div>
    <?php echo $__env->make('dashboard.faqs._create_modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
        <script>
            $(document).ready(function() {
                $('#createfaqModal').modal('show');
            });
        </script>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


    <script>
        $(document).ready(function() {

            let lang = "<?php echo e(app()->getLocale()); ?>";
            $('#createfaq').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: "<?php echo e(route('dashboard.faqs.store')); ?>",
                    method: 'post',
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        if (data.status == 'success') {
                            var id = data.data.id;
                            var question = lang == 'ar' ? data.data.question.ar : data.data
                                .question.en;
                            var answer = lang == 'ar' ? data.data.answer.ar : data.data.answer
                                .en;
                            $('#createfaq')[0].reset();
                            $('#createfaqModal').modal('hide');
                            $('.faq_row').prepend(` <div role="tabpanel" class="card-header border-success">
                                                        <a data-toggle="collapse" href="#collapse51_${id}"
                                                            aria-expanded="true"
                                                            aria-controls="collapse51_${id}"
                                                            class="font-medium-1 success">${question}</a>
                                                        <a faq-id="${id}" class="delete_confirm_btn"
                                                            href=""><i class="la la-trash float-right"></i></a>
                                                        <a data-target="#editfaqModal${id}"
                                                            data-toggle="modal" href=""><i
                                                                class="la la-edit float-right"></i></a>
                                                    </div>
                                                <div id="collapse51_${id}" role="tabpanel"
                                                    aria-labelledby="headingCollapse51_${id}"
                                                    class="card-collapse collapse show " aria-expanded="true">
                                                    <div class="card-body">
                                                        ${answer}
                                                    </div>
                                                </div>`)
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
                            $('#error_list').empty();
                            $.each(data.responseJSON.errors, function(key, value) {

                                $('#error_list').append('<li>' + value[0] + '</li>');
                                $('#error_div').show();
                            });
                        }
                    }
                });
            })

            $(document).on('click', '.delete_confirm_btn', function(e) {
                e.preventDefault();
                var faq_id = $(this).attr('faq-id');
                console.log(faq_id);
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
                            url: "<?php echo e(route('dashboard.faqs.destroy', ':id')); ?>".replace(
                                ':id',
                                faq_id),
                            method: 'delete',
                            data: {
                                _token: "<?php echo e(csrf_token()); ?>"
                            },

                            success: function(data) {
                                if (data.status == 'success') {
                                                                    $('#faq_div_'+faq_id).remove();

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
                   Update faq (AJAX)
                ================================ */
        $(document).on('click', '.update_faq_btn', function(e) {
            e.preventDefault();
            let lang = "<?php echo e(app()->getLocale()); ?>";
            let form = $('#updatefaq')[0];
            let formData = new FormData(form);

            var faqId = $(this).attr('faq-id');

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
                        url: "<?php echo e(route('dashboard.faqs.update', ':id')); ?>".replace(':id', faqId),
                        method: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                        },

                        success: function(data) {

                            if (data.status === 'success') {
                                if (data.status === 'success') {
                                    console.log('Full data:', data);
                                    console.log('FAQ ID:', faqId);
                                    console.log('Language:', lang);
                                    console.log('Question data:', data.data.question);
                                    console.log('Answer data:', data.data.answer);

                                    var question = lang == 'ar' ? data.data.question.ar : data
                                        .data.question.en;
                                    var answer = lang == 'ar' ? data.data.answer.ar : data.data
                                        .answer.en;

                                    console.log('Selected question:', question);
                                    console.log('Selected answer:', answer);
                                    console.log('Target element:', '#question_' + faqId);
                                    console.log('Element exists?', $('#question_' + faqId)
                                        .length);

                                    $('#editfaqModal' + faqId).modal('hide');
                                    $('#question_' + faqId).text(question);
                                    $('#answer_' + faqId).text(answer);

                                    Swal.fire({
                                        icon: "success",
                                        title: data.message,
                                        timer: 1500,
                                        showConfirmButton: false
                                    });
                                }

                            }
                        },

                        error: function(data) {
                            if (data.responseJSON.errors) {
                                $('#error_list_' + faqId).empty();
                                $.each(data.responseJSON.errors, function(key, value) {
                                    $('#error_list_' + faqId).append('<li>' + value[0] +
                                        '</li>');
                                    $('#error_div_' + faqId).show();
                                });
                            }
                        }

                    });
                }
            });
        });
    </script>


<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.dashboard.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\my laravel projects\e-commerce paid\e-commerce12\resources\views/dashboard/faqs/index.blade.php ENDPATH**/ ?>