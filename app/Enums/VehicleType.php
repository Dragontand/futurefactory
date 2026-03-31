<?php

namespace App\Enums;

enum VehicleType : string
{
    case Step   = 'step';
    case Bike   = 'bike';
    case Scooter = 'scooter';
    case PassengerCar   = 'passenger_car';
    case Truck   = 'truck';
    case Bus   = 'bus';
}
