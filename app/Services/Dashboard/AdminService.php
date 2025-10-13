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
        return $this->adminRepository->getAdmins();
    }
    public function getAdmin($id){
        return $this->adminRepository->getAdmin($id);
    }

    public function storeAdmin($data){
        return $this->adminRepository->storeAdmin($data);
    }

    public function updateAdmin($id, $data){
        $admin = $this->adminRepository->getAdmin($id);
        if ($admin) {
            return $this->adminRepository->updateAdmin($admin, $data);
        }
        return null;
    }

    public function destroyAdmin($id){
        $admin = $this->adminRepository->getAdmin($id);
        if ($admin) {
            return $this->adminRepository->destroyAdmin($admin);
        }
        return null;
    }

    public function changeStatus($id, $status){
        $admin = $this->adminRepository->getAdmin($id);
        if ($admin) {
            return $this->adminRepository->changeStatus($admin, $status);
        }
        return null;

    }

}
