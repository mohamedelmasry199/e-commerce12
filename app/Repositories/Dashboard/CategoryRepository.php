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
}
