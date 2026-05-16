<?php $__env->startSection('title',__('website.wishlist')); ?>

<?php $__env->startSection('content'); ?>
 <section class="blog about-blog">
      <div class="container">

        
        <div class="blog-bradcrum">
          <span><a href="<?php echo e(route('website.home')); ?>"><?php echo e(__('website.home')); ?></a></span>
          <span class="devider">/</span>
          <span><a href="javascript:void(0)"><?php echo e(__('website.wishlist')); ?></a></span>
        </div>

        
        <div class="blog-heading about-heading">
          <h1 class="heading"><?php echo e(__('website.wishlist')); ?></h1>
        </div>

      </div>
    </section>

    
    <section class="cart product wishlist footer-padding">
        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('website.wishlist.wishlist-table',['wishlists'=>$wishlists]);

$key = null;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-365514274-0', null);

$__html = app('livewire')->mount($__name, $__params, $key);

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.website.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\my laravel projects\e-commerce paid\e-commerce12\resources\views/website/wishlist.blade.php ENDPATH**/ ?>