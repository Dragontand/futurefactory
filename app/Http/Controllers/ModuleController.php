<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Http\Requests\ModuleRequest;
use App\Models\Modules\Chassis;
use App\Services\ModuleCreationService;
use App\Services\ModuleUpdateService;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    private ModuleCreationService $creationService;
    private ModuleUpdateService $updateService;

    public function __construct(ModuleCreationService $creationService, ModuleUpdateService $updateService)
    {
        $this->creationService = $creationService;
        $this->updateService = $updateService;
    }

    private $moduleTypes = [
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
        if (session('module_type')) session()->forget('module_type');

        $modules = Module::with(['chassis', 'propulsion', 'wheel', 'steeringWheel', 'chair'])->latest()->simplePaginate(15);
        
        return view('modules.index', compact('modules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $chassisByType = Chassis::with('module')->get()->groupBy('type');
        $moduleTypes = $this->moduleTypes;

        return view('modules.create', compact('chassisByType', 'moduleTypes'));
    }

    /**
     * For cancelling the session
     */
    public function cancel()
    {
        session()->forget('module_type');
        return redirect()->route('modules.create');
    }

    /**
     * Store the type in the session
     */
    public function storeType(Request $request)
    {
        $request->validate([
            'type' => 'required|in:' . implode(",", array_keys($this->moduleTypes))
        ]);

        session(['module_type' => $request->type]);

        return redirect()->route('modules.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ModuleRequest $request)
    {
        $this->creationService->createModule(session('module_type'), $request->validated());

        session()->forget('module_type');

        return redirect()->route('modules.index')
            ->with('successs', 'Module successsfully created!');;
    }

    /**
     * Display the specified resource.
     */
    public function show(Module $module)
    {
        $module->load(['wheel.compatibleChassis.module']);
        return view('modules.show', compact('module'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Module $module)
    {
        $module->load(['chassis', 'propulsion', 'wheel', 'steeringWheel', 'chair']);
        return view('modules.edit', [
            'module' => $module,
            'modules' => $this->moduleTypes]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ModuleRequest $request, Module $module)
    {
        $this->updateService->updateModule($module, $request->validated());

        return redirect()->route('modules.show', $module)
            ->with('success', 'Module successsfully edited!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Module $module)
    {
        $module->delete();

        return redirect()->route('modules.index')
            ->with('successs', 'Module successsfully deleted!');;
    }
}
