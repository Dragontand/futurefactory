<?php

namespace App\Models\Modules;

use App\Enums\SteeringWheelType;
use App\Models\Module;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SteeringWheel extends Model
{
    /** @use HasFactory<\Database\Factories\Modules\SteeringWheelFactory> */
    use HasFactory;
    use SoftDeletes;
    // Module model already has a timestamp
    public $timestamps = false;
    // Assign the PK from Module to subclass
    protected $primaryKey = 'module_id';

    protected $guarded = [];
    
    protected $casts = [
        'type' => SteeringWheelType::class
    ];

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class, 'module_id');
    }
}
