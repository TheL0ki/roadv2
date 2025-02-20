<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('settings');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $userAttributes = $request->validate([
            'email' => ['required', 'email'],
            'userId' => ['required'],
            'profilePic' => ['nullable', 'file', File::types(['png', 'jpg', 'jpeg', 'webp', 'gif'])],
        ]);

        $user = User::find($userAttributes['userId']);

        $user->email = $userAttributes['email'];
        if(isset($userAttributes['profilePic'])) {
            if($user->profilePic !== NULL) {
                Storage::disk('public')->delete($user->profilePic);
            }
            $profilePicPath = $request->file("profilePic")->storePublicly('profilePic', 'public');
            $user->profilePic = $profilePicPath;
        }
        
        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully');
    }

    public function updatePassword(Request $request)
    {
        $userInput = $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::find($request->userId);
        $user->password = bcrypt($userInput['password']);
        $user->save();

        return redirect()->back()->with('success', 'Password updated successfully');
    }
}
