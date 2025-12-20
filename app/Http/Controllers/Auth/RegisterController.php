<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // Show register form
    public function create()
    {
        return view('authentication.register');
    }

    // Store user
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'unique_name' => 'required|string|max:255|unique:users,unique_name',
            'mobile'      => 'required|digits:10|unique:users,mobile',
            'dob'         => 'required|date',
            'password'    => 'required|min:6',
            'agree' => 'accepted',
        ]);

        User::create([
            'name'        => $request->name,
            'unique_name' => $request->unique_name,
            'mobile'      => $request->mobile,
            'dob'         => $request->dob,
            'password'    => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Registration successful');
    }
}
