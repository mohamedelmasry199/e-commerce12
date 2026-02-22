<?php

namespace App\Repositories\Dashboard;

use App\Models\Product;
use App\Models\ProductTag;
use App\Models\ProductVariant;
use App\Models\Tag;
use App\Models\VariantAttribute;

class ProductRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public function getAllProducts()
    {
        return Product::with(['brand', 'category', 'variants.attributeValues', 'tags','images'])->get();
    }
    public function getProductByIdWithEagerLoading($id)
    {
        return Product::with(['brand', 'category', 'variants.attributeValues', 'tags','images'])->findOrFail($id);
    }
    public function getProductById($id)
    {
        return Product::findOrFail($id);
    }
    public function createProduct($data)
    {
        return Product::create($data);
    }
    public function createProductVariant($data)
    {
        return ProductVariant::create($data);
    }
    public function createProductVariantAttribute($data)
    {
        return VariantAttribute::create($data);
    }
    public function createProuctTags($data, $product)
    {
      foreach ($data as $tagSlug) {
            $tag = $this->createOrGetTag($tagSlug, $product);
        }
    }
    public function createOrGetTag($tagSlug, $product)
    {
        $tag = Tag::where('slug', $tagSlug)->first();
        if (!$tag) {
            $tag = Tag::create(['slug' => $tagSlug]);
        }
        $product->tags()->attach($tag->id);
        return $tag;
    }
    public function changeStatus($product)
    {
        $product->status = !$product->status;
        $product->save();
        return $product;
    }
    public function deleteProduct($product)
    {
        
        return $product->delete();
    }
}


