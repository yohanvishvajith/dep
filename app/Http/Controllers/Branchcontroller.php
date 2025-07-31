<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BranchService;
use App\Models\Service;
use App\Models\Counter;
use App\Models\User;
use App\Models\Counterassign;
use App\Models\Counterservice;

class Branchcontroller extends Controller
{
    function index(){
        $services = Service::whereHas('branchServices', function($query) {
            $query->where('branch_id', 1);
        })->get(['id', 'name'])->toArray();
        $totalemployees = User::where('branch_id', 1)->count();
        $totalservices = Service::whereHas('branchServices', function($query) {
            $query->where('branch_id', 1);
        })->count();
        $totalcounters = Counter::where('branch_id', 1)->count();
        $employees = User::where('branch_id', 1)->get(['id', 'name'])->toArray();
        $counters = Counter::all()->where('branch_id', '1');
        
        // Get Counter assignments with Counter ID and User Name
        $counterAssignments = Counterassign::with(['counter', 'user'])
            ->whereHas('counter', function($query) {
                $query->where('branch_id', 1);
            })
            ->get()
            ->map(function($assignment) {
                return [
                    'counter_name' => $assignment->counter->name ?? 'N/A',
                    'user_name' => $assignment->user->name ?? 'N/A',
                ];
            });
        $serviceassign = Counterassign::with(['counter', 'user'])
            ->whereHas('counter', function($query) {
                $query->where('branch_id', 1);
            })
            ->get()
            ->map(function($assignment) {
                // Get services assigned to this counter
                $assignedServices = Counterservice::where('counter_id', $assignment->counter_id)
                    ->with('service')
                    ->get()
                    ->pluck('service.name')
                    ->toArray();

                return [
                    'counter' => $assignment->counter->name ?? 'N/A',
                    'incharge' => $assignment->user->name ?? 'N/A',
                    'assigned_services' => $assignedServices
                ];
            });

           // dd($serviceassign);
           return view('manager-dashboard', compact('services', 'counters', 'employees', 'counterAssignments', 'serviceassign','totalemployees','totalservices','totalcounters'));
    }

    function counterAssign(Request $request)
    {
        Counterassign::create([
            'incharge' => $request->input('incharge'),
            'counter_id' => $request->input('counter_id')
        ]);

        return redirect()->back()->with('success', 'Counter assigned successfully.');
    }
}