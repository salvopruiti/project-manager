<div class="row">
    <div class="col-12">
        <h5><strong>[#{{ $task->code }}]</strong> - {{ $task->title }}</h5>

        <p>{{ $task->description }}</p>


        <ul class="m-0 list-unstyled border border-bottom-0">
            <li class="p-1 border-bottom"><strong>Operatore:</strong> {{ $task->user->name ?? '-' }}</li>
            <li class="p-1 border-bottom"><strong>Tempo Impiegato:</strong> {{ $task->started_at ? gmdate('H:i:s', $task->sessions_time) : '-' }}</li>


        </ul>


    </div>

    <div class="col-12 mt-4">
        @include('tasks.modals.sessions')
    </div>
</div>
