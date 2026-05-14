<div>
 
    <div class="price">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->isSimple()): ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->firstVariant()->has_discount == 0): ?>
                <span class="new-price"><?php echo e($product->firstVariant()->price); ?> EGP</span>
            <?php else: ?>
                <span class="price-cut"><?php echo e($product->firstVariant()->price); ?> EGP</span>
                <span class="new-price"><?php echo e($product->getPriceAfterDiscount()); ?>

                    EGP</span>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php else: ?>
         <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($discount == 0): ?>
                <span class="new-price"><?php echo e($price); ?> EGP</span>
            <?php else: ?>
                <span class="price-cut"><?php echo e($price); ?> EGP</span>
                <span class="new-price"><?php echo e($price - $discount); ?>

                    EGP</span>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

<p class="content-paragraph"><?php echo e($product->small_desc); ?></p>
<hr>


<div class="product-availability">
    <span><?php echo e(__('website.availabillity')); ?> : </span>
    <span class="inner-text">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->has_variants): ?>
            <?php echo e($quantity); ?> <?php echo e(__('website.in_stock')); ?>

        <?php else: ?>
            <?php echo e($product->firstVariant()->manage_stock == 1 ? $product->firstVariant()->stock : __('website.available')); ?>

        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </span>
</div>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->has_variants): ?>
    <div class="product-size">
        <p class="size-title"><?php echo e(__('website.variants')); ?></p>

        
        <div class="selected-attributes">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->id == $variantId): ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $item->VariantAttributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $itemAttr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <p class="size-title">
                            <?php echo e($itemAttr->attributeValue->attribute->name); ?>:
                            <?php echo e($itemAttr->attributeValue->value); ?>

                        </p>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <div class="size-section">
            <span class="size-text"><?php echo e(__('website.select_variant')); ?></span>
        </div>

        <ul class="size-option">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a wire:click="changeVariant(<?php echo e($item->id); ?>)"
                   href="javascript:void(0)"
                   class="option <?php echo e($item->id == $variantId ? 'active' : ''); ?>">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $item->VariantAttributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $itemAttr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <span class="option-text">
                            <?php echo e($itemAttr->attributeValue->attribute->name); ?>:
                            <?php echo e($itemAttr->attributeValue->value); ?>

                        </span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </ul>
    </div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


<div class="product-quantity">
    <div class="quantity-wrapper">
        <div class="quantity">
            <a href="" wire:click.prevent="decrementCartQuantity" class="minus">-</a>
            <span class="number"><?php echo e($cartQuantity); ?></span>
            <a href="" wire:click.prevent="incrementCartQuantity" class="plus">+</a>
        </div>
    </div>
    <a href="#" wire:click.prevent="addToCart" class="shop-btn">
        <span></span>
        <span><?php echo e(__('Add to Cart')); ?></span>
    </a>
</div>


<a href="#" wire:click.prevent="toggleWishlist"
   style="
       display: inline-flex;
       align-items: center;
       gap: 8px;
       padding: 10px 20px;
       border-radius: 12px;
       font-size: 14px;
       font-weight: 500;
       cursor: pointer;
       text-decoration: none;
       transition: opacity 0.15s;
       border: 1.5px solid <?php echo e($inWishlist ? '#e74c3c' : '#ccc'); ?>;
       background: <?php echo e($inWishlist ? '#fff0f0' : 'transparent'); ?>;
       color: <?php echo e($inWishlist ? '#e74c3c' : 'inherit'); ?>;
   ">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="<?php echo e($inWishlist ? '#e74c3c' : 'none'); ?>"
         stroke="<?php echo e($inWishlist ? '#e74c3c' : 'currentColor'); ?>" stroke-width="2"
         stroke-linecap="round" stroke-linejoin="round">
        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
    </svg>
    <?php echo e($inWishlist ? __('website.remove_from_wishlist') : __('website.add_to_wishlist')); ?>

</a>
    <?php
        $__scriptKey = '829434112-0';
        ob_start();
    ?>
    <script>
        $wire.on('successMessage', (event) => {
            Swal.fire({
                position: "top-center",
                icon: "success",
                title: event,
                showConfirmButton: false,
                timer: 1500
            });
        });

        $wire.on('errorMessage', (event) => {
            Swal.fire({
                position: "top-center",
                icon: "error",
                title: event,
                showConfirmButton: false,
                timer: 1500
            });
        });
    </script>
    <?php
        $__output = ob_get_clean();

        \Livewire\store($this)->push('scripts', $__output, $__scriptKey)
    ?>

</div>
<?php /**PATH D:\my laravel projects\e-commerce paid\e-commerce12\resources\views/livewire/website/product-details.blade.php ENDPATH**/ ?>