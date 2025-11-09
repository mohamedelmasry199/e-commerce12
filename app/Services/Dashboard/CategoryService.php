<?php

namespace App\Services\Dashboard;

use App\Models\Category;
use App\Repositories\Dashboard\CategoryRepository;
use Yajra\DataTables\Facades\DataTables;

class CategoryService
{
    /**
     * Create a new class instance.
     */
    protected $categoryRepository;
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    public function getCategoriesForDataTable(){
        $categories = $this->categoryRepository->getAll();
         return DataTables::of($categories)
        ->addIndexColumn()
        ->addColumn('name', function (Category $category) {
            return $category->getTranslation('name',app()->getLocale());
        }
        )
         ->addColumn("action", function ($category) {
            return view('dashboard.categories.datatables.actions', compact('category'));
         }
         )
        ->make(true);

    }
}
