<div>
    <form wire:submit.prevent="submit">
        <div class="question-section login-section ">
            <div class="review-form">
                <h5 class="comment-title"><?php echo e(__('website.have_any_question')); ?></h5>
                <div class=" account-inner-form">
                    <div class="review-form-name">
                        <label for="fname" class="form-label"><?php echo e(__('website.name')); ?>*</label>
                        <input wire:model.live="name" type="text" id="fname" class="form-control"
                            placeholder="<?php echo e(__('website.name')); ?>">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <strong class="text-danger" role="alert"><?php echo e($message); ?></strong>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div class="review-form-name">
                        <label for="email" class="form-label"><?php echo e(__('website.email')); ?>*</label>
                        <input wire:model.live="email" type="email" id="email" class="form-control"
                            placeholder="user@gmail.com">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <strong class="text-danger" role="alert"><?php echo e($message); ?></strong>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div class="review-form-name">
                        <label for="subject" class="form-label"><?php echo e(__('website.subject')); ?>*</label>
                        <input wire:model.live="subject" type="text" id="subject" class="form-control"
                            placeholder="<?php echo e(__('website.subject')); ?>">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['subject'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <strong class="text-danger" role="alert"><?php echo e($message); ?></strong>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
                <div class="review-textarea">
                    <label for="floatingTextarea"><?php echo e(__('website.message')); ?>*</label>
                    <textarea wire:model.live="message" class="form-control" placeholder="<?php echo e(__('website.write_message')); ?>..........."
                        id="floatingTextarea" rows="3"></textarea>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <strong class="text-danger" role="alert"><?php echo e($message); ?></strong>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <div class="login-btn">
                    <button type="submit" class="shop-btn"><?php echo e(__('website.send')); ?></button>
                </div>
            </div>
        </div>
    </form>
</div>

<?php /**PATH D:\my laravel projects\e-commerce paid\e-commerce12\resources\views/livewire/website/faq-question.blade.php ENDPATH**/ ?>