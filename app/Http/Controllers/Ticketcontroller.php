<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Ticket;
use App\Models\Branch;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Ticketcontroller extends Controller
{
    function index(){
        //services for branch id 1
        $branchId = Auth::check() && Auth::user()->branch_id ? Auth::user()->branch_id : 1; // Default to branch 1 if not authenticated
        $services = Service::whereHas('branchServices', function($query) use ($branchId) {
            $query->where('branch_id', $branchId);
        })->get(['id', 'name'])->toArray();
      
        //dd($services);
        return view('ticketissue', compact('services'));
    }

    function ticketissue(Request $request){
        try {
            // Validate the request
            $request->validate([
                'service_id' => 'required|exists:services,id',
                'customer_name' => 'required|string|max:255',
                'mobile_number' => 'required|string|size:10'
            ]);

            // Get the authenticated user's branch (assuming user has a branch_id)
            // If you don't have auth yet, you can use a default branch or the first branch
            $branchId = Auth::check() && Auth::user()->branch_id ? Auth::user()->branch_id : Branch::first()->id;

            // Create the ticket
            $ticket = Ticket::create([
                'branch_id' => $branchId,
                'service_id' => $request->service_id,
                'customer_name' => $request->customer_name,
                'mobile_number' => $request->mobile_number,
            ]);

            // Load relationships
            $ticket->load(['branch', 'service']);

            // Prepare response data
            $responseData = [
                'success' => true,
                'ticket' => [
                    'id' => $ticket->id,
                    'branch_name' => $ticket->branch ? $ticket->branch->name : 'Main Branch',
                    'service_name' => $ticket->service->name,
                    'customer_name' => $ticket->customer_name,
                    'mobile' => $ticket->mobile_number,
                    'issued_at' => $ticket->created_at->format('Y-m-d H:i:s'),
                ]
            ];

            return response()->json($responseData);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error generating ticket: ' . $e->getMessage()
            ], 500);
        }
    }

    function staffView(){
        return view('counter');
    }
}
