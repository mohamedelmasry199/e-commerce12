<?php

namespace App\Repositories\Dashboard;

use App\Models\Brand;

class BrandRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public function getAll(){
        $brands = Brand::withCount('products')->get();
        return $brands;
    }
    public function createBrand($data){
        $brand = Brand::create($data);
        return $brand;
    }
    public function findById($id){
        $brand =Brand::find($id);
        if(!$brand){
            abort(404);
        }
        return $brand;
    }
    public function updateBrand($brand ,$data){
        $brand->update($data);
        return $brand;
     }
     public function deleteBrand($brand){

        return $brand->delete();

    }
}
