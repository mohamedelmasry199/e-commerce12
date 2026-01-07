<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Faq extends Model
{
    use HasTranslations ,HasFactory;
    protected $translatable = ['question','answer'];
    protected $fillable = ['question','answer'];
    public $timestamps = false;
}
