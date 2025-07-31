<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Counter;
  use App\Models\Counterassign;

class Queuecontroller extends Controller
{
    //
    public function index()
    {
             $servingTickets = Ticket::where('status', 'serving')
    ->whereHas('service.counterservices.counter', function ($query) {
        $query->where('branch_id', 1);
    })
    ->with(['service.counterservices.counter'])
    ->get()
    ->map(function ($ticket) {
        // Get first counter (in case there are multiple)
        $counter = optional($ticket->service->counterservices->first())->counter;

        return [
            'ticket_id' => $ticket->id,
            'counter_name' => $counter?->name ?? 'N/A',
        ];
    });


        $waitingTickets = Ticket::where('status', 'waiting')
        ->where('branch_id', 1) // Assuming branch_id is 1 for the current branch
            ->get();



$counters = Counterassign::with(['counter', 'user'])
    ->whereHas('user', function($query) {
        $query->where('branch_id', 1);
    })
    ->get()
    ->map(function($assign) {
        return [
            'counter_name' => $assign->counter->name ?? 'N/A',
            'user_name' => $assign->user->name ?? 'N/A',
        ];
    });
     
        return view('queue', compact('servingTickets', 'waitingTickets', 'counters')); // Assuming you have a view named 'queue'
    }
}
