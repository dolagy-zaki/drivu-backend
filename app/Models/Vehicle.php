<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    use HasFactory;
    
    // --- Custom Configuration for Existing vehicle Table ---
    protected $table = 'vehicle'; 
    protected $primaryKey = 'vehicle_id'; 
    public $incrementing = false; 
    protected $keyType = 'string'; 

    protected $fillable = [
        'vehicle_id',
        'user_id', // Foreign key to the 'user' table
        'model',
        'year',
        'fuel_tank_capacity', // Decimal type
    ];

  

    
     // A Vehicle belongs to a single User (owner/driver).
     
    public function user(): BelongsTo
    {
        // The foreign key 'user_id' exists on this model (Vehicle).
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

  
     // A Vehicle has many Trips.
   
    public function trips(): HasMany
    {
        return $this->hasMany(Trip::class, 'vehicle_id', 'vehicle_id');
    }

   
     // A Vehicle has many FuelFillUps.
 
    public function fuelFillUps(): HasMany
    {
        return $this->hasMany(FuelFillUp::class, 'vehicle_id', 'vehicle_id');
    }

    
     // A Vehicle has many MaintenanceJobs performed on it.

    public function maintenanceJobs(): HasMany
    {
        return $this->hasMany(MaintenanceJob::class, 'vehicle_id', 'vehicle_id');
    }

    
     // A Vehicle has many MaintenancePredictions.
     
    public function maintenancePredictions(): HasMany
    {
        return $this->hasMany(MaintenancePrediction::class, 'vehicle_id', 'vehicle_id');
    }

}
