<div class="modal fade" id="createcouponModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document"> <!-- Larger modal -->
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="la la-plus-circle"></i> {{ __('dashboard.create_coupon') }}
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Body -->
            <div class="modal-body pt-1 pb-2">

 {{-- validations error --}}
                <div class="alert alert-danger" id="error_div" style="display: none;">
                    <ul id="error_list"></ul>
                </div>

                <form action="{{ route('dashboard.coupons.store') }}" method="POST" id="createCoupon">
                    @csrf

                    <div class="row">

                        <!-- Coupon Code -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">{{ __('dashboard.coupon_code') }}</label>
                                <input type="text" name="code" class="form-control" placeholder="{{ __('dashboard.coupon_code') }}">
                            </div>
                        </div>

                        <!-- Discount -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">{{ __('dashboard.discount_percentage') }}</label>
                                <input type="number" name="discount_precentage" min="1" max="100"
                                       class="form-control" placeholder="{{ __('dashboard.discount_percentage') }}">
                            </div>
                        </div>

                        <!-- Start Date -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">{{ __('dashboard.start_date') }}</label>
                                <input type="date" name="start_date" class="form-control">
                            </div>
                        </div>

                        <!-- End Date -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">{{ __('dashboard.end_date') }}</label>
                                <input type="date" name="end_date" class="form-control">
                            </div>
                        </div>

                        <!-- Usage Limit -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">{{ __('dashboard.usage_limit') }}</label>
                                <input type="number" name="limit" min="1" class="form-control"
                                       placeholder="{{ __('dashboard.usage_limit') }}">
                            </div>
                        </div>

                        <!-- Time Used -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">{{ __('dashboard.time_used') }}</label>
                                <input type="number" name="time_used" value="0" min="0" class="form-control"
                                       placeholder="{{ __('dashboard.time_used') }}">
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="col-md-12">
                            <label class="font-weight-bold d-block">{{ __('dashboard.status') }}</label>
                            <div class="form-group d-flex align-items-center">

                                <div class="custom-control custom-radio mr-3">
                                    <input type="radio" id="active1" name="is_active" value="1"
                                           class="custom-control-input">
                                    <label class="custom-control-label" for="active1">
                                        <span class="badge badge-success">{{ __('dashboard.active') }}</span>
                                    </label>
                                </div>

                                <div class="custom-control custom-radio">
                                    <input type="radio" id="inactive1" name="is_active" value="0"
                                           class="custom-control-input">
                                    <label class="custom-control-label" for="inactive1">
                                        <span class="badge badge-danger">{{ __('dashboard.inactive') }}</span>
                                    </label>
                                </div>

                            </div>
                        </div>

                    </div> <!-- row -->

                </form>
            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="ft-x"></i> {{ __('dashboard.close') }}
                </button>

                <button type="submit" form="createCoupon" class="btn btn-primary">
                    <i class="la la-check-square-o"></i> {{ __('dashboard.save') }}
                </button>
            </div>

        </div>
    </div>
</div>
