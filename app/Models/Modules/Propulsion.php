<?php

namespace App\Models\Modules;

use App\Enums\PropulsionType;
use App\Models\Module;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Propulsion extends Model
{
    /** @use HasFactory<\Database\Factories\Modules\PropulsionFactory> */
    use HasFactory;
    // Module model already has a timestamp
    public $timestamps = false;
    // Assign the PK from Module to subclass
    protected $primaryKey = 'module_id';

    protected $guarded = [];
    
    protected $casts = [
        'type' => PropulsionType::class
    ];

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class, 'module_id');
    }
}
