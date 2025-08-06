<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Image;
use App\Models\Review;

class Vehicle extends Model
{
    use HasFactory;

    protected $primaryKey = 'vehicle_id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'brand', // Changed from 'make' to match migration
        'model',
        'fuel_type',
        'fuel_efficiency',
        'year',
        'color',
        'seats',
        'engine',
        'registration_number',
        'mileage',
        'daily_rate',
        'is_available'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'year' => 'integer',
        'seats' => 'integer',
        'daily_rate' => 'decimal:2',
        'is_available' => 'boolean',
    ];

    /**
     * Relationship with images
     */
    public function images()
    {
        return $this->hasMany(Image::class, 'vehicle_id');
    }

    /**
     * Relationship with reviews
     */
    public function reviews()
    {
        return $this->hasMany(Review::class, 'vehicle_id', 'vehicle_id')->where('is_approved', true);
    }

    /**
     * Accessor for featured image
     */
    public function getFeaturedImageAttribute()
    {
        return $this->images()->first()?->url ?? asset('images/default-vehicle.jpg');
    }

    /**
     * Get average rating for this vehicle
     */
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    /**
     * Get total review count for this vehicle
     */
    public function getReviewCountAttribute()
    {
        return $this->reviews()->count();
    }

    /**
     * Scope for available vehicles
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }
}

