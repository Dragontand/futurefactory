<?php

namespace App\Models\Modules;

use App\Enums\UpholsteryType;
use App\Models\Module;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chair extends Model
{
    /** @use HasFactory<\Database\Factories\Modules\ChairFactory> */
    use HasFactory;
    // Module model already has a timestamp
    public $timestamps = false;
    // Assign the PK from Module to subclass
    protected $primaryKey = 'module_id';

    protected $guarded = [];
    
    protected $casts = [
        'type' => UpholsteryType::class
    ];

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class, 'module_id');
    }
}
