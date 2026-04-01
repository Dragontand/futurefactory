<?php

namespace App\Models\Modules;

use App\Enums\WheelType;
use App\Models\Module;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wheel extends Model
{
    /** @use HasFactory<\Database\Factories\Modules\WheelFactory> */
    use HasFactory;
    use SoftDeletes;
    // Module model already has a timestamp
    public $timestamps = false;
    // Assign the PK from Module to subclass
    protected $primaryKey = 'module_id';

    protected $guarded = [];
    
    protected $casts = [
        'type' => WheelType::class
    ];

    // To get, attach and or detach compatible chassis. Examples:
    // Get: $wheel->compatibleChassis;
    // Attach/Detach: $wheel->compatibleChassis()->attach/detach($chassis);
    public function compatibleChassis() : BelongsToMany
    {
        return $this->belongsToMany(
            Chassis::class,
            'chassis_wheel',
            'wheel_module_id',
            'chassis_module_id',
            'module_id',
            'module_id',
        );
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class, 'module_id');
    }
}
