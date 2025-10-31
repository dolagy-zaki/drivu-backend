<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceJob; // Import the MaintenanceJob Model
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Needed to generate a unique ID

class MaintenanceJobController extends Controller
{
    
     // Display a listing of the resource (all maintenance jobs), with related data.

    public function index()
    {
        return MaintenanceJob::with(['vehicle', 'maintenanceType'])->get();
    }

     // Store a newly created resource in storage (create a new maintenance job).
     
    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|string|max:30|exists:vehicle,vehicle_id', 
            'maintenance_type_id' => 'required|integer|exists:maintenance_type,maintenance_type_id', 
            'cost' => 'required|numeric|min:0',        
            'date_performed' => 'required|date',            
            'notes' => 'nullable|string|max:255', 
        ]);

        $validated['job_id'] = (string) Str::uuid(); // Generate UUID for VARCHAR(30)
        $job = MaintenanceJob::create($validated);
        return response()->json($job, 201);
    }

     // Display the specified resource (show a single maintenance job) with related data.
     
    public function show(string $job_id)
    {
        return MaintenanceJob::with(['vehicle', 'maintenanceType'])->findOrFail($job_id);
    }

    
     // Update the specified resource in storage. NEW CRUD METHOD
     
    public function update(Request $request, string $job_id)
    {
        $job = MaintenanceJob::findOrFail($job_id);

        $validated = $request->validate([
            'vehicle_id' => 'sometimes|required|string|max:30|exists:vehicle,vehicle_id', 
            'maintenance_type_id' => 'sometimes|required|integer|exists:maintenance_type,maintenance_type_id',           
            'cost' => 'sometimes|required|numeric|min:0',        
            'date_performed' => 'sometimes|required|date',
            'notes' => 'nullable|string|max:255',
        ]);

        $job->update($validated);

        return response()->json($job);
    }

    
     // Remove the specified resource from storage. NEW CRUD METHOD
   
    public function destroy(string $job_id)
    {
        $job = MaintenanceJob::findOrFail($job_id);
        $job->delete();
        return response()->json(null, 204);
    }
}
