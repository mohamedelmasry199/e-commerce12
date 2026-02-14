<?php

namespace App\Models;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use HasTranslations , Sluggable;
     protected $fillable = [
        'name',
        'slug',
        'small_desc',
        'desc',
        'status',
        'sku',
        'available_for',
        'views',
        'has_variants',
        'price',
        'has_discount',
        'discount',
        'start_discount',
        'end_discount',
        'manage_stock',
        'quantity',
        'available_in_stock',
        'category_id',
        'brand_id',
    ];
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    protected $translatable = ['name', 'small_desc', 'desc'];
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function brand(){
        return $this->belongsTo(Brand::class);
    }
    public function variants(){
        return $this->hasMany(ProductVariant::class);
    }
    public function previews(){
        return $this->hasMany(ProductPreview::class);
    }
    public function images(){
        return $this->hasMany(ProductImage::class);
    }



    //treanslations
    public function getStatusTranslated()
    {
        return $this->status == 1
            ? __('dashboard.active')
            : __('dashboard.inactive');
    }
    public function getHasVariantsTranslated()
    {
        return $this->has_variants == 1
            ? __('dashboard.yes')
            : __('dashboard.no');
    }
    public function getHasDiscountTranslated()
    {
        return $this->has_discount == 1
            ? __('dashboard.yes')
            : __('dashboard.no');
    }


    public function isSimple(){
        return !$this->has_variants ;
    }
    // get price after discount if the product has discount and the discount is active
    public function getPriceAfterDiscount(){
        if($this->has_discount == 0 || $this->price == null){
            return $this->price;
        }
        if($this->start_discount != null && $this->end_discount != null){
            $now = now();
            if($now->isBetween($this->start_discount, $this->end_discount)){
                return $this->price - $this->discount ;
            }
        }
        return $this->price;
    }
    //accessors
    public function getCreatedAtAttibute($value){
        return date('Y-m-d', strtotime($value));
    }
    public function getUpdatedAtAttibute($value){
        return date('Y-m-d', strtotime($value));
    }

    // if the product has variants price and quantity will be null
    public function PriceAttribute()
    {
        return $this->has_variants == 0 ? number_format($this->price, 2) : __("dashboard.has_variants");
    }
    public function quantityAttribute()
    {
        return $this->has_variants == 0 ? $this->quantity : __("dashboard.has_variants");
    }
    //other methods
    public function discountPrecentage(){
        if($this->has_discount == 0 || $this->price == null){
            return '🔥';
        }
        return round(($this->discount / $this->price) * 100, 2).' %';
    }
    //scopes:global query modifiers
    public function ScopeActive($query){
        return $query->where('status', 1);
    }
    public function ScopeInActive($query){
        return $query->where('status', 0);
    }



}
