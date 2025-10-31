<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Trip extends Model
{
    use HasFactory;
    
    // --- Custom Configuration for Existing Trip Table ---
    protected $table = 'trip'; 
    protected $primaryKey = 'trip_id'; 
    public $incrementing = false; 
    protected $keyType = 'string'; 

    protected $fillable = [
        'trip_id',
        'vehicle_id', // Foreign key to the 'vehicle' table
        'start_time',
        'end_time',   
        'distance',
        'average_speed',
        'fuel_consumed',
    ];

    // Optional: Cast datetime fields
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];


     // A Trip belongs to a single Vehicle.
     
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id', 'vehicle_id');
    }

    
     // A Trip has many DrivingEvents.
     
    public function drivingEvents(): HasMany
    {
        return $this->hasMany(DrivingEvent::class, 'trip_id', 'trip_id');
    }
}
