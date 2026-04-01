<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Http\Requests\ModuleRequest;
use App\Http\Requests\UpdateModuleRequest;
use App\Services\ModuleCreationService;


class ModuleController extends Controller
{
    private ModuleCreationService $moduleService;

    public function __construct(ModuleCreationService $moduleService)
    {
        $this->moduleService = $moduleService;
    }

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
        $modules = Module::with(['chassis', 'propulsion', 'wheel', 'steeringWheel', 'chair'])->simplePaginate(15);
        return view('modules.index', [
            'modules' => $modules
        ]);
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
    public function storeType(ModuleRequest $request)
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
    public function store(ModuleRequest $request)
    {
        $this->moduleService->createModule(session('module_type'), $request->validated());

        session()->forget('module_type');

        return redirect()->route('modules.index')
            ->with('succes', 'Module succesvol aangemaakt!');;
    }

    /**
     * Display the specified resource.
     */
    public function show(Module $module)
    {
        return view('modules.show', ['module' => $module]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Module $module)
    {
        return view('modules.edit', ['module' => $module]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ModuleRequest $request, Module $module)
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
