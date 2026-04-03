<?php

namespace App\Models;

use App\Models\Modules\Chair;
use App\Models\Modules\Chassis;
use App\Models\Modules\Propulsion;
use App\Models\Modules\SteeringWheel;
use App\Models\Modules\Wheel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    /** @use HasFactory<\Database\Factories\VehicleFactory> */
    use HasFactory;

    protected $guarded = [];

    public function chassis(): BelongsTo 
    {
        return $this->belongsTo(Chassis::class, 'chassis_module_id', 'module_id');
    }

    public function propulsion() : BelongsTo
    {
        return $this->belongsTo(Propulsion::class, 'propulsion_module_id', 'module_id');
    }

    public function wheel() : BelongsTo
    {
        return $this->belongsTo(Wheel::class, 'wheel_module_id', 'module_id');
    }

    public function steeringWheel() : BelongsTo
    {
        return $this->belongsTo(SteeringWheel::class, 'steering_wheel_module_id', 'module_id');
    }

    public function chair() : BelongsTo
    {
        return $this->belongsTo(Chair::class, 'chair_module_id', 'module_id');
    }

    public function schedules() : HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    // Check compatible chassis
    public function isCompatible(): bool
    {
        return $this->wheel->compatibleChassis->contains($this->chassis);
    }

    // To calculate the total of a vehicle
    public function calcTotal() {
        return (
            $this->chassis->module->price +
            $this->propulsion->module->price +
            $this->wheel->module->price +
            $this->steeringWheel->module->price +
            $this->chair->module->price
        );
    }
}
