<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Trip; // Import the Trip Model
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Needed to generate a unique ID

class TripController extends Controller
{
    
     // Display a listing of the resource (all trips), with related data.
     
    public function index()
    {
        return Trip::with(['vehicle', 'drivingEvents'])->get();
    }

    
     // Store a newly created resource in storage (create a new trip).
     
    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|string|max:30|exists:vehicle,vehicle_id', 
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',  
            'distance' => 'required|numeric|min:0',        
            'average_speed' => 'required|numeric|min:0',   
            'fuel_consumed' => 'required|numeric|min:0',   
        ]);

        $validated['trip_id'] = (string) Str::uuid(); // Generate UUID for VARCHAR(30)
        $trip = Trip::create($validated);
        return response()->json($trip, 201);
    }

    
     // Display the specified resource (show a single trip) with related data.
     
    public function show(string $trip_id)
    {
        return Trip::with(['vehicle', 'drivingEvents'])->findOrFail($trip_id);
    }

    
     // Update the specified resource in storage.  NEW CRUD METHOD
     
    public function update(Request $request, string $trip_id)
    {
        $trip = Trip::findOrFail($trip_id);

        $validated = $request->validate([
            'vehicle_id' => 'sometimes|required|string|max:30|exists:vehicle,vehicle_id', 
            
            'start_time' => 'sometimes|required|date',
            // Rule needs to check against start_time (from request or existing model)
            'end_time' => 'sometimes|required|date|after:start_time',
            
            'distance' => 'sometimes|required|numeric|min:0',        
            'average_speed' => 'sometimes|required|numeric|min:0',   
            'fuel_consumed' => 'sometimes|required|numeric|min:0',   
        ]);

        $trip->update($validated);

        return response()->json($trip);
    }

     // Remove the specified resource from storage.  NEW CRUD METHOD
     
    public function destroy(string $trip_id)
    {
        $trip = Trip::findOrFail($trip_id);
        $trip->delete();
        return response()->json(null, 204);
    }
}
