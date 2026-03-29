<?php

namespace App\Observers;

use App\Models\Module;

class ModuleObserver
{
    public function created(Module $module) : void
    {
        // To make sure the Module model is abstract wihtout initiating it as abstract.
        if (!$module->chassis()->exists() && 
            !$module->propulsion()->exists() && 
            !$module->wheel()->exists() &&
            !$module->steeringWheel()->exists() &&
            !$module->chair()->exists()
        )   {
            $module->delete();
            throw new \LogicException('A module cannot exist without a subtype.');
        }
    }
}
