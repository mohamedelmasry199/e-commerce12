<?php $__env->startSection('title', __('checkout.failed.title')); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-5 text-center">


            <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-danger bg-opacity-10 mb-4"
                 style="width:72px;height:72px">
                <i class="ti ti-x text-danger" style="font-size:36px"></i>
            </div>

            <h1 class="h4 fw-semibold mb-2"><?php echo e(__('checkout.failed.heading')); ?></h1>
            <p class="text-muted mb-1"><?php echo e(__('checkout.failed.subheading')); ?></p>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
                <p class="text-danger small mb-4"><?php echo e(session('error')); ?></p>
            <?php else: ?>
                <p class="text-muted small mb-4"><?php echo e(__('checkout.failed.default_reason')); ?></p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($order) && $order): ?>
                <div class="card border-0 shadow-sm mb-4 text-start">
                    <div class="card-body p-4">
                        <h2 class="h6 fw-semibold mb-3 text-muted text-uppercase" style="letter-spacing:.05em;font-size:11px">
                            <?php echo e(__('checkout.failed.order_details')); ?>

                        </h2>
                        <div class="d-flex justify-content-between small mb-2">
                            <span class="text-muted"><?php echo e(__('checkout.success.order_number')); ?></span>
                            <strong>#<?php echo e(str_pad($order->id, 6, '0', STR_PAD_LEFT)); ?></strong>
                        </div>
                        <div class="d-flex justify-content-between small mb-2">
                            <span class="text-muted"><?php echo e(__('checkout.total')); ?></span>
                            <span><?php echo e(number_format($order->total_price, 2)); ?> <?php echo e(__('common.currency')); ?></span>
                        </div>
                        <div class="d-flex justify-content-between small">
                            <span class="text-muted"><?php echo e(__('checkout.status')); ?></span>
                            <span class="badge bg-secondary"><?php echo e($order->status); ?></span>
                        </div>
                    </div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


            <div class="card border-0 bg-light mb-4 text-start">
                <div class="card-body p-4">
                    <h2 class="h6 fw-semibold mb-3"><?php echo e(__('checkout.failed.what_happened')); ?></h2>
                    <ul class="list-unstyled mb-0 small text-muted d-flex flex-column gap-2">
                        <li><i class="ti ti-point-filled me-2" style="font-size:8px"></i><?php echo e(__('checkout.failed.reason_card')); ?></li>
                        <li><i class="ti ti-point-filled me-2" style="font-size:8px"></i><?php echo e(__('checkout.failed.reason_cancel')); ?></li>
                        <li><i class="ti ti-point-filled me-2" style="font-size:8px"></i><?php echo e(__('checkout.failed.reason_timeout')); ?></li>
                        <li><i class="ti ti-point-filled me-2" style="font-size:8px"></i><?php echo e(__('checkout.failed.reason_funds')); ?></li>
                    </ul>
                </div>
            </div>


            <p class="text-muted mb-4" style="font-size:12px">
                <i class="ti ti-refresh me-1"></i>
                <?php echo e(__('checkout.failed.stock_note')); ?>

            </p>


            <div class="d-flex flex-column gap-2">
                <a href="<?php echo e(route('website.cart')); ?>" class="btn btn-dark py-3 fw-semibold">
                    <i class="ti ti-shopping-cart me-2"></i>
                    <?php echo e(__('checkout.failed.retry')); ?>

                </a>
                <a href="<?php echo e(route('website.home')); ?>" class="btn btn-outline-secondary py-2">
                    <?php echo e(__('checkout.failed.continue_shopping')); ?>

                </a>
            </div>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.website.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\my laravel projects\e-commerce paid\e-commerce12\resources\views/website/checkout/failed.blade.php ENDPATH**/ ?>
