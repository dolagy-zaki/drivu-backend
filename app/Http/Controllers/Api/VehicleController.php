<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vehicle; // Import the Vehicle Model
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Needed to generate a unique ID

class VehicleController extends Controller
{
    
    // Display a listing of the resource (all vehicles), with their owner eagerly loaded.
    
    public function index()
    {
        return Vehicle::with('user')->get();
    }

    
    // Store a newly created resource in storage (create a new vehicle).
     
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|string|max:30|exists:user,user_id', 
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1), // Year validation
            'fuel_tank_capacity' => 'required|numeric|min:0', // Decimal(5,2) validation
        ]);

        $validated['vehicle_id'] = (string) Str::uuid(); 
        $vehicle = Vehicle::create($validated);
        return response()->json($vehicle, 201);
    }

    
      // Display the specified resource (show a single vehicle), with ALL related data eagerly loaded.
     
    public function show(string $vehicle_id)
    {
        return Vehicle::with([
            'user', 
            'trips', 
            'fuelFillUps', 
            'maintenanceJobs',
            'maintenancePredictions',
            'tips'
        ])->findOrFail($vehicle_id);
    }

    
     // Update the specified resource in storage. NEW CRUD METHOD
     
    public function update(Request $request, string $vehicle_id)
    {
        $vehicle = Vehicle::findOrFail($vehicle_id);

        $validated = $request->validate([
            'user_id' => 'sometimes|required|string|max:30|exists:user,user_id', 
            'model' => 'sometimes|required|string|max:255',
            'year' => 'sometimes|required|integer|min:1900|max:' . (date('Y') + 1), 
            'fuel_tank_capacity' => 'sometimes|required|numeric|min:0', 
        ]);

        $vehicle->update($validated);

        return response()->json($vehicle);
    }


     // Remove the specified resource from storage. NEW CRUD METHOD
     
    public function destroy(string $vehicle_id)
    {
        $vehicle = Vehicle::findOrFail($vehicle_id);
        $vehicle->delete();
        return response()->json(null, 204);
    }
}