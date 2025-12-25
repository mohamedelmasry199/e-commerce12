<div class="form-group">
    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
        <button type="button" class="btn btn-outline-success edit-coupon-btn" data-toggle="modal"
            data-target="#editcouponModal" data-id="{{ $coupon->id }}" data-code="{{ $coupon->code }}"
            data-discount="{{ $coupon->discount_precentage }}" data-start="{{ $coupon->start_date }}"
            data-end="{{ $coupon->end_date }}" data-limit="{{ $coupon->limit }}" data-used="{{ $coupon->time_used }}"
            data-active="{{ $coupon->is_active }}">
            {{ __('dashboard.edit') }} <i class="la la-edit"></i>
        </button>

        <button
    class="change_status_btn btn btn-outline-info"
    data-id="{{ $coupon->id }}">
    {{ __('dashboard.status_change') }}
    <i class="la la-stop"></i>
</button>

        <div class="btn-group" role="group">
            <button id="btnGroupDrop2" type="button" coupon-id="{{ $coupon->id }}"
                class="ajax_delete_btn btn btn-outline-danger">
                {{ __('dashboard.delete') }}<i class="la la-trash"></i>
            </button>
        </div>
    </div>
</div>
