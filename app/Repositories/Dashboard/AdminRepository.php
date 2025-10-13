<?php

namespace App\Repositories\Dashboard;

use App\Models\Admin;

class AdminRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
        public function getAdmins(){
            $admins = Admin::with('role')->select('id','name','email','created_at','status','role_id')->get();
            return $admins;
        }

        public function getAdmin($id){
            $admin = Admin::with('role')->find($id);
            return $admin;
        }
        public function storeAdmin($data){
            $admin = Admin::create($data);
            return $admin;
        }

        public function updateAdmin($admin, $data){
            $admin->update($data);
            return $admin;
        }

        public function destroyAdmin($admin){
            return $admin->delete();;
        }

        public function changeStatus($admin, $status){
            $admin->status = $status;
            $admin->save();
            return $admin;
        }

}
