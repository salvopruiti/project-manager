@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            @if($tasks->count())
                <ul class="list-unstyled mb-0 p-4">
                    @foreach($tasks as $task)
                        <li class="card @if(!$loop->last) mb-4 @endif">
                            <div>
                                <div class="p-2">
                                    <h5 class="mb-0 fw-bolder">[<span class="text-info">#{{$task->code}}</span>] - {{ $task->title }} <small class="text-primary fw-normal">({{ \App\Enums\Priority::getName($task->priority) }})</small></h5>
                                    <p class="mb-0">{{ $task->description }}</p>
                                </div>

                                <div class="border-top p-2 bg-light">
                                    @if($task->ticket)
                                        <small><strong>Ticket:</strong> <a href="{{ route('tickets.edit', $task->ticket) }}">[#{{ $task->ticket->code }}] - {{ $task->ticket->title }}</a>
                                            (<a href="{{ route('tasks.index', ['ticket_id' => $task->ticket_id]) }}">Vedi tutte le attività</a>)
                                        </small><br>
                                    @endif
                                    <small><strong>Stato:</strong> {{ \App\Enums\Status::getName($task->status) }}</small><br>
                                    @if($task->customer)
                                    <small><strong>Cliente:</strong> {{ $task->customer->company->name ?? $task->customer->full_name }}</small><br>
                                    @endif
                                    <small><strong>Tempo Stimato:</strong> {{ $task->estimated_time }}</small><br>
                                    <small><strong>Tempo Trascorso:</strong> <span @if($task->activeSession) data-start="{{ $task->sessions_time }}" @endif>{{ $task->started_at ? gmdate('H:i:s', $task->sessions_time) : '-' }}</span></small>
                                </div>
                            </div>

                            <div class="border border-start-0 border-end-0 p-2">
                                @include('tasks.parts.buttons')
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else

            <div class="card mb-2">
                <div class="card-header">Attività ({{ $tasks->count() }})</div>
                    <div class="card-body text-center">
                        Nessuna attività
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection
