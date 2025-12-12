<div class="modal fade" id="createBrandModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-right" role="document"> <!-- custom class modal-right -->
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="la la-plus-circle"></i> {{ __('dashboard.create_brand') }}
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Body -->
            <div class="modal-body pt-2 pb-2">
                @include('dashboard.includes.validations-errors')

                <form action="{{ route('dashboard.brands.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">

                        <!-- Name AR -->
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">{{ __('dashboard.name_ar') }}</label>
                            <input type="text" name="name[ar]" class="form-control" placeholder="{{ __('dashboard.name_ar') }}">
                        </div>

                        <!-- Name EN -->
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">{{ __('dashboard.name_en') }}</label>
                            <input type="text" name="name[en]" class="form-control" placeholder="{{ __('dashboard.name_en') }}">
                        </div>

                        <!-- Logo -->
                        <div class="col-md-12 mb-3">
                            <label class="font-weight-bold">{{ __('dashboard.logo') }}</label>
                            <input type="file" name="logo" class="form-control" id="single-image">
                        </div>

                        <!-- Status -->
                        <div class="col-md-12 mb-3">
                            <label class="font-weight-bold d-block">{{ __('dashboard.status') }}</label>
                            <div class="d-flex align-items-center gap-3">

                                <div class="custom-control custom-radio">
                                    <input type="radio" id="brandActive" name="status" value="1" class="custom-control-input">
                                    <label class="custom-control-label" for="brandActive">
                                        <span class="badge badge-success">{{ __('dashboard.active') }}</span>
                                    </label>
                                </div>

                                <div class="custom-control custom-radio">
                                    <input type="radio" id="brandInactive" name="status" value="0" class="custom-control-input">
                                    <label class="custom-control-label" for="brandInactive">
                                        <span class="badge badge-danger">{{ __('dashboard.inactive') }}</span>
                                    </label>
                                </div>

                            </div>
                        </div>

                    </div>

                    <!-- Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="ft-x"></i> {{ __('dashboard.close') }}
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="la la-check-square-o"></i> {{ __('dashboard.save') }}
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>
<style>
    /* Right aligned modal on large screens */
@media (min-width: 992px) {  /* large screens */
    .modal-right {

        width: 50%; /* change width as needed */
        max-width: 50%;
        border-radius: 0;
    }

    .modal-right .modal-content {
        height: 100%;
        border-radius: 0;
    }
}

</style>
