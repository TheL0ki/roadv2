<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Team;
use App\Models\User;
use App\Models\Schedule;
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
    public function edit($id)
    {

        $user = User::with('team.shift')->find($id);

        return view('schedule.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update()
    {
        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule)
    {
        //
    }
}
