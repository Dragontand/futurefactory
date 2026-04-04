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

class ScheduleCreationService
{
    public function storeMaintenance(array $data): void
    {
        Schedule::create([
            'robot_id' => $data['robot_id'],
            'type'     => ScheduleType::Maintenance,
            'date'      => $data['date'],
            'slot'     => $data['slot'],
        ]);
    }

    public function storeAssembly(array $data): bool
    {
        $vehicle = Vehicle::with(['chassis.module', 'propulsion.module', 'wheel.module', 'steeringWheel.module', 'chair.module'])
            ->findOrFail($data['vehicle_id']);

        $slot = (int) $data['slot'];
        $robot = $this->findMatchingRobot($vehicle, $data['date'], $slot);

        if (!$robot) {
            return false;
        }

        $totalSlots = $vehicle->calcTotalTime();

        $carbonDate= CarbonImmutable::parse($data['date']);
    
        $slotsPlanned = 0;
        while ($slotsPlanned < $totalSlots) {
            if ($carbonDate->isWeekday()) {
                $isBusy = Schedule::where('date', $carbonDate->toDateString())
                    ->where('slot', $slot)
                    ->where('robot_id', $robot->id)
                    ->exists();

                if (!$isBusy) {
                    Schedule::create([
                        'robot_id'   => $robot->id,
                        'vehicle_id' => $vehicle->id,
                        'type'       => ScheduleType::Assembly,
                        'date'        => $carbonDate->toDateString(),
                        'slot'       => $slot,
                    ]);
                    $slotsPlanned++;
                }
            }

            $slot++;
            if ($slot > 4) {
                $slot = 1;
                $carbonDate = $carbonDate->addDay();
            }
        }
        return true;
    }

    public function getAvailableRobots(string $date, int $slot): Collection
    {
        $busyRobotIds = Schedule::where('date', $date)
            ->where('slot', $slot)
            ->pluck('robot_id');

        return Robot::whereNotIn('id', $busyRobotIds)->get();
    }

    public function getSchedulableVehicles(string $date, int $slot): Collection
    {
        $scheduledVehicleIds = Schedule::where('type', ScheduleType::Assembly)
            ->distinct()
            ->pluck('vehicle_id');

        $unschedulesVehicleIds = Vehicle::whereNotIn('id', $scheduledVehicleIds)->get();
        
        $avaiableVehicles = [];
        foreach($unschedulesVehicleIds as $vehicleId) {
            if($this->findMatchingRobot($vehicleId, $date, $slot)) {
                $avaiableVehicles[] = $vehicleId;
            }
        }
        return new Collection($avaiableVehicles);
    }

    private function getRequiredAccountability(Vehicle $vehicle): ?array
    {
        $accountabilities = [];
        if ($vehicle->chassis->amount_wheels === 2) {
            $accountabilities[] = RobotAccountability::TwoWheeledVehicles;
        }

        if ($vehicle->propulsion->type === PropulsionType::Hydrogen) {
            $accountabilities[] = RobotAccountability::HydrogenVehicles;
        }

        if ($vehicle->propulsion->type === PropulsionType::Electric) {
            $accountabilities[] = RobotAccountability::ElectricVehicles;
        }

        if (in_array($vehicle->chassis->type, [VehicleType::Truck, VehicleType::Bus])) {
            $accountabilities[] = RobotAccountability::HeavyVehicles;
        }

        return $accountabilities;
    }

    public function findMatchingRobot(Vehicle $vehicle, string $date, int $slot): ?Robot
    {
        $possibleAccountabilities = $this->getRequiredAccountability($vehicle);

        $busyRobotIds = Schedule::where('date', $date)
            ->where('slot', $slot)
            ->pluck('robot_id');

        return Robot::whereIn('accountability', $possibleAccountabilities)
            ->whereNotIn('id', $busyRobotIds)
            ->first();
    }
}
