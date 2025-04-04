<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreShiftRequest;
use App\Http\Requests\UpdateShiftRequest;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shifts = Shift::where('isHoliday', 0)->where('active', 1)->get();
        return view('shift.index', ['shifts' => $shifts]);
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
        $shiftAttributes = $request->validate([
            'name' => 'required',
            'display' => 'required',
            'color' => [
                'required',
                'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'
            ],
            'textColor' => [
                'required',
                'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'
            ],
            'hours' => ['required', 'numeric'],
        ]);

        if($request->flexLoc) {
            $shiftAttributes['flexLoc'] = true;
        } else {
            $shiftAttributes['flexLoc'] = false;
        }
        
        if($request->override) {
            $shiftAttributes['override'] = true;
        } else {
            $shiftAttributes['override'] = false;
        }

        $shift = Shift::create($shiftAttributes);

        return redirect('/shiftManagement')->with('feedback', 'shiftCreated');
    }

    /**
     * Display the specified resource.
     */
    public function show(Shift $shift)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shift $shift)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $shift = Shift::find($id);

        $shiftAttributes = $request->validate([
            'name' => 'required',
            'display' => 'required',
            'color' => [
                'required',
                'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'
            ],
            'textColor' => [
                'required',
                'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'
            ],
            'hours' => ['required', 'numeric']
        ]);

        if(!$request->flexLoc) {            
            $shiftAttributes['flexLoc'] = false;
        } else {
            $shiftAttributes['flexLoc'] = true;
        }

        if(!$request->override) {
            $shiftAttributes['override'] = false;
        } else {
            $shiftAttributes['override'] = true;
        }

        $shift->name = $shiftAttributes['name'];
        $shift->display = $shiftAttributes['display'];
        $shift->color = $shiftAttributes['color'];
        $shift->textColor = $shiftAttributes['textColor'];
        $shift->hours = $shiftAttributes['hours'];
        $shift->flexLoc = $shiftAttributes['flexLoc'];
        $shift->override = $shiftAttributes['override'];

        $shift->save();

        return redirect('/shiftManagement')->with('feedback', 'shiftUpdated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $shift = Shift::find($id);

        $shift->active = false;
        $shift->deletedAt = now();
        $shift->deletedBy = Auth::user()->id;

        $shift->save();

        return redirect('/shiftManagement')->with('feedback', 'shiftDeleted');
    }
}
