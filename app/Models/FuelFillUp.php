<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FuelFillUp extends Model
{
    use HasFactory;
    
    // --- Custom Configuration for Existing fuel_fill_up Table ---
    protected $table = 'fuel_fill_up'; 
    protected $primaryKey = 'fill_up_id'; 
    public $incrementing = false; 
    protected $keyType = 'string'; 

    protected $fillable = [
        'fill_up_id',
        'vehicle_id',        // Foreign key
        'date',              // Date of fill-up
        'volume_liters',     // Decimal/numeric
        'cost',              // Decimal/numeric
        'odometer_reading',  // Integer or numeric
    ];

    protected $casts = [
        'date' => 'date',
    ];
  
     // A FuelFillUp belongs to a single Vehicle.
 
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id', 'vehicle_id');
    }
}
