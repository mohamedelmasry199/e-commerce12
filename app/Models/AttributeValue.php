<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class AttributeValue extends Model
{
    use HasTranslations;
    protected $fillable = ['attribute_id', 'value','created_at', 'updated_at'];
    protected $translatable =['value'];
    protected $table = 'attribute_values';
    public $timestamps = false;

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return date('d-m-Y H:i:s', strtotime($value));
    }
}
