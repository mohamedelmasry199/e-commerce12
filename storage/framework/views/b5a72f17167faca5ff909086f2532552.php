<?php $__env->startSection('title', __('dashboard.create_category')); ?>

<?php $__env->startSection('content'); ?>
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-9 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block"><?php echo e(__('dashboard.governorates_table')); ?></h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a
                                        href="<?php echo e(route('dashboard.index')); ?>"><?php echo e(__('dashboard.dashboard')); ?></a>
                                </li>
                                <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard.categories.index')); ?>">
                                        <?php echo e(__('dashboard.categories')); ?></a>
                                </li>
                                <li class="breadcrumb-item active"><a href="">
                                        <?php echo e(__('dashboard.create_category')); ?></a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
                <?php echo $__env->make('dashboard.includes.button-header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
            <div class="row" style="display: flex; justify-content: center;">
                <div class="col-md-11">
                    <div class="content-body">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title" id="basic-layout-colored-form-control">
                                    <?php echo e(__('dashboard.categories')); ?>

                                </h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        <li><a data-action="close"><i class="ft-x"></i></a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="card-content">
                                <div class="card-body">
                                    
                                    <?php echo $__env->make('dashboard.includes.validations-errors', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                                    <p class="card-text"><?php echo e(__('dashboard.form_edit')); ?>.</p>
                                    <form class="form" action="<?php echo e(route('dashboard.categories.store')); ?>" method="POST" enctype="multipart/form-data" >
                                        <?php echo csrf_field(); ?>

                                        <div class="form-body">
                                            <div class="form-group">
                                                <label for="eventRegInput1"><?php echo e(__('dashboard.name_en')); ?></label>
                                                <input type="text" value="<?php echo e(old('name[en]')); ?>" class="form-control"
                                                    placeholder="<?php echo e(__('dashboard.name_en')); ?>" name="name[en]">
                                            </div>
                                            <div class="form-group">
                                                <label for="eventRegInput1"><?php echo e(__('dashboard.name_ar')); ?></label>
                                                <input type="text" value="<?php echo e(old('name[ar]')); ?>" class="form-control"
                                                    placeholder="<?php echo e(__('dashboard.name_ar')); ?>" name="name[ar]">
                                            </div>
                                            <div class="form-group">
                                                <label for="eventRegInput1"><?php echo e(__('dashboard.select_parent')); ?></label>
                                                <select name="parent" class="form-control">
                                                    <option value=""><?php echo e(__('dashboard.select_parent')); ?></option>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($cat->id); ?>" ><?php echo e($cat->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="image"><?php echo e(__('dashboard.icon')); ?></label>
                                                <input type="file"  name="icon" class="form-control" id="single-image"
                                                    placeholder="<?php echo e(__('dashboard.icon')); ?>">
                                            </div>


                                            <div class="form-group">
                                                <label><?php echo e(__('dashboard.status')); ?></label>
                                                <div class="input-group">
                                                    <div class="d-inline-block custom-control custom-radio mr-1">
                                                        <input type="radio" value="1"  name="status" class="custom-control-input"
                                                            id="yes1">
                                                        <label class="custom-control-label" for="yes1"><?php echo e(__('dashboard.active')); ?></label>
                                                    </div>
                                                    <div class="d-inline-block custom-control custom-radio">
                                                        <input type="radio" value="0"  name="status" class="custom-control-input"
                                                            id="no1">
                                                        <label class="custom-control-label" for="no1"><?php echo e(__('dashboard.inactive')); ?></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-actions left">
                                            <a href="<?php echo e(url()->previous()); ?>" type="button" class="btn btn-warning mr-1">
                                                <i class="ft-x"></i> <?php echo e(__('dashboard.cancel')); ?>

                                            </a>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="la la-check-square-o"></i> <?php echo e(__('dashboard.save')); ?>

                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\my laravel projects\e-commerce paid\e-commerce12\resources\views/dashboard/categories/create.blade.php ENDPATH**/ ?>