<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BranchService;
use App\Models\Counterservice;

class Assignservicecontroller extends Controller
{
public function add(Request $request)
{
    // Validate inputs
    $counterId = $request['counter_id'];
    $serviceIds = $request['service_ids'] ?? [];
    if (!is_array($serviceIds)) {
        $serviceIds = [];
    }

    // Get existing service IDs for this counter
    $existingServiceIds = Counterservice::where('counter_id', $counterId)
        ->whereIn('service_id', $serviceIds)
        ->pluck('service_id')
        ->toArray();

    // Filter out already assigned service_ids
    $newServiceIds = array_diff($serviceIds, $existingServiceIds);

    // Insert only new assignments
    foreach ($newServiceIds as $serviceId) {
        Counterservice::create([
            'counter_id' => $counterId,
            'service_id' => $serviceId,
            'branch_id' => 1, // Assuming branch_id is always 1 for this example
        ]);
    }
    return redirect()->back()->with('success', 'Services assigned successfully!');

}}
