<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Services\Website\PageService;
use Illuminate\Http\Request;

class PageController extends Controller
{
    protected $pageService;
        public function __construct(PageService $pageService)
        {
            $this->pageService = $pageService;
        }
    public function show($slug)
    {
        $page = $this->pageService->getPage($slug);
        return view('website.dynamic-page', compact('page'));
    }
}
