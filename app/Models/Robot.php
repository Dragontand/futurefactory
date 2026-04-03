<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Robot extends Model
{
    public function robot(): HasOne
    {
        return $this->hasOne(Schedule::class);
    }
}
