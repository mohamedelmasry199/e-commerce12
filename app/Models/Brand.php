<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Brand extends Model
{
    use Sluggable, HasTranslations ;
    protected $fillable = ['name','slug','status','logo'];
    protected $translatable = ['name'];

    public function products(){
        return $this->hasMany(Product::class);
    }
     public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
  public function getStatusTranslated()
    {
    return $this->status == 1
        ? __('dashboard.active')
        : __('dashboard.inactive');
    }
    public function getLogoAttribute($logo){
        return 'uploads/brands/'.$logo;
    }
     public function getNameTranslated(){
        return $this->getTranslation('name', app()->getLocale());
    }

}
