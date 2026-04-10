<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShiftController extends Controller
{
    private function normalizeTime(string $value): string
    {
        return strlen($value) === 5 ? "{$value}:00" : $value;
    }

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
                'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/',
            ],
            'textColor' => [
                'required',
                'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/',
            ],
            'hour_start' => ['required', 'regex:/^([01]\d|2[0-3]):[0-5]\d(?::[0-5]\d)?$/'],
            'hour_end' => ['required', 'regex:/^([01]\d|2[0-3]):[0-5]\d(?::[0-5]\d)?$/'],
            'flexLoc' => ['required', 'boolean'],
            'override' => ['required', 'boolean'],
        ]);

        $shiftAttributes['flexLoc'] = $request->boolean('flexLoc');
        $shiftAttributes['override'] = $request->boolean('override');
        $shiftAttributes['hour_start'] = $this->normalizeTime($shiftAttributes['hour_start']);
        $shiftAttributes['hour_end'] = $this->normalizeTime($shiftAttributes['hour_end']);

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
                'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/',
            ],
            'textColor' => [
                'required',
                'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/',
            ],
            'hour_start' => ['required', 'regex:/^([01]\d|2[0-3]):[0-5]\d(?::[0-5]\d)?$/'],
            'hour_end' => ['required', 'regex:/^([01]\d|2[0-3]):[0-5]\d(?::[0-5]\d)?$/'],
            'flexLoc' => ['required', 'boolean'],
            'override' => ['required', 'boolean'],
        ]);

        $shiftAttributes['flexLoc'] = $request->boolean('flexLoc');
        $shiftAttributes['override'] = $request->boolean('override');
        $shiftAttributes['hour_start'] = $this->normalizeTime($shiftAttributes['hour_start']);
        $shiftAttributes['hour_end'] = $this->normalizeTime($shiftAttributes['hour_end']);

        $shift->name = $shiftAttributes['name'];
        $shift->display = $shiftAttributes['display'];
        $shift->color = $shiftAttributes['color'];
        $shift->textColor = $shiftAttributes['textColor'];
        $shift->hour_start = $shiftAttributes['hour_start'];
        $shift->hour_end = $shiftAttributes['hour_end'];
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
