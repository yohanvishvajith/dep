<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    // function vehicleOverview(){
    //     return view('display_vehicle');
    // }

    function vehicles()
    {
        $vehicles = Vehicle::with('images')->where('is_available', '1')->paginate(3);
        return view('vehicles', compact('vehicles'));
    }

    function vehicleDetails($vehicle_id)
    {
        $vehicle = Vehicle::with(['images', 'reviews' => function($query) {
            $query->with('user')
                  ->where('is_approved', true)
                  ->orderBy('created_at', 'desc')
                  ->limit(6); // Limit to 6 most recent reviews
        }])->where('vehicle_id', $vehicle_id)->first();
        
        return view('display_vehicle', compact('vehicle'));
    }
}
