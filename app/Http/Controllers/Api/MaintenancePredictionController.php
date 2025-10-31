<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MaintenancePrediction; // Import the MaintenancePrediction Model
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Needed to generate a unique ID

class MaintenancePredictionController extends Controller
{
     // Display a listing of the resource (all maintenance predictions), with related data.
  
    public function index()
    {
        return MaintenancePrediction::with('vehicle')->get();
    }

   
     // Store a newly created resource in storage (create a new prediction).
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|string|max:30|exists:vehicle,vehicle_id',         
            'maintenance_type_id' => 'required|integer|exists:maintenance_type,maintenance_type_id',         
            'predicted_date' => 'required|date',            
            'confidence_score' => 'required|numeric|min:0|max:100', // Assuming a 0-100 score
        ]);

        $validated['prediction_id'] = (string) Str::uuid(); // Generate UUID for VARCHAR(30)
        $prediction = MaintenancePrediction::create($validated);
        return response()->json($prediction, 201);
    }


     // Display the specified resource (show a single maintenance prediction) with related data.
 
    public function show(string $prediction_id)
    {
        return MaintenancePrediction::with('vehicle')->findOrFail($prediction_id);
    }

    
     // Update the specified resource in storage. NEW CRUD METHOD

    public function update(Request $request, string $prediction_id)
    {
        $prediction = MaintenancePrediction::findOrFail($prediction_id);

        $validated = $request->validate([
            'vehicle_id' => 'sometimes|required|string|max:30|exists:vehicle,vehicle_id', 
            'maintenance_type_id' => 'sometimes|required|integer|exists:maintenance_type,maintenance_type_id',             
            'predicted_date' => 'sometimes|required|date',
            'confidence_score' => 'sometimes|required|numeric|min:0|max:100', 
        ]);

        $prediction->update($validated);

        return response()->json($prediction);
    }

    
     // Remove the specified resource from storage. NEW CRUD METHOD
   
    public function destroy(string $prediction_id)
    {
        $prediction = MaintenancePrediction::findOrFail($prediction_id);
        $prediction->delete();
        return response()->json(null, 204);
    }
}
