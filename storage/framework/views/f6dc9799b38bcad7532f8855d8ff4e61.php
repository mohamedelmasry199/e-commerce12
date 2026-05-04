<div>
    <!-- Modal -->
    <div class="modal fade" id="replayContactModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <img src="<?php echo e(asset($setting->logo)); ?>" alt="Logo" class="mr-2" width="40">
                    <h5 class="modal-title font-weight-bold">
                        <i class="fas fa-envelope"></i> <?php echo e(__('dashboard.replay_contact')); ?>

                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="replayContact" class="form">
                        <input type="hidden" wire:model="id" id="contactId">

                        <div class="form-group">
                            <label for="userEmail"><i class="fas fa-envelope"></i> <?php echo e(__('dashboard.email')); ?></label>
                            <input readonly wire:model="email" id="userEmail" class="form-control bg-light border-0" type="email">
                        </div>

                        <div class="form-group">
                            <label for="contactSubject"><i class="fas fa-tag"></i> <?php echo e(__('dashboard.subject')); ?></label>
                            <input readonly wire:model="subject" id="contactSubject" class="form-control bg-light border-0" type="text">
                        </div>

                        <div class="form-group">
                            <label for="replayMessage"><i class="fas fa-comment-dots"></i> <?php echo e(__('dashboard.replay_message')); ?></label>
                            <textarea rows="4" wire:model="replayMessage" id="replayMessage" class="form-control border-primary"></textarea>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                <i class="fas fa-times"></i> <?php echo e(__('dashboard.close')); ?>

                            </button>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-paper-plane"></i> <?php echo e(__('dashboard.send')); ?>

                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

    <?php
        $__scriptKey = '3483805140-0';
        ob_start();
    ?>
<script>
    Livewire.on('luanch-replay-contact-modal', () => {
        $('#replayContactModal').modal('show');
    });
    Livewire.on('close-modal', () => {
        $('#replayContactModal').modal('hide');
    });
</script>
    <?php
        $__output = ob_get_clean();

        \Livewire\store($this)->push('scripts', $__output, $__scriptKey)
    ?>
<?php /**PATH D:\my laravel projects\e-commerce paid\e-commerce12\resources\views/livewire/dashboard/contact/replay-contact.blade.php ENDPATH**/ ?>