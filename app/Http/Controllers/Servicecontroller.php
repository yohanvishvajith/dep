<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\BranchService;

class Servicecontroller extends Controller
{
    function add(Request $request)
    {
       $result= Service::create([
            'name' => $request->input('serviceName'),
        ]);
//branch service model service id
       $branchService = new BranchService();
       $branchService->branch_id = '1';
       $branchService->service_id = $result->id;
       $branchService->save();

        return redirect()->back()->with('success', 'Service added successfully!');
    }
}
