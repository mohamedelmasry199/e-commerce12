<?php $__env->startSection('title'); ?>
    <?php echo e(__('dashboard.order_items')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block"><?php echo e(__('dashboard.order_items_table')); ?></h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a
                                        href="<?php echo e(route('dashboard.index')); ?>"><?php echo e(__('dashboard.dashboard')); ?></a>
                                </li>
                                <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard.orders.index')); ?>">
                                        <?php echo e(__('dashboard.orders')); ?></a>
                                </li>
                                <li class="breadcrumb-item"><a href="javascript:void(0)">
                                        <?php echo e(__('dashboard.order_items')); ?></a>
                                </li>


                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="header-styling">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title"><?php echo e(__('dashboard.order_items')); ?> </h4><br>
                            
                            <div class="mb-2">
                                <!-- Change Status to Delivered -->
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($orderWithItems->status !== 'delivered'): ?>
                                    <a href="<?php echo e(route('dashboard.orders.markDelivered', $orderWithItems->id)); ?>"
                                        class="btn btn-success"
                                        onclick="return confirm('<?php echo e(__('dashboard.confirm_mark_delivered')); ?>')">
                                        <?php echo e(__('dashboard.mark_as_delivered')); ?>

                                    </a>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                <!-- Delete Order Form -->
                                <form action="<?php echo e(route('dashboard.orders.destroy', $orderWithItems->id)); ?>" method="POST"
                                    style="display:inline-block;"
                                    onsubmit="return confirm('<?php echo e(__('dashboard.confirm_delete')); ?>')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-danger">
                                        <?php echo e(__('dashboard.delete_order')); ?>

                                    </button>
                                </form>
                            </div>

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
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                <p class="card-text">Example of a custom table
                                    <em>header</em> styling. Table header supports default contextual
                                    and custom background colors available in <a href="colors-primary-palette.html"
                                        target="_blank">bootstrap brand colors</a>. To use bootstrap
                                    brand color in the table header, add <code>.bg-*</code> class
                                    to the header row. All border and text colors will be automatically
                                    adjusted.
                                </p>
                            </div>
                            <div class="card-body">
                                <h4 class="card-title"><?php echo e(__('dashboard.order_details')); ?></h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong><?php echo e(__('dashboard.user_name')); ?>:</strong>
                                            <?php echo e($orderWithItems->user_name); ?></p>
                                        <p><strong><?php echo e(__('dashboard.user_phone')); ?>:</strong>
                                            <?php echo e($orderWithItems->user_phone); ?></p>
                                        <p><strong><?php echo e(__('dashboard.user_email')); ?>:</strong>
                                            <?php echo e($orderWithItems->user_email); ?></p>
                                        <p><strong><?php echo e(__('dashboard.note')); ?>:</strong> <?php echo e($orderWithItems->note); ?></p>
                                        <p><strong><?php echo e(__('dashboard.status')); ?>:</strong>
                                            <span
                                                class="badge
                                                <?php if($orderWithItems->status == 'pending'): ?> badge-warning
                                                <?php elseif($orderWithItems->status == 'paid'): ?> badge-primary
                                                <?php elseif($orderWithItems->status == 'delivered'): ?> badge-success
                                                <?php elseif($orderWithItems->status == 'cancelled'): ?> badge-danger <?php endif; ?>">
                                                <?php echo e(ucfirst($orderWithItems->status)); ?>

                                            </span>
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong><?php echo e(__('dashboard.country')); ?>:</strong> <?php echo e($orderWithItems->country); ?>

                                        </p>
                                        <p><strong><?php echo e(__('dashboard.governorate')); ?>:</strong>
                                            <?php echo e($orderWithItems->governorate); ?></p>
                                        <p><strong><?php echo e(__('dashboard.city')); ?>:</strong> <?php echo e($orderWithItems->city); ?></p>
                                        <p><strong><?php echo e(__('dashboard.street')); ?>:</strong> <?php echo e($orderWithItems->street); ?>

                                        </p>
                                        <p><strong><?php echo e(__('dashboard.coupon')); ?>:</strong> <?php echo e($orderWithItems->coupon ?? __('dashboard.none')); ?></p>
                                        <p><strong><?php echo e(__('dashboard.coupon_discount')); ?>:</strong> <?php echo e($orderWithItems->coupon_discount ?? __('dashboard.no_coupon_discount')); ?>%</p>
                                    </div>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <div class="glass-box">
                                            <p class="mb-0">
                                                <strong><i class="fas fa-dollar-sign"></i>
                                                    <?php echo e(__('dashboard.price')); ?>:</strong>
                                                <?php echo e($orderWithItems->price); ?> EGP
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="glass-box">
                                            <p class="mb-0">
                                                <strong><i class="fas fa-shipping-fast"></i>
                                                    <?php echo e(__('dashboard.shipping_price')); ?>:</strong>
                                                <?php echo e($orderWithItems->shipping_price); ?> EGP
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="glass-box">
                                            <p class="mb-0">
                                                <strong><i class="fas fa-calculator"></i>
                                                    <?php echo e(__('dashboard.total_price')); ?>:</strong>
                                                <?php echo e($orderWithItems->total_price); ?> EGP
                                            </p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="bg-success white">
                                        <tr>
                                            <th><?php echo e(__('dashboard.product_name')); ?></th>
                                            <th><?php echo e(__('dashboard.product_quantity')); ?></th>
                                            <th><?php echo e(__('dashboard.product_price')); ?></th>
                                            <th><?php echo e(__('dashboard.product_price_for_quantity')); ?></th>
                                            <th><?php echo e(__('dashboard.attributes')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $orderWithItems->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($item->product_name); ?></td>
                                                <td><?php echo e($item->product_quantity); ?></td>
                                                <td><?php echo e($item->product_price); ?></td>
                                                <td><?php echo e($item->product_price * $item->product_quantity); ?></td>
                                                <td>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->attributes != null): ?>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $item->attributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attr => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <h5 style="margin-right: 4px" class="heading">
                                                                <?php echo e($attr . ' : ' . $value); ?> </h5>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    <?php else: ?>
                                                        <h5 class="heading">No Attributes</h5>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
    <style>
        .glass-box {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border-radius: 5px;
            padding: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease-in-out;
        }

        .glass-box:hover {
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.15);
        }
    </style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.dashboard.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\my laravel projects\e-commerce paid\e-commerce12\resources\views/dashboard/orders/show.blade.php ENDPATH**/ ?>