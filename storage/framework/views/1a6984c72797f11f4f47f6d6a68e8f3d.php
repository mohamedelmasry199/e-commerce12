<div class="form-group">
    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">

        <a href="<?php echo e(route('dashboard.pages.edit', $page->id)); ?>" class="btn btn-outline-success">
            <?php echo e(__('dashboard.edit')); ?> <i class="la la-edit"></i>
        </a>

        <a href="javascript:void(0)" page-id="<?php echo e($page->id); ?>"  class="delete_confirm_btn btn btn-outline-danger">
            <?php echo e(__('dashboard.delete')); ?> <i class="la la-trash"></i>
        </a>

    </div>
</div>
<?php /**PATH D:\my laravel projects\e-commerce paid\e-commerce12\resources\views/dashboard/pages/datatables/action.blade.php ENDPATH**/ ?>