<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id',
        'price',
        'manage_stock',
        'stock',
        'sku',
        'has_discount',
        'discount',
        'start_discount',
        'end_discount',
    ];
    public function product(){
        return $this->belongsTo(Product::class);
    }
       public function VariantAttributes()
    {
        return $this->hasMany(VariantAttribute::class);
    }
      public function attributeValues()
    {
        return $this->belongsToMany(
            AttributeValue::class,
            'variant_attributes',    // pivot table name
            'product_variant_id',    // foreign key on pivot table
            'attribute_value_id'     // related key on pivot table
        )->withTimestamps();
    }

       public function getHasDiscountTranslated()
    {
        return $this->has_discount == 1
            ? __('dashboard.yes')
            : __('dashboard.no');
    }
        // get price after discount if the product has discount and the discount is active
       public function getPriceAfterDiscount(){
        if($this->has_discount == 0 || $this->price == null){
            return $this->price;
        }
        if($this->start_discount != null && $this->end_discount != null){
            $now = now();
            if($now->betweenIncluded($this->start_discount, $this->end_discount)){
                return $this->price - $this->discount ;
            }
        }
        return $this->price;
    }

       public function PriceAttribute()
    {
        return $this->has_variants == 0 ? number_format($this->price, 2) : __("dashboard.has_variants");
    }
    public function stockAttribute()
    {
        return $this->has_variants == 0 ? $this->stock : __("dashboard.has_variants");
    }
    //other methods
    public function discountPrecentage(){
        if($this->has_discount == 0 || $this->price == null){
            return '🔥';
        }
        return round(($this->discount / $this->price) * 100, 2).' %';
    }
    public function isAvailable(){
        if($this->manage_stock == 0){
            return true;
        }
        return $this->stock > 0;
    }
}
