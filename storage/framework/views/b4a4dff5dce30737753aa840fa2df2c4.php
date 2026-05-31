<div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($couponInfo != null): ?>
        <p class="paragraph" style="color: rgb(210, 77, 77)"> <?php echo e($couponInfo); ?></p>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cartItemsCount > 0 && $cart->coupon == null): ?>
        <div class=" account-inner-form">
            <div class="review-form-name">
                <input wire:model="code" class="form-control" placeholder="Coupon Code">
                <button wire:click="applyCoupon" type="button" class="shop-btn">Apply</button>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>


    <?php
        $__scriptKey = '4012101339-0';
        ob_start();
    ?>
    <script>
        $wire.on('couponApplied', (event) => {
            Swal.fire({
                position: "top-center",
                icon: "success",
                title: event,
                showConfirmButton: false,
                timer: 10000
            });
        });

        $wire.on('couponNotValid', (event) => {
            Swal.fire({
                position: "top-center",
                icon: "error",
                title: event,
                showConfirmButton: false,
                timer: 3500
            });
        });
    </script>
    <?php
        $__output = ob_get_clean();

        \Livewire\store($this)->push('scripts', $__output, $__scriptKey)
    ?>
<?php /**PATH D:\my laravel projects\e-commerce paid\e-commerce12\resources\views/livewire/website/checkout/coupons.blade.php ENDPATH**/ ?>