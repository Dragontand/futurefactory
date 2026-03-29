<?php

namespace App\Models\Modules;

use App\Models\Module;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chassis extends Module
{
    /** @use HasFactory<\Database\Factories\Modules\ChassisFactory> */
    use HasFactory;

    protected static string $moduleType = 'chassis';
}
