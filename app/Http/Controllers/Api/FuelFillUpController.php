<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FuelFillUp; // Import the FuelFillUp Model
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Needed to generate a unique ID

class FuelFillUpController extends Controller
{
  
     // Display a listing of the resource (all fuel fill-ups), with their vehicle eagerly loaded.
  
    public function index()
    {
        return FuelFillUp::with('vehicle')->get();
    }

  
     // Store a newly created resource in storage (create a new fill-up record).

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|string|max:30|exists:vehicle,vehicle_id', 
            'date' => 'required|date',
            'volume_liters' => 'required|numeric|min:0.01',
            'cost' => 'required|numeric|min:0.01',
            'odometer_reading' => 'required|integer|min:0',
        ]);

        $validated['fill_up_id'] = (string) Str::uuid(); 
        $fill_up = FuelFillUp::create($validated);
        return response()->json($fill_up, 201);
    }


     // Display the specified resource (show a single fill-up record), with its vehicle eagerly loaded.
  
    public function show(string $fill_up_id)
    {
        // Find the fill-up by its primary key and eager load the 'vehicle'.
        return FuelFillUp::with('vehicle')->findOrFail($fill_up_id);
    }

    
     // Update the specified resource in storage.
    
    public function update(Request $request, string $fill_up_id)
    {
        $fill_up = FuelFillUp::findOrFail($fill_up_id);

        $validated = $request->validate([
            'vehicle_id' => 'sometimes|required|string|max:30|exists:vehicle,vehicle_id', 
            'date' => 'sometimes|required|date',
            'volume_liters' => 'sometimes|required|numeric|min:0.01',
            'cost' => 'sometimes|required|numeric|min:0.01',
            'odometer_reading' => 'sometimes|required|integer|min:0',
        ]);

        $fill_up->update($validated);

        return response()->json($fill_up);
    }

    
     // Remove the specified resource from storage.
     
    public function destroy(string $fill_up_id)
    {
        $fill_up = FuelFillUp::findOrFail($fill_up_id);
        $fill_up->delete();
        return response()->json(null, 204);
    }
}
