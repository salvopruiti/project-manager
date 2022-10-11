<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskStatusController extends Controller
{
    private function setTaskStatus(Task $task, int $status, array $extra = [])
    {
        try {
            \DB::beginTransaction();

            if($task->activeSession)
                $task->activeSession->stop();

            $task->update(['status' => $status] + $extra);

            if($task->ticket) {
                $task->ticket->checkForTaskCompletation();
            }

            \DB::commit();

            return [
                'status' => 1,
                'message' => null,
                'refresh' => true
            ];

        } catch (\Exception $e) {
            \DB::rollBack();

            throw $e;
        }
    }

    public function update(Request $request, Task $task)
    {
        $data = $request->validate(['status' => 'required']);

        return $this->setTaskStatus($task, $data['status']);
    }

    public function complete(Task $task)
    {
        return $this->setTaskStatus($task, Status::CLOSED, ['closed_at' => now()]);
    }

    public function archive(Task $task)
    {
        return $this->setTaskStatus($task, Status::ARCHIVED, ['closed_at' => now()]);
    }

}
