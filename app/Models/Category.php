<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use Sluggable , HasTranslations;

    protected $translatable = ["name"];
    protected $fillable = ["name","slug","status","parent","icon"];
    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
//     public function getStatusAttribute(string $status): string{
//         if(app()->getLocale() == 'en'){
//         return $status == '1'?'active': 'inactive';
//     }
//     else{
//         return $status == '1'?'مفعل': 'غير مفعل';
//     }
// }
public function getStatusTranslated(): string{
        if(app()->getLocale() == 'en'){
        return $this->status == '1'?'active': 'inactive';
    }
    else{
        return $this->status == '1'?'مفعل': 'غير مفعل';
    }
}
 public function getNameTranslated(){
        return $this->getTranslation('name', app()->getLocale());
    }
    public function getCreatedAtAttribute($created_at){
        return Carbon::parse($created_at);
    }
    public function getIconAttribute($icon){
        return 'uploads/categories/'.$icon;
    }
public function scopeActive($query)
{
   return $query->where('status',1);
}
public function scopeInactive($query)
{
   return $query->where('status',0);
}
public function children(){
    return $this->hasMany(Category::class,'parent');
}
public function parent(){
    return $this->belongsTo(Category::class,'parent');
}

}
