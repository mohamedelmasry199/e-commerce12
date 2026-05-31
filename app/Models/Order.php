<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

        protected $fillable = [
        'user_id',
        'user_name',
        'user_phone',
        'user_email',
        'price',
        'shipping_price',
        'total_price',
        'note',
        'status',
        'country',
        'governorate',
        'city',
        'street',
        'coupon',
        'coupon_discount',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function items(){
        return $this->hasMany(OrderItem::class);
    }
    public function transaction(){
        return $this->hasOne(Transaction::class);
    }


}
