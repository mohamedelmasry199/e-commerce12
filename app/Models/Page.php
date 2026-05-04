<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Page extends Model
{
    use HasTranslations,Sluggable;

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'is_active',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];
    protected $translatable = [
        'title',
        'content',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];
}
