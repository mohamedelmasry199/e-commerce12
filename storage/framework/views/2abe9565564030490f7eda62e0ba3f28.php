<?php $__env->startSection('title', __('website.login')); ?>

<?php $__env->startSection('content'); ?>
<section class="login footer-padding">
  <div class="container">
    <div class="login-section">
      <div class="review-form">

        <h5 class="comment-title"><?php echo e(__('website.login')); ?></h5>

        <form method="POST" action="<?php echo e(route('login')); ?>">
          <?php echo csrf_field(); ?>

          <div class="review-inner-form">

            
            <div class="review-form-name">
              <label for="email" class="form-label">
                <?php echo e(__('auth.email_address')); ?>

              </label>

              <input
                type="email"
                id="email"
                name="email"
                class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                placeholder="<?php echo e(__('auth.email_placeholder')); ?>"
                value="<?php echo e(old('email')); ?>"
                required
                autofocus
              />

              <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="invalid-feedback d-block">
                  <strong><?php echo e($message); ?></strong>
                </span>
              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            
            <div class="review-form-name">
              <label for="password" class="form-label">
                <?php echo e(__('auth.password')); ?>

              </label>

              <input
                type="password"
                id="password"
                name="password"
                class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                placeholder="<?php echo e(__('auth.password_placeholder')); ?>"
                required
              />

              <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="invalid-feedback d-block">
                  <strong><?php echo e($message); ?></strong>
                </span>
              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            
            <div class="review-form-name checkbox">
              <div class="checkbox-item">
                <input
                  type="checkbox"
                  name="remember"
                  id="remember"
                  <?php echo e(old('remember') ? 'checked' : ''); ?>

                />

                <span class="address">
                  <?php echo e(__('auth.remember_me')); ?>

                </span>
              </div>

              <div class="forget-pass">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Route::has('password.request')): ?>
                  <a href="<?php echo e(route('password.request')); ?>">
                    <?php echo e(__('auth.forgot_password')); ?>

                  </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
              </div>
            </div>

          </div>

          
          <div class="login-btn text-center">
            <button type="submit" class="shop-btn">
              <?php echo e(__('auth.login_button')); ?>

            </button>

            <span class="shop-account">
              <?php echo e(__('auth.dont_have_account')); ?>

              <a href="<?php echo e(route('register')); ?>">
                <?php echo e(__('auth.register')); ?>

              </a>
            </span>
          </div>

        </form>

      </div>
    </div>
  </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.website.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\my laravel projects\e-commerce paid\e-commerce12\resources\views/website/auth/login.blade.php ENDPATH**/ ?>