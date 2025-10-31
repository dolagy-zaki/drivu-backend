<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tip; // Import the Tip Model
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Needed to generate a unique ID

class TipController extends Controller
{
    
     // Display a listing of the resource (all tips), with related data.
     
    public function index()
    {
        return Tip::with(['user', 'maintenancePrediction'])->get();
    }

    
     // Store a newly created resource in storage (create a new tip).
     
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|string|max:30|exists:user,user_id', 
            'prediction_id' => 'required|string|max:30|exists:maintenance_prediction,prediction_id',         
            'description' => 'required|string', 
            'date_created' => 'required|date',
        ]);

        $validated['tip_id'] = (string) Str::uuid(); 
        $tip = Tip::create($validated);
        return response()->json($tip, 201);
    }

    
     // Display the specified resource (show a single tip) with related data.
     
    public function show(string $tip_id)
    {
        return Tip::with(['user', 'maintenancePrediction'])->findOrFail($tip_id);
    }

     // Update the specified resource in storage.  NEW CRUD METHOD
     
    public function update(Request $request, string $tip_id)
    {
        $tip = Tip::findOrFail($tip_id);

        $validated = $request->validate([
            'user_id' => 'sometimes|required|string|max:30|exists:user,user_id', 
            'prediction_id' => 'sometimes|required|string|max:30|exists:maintenance_prediction,prediction_id',          
            'description' => 'sometimes|required|string', 
            'date_created' => 'sometimes|required|date',
        ]);

        $tip->update($validated);
        return response()->json($tip);
    }

     // Remove the specified resource from storage. NEW CRUD METHOD
    public function destroy(string $tip_id)
    {
        $tip = Tip::findOrFail($tip_id);
        $tip->delete();
        return response()->json(null, 204);
    }
}
