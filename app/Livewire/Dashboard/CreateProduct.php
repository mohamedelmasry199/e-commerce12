<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Attribute;
use App\Models\Tag;
use Livewire\WithFileUploads;
use App\Services\Dashboard\ProductService;
use Illuminate\Validation\ValidationException;

class CreateProduct extends Component
{
    use WithFileUploads;

    // Step Management
    public $currentStep = 1;
    public $successMessage = '';

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
    public $images = [];
    public $mainImageIndex = 0;
    public $fullscreenImage = '';

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

    public function mount($categories, $brands)
    {
        $this->categories = $categories;
        $this->brands = $brands;
        $this->loadAvailableTags();
    }

    /**
     * Load available tags from database
     */
    public function loadAvailableTags()
    {
        $this->availableTags = Tag::all()->pluck('slug')->toArray();
    }

    /**
     * Add a new variant row
     */
    public function addNewVariant()
    {
        $this->prices[] = null;
        $this->quantities[] = null;
        $this->attributeValues[] = [];
        $this->privateSkus[] = '';
        $this->variantDiscounts[] = null;
        $this->variantStartDiscounts[] = null;
        $this->variantEndDiscounts[] = null;
        $this->variantManageStock[] = 0;
        $this->variantHasDiscount[] = 0;
        $this->valueRowCount = count($this->prices);
    }

    /**
     * Remove the last variant row
     */
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

    /**
     * Delete an uploaded image
     */
    public function deleteImage($key)
    {
        if (isset($this->images[$key])) {
            unset($this->images[$key]);
            $this->images = array_values($this->images); // Re-index array

            // Adjust main image index if needed
            if ($this->mainImageIndex >= count($this->images)) {
                $this->mainImageIndex = max(0, count($this->images) - 1);
            }
        }
    }

    /**
     * Set main image
     */
    public function setMainImage($index)
    {
        if (isset($this->images[$index])) {
            $this->mainImageIndex = $index;
            $this->dispatch('imageUpdated', ['message' => __('dashboard.main_image_set')]);
        }
    }

    /**
     * Open image in fullscreen
     */
    public function openFullscreen($key)
    {
        if (isset($this->images[$key])) {
            $this->fullscreenImage = $this->images[$key]->temporaryUrl();
            $this->dispatch('showFullscreenModal');
        }
    }

    /**
     * Clear image validation errors when file is updated
     */
    public function updatedImages()
    {
        $this->resetErrorBag('images');
    }

    /**
     * Add a tag
     */
    public function addTag()
    {
        $tag = trim(strtolower($this->tagInput));

        if (empty($tag)) {
            return;
        }

        if (!in_array($tag, $this->tags)) {
            $this->tags[] = $tag;
        }

        $this->tagInput = '';
        $this->showTagSuggestions = false;
        $this->resetErrorBag('tags');
    }

    /**
     * Remove a tag
     */
    public function removeTag($index)
    {
        if (isset($this->tags[$index])) {
            array_splice($this->tags, $index, 1);
        }
    }

    /**
     * Select a tag from suggestions
     */
    public function selectTag($tag)
    {
        if (!in_array($tag, $this->tags)) {
            $this->tags[] = $tag;
        }
        $this->tagInput = '';
        $this->showTagSuggestions = false;
    }

    /**
     * Update tag input and show suggestions
     */
    public function updatedTagInput()
    {
        $this->showTagSuggestions = !empty($this->tagInput);
    }

    /**
     * Get filtered tag suggestions
     */
    public function getFilteredTagsProperty()
    {
        if (empty($this->tagInput)) {
            return [];
        }

        return array_filter($this->availableTags, function($tag) {
            return stripos($tag, $this->tagInput) !== false && !in_array($tag, $this->tags);
        });
    }

    /**
     * Step 1: Basic Information Validation
     */
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
            'available_for' => ['required', 'date', 'after:yesterday'],
        ], [
            'name_ar.required' => __('validation.required', ['attribute' => __('dashboard.name_ar')]),
            'name_en.required' => __('validation.required', ['attribute' => __('dashboard.name_en')]),
            'desc_ar.required' => __('validation.required', ['attribute' => __('dashboard.desc_ar')]),
            'desc_en.required' => __('validation.required', ['attribute' => __('dashboard.desc_en')]),
            'small_desc_ar.required' => __('validation.required', ['attribute' => __('dashboard.small_desc_ar')]),
            'small_desc_en.required' => __('validation.required', ['attribute' => __('dashboard.small_desc_en')]),
            'category_id.required' => __('validation.required', ['attribute' => __('dashboard.category')]),
            'brand_id.required' => __('validation.required', ['attribute' => __('dashboard.brand')]),
            'available_for.required' => __('validation.required', ['attribute' => __('dashboard.available_for')]),
            'available_for.after' => __('validation.after', ['attribute' => __('dashboard.available_for'), 'date' => 'yesterday']),
        ]);

        $this->currentStep = 2;
    }

    /**
     * Step 2: Pricing & Inventory Validation
     */
    public function secondStepSubmit()
    {
        $rules = [
            'has_variants'  => ['required', 'in:1,0'],
        ];

        // Simple product rules
        if ($this->has_variants == 0) {
            $rules['manage_stock']  = ['required', 'in:0,1'];
            $rules['price'] = ['required', 'numeric', 'min:1', 'max:1000000'];
            $rules['sku'] = ['nullable', 'string', 'max:200', 'unique:product_variants,sku'];
            $rules['has_discount']  = ['required', 'in:1,0'];

        }

        // Stock management for simple products
        if ($this->manage_stock == 1 && $this->has_variants == 0) {
            $rules['quantity'] = ['required', 'integer', 'min:0', 'max:1000000'];
        }

        // Discount rules for simple products
        if ($this->has_discount == 1 && $this->has_variants == 0) {
            $rules['discount'] = ['required', 'numeric', 'min:1'];
            $rules['start_discount'] = ['required', 'date', 'before:end_discount'];
            $rules['end_discount'] = ['required', 'date', 'after:start_discount'];
        }

        // Variant product rules
        if ($this->has_variants == 1) {
            $rules['prices'] = ['required', 'array', 'min:1'];
            $rules['prices.*'] = ['required', 'numeric', 'min:1', 'max:1000000'];
            $rules['privateSkus'] = ['required', 'array', 'min:1'];
            $rules['privateSkus.*'] = ['required', 'string', 'max:200', 'unique:product_variants,sku'];
            $rules['attributeValues'] = ['required', 'array', 'min:1'];
            $rules['attributeValues.*'] = ['required', 'array', 'min:1']; // at least 1 attribute selected
            $rules['attributeValues.*.*'] = ['nullable', 'integer', 'exists:attribute_values,id'];
            // Quantity per variant - required only if that variant manages stock
            $rules['quantities'] = ['nullable', 'array'];
foreach (($this->prices ?? []) as $i => $price){
                if (($this->variantManageStock[$i] ?? 1) == 1) {
                    $rules["quantities.$i"] = ['required', 'integer', 'min:0'];
                } else {
                    $rules["quantities.$i"] = ['nullable', 'integer', 'min:0'];
                }
            }

            // Discount per variant - required only if that variant has discount
            $rules['variantDiscounts'] = ['nullable', 'array'];
            $rules['variantStartDiscounts'] = ['nullable', 'array'];
            $rules['variantEndDiscounts'] = ['nullable', 'array'];
            foreach ($this->prices as $i => $price) {
                if (($this->variantHasDiscount[$i] ?? 0) == 1) {
                    $rules["variantDiscounts.$i"] = ['required', 'numeric', 'min:0'];
                    $rules["variantStartDiscounts.$i"] = ['required', 'date'];
                    $rules["variantEndDiscounts.$i"] = ['required', 'date', "after:variantStartDiscounts.$i"];
                } else {
                    $rules["variantDiscounts.$i"] = ['nullable', 'numeric', 'min:0'];
                    $rules["variantStartDiscounts.$i"] = ['nullable', 'date'];
                    $rules["variantEndDiscounts.$i"] = ['nullable', 'date'];
                }
            }
        }

        $this->validate($rules, [
            'price.required' => __('validation.required', ['attribute' => __('dashboard.price')]),
            'quantity.required' => __('validation.required', ['attribute' => __('dashboard.quantity')]),
            'discount.required' => __('validation.required', ['attribute' => __('dashboard.discount')]),
            'start_discount.required' => __('validation.required', ['attribute' => __('dashboard.start_discount')]),
            'end_discount.required' => __('validation.required', ['attribute' => __('dashboard.end_discount')]),
            'prices.*.required' => __('validation.required', ['attribute' => __('dashboard.variant_price')]),
            'quantities.*.required' => __('validation.required', ['attribute' => __('dashboard.variant_quantity')]),
            'privateSkus.*.required' => __('validation.required', ['attribute' => __('dashboard.variant_sku')]),
            'privateSkus.*.unique' => __('validation.unique', ['attribute' => __('dashboard.variant_sku')]),
        ]);

        $this->currentStep = 3;
    }

    /**
     * Step 3: Images & Tags Validation
     */
    public function thirdStepSubmit()
    {
        $this->validate([
            'images' => ['required', 'array', 'min:1'],
            'images.*' => ['image', 'max:5120'], // 5MB max
            'tags' => ['nullable', 'array'],
        ], [
            'images.required' => __('validation.required', ['attribute' => __('dashboard.images')]),
            'images.min' => __('validation.min.array', ['attribute' => __('dashboard.images'), 'min' => 1]),
            'images.*.image' => __('validation.image', ['attribute' => __('dashboard.image')]),
            'images.*.max' => __('validation.max.file', ['attribute' => __('dashboard.image'), 'max' => '5MB']),
        ]);
// dd($this->mainImageIndex,$this->images, $this->tags);
        $this->currentStep = 4;
    }

    /**
     * Final Submit: Create Product
     */
    public function submitForm()
    {


        // Prepare product data
        $product = [
            'name' => [
                'ar' => $this->name_ar,
                'en' => $this->name_en
            ],
            'desc' => [
                'ar' => $this->desc_ar,
                'en' => $this->desc_en
            ],
            'small_desc' => [
                'ar' => $this->small_desc_ar,
                'en' => $this->small_desc_en
            ],
            'category_id' => $this->category_id,
            'brand_id' => $this->brand_id,
            'available_for' => $this->available_for,
            'has_variants' => $this->has_variants,

        ];

        $productVariants = [];
        if ($this->has_variants) {
            foreach ($this->prices as $index => $price) {
                $productVariants[] = [
                    'product_id' => null,
                    'price' => $price,
                    'sku' => $this->privateSkus[$index] ?? null,
                    'manage_stock' => $this->variantManageStock[$index] ?? 0,
                    'stock' => $this->quantities[$index] ?? 0,
                    'attribute_value_ids' => $this->attributeValues[$index] ?? [],
                    'has_discount' => $this->variantHasDiscount[$index] ?? 0,
                    'discount' => $this->variantDiscounts[$index] ?? null,
                    'start_discount' => $this->variantStartDiscounts[$index] ?? null,
                    'end_discount' => $this->variantEndDiscounts[$index] ?? null,
                ];
            }
        }
        else {
            $productVariants[] = [
                'product_id' => null,
                'price' => $this->price,
                'sku' => $this->sku,
                'manage_stock' => $this->manage_stock,
                'stock' => $this->manage_stock == 1 ? $this->quantity : 0,
                'attribute_value_ids' => [],
                'has_discount' => $this->has_discount,
                'discount' => $this->has_discount == 1 ? $this->discount : null,
                'start_discount' => $this->has_discount == 1 ? $this->start_discount : null,
                'end_discount' => $this->has_discount == 1 ? $this->end_discount : null,
            ];
        }

        // Call service to create product
        $this->productService->createProductWithDetails(
            $product,
            $productVariants,
            $this->images,
            $this->mainImageIndex,
            $this->tags
        );

        $this->successMessage = __('dashboard.product_created_successfully');
        $this->resetExcept(['categories', 'brands', 'successMessage']);
        $this->currentStep = 1;

        $this->dispatch('productCreated', ['message' => $this->successMessage]);
    }

    /**
     * Navigate back to a specific step
     */
    public function back($step)
    {
        if ($step >= 1 && $step < $this->currentStep) {
            $this->currentStep = $step;
        }
    }

    /**
     * Reset form
     */
    public function resetForm()
    {
        $this->resetExcept(['categories', 'brands', 'availableTags']);
        $this->currentStep = 1;
    }

    /**
     * Render the component
     */
    public function render()
    {
        $attributes = Attribute::with('attributeValues')->get();

        return view('livewire.dashboard.create-product', [
            'attributes' => $attributes,
            'filteredTags' => $this->filteredTags,
        ]);
    }
}
