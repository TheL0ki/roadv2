<?php

namespace App\Http\Controllers;

use App\Models\User;
use DateTime;
use Exception;
use Illuminate\Http\Request;

class DailyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($year, $month, $day)
    {
        // Validate date parameters
        if (! is_numeric($year) || ! is_numeric($month) || ! is_numeric($day)) {
            abort(404, 'Invalid date format');
        }

        // Convert to integers and validate ranges
        $year = (int) $year;
        $month = (int) $month;
        $day = (int) $day;

        if ($year < 1900 || $year > 2200 || $month < 1 || $month > 12 || $day < 1 || $day > 31) {
            abort(404, 'Invalid date values');
        }

        // Attempt to create DateTime object and handle invalid dates
        try {
            $date = new DateTime($year.'-'.$month.'-'.$day);

            // Additional validation: check if the created date matches input
            // This catches cases like February 30th, which DateTime would adjust
            if ((int) $date->format('Y') !== $year ||
                (int) $date->format('n') !== $month ||
                (int) $date->format('j') !== $day) {
                abort(404, 'Invalid date');
            }
        } catch (Exception $e) {
            abort(404, 'Invalid date format');
        }
        $previousDate = (clone $date)->modify('-1 day');

        $user = User::where('validFrom', '<=', \Carbon\Carbon::parse($date)->format('Y-m-d'))
            ->where(function ($query) use ($date) {
                $query->where('validUntil', '>=', \Carbon\Carbon::parse($date)->format('Y-m-d'))
                    ->orWhereNull('validUntil');
            })
            ->orderBy('lastName', 'asc')
            ->with(['schedule' => function ($query) use ($date, $previousDate) {
                $query->with('shift')
                    ->where(function ($subQuery) use ($date, $previousDate) {
                        // Current day schedules
                        $subQuery->where(function ($currentDay) use ($date) {
                            $currentDay->where('day', '=', $date->format('d'))
                                ->where('month', '=', $date->format('n'))
                                ->where('year', '=', $date->format('Y'));
                        })
                        // Previous day schedules (for overnight shifts)
                            ->orWhere(function ($prevDay) use ($previousDate) {
                                $prevDay->where('day', '=', $previousDate->format('d'))
                                    ->where('month', '=', $previousDate->format('n'))
                                    ->where('year', '=', $previousDate->format('Y'));
                            });
                    });
            }])->get();

        $table = [];

        foreach ($user as $item) {
            foreach ($item->schedule as $entry) {
                $startHour = (int) substr($entry->shift->hour_start, 0, 2);
                $endHour = (int) substr($entry->shift->hour_end, 0, 2);

                // Skip shifts with invalid time ranges (00:00 to 00:00 or same start/end)
                if ($startHour === $endHour) {
                    continue;
                }

                // Determine if this schedule entry is for the current day or previous day
                $entryDate = new DateTime($entry->year.'-'.$entry->month.'-'.$entry->day);
                $isCurrentDay = $entryDate->format('Y-m-d') === $date->format('Y-m-d');
                $isPreviousDay = $entryDate->format('Y-m-d') === $previousDate->format('Y-m-d');

                // Initialize segments array if not exists
                if (! isset($table[$entry->user_id]['segments'])) {
                    $table[$entry->user_id]['segments'] = [];
                }

                if ($endHour < $startHour) {
                    // Overnight shift
                    if ($isCurrentDay) {
                        // Show only evening segment on current day (start to midnight)
                        $table[$entry->user_id]['segments'][] = [
                            'start' => $startHour,
                            'end' => 24, // Until midnight
                            'name' => $entry->shift->name,
                            'color' => $entry->shift->color,
                            'textColor' => $entry->shift->textColor,
                        ];
                    } elseif ($isPreviousDay) {
                        // Show only morning segment from previous day's overnight shift (midnight to end)
                        $table[$entry->user_id]['segments'][] = [
                            'start' => 0, // From midnight
                            'end' => $endHour,
                            'name' => $entry->shift->name,
                            'color' => $entry->shift->color,
                            'textColor' => $entry->shift->textColor,
                        ];
                    }
                } else {
                    // Regular shift within the same day
                    if ($isCurrentDay) {
                        $table[$entry->user_id]['segments'][] = [
                            'start' => $startHour,
                            'end' => $endHour,
                            'name' => $entry->shift->name,
                            'color' => $entry->shift->color,
                            'textColor' => $entry->shift->textColor,
                        ];
                    }
                }
            }
        }

        return view('daily.index', [
            'users' => $user,
            'table' => $table,
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        //
    }
}
