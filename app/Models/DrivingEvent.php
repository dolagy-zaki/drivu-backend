<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DrivingEvent extends Model
{
    use HasFactory;
    
    // --- Custom Configuration for Existing driving_event Table ---
    protected $table = 'driving_event'; 
    protected $primaryKey = 'event_id'; 
    public $incrementing = false; 
    protected $keyType = 'string'; 

    protected $fillable = [
        'event_id',
        'trip_id', // Foreign key to the 'trip' table
        'type',    // varchar(50)
        'time',    // datetime
        'severity', // tinyint(4)
    ];

    protected $casts = [
        'time' => 'datetime',
    ];


    
     // A DrivingEvent belongs to a single Trip.
    
    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class, 'trip_id', 'trip_id');
    }
}
