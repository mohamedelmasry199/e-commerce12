<?php

namespace App\Services\Dashboard;

use App\Models\Category;
use App\Repositories\Dashboard\CategoryRepository;
use Illuminate\Support\Facades\Cache;
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
        ->addColumn('status', function (Category $category) {
                    return $category->getStatusTranslated();

        }
        )
         ->addColumn("action", function ($category) {
            return view('dashboard.categories.datatables.actions', compact('category'));
         }
         )
        ->make(true);
    }
    public function getParentCategories(){
        $categories = $this->categoryRepository->getParentCategories();
        return $categories;
    }
    public function createCategory($data){
        $category = $this->categoryRepository->createCategory($data);
        $this->removeFromCache();
        return $category;
    }
    public function findById($id){
        $category = $this->categoryRepository->findById($id);
        return $category;
}
public function getParentCategoriesExceptThis($id){
    $categories = $this->categoryRepository->getParentCategoriesExceptThis($id);
    return $categories;
}
public function updateCategory($id, $data){
    $category = $this->categoryRepository->findById($id);
    if(!$category){
        return false;
    }
    return $this->categoryRepository->updateCategory($category,$data);
}
public function deleteCategory($id){
    $category = $this->categoryRepository->findById($id);
    if(!$category){
        return false;
    }
    $category = $this->categoryRepository->deleteCategory($category);
    $this->removeFromCache();
    return $category;
}
public function removeFromCache(){
    Cache::forget('categories_count');
}
}
