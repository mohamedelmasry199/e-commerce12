<?php

namespace App\Http\Controllers\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Services\Website\GeneralService;

class BrandController extends Controller
{
    protected $generalService;
    public function __construct(GeneralService $general_service)
    {
        $this->generalService = $general_service;
    }
    public function getBrands()
    {
        $brands = $this->generalService->getData(Brand::class);
        return view('website.brands',compact('brands'));
    }

    public function getProductsByBrand($slug)
    {
        $products = $this->generalService->getProductsByBrand($slug);
        return view('website.products', ['products' => $products, 'flash_timer' => false]);
    }

}
