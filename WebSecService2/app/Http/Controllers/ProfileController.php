<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Add this line to import the User model

class ProfileController extends Controller
{
    public function __construct()
{
    $this->middleware('auth');
}


    public function show()
    {
        return view('profile', ['user' => Auth::user()]);
    }

    public function updatePassword(Request $request)
{
    $request->validate([
        'old_password' => 'required',
        'new_password' => 'required|min:6|confirmed',
    ]);

    dd($request->all()); // هذه السطر سيطبع جميع البيانات المرسلة
}

}

