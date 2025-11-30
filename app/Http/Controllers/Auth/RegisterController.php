<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Buat user_profile default
        \App\Models\UserProfile::create([
            'user_id' => $user->id,
            'level' => 1,
            'total_xp' => 0,
            'role' => 'member',
            'bio' => null,
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil, silakan login!');
    }
}
