<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
                Storage::delete($user->profilePic);
            }
            $profilePicPath = $request->profilePic->store('profilePic');
            $user->profilePic = $profilePicPath;
        }
        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
