<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Counterassign;
use App\Models\Counterservice;
use App\Models\Service;
class Counterdashboardcontroller extends Controller
{
    //
    function index()
    {
    $tickets = Ticket::where('status', 'waiting')
        ->whereHas('service.counterservices.counterassigns', function($query) {
            $query->where('incharge', 1);
        })
        ->get();

   // dd($tickets);

        // Or if you want to be more specific with the relationships:
        // $tickets = Ticket::whereHas('service', function($serviceQuery) {
        //     $serviceQuery->whereHas('counterServices', function($counterServiceQuery) {
        //         $counterServiceQuery->whereHas('counterAssign', function($assignQuery) {
        //             $assignQuery->where('incharge', 1);
        //         });
        //     });
        // })->get();

        return view('counterdashboard', compact('tickets'));
    }

    function assigncounter($id)
    
    {
        $ticket = Ticket::findOrFail($id);
        // Update the ticket status to 'serving'
        $ticket->status = 'serving';
        $ticket->save();

        return redirect()->back();
    }

    function finishcounter($id, Request $request)
    {
        $ticket = Ticket::findOrFail($id);
        // Update the ticket status to 'completed'
        $ticket->status = $request->input('status');
        $ticket->save();

        return redirect()->back();
    }
}
