<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CategoryRequest;
use App\Models\Category;
use App\Services\Dashboard\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session as Session;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    protected $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("dashboard.categories.index");
    }
    public function getAll(){
        return $this->categoryService->getCategoriesForDataTable();

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->categoryService->getParentCategories();
        return view('dashboard.categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $data = $request->only(['name','status','parent', 'icon']);

        $category = $this->categoryService->createCategory($data);
        if(!$category){
            Session::flash('error' , __('dashboard.error_msg'));
        }
        else{
        Session::flash('success' , __('dashboard.success_msg'));
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = $this->categoryService->findById($id);
        if(!$category){
            Session::flash('error' , __('dashboard.error_msg'));
            return redirect()->back();
        }
        $categories = $this->categoryService->getParentCategoriesExceptThis($id);
        return view('dashboard.categories.edit', compact('category','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request , string $id)
    {
        $data = $request->only(['name','status','parent','icon']);
        $category = $this->categoryService->updateCategory($request->id, $data);
        if(!$category){
            Session::flash('error' , __('dashboard.error_msg'));
        }
        Session::flash('success' , __('dashboard.success_msg'));
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = $this->categoryService->deleteCategory($id);
        if(!$category){
            Session::flash('error' , __('dashboard.error_msg'));
        }
        else{
        Session::flash('success' , __('dashboard.success_msg'));
        }
        return redirect()->back();
    }
}
