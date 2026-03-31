<?php

namespace App\Observers;

use App\Models\Module;

class ModuleObserver
{
    public function created(Module $module) : void
    {
        $subtTypCount = (int) $module->chassis()->exists()  
            + (int) $module->propulsion()->exists()  
            + (int) $module->wheel()->exists() 
            + (int)$module->steeringWheel()->exists()
            + (int)$module->chair()->exists();
        // To make sure the Module model is abstract wihtout initiating it as abstract.
        if ($subtTypCount === 0)   {
            $module->delete();
            throw new \LogicException('A module cannot exist without a subtype.');
        }
        // And to enforce that one Module is one subtype.
        if ($subtTypCount > 1)   {
            $module->delete();
            throw new \LogicException('A module cannot have more than one subtype.');
        }
    }
}
