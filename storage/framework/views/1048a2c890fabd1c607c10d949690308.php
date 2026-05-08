<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">


            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('categories')): ?>
                <li class=" nav-item"><a href="<?php echo e(route('dashboard.categories.index')); ?>"><i class="la la-folder"></i><span class="menu-title"
                            data-i18n="nav.dash.main"><?php echo e(__('dashboard.categories')); ?></span>
                            <span
                            class="badge badge badge-info badge-pill float-right mr-2"><?php echo e($categories_count); ?>

                        </span>
                        </a>
                    <ul class="menu-content">
                        <li class="active"><a class="menu-item" href="<?php echo e(route('dashboard.categories.index')); ?>"
                                data-i18n="nav.dash.ecommerce"><?php echo e(__('dashboard.categories')); ?></a>
                        </li>
                        <li><a class="menu-item" href="<?php echo e(route('dashboard.categories.create')); ?>"
                                data-i18n="nav.dash.crypto"><?php echo e(__('dashboard.category_create')); ?></a>
                        </li>

                    </ul>
                </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('brands')): ?>
                <li class=" nav-item"><a href="<?php echo e(route('dashboard.brands.index')); ?>"><i class="la la-check-square"></i><span class="menu-title"
                            data-i18n="nav.dash.main"><?php echo e(__('dashboard.brands')); ?></span>
                            <span
                            class="badge badge badge-info badge-pill float-right mr-2"><?php echo e($brands_count); ?>

                        </span>
                        </a>
                    <ul class="menu-content">
                        <li class="active"><a class="menu-item" href="<?php echo e(route('dashboard.brands.index')); ?>"
                                data-i18n="nav.dash.ecommerce"><?php echo e(__('dashboard.brands')); ?></a>
                        </li>
                        

                    </ul>
                </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('roles')): ?>
                <li class=" nav-item"><a href="<?php echo e(route('dashboard.roles.index')); ?>"><i class="la la-unlock-alt"></i><span class="menu-title"
                            data-i18n="nav.templates.main"><?php echo e(__('dashboard.roles')); ?></span></a>
                    <ul class="menu-content">
                        <li>
                            <a class="menu-item" href="<?php echo e(route('dashboard.roles.create')); ?>" data-i18n="">
                                <?php echo e(__('dashboard.create_role')); ?> </a>
                        </li>
                        <li>
                            <a class="menu-item" href="<?php echo e(route('dashboard.roles.index')); ?>"
                                data-i18n=""><?php echo e(__('dashboard.roles')); ?> </a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admins')): ?>
                <li class=" nav-item"><a href="<?php echo e(route('dashboard.admins.index')); ?>"><i class="la la-user-secret"></i><span class="menu-title"
                            data-i18n="nav.templates.main"><?php echo e(__('dashboard.admins')); ?></span>
                            <span
                            class="badge badge badge-info badge-pill float-right mr-2"><?php echo e($admins_count); ?>

                        </span>
                        </a>
                    <ul class="menu-content">
                        <li>
                            <a class="menu-item" href="<?php echo e(route('dashboard.admins.create')); ?>"
                                data-i18n=""><?php echo e(__('dashboard.create_admin')); ?> </a>
                        </li>
                        <li>
                            <a class="menu-item" href="<?php echo e(route('dashboard.admins.index')); ?>"
                                data-i18n=""><?php echo e(__('dashboard.admins')); ?></a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('users')): ?>
                <li class=" nav-item"><a href="<?php echo e(route('dashboard.users.index')); ?>"><i class="la la-users"></i><span class="menu-title"
                            data-i18n="nav.templates.main"><?php echo e(__('dashboard.users')); ?></span><span
                            class="badge badge badge-info badge-pill float-right mr-2"><?php echo e($users_count); ?></span></a>
                    <ul class="menu-content">
                        <li>
                            <a class="menu-item" href="<?php echo e(route('dashboard.users.index')); ?>"
                                data-i18n=""><?php echo e(__('dashboard.users')); ?></a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>
            

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('coupons')): ?>
                <li class=" nav-item"><a href="<?php echo e(route('dashboard.coupons.index')); ?>"><i class="la la-500px"></i><span class="menu-title"
                            data-i18n="nav.dash.main"><?php echo e(__('dashboard.coupons')); ?></span><span
                            class="badge badge badge-info badge-pill float-right mr-2"><?php echo e($coupons_count); ?></span></a>
                    <ul class="menu-content">
                        <li class="active"><a class="menu-item" href="<?php echo e(route('dashboard.coupons.index')); ?>"
                                data-i18n="nav.dash.ecommerce"><?php echo e(__('dashboard.coupons')); ?></a>
                        </li>
                        
            </li>
        </ul>
                </li>
            <?php endif; ?>

             <li class="nav-item"><a href="javascript:void(0)"><i class="la la-cart-arrow-down"></i><span
                        class="menu-title" data-i18n="nav.dash.main"><?php echo e(__('dashboard.products')); ?></span><span
                        class="badge badge badge-info badge-pill float-right mr-2">10</span></a>
                <ul class="menu-content">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('attributes')): ?>
                        <li class="active"><a class="menu-item" href="<?php echo e(route('dashboard.attributes.index')); ?>"
                                data-i18n="nav.dash.ecommerce"><?php echo e(__('dashboard.attributes')); ?></a>
                        </li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('products')): ?>
                        <li><a class="menu-item" href="<?php echo e(route('dashboard.products.index')); ?>"
                                data-i18n="nav.dash.crypto"><?php echo e(__('dashboard.products')); ?></a>
                        </li>
                        <li><a class="menu-item" href="<?php echo e(route('dashboard.products.create')); ?>"
                                data-i18n="nav.dash.crypto"><?php echo e(__('dashboard.create_product')); ?></a>
                        </li>
                    <?php endif; ?>
                </ul>
            </li>

            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('contacts')): ?>
                <li class=" nav-item"><a href="<?php echo e(route('dashboard.contacts.index')); ?>"><i class="la la-phone"></i><span class="menu-title"
                            data-i18n="nav.dash.main"><?php echo e(__('dashboard.contacts')); ?></span><span
                            class="badge badge badge-info badge-pill float-right mr-2"><?php echo e($contacts_count); ?></span></a>
                    <ul class="menu-content">
                        <li><a class="menu-item" href="<?php echo e(route('dashboard.contacts.index')); ?>"
                                data-i18n="nav.dash.ecommerce"><?php echo e(__('dashboard.contacts')); ?></a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('faqs')): ?>
                <li class=" nav-item"><a href="<?php echo e(route('dashboard.faqs.index')); ?>  "><i class="la la-info"></i><span class="menu-title"
                            data-i18n="nav.dash.main"><?php echo e(__('dashboard.faqs')); ?></span><span
                            class="badge badge badge-info badge-pill float-right mr-2"><?php echo e($faqs_count); ?></span></a>
                    <ul class="menu-content">
                        <li><a class="menu-item" href="<?php echo e(route('dashboard.faqs.index')); ?>"
                                data-i18n="nav.dash.ecommerce"><?php echo e(__('dashboard.faqs')); ?></a>
                        </li>
                        <li><a class="menu-item" href="<?php echo e(route('dashboard.faqs.index')); ?>"
                                data-i18n="nav.dash.ecommerce"><?php echo e(__('dashboard.faq_questions')); ?></a>
                        </li>
                        <li><a class="menu-item" href="<?php echo e(route('dashboard.faq.questions.index')); ?>"
                                data-i18n="nav.dash.ecommerce"><?php echo e(__('dashboard.userFaqs')); ?></a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>

            <li class=" nav-item"><a href="javascipt:void(0)"><i class="la la-gears"></i><span class="menu-title"
                        data-i18n="nav.dash.main"><?php echo e(__('dashboard.settings')); ?></span></a>
                <ul class="menu-content">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('settings')): ?>
                        <li><a class="menu-item" href="<?php echo e(route('dashboard.settings.index')); ?>"
                                data-i18n="nav.dash.ecommerce"><?php echo e(__('dashboard.settings')); ?></a>
                        </li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sliders')): ?>
                        <li><a class="menu-item" href="<?php echo e(route('dashboard.sliders.index')); ?>"
                                data-i18n="nav.dash.ecommerce"><?php echo e(__('dashboard.sliders')); ?></a>
                        </li>
                    <?php endif; ?>

                </ul>
            </li>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('pages')): ?>
                <li class=" nav-item"><a href="javascipt:void(0)"><i class="la la-folder-open-o"></i><span
                            class="menu-title" data-i18n="nav.dash.main"><?php echo e(__('dashboard.pages')); ?></span></a>
                    <ul class="menu-content">
                        <li><a class="menu-item" href="<?php echo e(route('dashboard.pages.index')); ?>"
                                data-i18n="nav.dash.ecommerce"><?php echo e(__('dashboard.pages')); ?></a>
                        </li>
                        <li><a class="menu-item" href="<?php echo e(route('dashboard.pages.create')); ?>"
                                data-i18n="nav.dash.ecommerce"><?php echo e(__('dashboard.create_page')); ?></a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>




            <li class=" navigation-header">
                <span data-i18n="nav.category.ui">User Interface</span><i class="la la-ellipsis-h ft-minus"
                    data-toggle="tooltip" data-placement="right" data-original-title="User Interface"></i>
            </li>

        </ul>
    </div>
</div>
<?php /**PATH D:\my laravel projects\e-commerce paid\e-commerce12\resources\views/layouts/dashboard/_sidebar.blade.php ENDPATH**/ ?>