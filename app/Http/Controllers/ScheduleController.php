<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Team;
use App\Models\User;
use App\Models\Shift;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Mail\ScheduleChanged;
use App\Jobs\SendScheduleMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\StoreScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;

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
    public function show($year, $month, $team = null)
    {
        $date = new DateTime($year . '-' . $month . '-01');

        if($team !== null) {
            $user = User::where('team_id', '=', $team)
                ->where('validFrom', '<=', \Carbon\Carbon::parse($date)->addMonth()->format('Y-m-d'))
                ->where(function($query) use ($date) {
                    $query->where('validUntil', '>=', \Carbon\Carbon::parse($date)->format('Y-m-d'))
                        ->orWhereNull('validUntil');
                })
                ->orderBy('lastName', 'asc')
                ->with(['schedule' => function ($query) use ($date) {
                    $query->with('shift')->where('month', '=', $date->format('n'))->where('year', '=', $date->format('Y'));
                }])->get();
        } else {
            $user = User::where('validFrom', '<=', \Carbon\Carbon::parse($date)->addMonth()->format('Y-m-d'))
                ->where(function($query) use ($date) {
                    $query->where('validUntil', '>=', \Carbon\Carbon::parse($date)->format('Y-m-d'))
                          ->orWhereNull('validUntil');
                })
                ->orderBy('lastName', 'asc')
                ->with(['schedule' => function ($query) use ($date) {
                    $query->with('shift')->where('month', '=', $date->format('n'))->where('year', '=', $date->format('Y'));
                }])->get();
        }

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
            'shifts' => Shift::all()->where('active', '=', '1'),
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
                $schedule->flexLoc = $details['flexLoc'] ?? 0;
                $schedule->save();                
            }
        }

        if(in_array(Auth::user()->role->id, [1, 2])) {
            SendScheduleMail::dispatch(new ScheduleChanged($user, new DateTime($request->year . '-' . $request->month . '-01')));
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
