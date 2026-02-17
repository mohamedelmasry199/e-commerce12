<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class ProductTag extends Model
{
protected $table = 'product_tags';
    protected $guarded = [];
    public $timestamps = false;
}
