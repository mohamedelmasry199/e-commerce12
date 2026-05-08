<?php $__env->startSection('title'); ?>
    <?php echo e(__('errors.403_title', ['code' => 403])); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="app-content content">
    <div class="content-wrapper">

        
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
                <h3 class="content-header-title mb-0 d-inline-block"><?php echo e(__('errors.403_title', ['code' => 403])); ?></h3>
                <div class="row breadcrumbs-top d-inline-block">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="<?php echo e(route('dashboard.index')); ?>"><?php echo e(__('dashboard.dashboard')); ?></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="<?php echo e(route('dashboard.roles.index')); ?>">Roles</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <a href="#">403 Error</a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="content-header-right col-md-6 col-12">
                <div class="dropdown float-md-right">
                    <button class="btn btn-danger dropdown-toggle round btn-glow px-2" id="dropdownBreadcrumbButton"
                        type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Actions
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownBreadcrumbButton">
                        <a class="dropdown-item" href="#"><i class="la la-calendar-check-o"></i> Calender</a>
                        <a class="dropdown-item" href="#"><i class="la la-cart-plus"></i> Cart</a>
                        <a class="dropdown-item" href="#"><i class="la la-life-ring"></i> Support</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#"><i class="la la-cog"></i> Settings</a>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="content-body">
            <div class="card">
                <div class="card-body d-flex align-items-center justify-content-center" style="min-height: 70vh;">
                    <div class="text-center">

                        
                        <h1 class="display-1 fw-bolder text-danger mb-3">403</h1>

                        
                        <h2 class="fw-bold fs-2 mb-3">
                            <?php echo e(__('errors.403_message') ?? "Forbidden — You don't have permission to access this page."); ?>

                        </h2>

                        
                        <p class="text-gray-600 fw-semibold fs-6 mb-4">
                            <?php echo e(__('errors.403_description') ?? "If you believe this is a mistake, please contact the administrator or try again with the required permissions."); ?>

                        </p>

                        
                        <div class="d-flex flex-wrap justify-content-center gap-2">
                            <a href="<?php echo e(url('/')); ?>" class="btn btn-primary px-4 py-2">
                                <i class="la la-home mr-1"></i> <?php echo e(__('errors.back_home') ?? 'Back to Home'); ?>

                            </a>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->guest()): ?>
                                <a href="<?php echo e(route('login')); ?>" class="btn btn-light px-4 py-2">
                                    <i class="la la-sign-in mr-1"></i> <?php echo e(__('errors.login') ?? 'Log in'); ?>

                                </a>
                            <?php else: ?>
                                <a href="<?php echo e(url()->previous() ?? route('dashboard')); ?>" class="btn btn-light px-4 py-2">
                                    <i class="la la-arrow-left mr-1"></i> <?php echo e(__('errors.go_back') ?? 'Go back'); ?>

                                </a>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\my laravel projects\e-commerce paid\e-commerce12\resources\views/errors/403.blade.php ENDPATH**/ ?>