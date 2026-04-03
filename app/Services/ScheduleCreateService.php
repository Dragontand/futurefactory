<?php

namespace App\Services;

use App\Enums\PropulsionType;
use App\Enums\RobotAccountability;
use App\Enums\ScheduleType;
use App\Enums\VehicleType;
use App\Models\Robot;
use App\Models\Schedule;
use App\Models\Vehicle;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Collection;

class ScheduleCreateService
{
    public function storeMaintenance(array $data): void
    {
        Schedule::create([
            'robot_id' => $data['robot_id'],
            'type'     => ScheduleType::Maintenance,
            'day'      => $data['day'],
            'slot'     => $data['slot'],
        ]);
    }

    public function storeAssembly(array $data): void
    {
        $vehicle = Vehicle::with(['chassis.module', 'propulsion.module', 'wheel.module', 'steeringWheel.module', 'chair.module'])
            ->findOrFail($data['vehicle_id']);

        $slot = (int) $data['slot'];
        $robot = $this->findMatchingRobot($vehicle, $data['day'], $slot);

        if (!$robot) {
            throw new \RuntimeException('No suitable robot available for this vehicle.');
        }

        $totalSlots = $vehicle->calcTotalTime();

        $day = CarbonImmutable::parse($data['day']);
    
        $slotsPlanned = 0;
        while ($slotsPlanned < $totalSlots) {
            if ($day->isWeekday()) {
                $isBusy = Schedule::where('day', $day->toDateString())
                    ->where('slot', $slot)
                    ->where('robot_id', $robot->id)
                    ->exists();

                if (!$isBusy) {
                    Schedule::create([
                        'robot_id'   => $robot->id,
                        'vehicle_id' => $vehicle->id,
                        'type'       => ScheduleType::Assembly,
                        'day'        => $day->toDateString(),
                        'slot'       => $slot,
                    ]);
                    $slotsPlanned++;
                }
            }

            $slot++;
            if ($slot > 4) {
                $slot = 1;
                $day = $day->addDay();
            }
        }
    }

    public function getAvailableRobots(string $date, int $slot): Collection
    {
        $busyRobotIds = Schedule::where('day', $date)
            ->where('slot', $slot)
            ->pluck('robot_id');

        return Robot::whereNotIn('id', $busyRobotIds)->get();
    }

    public function getSchedulableVehicles(): Collection
    {
        $scheduledVehicleIds = Schedule::where('type', ScheduleType::Assembly)
            ->distinct()
            ->pluck('vehicle_id');

        return Vehicle::whereNotIn('id', $scheduledVehicleIds)->get();
    }

    private function getRequiredAccountability(Vehicle $vehicle): ?RobotAccountability
    {
        if ($vehicle->chassis->amount_wheels === 2) {
            return RobotAccountability::TwoWheeledVehicles;
        }

        if ($vehicle->propulsion->type === PropulsionType::Hydrogen) {
            return RobotAccountability::HydrogenVehicles;
        }

        if (in_array($vehicle->chassis->type, [VehicleType::Truck, VehicleType::Bus])) {
            return RobotAccountability::HeavyVehicles;
        }

        return null;
    }

    public function findMatchingRobot(Vehicle $vehicle, string $date, int $slot): ?Robot
    {
        $requiredAccountability = $this->getRequiredAccountability($vehicle);

        if (!$requiredAccountability) {
            throw new \RuntimeException('No suitable robot accountability found for this vehicle.');
        }

        $busyRobotIds = Schedule::where('day', $date)
            ->where('slot', $slot)
            ->pluck('robot_id');

        return Robot::where('accountability', $requiredAccountability)
            ->whereNotIn('id', $busyRobotIds)
            ->first();
    }
}
