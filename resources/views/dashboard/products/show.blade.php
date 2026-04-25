@extends('layouts.dashboard.app')

@section('title')
    {{ __('dashboard.products_show') }}
@endsection

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block">{{ __('dashboard.products_show') }}</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">{{ __('dashboard.dashboard') }}</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('dashboard.products.index') }}">{{ __('dashboard.products') }}</a></li>
                                <li class="breadcrumb-item active">{{ $product->getNameTranslated() }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
                @include('dashboard.includes.button-header')
            </div>

            <div class="row justify-content-center">
                <div class="col-md-11">
                    <div class="content-body">

                        {{-- ─── MAIN PRODUCT CARD ─────────────────────────────────── --}}
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{ $product->getNameTranslated() }}</h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        <li><a data-action="close"><i class="ft-x"></i></a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">

                                        {{-- ─── LEFT: Product Details ───────────────────────── --}}
                                        <div class="col-md-6">
                                            <h3>{{ $product->getNameTranslated() }}</h3>
                                            <p class="text-muted">{{ $product->getSmallDescTranslated() }}</p>
                                            <p>{{ $product->getDescTranslated() }}</p>

                                            {{-- Status Badge --}}
                                            <div class="mb-2">
                                                @if ($product->status == 1)
                                                    <span class="badge badge-success">{{ __('dashboard.active') }}</span>
                                                @else
                                                    <span class="badge badge-secondary">{{ __('dashboard.inactive') }}</span>
                                                @endif

                                                @if ($product->has_variants)
                                                    <span class="badge badge-warning ml-1">Has Variants</span>
                                                @else
                                                    <span class="badge badge-info ml-1">Simple Product</span>
                                                @endif
                                            </div>

                                            {{-- Simple product price / stock --}}
                                            @if (!$product->has_variants && $product->variants->isNotEmpty())
                                                @php $mainVariant = $product->variants->first(); @endphp
                                                <div class="mt-2">
                                                    <h4>
                                                        <span class="text-danger">${{ $mainVariant->getPriceAfterDiscount() }}</span>
                                                        @if ($mainVariant->has_discount)
                                                            <small class="text-muted ml-1"><del>${{ $mainVariant->price }}</del></small>
                                                            <small class="badge badge-danger ml-1">{{ $mainVariant->discountPrecentage() }} OFF</small>
                                                        @endif
                                                    </h4>
                                                    @if ($mainVariant->manage_stock)
                                                        <h5>
                                                            <span class="text-muted">
                                                                <i class="fa fa-cubes"></i> Stock:
                                                                <strong>{{ $mainVariant->stock }}</strong>
                                                            </span>
                                                        </h5>
                                                    @endif
                                                </div>
                                            @endif

                                            {{-- Availability --}}
                                            <div class="mt-3">
                                                <p>
                                                    <i class="fa fa-calendar-check text-success"></i>
                                                    <strong>Available For:</strong>
                                                    {{ $product->available_for ?? 'N/A' }}
                                                </p>
                                                @if (!$product->has_variants && $product->variants->isNotEmpty())
                                                    <p>
                                                        <i class="fa fa-box text-primary"></i>
                                                        <strong>In Stock:</strong>
                                                        @if ($product->variants->first()->isAvailable())
                                                            <span class="text-success"><i class="fa fa-check-circle"></i> Yes</span>
                                                        @else
                                                            <span class="text-danger"><i class="fa fa-times-circle"></i> No</span>
                                                        @endif
                                                    </p>
                                                @endif
                                            </div>

                                            {{-- SKU --}}
                                            @if ($product->sku)
                                                <p>
                                                    <i class="fa fa-barcode text-info"></i>
                                                    <strong>SKU:</strong> {{ $product->sku }}
                                                </p>
                                            @endif

                                            {{-- Views --}}
                                            <p>
                                                <i class="fa fa-eye text-secondary"></i>
                                                <strong>Views:</strong> {{ $product->views }}
                                            </p>

                                            {{-- Category & Brand --}}
                                            <div class="mt-2">
                                                <p>
                                                    <i class="fa fa-tag text-warning"></i>
                                                    <strong>Category:</strong> {{ $product->category->name }}
                                                </p>
                                                <p>
                                                    <i class="fa fa-industry text-danger"></i>
                                                    <strong>Brand:</strong> {{ $product->brand->name }}
                                                </p>
                                            </div>

                                            {{-- Tags --}}
                                            @if ($product->tags->isNotEmpty())
                                                <div class="mt-2">
                                                    <p class="mb-1"><i class="fa fa-hashtag text-primary"></i> <strong>Tags:</strong></p>
                                                    @foreach ($product->tags as $tag)
                                                        <span class="badge badge-light border">{{ $tag->slug }}</span>
                                                    @endforeach
                                                </div>
                                            @endif

                                            {{-- Timestamps --}}
                                            <div class="mt-3 text-muted small">
                                                <p class="mb-0"><i class="fa fa-clock"></i> Created: {{ $product->created_at }}</p>
                                                <p class="mb-0"><i class="fa fa-edit"></i> Updated: {{ $product->updated_at }}</p>
                                            </div>
                                        </div>

                                        {{-- ─── RIGHT: Image Carousel ──────────────────────── --}}
                                        <div class="col-md-6 text-center">
                                            @if ($product->images->isNotEmpty())
                                                <div id="productImageSlider" class="carousel slide" data-ride="carousel">
                                                    <div class="carousel-inner">
                                                        @foreach ($product->images as $key => $image)
                                                            <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                                                                <img src="{{ asset('uploads/products/' . $image->file_name) }}"
                                                                    class="d-block w-100 rounded shadow-sm"
                                                                    style="max-height: 350px; object-fit: contain;"
                                                                    alt="{{ $product->getNameTranslated() }}">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    @if ($product->images->count() > 1)
                                                        <a class="carousel-control-prev" href="#productImageSlider" role="button" data-slide="prev">
                                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                            <span class="sr-only">Previous</span>
                                                        </a>
                                                        <a class="carousel-control-next" href="#productImageSlider" role="button" data-slide="next">
                                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                            <span class="sr-only">Next</span>
                                                        </a>
                                                    @endif
                                                </div>
                                                <div class="mt-3">
                                                    <button class="btn btn-outline-secondary btn-sm" data-toggle="modal" data-target="#fullscreenModal">
                                                        <i class="fa fa-expand"></i> View Fullscreen
                                                    </button>
                                                </div>
                                                {{-- Thumbnail strip --}}
                                                @if ($product->images->count() > 1)
                                                    <div class="d-flex flex-wrap justify-content-center mt-2" style="gap:6px;">
                                                        @foreach ($product->images as $key => $image)
                                                            <img src="{{ asset('uploads/products/' . $image->file_name) }}"
                                                                class="rounded border {{ $key === 0 ? 'border-primary' : '' }}"
                                                                style="width:60px;height:60px;object-fit:cover;cursor:pointer;"
                                                                onclick="$('#productImageSlider').carousel({{ $key }})"
                                                                alt="thumb">
                                                        @endforeach
                                                    </div>
                                                @endif
                                            @else
                                                <div class="d-flex align-items-center justify-content-center bg-light rounded" style="height:250px;">
                                                    <span class="text-muted"><i class="fa fa-image fa-3x"></i><br>No Images</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>{{-- /row --}}

                                    {{-- ─── VARIANTS SECTION ───────────────────────────────── --}}
                                    @if ($product->has_variants)
                                        <hr class="mt-4">
                                        <div class="mt-3">
                                            <h4><i class="fa fa-layer-group text-primary"></i> Product Variants
                                                <span class="badge badge-primary ml-1">{{ $product->variants->count() }}</span>
                                            </h4>
                                            <div class="table-responsive mt-2">
                                                <table class="table table-bordered table-striped table-hover">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>SKU</th>
                                                            <th>Price</th>
                                                            <th>Discount</th>
                                                            <th>Final Price</th>
                                                            <th>Stock</th>
                                                            <th>Manage Stock</th>
                                                            <th>Available</th>
                                                            <th>Attributes</th>
                                                            <th>Discount Period</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($product->variants as $variant)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>

                                                                {{-- SKU --}}
                                                                <td>
                                                                    @if ($variant->sku)
                                                                        <code>{{ $variant->sku }}</code>
                                                                    @else
                                                                        <span class="text-muted">—</span>
                                                                    @endif
                                                                </td>

                                                                {{-- Original Price --}}
                                                                <td>${{ number_format($variant->price, 2) }}</td>

                                                                {{-- Discount --}}
                                                                <td>
                                                                    @if ($variant->has_discount)
                                                                        <span class="text-danger">
                                                                            -${{ number_format($variant->discount, 2) }}
                                                                            <small class="badge badge-danger">{{ $variant->discountPrecentage() }}</small>
                                                                        </span>
                                                                    @else
                                                                        <span class="text-muted">No Discount</span>
                                                                    @endif
                                                                </td>

                                                                {{-- Final Price --}}
                                                                <td>
                                                                    <strong class="text-success">
                                                                        ${{ number_format($variant->getPriceAfterDiscount(), 2) }}
                                                                    </strong>
                                                                </td>

                                                                {{-- Stock --}}
                                                                <td>
                                                                    @if ($variant->manage_stock)
                                                                        <span class="{{ $variant->stock > 0 ? 'text-success' : 'text-danger' }}">
                                                                            {{ $variant->stock }}
                                                                        </span>
                                                                    @else
                                                                        <span class="text-muted">Unmanaged</span>
                                                                    @endif
                                                                </td>

                                                                {{-- Manage Stock --}}
                                                                <td>
                                                                    @if ($variant->manage_stock)
                                                                        <span class="badge badge-success">Yes</span>
                                                                    @else
                                                                        <span class="badge badge-secondary">No</span>
                                                                    @endif
                                                                </td>

                                                                {{-- Available --}}
                                                                <td>
                                                                    @if ($variant->isAvailable())
                                                                        <span class="badge badge-success"><i class="fa fa-check"></i> Yes</span>
                                                                    @else
                                                                        <span class="badge badge-danger"><i class="fa fa-times"></i> No</span>
                                                                    @endif
                                                                </td>

                                                                {{-- Attributes --}}
                                                                <td>
                                                                    @forelse ($variant->VariantAttributes as $variantAttribute)
                                                                        <span class="badge badge-primary mr-1">
                                                                            {{ $variantAttribute->attributeValue->attribute->name }}:
                                                                            {{ $variantAttribute->attributeValue->value }}
                                                                        </span>
                                                                    @empty
                                                                        <span class="text-muted">—</span>
                                                                    @endforelse
                                                                </td>

                                                                {{-- Discount Period --}}
                                                                <td>
                                                                    @if ($variant->has_discount && $variant->start_discount && $variant->end_discount)
                                                                        <small>
                                                                            {{ \Carbon\Carbon::parse($variant->start_discount)->format('Y-m-d') }}
                                                                            <br>to<br>
                                                                            {{ \Carbon\Carbon::parse($variant->end_discount)->format('Y-m-d') }}
                                                                        </small>
                                                                    @else
                                                                        <span class="text-muted">—</span>
                                                                    @endif
                                                                </td>

                                                                {{-- Actions --}}
                                                                <td>
                                                                    <a href="{{ route('dashboard.products.variants.delete', $variant->id) }}"
                                                                        class="btn btn-danger btn-sm"
                                                                        onclick="return confirm('Delete this variant?')">
                                                                        <i class="la la-trash"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    @else
                                        {{-- Simple product: full variant detail card --}}
                                        @if ($product->variants->isNotEmpty())
                                            @php $v = $product->variants->first(); @endphp
                                            <hr class="mt-4">
                                            <h4><i class="fa fa-info-circle text-info"></i> Pricing & Stock Details</h4>
                                            <div class="row mt-3">
                                                <div class="col-sm-6 col-md-3 mb-3">
                                                    <div class="card border text-center p-3">
                                                        <div class="text-muted small">Original Price</div>
                                                        <div class="h4 mt-1">${{ number_format($v->price, 2) }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-3 mb-3">
                                                    <div class="card border text-center p-3">
                                                        <div class="text-muted small">Final Price</div>
                                                        <div class="h4 mt-1 text-success">${{ number_format($v->getPriceAfterDiscount(), 2) }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-3 mb-3">
                                                    <div class="card border text-center p-3">
                                                        <div class="text-muted small">Discount</div>
                                                        <div class="h4 mt-1 text-danger">
                                                            @if ($v->has_discount)
                                                                {{ $v->discountPrecentage() }}
                                                            @else
                                                                None
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-3 mb-3">
                                                    <div class="card border text-center p-3">
                                                        <div class="text-muted small">Stock</div>
                                                        <div class="h4 mt-1">
                                                            @if ($v->manage_stock)
                                                                {{ $v->stock }}
                                                            @else
                                                                <span class="text-muted small">Unmanaged</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            @if ($v->has_discount && $v->start_discount && $v->end_discount)
                                                <p class="text-muted">
                                                    <i class="fa fa-calendar"></i>
                                                    Discount Period:
                                                    <strong>{{ \Carbon\Carbon::parse($v->start_discount)->format('Y-m-d') }}</strong>
                                                    to
                                                    <strong>{{ \Carbon\Carbon::parse($v->end_discount)->format('Y-m-d') }}</strong>
                                                </p>
                                            @endif

                                            @if ($v->sku)
                                                <p><i class="fa fa-barcode text-info"></i> <strong>Variant SKU:</strong> <code>{{ $v->sku }}</code></p>
                                            @endif
                                        @endif
                                    @endif

                                </div>{{-- /card-body --}}
                            </div>{{-- /card-content --}}

                            <div class="card-footer text-right">
                                <a href="{{ route('dashboard.products.edit', $product->id) }}" class="btn btn-primary">
                                    <i class="fa fa-edit"></i> Edit Product
                                </a>
                                <a href="{{ route('dashboard.products.index') }}" class="btn btn-secondary">
                                    <i class="fa fa-arrow-left"></i> Back to Products
                                </a>
                            </div>
                        </div>{{-- /card --}}

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ─── Fullscreen Modal ─────────────────────────────────────────── --}}
    <div class="modal fade" id="fullscreenModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $product->getNameTranslated() }} — Images</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <div id="fullscreenCarousel" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            @foreach ($product->images as $key => $image)
                                <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                                    <img src="{{ asset('uploads/products/' . $image->file_name) }}"
                                        class="d-block w-100"
                                        style="max-height:80vh;object-fit:contain;background:#000;"
                                        alt="{{ $product->getNameTranslated() }}">
                                </div>
                            @endforeach
                        </div>
                        @if ($product->images->count() > 1)
                            <a class="carousel-control-prev" href="#fullscreenCarousel" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#fullscreenCarousel" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Sync fullscreen carousel with main slider
    $('#fullscreenModal').on('show.bs.modal', function () {
        var activeIndex = $('#productImageSlider .carousel-item.active').index();
        $('#fullscreenCarousel').carousel(activeIndex);
    });
</script>
@endpush
