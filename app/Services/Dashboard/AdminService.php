<?php

namespace App\Services\Dashboard;

use App\Repositories\Dashboard\AdminRepository;

class AdminService
{
    protected $adminRepository;
    /**
     * Create a new class instance.
     */
    public function __construct(AdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    public function getAdmins(){
        $admins = $this->adminRepository->getAdmins();
        if(!$admins){
            return [];
        }
        return $admins;
    }
    public function getAdmin($id){
        $admin= $this->adminRepository->getAdmin($id);
        if(!$admin){
            abort(404);
        }
        return $admin;
    }

    public function storeAdmin($data){
        $admin = $this->adminRepository->storeAdmin($data);
        if(!$admin){
            return false;
        }
        return $admin;

    }

    public function updateAdmin($id, $data){
        $admin = $this->adminRepository->getAdmin($id);
        if(!$admin){
            abort(404);
        }
            if($data['password'] == null){
                unset($data['password']);
            }
            return $this->adminRepository->updateAdmin($admin, $data);

    }

    public function destroyAdmin($id){
        $admin = $this->adminRepository->getAdmin($id);
        if (!$admin) {
            return false;
        }
        return $this->adminRepository->destroyAdmin($admin);
    }

    public function changeStatus($id,){
        $admin = $this->adminRepository->getAdmin($id);
        if (!$admin) {
            return false;
        }
        return $this->adminRepository->changeStatus($admin);

    }

}
