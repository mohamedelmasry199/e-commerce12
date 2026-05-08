<?php

namespace App\Repositories\Website;

use App\Models\Page;

class PageRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public function getPages()
    {
        return Page::select('id', 'title','slug')->get();
    }

    public function getPage($slug)
    {
        return Page::where('slug', $slug)->first();
    }
}
