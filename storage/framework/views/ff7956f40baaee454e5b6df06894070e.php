<div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$inWishlist): ?>
    <div class="wishlist">
        <a wire:click.prevent="addToWishlist(<?php echo e($product->id); ?>)" href="">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M17 1C14.9 1 13.1 2.1 12 3.7C10.9 2.1 9.1 1 7 1C3.7 1 1 3.7 1 7C1 13 12 22 12 22C12 22 23 13 23 7C23 3.7 20.3 1 17 1Z"
                    stroke="#797979" stroke-width="2" stroke-miterlimit="10"
                    stroke-linecap="square" />
            </svg>
        </a>
    </div>

    <?php else: ?>
    <div class="wishlist">
        <a wire:click.prevent="removeFromWishlist(<?php echo e($product->id); ?>)" href="">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M17 1C14.9 1 13.1 2.1 12 3.7C10.9 2.1 9.1 1 7 1C3.7 1 1 3.7 1 7C1 13 12 22 12 22C12 22 23 13 23 7C23 3.7 20.3 1 17 1Z"
                    stroke="red" stroke-width="2" stroke-miterlimit="10"
                    stroke-linecap="square" fill="none" />
            </svg>
        </ah>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>

    <?php
        $__scriptKey = '467126076-0';
        ob_start();
    ?>
<script>
    $wire.on('addToWishlist', (event) => {
        Swal.fire({
                    position: "top-center",
                    icon: "success",
                    title: event,
                    showConfirmButton: false,
                    timer: 1500
                });
    });

    $wire.on('removeFromWishlist', (event) => {
        Swal.fire({
                    position: "top-center",
                    icon: "success",
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

<?php /**PATH D:\my laravel projects\e-commerce paid\e-commerce12\resources\views/livewire/website/wishlist/wishlist.blade.php ENDPATH**/ ?>