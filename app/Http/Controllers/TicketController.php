<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Http\Resources\TicketResource;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return TicketResource::collection(Ticket::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validateTicket($request);

        $infoTicket = [
            'user_id'     => $request->input('user_id'),
            'status_id'   => $request->input('status_id'),
            'description' => $request->input('description')
        ];

        $ticket = Ticket::create($infoTicket);

        return response()->json([
            "message"=>'Ticket created successfully',
            "id"=>$ticket->id
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        return new TicketResource($ticket);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        $this->validateTicket($request);
        $ticket->update($request->all());

        return new TicketResource($ticket);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return response()->json([
            "message"=>'Deleted successfully'
        ]);
    }

    /**
     * Se validan los datos del ticket
     */
    function validateTicket(Request $request){
        return $request->validate([
            'user_id' => 'required|numeric|exists:users,id',
            'status_id' => 'required|numeric|exists:statuses,id',
            'description' => 'required',
        ]);
    }
}
