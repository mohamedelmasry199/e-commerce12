<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="rtl">
<head>
<?php echo $__env->make('layouts.dashboard._head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->yieldPushContent('css'); ?>
</head>
<body class="vertical-layout vertical-menu-modern 2-columns   menu-expanded fixed-navbar"
data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
  <!-- fixed-top-->
<?php echo $__env->make('layouts.dashboard._header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  <!-- ////////////////////////////////////////////////////////////////////////////-->
<?php echo $__env->make('layouts.dashboard._sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  
  <?php echo $__env->yieldContent('content'); ?>
  <!-- ////////////////////////////////////////////////////////////////////////////-->
<?php echo $__env->make('layouts.dashboard._footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('layouts.dashboard._scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->yieldPushContent('js'); ?>

</body>
</html>
<?php /**PATH D:\my laravel projects\e-commerce paid\e-commerce12\resources\views/layouts/dashboard/app.blade.php ENDPATH**/ ?>