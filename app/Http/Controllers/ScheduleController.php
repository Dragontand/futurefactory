<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Http\Requests\StoreScheduleRequest;
use App\Services\ScheduleCalendarService;
use App\Services\ScheduleCreateService;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    private ScheduleCalendarService $calendarService;
    private ScheduleCreateService $createService;

    public function __construct(ScheduleCalendarService $calendarService, ScheduleCreateService $createService)
    {
        $this->calendarService = $calendarService;
        $this->createService = $createService;
    }

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

    public function show(Request $request)
    {
        $date = $request->date;
        $slots = $this->calendarService->getAvailableSlots($date);

        return view('schedules.show', compact('date', 'slots'));
    }

    public function create(Request $request)
    {
        $day = $request->day;
        $slot = $request->slot;
        $robots = $this->createService->getAvailableRobots($day, $slot);
        $vehicles = $this->createService->getSchedulableVehicles();

        return view('schedules.create', compact('day', 'slot', 'robots', 'vehicles'));
    }

    public function store(StoreScheduleRequest $request)
    {
        $data = $request->validated();

        if ($data['type'] === 'maintenance') {
            $this->createService->storeMaintenance($data);
        } else {
            $this->createService->storeAssembly($data);
        }

        return redirect()->route('schedules.show', ['date' => $data['day']])
            ->with('success', 'Schedule successfully created!');;
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('schedules.index')
            ->with('success', 'Schedule successfully deleted!');
    }
}
