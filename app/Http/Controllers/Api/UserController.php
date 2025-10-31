<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User; // Import the User Model
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Needed to generate a unique ID
use Illuminate\Validation\Rule; // Needed for the 'unique' rule in update

class UserController extends Controller
{
    
     // Display a listing of the resource (all users), with their vehicles eagerly loaded.

    public function index()
    {
        return User::with('vehicles')->get();
    }

    
     // Store a newly created resource in storage (create a new user).

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100', 
            'email' => 'required|email|unique:user,email|max:100', 
            'phone_number' => 'nullable|string|max:20',
            'role' => 'required|string|in:driver,manager,admin', // Restricted values
        ]);

        $validated['user_id'] = (string) Str::uuid(); 

        $user = User::create($validated);

        return response()->json($user, 201);
    }

    
     // Display the specified resource (show a single user), with all their vehicles eagerly loaded.
     
    public function show(string $user_id)
    {
        return User::with('vehicles')->findOrFail($user_id);
    }

    
     // Update the specified resource in storage.
     
    public function update(Request $request, string $user_id)
    {
        $user = User::findOrFail($user_id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:100', 
            'email' => ['sometimes', 'required', 'email', 'max:100', Rule::unique('user', 'email')->ignore($user->user_id, 'user_id')],
            'phone_number' => 'sometimes|nullable|string|max:20',
            'role' => 'sometimes|required|string|in:driver,manager,admin', 
        ]);

        $user->update($validated);

        return response()->json($user);
    }

     // Remove the specified resource from storage.
   
    public function destroy(string $user_id)
    {
        $user = User::findOrFail($user_id);
        $user->delete();
        return response()->json(null, 204);
    }
}
