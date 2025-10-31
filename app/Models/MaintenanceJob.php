<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaintenanceJob extends Model
{
    use HasFactory;
    
    // --- Custom Configuration for Existing maintenance_job Table ---
    protected $table = 'maintenance_job'; 
    protected $primaryKey = 'job_id'; 
    public $incrementing = false; 
    protected $keyType = 'string'; 

    protected $fillable = [
        'job_id',
        'vehicle_id',            // Foreign key (VARCHAR)
        'maintenance_type_id',   // Foreign key (INT)
        'cost',                  // decimal(8,2)
        'date_performed',        // date or datetime
        'notes',                 // varchar(255)
    ];

    protected $casts = [
        'date_performed' => 'date',
    ];

    
     // A MaintenanceJob belongs to a single Vehicle.
     
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id', 'vehicle_id');
    }

    
     // A MaintenanceJob belongs to a specific MaintenanceType.
     
    public function maintenanceType(): BelongsTo
    {
        return $this->belongsTo(MaintenanceType::class, 'maintenance_type_id', 'maintenance_type_id');
    }
}
