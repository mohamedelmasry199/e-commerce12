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
            ->addColumn('small_desc', function ($product) {
                return $product->getSmallDescTranslated();
            })
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
            ->addColumn('tags', function ($product) {
                return $product->tags->pluck('slug')->implode(', ');
            })
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
}
