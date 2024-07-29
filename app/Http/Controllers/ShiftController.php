<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Shift;
use Illuminate\Http\Request;
use App\Http\Requests\StoreShiftRequest;
use App\Http\Requests\UpdateShiftRequest;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shifts = Shift::all();
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

        if($request->hoAllowed) {
            $shiftAttributes['hoAllowed'] = true;
        } else {
            $shiftAttributes['hoAllowed'] = false;
        }

        $shift = Shift::create($shiftAttributes);

        return redirect('/shiftManagement')->with('success', 'Shift created successfully!');
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
            'hours' => ['required', 'numeric'],
        ]);

        if($request->hoAllowed) {
            $shiftAttributes['hoAllowed'] = true;
        } else {
            $shiftAttributes['hoAllowed'] = false;
        }

        $shift->update($shiftAttributes);

        return redirect('/shiftManagement')->with('success', 'Shift updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $shift = Shift::find($id);

        $shift->delete();

        return redirect('/shiftManagement')->with('success', 'Shift deleted successfully!');
    }
}
