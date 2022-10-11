<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Http\Requests\TaskRequest;
use App\Models\Category;
use App\Models\Company;
use App\Models\Tag;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class TaskController extends Controller
{
    public function index()
    {
        $defaults['status'] = [];

        $data['tasks'] = Task::query()
            ->with(['activeSession'])
            ->when(request('tags'), fn($query, $tags) => $query->whereHas('tags', fn($query) => $query->whereIn('tag', $tags), '>=', count($tags)))
            ->when(request('category_id'), function($query, $category_id) { $query->whereCategoryId($category_id);})
            ->when(request('ticket_id'), function($query, $ticket_id) { $query->whereTicketId($ticket_id);})
            ->when(request('user_id'), function($query, $userId) { $query->whereUserId($userId);})
            ->when(request('unassigned'), function($query) { $query->whereNull('user_id');})
            ->when(request('q'), function($query, $q) { $query->where(function($query) use($q) {
                $query->where('title', 'like', "%$q%")->orWhere('description', 'like', "%$q%")->orWhere('id', '=', $q);
            });})
            ->when(request('status', $defaults['status']), fn($query,$status) => $query->whereIn('status', $status))
            ->when(request('priority', -1) != -1, function($query) { $query->wherePriority(request('priority'));})
            ->when(request('company_id'), function($query, $company_id) { $query->whereHas('customer', function($query) use($company_id) { $query->whereCompanyId($company_id); }); })
            ->withSessionsTime()
            ->paginate(
                request('pagesize'),
                ['id','created_at','customer_id', 'title', 'status', 'priority', 'category_id', 'estimated_time', 'user_id', 'started_at', 'closed_at']
            )
            ->withQueryString();

        \Session::flashInput(request()->all() + $defaults);

        return view('tasks.index', $data);
    }

    public function create()
    {
        return $this->edit(new Task(request()->only('ticket_id')));
    }

    public function show(Task $task)
    {
        return view('tasks.modals.show', ['task' => $task->withSessionsTime()->find($task->id)]);
    }

    public function edit(Task $task)
    {
        return view('tasks.modals.form', [
            'task' => $task,
            'tags' => Tag::orderBy('tag')->pluck('tag', 'id'),
            'users' => User::orderBy('name')->get(['id','name'])
        ]);
    }

    protected function parseTags(array &$data) : Collection
    {
        $taskTags = collect($data['tags'] ?? [])->map(fn($tag) => mb_strtoupper($tag));
        $existingTags = Tag::whereIn('tag', $taskTags->toArray())->distinct()->get();
        $tagsToCreate = $taskTags->diff($existingTags->pluck('tag')->map(fn($tag) => mb_strtoupper($tag)));

        if($tagsToCreate->count())
            foreach($tagsToCreate as $tag)
                $existingTags->push(Tag::create(['tag' => $tag]));

        unset($data['tags']);

        Tag::whereNotIn('id', $existingTags->pluck('id')->toArray())->whereDoesntHave('tasks')->delete();

        return $existingTags;
    }

    public function update(TaskRequest $request, Task $task)
    {
        $data = $request->validated();
        $tags = $this->parseTags($data);

        $task->update($data);
        $task->tags()->sync($tags->pluck('id'));

        return [
            'status' => 1,
            'refresh' => true
        ];
    }

    public function store(TaskRequest $request)
    {
        $data = $request->validated();
        $tags = $this->parseTags($data);

        $task = Task::create($data);
        $task->tags()->attach($tags->pluck('id'));

        if($ticket = $task->ticket) {

            return [
                'status' => 1,
                'selector' => '.tasks-container',
                'html' => view('tickets.parts.tasks', ['ticket' => $ticket->load('tasks')])->render()
            ];
        }

        return [
            'status' => 1,
            'refresh' => true
        ];
    }

    public function destroy(Task $task)
    {
        $task->tags()->detach();
        $task->sessions()->delete();
        $task->delete();

        return [
            'status' => 1,
            'refresh' => true
        ];
    }

}
