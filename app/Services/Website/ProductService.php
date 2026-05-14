<?php

namespace App\Services\Website;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class ProductService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public function getProductBySlug($slug)
    {
        $product = Product::with('images', 'brand', 'category', 'productReviews', 'variants')
            ->select('id', 'name', 'desc', 'small_desc', 'slug', 'has_variants', 'brand_id', 'category_id')
            ->where('slug', $slug)
            ->active()
            ->first();
        if (!$product) {
            return abort(404);
        }
        return $product;
    }
    public function getCategoryProducts($category_id, $limit = null)
    {
        $products = Category::findOrFail($category_id)
            ->products()
            ->with(['images', 'brand', 'category', 'variants'])
            ->select(
                'id',
                'name',
                'slug',
                'has_variants',
                'brand_id',
                'category_id'
            )
            ->active()
            ->latest();
        if (!$limit) {
            return $products->get();
        }
        return $products->paginate($limit);
    }
    public function getRelatedProductsBySlug($slug, $limit = null)
    {
        $categoryId = Product::whereSlug($slug)->first()->category_id;
        $products   = Product::with('images', 'brand', 'category','variants')
            ->select('id', 'name', 'slug', 'has_variants', 'brand_id', 'category_id')
            ->whereCategoryId($categoryId)
            ->where('slug', '!=', $slug)
            ->active()
            ->latest();

        if ($limit) {
            return $products->paginate($limit);
        }
        return $products->paginate(30);
    }
    public function newArrivalsProducts($limit = null)
    {
        $products = Product::query()->with('images', 'brand', 'category', 'variants')
            ->active()
            ->latest()
            ->select('id', 'name', 'slug', 'has_variants', 'brand_id', 'category_id');
        if (!$limit) {
            return $products->get();
        }
        return $products->paginate($limit);
    }
    public function getFlashProducts($limit = null)
{
    $products = Product::query()
        ->with([
            'images', 'brand', 'category',
            'variants' => fn($q) => $q->activeDiscount()
        ])
        ->active()
        ->whereHas('variants', fn($q) => $q->activeDiscount())
        ->latest()
        ->select('id', 'name', 'slug', 'has_variants', 'brand_id', 'category_id');
    return $limit ? $products->paginate($limit) : $products->get();
}

    public function getFlashProductsWithTimer($limit = null)
    {
        $products = Product::query()->with(['images', 'brand', 'category',
         'variants' => fn($q) => $q->activeDiscount()])
            ->active()
            ->where('available_for', date('Y-m-d'))->whereNotNull('available_for')
             ->whereHas('variants', fn($q) => $q->activeDiscount())
->latest()
            ->select('id', 'name', 'slug', 'has_variants', 'brand_id', 'category_id');
        if (!$limit) {
            return $products->get();
        }
        // dd($products->get());
        return $products->paginate($limit);
    }
}
