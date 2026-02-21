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
        'available_for',
        'views',
        'has_variants',
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
    public function reviews(){
        return $this->hasMany(ProductReview::class);
    }
    public function images(){
        return $this->hasMany(ProductImage::class);
    }
 public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tags', 'product_id', 'tag_id');
    }


    //treanslations
    public function getStatusTranslated()
    {
        return $this->status == 1
            ? __('dashboard.active')
            : __('dashboard.inactive');
    }
    public function getNameTranslated(){
        return $this->getTranslation('name', app()->getLocale());
    }

    public function getSmallDescTranslated(){
        return $this->getTranslation('small_desc', app()->getLocale());
    }
    public function getDescTranslated(){
        return $this->getTranslation('desc', app()->getLocale());
    }
    public function getHasVariantsTranslated()
    {
        return $this->has_variants == 1
            ? __('dashboard.yes')
            : __('dashboard.no');
    }



    public function isSimple(){
        return !$this->has_variants ;
    }

    //accessors
    public function getCreatedAtAttibute($value){
        return date('Y-m-d', strtotime($value));
    }
    public function getUpdatedAtAttibute($value){
        return date('Y-m-d', strtotime($value));
    }

    // if the product has variants price and quantity will be null

    //scopes:global query modifiers
    public function ScopeActive($query){
        return $query->where('status', 1);
    }
    public function ScopeInActive($query){
        return $query->where('status', 0);
    }



}
