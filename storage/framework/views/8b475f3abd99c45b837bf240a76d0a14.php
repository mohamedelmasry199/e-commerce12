<!doctype html>
<html lang="en">

<!-- Mirrored from quomodothemes.website/html/shopus/ by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 15 Nov 2023 07:46:51 GMT -->

<head>
    <meta charset="utf-8">
    <meta name="keywords"
        content="<?php echo e($setting->site_desc); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?php echo e(asset($setting->favicon)); ?>">

    <title><?php echo $__env->yieldContent('title'); ?></title>

    <link rel="stylesheet" href="<?php echo e(asset('assets/website/css/swiper10-bundle.min.css')); ?>">

    <link rel="stylesheet" href="<?php echo e(asset('assets/website/css/bootstrap-5.3.2.min.css')); ?>">

    <link rel="stylesheet" href="<?php echo e(asset('assets/website/css/nouislider.min.css')); ?>">

    <link rel="stylesheet" href="<?php echo e(asset('assets/website/css/aos-3.0.0.css')); ?>">

    <link rel="stylesheet" href="<?php echo e(asset('assets/website/css/style.css')); ?>">
</head>

<body>

    <?php echo $__env->make('layouts.website.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<?php echo $__env->yieldContent('content'); ?>

<?php echo $__env->make('layouts.website.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>




    <script src="<?php echo e(asset('assets/website/assets/js/jquery_3.7.1.min.js')); ?>"></script>

    <script src="<?php echo e(asset('assets/website/assets/js/bootstrap_5.3.2.bundle.min.js')); ?>"></script>

    <script src="<?php echo e(asset('assets/website/assets/js/nouislider.min.js')); ?>"></script>

    <script src="<?php echo e(asset('assets/website/assets/js/aos-3.0.0.js')); ?>"></script>

    <script src="<?php echo e(asset('assets/website/assets/js/swiper10-bundle.min.js')); ?>"></script>

    <script src="<?php echo e(asset('assets/website/assets/js/shopus.js')); ?>"></script>
</body>


</html>
<?php /**PATH D:\my laravel projects\e-commerce paid\e-commerce12\resources\views/layouts/website/app.blade.php ENDPATH**/ ?>