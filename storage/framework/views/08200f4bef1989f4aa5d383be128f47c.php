    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->reply): ?>
    <button class="btn btn-outline-primary" data-toggle="modal"
        data-target="#replyPage_<?php echo e($item->id); ?>">
        <i class="fa fa-expand"></i> <?php echo e(__('dashboard.fullscreen')); ?>

    </button>

    <!-- Fullscreen Modal -->
    <div class="modal fade" id="replyPage_<?php echo e($item->id); ?>" tabindex="-1" role="dialog" aria-labelledby="fullscreenModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fullscreenModalLabel"><?php echo e(__('dashboard.fullscreen')); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="fullscreenCarousel" class="" data-ride="carousel">
                                <div class="active">
                                    <p><?php echo e($item->reply); ?></p>
                                </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
     <a href="<?php echo e(route('dashboard.faq.question.replyForm',$item->id)); ?>" question-id="<?php echo e($item->id); ?>"  class="reply_btn btn btn-outline-danger">
            <?php echo e(__('dashboard.reply')); ?> <i class="la la-reply"></i>
        </a>

<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH D:\my laravel projects\e-commerce paid\e-commerce12\resources\views/dashboard/faq-questions/datatables/reply.blade.php ENDPATH**/ ?>