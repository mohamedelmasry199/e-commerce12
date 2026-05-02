<?php $__env->startSection('title'); ?>
    Login
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <section class="flexbox-container">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="col-md-4 col-10 box-shadow-2 p-0">
                            <div class="card border-grey border-lighten-3 m-0">
                                <div class="card-header border-0">
                                    <div class="card-title text-center">
                                        <img src="<?php echo e(asset('assets/dashboard')); ?>/images/logo/logo-dark.png" alt=" ">
                                    </div>
                                    <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2">
                                        <span><?php echo e(__('auth.login')); ?></span>
                                    </h6>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form action="<?php echo e(route('dashboard.login.post')); ?>" method="POST" class="form-horizontal" action="index.html">
                                            <?php echo csrf_field(); ?>
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input name="email" type="text" class="form-control input-lg"
                                                    id="user-name" placeholder="<?php echo e(__('auth.YourUsername')); ?>"
                                                    tabindex="1">
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                <div class="form-control-position">
                                                    <i class="ft-user"></i>
                                                </div>
                                                <div class="help-block font-small-3"></div>
                                            </fieldset>
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input name="password" type="password" class="form-control input-lg"
                                                    id="password" placeholder="<?php echo e(__('auth.password')); ?>" tabindex="2">
                                                <div class="form-control-position">
                                                    <i class="la la-key"></i>
                                                </div>
                                            </fieldset>
                                            

                                            <div class="help-block font-small-3"></div>
                                            </fieldset>
                                            <div class="form-group row">
                                                <div class="col-md-6 col-12 text-center text-md-left">
                                                    <fieldset>
                                                        <input name="remember" type="checkbox" id="remember-me"
                                                            class="chk-remember">
                                                        <label for="remember-me"><?php echo e(__('auth.remember_me')); ?></label>
                                                    </fieldset>
                                                </div>
                                                
                                            <button type="submit" class="btn btn-danger btn-block btn-lg"><i
                                                    class="ft-unlock"></i>
                                                <?php echo e(__('auth.login')); ?></button>
                                        </form>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\my laravel projects\e-commerce paid\e-commerce12\resources\views/dashboard/auth/login.blade.php ENDPATH**/ ?>