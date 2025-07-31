<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Counterassign extends Model
{
    use HasFactory;

    protected $fillable = [
        'counter_id',
        'incharge'
    ];

    /**
     * Get the counter that this assignment belongs to
     */
    public function counter()
    {
        return $this->belongsTo(Counter::class);
    }

    /**
     * Get the user who is in charge (assuming incharge is user_id)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'incharge');
    }

    /**
     * Scope to get assignments by counter
     */
    public function scopeByCounter($query, $counterId)
    {
        return $query->where('counter_id', $counterId);
    }

    /**
     * Scope to get assignments by incharge person
     */
    public function scopeByIncharge($query, $incharge)
    {
        return $query->where('incharge', $incharge);
    }
}