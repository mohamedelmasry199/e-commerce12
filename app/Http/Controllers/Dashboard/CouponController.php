<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CouponRequest;
use App\Services\Dashboard\CouponService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CouponController extends Controller
{

    protected $couponService;
    public function __construct(CouponService $couponService)
    {
        $this->couponService = $couponService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.coupons.index');
    }
    public function getAll(){
        return $this->couponService->getCouponsForDataTable();
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
    public function store(CouponRequest $request)
    {
        $data = $request->all();
        $coupon =$this->couponService->createCoupon($data);
        if (!$coupon){
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
        $coupon =$this->couponService->findById($id);
        return view('dashboard.coupons.edit',compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CouponRequest $request, string $id)
    {
        $data = $request->all();
        $coupon =$this->couponService->updateCoupon($id,$data);
         if (!$coupon){
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

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $coupon =$this->couponService->deleteCoupon($id);
         if (!$coupon){
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

    }
    public function changeStatus($id)
    {
        $coupon = $this->couponService->changeStatus($id);
        if (!$coupon){
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
    }
}
