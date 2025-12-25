<div class="modal fade" id="editcouponModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="la la-edit"></i> {{ __('dashboard.edit_coupon') }}
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <!-- Body -->
            <div class="modal-body">

                <div class="alert alert-danger d-none" id="edit_error_div">
                    <ul id="edit_error_list"></ul>
                </div>

                <form id="updateCoupon">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="id" id="edit_id">

                    <div class="row">

                        <div class="col-md-6">
                            <label>{{ __('dashboard.coupon_code') }}</label>
                            <input type="text" name="code" id="edit_code" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label>{{ __('dashboard.discount_percentage') }}</label>
                            <input type="number" name="discount_precentage" id="edit_discount"
                                   min="1" max="100" class="form-control">
                        </div>

                        <div class="col-md-6 mt-2">
                            <label>{{ __('dashboard.start_date') }}</label>
                            <input type="date" name="start_date" id="edit_start" class="form-control">
                        </div>

                        <div class="col-md-6 mt-2">
                            <label>{{ __('dashboard.end_date') }}</label>
                            <input type="date" name="end_date" id="edit_end" class="form-control">
                        </div>

                        <div class="col-md-6 mt-2">
                            <label>{{ __('dashboard.usage_limit') }}</label>
                            <input type="number" name="limit" id="edit_limit" class="form-control">
                        </div>

                        <div class="col-md-6 mt-2">
                            <label>{{ __('dashboard.time_used') }}</label>
                            <input type="number" name="time_used" id="edit_used" class="form-control">
                        </div>

                        <div class="col-md-12 mt-3">
                            <label>{{ __('dashboard.status') }}</label>

                            <div class="custom-control custom-radio">
                                <input type="radio" id="edit_active" name="is_active"
                                       value="1" class="custom-control-input">
                                <label class="custom-control-label" for="edit_active">
                                    {{ __('dashboard.active') }}
                                </label>
                            </div>

                            <div class="custom-control custom-radio">
                                <input type="radio" id="edit_inactive" name="is_active"
                                       value="0" class="custom-control-input">
                                <label class="custom-control-label" for="edit_inactive">
                                    {{ __('dashboard.inactive') }}
                                </label>
                            </div>
                        </div>

                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">
                    {{ __('dashboard.close') }}
                </button>
                <button type="submit" form="updateCoupon" class="update_coupon_btn btn btn-primary">
                    {{ __('dashboard.save') }}
                </button>
            </div>

        </div>
    </div>
</div>
