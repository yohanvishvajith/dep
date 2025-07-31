<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    /**
     * Get the tickets for the service.
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
    public function counterservices()
    {
        return $this->hasMany(Counterservice::class, 'service_id');
    }
    /**
     * Get the branches that offer this service.
     */
    public function branches()
    {
        return $this->belongsToMany(Branch::class, 'branch_service');
    }
       public function branchServices(): HasMany
    {
        return $this->hasMany(BranchService::class);
    }
}
