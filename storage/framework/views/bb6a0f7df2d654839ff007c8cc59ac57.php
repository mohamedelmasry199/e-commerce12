<div>
    <div class="content-wrapper">
        <div class="content-body">
            <div class="card email-app-details d-none d-lg-block">
                <div class="card-content">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($msg): ?>
                        <!-- Email Options (Buttons) -->
                        <div class="email-app-options card-body d-flex justify-content-between align-items-center">
                            <!-- Left Side Buttons -->
                            <div class="btn-group">
                                <button type="button" wire:click="replayMsg(<?php echo e($msg->id); ?>)"
                                    class="btn btn-primary" data-toggle="tooltip" title="Reply">
                                    <i class="la la-reply"></i>
                                </button>

                                <button type="button" class="btn btn-warning" data-toggle="tooltip" title="Report Spam">
                                    <i class="ft-alert-octagon"></i>
                                </button>

                                <button <?php if($msg->deleted_at != null ): ?> wire:click="forceDelete(<?php echo e($msg->id); ?>)" <?php else: ?> wire:click="deleteMsg(<?php echo e($msg->id); ?>)" <?php endif; ?> type="button"
                                    class="btn btn-danger" data-toggle="tooltip" <?php if($msg->deleted_at != null ): ?> title="Force Delete" <?php else: ?> title="Delete" <?php endif; ?> >
                                    <i class="ft-trash-2"></i>
                                </button>
                            </div>

                            <!-- Right Side More Options -->
                            <div class="btn-group">
                                <button type="button" class="btn btn-outline-secondary dropdown-toggle"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    More
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" wire:click="markAsUnRead(<?php echo e($msg->id); ?>)" href="#">Mark as Unread</a>
                                    <a wire:click="forceDelete(<?php echo e($msg->id); ?>)" class="dropdown-item" href="#">Force Delete</a>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($msg->deleted_at != null): ?>
                                        <a wire:click="restoreContact(<?php echo e($msg->id); ?>)" class="dropdown-item" href="#">Restore</a>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Email Title -->
                        <div class="email-app-title card-body">
                            <h3 class="list-group-item-heading"><?php echo e($msg->title); ?></h3>
                            <p class="list-group-item-text">
                                <span class="badge badge-primary">Show Message</span>
                                <i class="float-right font-medium-3 ft-star warning"></i>
                            </p>
                        </div>

                        <!-- Message Content -->
                        <div class="media-list">
                            <div id="headingCollapse1" class="card-header p-0">
                                <a data-toggle="collapse" href="#collapse1" aria-expanded="true"
                                    aria-controls="collapse1"
                                    class="collapsed email-app-sender media border-0 bg-blue-grey bg-lighten-5">
                                    <div class="media-left pr-1">
                                        <span class="avatar avatar-md">
                                            <img class="media-object rounded-circle"
                                                src="<?php echo e(asset('assets/dashboard/images/avatar.jpg')); ?>"
                                                alt="Generic placeholder image">
                                        </span>
                                    </div>
                                    <div class="media-body w-100">
                                        <h6 class="list-group-item-heading"><?php echo e($msg->name); ?></h6>
                                        <p class="list-group-item-text"><?php echo e($msg->subject); ?>

                                            <span class="float-right text-muted"><?php echo e($msg->created_at->diffForHumans()); ?></span>
                                        </p>
                                    </div>
                                </a>
                            </div>
                            <div id="collapse1" role="tabpanel" aria-labelledby="headingCollapse1"
                                class="card-collapse collapse" aria-expanded="true">
                                <div class="card-content">
                                    <div class="card-body">
                                        <p><?php echo e($msg->message); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php else: ?>
                        <div class="text-center p-3">
                            <h5>No messages found</h5>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH D:\my laravel projects\e-commerce paid\e-commerce12\resources\views/livewire/dashboard/contact/contact-show.blade.php ENDPATH**/ ?>