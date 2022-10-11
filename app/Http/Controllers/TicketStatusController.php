<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketStatusController extends Controller
{
    public function index(Ticket $ticket)
    {
        $ticket->loadCount('tasks');
        return view('tickets.modals.status', ['ticket' => $ticket]);
    }

    public function store(Request $request, Ticket $ticket)
    {
        $data = $request->validate([
            'status' => 'required',
            'update_tasks_status' => ''
        ]);

        try {

            \DB::beginTransaction();

            $updateTasksStatus = $data['update_tasks_status'];
            unset($data['update_tasks_status']);

            $ticket->update($data);

            if($updateTasksStatus)
                $ticket->tasks()->update($data);

            \DB::commit();

            return [
                'status' => 1,
                'message' => 'Ticket Aggiornato!',
                'refresh' => true,
                'timeout' => 1000
            ];

        } catch (\Exception $e) {

            \DB::rollBack();

            throw $e;
        }
    }
}
