<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show($id)
    {
        $user = auth()->user();
        if ($user->id != $id) {
            abort(403);
        }
        return view('website.auth.profile', compact('user'));
    }
}
