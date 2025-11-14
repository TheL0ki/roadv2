<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\User;
use App\Models\Shift;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BatchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::where('active', '=', '1')->orderBy('lastName')->get();
        $shift = Shift::where('active', '=', '1')->get();
        $holidays = Shift::where('isHoliday', '=', '1')->where('active', '=', '1')->get();

        $date = new DateTime();
        $date->setDate($date->format('Y'), $date->format('m'), '01');
        
        return view('batch', [
            'users' => $user,
            'shifts' => $shift,
            'date' => $date,
            'holidays' => $holidays,
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
        $attributes = $request->validate([
            'shift' => ['required', 'integer'],
            'month' => ['required', 'integer', 'min:1', 'max:12'],
            'year' => ['required', 'integer'],
            'weekday' => ['required', 'array'],
            'weekday.*' => ['required', 'integer', 'min:1', 'max:7'],
            'user' => ['required', 'array'],
            'user.*' => ['required', 'integer'],
        ]);

        foreach($attributes['user'] as $user) {
            $date = new DateTime();
            $date = $date->setDate($attributes['year'], $attributes['month'], '01');
            $user = User::find($user);

            for($i = 1; $i <= $date->format('t'); $i++) {
                $date->setDate($attributes['year'], $attributes['month'], $i);
                if(in_array($date->format('N'), $attributes['weekday'])) {
                    $schedule = $user->schedule()->firstOrNew([
                        'day' => $i,
                        'month' => $attributes['month'],
                        'year' => $attributes['year'],
                    ]);

                    if(isset($schedule->shift->override) === false || $schedule->shift->override !== 0) {
                        $schedule->user_id = $user->id;
                        $schedule->shift_id = $attributes['shift'];
                        $schedule->flexLoc = 0;
                        $schedule->save();
                    }
                }
            }
        }

        return redirect()->route('schedule', [
            'year' => $attributes['year'],
            'month' => $attributes['month'],
        ]);
    }

    public function storeHoliday(Request $request)
    {
        $attributes = $request->validate([
            'day' => ['required', 'integer', 'min:1', 'max:31'],
            'month' => ['required', 'integer', 'min:1', 'max:12'],
            'year' => ['required', 'integer'],
            'holidayId' => ['required', 'integer'],
        ]);

        $user = User::all();

        foreach($user as $user) {
            $user->schedule()->updateOrCreate(
                [   
                    'user_id' => $user->id,
                    'day' => $attributes['day'],
                    'month' => $attributes['month'],
                    'year' => $attributes['year'],
                ],
                [
                    'shift_id' => $attributes['holidayId'],
                    'flexLoc' => 0,
                ]
            );
        }

        return redirect()->route('schedule', [
            'year' => $attributes['year'],
            'month' => $attributes['month'],
        ]);
    }

    public function createHoliday(Request $request) 
    {
        $input = $request->validate([
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

        Shift::create([
            'name' => $input['name'],
            'display' => $input['display'],
            'color' => $input['color'],
            'textColor' => $input['textColor'],
            'hours' => $input['hours'],
            'isHoliday' => true
        ]);

        return redirect()->back();
    }

    public function destroyHoliday($id)
    {
        $shift = Shift::find($id);
        $shift->active = false;
        $shift->deletedAt = now();
        $shift->deletedBy = Auth::user()->id;
        $shift->save();
        return redirect()->back();
    }

    public function updateHoliday(Request $request, $id) 
    {
        $input = $request->validate([
            'name' => ['required', 'string'],
            'display' => ['required', 'string'],
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

        $shift = Shift::find($id);
        $shift->name = $input['name'];
        $shift->display = $input['display'];
        $shift->color = $input['color'];
        $shift->textColor = $input['textColor'];
        $shift->hours = $input['hours'];
        $shift->save();

        return redirect()->back();
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

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
