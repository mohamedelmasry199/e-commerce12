<div>
 {{-- price --}}
    <div class="price">
        @if ($product->isSimple())
            @if ($product->firstVariant()->has_discount == 0)
                <span class="new-price">{{ $product->firstVariant()->price }} EGP</span>
            @else
                <span class="price-cut">{{ $product->firstVariant()->price }} EGP</span>
                <span class="new-price">{{ $product->getPriceAfterDiscount() }}
                    EGP</span>
            @endif
        @else
         @if ($discount == 0)
                <span class="new-price">{{ $price }} EGP</span>
            @else
                <span class="price-cut">{{ $price }} EGP</span>
                <span class="new-price">{{ $price - $discount }}
                    EGP</span>
            @endif

        @endif
    </div>

<p class="content-paragraph">{{ $product->small_desc }}</p>
<hr>

{{-- availability --}}
<div class="product-availability">
    <span>{{ __('website.availabillity') }} : </span>
    <span class="inner-text">
        @if ($product->has_variants)
            {{ $quantity }} {{ __('website.in_stock') }}
        @else
            {{ $product->firstVariant()->manage_stock == 1 ? $product->firstVariant()->stock : __('website.available') }}
        @endif
    </span>
</div>

@if ($product->has_variants)
    <div class="product-size">
        <p class="size-title">{{ __('website.variants') }}</p>

        {{-- selected variant attributes --}}
        <div class="selected-attributes">
            @foreach ($variants as $item)
                @if ($item->id == $variantId)
                    @foreach ($item->VariantAttributes as $itemAttr)
                        <p class="size-title">
                            {{ $itemAttr->attributeValue->attribute->name }}:
                            {{ $itemAttr->attributeValue->value }}
                        </p>
                    @endforeach
                @endif
            @endforeach
        </div>

        <div class="size-section">
            <span class="size-text">{{ __('website.select_variant') }}</span>
        </div>

        <ul class="size-option">
            @foreach ($variants as $item)
                <a wire:click="changeVariant({{ $item->id }})"
                   href="javascript:void(0)"
                   class="option {{ $item->id == $variantId ? 'active' : '' }}">
                    @foreach ($item->VariantAttributes as $itemAttr)
                        <span class="option-text">
                            {{ $itemAttr->attributeValue->attribute->name }}:
                            {{ $itemAttr->attributeValue->value }}
                        </span>
                    @endforeach
                </a>
            @endforeach
        </ul>
    </div>
@endif

{{-- add to cart --}}
<div class="product-quantity">
    <div class="quantity-wrapper">
        <div class="quantity">
            <a href="" wire:click.prevent="decrementCartQuantity" class="minus">-</a>
            <span class="number">{{ $cartQuantity }}</span>
            <a href="" wire:click.prevent="incrementCartQuantity" class="plus">+</a>
        </div>
    </div>
    <a href="#" wire:click.prevent="addToCart" class="shop-btn">
        <span>{{-- your SVG --}}</span>
        <span>{{ __('Add to Cart') }}</span>
    </a>
</div>

{{-- ✅ wishlist button — no nested livewire needed --}}
<a href="#" wire:click.prevent="toggleWishlist"
   style="
       display: inline-flex;
       align-items: center;
       gap: 8px;
       padding: 10px 20px;
       border-radius: 12px;
       font-size: 14px;
       font-weight: 500;
       cursor: pointer;
       text-decoration: none;
       transition: opacity 0.15s;
       border: 1.5px solid {{ $inWishlist ? '#e74c3c' : '#ccc' }};
       background: {{ $inWishlist ? '#fff0f0' : 'transparent' }};
       color: {{ $inWishlist ? '#e74c3c' : 'inherit' }};
   ">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="{{ $inWishlist ? '#e74c3c' : 'none' }}"
         stroke="{{ $inWishlist ? '#e74c3c' : 'currentColor' }}" stroke-width="2"
         stroke-linecap="round" stroke-linejoin="round">
        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
    </svg>
    {{ $inWishlist ? __('website.remove_from_wishlist') : __('website.add_to_wishlist') }}
</a>
@script
    <script>
        $wire.on('successMessage', (event) => {
            Swal.fire({
                position: "top-center",
                icon: "success",
                title: event,
                showConfirmButton: false,
                timer: 1500
            });
        });

        $wire.on('errorMessage', (event) => {
            Swal.fire({
                position: "top-center",
                icon: "error",
                title: event,
                showConfirmButton: false,
                timer: 1500
            });
        });
    </script>
@endscript

</div>
