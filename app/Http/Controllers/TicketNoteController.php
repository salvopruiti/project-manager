<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketNote;
use App\Models\TicketUser;
use Illuminate\Http\Request;

class TicketNoteController extends Controller
{
    public function index(Ticket $ticket)
    {
        return view('tickets.modals.note', ['ticket' => $ticket]);
    }

    public function show(Ticket $ticket, TicketNote $note)
    {
        if($note->ticket_id != $ticket->id)
            abort(404);

        return $note;
    }

    public function store(Request $request, Ticket $ticket)
    {
        $data = $request->validate([
            'note' => 'required'
        ]);

        TicketUser::updateOrCreate(['ticket_id' => $ticket->id, 'user_id' => auth()->id()], ['is_primary' => false]);

        $ticket->notes()->create(['user_id' => auth()->id()] + $data);

        return [
            'status' => 1,
            'selector' => '.notes-container',
            'html' => view('tickets.parts.notes', ['ticket' => $ticket->load('notes.user:id,name')])->render(),
        ];
    }

    public function destroy(Ticket $ticket, TicketNote $note)
    {
        $note->delete();

        return [
            'status' => 1,
            'selector' => '.notes-container',
            'html' => view('tickets.parts.notes', ['ticket' => $ticket->load('notes.user:id,name')])->render(),
        ];
    }
}
