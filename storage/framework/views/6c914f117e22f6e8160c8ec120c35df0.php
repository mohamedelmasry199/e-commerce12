<?php $__env->startSection('title', __('dashboard.reply')); ?>
<?php $__env->startSection('content'); ?>
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-9 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block"><?php echo e(__('dashboard.faq_questions')); ?></h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="<?php echo e(route('dashboard.index')); ?>"><?php echo e(__('dashboard.dashboard')); ?></a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="<?php echo e(route('dashboard.faq.questions.index')); ?>"><?php echo e(__('dashboard.faq_questions')); ?></a>
                                </li>
                                <li class="breadcrumb-item active">
                                    <a href="javascript:void(0)"><?php echo e(__('dashboard.reply')); ?></a>
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
                                <h4 class="card-title"><?php echo e(__('dashboard.reply')); ?></h4>
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

                                    <?php echo $__env->make('dashboard.includes.validations-errors', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                                    
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($question->reply): ?>

                                        <div class="alert alert-success">
                                            <i class="la la-check-circle"></i>
                                            <?php echo e(__('dashboard.already_replied')); ?>

                                        </div>

                                        <div class="form-group">
                                            <label><?php echo e(__('dashboard.question')); ?></label>
                                            <div class="p-2 border rounded bg-light">
                                                <?php echo e($question->message); ?>

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label><?php echo e(__('dashboard.reply')); ?></label>
                                            <div class="p-2 border rounded bg-light text-success">
                                                <?php echo e($question->reply); ?>

                                            </div>
                                        </div>

                                        <div class="form-actions left">
                                            <a href="<?php echo e(route('dashboard.faq.questions.index')); ?>" class="btn btn-warning mr-1">
                                                <i class="ft-x"></i> <?php echo e(__('dashboard.back')); ?>

                                            </a>
                                        </div>

                                    
                                    <?php else: ?>

                                        <p class="card-text"><?php echo e(__('dashboard.form_edit')); ?>.</p>

                                        <form class="form"
                                              action="<?php echo e(route('dashboard.faq.questions.reply', $question->id)); ?>"
                                              method="POST">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PUT'); ?>

                                            <div class="form-body">

                                                <div class="form-group">
                                                    <label><?php echo e(__('dashboard.question')); ?></label>
                                                    <div class="p-2 border rounded bg-light">
                                                        <?php echo e($question->message); ?>

                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="reply"><?php echo e(__('dashboard.reply')); ?></label>
                                                    <textarea
                                                        name="reply"
                                                        id="reply"
                                                        rows="6"
                                                        class="form-control <?php $__errorArgs = ['reply'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                        placeholder="<?php echo e(__('dashboard.write_reply')); ?>"><?php echo e(old('reply')); ?></textarea>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['reply'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </div>

                                            </div>

                                            <div class="form-actions left">
                                                <a href="<?php echo e(url()->previous()); ?>" class="btn btn-warning mr-1">
                                                    <i class="ft-x"></i> <?php echo e(__('dashboard.cancel')); ?>

                                                </a>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="la la-paper-plane"></i> <?php echo e(__('dashboard.send_reply')); ?>

                                                </button>
                                            </div>

                                        </form>

                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\my laravel projects\e-commerce paid\e-commerce12\resources\views/dashboard/faq-questions/showReplyForm.blade.php ENDPATH**/ ?>