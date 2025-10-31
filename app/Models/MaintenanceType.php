<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MaintenanceType extends Model
{
    use HasFactory;
    
    // --- Custom Configuration for Existing maintenance_type Table ---
    protected $table = 'maintenance_type'; 
    protected $primaryKey = 'maintenance_type_id'; 
    // Uses default INT key setup (auto-incrementing)

    protected $fillable = [
        'maintenance_type_id',
        'name',
        'description',
    ];

   
     // A MaintenanceType can have many MaintenanceJobs performed.
   
    public function maintenanceJobs(): HasMany
    {
        
        return $this->hasMany(MaintenanceJob::class, 'maintenance_type_id', 'maintenance_type_id');
    }

}
