<?php

namespace App\Observers;

use App\Models\Module;

class ModuleObserver
{
    public function deleting(Module $module) : void
    {
        // Gets called just before $module->delete() is executed
        $module->chassis?->delete();
        $module->propulsion?->delete();
        $module->wheel?->delete();
        $module->steeringWheel?->delete();
        $module->chair?->delete();
    }

    public function restoring(Module $module) : void
    {
        // Gets called just before $module->retore() is executed
        $module->chassis()->withTrashed()->first()?->restore();
        $module->propulsion()->withTrashed()->first()?->restore();
        $module->wheel()->withTrashed()->first()?->restore();
        $module->steeringWheel()->withTrashed()->first()?->restore();
        $module->chair()->withTrashed()->first()?->restore();
    }
}
