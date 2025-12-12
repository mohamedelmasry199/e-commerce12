<?php

namespace App\Repositories\Dashboard;

use App\Models\Category;

class CategoryRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public function getAll(){
        return Category::all();
    }
    public function findById($id){
        return Category::find($id);
    }
    public function getParentCategories(){
        $categories = Category::whereNull("parent")->get();
        return $categories;
    }
    public function createCategory($data){
        $category = Category::create($data);
        return $category;
    }
    public function getParentCategoriesExceptThis($id){
        $categories = Category::whereNull("parent")
        ->where('id','!=', $id)
        ->get();
        return $categories;
    }
    public function updateCategory($category,$data){
       $category = $category->update($data);
       return $category;
}
public function deleteCategory($category){
   $category = $category->delete();
   return $category;
}


}
