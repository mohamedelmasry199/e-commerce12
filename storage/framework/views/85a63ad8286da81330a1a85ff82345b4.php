<?php $__env->startSection('title', __('checkout.success.title')); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">


            <div class="text-center mb-5">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-success bg-opacity-10 mb-3"
                     style="width:72px;height:72px">
                    <i class="ti ti-check text-success" style="font-size:36px"></i>
                </div>
                <h1 class="h4 fw-semibold mb-1"><?php echo e(__('checkout.success.heading')); ?></h1>
                <p class="text-muted mb-0"><?php echo e(__('checkout.success.subheading')); ?></p>
                <p class="text-muted small mt-1">
                    <?php echo e(__('checkout.success.order_number')); ?>

                    <strong>#<?php echo e(str_pad($order->id, 6, '0', STR_PAD_LEFT)); ?></strong>
                </p>
            </div>


            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h2 class="h6 fw-semibold mb-3 text-muted text-uppercase" style="letter-spacing:.05em;font-size:11px">
                        <?php echo e(__('checkout.order_summary')); ?>

                    </h2>

                    <div class="d-flex flex-column gap-3">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="d-flex gap-3 align-items-center">
                                <div style="width:52px;height:52px;flex-shrink:0;border-radius:8px;overflow:hidden;background:#f5f5f5">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->product): ?>
                                        <img src="<?php echo e($item->product->getFirstImage()); ?>"
                                             alt="<?php echo e($item->product_name); ?>"
                                             style="width:100%;height:100%;object-fit:cover">
                                    <?php else: ?>
                                        <div class="w-100 h-100 bg-secondary opacity-25"></div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-0 fw-medium small"><?php echo e($item->product_name); ?></p>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->attributes): ?>
                                        <p class="mb-0 text-muted" style="font-size:11px">
                                            <?php echo e(collect($item->attributes)->map(fn($v,$k)=>"$k: $v")->implode(' · ')); ?>

                                        </p>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <p class="mb-0 text-muted" style="font-size:11px">
                                        <?php echo e(__('checkout.qty')); ?>: <?php echo e($item->product_quantity); ?>

                                    </p>
                                </div>
                                <div class="text-end">
                                    <span class="small fw-medium">
                                        <?php echo e(number_format($item->product_price * $item->product_quantity, 2)); ?>

                                        <?php echo e(__('common.currency')); ?>

                                    </span>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>


            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h2 class="h6 fw-semibold mb-3 text-muted text-uppercase" style="letter-spacing:.05em;font-size:11px">
                        <?php echo e(__('checkout.payment_details')); ?>

                    </h2>

                    <div class="d-flex flex-column gap-2">
                        <div class="d-flex justify-content-between small">
                            <span class="text-muted"><?php echo e(__('checkout.subtotal')); ?></span>
                            <span><?php echo e(number_format($order->price, 2)); ?> <?php echo e(__('common.currency')); ?></span>
                        </div>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->coupon_discount > 0): ?>
                        <div class="d-flex justify-content-between small">
                            <span class="text-success">
                                <?php echo e(__('checkout.discount')); ?>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->coupon): ?>
                                    <span class="badge bg-success bg-opacity-10 text-success ms-1" style="font-size:10px">
                                        <?php echo e($order->coupon); ?>

                                    </span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </span>
                            <span class="text-success">-<?php echo e(number_format($order->coupon_discount, 2)); ?> <?php echo e(__('common.currency')); ?></span>
                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <div class="d-flex justify-content-between small">
                            <span class="text-muted"><?php echo e(__('checkout.shipping')); ?></span>
                            <span><?php echo e(number_format($order->shipping_price, 2)); ?> <?php echo e(__('common.currency')); ?></span>
                        </div>

                        <hr class="my-2">

                        <div class="d-flex justify-content-between fw-semibold">
                            <span><?php echo e(__('checkout.total')); ?></span>
                            <span><?php echo e(number_format($order->total_price, 2)); ?> <?php echo e(__('common.currency')); ?></span>
                        </div>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->transaction): ?>
                        <div class="d-flex justify-content-between small text-muted mt-1">
                            <span><?php echo e(__('checkout.payment_method')); ?></span>
                            <span class="text-capitalize"><?php echo e($order->transaction->payment_method); ?></span>
                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>


            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h2 class="h6 fw-semibold mb-3 text-muted text-uppercase" style="letter-spacing:.05em;font-size:11px">
                        <?php echo e(__('checkout.shipping_address')); ?>

                    </h2>
                    <p class="mb-0 small">
                        <?php echo e($order->user_name); ?><br>
                        <?php echo e($order->street); ?>, <?php echo e($order->city); ?><br>
                        <?php echo e($order->governorate); ?>, <?php echo e($order->country); ?><br>
                        <a href="tel:<?php echo e($order->user_phone); ?>" class="text-muted"><?php echo e($order->user_phone); ?></a>
                    </p>
                </div>
            </div>


            <div class="d-flex gap-3">
                <a href="<?php echo e(route('website.home')); ?>" class="btn btn-dark flex-grow-1 py-3 fw-semibold">
                    <?php echo e(__('checkout.success.continue_shopping')); ?>

                </a>
                <a href="<?php echo e(route('website.orders.show', $order)); ?>" class="btn btn-outline-secondary flex-grow-1 py-3 fw-semibold">
                    <?php echo e(__('checkout.success.view_order')); ?>

                </a>
            </div>


            <p class="text-center text-muted mt-4" style="font-size:12px">
                <i class="ti ti-mail me-1"></i>
                <?php echo e(__('checkout.success.email_note', ['email' => $order->user_email])); ?>

            </p>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.website.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\my laravel projects\e-commerce paid\e-commerce12\resources\views/website/checkout/success.blade.php ENDPATH**/ ?>
