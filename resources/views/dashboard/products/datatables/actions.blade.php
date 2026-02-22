{{-- ── Action Buttons ────────────────────────────────────────────────── --}}
<div class="product-actions">

    <a href="{{ route('dashboard.products.edit', $product->id) }}"
       class="btn btn-outline-success btn-sm">
        <i class="la la-edit"></i> {{ __('dashboard.edit') }}
    </a>

    <button type="button"
            product-id="{{ $product->id }}"
            class="btn btn-outline-info btn-sm status_btn">
        <i class="la la-toggle-on"></i> {{ __('dashboard.status_management') }}
    </button>

    <a href="{{ route('dashboard.products.show', $product->id) }}"
       class="btn btn-outline-primary btn-sm">
        <i class="la la-eye"></i> {{ __('dashboard.show_product') }}
    </a>

    <button type="button"
            product-id="{{ $product->id }}"
            class="delete_confirm_btn btn btn-outline-danger btn-sm">
        <i class="la la-trash"></i> {{ __('dashboard.delete') }}
    </button>

</div>
