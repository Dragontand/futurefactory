<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Http\Requests\StoreModuleRequest;
use App\Http\Requests\UpdateModuleRequest;

class ModuleController extends Controller
{
    private $modules = [
        'chassis'         => 'Chassis', 
        'propulsion'      => 'Propulsion', 
        'wheel'           => 'Wheel', 
        'steering_wheel'  => 'Steering wheel', 
        'chair'           => 'Chair'
    ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get modules, pagianate and give with view
        return view('modules.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (session()->has('module_type')) {
            // makes sur eit is kept for the next page
            session()->reflash(); 
        }
        return view('modules.create', ['modules' => $this->modules]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeType(StoreModuleRequest $request)
    {
        $request->validate([
            'type' => 'required|in:' . implode(",", array_keys($this->modules))
        ]);

        return redirect()->route('modules.create')
            ->with('module_type', $request->type);;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreModuleRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Module $module)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Module $module)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateModuleRequest $request, Module $module)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Module $module)
    {
        //
    }
}
