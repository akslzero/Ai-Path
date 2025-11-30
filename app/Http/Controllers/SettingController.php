<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\UserProfile;

class SettingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profile = $user->profile ?? null;

        return view('setting', compact('user', 'profile'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
        ]);

        $user = Auth::user(); // instance model
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save(); // aman

        return redirect()->back()->with('success_profile', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Password lama salah']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success_password', 'Password updated successfully!');
    }

    public function uploadPicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        $profile = $user->profile ?? $user->profile()->create([]); // instance UserProfile

        if ($request->hasFile('profile_picture')) {
            $image = $request->file('profile_picture');
            $path = $image->store('profile_pictures', 'public');

            if ($profile->profile_picture) {
                Storage::disk('public')->delete($profile->profile_picture);
            }

            $profile->profile_picture = $path;
            $profile->save(); // aman
        }

        return redirect()->back()->with('success_picture', 'Profile picture updated!');
    }

    public function deleteAccount(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()->withErrors(['password' => 'Password salah']);
        }

        Auth::logout();

        $user->delete(); // aman

        return redirect('/')->with('success', 'Account deleted successfully');
    }
}
