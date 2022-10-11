    <div class="card mb-4">
        <div class="card-header">Attività associate al Ticket</div>
        @if(!$ticket->tasks->count())
            <div class="card-body text-center">
                <p>Nessuna attività associata a questo Ticket.</p>

                <button
                    data-modal-url="{{ route('tickets.tasks.index', $ticket) }}"
                    data-modal-title="Aggiungi Attività"
                    data-modal-classes="modal-lg"
                    class="btn btn-dark btn-sm"
                >
                    Nuova Attività
                </button>
            </div>
        @else
            <table class="table table-sm table-bordered table-striped align-middle mb-0">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Titolo</th>
                    <th>Stato</th>
                    <th>Tempo</th>
                    <th>Priorità</th>
                </tr>
                </thead>
                <tbody>
                @foreach($ticket->tasks as $task)
                    <tr>
                        <td><div class="text-end small">{{ $task->code }}</div></td>
                        <td>{{ $task->title }}</td>
                        <td>{{ \App\Enums\Status::getName($task->status) }}</td>
                        <td>{{ $task->estimated_time }}</td>
                        <td>{{ \App\Enums\Priority::getName($task->priority) }}</td>
                        <td>@include('tasks.parts.buttons')</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

       @endif
        <div class="card-footer">
            <button
                data-modal-url="{{ route('tickets.tasks.index', $ticket) }}"
                data-modal-title="Aggiungi Attività"
                data-modal-classes="modal-lg"
                class="btn btn-dark btn-sm"
            >
                Nuova Attività
            </button>
        </div>
    </div>
