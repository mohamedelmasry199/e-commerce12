<?php

namespace App\Services\Website;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class GeneralService
{
    /**
     * Create a new class instance.
     */
    protected $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

public function getData(string $model, ?int $limit = null)
{
    $query = $model::query();

    if (method_exists($model, 'scopeActive')) {
        $query->active();
    }

    return $limit
        ? $query->limit($limit)->get()
        : $query->get();
}
 public function getProductsByBrand($slug, $limit = 9)
    {
        $brand_id = Brand::where('slug', $slug)->first()->id;

        return Product::with('images', 'brand', 'category','variants')
            ->active()
            ->latest()
            ->select('id', 'name', 'slug', 'has_variants', 'brand_id', 'category_id')
            ->where('brand_id', $brand_id)
            ->paginate($limit);
    }
    public function getProductsByCategory($slug, $limit = 9)
    {
        $category_id = Category::where('slug', $slug)->first()->id;

        return Product::with('images', 'brand', 'category','variants')
            ->active()
            ->latest()
            ->select('id', 'name', 'desc', 'slug', 'has_variants', 'brand_id', 'category_id')
            ->where('category_id', $category_id)
            ->paginate($limit);
    }

   public function getHomePageProducts($limit = null): array
    {
        return [
            'newArriavals'       => $this->productService->newArrivalsProducts($limit),
            'flashProducts'      => $this->productService->getFlashProducts($limit),
            'flashProductsTimer' => $this->productService->getFlashProductsWithTimer($limit),
            // 'topSellingProducts' => $this->productService->getTopSellingProducts($limit),
        ];
    }
}
