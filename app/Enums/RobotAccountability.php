<?php

namespace App\Enums;

enum RobotAccountability : string
{
    case TwoWheeledVehicles = 'two_wheeled_vehicles';
    case HydrogenVehicles = 'hydrogen_vehicles';
    case HeavyVehicles = 'heavy_vehicles';
    case ElectricVehicles = 'electric_vehicles';
}
