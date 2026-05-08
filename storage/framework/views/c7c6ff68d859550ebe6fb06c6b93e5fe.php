<div class="form-group">
    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">

        <a href="javascript:void(0)" question-id="<?php echo e($item->id); ?>"  class="delete_confirm_btn btn btn-outline-danger">
            <?php echo e(__('dashboard.delete')); ?> <i class="la la-trash"></i>
        </a>
        <a href="<?php echo e(route('dashboard.faq.question.replyForm',$item->id)); ?>" question-id="<?php echo e($item->id); ?>"  class="reply_btn btn btn-outline-danger">
            <?php echo e(__('dashboard.reply')); ?> <i class="la la-reply"></i>
        </a>

    </div>
</div>
<?php /**PATH D:\my laravel projects\e-commerce paid\e-commerce12\resources\views/dashboard/faq-questions/datatables/action.blade.php ENDPATH**/ ?>