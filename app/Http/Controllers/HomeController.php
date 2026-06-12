<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use App\Services\Website\GeneralService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $generalService;
    public function __construct(GeneralService $generalService)
    {
        $this->generalService =$generalService;
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();
        // $sliders = Slider::all();
        $sliders = $this->generalService->getData(Slider::class);
        $someCategories     = $this->generalService->getData(Category::class,12);
        $someBrands         = $this->generalService->getData(Brand::class,12);
        $homePageProducts   = $this->generalService->getHomePageProducts(12);
        return view('website.index',[
            'sliders'           => $sliders,
            'someCategories'    => $someCategories,
            'someBrands'        => $someBrands,
            'homePageProducts'  => $homePageProducts,
            'user'              => $user

        ]);
        }
    
}
