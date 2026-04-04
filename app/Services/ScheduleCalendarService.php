<?php

namespace App\Services;

use App\Models\Robot;
use App\Models\Schedule;
use App\Models\Vehicle;
use Carbon\CarbonImmutable;
use Carbon\CarbonPeriod;

class ScheduleCalendarService
{
    private const SLOT_LABELS = [
        1 => '09:00 - 11:00',
        2 => '11:00 - 13:00',
        3 => '13:00 - 15:00',
        4 => '15:00 - 17:00',
    ];

    
    public static function buildDays(int $year, int $month): array
    {
        // CarbonImmutable::create() makes a date-object fro the year, month and day
        $startOfMonth = CarbonImmutable::create($year, $month, 1);

        // This is for the "paddings" days that go into
        // last and next month in the calendar view.
        $start = $startOfMonth->startOfWeek();
        $end = $start->addWeeks(6)->subDay();

        // Gets all schedules in this range in one query and group them by datestring
        $schedulesByDay = Schedule::whereBetween('date', [$start->toDateString(), $end->toDateString()])
            ->get()
            ->groupBy(fn ($slotSchedules) => $slotSchedules->date->toDateString());

        // Makes a collection of the period, filters out the weekend.
        // Then in maps each dat to an associative array in the original array.
        // After that, if there are schedules for that date, it gest all the events's types.
        // Finally it deletes the empty position in the collection and makes it an array.
        $dates = [];
        foreach ($start->toPeriod($end)->toArray() as $date) {
            if ($date->isWeekday()) {
                $dates[] = [
                    'date'           => $date->toDateString(),       // "2026-04-03"
                    'number'         => $date->day,                   // 3
                    'isCurrentMonth' => $date->month === $month,      // true/false
                    'isToday'        => $date->isToday(),             // true/false
                    'events'         => ($schedulesByDay[$date->toDateString()] ?? collect())
                        ->groupBy(fn ($s) => $s->type->value)
                        ->map(fn ($group) => $group->count())
                        ->toArray(),
                ];
            }
        }
        return $dates;
    }

    public function getAvailableSlots(string $date): array
    {
        $schedules = Schedule::with(['robot', 'vehicle'])
            ->where('date', $date)
            ->get()
            // Group them on each array key by the slotnumber
            ->groupBy('slot');

        $robotCount = Robot::count();

        $slots = [];
        foreach (range(1, 4) as $slotNumber) {
            $slotSchedules = $schedules->get($slotNumber);

            $scheduleData = [];
            if ($slotSchedules) {
                foreach ($slotSchedules as $schedule) {
                $scheduleData[] = [
                        'id'          => $schedule->id,
                        'type'        => $schedule->type->value,
                        'robot_id'    => $schedule->robot->id,
                        'robot_name'  => $schedule->robot->name,
                        'vehicle_id'  => $schedule->vehicle?->id,
                        'vehicle_name'=> $schedule->vehicle?->name,
                        'is_complete' => $schedule->is_complete,
                    ];
                }
            }

            $slots[] = [
                'number'      => $slotNumber,
                'label'     => self::SLOT_LABELS[$slotNumber],
                'isAvailable' => count($slotSchedules ?? []) < $robotCount,
                'schedules'  => $scheduleData,
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
            $lastDay = $assemblySchedules->max('date');

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
