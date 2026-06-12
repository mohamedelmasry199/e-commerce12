<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="<?php if(Config::get('app.locale') == 'ar'): ?> rtl <?php else: ?> ltr <?php endif; ?>">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description"
        content="Modern admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities with bitcoin dashboard.">
    <meta name="keywords"
        content="admin template, modern admin template, dashboard template, flat admin template, responsive admin template, web app, crypto dashboard, bitcoin dashboard">
    <meta name="author" content="PIXINVENT">
    <title>
        dashboard|<?php echo $__env->yieldContent('title'); ?>
    </title>
    <link rel="apple-touch-icon" href="<?php echo e(asset('assets/dashboard')); ?>/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo e(asset('assets/dashboard')); ?>/images/ico/favicon.ico">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Quicksand:300,400,500,700"
        rel="stylesheet">
    <link href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css" rel="stylesheet">
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/dashboard')); ?>/css-rtl/vendors.css">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/dashboard')); ?>/vendors/css/forms/icheck/icheck.css">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/dashboard')); ?>/vendors/css/forms/icheck/custom.css">
    <!-- END VENDOR CSS-->
    <!-- BEGIN MODERN CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/dashboard')); ?>/css-rtl/app.css">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/dashboard')); ?>/css-rtl/custom-rtl.css">
    <!-- END MODERN CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css"
        href="<?php echo e(asset('assets/dashboard')); ?>/css-rtl/core/menu/menu-types/vertical-menu-modern.css">
    <link rel="stylesheet" type="text/css"
        href="<?php echo e(asset('assets/dashboard')); ?>/css-rtl/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/dashboard')); ?>/css-rtl/pages/login-register.css">
    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/dashboard')); ?>/assets/css/style-rtl.css">
    <!-- END Custom CSS-->
</head>

<body class="vertical-layout vertical-menu-modern 1-column  bg-cyan bg-lighten-2 menu-expanded fixed-navbar"
    data-open="click" data-menu="vertical-menu-modern" data-col="1-column">
    <!-- fixed-top-->
    <nav
        class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-dark navbar-shadow">
        <div class="navbar-wrapper">
            <div class="navbar-header">
                <ul class="nav navbar-nav flex-row">
                    <li class="nav-item mobile-menu d-md-none mr-auto"><a
                            class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i
                                class="ft-menu font-large-1"></i></a></li>
                    <li class="nav-item">
                        <a class="navbar-brand" href="index.html">
                            <img class="brand-logo" alt="modern admin logo"
                                src="<?php echo e(asset('assets/dashboard')); ?>/images/logo/logo.png">
                            <h3 class="brand-text"><?php echo e(__('E-Commerce')); ?></h3>
                        </a>
                    </li>
                    <li class="nav-item d-md-none">
                        <a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i
                                class="la la-ellipsis-v"></i></a>
                    </li>
                </ul>
            </div>
            <div class="navbar-container">
                <div class="collapse navbar-collapse justify-content-end" id="navbar-mobile">
                    <ul class="nav navbar-nav">
<li class="dropdown dropdown-language nav-item">
    <a class="dropdown-toggle nav-link" id="dropdown-flag" href="#" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <i class="flag-icon
            <?php if(app()->getLocale() == 'en'): ?> flag-icon-gb
            <?php elseif(app()->getLocale() == 'ar'): ?> flag-icon-eg
            <?php endif; ?>">
        </i>
        <span class="selected-language"><?php echo e(strtoupper(app()->getLocale())); ?></span>
    </a>
    <div class="dropdown-menu" aria-labelledby="dropdown-flag">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = LaravelLocalization::getSupportedLocales(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $localeCode => $properties): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a class="dropdown-item" rel="alternate" hreflang="<?php echo e($localeCode); ?>"
                href="<?php echo e(LaravelLocalization::getLocalizedURL($localeCode, null, [], true)); ?>">
                <i class="flag-icon
                    <?php if($localeCode == 'en'): ?> flag-icon-gb
                    <?php elseif($localeCode == 'ar'): ?> flag-icon-eg
                    <?php endif; ?>">
                </i>
                <?php echo e($properties['native']); ?>

            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</li>

                        <li class="dropdown nav-item">
                            <a class="nav-link mr-2 nav-link-label" href="#" data-toggle="dropdown"><i
                                    class="ficon ft-settings"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- ////////////////////////////////////////////////////////////////////////////-->
    <?php echo $__env->yieldContent('content'); ?>
    <!-- ////////////////////////////////////////////////////////////////////////////-->
    <footer class="footer fixed-bottom footer-dark navbar-border navbar-shadow">
        <p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2">
            <span class="float-md-left d-block d-md-inline-block">Copyright &copy; 2018 <a
                    class="text-bold-800 grey darken-2"
                    href="https://themeforest.net/user/pixinvent/portfolio?ref=pixinvent" target="_blank">PIXINVENT
                </a>, All rights reserved. </span>
            <span class="float-md-right d-block d-md-inline-blockd-none d-lg-block">Hand-crafted & Made with <i
                    class="ft-heart pink"></i></span>
        </p>
    </footer>
    <!-- BEGIN VENDOR JS-->
    <script src="<?php echo e(asset('assets/dashboard')); ?>/vendors/js/vendors.min.js" type="text/javascript"></script>
    <!-- BEGIN VENDOR JS-->
    <!-- BEGIN PAGE VENDOR JS-->
    <script src="<?php echo e(asset('assets/dashboard')); ?>/vendors/js/forms/validation/jqBootstrapValidation.js"
        type="text/javascript"></script>
    <script src="<?php echo e(asset('assets/dashboard')); ?>/vendors/js/forms/icheck/icheck.min.js" type="text/javascript"></script>
    <!-- END PAGE VENDOR JS-->
    <!-- BEGIN MODERN JS-->
    <script src="<?php echo e(asset('assets/dashboard')); ?>/js/core/app-menu.js" type="text/javascript"></script>
    <script src="<?php echo e(asset('assets/dashboard')); ?>/js/core/app.js" type="text/javascript"></script>
    <script src="<?php echo e(asset('assets/dashboard')); ?>/js/scripts/customizer.js" type="text/javascript"></script>
    <!-- END MODERN JS-->
    <!-- BEGIN PAGE LEVEL JS-->
    <script src="<?php echo e(asset('assets/dashboard')); ?>/js/scripts/forms/form-login-register.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL JS-->
 

</html>
<?php /**PATH D:\my laravel projects\e-commerce paid\e-commerce12\resources\views/layouts/dashboard/auth.blade.php ENDPATH**/ ?>