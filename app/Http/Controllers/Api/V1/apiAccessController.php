<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class apiAccessController extends Controller
{
    public function index()
    {
        return view('apiAccess')->with([
            'tokens' => Auth::user()->tokens,
        ]);
    }

    public function create(Request $request) {
        $requestData = $request->validate([
            'tokenName' => 'required|string',
        ]);
        
        return redirect()->back()->with([
            'newToken' => Auth::user()->createToken($requestData['tokenName'])->plainTextToken,
        ]);
    }

    public function destroy(Request $request)
    {
        Auth::user()->tokens()->where('id', $request->tokenID)->delete();
        return redirect()->back();
    }
}
