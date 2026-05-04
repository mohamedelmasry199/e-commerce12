<!-- Contact Messages Page -->
<div class="email-app-list">
    <div class="card-body">
        <fieldset class="form-group position-relative has-icon-left m-0 pb-1">
            <input type="text" wire:model.live="itemSearch" class="form-control" placeholder="Search email">
            <div class="form-control-position">
                <i class="ft-search"></i>
            </div>
        </fieldset>
    </div>
    <div class="list-group">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <a wire:click="showMessage(<?php echo e($msg->id); ?>)" href="#" class="media border-0 <?php echo e($msg->id == $opendMsgId ? 'bg-light' : ''); ?>">
                <div class="media-left pr-1">
                    <span class="avatar avatar-md">
                        <span class="media-object rounded-circle text-circle bg-info">T</span>
                    </span>                </div>
                <div class="media-body w-100">
                    <h6 class="font-weight-bold"><?php echo e($msg->name); ?>

                        <span class="float-right text-muted"><?php echo e($msg->created_at->diffForHumans()); ?></span>
                    </h6>
                    <p class="text-bold-600 mb-0"><?php echo e($msg->subject); ?></p>
                    <p class="mb-0 text-muted"><?php echo e(Str::limit($msg->message, 50)); ?>

                        <span class="float-right">
                            <span class="badge badge-<?php echo e($msg->is_read ? 'success' : 'danger'); ?>"><?php echo e($msg->is_read ? 'Read' : 'New'); ?></span>
                        </span>
                    </p>
                </div>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="text-center p-3">No Messages Found</div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php echo e($messages->links('vendor.livewire.simple-bootstrap')); ?>


    </div>
</div>
<?php /**PATH D:\my laravel projects\e-commerce paid\e-commerce12\resources\views/livewire/dashboard/contact/contact-messages.blade.php ENDPATH**/ ?>