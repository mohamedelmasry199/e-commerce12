<?php

namespace App\Services\Website;

use App\Repositories\Website\PageRepository;

class PageService
{
    /**
     * Create a new class instance.
     */
    protected $pageRepository;

    public function __construct(PageRepository $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    public function getPages()
    {
        return $this->pageRepository->getPages();
    }
    public function getPage($slug)
    {
        $page = $this->pageRepository->getPage($slug);
        if (!$page) {
            return abort(404);
        }
        return $page;
    }
}
