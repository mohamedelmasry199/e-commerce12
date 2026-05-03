<div class="form-group">
    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
      <a href="<?php echo e(route('dashboard.categories.edit', $category->id)); ?>" type="button" class="btn  btn-outline-success" > <?php echo e(__('dashboard.edit')); ?> <i class="la la-edit"></i></a>
      <a href="<?php echo e(route('dashboard.categories.edit' , $category->id)); ?>" type="button" class="btn btn-outline-info"><?php echo e(__('dashboard.status_management')); ?> <i class="la la-stop"></i> </a>
      <div class="btn-group" role="group">
        <button id="btnGroupDrop2" type="button" class="btn btn-outline-danger dropdown-toggle"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php echo e(__('dashboard.delete')); ?><i class="la la-trash"></i>
        </button>

        <div class="dropdown-menu" aria-labelledby="btnGroupDrop2">
            <form  action="<?php echo e(route('dashboard.categories.destroy', $category->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" class="delete_confirm dropdown-item"><?php echo e(__('dashboard.delete')); ?></button>
            </form>
        </div>
      </div>
    </div>
  </div>
<?php /**PATH D:\my laravel projects\e-commerce paid\e-commerce12\resources\views/dashboard/categories/datatables/actions.blade.php ENDPATH**/ ?>