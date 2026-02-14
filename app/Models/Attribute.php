<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Attribute extends Model
{
    use HasTranslations;

    protected $fillable = ['name','created_at', 'updated_at'];
    public $translatable = ['name'];


    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class);
    }
    public function getCreatedAtAttribute($value)
    {
        return date('d-m-Y H:i:s', strtotime($value));
    }
}
