<?php

namespace App\Http\Controllers\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\Website\GeneralService;

class CategoryController extends Controller
{
    protected $generalService;
    public function __construct(GeneralService $generalService)
    {
        $this->generalService = $generalService;
    }

    public function getCategories()
    {
        $categories = $this->generalService->getData(Category::class);
        return view('website.categories', compact('categories'));
    }

    public function getProductsByCategory($slug)
    {
        $products = $this->generalService->getProductsByCategory($slug);
        return view('website.products', ['products' => $products, 'flash_timer' => false]);
    }
}
