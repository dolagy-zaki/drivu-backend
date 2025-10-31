<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DrivingEvent; // Import the DrivingEvent Model
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Needed to generate a unique ID

class DrivingEventController extends Controller
{
   
     // Display a listing of the resource (all driving events), with related Trip data.
     
    public function index()
    {
        return DrivingEvent::with('trip')->get();
    }

    
     // Store a newly created resource in storage (create a new driving event).
     
    public function store(Request $request)
    {
        $validated = $request->validate([
            'trip_id' => 'required|string|max:30|exists:trip,trip_id', 
            'type' => 'required|string|max:50',
            'time' => 'required|date',
            'severity' => 'required|integer|min:1|max:5', 
        ]);

        $validated['event_id'] = (string) Str::uuid(); // Generate UUID for VARCHAR(30)
        $event = DrivingEvent::create($validated);
        return response()->json($event, 201);
    }

  
     // Display the specified resource (show a single driving event) with related Trip data.
  
    public function show(string $event_id)
    {
        return DrivingEvent::with('trip')->findOrFail($event_id);
    }

    
     // Update the specified resource in storage. NEW CRUD METHOD
 
    public function update(Request $request, string $event_id)
    {
        $event = DrivingEvent::findOrFail($event_id);

        $validated = $request->validate([
            'trip_id' => 'sometimes|required|string|max:30|exists:trip,trip_id', 
            'type' => 'sometimes|required|string|max:50',
            'time' => 'sometimes|required|date',
            'severity' => 'sometimes|required|integer|min:1|max:5', 
        ]);

        $event->update($validated);
        return response()->json($event);
    }

   
     // Remove the specified resource from storage. NEW CRUD METHOD

    public function destroy(string $event_id)
    {
        $event = DrivingEvent::findOrFail($event_id);
        $event->delete();
        return response()->json(null, 204);
    }
}
