<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Http\Requests\ModuleRequest;
use App\Http\Requests\UpdateModuleRequest;
use App\Services\ModuleCreationService;
use App\Services\ModuleUpdateService;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    private ModuleCreationService $moduleCreationService;
    private ModuleUpdateService $moduleUpdateService;

    public function __construct(ModuleCreationService $moduleCreationService, ModuleUpdateService $moduleUpdateService)
    {
        $this->moduleCreationService = $moduleCreationService;
        $this->moduleUpdateService = $moduleUpdateService;
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
        $modules = Module::with(['chassis', 'propulsion', 'wheel', 'steeringWheel', 'chair'])->latest()->simplePaginate(15);
        return view('modules.index', [
            'modules' => $modules
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('modules.create', ['modules' => $this->modules]);
    }

    /**
     * For cancelling the session
     */
    public function cancel()
    {
        session()->forget('module_type');
        return redirect()->route('modules.index');
    }

    /**
     * Store the module type in the session
     */
    public function storeType(Request $request)
    {
        $request->validate([
            'type' => 'required|in:' . implode(",", array_keys($this->modules))
        ]);

        session(['module_type' => $request->type]);

        return redirect()->route('modules.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ModuleRequest $request)
    {
        $this->moduleCreationService->createModule(session('module_type'), $request->validated());

        session()->forget('module_type');

        return redirect()->route('modules.index')
            ->with('succes', 'Module succesvol aangemaakt!');;
    }

    /**
     * Display the specified resource.
     */
    public function show(Module $module)
    {
        $module->load(['wheel.compatibleChassis.module']);
        return view('modules.show', ['module' => $module]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Module $module)
    {
        $module->load(['chassis', 'propulsion', 'wheel', 'steeringWheel', 'chair']);
        return view('modules.edit', [
            'module' => $module,
            'modules' => $this->modules]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ModuleRequest $request, Module $module)
    {
        $this->moduleUpdateService->updateModule($module, $request->validated());

        return redirect()->route('modules.show', $module)
            ->with('succes', 'Module succesvol geüpdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Module $module)
    {
        $module->delete();

        return redirect()->route('modules.index')
            ->with('succes', 'Module succesvol verwijderd!');;
    }
}
