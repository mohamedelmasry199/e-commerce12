<div class="form-group">
    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">

        <a href="<?php echo e(route('dashboard.orders.show', $row->id)); ?>" class="btn btn-outline-primary ">
            <?php echo e(__('dashboard.show')); ?> <i class="la la-eye"></i>
        </a>


        <button id="btnGroupDrop2" order-id="<?php echo e($row->id); ?>" type="button"
            class="delete_confirm_btn btn btn-outline-danger">
            <?php echo e(__('dashboard.delete')); ?><i class="la la-trash"></i>
        </button>


    </div>
</div>
<?php /**PATH D:\my laravel projects\e-commerce paid\e-commerce12\resources\views/dashboard/orders/datatables/action.blade.php ENDPATH**/ ?>