<?php

namespace App\Services\Dashboard;

use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Dashboard\PageRepository;
use App\Utils\ImageManager;

class PageService
{
    protected $pageRepository, $imageManager;

    public function __construct(PageRepository $pageRepository , ImageManager $imageManager)
    {
        $this->pageRepository = $pageRepository;
        $this->imageManager = $imageManager;
    }
    public function getPages() // new
    {
        return $this->pageRepository->getPages();
    }
    public function getPagesForDatatables()
    {

        $pages = $this->pageRepository->getPages();
        return DataTables::of($pages)
            ->addIndexColumn()
            ->addColumn('title', function ($page) {
                return $page->getTranslation('title', app()->getLocale());
            })
             ->addColumn('content', function ($page) {
                return view('dashboard.pages.datatables.content', compact('page'));
            })
            ->addColumn('image', function ($page) {
                return view('dashboard.pages.datatables.image', compact('page'));
            })
            ->addColumn('action', function ($page) {
                return view('dashboard.pages.datatables.action', compact('page'));
            })
            ->rawColumns(['content','image', 'action'])
            ->make(true);
    }

    public function getPage($id)
    {
        return $this->pageRepository->getPage($id);
    }

    public function createPage($data)
    {
        if(array_key_exists('image', $data)  && $data['image'] != null){
            $image = $this->imageManager->uploadSingleImage('/' , $data['image'] , 'pages');
            $data['image'] = $image;
        }
        return $this->pageRepository->createPage($data);
    }
    public function updatePage($id, $data)
    {
        $page = $this->getPage($id);
        if(!$page){
            return false;
        }

        if(array_key_exists('image', $data)  && $data['image'] != null){
            if ($page->image != null) {
                $this->imageManager->deleteImageFromLocal($page->image);
            }
            $image = $this->imageManager->uploadSingleImage('/' , $data['image'] , 'pages');
            $data['image'] = $image;
        }

        return $this->pageRepository->updatePage($page, $data);
    }


    public function deletePage($id)
    {
       if(!$page = $this->getPage($id)){
           return false;
        };

        if ($page->image != null) {
            $this->imageManager->deleteImageFromLocal($page->image);
        }
        return $this->pageRepository->deletePage($page);
    }

}
