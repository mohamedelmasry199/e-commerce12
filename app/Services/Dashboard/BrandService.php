<?php

namespace App\Services\Dashboard;

use App\Models\Brand;
use App\Repositories\Dashboard\BrandRepository;
use App\Utils\ImageManager;
use Illuminate\Support\Facades\Cache;

class BrandService
{
    /**
     * Create a new class instance.
     */
    protected $brandRepository;
        protected $imageManager;

    public function __construct(BrandRepository $brandRepository ,ImageManager $imageManager)
    {
        $this->brandRepository =$brandRepository;
        $this->imageManager = $imageManager;
    }
    public function getAllBrands(){
        $brands =$this->brandRepository->getAll();
        return $brands;
    }
    public function getBrandsForDataTable(){
        $brands = $this->brandRepository->getAll();
        return datatables($brands)
        ->addIndexColumn()
        ->addColumn('name' , function(Brand $brand){
            return $brand->getTranslation('name',app()->getLocale());
        })
        ->addColumn('logo',function(Brand $brand){
            return view('dashboard.brands.datatables.logo',compact('brand'));
        })
        ->addColumn('status',function(Brand $brand){
            return $brand->getStatusTranslated();
        })
        ->addColumn('action',function(Brand $brand){
            return view('dashboard.brands.datatables.actions',compact('brand'));
        })
        ->make(true);
    }
     public function createBrand($data){
        if(array_key_exists('logo',$data)&&$data['logo']!=Null)
        {
            $data['logo'] = $this->imageManager->uploadSingleImage('/',$data['logo'],'brands');
        }
        $brand = $this->brandRepository->createBrand($data);
        $this->removeFromCache();
        return $brand;
     }
     public function findById($id){
        $brand = $this->brandRepository->findById($id);
        return $brand;
     }
     public function updateBrand($id ,$data){
        $brand =$this->findById($id);
        if(!$brand){
            abort(404);
        }
        if(array_key_exists('logo',$data)&&$data['logo']!=Null){
            $this->imageManager->deleteImageFromLocal($brand->logo);
           $data['logo'] = $this->imageManager->uploadSingleImage('/',$data['logo'],'brands');
        }
        return $this->brandRepository->updateBrand($brand,$data);
     }
      public function deleteBrand($id){
        $brand =$this->findById($id);
        if(!$brand){
            abort(404);
        }
        if ($brand->logo != null) {
        $this->imageManager->deleteImageFromLocal($brand->logo);
        }
       $brand = $this->brandRepository->deleteBrand($brand);
       $this->removeFromCache();
       return $brand;

    }
    public function removeFromCache(){
        Cache::forget('brands_count');
    }
}
