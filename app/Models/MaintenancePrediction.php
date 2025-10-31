<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaintenancePrediction extends Model
{
    use HasFactory;
    
    // --- Custom Configuration for Existing maintenance_prediction Table ---
    protected $table = 'maintenance_prediction'; 
    protected $primaryKey = 'prediction_id'; 
    public $incrementing = false; 
    protected $keyType = 'string'; 

    protected $fillable = [
        'prediction_id',
        'vehicle_id',            // Foreign key (VARCHAR)
        'maintenance_type_id',   // Foreign key (INT)
        'predicted_date',        // date
        'confidence_score',      // decimal(5,2)
    ];

    protected $casts = [
        'predicted_date' => 'date',
    ];


    
     // A MaintenancePrediction belongs to a single Vehicle.
 
    public function vehicle(): BelongsTo
    {
      
        return $this->belongsTo(Vehicle::class, 'vehicle_id', 'vehicle_id');
    }

}
