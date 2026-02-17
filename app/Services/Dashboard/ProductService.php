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
