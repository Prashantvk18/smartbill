<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    // Show login form
    public function create()
    {
        return view('authentication.login');
    }

    // Handle login
    public function store(Request $request)
    {
        $request->validate([
            'unique_name' => 'required',
            'password' => 'required',
            'agree' => 'accepted',
        ]);

        if (Auth::attempt([
            'unique_name' => $request->unique_name,
            'password' => $request->password
        ])) {
            return redirect('/dashboard');
        }

        return back()->with('error', 'Invalid credentials');
    }

    // Logout
    public function logout()
        {
            Auth::logout();
            return redirect('/');
        }

}
