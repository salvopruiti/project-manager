<?php

/** @var \Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|\App\Models\Task[] $tasks */

?>@extends('layouts.admin')

@section('content')

    <div class="container-fluid">
        <div class="row justify-content-center">

            <div class="col-md-8 mb-4">

                <div class="btn-toolbar mb-3">
                    <button data-modal-classes="modal-lg" data-modal-title="Nuova Attività" data-modal-url="{{ route('tasks.create', ['ticket_id' => old('ticket_id')]) }}" class="btn btn-dark">Nuova Attività</button>
                </div>


                <div class="card">
                    <form action="{{ route('tasks.index') }}" method="get" class="card-body row align-items-start">

                        @if(old('ticket_id'))

                            @php($ticket = \App\Models\Ticket::findOrFail(old('ticket_id')))

                            <div class="col-12form-group mb-4">
                                <label for="ticket">Attività collegate al ticket:</label>
                                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                                <input type="text" class="form-control" value="[#{{ $ticket->code }}] - {{ $ticket->title }}" readonly>
                                <div class="mt-2">
                                    <a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-dark btn-sm">Vedi ticket</a>
                                    <a href="{{ route('tasks.index') }}" class="btn btn-danger btn-sm">Rimuovi filtro</a>
                                </div>
                            </div>

                        @endif

                        <div class="col-12 col-lg-8 form-group mb-4">
                            <label for="q">Cerca:</label>
                            <input type="text" name="q" id="q" class="form-control" value="{{ old('q') }}">
                        </div>

                        <div class="col-12 col-lg-4 form-group mb-4">
                            <label for="status">Stato:</label>
                            <select name="status[]" id="status" class="form-control"  multiple>
                                @foreach(\App\Enums\Status::all() as $id => $name)
                                    <option value="{{ $id }}" @if(in_array($id, old('status',[]))) selected @endif>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 col-lg-4 form-group mb-4 @if($errors->has('report_type')) is-invalid @endif">
                            <label for="tags">Etichetta:</label>
                            <select name="tags[]" id="tags" class="form-control"  multiple>
                                @foreach(\App\Models\Tag::orderBy('tag')->get(['tag']) as $tag)
                                    <option value="{{ $tag->tag }}" @if(in_array($tag->tag, old('tags',[]))) selected @endif>{{ $tag->tag }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 col-lg-4 form-group mb-4 @if($errors->has('report_type')) is-invalid @endif">
                            <label for="tags">Priorità:</label>
                            <select name="priority" id="priority" class="form-control">
                                <option value="">-</option>
                                @foreach(\App\Enums\Priority::all() as $id => $name)
                                    <option value="{{ $id }}" @if($id == old('priority')) selected @endif>{{ $name}}</option>
                                @endforeach
                            </select>

                        </div>

                            <div class="col-12 col-lg-4 form-group mb-4 @if($errors->has('report_type')) is-invalid @endif">
                            <label for="user_id">Operatore:</label>
                            <select name="user_id" id="user_id" class="form-control">
                                <option value="">Tutti</option>
                                @foreach(\App\Models\User::orderBy('name')->pluck('name','id') as $id => $name)
                                    <option value="{{ $id }}" @if($id == old('user_id')) selected @endif>{{ $name}}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="col-12 text-end form-group">
                            <button class="btn btn-dark">Filtra</button>
                        </div>
                    </form>

                </div>
            </div>


            <div class="col-md-10">

                <div class="mb-4">

                    <div class="card mb-2">
                        <div class="card-header">Attività ({{ $tasks->total() }})</div>
                        <table class="table table-hover table-striped table-bordered mb-0 table-sm align-middle">
                            <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Titolo</th>
                                <th>Stato</th>
                                <th class="d-none d-xl-table-cell">Priorità</th>
                                <th>D.I.</th>
                                <th>D.A.</th>
                                <th>D.C.</th>
                                <th>T.S.</th>
                                <th>T.I.</th>
                                @if(!request('user_id'))<th>Operatore</th> @endif
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($tasks as $task)
                                <tr>
                                    <td><div class="small text-end">{{ $task->code }}</div></td>
                                    <td>{{ $task->title }}

                                        @if($task->ticket)

                                            ( <a href="{{ route('tickets.edit', $task->ticket) }}" target="_blank" title="{{ $task->ticket->title }}">#{{ $task->ticket->code }}</a> )

                                        @endif

                                        <br><small>
                                            @foreach($task->tags->sort() as $tag)
                                                <span class="badge py-1 bg-primary">{{ $tag->tag }}</span>
                                            @endforeach
                                        </small>

                                    </td>
                                    <td>{{ \App\Enums\Status::getName($task->status) }}</td>
                                    <td class="d-none d-xl-table-cell">{{ \App\Enums\Priority::getName($task->priority) }}</td>
                                    <td>{{ $task->created_at->format('d/m/Y') }}</td>
                                    <td>{{ optional($task->started_at)->format('d/m/Y H:i') ?? '-' }}</td>
                                    <td>{{ optional($task->closed_at)->format('d/m/Y H:i') ?? '-' }}</td>
                                    <td>{{ $task->estimated_time }}</td>
                                    <td><span @if($task->activeSession) data-start="{{ $task->sessions_time }}" @endif>{{ $task->started_at ? gmdate('H:i:s', $task->sessions_time) : '-' }}</span></td>
                                    @if(!request('user_id'))<td>{{ $task->user->name ?? '-' }}</td>@endif
                                    <td>
                                        @include('tasks.parts.buttons')
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>


                    </div>

                    <div>
                        {{ $tasks->render() }}
                    </div>

                </div>

            </div>
        </div>
    </div>

@endsection
