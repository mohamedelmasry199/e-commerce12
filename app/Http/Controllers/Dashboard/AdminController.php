<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AdminRequest;
use App\Services\Dashboard\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    protected $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = $this->adminService->getAdmins();
        return view('dashboard.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.admins.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminRequest $request)
    {
        $data = $request->only(['name', 'email', 'password', 'role_id', 'status']);
        $admin = $this->adminService->storeAdmin($data);
        if(!$admin){
            Session::flash('error' , __('dashboard.error_msg'));
            return redirect()->back();
        }
        Session::flash('success' , __('dashboard.success_msg'));
        return redirect()->route('dashboard.admins.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $admin = $this->adminService->getAdmin($id);
        if(!$admin){
            Session::flash('error' , __('dashboard.error_msg'));
            return redirect()->back();
        }
        return view('dashboard.admins.show' , compact('admin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $admin = $this->adminService->getAdmin($id);
        if(!$admin){
            Session::flash('error' , __('dashboard.error_msg'));
            return redirect()->back();
        }
        return view('dashboard.admins.edit' , compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $admin = $this->adminService->getAdmin($id);
        if(!$admin){
            Session::flash('error' , __('dashboard.error_msg'));
            return redirect()->back();
        }
        $data = $request->only(['name', 'email', 'password', 'role_id', 'status']);
        $updated = $this->adminService->updateAdmin($admin, $data);
        if(!$updated){
            Session::flash('error' , __('dashboard.error_msg'));
            return redirect()->back();
        }
        Session::flash('success' , __('dashboard.success_msg'));
        return redirect()->route('dashboard.admins.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $admin = $this->adminService->getAdmin($id);
        if(!$admin){
            Session::flash('error' , __('dashboard.error_msg'));
            return redirect()->back();
        }
        $deleted = $this->adminService->destroyAdmin($id);
        if(!$deleted){
            Session::flash('error' , __('dashboard.error_msg'));
            return redirect()->back();
        }
        Session::flash('success' , __('dashboard.success_msg'));
        return redirect()->route('dashboard.admins.index');
    }
    public function changeStatus(Request $request, string $id)
    {
        $admin = $this->adminService->getAdmin($id);
        if(!$admin){
            Session::flash('error' , __('dashboard.error_msg'));
            return redirect()->back();
        }
        $status = $request->input('status');
        $changed = $this->adminService->changeStatus($id, $status);
        if(!$changed){
            Session::flash('error' , __('dashboard.error_msg'));
            return redirect()->back();
        }
        Session::flash('success' , __('dashboard.success_msg'));
        return redirect()->route('dashboard.admins.index');
    }
}
