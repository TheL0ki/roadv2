<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('team.index', [
            'teams' => Team::where('active', "=", "1")->get()
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
        $teamAttributes = $request->validate([
            'name' => 'required',
            'displayName' => 'required',
        ]);

        $team = Team::create($teamAttributes);

        return redirect()->back()->with('feedback', 'teamCreated');
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Team $team)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $teamAttributes = $request->validate([
            'name' => 'required',
            'displayName' => 'required',
        ]);

        $team = Team::find($id);

        if ($team) {
            $team->update($teamAttributes);
        }

        return redirect()->back()->with('feedback', 'teamUpdated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $team = Team::find($id);

        if($team->user()->count() > 0) {
            return redirect()->back()->with('feedback', 'teamActiveUser');
        }

        $team->active = 0;
        $team->deletedAt = now();
        $team->deletedBy = auth()->user()->id;

        $team->save();

        return redirect()->back()->with('feedback', 'teamDeleted');
    }
}
