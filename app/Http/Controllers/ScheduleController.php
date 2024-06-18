<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Team;
use App\Models\User;
use App\Models\Shift;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Http\Requests\StoreScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;
use Illuminate\Support\Facades\Date;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $date = new DateTime();
        $date->setDate($date->format('Y'), $date->format('m'), '01');

        return $this->show($date->format('Y'), $date->format('n'));
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
    public function store(StoreScheduleRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($year, $month)
    {
        $displayDate = $year . '-' . $month . '-01';
        $date = new DateTime($displayDate);

        $user = User::with(['schedule' => function ($query) use ($date) {
            $query->with('shift')->where('month', '=', $date->format('n'))->where('year', '=', $date->format('Y'));
        }])->get();

        $table = [];

        foreach ($user as $item) {
            foreach ($item->schedule as $entry) {
                $table[$entry->user_id][$entry->day] = $entry;
            }
        }

        $months = [
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December'
        ];

        return view('schedule.index', [
            'user' => $user,
            'table' => $table,
            'date' => $date,
            'teams' => Team::all(),
            'months' => $months
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id, $year, $month)
    {
        $displayDate = $year . '-' . $month . '-01';
        $date = new DateTime($displayDate);
        $user = User::with('schedule')->find($id);

        return view('schedule.edit', [
            'user' => $user,
            'date' => $date,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'shift' => ['required', 'array'],
            'shift.*' => ['required', 'array', 'min:1', 'max:2'],
            'shift.*.shift' => ['required', 'alpha_num'],
            'user_id' => ['required', 'integer'],
            'month' => ['required', 'numeric', 'min:1', 'max:12'],
            'year' => ['required', 'numeric'],
        ]);

        $user = User::find($request->user_id);

        foreach($request->shift as $day => $details) {
            
            if($details['shift'] === "null") 
            {
                $schedule = $user->schedule()->where('day', $day)->where('month', $request->month)->where('year', $request->year)->first();
                if($schedule) {
                    $schedule->delete();
                }
            }
            else
            {
                $schedule = $user->schedule()->firstOrNew([
                    'day' => $day,
                    'month' => $request->month,
                    'year' => $request->year,
                ]);
    
                $schedule->user_id = $user->id;
                $schedule->shift_id = $details['shift'];
                $schedule->homeOffice = $details['homeOffice'] ?? 0;
                $schedule->save();                
            }
        }
        
        return redirect('/schedule/' . $request->year .'/' . $request->month);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule)
    {
        //
    }
}
