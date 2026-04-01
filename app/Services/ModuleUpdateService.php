<?php

namespace App\Services;

use App\Models\Module;
use App\Models\Modules\Chassis;
use App\Models\Modules\Propulsion;
use App\Models\Modules\Wheel;
use App\Models\Modules\SteeringWheel;
use App\Models\Modules\Chair;

class ModuleUpdateService
{
    public function updateModule(Module $module, array $data)
    {
        // Make basis Module
        $module->update([
            'name' => $data['name'],
            'price' => $data['price'],
            'time' => $data['time'],
            // Image has a placeholder for now
            'image' => 'https://placehold.co/600x400/000000/FFFFFF.png',
        ]);
        
        // Send to update switcher
        $this->updateSpecificModule($module, $data);
    }
    
    // Module type updater switcher
    private function updateSpecificModule(Module $module, array $data): void
    {
        match(true) {
            $module->chassis !== null       => $this->updateChassis($module->chassis, $data),
            $module->propulsion !== null    => $this->updatePropulsion($module->propulsion, $data),
            $module->wheel !== null         => $this->updateWheel($module->wheel, $data),
            $module->steeringWheel !== null => $this->updateSteeringWheel($module->steeringWheel, $data),
            $module->chair !== null         => $this->updateChair($module->chair, $data),
            default => throw new \InvalidArgumentException("Unknown module type"),
        };
    }
    
    // Updaters for all Module types
    private function updateChassis(Chassis $chassis, array $data): void
    {
        $chassis->update([
            'type' => $data['vehicle_type'],
            'amount_wheels' => $data['amount_wheels'],
            'length' => $data['length'],
            'width' => $data['width'],
            'height' => $data['height'],
        ]);
    }
    
    private function updatePropulsion(Propulsion $propulsion, array $data): void
    {
        $propulsion->update([
            'type' => $data['propulsion_type'],
            'horsepower' => $data['horsepower'],
        ]);
    }
    
    private function updateWheel(Wheel $wheel, array $data): void
    {
        $wheel->update([
            'type' => $data['wheel_type'],
            'diameter' => $data['diameter'],
        ]);
    }
    
    private function updateSteeringWheel(SteeringWheel $steeringWheel, array $data): void
    {
        $steeringWheel->update([
            'type' => $data['steering_wheel_type'],
            'special_request' => $data['special_request'] ?? '',
        ]);
    }
    
    private function updateChair(Chair $chair, array $data): void
    {
        $chair->update([
            'type' => $data['upholstery_type'],
            'amount' => $data['amount'],
        ]);
    }
}
