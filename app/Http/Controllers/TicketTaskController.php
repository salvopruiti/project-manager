<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Tag;
use App\Models\Task;
use App\Models\Ticket;

class TicketTaskController extends Controller
{
    public function index(Ticket $ticket)
    {
        return (new TaskController())->edit(new Task(['ticket_id' => $ticket->id]));
    }
    public function store(Ticket $ticket, TaskRequest $request)
    {
        $ticket->tasks()->create($request->validated());

        return [
            'status' => 1,
            'selector' => '.tasks-container',
            'html' => view('tickets.parts.tasks', ['ticket' => $ticket->load('tasks')])->render()
        ];
    }
}
