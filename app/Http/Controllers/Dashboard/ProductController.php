<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Services\Dashboard\BrandService;
use App\Services\Dashboard\CategoryService;
use App\Services\Dashboard\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;
    protected $categoryService;
    protected $brandService;
    /**
     * Display a listing of the resource.
     */
    public function __construct(ProductService $productService ,CategoryService $categoryService, BrandService $brandService)
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
        $this->brandService = $brandService;
    }
    public function index()
    {
        return view('dashboard.products.index');
    }
    public function getAll()
    {
        $products = $this->productService->getAllProducts();
        return $products;
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->categoryService->getAllCategories();
        $brands = $this->brandService->getAllBrands();
        return view('dashboard.products.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */

public function edit($id)
    {
        $product    = $this->productService->getProductByIdWithEagerLoading($id);
        $categories = $this->categoryService->getAllCategories();
        $brands     = $this->brandService->getAllBrands();
        return view('dashboard.products.edit', compact('product', 'categories', 'brands'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $product = $this->productService->deleteProduct($id);
        if (!$product){
            return response()->json(
                ['status'=>'error',
                'message'=>__('dashboard.error_msg')],
                500
            );
        }
        return response()->json([
            'status' => 'success',
            'message' => __('dashboard.success_msg'),
        ], 200);
    }
    public function delete(string $id)
    {
       $product = $this->productService->deleteProduct($id);
        if (!$product){
            return response()->json(
                ['status'=>'error',
                'message'=>__('dashboard.error_msg')],
                500
            );
        }
        return response()->json([
            'status' => 'success',
            'message' => __('dashboard.success_msg'),
        ], 200);
    }
    public function changeStatus(Request $request)
    {
        $product = $this->productService->changeStatus($request->id);
         if (!$product){
            return response()->json(
                ['status'=>'error',
                'message'=>__('dashboard.error_msg')],
                500
            );
        }

        return response()->json([
            'status'=>'success',
            'message'=>__('dashboard.success_msg'),
        ],200);
        return response()->json(['message' => 'Product status changed successfully']);
    }
}
