<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'service_id',
        'customer_name',
        'mobile_number',
    ];


    /**
     * Get the branch that owns the ticket.
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * Get the service that owns the ticket.
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
