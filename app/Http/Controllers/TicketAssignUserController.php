<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketUser;
use App\Models\User;
use Illuminate\Http\Request;

class TicketAssignUserController extends Controller
{
    public function index(Ticket $ticket)
    {
        $data = [
            'ticket' => $ticket,
            'users' => User::get(['id','name'])
        ];


        return view('tickets.modals.user', $data);
    }

    public function store(Request $request, Ticket $ticket)
    {
        $data = $request->validate([
            'user' => 'required'
        ]);

        TicketUser::updateOrCreate(['ticket_id' => $ticket->id, 'is_primary' => true], ['user_id' => $data['user']]);

        return [
            'status' => 1,
            'message' => 'Operatore assegnato!',
            'timeout' => 4000,
            'refresh' => true
        ];
    }
}
