<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Http\Requests\StoreVehicleRequest;
use App\Http\Requests\UpdateVehicleRequest;
use App\Models\Module;
use App\Models\Modules\Chair;
use App\Models\Modules\Chassis;
use App\Models\Modules\Propulsion;
use App\Models\Modules\SteeringWheel;
use App\Models\Modules\Wheel;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vehicles = Vehicle::with(['chassis', 'propulsion', 'wheel', 'steeringWheel', 'chair'])->latest()->simplePaginate(15);
        return view('vehicles.index', [
            'vehicles' => $vehicles
        ]);
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vehicles.create', [
            'chassisModules'      => Chassis::with('module')->get(),
            'propulsionModules'   => Propulsion::with('module')->get(),
            'wheelModules'        => Wheel::with('module')->get(),
            'steeringWheelModules'=> SteeringWheel::with('module')->get(),
            'chairModules'        => Chair::with('module')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVehicleRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Vehicle $vehicle)
    {
        return view('vehicles.show', [
            'vehicle' => $vehicle
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();

        return redirect()->route('vehicles.index')
            ->with('succes', 'Vehicle succesvol verwijderd!');;
    }
}
