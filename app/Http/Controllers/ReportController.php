<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Models\Task;
use App\Models\TaskSession;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $data['period'] = date('Y-m');

        return view('reports.index', $data);
    }

    public function show(Request $request)
    {
        $data = $request->validate([
            'period' => '',
            'report_type' => 'required',
            'hourly_costs' => ''
        ]);

        if(!isset($data['hourly_costs'])) $data['hourly_costs'] = 0;

        $data+= $this->parseReport($data['report_type'], $data['period']);

        \Session::flashInput($data);

        return view('reports.index', $data);
    }

    protected function parseReport(string $type, string $period)
    {
        $start = Carbon::parse($period)->startOfMonth()->startOfDay();
        $end = Carbon::parse($period)->endOfMonth()->endOfDay();

        switch ($type) {
            case 'tickets':

                $tickets = Ticket::whereStatus(Status::RESOLVED)
                    ->with(['customer.company', 'tasks' => fn($query) => $query->withSessionsTime()])
                    ->whereBetween('created_at', [$start->toDateTimeString(), $end->toDateTimeString()])
                    ->get()
                    ->groupBy('customer.company.name');

                return [
                    'view' => 'reports.reports.tickets',
                    'data' => $tickets
                ];

            case 'task_users':

                $data = Task::whereStatus(Status::CLOSED)
                    ->with('user', 'sessions')
                    ->withSessionsTime()
                    ->whereBetween('closed_at', [$start->toDateTimeString(), $end->toDateTimeString()])
                    ->get()
                    ->groupBy('user.name');

                return [
                    'view' => 'reports.reports.task_users',
                    'data' => $data
                ];

            case 'daily_tasks':

                $data = TaskSession::whereBetween('started_at', [$start->toDateTimeString(), $end->toDateTimeString()])
                    ->with('task:id,title,ticket_id', 'user:id,name', 'task.ticket:id,title')->get()
                    ->groupBy(['user.name', function($taskSession) {
                        return $taskSession->started_at->toDateString();
                    }]);

                return [
                    'view' => 'reports.reports.daily_tasks',
                    'data' => $data
                ];



        }


    }
}
