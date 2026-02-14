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
     public function createProductWithDetails($ProductData, $productVariant, $images)
    {
        // dd($ProductData, $productVariant, $images);
        // create Product
        // dd($ProductData);
        $product = $this->productRepository->createProduct($ProductData);
        // create Product Variant
        foreach ($productVariant as $variant) {

            $variant['product_id'] = $product->id;
            $productVariant = $this->productRepository->createProductVariant($variant);

            // create Variant Attributes
            foreach ($variant['attriubte_value_ids'] as $attribute_value_id) {
                $this->productRepository->createProductVariantAttribute([
                    'product_variant_id' => $productVariant->id,
                    'attribute_value_id' => $attribute_value_id,
                ]);
            }
        }
        // dd($images);

        // create Product Images
        $this->imageManager->uploadImages($images, $product, 'products');
    }
}
