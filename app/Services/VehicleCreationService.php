<?php

namespace App\Services;

use App\Models\Vehicle;

class VehicleCreationService
{
    public function createVehicle(array $data)
    {
        // Make basis Module
        Vehicle::create($data);
    }
}