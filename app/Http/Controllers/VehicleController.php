<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Http\Requests\VehicleRequest;
use App\Models\Modules\Chair;
use App\Models\Modules\Chassis;
use App\Models\Modules\Propulsion;
use App\Models\Modules\SteeringWheel;
use App\Models\Modules\Wheel;
use App\Services\VehicleCreationService;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    private VehicleCreationService $creationService;

    public function __construct(VehicleCreationService $creationService)
    {
        $this->creationService = $creationService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Nested eager loading
        $vehicles = Vehicle::with([
            'chassis.module',
            'propulsion.module',
            'wheel.module',
            'steeringWheel.module',
            'chair.module'
        ])->latest()->simplePaginate(15);

        return view('vehicles.index', compact('vehicles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $chassisModules = Chassis::with('module')->get();
        
        return view('vehicles.create', [
            'chassisModules' => $chassisModules,
            // These are empty because they will be given in the next request
            'propulsionModules'    => collect(),
            'wheelModules'         => collect(),
            'steeringWheelModules' => collect(),
            'chairModules'         => collect(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createStep2(Request $request)
    {
        $selectedChassis = Chassis::findOrFail($request->chassis_module_id);
        return view('vehicles.create', [
            'selectedChassis'       => $selectedChassis,
            'name'                  => $request->name,
            // This is empty because it was given in the previous request
            'chassisModules'        => collect(),
            'propulsionModules'     => Propulsion::with('module')->get(),
            'wheelModules'          => $selectedChassis->compatibleWheels,
            'steeringWheelModules'  => SteeringWheel::with('module')->get(),
            'chairModules'          => Chair::with('module')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VehicleRequest $request)
    {
        $this->creationService->createVehicle($request->validated());

        return redirect()->route('vehicles.index')
            ->with('success', 'Vehicle successfully created!');;
    }

    /**
     * Display the specified resource.
     */
    public function show(Vehicle $vehicle)
    {
        $vehicle->load(['chassis.module', 'propulsion.module', 'wheel.module', 'steeringWheel.module', 'chair.module']);

        $assemblyOrder = collect([
            ['label' => '1. Chassis',        'moduleType' => $vehicle->chassis->module],
            ['label' => '2. Propulsion',     'moduleType' => $vehicle->propulsion->module],
            ['label' => '3. Wheels',         'moduleType' => $vehicle->wheel->module],
            ['label' => '4. Steering wheel', 'moduleType' => $vehicle->steeringWheel->module],
            ['label' => '5. Chair',          'moduleType' => $vehicle->chair->module],
        ]);

        return view('vehicles.show', compact('vehicle', 'assemblyOrder'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();

        return redirect()->route('vehicles.index')
            ->with('success', 'Vehicle successfully deleted!');;
    }
}
