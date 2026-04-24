<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Attribute;
use App\Models\Tag;
use Livewire\WithFileUploads;
use App\Services\Dashboard\ProductService;

class EditProduct extends Component
{
    use WithFileUploads;

    // Step Management
    public $currentStep = 1;
    public $successMessage = '';

    // Product ID
    public $productId;

    // Reference Data
    public $brands, $categories;

    // Basic Product Information
    public $name_ar, $name_en;
    public $desc_ar, $desc_en;
    public $small_desc_ar, $small_desc_en;
    public $category_id, $brand_id;
    public $sku, $available_for;

    // Product Options
    public $has_variants = 0;
    public $manage_stock = 0;
    public $has_discount = 0;

    // Simple Product Data
    public $price, $quantity;

    // Discount Data
    public $discount, $start_discount, $end_discount;

    // Variant Data
    public $prices = [];
    public $quantities = [];
    public $attributeValues = [];
    public $privateSkus = [];
    public $variantDiscounts = [];
    public $variantStartDiscounts = [];
    public $variantEndDiscounts = [];
    public $variantManageStock = [];
    public $variantHasDiscount = [];
    public $valueRowCount = 1;

    // Media Management
    public $images = [];           // New uploaded images
    public $existingImages = [];   // Already saved images [{id, url, is_main}]
    public $mainImageIndex = 0;
    public $mainImageIsExisting = true; // true = mainImageIndex refers to existingImages, false = new images
    public $fullscreenImage = '';
    public $imagesToDelete = [];   // IDs of existing images marked for deletion

    // Tags Management
    public $tags = [];
    public $tagInput = '';
    public $availableTags = [];
    public $showTagSuggestions = false;

    protected ProductService $productService;

    public function boot(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function mount($product, $categories, $brands)
    {
        $this->productId   = $product->id;
        $this->categories  = $categories;
        $this->brands      = $brands;

        $this->loadAvailableTags();
        $this->fillFromProduct($product);
    }

    // ──────────────────────────────────────────────
    //  Hydrate existing product data into properties
    // ──────────────────────────────────────────────
    protected function fillFromProduct($product)
    {
        // Basic info
        $this->name_ar       = $product->getTranslation('name', 'ar');
        $this->name_en       = $product->getTranslation('name', 'en');
        $this->desc_ar       = $product->getTranslation('desc', 'ar');
        $this->desc_en       = $product->getTranslation('desc', 'en');
        $this->small_desc_ar = $product->getTranslation('small_desc', 'ar');
        $this->small_desc_en = $product->getTranslation('small_desc', 'en');
        $this->category_id   = $product->category_id;
        $this->brand_id      = $product->brand_id;
        $this->available_for = $product->available_for;
        $this->has_variants  = $product->has_variants;

        // Tags
        $this->tags = $product->tags->pluck('slug')->toArray();

        // Existing images
        $this->existingImages = $product->images->map(fn($img) => [
            'id'      => $img->id,
            'url'     => asset('storage/' . $img->path),
            'is_main' => $img->is_main,
        ])->toArray();

        // Determine main image index from existing images
        $this->mainImageIsExisting = true;
        $this->mainImageIndex = 0;
        foreach ($this->existingImages as $idx => $img) {
            if ($img['is_main']) {
                $this->mainImageIndex = $idx;
                break;
            }
        }

        // Variants
        if ($product->has_variants) {
            $this->valueRowCount = $product->variants->count();
            foreach ($product->variants as $i => $variant) {
                $this->prices[]                = $variant->price;
                $this->quantities[]            = $variant->stock;
                $this->privateSkus[]           = $variant->sku;
                $this->variantManageStock[]    = $variant->manage_stock;
                $this->variantHasDiscount[]    = $variant->has_discount;
                $this->variantDiscounts[]      = $variant->discount;
                $this->variantStartDiscounts[] = $variant->start_discount;
                $this->variantEndDiscounts[]   = $variant->end_discount;

                // Map attribute values keyed by attribute_id
                $attrMap = [];
                foreach ($variant->attributeValues as $av) {
                    $attrMap[$av->attribute_id] = $av->id;
                }
                $this->attributeValues[] = $attrMap;
            }
        } else {
            $firstVariant = $product->variants->first();
            if ($firstVariant) {
                $this->price         = $firstVariant->price;
                $this->quantity      = $firstVariant->stock;
                $this->sku           = $firstVariant->sku;
                $this->manage_stock  = $firstVariant->manage_stock;
                $this->has_discount  = $firstVariant->has_discount;
                $this->discount      = $firstVariant->discount;
                $this->start_discount = $firstVariant->start_discount;
                $this->end_discount  = $firstVariant->end_discount;
            }
        }
    }

    public function loadAvailableTags()
    {
        $this->availableTags = Tag::all()->pluck('slug')->toArray();
    }

    // ──────────────────────────────────────────────
    //  Variant management
    // ──────────────────────────────────────────────
    public function addNewVariant()
    {
        $this->prices[]                = null;
        $this->quantities[]            = null;
        $this->attributeValues[]       = [];
        $this->privateSkus[]           = '';
        $this->variantDiscounts[]      = null;
        $this->variantStartDiscounts[] = null;
        $this->variantEndDiscounts[]   = null;
        $this->variantManageStock[]    = 0;
        $this->variantHasDiscount[]    = 0;
        $this->valueRowCount = count($this->prices);
    }

    public function removeVariant($index = null)
    {
        if ($index !== null && isset($this->prices[$index])) {
            array_splice($this->prices, $index, 1);
            array_splice($this->quantities, $index, 1);
            array_splice($this->attributeValues, $index, 1);
            array_splice($this->privateSkus, $index, 1);
            array_splice($this->variantDiscounts, $index, 1);
            array_splice($this->variantStartDiscounts, $index, 1);
            array_splice($this->variantEndDiscounts, $index, 1);
            array_splice($this->variantManageStock, $index, 1);
            array_splice($this->variantHasDiscount, $index, 1);
            $this->valueRowCount = count($this->prices);
        } elseif ($this->valueRowCount > 1) {
            $this->valueRowCount--;
            array_pop($this->prices);
            array_pop($this->quantities);
            array_pop($this->attributeValues);
            array_pop($this->privateSkus);
            array_pop($this->variantDiscounts);
            array_pop($this->variantStartDiscounts);
            array_pop($this->variantEndDiscounts);
            array_pop($this->variantManageStock);
            array_pop($this->variantHasDiscount);
        }
    }

    // ──────────────────────────────────────────────
    //  Image management
    // ──────────────────────────────────────────────

    /** Mark an existing (saved) image for deletion */
    public function deleteExistingImage($index)
    {
        if (isset($this->existingImages[$index])) {
            $this->imagesToDelete[] = $this->existingImages[$index]['id'];
            array_splice($this->existingImages, $index, 1);
            $this->existingImages = array_values($this->existingImages);

            // Adjust main image pointer
            if ($this->mainImageIsExisting) {
                if ($this->mainImageIndex >= count($this->existingImages)) {
                    if (!empty($this->existingImages)) {
                        $this->mainImageIndex = 0;
                    } else {
                        // Fall back to new images if any
                        $this->mainImageIsExisting = false;
                        $this->mainImageIndex      = 0;
                    }
                }
            }
        }
    }

    /** Delete a newly uploaded image (not yet persisted) */
    public function deleteNewImage($key)
    {
        if (isset($this->images[$key])) {
            unset($this->images[$key]);
            $this->images = array_values($this->images);

            if (!$this->mainImageIsExisting) {
                if ($this->mainImageIndex >= count($this->images)) {
                    $this->mainImageIndex = max(0, count($this->images) - 1);
                }
            }
        }
    }

    public function setMainExistingImage($index)
    {
        if (isset($this->existingImages[$index])) {
            $this->mainImageIsExisting = true;
            $this->mainImageIndex      = $index;
        }
    }

    public function setMainNewImage($index)
    {
        if (isset($this->images[$index])) {
            $this->mainImageIsExisting = false;
            $this->mainImageIndex      = $index;
        }
    }

    public function openFullscreenExisting($index)
    {
        if (isset($this->existingImages[$index])) {
            $this->fullscreenImage = $this->existingImages[$index]['url'];
            $this->dispatch('showFullscreenModal');
        }
    }

    public function openFullscreenNew($key)
    {
        if (isset($this->images[$key])) {
            $this->fullscreenImage = $this->images[$key]->temporaryUrl();
            $this->dispatch('showFullscreenModal');
        }
    }

    public function updatedImages()
    {
        $this->resetErrorBag('images');
    }

    // ──────────────────────────────────────────────
    //  Tag management
    // ──────────────────────────────────────────────
    public function addTag()
    {
        $tag = trim(strtolower($this->tagInput));
        if (empty($tag)) return;

        if (!in_array($tag, $this->tags)) {
            $this->tags[] = $tag;
        }
        $this->tagInput          = '';
        $this->showTagSuggestions = false;
        $this->resetErrorBag('tags');
    }

    public function removeTag($index)
    {
        if (isset($this->tags[$index])) {
            array_splice($this->tags, $index, 1);
        }
    }

    public function selectTag($tag)
    {
        if (!in_array($tag, $this->tags)) {
            $this->tags[] = $tag;
        }
        $this->tagInput           = '';
        $this->showTagSuggestions = false;
    }

    public function updatedTagInput()
    {
        $this->showTagSuggestions = !empty($this->tagInput);
    }

    public function getFilteredTagsProperty()
    {
        if (empty($this->tagInput)) return [];

        return array_filter($this->availableTags, fn($tag) =>
            stripos($tag, $this->tagInput) !== false && !in_array($tag, $this->tags)
        );
    }

    // ──────────────────────────────────────────────
    //  Step validation
    // ──────────────────────────────────────────────
    public function firstStepSubmit()
    {
        $this->validate([
            'name_ar'       => ['required', 'string', 'max:80'],
            'name_en'       => ['required', 'string', 'max:80'],
            'desc_ar'       => ['required', 'string', 'max:1000'],
            'desc_en'       => ['required', 'string', 'max:1000'],
            'small_desc_ar' => ['required', 'string', 'max:150'],
            'small_desc_en' => ['required', 'string', 'max:150'],
            'category_id'   => ['required', 'exists:categories,id'],
            'brand_id'      => ['required', 'exists:brands,id'],
            'available_for' => ['required', 'date','after_or_equal:today'],
        ], [
            'name_ar.required'       => __('validation.required', ['attribute' => __('dashboard.name_ar')]),
            'name_en.required'       => __('validation.required', ['attribute' => __('dashboard.name_en')]),
            'desc_ar.required'       => __('validation.required', ['attribute' => __('dashboard.desc_ar')]),
            'desc_en.required'       => __('validation.required', ['attribute' => __('dashboard.desc_en')]),
            'small_desc_ar.required' => __('validation.required', ['attribute' => __('dashboard.small_desc_ar')]),
            'small_desc_en.required' => __('validation.required', ['attribute' => __('dashboard.small_desc_en')]),
            'category_id.required'   => __('validation.required', ['attribute' => __('dashboard.category')]),
            'brand_id.required'      => __('validation.required', ['attribute' => __('dashboard.brand')]),
            'available_for.required' => __('validation.required', ['attribute' => __('dashboard.available_for')]),
        ]);

        $this->currentStep = 2;
    }

    public function secondStepSubmit()
    {
        $rules = ['has_variants' => ['required', 'in:1,0']];

        if ($this->has_variants == 0) {
            $rules['manage_stock'] = ['required', 'in:0,1'];
            $rules['price']        = ['required', 'numeric', 'min:1', 'max:1000000'];
            // unique except current product's variant
            $rules['sku']          = ['nullable', 'string', 'max:200',
                "unique:product_variants,sku,{$this->getSimpleVariantId()},id"];
            $rules['has_discount'] = ['required', 'in:1,0'];
        }

        if ($this->manage_stock == 1 && $this->has_variants == 0) {
            $rules['quantity'] = ['required', 'integer', 'min:0', 'max:1000000'];
        }

        if ($this->has_discount == 1 && $this->has_variants == 0) {
            $rules['discount']        = ['required', 'numeric', 'min:1'];
            $rules['start_discount']  = ['required', 'date', 'before:end_discount'];
            $rules['end_discount']    = ['required', 'date', 'after:start_discount'];
        }

        if ($this->has_variants == 1) {
            $rules['prices']          = ['required', 'array', 'min:1'];
            $rules['prices.*']        = ['required', 'numeric', 'min:1', 'max:1000000'];
            $rules['privateSkus']     = ['required', 'array', 'min:1'];
            $rules['attributeValues'] = ['required', 'array', 'min:1'];
            $rules['attributeValues.*']   = ['required', 'array', 'min:1'];
            $rules['attributeValues.*.*'] = ['nullable', 'integer', 'exists:attribute_values,id'];
            $rules['quantities']      = ['nullable', 'array'];

            foreach (($this->prices ?? []) as $i => $price) {
                // SKU unique except variants of this product
                $rules["privateSkus.$i"] = ['required', 'string', 'max:200'];

                if (($this->variantManageStock[$i] ?? 1) == 1) {
                    $rules["quantities.$i"] = ['required', 'integer', 'min:0'];
                } else {
                    $rules["quantities.$i"] = ['nullable', 'integer', 'min:0'];
                }

                if (($this->variantHasDiscount[$i] ?? 0) == 1) {
                    $rules["variantDiscounts.$i"]      = ['required', 'numeric', 'min:0'];
                    $rules["variantStartDiscounts.$i"] = ['required', 'date'];
                    $rules["variantEndDiscounts.$i"]   = ['required', 'date', "after:variantStartDiscounts.$i"];
                } else {
                    $rules["variantDiscounts.$i"]      = ['nullable', 'numeric', 'min:0'];
                    $rules["variantStartDiscounts.$i"] = ['nullable', 'date'];
                    $rules["variantEndDiscounts.$i"]   = ['nullable', 'date'];
                }
            }
        }

        $this->validate($rules, [
            'price.required'          => __('validation.required', ['attribute' => __('dashboard.price')]),
            'quantity.required'       => __('validation.required', ['attribute' => __('dashboard.quantity')]),
            'discount.required'       => __('validation.required', ['attribute' => __('dashboard.discount')]),
            'start_discount.required' => __('validation.required', ['attribute' => __('dashboard.start_discount')]),
            'end_discount.required'   => __('validation.required', ['attribute' => __('dashboard.end_discount')]),
            'prices.*.required'       => __('validation.required', ['attribute' => __('dashboard.variant_price')]),
            'quantities.*.required'   => __('validation.required', ['attribute' => __('dashboard.variant_quantity')]),
            'privateSkus.*.required'  => __('validation.required', ['attribute' => __('dashboard.variant_sku')]),
        ]);

        $this->currentStep = 3;
    }

    public function thirdStepSubmit()
    {
        $hasExistingImages = !empty($this->existingImages);
        $hasNewImages      = !empty($this->images);

        $rules = [
            'images'   => ['nullable', 'array'],
            'images.*' => ['image', 'max:5120'],
            'tags'     => ['nullable', 'array'],
        ];

        // Require at least one image total
        if (!$hasExistingImages && !$hasNewImages) {
            $this->addError('images', __('validation.required', ['attribute' => __('dashboard.images')]));
            return;
        }

        $this->validate($rules, [
            'images.*.image' => __('validation.image', ['attribute' => __('dashboard.image')]),
            'images.*.max'   => __('validation.max.file', ['attribute' => __('dashboard.image'), 'max' => '5MB']),
        ]);

        $this->currentStep = 4;
    }

    // ──────────────────────────────────────────────
    //  Final submit
    // ──────────────────────────────────────────────
    public function submitForm()
    {
        $productData = [
            'name'         => ['ar' => $this->name_ar, 'en' => $this->name_en],
            'desc'         => ['ar' => $this->desc_ar, 'en' => $this->desc_en],
            'small_desc'   => ['ar' => $this->small_desc_ar, 'en' => $this->small_desc_en],
            'category_id'  => $this->category_id,
            'brand_id'     => $this->brand_id,
            'available_for'=> $this->available_for,
            'has_variants' => $this->has_variants,
        ];

        $productVariants = [];

        if ($this->has_variants) {
            foreach ($this->prices as $index => $price) {
                $productVariants[] = [
                    'product_id'          => null,
                    'price'               => $price,
                    'sku'                 => $this->privateSkus[$index] ?? null,
                    'manage_stock'        => $this->variantManageStock[$index] ?? 0,
                    'stock'               => $this->quantities[$index] ?? 0,
                    'attribute_value_ids' => $this->attributeValues[$index] ?? [],
                    'has_discount'        => $this->variantHasDiscount[$index] ?? 0,
                    'discount'            => $this->variantDiscounts[$index] ?? null,
                    'start_discount'      => $this->variantStartDiscounts[$index] ?? null,
                    'end_discount'        => $this->variantEndDiscounts[$index] ?? null,
                ];
            }
        } else {
            $productVariants[] = [
                'product_id'          => null,
                'price'               => $this->price,
                'sku'                 => $this->sku,
                'manage_stock'        => $this->manage_stock,
                'stock'               => $this->manage_stock == 1 ? $this->quantity : null,
                'attribute_value_ids' => [],
                'has_discount'        => $this->has_discount,
                'discount'            => $this->has_discount == 1 ? $this->discount : null,
                'start_discount'      => $this->has_discount == 1 ? $this->start_discount : null,
                'end_discount'        => $this->has_discount == 1 ? $this->end_discount : null,
            ];
        }

        // Resolve main image index for service
        // If mainImageIsExisting → pass null for new images main index (service will handle existing)
        $newMainImageIndex = $this->mainImageIsExisting ? null : $this->mainImageIndex;

        $this->productService->updateProductWithDetails(
            $this->productId,
            $productData,
            $productVariants,
            $this->images,
            $this->existingImages,
            $newMainImageIndex,
            $this->tags,
            $this->imagesToDelete,
            $this->mainImageIsExisting ? $this->mainImageIndex : null
        );

        $this->successMessage = __('dashboard.product_updated_successfully');
        $this->dispatch('productUpdated', ['message' => $this->successMessage]);

        // Refresh existing images from DB
        $product = $this->productService->getProductByIdWithEagerLoading($this->productId);
        $this->existingImages = $product->images->map(fn($img) => [
            'id'      => $img->id,
            'url'     => asset('storage/' . $img->path),
            'is_main' => $img->is_main,
        ])->toArray();

        $this->images         = [];
        $this->imagesToDelete = [];
        $this->currentStep    = 1;
    }

    // ──────────────────────────────────────────────
    //  Helpers
    // ──────────────────────────────────────────────
    protected function getSimpleVariantId(): int
    {
        $product = $this->productService->getProductById($this->productId);
        $variant = $product->variants()->first();
        return $variant ? $variant->id : 0;
    }

    public function back($step)
    {
        if ($step >= 1 && $step < $this->currentStep) {
            $this->currentStep = $step;
        }
    }

    public function render()
    {
        $attributes = Attribute::with('attributeValues')->get();

        return view('livewire.dashboard.edit-product', [
            'attributes'   => $attributes,
            'filteredTags' => $this->filteredTags,
        ]);
    }
}
