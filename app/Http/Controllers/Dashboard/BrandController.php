<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\BrandRequest;
use App\Models\Brand;
use App\Services\Dashboard\BrandService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BrandController extends Controller
{
    protected $brandService;
    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.brands.index');
    }
    public function getAll(){
        return $this->brandService->getBrandsForDataTable();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BrandRequest $request)
    {
        $data = $request->only(['name','status','logo']);
        $brand =$this->brandService->createBrand($data);
        if (!$brand){
            Session::flash('error' , __('dashboard.error_msg'));
        }
        Session::flash('success' , __('dashboard.success_msg'));
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $brand =$this->brandService->findById($id);
        return view('dashboard.brands.edit',compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BrandRequest $request, string $id)
    {
        $data = $request->only('name','status','logo');
        $brand =$this->brandService->updateBrand($id,$data);
         if (!$brand){
            Session::flash('error' , __('dashboard.error_msg'));
        }
        Session::flash('success' , __('dashboard.success_msg'));
        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand =$this->brandService->deleteBrand($id);
         if (!$brand){
            Session::flash('error' , __('dashboard.error_msg'));
        }
        Session::flash('success' , __('dashboard.success_msg'));
        return redirect()->back();

    }
}
