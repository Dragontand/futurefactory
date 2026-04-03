<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Http\Requests\StoreScheduleRequest;
use App\Services\ScheduleCalendarService;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    private ScheduleCalendarService $scheduleCalendarService;

    public function __construct(ScheduleCalendarService $scheduleCalendarService)
    {
        $this->scheduleCalendarService = $scheduleCalendarService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $curDate = $request->has('month') ? 
            CarbonImmutable::parse($request->month) : 
            CarbonImmutable::now();

        $now = CarbonImmutable::now();
        $months = [
            'viewMonth'  => $curDate->format('F Y'),
            'prevMonth' => $curDate->subMonth()->format('Y-m'),
            'nextMonth' => $curDate->addMonth()->format('Y-m'),
            'curMonth'     => $now->format('Y-m'),
            'isCurrentMonth' => $curDate->isSameMonth($now),
        ];

        $days = ScheduleCalendarService::buildDays($curDate->year, $curDate->month);
        
        return view('schedules.index',
            compact('months', 'days'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('schedules.create');
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
    public function show(StoreScheduleRequest $request)
    {
        $date = $request->date;
        $slots = $this->scheduleCalendarService->getAvailableSlots($date);

        return view('schedules.show', compact('$slots'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('schedules.index')
            ->with('success', 'Vehicle successfully deleted!');;
    }
}
