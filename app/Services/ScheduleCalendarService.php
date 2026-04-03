<?php

namespace App\Services;

use App\Models\Schedule;
use Carbon\CarbonImmutable;
use Carbon\CarbonPeriod;

class ScheduleCalendarService
{
    public static function buildMonth(int $year, int $month) : array
    {
        $startOfMonth = CarbonImmutable::create($year, $month, 1);
        $endOfMonth = $startOfMonth->endOfMonth();
        $startOfWeek = $startOfMonth->startOfWeek(); 
        $endOfWeek = $endOfMonth->endOfWeek();

        return [
            'year'  => $startOfMonth->year,
            'month' => $startOfMonth->format('F'),
            'weeks' => collect($startOfWeek->toPeriod($endOfWeek)->toArray()) 
                ->map(fn ($date) => [
                    'path' => $date->format('/Y/m/d'),
                    'day' => $date->day,
                ])
                ->chunk(5),
        ];
    }

    public static function buildDays(int $year, int $month): array
    {
        // CarbonImmutable::create() makes a date-object fro the year, month and day
        $startOfMonth = CarbonImmutable::create($year, $month, 1);
        $endOfMonth = $startOfMonth->endOfMonth();

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

    public function getAvailableSlots(string $date) : array
    {
        $bookedSlots = Schedule::where('day', $date)
            ->pluck('slot')
            ->toArray();

        return collect(range(1, 4))->map(fn ($slot) => [
            'slot' => $slot,
            'available' => !in_array($slot, $bookedSlots),
        ])->toArray();
    }
}
