<?php

namespace App\Services\Dashboard;

use App\Models\Category;
use App\Repositories\Dashboard\CategoryRepository;
use App\Utils\ImageManager;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\Facades\DataTables;

class CategoryService
{

    /**
     * Create a new class instance.
     */
    protected $categoryRepository, $imageManager;
    public function __construct(CategoryRepository $categoryRepository, ImageManager $imageManager)
    {
        $this->categoryRepository = $categoryRepository;
        $this->imageManager = $imageManager;
    }

    public function getCategoriesForDataTable()
    {
        $categories = $this->categoryRepository->getAll();
        return DataTables::of($categories)
            ->addIndexColumn()
            ->addColumn(
                'name',
                function (Category $category) {
                    return $category->getTranslation('name', app()->getLocale());
                }
            )
            ->addColumn(
                'status',
                function (Category $category) {
                    return $category->getStatusTranslated();
                }
            )
            ->addColumn('icon', function (Category $category) {
                return view('dashboard.categories.datatables.icon', compact('category'));
            })
            ->addColumn(
                "action",
                function ($category) {
                    return view('dashboard.categories.datatables.actions', compact('category'));
                }
            )
            ->make(true);
    }
    public function getAllCategories()
    {
        $categories = $this->categoryRepository->getAll();
        return $categories;
    }
    public function getParentCategories()
    {
        $categories = $this->categoryRepository->getParentCategories();
        return $categories;
    }
    public function createCategory($data)
    {
        if (array_key_exists('icon', $data)  && $data['icon'] != null) {
            $file_name = $this->imageManager->uploadSingleImage('/', $data['icon'], 'categories');
            $data['icon'] = $file_name;
        }
        $category = $this->categoryRepository->createCategory($data);
        $this->removeFromCache();
        return $category;
    }
    public function findById($id)
    {
        $category = $this->categoryRepository->findById($id);
        return $category;
    }
    public function getParentCategoriesExceptThis($id)
    {
        $categories = $this->categoryRepository->getParentCategoriesExceptThis($id);
        return $categories;
    }
    public function updateCategory($id, $data)
    {
        $category = $this->categoryRepository->findById($id);
        if (array_key_exists('icon', $data)  && $data['icon'] != null) {
            if ($category->icon != null) {
                $this->imageManager->deleteImageFromLocal($category->icon);
            }
            $file_name = $this->imageManager->uploadSingleImage('/', $data['icon'], 'categories');
            $data['icon'] = $file_name;
        }
        if (!$category) {
            return false;
        }
        return $this->categoryRepository->updateCategory($category, $data);
    }
    public function deleteCategory($id)
    {
        $category = $this->categoryRepository->findById($id);
        if (!$category) {
            return false;
        }
        $this->imageManager->deleteImageFromLocal($category->icon);
        $category = $this->categoryRepository->deleteCategory($category);
        $this->removeFromCache();
        return $category;
    }
    public function removeFromCache()
    {
        Cache::forget('categories_count');
    }
}
