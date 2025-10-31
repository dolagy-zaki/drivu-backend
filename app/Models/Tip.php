<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// Import the necessary related models
use App\Models\User;
use App\Models\MaintenancePrediction;

class Tip extends Model
{
    use HasFactory;
    
    // --- Custom Configuration for Existing tip Table ---
    protected $table = 'tip'; 
    protected $primaryKey = 'tip_id'; 
    public $incrementing = false; 
    protected $keyType = 'string'; 

    protected $fillable = [
        'tip_id',
        'user_id',          // Foreign key to User
        'prediction_id',    // Foreign key to MaintenancePrediction
        'description',      // Text content of the tip
        'date_created',     // Date the tip was issued/created
    ];

    protected $casts = [
        'date_created' => 'date',
    ];

     // A Tip belongs to a single User.  Assumes 'user_id' foreign key on the 'tip' table links to the 'user_id' primary key on the 'user' table.
   
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

  
     // A Tip belongs to a single MaintenancePrediction.  The foreign key is 'prediction_id' on this model (Tip).

    public function maintenancePrediction(): BelongsTo
    {
        // The MaintenancePrediction model uses 'prediction_id' as its primary key.
        return $this->belongsTo(MaintenancePrediction::class, 'prediction_id', 'prediction_id');
    }
}
