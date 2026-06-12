<div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($wishlists->count() > 0): ?>
        <div class="container">
            <div class="cart-section wishlist-section">
                <table>
                    <tbody>

                        <tr class="table-row table-top-row">
                            <td class="table-wrapper wrapper-product">
                                <h5 class="table-heading"><?php echo e(__('website.products')); ?></h5>
                            </td>
                            <td class="table-wrapper">
                                <div class="table-wrapper-center">
                                    <h5 class="table-heading"><?php echo e(__('website.price')); ?></h5>
                                </div>
                            </td>
                            <td class="table-wrapper">
                                <div class="table-wrapper-center">
                                    <h5 class="table-heading"><?php echo e(__('website.action')); ?></h5>
                                </div>
                            </td>
                        </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $wishlists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="table-row ticket-row">
                                <td class="table-wrapper wrapper-product">
                                    <div class="wrapper">
                                        <div class="wrapper-img">
                                            <img src="<?php echo e(asset('uploads/products/' . $item->product->images()->first()->file_name)); ?>"
                                                alt="<?php echo e($item->product->name); ?>" />
                                        </div>
                                        <div class="wrapper-content">

    <h5 style="margin-bottom:10px; line-height:1.6;">
        <a href="<?php echo e(route('website.products.show', $item->product->slug)); ?>"
           style="
                font-size:18px;
                font-weight:700;
                color:#222;
                text-decoration:none;
                transition:0.3s;
           ">
            <?php echo e($item->product->name); ?>

        </a>
    </h5>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->product->has_variants): ?>
        <div style="
            display:flex;
            flex-wrap:wrap;
            gap:8px;
            margin-top:8px;
        ">

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $item->variant->VariantAttributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attribute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <span style="
                    background:#f5f5f7;
                    border:1px solid #e5e5e5;
                    padding:6px 12px;
                    border-radius:30px;
                    font-size:13px;
                    color:#555;
                    display:inline-flex;
                    align-items:center;
                    gap:4px;
                ">
                    <strong style="font-weight:600;">
                        <?php echo e($attribute->attributeValue->attribute->name); ?>

                    </strong>
                    :
                    <?php echo e($attribute->attributeValue->value); ?>

                </span>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

</div>
                                    </div>
                                </td>
                                <td class="table-wrapper">
                                    <div class="table-wrapper-center">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$item->product->has_variants): ?>
                                            <h5 class="heading"><?php echo e($item->product->firstVariant()->price); ?></h5>
                                        <?php else: ?>
                                            <h5 class="heading"><?php echo e($item->variant->price); ?></h5>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </td>
                                <td class="table-wrapper">
                                    <div class="table-wrapper-center">
                                        <span>
                                            <a wire:click.prevent="removeFromWishlist(<?php echo e($item->id); ?>)" href="">
                                                <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M9.7 0.3C9.3 -0.1 8.7 -0.1 8.3 0.3L5 3.6L1.7 0.3C1.3 -0.1 0.7 -0.1 0.3 0.3C-0.1 0.7 -0.1 1.3 0.3 1.7L3.6 5L0.3 8.3C-0.1 8.7 -0.1 9.3 0.3 9.7C0.7 10.1 1.3 10.1 1.7 9.7L5 6.4L8.3 9.7C8.7 10.1 9.3 10.1 9.7 9.7C10.1 9.3 10.1 8.7 9.7 8.3L6.4 5L9.7 1.7C10.1 1.3 10.1 0.7 9.7 0.3Z"
                                                    fill="#AAAAAA"></path>
                                                </svg>
                                            </a>
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="wishlist-btn">
                <a wire:click.prevent="clearWishlist" href="" class="clean-btn"><?php echo e(__('website.clean_wishlist')); ?></a>
            </div>
        </div>
    <?php else: ?>
        <section class="blog about-blog footer-padding">
            <div class="container">
                <div class="blog-item" data-aos="fade-up">
                    <div class="cart-img">
                        <img src="<?php echo e(asset('assets/website/assets/images/homepage-one/empty-wishlist.webp')); ?>" alt>
                    </div>
                    <div class="cart-content">
                        <p class="content-title"><?php echo e(__('website.no_products')); ?></p>
                        <a href="<?php echo e(route('website.home')); ?>" class="shop-btn"><?php echo e(__('website.back_to_shop')); ?></a>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH D:\my laravel projects\e-commerce paid\e-commerce12\resources\views/livewire/website/wishlist/wishlist-table.blade.php ENDPATH**/ ?>
