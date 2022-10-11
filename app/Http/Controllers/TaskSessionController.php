<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskSession;

class TaskSessionController extends Controller
{
    public function index(Task $task)
    {
        return view('tasks.modals.sessions', ['task' => $task->load('sessions', 'activeSession')]);
    }

    public function start(Task $task)
    {
        throw_if($task->activeSession, "Sessione già attiva");

        $taskSession = TaskSession::start($task);

        return [
            'status' => 1,
            'refresh' => true
        ];
    }

    public function stop(Task $task, TaskSession $taskSession)
    {

        $taskSession->stop();

        return [
            'status' => 1,
            'refresh' => true
        ];
    }

}
