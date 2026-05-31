<div>
    <div class="checkout-wrapper">
        
        <div class="account-section billing-section">
            <h5 class="wrapper-heading">Order Summary</h5>
            <div class="order-summery">
                <div class="subtotal product-total">
                    <h5 class="wrapper-heading">PRODUCT</h5>
                    <h5 class="wrapper-heading">Quantity</h5>
                    <h5 class="wrapper-heading">TOTAL</h5>
                </div>
                <hr>
                <div class="subtotal product-total">
                    <ul class="product-list">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $cart->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <div class="product-info">
                                    <h5 class="wrapper-heading"><?php echo e($item->product->name); ?></-h5>
                                    <p class="paragraph">
                                      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->product_variant_id != null): ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $item->attributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$attr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php echo e($key . ' : ' .  $attr); ?>,
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                       <?php else: ?>
                                        <span class="paragraph">No Variables</span>
                                      <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </p>
                                </div>
                                
                                <div class="price">
                                    <h5 class="wrapper-heading"><?php echo e($item->quantity); ?></h5>
                                </div>
                                 <div class="price">
                                    <h5 class="wrapper-heading"><?php echo e($item->price * $item->quantity); ?> EGP</h5>
                                </div>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </ul>
                </div>
                <hr>
                <div class="subtotal product-total">
                    <h5 class="wrapper-heading">SUBTOTAL</h5>
                    <h5 class="wrapper-heading"><?php echo e($cart->items->sum(fn($item) => $item->price * $item->quantity)); ?> EGP</h5>
                </div>
                <div class="subtotal product-total">
                    <ul class="product-list">
                        <li>
                            <div class="product-info">
                                <p class="paragraph">SHIPPING</p>
                            </div>
                            <div class="price">
                                <h5 class="wrapper-heading">+<?php echo e($shippingPrice); ?> EGP</h5>
                            </div>
                        </li>
                    </ul>
                </div>
                <hr>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($couponInfo): ?>
                 <div class="subtotal total">
                    <h5 class="wrapper-heading">Coupon discount</h5>
                    <h5 class="wrapper-heading price"><?php echo e($couponInfo->discount_precentage ?? $couponInfo->discount_precentage); ?> %</h5>
                </div>

                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <div class="subtotal total">
                    <h5 class="wrapper-heading">TOTAL</h5>
                    <h5 class="wrapper-heading price"><?php echo e($cart->items->sum(fn($item) => $item->price * $item->quantity) * (1 - ($couponInfo->discount_precentage ?? 0) / 100)  + $shippingPrice); ?> EGP</h5>
                </div>
                
            </div>
        </div>
    </div>
</div>
<?php /**PATH D:\my laravel projects\e-commerce paid\e-commerce12\resources\views/livewire/website/checkout/order-summary.blade.php ENDPATH**/ ?>