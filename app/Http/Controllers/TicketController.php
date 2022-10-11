<?php

namespace App\Http\Controllers;

use App\Enums\Priority;
use App\Enums\Status;
use App\Http\Requests\TicketRequest;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {

        $defaults['status'] = [Status::OPENED, Status::IN_PROGRESS];
        $status = request('status', []);
        if(!$status)
            $status = $defaults['status'];
        elseif(in_array(-1, $status))
            $status = [];

        $data['tickets'] = Ticket::with('customer:id,company_id,first_name,last_name', 'customer.company:id,name', 'category:id,name')
            ->withSum('tasks', 'estimated_time')
            ->when(request('category_id'), function($query, $category_id) { $query->whereCategoryId($category_id);})
            ->when(request('q'), function($query, $q) { $query->where(function($query) use($q) {
                $query->where('title', 'like', "%$q%")->orWhere('body', 'like', "%$q%");
            });})
            ->when($status, fn($query, $status) => $query->whereIn('status', $status))
            ->when(request('priority', -1) != -1, function($query) { $query->wherePriority(request('priority'));})
            ->when(request('company_id'), function($query, $company_id) { $query->whereHas('customer', function($query) use($company_id) { $query->whereCompanyId($company_id); }); })
            ->paginate(request('pagesize'), ['id','created_at','customer_id', 'title', 'status', 'priority', 'category_id'])
            ->withQueryString();

        \Session::flashInput(request()->all() + $defaults);

        return view('tickets.index', $data);
    }

    public function create()
    {
        return $this->edit(new Ticket(request()->only('customer_id') + ['priority' => Priority::NORMAL]));
    }

    public function edit(Ticket $ticket)
    {
        $data = [
            'ticket' => $ticket->load('notes.user:id,name'),
            'categories' => Category::orderBy('name')->get(['id','name']),
            'customers' => Customer::with('company:id,name')->get(['id','company_id','first_name','last_name']),
        ];

        return view('tickets.form', $data);
    }

    public function store(TicketRequest $request)
    {
        $data = $request->validated();

        $createTask = $data['create_task'];
        unset($data['create_task']);

        /** @var Ticket $ticket */
        $ticket = Ticket::create($data);

        if($createTask) {
            $ticket->tasks()->create(['title' => $ticket->title, 'priority' => $ticket->priority, 'estimated_time' => 1, 'status' => Status::OPENED]);
        }

        return redirect()->route('tickets.edit', $ticket);
    }

    public function update(TicketRequest $request, Ticket $ticket)
    {
        $ticket->update($request->validated());
        return redirect()->route('tickets.index');
    }
}
