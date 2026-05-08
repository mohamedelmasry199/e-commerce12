<?php $__env->startSection('title', __('dashboard.create_page')); ?>
<?php $__env->startPush('css'); ?>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-bs4.min.css" rel="stylesheet">
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-9 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block"><?php echo e(__('dashboard.pages_table')); ?></h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a
                                        href="<?php echo e(route('dashboard.index')); ?>"><?php echo e(__('dashboard.dashboard')); ?></a>
                                </li>
                                <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard.pages.index')); ?>">
                                        <?php echo e(__('dashboard.pages')); ?></a>
                                </li>
                                <li class="breadcrumb-item active"><a href="javascript:void(0)">
                                        <?php echo e(__('dashboard.create_page')); ?></a>
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
                                    <?php echo e(__('dashboard.governorates')); ?>

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
                                    <form class="form" action="<?php echo e(route('dashboard.pages.store')); ?>" method="POST" enctype="multipart/form-data" >
                                        <?php echo csrf_field(); ?>

                                         <div class="form-body">
                                            <div class="form-group">
                                                <label for="eventRegInput1"><?php echo e(__('dashboard.title_ar')); ?></label>
                                                <input type="text" value="<?php echo e(old('title[ar]')); ?>" class="form-control"
                                                    placeholder="<?php echo e(__('dashboard.title_ar')); ?>" name="title[ar]">
                                            </div>
                                            <div class="form-group">
                                                <label for="eventRegInput1"><?php echo e(__('dashboard.title_en')); ?></label>
                                                <input type="text" value="<?php echo e(old('title[en]')); ?>" class="form-control"
                                                    placeholder="<?php echo e(__('dashboard.title_en')); ?>" name="title[en]">
                                            </div>

                                            
                                            <div class="form-group">
                                                <label for="eventRegInput1"><?php echo e(__('dashboard.content_ar')); ?></label>
                                                <textarea id="summernote" type="text" class="form-control" name="content[ar]"><?php echo e(old('content[ar]')); ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="eventRegInput1"><?php echo e(__('dashboard.content_en')); ?></label>
                                                <textarea id="summernote2" type="text" class="form-control" name="content[en]"><?php echo e(old('content[en]')); ?></textarea>
                                            </div>


                                            <div class="form-group">
                                                <label for="image"><?php echo e(__('dashboard.image')); ?></label>
                                                <input type="file"  name="image" class="form-control" id="single-image"
                                                    placeholder="<?php echo e(__('dashboard.image')); ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="eventRegInput1"><?php echo e(__('dashboard.is_active')); ?></label>
                                                <select name="is_active" class="form-control">
                                                    <option value="1" <?php echo e(old('is_active') == '1' ? 'selected' : ''); ?>><?php echo e(__('dashboard.active')); ?></option>
                                                    <option value="0" <?php echo e(old('is_active') == '0' ? 'selected' : ''); ?>><?php echo e(__('dashboard.inactive')); ?></option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="eventRegInput1"><?php echo e(__('dashboard.meta_title_ar')); ?></label>
                                                <input type="text" value="<?php echo e(old('meta_title[ar]')); ?>" class="form-control"
                                                    placeholder="<?php echo e(__('dashboard.meta_title_ar')); ?>" name="meta_title[ar]">
                                            </div>
                                            <div class="form-group">
                                                <label for="eventRegInput1"><?php echo e(__('dashboard.meta_title_en')); ?></label>
                                                <input type="text" value="<?php echo e(old('meta_title[en]')); ?>" class="form-control"
                                                    placeholder="<?php echo e(__('dashboard.meta_title_en')); ?>" name="meta_title[en]">
                                            </div>
                                            <div class="form-group">
                                                <label for="eventRegInput1"><?php echo e(__('dashboard.meta_description_ar')); ?></label>
                                                <input type="text" value="<?php echo e(old('meta_description[ar]')); ?>" class="form-control"
                                                    placeholder="<?php echo e(__('dashboard.meta_description_ar')); ?>" name="meta_description[ar]">
                                                    </div>
                                            <div class="form-group">
                                                <label for="eventRegInput1"><?php echo e(__('dashboard.meta_description_en')); ?></label>
                                                <input type="text" value="<?php echo e(old('meta_description[en]')); ?>" class="form-control"
                                                    placeholder="<?php echo e(__('dashboard.meta_description_en')); ?>" name="meta_description[en]">
                                            </div>
                                            <div class="form-group">
                                                <label for="eventRegInput1"><?php echo e(__('dashboard.meta_keywords_ar')); ?></label>
                                                <input type="text" value="<?php echo e(old('meta_keywords[ar]')); ?>" class="form-control"
                                                    placeholder="<?php echo e(__('dashboard.meta_keywords_ar')); ?>" name="meta_keywords[ar]">
                                                    </div>
                                            <div class="form-group">
                                                <label for="eventRegInput1"><?php echo e(__('dashboard.meta_keywords_en')); ?></label>
                                                <input type="text" value="<?php echo e(old('meta_keywords[en]')); ?>" class="form-control"
                                                    placeholder="<?php echo e(__('dashboard.meta_keywords_en')); ?>" name="meta_keywords[en]">
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
<?php $__env->startPush('js'); ?>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-bs4.min.js"></script>
<script>
    $('#summernote').summernote({
      placeholder: 'اكتب هنا ...',
      tabsize: 2,
      height: 150,
      toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'clear']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['table', ['table']],
          ['insert', ['link', 'video']],
          ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });
    $('#summernote2').summernote({
      placeholder: 'Write here...',
      tabsize: 2,
      height: 150,
      lang:'ar-AR',
      toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'clear']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['table', ['table']],
          ['insert', ['link', 'video']],
          ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });
  </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.dashboard.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\my laravel projects\e-commerce paid\e-commerce12\resources\views/dashboard/pages/create.blade.php ENDPATH**/ ?>