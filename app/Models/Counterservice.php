<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Counterservice extends Model
{
    use HasFactory;

    protected $fillable = [
        'counter_id',
        'service_id'
    ];

    /**
     * Get the counter that this service is associated with
     */
    public function counter()
    {
        return $this->belongsTo(Counter::class);
    }

    /**
     * Get the service that this counter provides
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
 public function counterassigns()
    {
        return $this->hasMany(Counterassign::class, 'counter_id', 'counter_id');
    }
    /**
     * Scope to get counterservices by branch
     */
    public function scopeByBranch($query, $branchId)
    {
        return $query->whereHas('counter', function($q) use ($branchId) {
            $q->where('branch_id', $branchId);
        });
    }

    /**
     * Scope to get counterservices by service
     */
    public function scopeByService($query, $serviceId)
    {
        return $query->where('service_id', $serviceId);
    }
}
