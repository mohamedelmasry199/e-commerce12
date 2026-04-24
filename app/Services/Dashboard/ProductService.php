<?php

namespace App\Services\Dashboard;

use App\Utils\ImageManager;
use App\Repositories\Dashboard\ProductRepository;

class ProductService
{
    /**
     * Create a new class instance.
     */
    protected ProductRepository $productRepository;
    protected ImageManager $imageManager;
    public function __construct(ProductRepository $productRepository, ImageManager $imageManager)
    {
        $this->productRepository = $productRepository;
        $this->imageManager = $imageManager;
    }
    public function getAllProducts()
    {
        $products = $this->productRepository->getAllProducts();
        return datatables()->of($products)
      ->addIndexColumn()
            ->addColumn('name', function ($product) {
                return $product->getNameTranslated();
            })
            // ->addColumn('small_desc', function ($product) {
            //     return $product->getSmallDescTranslated();
            // })
                ->addColumn('status', function ($product) {
                    return $product->getStatusTranslated();
                })
            ->addColumn('has_variants', function ($product) {
                return $product->getHasVariantsTranslated();
            })
            ->addColumn('price',function($product){
                if($product->has_variants){
                $minPrice = $product->variants->min('price');
                $maxPrice = $product->variants->max('price');
                return $minPrice == $maxPrice ? $minPrice : "$minPrice - $maxPrice";
                }
                else{
                    return $product->variants->first()->price ?? 'N/A';
                }
            })
            ->addColumn('quantity', function ($product) {
                if($product->has_variants){
                $totalQuantity = $product->variants->sum('stock');
                return $totalQuantity;
                }
                elseif($product->variants->first()->manage_stock ?? true){
                    return $product->variants->first()->stock ;
                }
                else{
                    return __('dashboard.stock_not_managed');
                }
            })
            ->addColumn('sku', function ($product) {
                if($product->has_variants){
                $skus = $product->variants->pluck('sku')->implode(', ');
                return $skus;
                }
                else{
                    return $product->variants->first()->sku ?? 'N/A';
                }
            })
            // ->addColumn('tags', function ($product) {
            //     return $product->tags->pluck('slug')->implode(', ');
            // })
            ->addColumn('images', function ($product) {
                return view('dashboard.products.datatables.images', compact('product'));
            })
            ->addColumn('category', function ($product) {
                return $product->category ? $product->category->getNameTranslated() : '';
            })
            ->addColumn('brand', function ($product) {
                return $product->brand ? $product->brand->getNameTranslated() : '';
            })
                ->addColumn('action', function ($product) {
                    return view('dashboard.products.datatables.actions', compact('product'));
                })
            ->make(true);
    }


    public function createProductWithDetails($ProductData, $productVariant, $images, $mainImageIndex, $tags)
    {
        // Create Product
        $product = $this->productRepository->createProduct($ProductData);

        // Create Product Variants
        foreach ($productVariant as $variant) {
            $variant['product_id'] = $product->id;
            $createdVariant = $this->productRepository->createProductVariant($variant);

            // Filter and sync attribute values (removes empty values)
            $attributeIds = array_filter(
                $variant['attribute_value_ids'] ?? [],
                fn($id) => !empty($id) && is_numeric($id)
            );

            if (!empty($attributeIds)) {
                $createdVariant->attributeValues()->sync(array_values($attributeIds));
            }
        }

        // Create Product Tags
        if (!empty($tags)) {
            $this->productRepository->createProuctTags($tags, $product);
        }

        // Upload Product Images
        if (!empty($images)) {
            $this->imageManager->uploadImages($images, $product, 'products', $mainImageIndex);
        }

        return $product;
    }
    public function getProductByIdWithEagerLoading($id)
    {
        return $this->productRepository->getProductByIdWithEagerLoading($id);
    }
    public function getProductById($id)
    {
        return $this->productRepository->getProductById($id);
    }
    public function getProductTags($id)
    {
        $product = $this->productRepository->getProductByIdWithEagerLoading($id);
        if (!$product){
           return false;
       }
        return $product->tags->pluck('slug')->toArray();
    }
    public function changeStatus($id)
    {
        $product =$this->productRepository->getProductById($id);
        if (!$product){
           return false;
       }
        return $this->productRepository->changeStatus($product);
    }
    public function getProductAttributes($id)
    {
        $product = $this->productRepository->getProductByIdWithEagerLoading($id);
        if (!$product){
           return false;
       }
       $attributes = $product->variants->flatMap(function ($variant) {
        return $variant->attributeValues;
    })->unique('attribute_id')->groupBy('attribute_id');
        return $attributes;
    }
    public function deleteProduct($id)
    {
        $product = $this->productRepository->getProductById($id);
        if (!$product){
           return false;
       }
        return $this->productRepository->deleteProduct($product);
    }

    // public function updateProductWithDetails($productId, $productData, $productVariants, $newImages, $existingImages, $mainImageIndex, $tags)
    // {
    //     // Get existing product
    //     $product = $this->productRepository->getProductById($productId);

    //     // Update product basic info
    //     $this->productRepository->updateProduct($product, $productData);

    //     // Delete old variants and create new ones
    //     $this->productRepository->deleteProductVariants($productId);

    //     foreach ($productVariants as $variant) {
    //         $variant['product_id'] = $productId;
    //         $createdVariant = $this->productRepository->createProductVariant($variant);

    //         // Filter and sync attribute values
    //         $attributeIds = array_filter(
    //             $variant['attribute_value_ids'] ?? [],
    //             fn($id) => !empty($id) && is_numeric($id)
    //         );

    //         if (!empty($attributeIds)) {
    //             $createdVariant->attributeValues()->sync(array_values($attributeIds));
    //         }
    //     }

    //     // Sync tags
    //     if (!empty($tags)) {
    //         $this->productRepository->syncProductTags($product, $tags);
    //     } else {
    //         $product->tags()->detach();
    //     }

    //     // Handle images - delete old ones if new images are uploaded
    //     if (!empty($newImages)) {
    //         $this->productRepository->deleteProductImages($productId);
    //         $this->imageManager->uploadImages($newImages, $product, 'products', $mainImageIndex);
    //     } elseif (!empty($existingImages)) {
    //         // Update main image if needed
    //         foreach ($product->images as $index => $image) {
    //             $image->is_main = ($index == $mainImageIndex) ? 1 : 0;
    //             $image->save();
    //         }
    //     }

    //     return $product;
    // }
     public function updateProductWithDetails(
        $productId,
        $productData,
        $productVariants,
        $newImages,
        $existingImages,        // array of ['id', 'url', 'is_main']
        $newMainImageIndex,     // int|null  — index into $newImages; null if main is an existing image
        $tags,
        $imagesToDelete,        // array of existing image IDs to remove
        $existingMainIndex      // int|null  — index into $existingImages that should be main
    ) {
        $product = $this->productRepository->getProductById($productId);

        // 1. Update basic info
        $this->productRepository->updateProduct($product, $productData);

        // 2. Replace variants
        $this->productRepository->deleteProductVariants($productId);
        foreach ($productVariants as $variant) {
            $variant['product_id'] = $productId;
            $createdVariant = $this->productRepository->createProductVariant($variant);

            $attributeIds = array_filter(
                $variant['attribute_value_ids'] ?? [],
                fn($id) => !empty($id) && is_numeric($id)
            );
            if (!empty($attributeIds)) {
                $createdVariant->attributeValues()->sync(array_values($attributeIds));
            }
        }

        // 3. Sync tags
        if (!empty($tags)) {
            $this->productRepository->syncProductTags($product, $tags);
        } else {
            $product->tags()->detach();
        }

        // 4. Delete images the user removed
        if (!empty($imagesToDelete)) {
            foreach ($imagesToDelete as $imageId) {
                $image = \App\Models\ProductImage::find($imageId);
                if ($image) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($image->path);
                    $image->delete();
                }
            }
        }

        // 5. Upload new images (if any)
        if (!empty($newImages)) {
            $this->imageManager->uploadImages($newImages, $product, 'products', $newMainImageIndex ?? 0);
            // After uploading, unset is_main on all existing images if main comes from new batch
            if ($newMainImageIndex !== null) {
                $product->images()->where('is_main', 1)->update(['is_main' => 0]);
                // imageManager should set is_main on the correct new image
            }
        }

        // 6. Update main flag among existing (surviving) images
        if ($existingMainIndex !== null) {
            $product->refresh();
            // Clear all main flags first
            $product->images()->update(['is_main' => 0]);
            // Set main on the correct existing image
            $survivingIds = collect($existingImages)->pluck('id')->values();
            if (isset($survivingIds[$existingMainIndex])) {
                $product->images()->where('id', $survivingIds[$existingMainIndex])->update(['is_main' => 1]);
            }
        }

        return $product;
    }

}
