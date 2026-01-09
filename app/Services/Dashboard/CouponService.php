<?php

namespace App\Services\Dashboard;

use App\Models\Coupon;
use App\Repositories\Dashboard\CouponRepository;
use Illuminate\Support\Facades\Cache as Cache;

class CouponService
{
   protected $couponRepository;

    public function __construct(CouponRepository $couponRepository)
    {
        $this->couponRepository =$couponRepository;
    }
    public function getAllCoupons(){
        $coupons =$this->couponRepository->getAll();
        return $coupons;
    }
    public function getCouponsForDataTable(){
        $coupons = $this->couponRepository->getAll();
        return datatables($coupons)
        ->addIndexColumn()
        ->addColumn('status',function(Coupon $coupon){
            return $coupon->status();
        })
        ->addColumn('action',function(Coupon $coupon){
            return view('dashboard.coupons.datatables.actions',compact('coupon'));
        })
        ->make(true);
    }
     public function createCoupon($data){

        $coupon = $this->couponRepository->createCoupon($data);
        $this->removeFromCache();
        return $coupon;
     }
     public function findById($id){
        $coupon = $this->couponRepository->findById($id);
        if(!$coupon){
            abort(404);
        }
        return $coupon;
     }
     public function updateCoupon($id ,$data){
        $coupon =$this->findById($id);
        if(!$coupon){
            abort(404);
        }

        return $this->couponRepository->updateCoupon($coupon,$data);
     }
      public function deleteCoupon($id){
        $coupon =$this->findById($id);
        if(!$coupon){
            abort(404);
        }

       $coupon = $this->couponRepository->deleteCoupon($coupon);
       $this->removeFromCache();
       return $coupon;

    }
    public function removeFromCache(){
        Cache::forget('coupons_count');
    }
    public function changeStatus($id){
        $coupon = $this->findById($id);
        if(!$coupon){
            abort(404);
        }
        $coupon = $this->couponRepository->updateCoupon($coupon,[
            'is_active' => !$coupon->is_active,
        ]);
        return $coupon;
    }
}
