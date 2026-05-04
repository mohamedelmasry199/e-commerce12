<?php $__env->startSection('title', 'Contacts'); ?>

<?php $__env->startSection('content'); ?>
<div class="app-content content">
    <div class="content-wrapper">
        <div class="row justify-content-center">
            <div class="card w-100 p-3">
                <!-- Card Header -->
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title"><?php echo e(__('dashboard.governorates')); ?></h4>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                            <li><a data-action="close"><i class="ft-x"></i></a></li>
                        </ul>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body">
                    <div class="row">
                        <!-- Contact Sidebar -->
                        <div class="col-md-3 d-none d-lg-block">
                            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('dashboard.contact.contact-sidebar');

$key = null;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-3798710639-0', null);

$__html = app('livewire')->mount($__name, $__params, $key);

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                        </div>

                        <!-- Contact Messages -->
                        <div class="col-md-5">
                            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('dashboard.contact.contact-messages');

$key = null;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-3798710639-1', null);

$__html = app('livewire')->mount($__name, $__params, $key);

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                        </div>

                        <!-- Contact Show (Message Details) -->
                        <div class="col-md-4">
                            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('dashboard.contact.contact-show');

$key = null;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-3798710639-2', null);

$__html = app('livewire')->mount($__name, $__params, $key);

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                        </div>
                    </div>
                </div>

                <!-- Card Footer -->
                <div class="card-footer text-center">
                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('dashboard.contact.replay-contact');

$key = null;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-3798710639-3', null);

$__html = app('livewire')->mount($__name, $__params, $key);

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
    <script>
        // sweet alert after contact deleted
        document.addEventListener('livewire:init', () => {
            Livewire.on('msg-deleted', (event) => {
                Swal.fire({
                    position: "top-center",
                    icon: "success",
                    title: event,
                    showConfirmButton: false,
                    timer: 1500
                });
            });
        });
        // sweet alert after contact replay
        document.addEventListener('livewire:init', () => {
            Livewire.on('replay-contact-success', (event) => {
                Swal.fire({
                    position: "top-center",
                    icon: "success",
                    title: 'event',
                    showConfirmButton: false,
                    timer: 1500
                });
            });
        });

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.dashboard.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\my laravel projects\e-commerce paid\e-commerce12\resources\views/dashboard/contacts/index.blade.php ENDPATH**/ ?>