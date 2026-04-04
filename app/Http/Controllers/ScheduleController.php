<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Http\Requests\StoreScheduleRequest;
use App\Services\ScheduleCalendarService;
use App\Services\ScheduleCreationService;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    private ScheduleCalendarService $calendarService;
    private ScheduleCreationService $creationService;

    public function __construct(ScheduleCalendarService $calendarService, ScheduleCreationService $creationService)
    {
        $this->calendarService = $calendarService;
        $this->creationService = $creationService;
    }

    private $scheduleTypes = [
        'assembly'      => 'Assembly',
        'maintenance'   => 'Maintenance',
    ];

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
        $vehicles = $this->calendarService->getVehicleOverview();

        return view('schedules.index',
            compact('months', 'days', 'vehicles'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        if (session('schedule_type')) session()->forget('schedule_type');

        $date = $request->date;
        $isPast = CarbonImmutable::parse($date)->isPast();
        $slots = $this->calendarService->getAvailableSlots($date);

        return view('schedules.show', compact('date', 'slots', 'isPast'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $date = $request->date;
        if (CarbonImmutable::parse($request->date)->isPast()) {
            return redirect()->route('schedules.index')
                ->with('error', 'Cannot schedule in the past.');
        }
        $slot = $request->slot;
        $scheduleTypes = $this->scheduleTypes;
        $robots = $this->creationService->getAvailableRobots($date, $slot);
        $vehicles = $this->creationService->getSchedulableVehicles($date, $slot);

        return view('schedules.create', compact('date', 'slot', 'scheduleTypes', 'robots', 'vehicles'));
    }

    /**
     * For cancelling the session
     */
    public function cancel(Request $request)
    {
        $date = $request->date;
        $slot = $request->slot;
        
        session()->forget('schedule_type');
        return redirect()->route('schedules.create', compact('date', 'slot'));
    }

    /**
     * Store the type in the session
     */
    public function storeType(Request $request)
    {
        $date = $request->date;
        $slot = $request->slot;
        
        $request->validate([
            'type' => 'required|in:' . implode(",", array_keys($this->scheduleTypes))
        ]);

        session(['schedule_type' => $request->type]);

        return redirect()->route('schedules.create', compact('date', 'slot'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreScheduleRequest $request)
    {
        $data = $request->validated();

        if ($data['type'] === 'maintenance') {
            $this->creationService->storeMaintenance($data);
        } else {
            if(!$this->creationService->storeAssembly($data)) {
                return back()->withErrors(['robot' => 'No suitable robot available for this vehicle.']);
            }
        }

        return redirect()->route('schedules.show', ['date' => $data['date']])
            ->with('success', 'Item succesfully created!');;
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('schedules.index')
            ->with('success', 'Schedule successfully deleted!');
    }
}
