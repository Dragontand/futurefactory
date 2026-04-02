<?php

namespace App\Models\Modules;

use App\Enums\VehicleType;
use App\Models\Module;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chassis extends Model
{
    /** @use HasFactory<\Database\Factories\Modules\ChassisFactory> */
    use HasFactory;
    use SoftDeletes;
    // Module model already has a timestamp
    public $timestamps = false;
    // Assign the PK from Module to subclass
    protected $primaryKey = 'module_id';

    protected $guarded = [];
    
    protected $casts = [
        'type' => VehicleType::class
    ];

    // To get, attach and or detach compatible wheels. Examples:
    // Get: $chassis->compatibleChassis;
    // Attach/Detach: $chassis->compatibleChassis()->attach/detach($wheel);
    public function compatibleWheels() : BelongsToMany
    {
        return $this->belongsToMany(
            Wheel::class,
            'chassis_wheel',
            'chassis_module_id',
            'wheel_module_id',
            'module_id',
            'module_id',
        );
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class, 'module_id');
    }
}
