<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceType; // Import the MaintenanceType Model
use Illuminate\Http\Request;

class MaintenanceTypeController extends Controller
{
    
     // Display a listing of the resource (all maintenance types), with related jobs.
     
    public function index()
    {
        return MaintenanceType::with('maintenanceJobs')->get();
    }

    
     // Store a newly created resource in storage (create a new maintenance type).
     
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:maintenance_type,name', // Added uniqueness check
            'description' => 'nullable|string|max:255', 
        ]);

        $type = MaintenanceType::create($validated);

        return response()->json($type, 201);
    }

    
     // Display the specified resource (show a single maintenance type) with related jobs.
     
    public function show(string $maintenance_type_id)
    {
        return MaintenanceType::with('maintenanceJobs')->findOrFail($maintenance_type_id);
    }
    

     // Update the specified resource in storage. NEW CRUD METHOD
 
    public function update(Request $request, string $maintenance_type_id)
    {
        $type = MaintenanceType::findOrFail($maintenance_type_id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:100|unique:maintenance_type,name,' . $maintenance_type_id . ',maintenance_type_id', 
            'description' => 'nullable|string|max:255',
        ]);

        $type->update($validated);
        return response()->json($type);
    }


     // Remove the specified resource from storage. NEW CRUD METHOD
 
    public function destroy(string $maintenance_type_id)
    {
        $type = MaintenanceType::findOrFail($maintenance_type_id);
        $type->delete();
        return response()->json(null, 204);
    }
}
