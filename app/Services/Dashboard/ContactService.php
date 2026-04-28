<?php

namespace App\Services\Dashboard;

use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Dashboard\ContactRepository;

class ContactService
{
     /**
     * Create a new class instance.
     */
    protected $userRepository;
    public function __construct(ContactRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function getContactsForDatatable()
    {
        $users = $this->userRepository->getAll();
        return DataTables::of($users)
        ->addIndexColumn()
        ->addColumn('is_active' , function ($user){
            return $user->getStatusTranslated();
        })
        ->addColumn('country' , function($user){
            return $user->country->name;
        })
        ->addColumn('governorate' , function($user){
            return $user->governorate->name;
        })
        ->addColumn('city' , function($user){
            return $user->city->name;
        })
        // ->addColumn('num_of_orders' , function($user){
        //     return $user->orders()->count() > 0 ? $user->orders()->count() : __('dashboard.not_found');
        // })
         ->addColumn('num_of_orders' , function($user){
            return 0;
        })
        ->addColumn('action', function ($user) {
           return view('dashboard.users.datatables.actions'  ,compact('user'));
        })

        ->make(true);
    }
    public function getContact($id)
    {
        $user = $this->userRepository->getContact($id);
        if(!$user){
           return false;
        }
        return $user;
    }

    public function storeContact($data)
    {
        $user = $this->userRepository->storeContact($data);
        if(!$user){
            return false;
        }
        return $user;

    }

    public function updateContact($data, $id)
    {
        $user = $this->userRepository->getContact($id);
        if(!$user){
            abort(404);
        }
        if($data['password'] == null){
            unset($data['password']);
        }

        $user = $this->userRepository->updateContact($data,$user);
        if(!$user){
            return false;
        }
        return $user;
    }

    public function deleteContact($id)
    {
        $user = $this->userRepository->getContact($id);
        if(!$user){
            return false;
        }
        return $this->userRepository->destroy($user);

    }

    public function changeStatus($id)
    {
        $user = $this->userRepository->getContact($id);
        if(!$user){
            return false;
        }
        $user->is_active == 1? $status = 0 : $status = 1;
        return $this->userRepository->changeStatus($user, $status);
    }
}
