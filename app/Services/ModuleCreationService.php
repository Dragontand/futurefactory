<?php

namespace App\Services;

use App\Models\Module;
use App\Models\Modules\Chassis;
use App\Models\Modules\Propulsion;
use App\Models\Modules\Wheel;
use App\Models\Modules\SteeringWheel;
use App\Models\Modules\Chair;

class ModuleCreationService
{
    public function createModule(string $moduleType, array $data)
    {
        // Make basis Module
        $module = Module::create([
            'name' => $data['name'],
            'price' => $data['price'],
            'time' => $data['time'],
            // Image has a placeholder for now
            'image' => 'https://placehold.co/600x400/000000/FFFFFF.png',
        ]);
        
        // Send to create switcher
        $this->createSpecificModule($moduleType, $module->id, $data);
    }
    
    // Module type creator switcher
    private function createSpecificModule(string $type, int $moduleId, array $data): void
    {
        match($type) {
            'chassis' => $this->createChassis($moduleId, $data),
            'propulsion' => $this->createPropulsion($moduleId, $data),
            'wheel' => $this->createWheel($moduleId, $data),
            'steering_wheel' => $this->createSteeringWheel($moduleId, $data),
            'chair' => $this->createChair($moduleId, $data),
            default => throw new \InvalidArgumentException("Unknown module type: {$type}")
        };
    }
    
    // Creators for all Module types
    private function createChassis(int $moduleId, array $data): void
    {
        Chassis::create([
            'module_id' => $moduleId,
            'type' => $data['vehicle_type'],
            'amount_wheels' => $data['amount_wheels'],
            'length' => $data['length'],
            'width' => $data['width'],
            'height' => $data['height'],
        ]);
    }
    
    private function createPropulsion(int $moduleId, array $data): void
    {
        Propulsion::create([
            'module_id' => $moduleId,
            'type' => $data['propulsion_type'],
            'horsepower' => $data['horsepower'],
        ]);
    }
    
    private function createWheel(int $moduleId, array $data): void
    {
        Wheel::create([
            'module_id' => $moduleId,
            'type' => $data['wheel_type'],
            'diameter' => $data['diameter'],
        ]);
    }
    
    private function createSteeringWheel(int $moduleId, array $data): void
    {
        SteeringWheel::create([
            'module_id' => $moduleId,
            'type' => $data['steering_wheel_type'],
            'special_request' => $data['special_request'] ?? '',
        ]);
    }
    
    private function createChair(int $moduleId, array $data): void
    {
        Chair::create([
            'module_id' => $moduleId,
            'type' => $data['upholstery_type'],
            'amount' => $data['amount'],
        ]);
    }
}