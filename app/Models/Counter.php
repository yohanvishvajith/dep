<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Counter extends Model
{
    //
     protected $fillable = [
        'name',
        'branch_id',
    ];
    public function branch()
{
    return $this->belongsTo(Branch::class);
}

public function counterassigns()
{
    return $this->hasMany(Counterassign::class);
}
}
