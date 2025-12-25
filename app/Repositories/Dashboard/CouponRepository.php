<?php

namespace App\Repositories\Dashboard;

use App\Models\Coupon;

class CouponRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public function getAll()
    {
        return Coupon::latest()->get();
    }
    public function findById($id)
    {
        return Coupon::find($id);
    }

    public function createCoupon($data)
    {
        $coupon = Coupon::create($data);
        return $coupon;
    }

   public function updateCoupon($coupon, $data)
    {
        $coupon = $coupon->update($data);
        return $coupon;
    }
    public function deleteCoupon($coupon)
    {
        $coupon = $coupon->delete();
        return $coupon;
    }

}
