<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::where('active', '=', '1')->with('team')->with('role')->get();

        return view('user.index', [
            'user' => $user,
            'teams' => Team::all(),
            'roles' => Role::all(),
        ]);
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
        $userAttributes = $request->validate([
            'firstName' => ['required'],
            'lastName' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', Password::min(6)],
            'role_id' => ['required'],
            'team_id' => ['required'],
            'model' => ['required'],
            'slackId' => ['required', 'unique:users,slackId'],
        ]);

        $user = User::create($userAttributes);

        $this->associateUser($user, $userAttributes);

        return redirect('/userManagement')->with('feedback', 'userCreated');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        
        $userAttributes = $request->validate([
            'firstName' => ['required'],
            'lastName' => ['required'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'role_id' => ['required'],
            'team_id' => ['required'],
            'model' => ['required'],
            'slackId' => ['required', Rule::unique('users', 'slackId')->ignore($user->id)],
        ]);

        $user->firstName = $userAttributes['firstName'];
        $user->lastName = $userAttributes['lastName'];
        $user->email = $userAttributes['email'];
        $user->model = $userAttributes['model'];
        $user->slackId = $userAttributes['slackId'];

        $this->associateUser($user, $userAttributes);

        return redirect('/userManagement')->with('feedback', 'userUpdatedSuccess');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::find($id);

        $user->active = 0;
        $user->deletedAt = now();
        $user->deletedBy = Auth::user()->id;

        $user->save();

        return redirect('/userManagement')->with('feedback', 'userDeleted');
    }

    protected function associateUser(User $user, $userAttributes) : void
    {
        $user->team()->associate(Team::find($userAttributes['team_id']));
        $user->role()->associate(Role::find($userAttributes['role_id']));
        $user->save();
    }
}
