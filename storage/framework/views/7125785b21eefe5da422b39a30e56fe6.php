<!-- Modal -->
<div class="modal fade" id="createSliderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo e(__('dashboard.create_slider')); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo $__env->make('dashboard.includes.validations-errors', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                <form action="<?php echo e(route('dashboard.sliders.store')); ?>" class="form" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label for="name"><?php echo e(__('dashboard.note_ar')); ?></label>
                        <input type="text" name="note[ar]" class="form-control" id="name"
                            placeholder="<?php echo e(__('dashboard.note_ar')); ?>">
                    </div>
                    <div class="form-group">
                        <label for="name"><?php echo e(__('dashboard.note_en')); ?></label>
                        <input type="text" name="note[en]" class="form-control" id="name"
                            placeholder="<?php echo e(__('dashboard.note_en')); ?>">
                    </div>

                    <div class="form-group">
                        <label for="image"><?php echo e(__('dashboard.image')); ?></label>
                        <input type="file"  name="file_name" class="form-control" id="single-image"
                            placeholder="<?php echo e(__('dashboard.image')); ?>">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal"><i class="ft-x"></i><?php echo e(__('dashboard.close')); ?></button>
                        <button type="submit" class="btn btn-primary">  <i class="la la-check-square-o"></i> <?php echo e(__('dashboard.save')); ?></button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<?php /**PATH D:\my laravel projects\e-commerce paid\e-commerce12\resources\views/dashboard/sliders/_create.blade.php ENDPATH**/ ?>