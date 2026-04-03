<?php

namespace App\Services;

use App\Models\Schedule;
use App\Models\Vehicle;
use Carbon\CarbonImmutable;
use Carbon\CarbonPeriod;

class ScheduleCalendarService
{
    public static function buildDays(int $year, int $month): array
    {
        // CarbonImmutable::create() makes a date-object fro the year, month and day
        $startOfMonth = CarbonImmutable::create($year, $month, 1);

        // This is for the "paddings" days that go into
        // last and next month in the calendar view.
        $start = $startOfMonth->startOfWeek();
        $end = $start->addWeeks(6)->subDay();

        // gets all schedules in this range in one query
        $schedulesByDay = Schedule::whereBetween('day', [$start->toDateString(), $end->toDateString()])
            ->get()
            ->groupBy(fn ($schedule) => $schedule->day->toDateString());

        // makes a collection of thge period, filters out the weekend.
        // Then in maps each dat to an associative array in the original array.
        // After that, if there are schedules for that day, it gest all the events's types.
        // Finally it deletes the empty position in the collection and makes it an array.
        return collect($start->toPeriod($end)->toArray())
            ->filter(fn ($date) => $date->isWeekday())
            ->map(fn ($date) => [
                'date'           => $date->toDateString(),       // "2026-04-03"
                'number'         => $date->day,                   // 3
                'isCurrentMonth' => $date->month === $month,      // true/false
                'isToday'        => $date->isToday(),             // true/false
                'events'         => ($schedulesByDay[$date->toDateString()] ?? collect())
                    ->map(fn ($s) => $s->type->value)
                    ->toArray(),
            ])
            ->values()
            ->toArray();
    }

    private const SLOT_LABELS = [
        1 => '09:00 - 11:00',
        2 => '11:00 - 13:00',
        3 => '13:00 - 15:00',
        4 => '15:00 - 17:00',
    ];

    public function getAvailableSlots(string $date): array
    {
        $schedules = Schedule::with(['robot', 'vehicle'])
            ->where('day', $date)
            ->get()
            // Make array key the slot number
            ->keyBy('slot');

        $slots = [];
        foreach (range(1, 4) as $slotNumber) {
            $schedule = $schedules->get($slotNumber);
            $slots[] = [
                'number'      => $slotNumber,
                'label'     => self::SLOT_LABELS[$slotNumber],
                'isAvailable' => $schedule === null,
                'schedule'  => $schedule ? [
                    'id'          => $schedule->id,
                    'type'        => $schedule->type->value,
                    'robot'       => $schedule->robot->name,
                    'vehicle'     => $schedule->vehicle?->name,
                    'is_complete' => $schedule->is_complete,
                ] : null,
            ];
        }
        return $slots;
    }

    public function getVehicleOverview(): array
    {
        $vehicles = Vehicle::with([
            'chassis.module',
            'propulsion.module',
            'wheel.module',
            'steeringWheel.module',
            'chair.module',
            'schedules'
        ])->get();

        $overview = [];
        foreach ($vehicles as $vehicle) {
            $totalTime = $vehicle->calcTotalTime();

            $assemblySchedules = $vehicle->schedules->where('type.value', 'assembly');
            $completedSlots = $assemblySchedules->where('is_complete', true)->count();
            $scheduledSlots = $assemblySchedules->count();
            $lastDay = $assemblySchedules->max('day');

            $overview[] = [
                'name'           => $vehicle->name,
                'totalSlots'     => $totalTime,
                'scheduledSlots' => $scheduledSlots,
                'completedSlots' => $completedSlots,
                'expectedDate'   => $lastDay?->format('d M Y'),
                'isScheduled'    => $scheduledSlots > 0,
                'isComplete'     => $completedSlots >= $totalTime,
            ];
        }

        return $overview;
    }
}
