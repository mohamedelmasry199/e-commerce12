<?php

namespace App\Repositories\Dashboard;

use App\Models\Contact;

class ContactRepository
{
    public function getAll()
    {
        return Contact::get();
    }
    public function getUser($id)
    {
        return Contact::find($id);
    }

    public function storeUser($data)
    {
       return Contact::create($data);
    }

    public function updateUser($data, $contact)
    {
        return $contact->update($data);
    }

    public function destroy($contact)
    {
        return $contact->delete();
    }

    public function changeStatus($contact , $status)
    {
        return $contact->update([
            'is_active'=>$status,
        ]);
    }

}
