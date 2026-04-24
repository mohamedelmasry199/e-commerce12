<section id="icon-tabs">
    @if (!empty($successMessage))
        <div class="alert bg-success alert-icon-left alert-arrow-left alert-dismissible mb-2" role="alert">
            <span class="alert-icon"><i class="la la-thumbs-o-up"></i></span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>{{ __('dashboard.well_done') }}!</strong> {{ $successMessage }}
        </div>
    @endif

    <ul class="wizard-timeline center-align">
        <li class="{{ $currentStep > 1 ? 'completed' : '' }}">
            <span class="step-num">1</span>
            <label>{{ __('dashboard.basic_information') }}</label>
        </li>
        <li class="{{ $currentStep > 2 ? 'completed' : '' }}">
            <span class="step-num">2</span>
            <label>{{ __('dashboard.product_variants') }}</label>
        </li>
        <li class="active {{ $currentStep > 3 ? 'completed' : '' }}">
            <span class="step-num">3</span>
            <label>{{ __('dashboard.product_images') }}</label>
        </li>
        <li class="{{ $currentStep == 4 ? 'completed' : '' }}">
            <span class="step-num">4</span>
            <label>{{ __('dashboard.confirmation') }}</label>
        </li>
    </ul>

    <form class="wizard-circle">

        {{-- ═══════════════════════════════════════════════════
             STEP 1 — Basic Information
        ════════════════════════════════════════════════════ --}}
        <div class="setup-content {{ $currentStep != 1 ? 'displayNone' : '' }}" id="step-1">
            <h3>{{ __('dashboard.step') }} 1</h3>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{ __('dashboard.product_name_ar') }}:</label>
                        <input wire:model.live="name_ar" type="text" class="form-control"
                            placeholder="{{ __('dashboard.product_name_ar') }}">
                        @error('name_ar') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{ __('dashboard.product_name_en') }}:</label>
                        <input wire:model.live="name_en" type="text" class="form-control"
                            placeholder="{{ __('dashboard.product_name_en') }}">
                        @error('name_en') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{ __('dashboard.small_description_ar') }}:</label>
                        <textarea wire:model.live="small_desc_ar" class="form-control"></textarea>
                        @error('small_desc_ar') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{ __('dashboard.small_description_en') }}:</label>
                        <textarea wire:model.live="small_desc_en" class="form-control"></textarea>
                        @error('small_desc_en') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{ __('dashboard.description_ar') }}:</label>
                        <textarea wire:model.live="desc_ar" class="form-control"></textarea>
                        @error('desc_ar') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{ __('dashboard.description_en') }}:</label>
                        <textarea wire:model.live="desc_en" class="form-control"></textarea>
                        @error('desc_en') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{ __('dashboard.category') }}:</label>
                        <select wire:model.live="category_id" class="form-control custom-select">
                            <option value="">{{ __('dashboard.select_category') }}</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{ __('dashboard.brand') }}:</label>
                        <select wire:model.live="brand_id" class="form-control custom-select">
                            <option value="">{{ __('dashboard.select_brand') }}</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                        @error('brand_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{ __('dashboard.available_for') }}:</label>
                        <input wire:model.live="available_for" type="date" class="form-control">
                        @error('available_for') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Tags --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{ __('dashboard.product_tags') }}:</label>

                        @if (!empty($tags))
                            <div class="mb-2">
                                @foreach ($tags as $index => $tag)
                                    <span class="badge badge-primary mr-1 mb-1" style="font-size:14px;padding:8px 12px;">
                                        <i class="la la-tag"></i> {{ $tag }}
                                        <button type="button" wire:click="removeTag({{ $index }})"
                                            class="close ml-2" style="font-size:18px;color:white;">
                                            <span>&times;</span>
                                        </button>
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        <div class="position-relative">
                            <input type="text" wire:model.live="tagInput"
                                wire:keydown.enter.prevent="addTag"
                                class="form-control"
                                placeholder="{{ __('dashboard.type_tag') }}">

                            @if ($showTagSuggestions && !empty($filteredTags))
                                <div class="position-absolute w-100 bg-white border rounded shadow-sm"
                                    style="z-index:1000;max-height:200px;overflow-y:auto;">
                                    <div class="list-group list-group-flush">
                                        @foreach ($filteredTags as $suggestedTag)
                                            <button type="button" wire:click="selectTag('{{ $suggestedTag }}')"
                                                class="list-group-item list-group-item-action">
                                                <i class="la la-tag"></i> {{ $suggestedTag }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                        @error('tags') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <button class="btn btn-primary pull-right mb-3" wire:click="firstStepSubmit"
                type="button">{{ __('dashboard.next') }}</button>
        </div>

        {{-- ═══════════════════════════════════════════════════
             STEP 2 — Pricing & Variants
        ════════════════════════════════════════════════════ --}}
        <div class="setup-content {{ $currentStep != 2 ? 'displayNone' : '' }}" id="step-2">
            <h3>{{ __('dashboard.step') }} 2</h3>

            <div class="row">
                <div class="col-md-{{ $has_variants == 0 ? '4' : '12' }}">
                    <div class="form-group">
                        <label>{{ __('dashboard.has_variants') }}:</label>
                        <select wire:model.live="has_variants" class="form-control">
                            <option value="0">{{ __('dashboard.no') }}</option>
                            <option value="1">{{ __('dashboard.yes') }}</option>
                        </select>
                        @error('has_variants') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>

                @if ($has_variants == 0)
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>{{ __('dashboard.manage_stock') }}:</label>
                            <select wire:model.live="manage_stock" class="form-control">
                                <option value="0">{{ __('dashboard.no') }}</option>
                                <option value="1">{{ __('dashboard.yes') }}</option>
                            </select>
                            @error('manage_stock') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>{{ __('dashboard.has_discount') }}:</label>
                            <select wire:model.live="has_discount" class="form-control">
                                <option value="0">{{ __('dashboard.no') }}</option>
                                <option value="1">{{ __('dashboard.yes') }}</option>
                            </select>
                            @error('has_discount') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                @endif
            </div>

            {{-- ==================== SIMPLE PRODUCT ==================== --}}
            @if ($has_variants == 0)
                <hr class="my-4">
                <h5 class="mb-4 font-weight-bold text-primary">{{ __('dashboard.product_details') }}</h5>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>{{ __('dashboard.price') }}:</label>
                            <input wire:model="price" type="number" step="0.01" class="form-control"
                                placeholder="{{ __('dashboard.price') }}">
                            @error('price') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>{{ __('dashboard.sku') }}:</label>
                            <input wire:model="sku" type="text" class="form-control"
                                placeholder="{{ __('dashboard.sku') }}">
                            @error('sku') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    @if ($manage_stock == 1)
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ __('dashboard.quantity') }}:</label>
                                <input wire:model="quantity" type="number" class="form-control"
                                    placeholder="{{ __('dashboard.quantity') }}">
                                @error('quantity') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    @endif
                </div>

                @if ($has_discount == 1)
                    <hr class="my-4">
                    <h5 class="mb-4 font-weight-bold text-primary">{{ __('dashboard.discount') }}</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ __('dashboard.discount') }}:</label>
                                <input wire:model="discount" type="number" step="0.01" min="0"
                                    max="100" class="form-control">
                                @error('discount') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ __('dashboard.start_discount') }}:</label>
                                <input wire:model="start_discount" type="date" class="form-control">
                                @error('start_discount') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ __('dashboard.end_discount') }}:</label>
                                <input wire:model="end_discount" type="date" class="form-control">
                                @error('end_discount') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                @endif
            @endif

            {{-- ==================== VARIANTS ==================== --}}
            @if ($has_variants == 1)
                <hr class="my-4">
                <h5 class="mb-4 font-weight-bold text-primary">{{ __('dashboard.product_variants') }}</h5>

                @for ($i = 0; $i < $valueRowCount; $i++)
                    <div class="card mb-4 shadow-sm border-0">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <strong>{{ __('dashboard.variant') }} #{{ $i + 1 }}</strong>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group mb-0">
                                        <label class="font-weight-bold">{{ __('dashboard.manage_stock') }}:</label>
                                        <select wire:model.live="variantManageStock.{{ $i }}" class="form-control">
                                            <option value="0">{{ __('dashboard.no') }}</option>
                                            <option value="1">{{ __('dashboard.yes') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-0">
                                        <label class="font-weight-bold">{{ __('dashboard.has_discount') }}:</label>
                                        <select wire:model.live="variantHasDiscount.{{ $i }}" class="form-control">
                                            <option value="0">{{ __('dashboard.no') }}</option>
                                            <option value="1">{{ __('dashboard.yes') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-3">

                            <div class="row">
                                <div class="col-md-{{ ($variantManageStock[$i] ?? 1) == 1 ? '4' : '6' }}">
                                    <div class="form-group">
                                        <label class="font-weight-bold">
                                            {{ __('dashboard.price') }} <span class="text-danger">*</span>
                                        </label>
                                        <input wire:model.defer="prices.{{ $i }}" type="number"
                                            step="0.01" class="form-control">
                                        @error('prices.' . $i) <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>

                                @if (($variantManageStock[$i] ?? 1) == 1)
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">
                                                {{ __('dashboard.quantity') }} <span class="text-danger">*</span>
                                            </label>
                                            <input wire:model.defer="quantities.{{ $i }}" type="number"
                                                class="form-control">
                                            @error('quantities.' . $i) <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                    </div>
                                @else
                                    <div class="col-md-6">
                                        <div class="alert alert-info mb-0 d-flex align-items-center h-100"
                                            style="margin-top:28px;">
                                            <i class="la la-info-circle mr-2"></i>
                                            <small>{{ __('dashboard.stock_not_managed_info') }}</small>
                                        </div>
                                    </div>
                                @endif

                                <div class="col-md-{{ ($variantManageStock[$i] ?? 1) == 1 ? '4' : '6' }}">
                                    <div class="form-group">
                                        <label class="font-weight-bold">
                                            {{ __('dashboard.sku') }} <span class="text-danger">*</span>
                                        </label>
                                        <input wire:model.defer="privateSkus.{{ $i }}" type="text"
                                            class="form-control">
                                        @error('privateSkus.' . $i) <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                            </div>

                            @if (($variantHasDiscount[$i] ?? 0) == 1)
                                <hr class="my-3">
                                <h6 class="font-weight-bold text-secondary mb-3">
                                    <i class="la la-percent"></i> {{ __('dashboard.discount') }}
                                </h6>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">{{ __('dashboard.discount') }}</label>
                                            <input wire:model.defer="variantDiscounts.{{ $i }}"
                                                type="number" step="0.01" min="0" max="100"
                                                class="form-control">
                                            @error('variantDiscounts.' . $i) <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">{{ __('dashboard.start_discount') }}</label>
                                            <input wire:model.defer="variantStartDiscounts.{{ $i }}"
                                                type="date" class="form-control">
                                            @error('variantStartDiscounts.' . $i) <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">{{ __('dashboard.end_discount') }}</label>
                                            <input wire:model.defer="variantEndDiscounts.{{ $i }}"
                                                type="date" class="form-control">
                                            @error('variantEndDiscounts.' . $i) <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <hr class="my-3">
                            <h6 class="font-weight-bold text-secondary mb-3">
                                <i class="la la-tags"></i> {{ __('dashboard.attributes') }}
                                <span class="text-danger">*</span>
                            </h6>
                            <div class="row">
                                @foreach ($attributes as $attr)
                                    <div class="col-md-4 mb-3">
                                        <label class="font-weight-bold">{{ $attr->name }}</label>
                                        <select
                                            wire:model.defer="attributeValues.{{ $i }}.{{ $attr->id }}"
                                            class="form-control">
                                            <option value="">{{ __('dashboard.select') }} {{ $attr->name }}</option>
                                            @foreach ($attr->attributeValues as $item)
                                                <option value="{{ $item->id }}">{{ $item->value }}</option>
                                            @endforeach
                                        </select>
                                        @error('attributeValues.' . $i . '.' . $attr->id)
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endfor

                <div class="d-flex justify-content-between mb-4">
                    <button type="button" wire:click="addNewVariant" class="btn btn-success px-4">
                        <i class="la la-plus"></i> {{ __('dashboard.add_variant') }}
                    </button>
                    <button type="button" wire:click="removeVariant" class="btn btn-outline-danger px-4">
                        <i class="la la-minus"></i> {{ __('dashboard.remove_variant') }}
                    </button>
                </div>
            @endif

            <button class="btn btn-primary pull-right mb-3 ml-1" type="button"
                wire:click="secondStepSubmit">{{ __('dashboard.next') }}</button>
            <button class="btn btn-danger pull-right" type="button"
                wire:click="back(1)">{{ __('dashboard.back') }}</button>
        </div>

        {{-- ═══════════════════════════════════════════════════
             STEP 3 — Images
        ════════════════════════════════════════════════════ --}}
        <div class="setup-content {{ $currentStep != 3 ? 'displayNone' : '' }}" id="step-3">
            <h3>{{ __('dashboard.step') }} 3</h3>

            @error('images')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            {{-- ── Existing Images ── --}}
            @if (!empty($existingImages))
                <h6 class="font-weight-bold mb-3">
                    <i class="la la-images"></i> {{ __('dashboard.current_images') }}
                </h6>
                <div class="row mb-4">
                    @foreach ($existingImages as $index => $img)
                        <div class="col-md-3 mb-3">
                            <div class="position-relative">
                                <img src="{{ $img['url'] }}"
                                    class="img-thumbnail {{ ($mainImageIsExisting && $mainImageIndex === $index) ? 'border-primary' : '' }}"
                                    style="width:100%;height:200px;object-fit:cover;">

                                @if ($mainImageIsExisting && $mainImageIndex === $index)
                                    <span class="badge badge-primary position-absolute"
                                        style="top:10px;left:10px;font-size:12px;">
                                        <i class="la la-star"></i> {{ __('dashboard.main_image') }}
                                    </span>
                                @endif

                                <div class="position-absolute" style="top:10px;right:10px;">
                                    @if (!($mainImageIsExisting && $mainImageIndex === $index))
                                        <button type="button"
                                            wire:click="setMainExistingImage({{ $index }})"
                                            class="btn btn-sm btn-warning mb-1"
                                            title="{{ __('dashboard.set_as_main') }}">
                                            <i class="la la-star"></i>
                                        </button>
                                    @endif
                                    <button type="button"
                                        wire:click="openFullscreenExisting({{ $index }})"
                                        class="btn btn-sm btn-info mb-1">
                                        <i class="la la-expand"></i>
                                    </button>
                                    <button type="button"
                                        wire:click="deleteExistingImage({{ $index }})"
                                        class="btn btn-sm btn-danger"
                                        title="{{ __('dashboard.delete_image') }}">
                                        <i class="la la-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- ── Upload New Images ── --}}
            <div class="form-group">
                <label>{{ __('dashboard.upload_new_images') }}:</label>
                <input type="file" wire:model.live="images" class="form-control" multiple>
                <small class="form-text text-muted">{{ __('dashboard.max_file_size') }}</small>
            </div>

            @if (!empty($images))
                <h6 class="font-weight-bold mb-3 mt-3">
                    <i class="la la-upload"></i> {{ __('dashboard.new_images') }}
                </h6>
                <div class="row">
                    @foreach ($images as $key => $image)
                        <div class="col-md-3 mb-3">
                            <div class="position-relative">
                                <img src="{{ $image->temporaryUrl() }}"
                                    class="img-thumbnail {{ (!$mainImageIsExisting && $mainImageIndex === $key) ? 'border-primary' : '' }}"
                                    style="width:100%;height:200px;object-fit:cover;">

                                @if (!$mainImageIsExisting && $mainImageIndex === $key)
                                    <span class="badge badge-success position-absolute"
                                        style="top:10px;left:10px;font-size:12px;">
                                        <i class="la la-star"></i> {{ __('dashboard.main_image') }}
                                    </span>
                                @endif

                                <div class="position-absolute" style="top:10px;right:10px;">
                                    @if (!(!$mainImageIsExisting && $mainImageIndex === $key))
                                        <button type="button"
                                            wire:click="setMainNewImage({{ $key }})"
                                            class="btn btn-sm btn-warning mb-1"
                                            title="{{ __('dashboard.set_as_main') }}">
                                            <i class="la la-star"></i>
                                        </button>
                                    @endif
                                    <button type="button"
                                        wire:click="openFullscreenNew({{ $key }})"
                                        class="btn btn-sm btn-info mb-1">
                                        <i class="la la-expand"></i>
                                    </button>
                                    <button type="button"
                                        wire:click="deleteNewImage({{ $key }})"
                                        class="btn btn-sm btn-danger">
                                        <i class="la la-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Fullscreen Modal --}}
            <div wire:ignore.self class="modal fade" id="fullscreenModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ __('dashboard.image_preview') }}</h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body text-center">
                            <img src="{{ $fullscreenImage }}" class="img-fluid" alt="">
                        </div>
                    </div>
                </div>
            </div>

            <button class="btn btn-success pull-right mb-3 ml-1" wire:click="thirdStepSubmit"
                type="button">{{ __('dashboard.next') }}</button>
            <button class="btn btn-danger pull-right mb-3" type="button"
                wire:click="back(2)">{{ __('dashboard.back') }}</button>
        </div>

        {{-- ═══════════════════════════════════════════════════
             STEP 4 — Confirmation
        ════════════════════════════════════════════════════ --}}
        <div class="setup-content {{ $currentStep != 4 ? 'displayNone' : '' }}" id="step-4">
            <h3>{{ __('dashboard.step') }} 4 - {{ __('dashboard.confirmation') }}</h3>

            <div class="row">
                {{-- Basic Information --}}
                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="la la-info-circle"></i> {{ __('dashboard.basic_information') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>{{ __('dashboard.product_name_ar') }}:</strong> {{ $name_ar }}</p>
                                    <p><strong>{{ __('dashboard.product_name_en') }}:</strong> {{ $name_en }}</p>
                                    <p><strong>{{ __('dashboard.category') }}:</strong>
                                        {{ $categories->firstWhere('id', $category_id)?->name ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>{{ __('dashboard.brand') }}:</strong>
                                        {{ $brands->firstWhere('id', $brand_id)?->name ?? 'N/A' }}</p>
                                    <p><strong>{{ __('dashboard.available_for') }}:</strong> {{ $available_for }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Pricing --}}
                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="la la-dollar"></i> {{ __('dashboard.pricing_inventory') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <p><strong>{{ __('dashboard.has_variants') }}:</strong>
                                        {{ $has_variants ? __('dashboard.yes') : __('dashboard.no') }}</p>
                                </div>
                                <div class="col-md-4">
                                    <p><strong>{{ __('dashboard.manage_stock') }}:</strong>
                                        {{ $manage_stock ? __('dashboard.yes') : __('dashboard.no') }}</p>
                                </div>
                                <div class="col-md-4">
                                    <p><strong>{{ __('dashboard.has_discount') }}:</strong>
                                        {{ $has_discount ? __('dashboard.yes') : __('dashboard.no') }}</p>
                                </div>
                            </div>

                            @if (!$has_variants)
                                <hr>
                                <div class="row">
                                    <div class="col-md-4">
                                        <p><strong>{{ __('dashboard.price') }}:</strong> {{ $price }}</p>
                                    </div>
                                    @if ($manage_stock)
                                        <div class="col-md-4">
                                            <p><strong>{{ __('dashboard.quantity') }}:</strong> {{ $quantity }}</p>
                                        </div>
                                    @endif
                                    @if ($sku)
                                        <div class="col-md-4">
                                            <p><strong>{{ __('dashboard.sku') }}:</strong> {{ $sku }}</p>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <hr>
                                <p><strong>{{ __('dashboard.variants') }}:</strong> {{ count($prices) }}</p>
                                <div class="table-responsive mt-3">
                                    <table class="table table-sm table-bordered">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>#</th>
                                                <th>{{ __('dashboard.price') }}</th>
                                                <th>{{ __('dashboard.quantity') }}</th>
                                                <th>{{ __('dashboard.sku') }}</th>
                                                <th>{{ __('dashboard.discount') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($prices as $index => $price)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $price }}</td>
                                                    <td>
                                                        @if (($variantManageStock[$index] ?? 0) == 1)
                                                            {{ $quantities[$index] ?? 0 }}
                                                        @else
                                                            <span class="text-muted">{{ __('dashboard.stock_not_managed') }}</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $privateSkus[$index] ?? 'N/A' }}</td>
                                                    <td>
                                                        @if (!empty($variantDiscounts[$index]))
                                                            <span class="badge badge-warning">{{ $variantDiscounts[$index] }}</span>
                                                            @if (!empty($variantStartDiscounts[$index]) && !empty($variantEndDiscounts[$index]))
                                                                <br><small class="text-muted">
                                                                    {{ $variantStartDiscounts[$index] }} - {{ $variantEndDiscounts[$index] }}
                                                                </small>
                                                            @endif
                                                        @else
                                                            <span class="text-muted">{{ __('dashboard.no_discount') }}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Images preview --}}
                @if (!empty($existingImages) || !empty($images))
                    <div class="col-md-12 mb-4">
                        <div class="card">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0">
                                    <i class="la la-image"></i> {{ __('dashboard.product_images') }}
                                    ({{ count($existingImages) + count($images) }})
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach ($existingImages as $idx => $img)
                                        <div class="col-md-2 col-sm-4 col-6 mb-2">
                                            <img src="{{ $img['url'] }}"
                                                class="img-thumbnail {{ ($mainImageIsExisting && $mainImageIndex === $idx) ? 'border-primary' : '' }}"
                                                style="width:100%;height:100px;object-fit:cover;">
                                            @if ($mainImageIsExisting && $mainImageIndex === $idx)
                                                <small class="text-primary"><i class="la la-star"></i> {{ __('dashboard.main') }}</small>
                                            @endif
                                        </div>
                                    @endforeach
                                    @foreach ($images as $key => $image)
                                        <div class="col-md-2 col-sm-4 col-6 mb-2">
                                            <img src="{{ $image->temporaryUrl() }}"
                                                class="img-thumbnail {{ (!$mainImageIsExisting && $mainImageIndex === $key) ? 'border-success' : '' }}"
                                                style="width:100%;height:100px;object-fit:cover;">
                                            @if (!$mainImageIsExisting && $mainImageIndex === $key)
                                                <small class="text-success"><i class="la la-star"></i> {{ __('dashboard.main') }}</small>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Tags --}}
                @if (!empty($tags))
                    <div class="col-md-12 mb-4">
                        <div class="card">
                            <div class="card-header bg-warning text-white">
                                <h5 class="mb-0">
                                    <i class="la la-tags"></i> {{ __('dashboard.product_tags') }} ({{ count($tags) }})
                                </h5>
                            </div>
                            <div class="card-body">
                                @foreach ($tags as $tag)
                                    <span class="badge badge-primary mr-1 mb-1" style="font-size:14px;padding:8px 12px;">
                                        <i class="la la-tag"></i> {{ $tag }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <button class="btn btn-success pull-right mb-3 ml-1" wire:click="submitForm" type="button">
                <i class="la la-check"></i> {{ __('dashboard.confirm_update') }}
            </button>
            <button class="btn btn-danger pull-right mb-3" type="button"
                wire:click="back(3)">{{ __('dashboard.back') }}</button>
        </div>

    </form>
</section>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('showFullscreenModal', () => {
            $('#fullscreenModal').modal('show');
        });
        Livewire.on('productUpdated', (event) => {
            console.log('Product updated successfully');
        });
    });
</script>
