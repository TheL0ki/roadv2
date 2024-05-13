<?php

namespace App\Http\Controllers;

use DateTime;
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

        $user = User::with(['schedule' => function ($query) use ($date) {
            $query->with('shift')->where('month', '=', $date->format('n'))->where('year', '=', $date->format('Y'));
        }])->get();
    
        $table = [];
    
        foreach ($user as $item) {
            foreach ($item->schedule as $entry) {
                $table[$entry->user_id][$entry->day] = $entry;
            }
        }
    
        $date = new DateTime();
    
        return view('table.show', [
            'user' => $user,
            'table' => $table,
            'date' => $date
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

        return view('table.show', [
            'user' => $user,
            'table' => $table,
            'date' => $date
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Schedule $schedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateScheduleRequest $request, Schedule $schedule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule)
    {
        //
    }
}
