<?php

    /** @var \Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|\App\Models\Ticket[] $tickets */

?>@extends('layouts.admin')

@section('content')

    <div class="container-fluid">
        <div class="row justify-content-center">

            <div class="col-md-8 mb-4">

                <div class="btn-toolbar mb-3">
                    <a href="{{ route('tickets.create') }}" class="btn btn-dark">Nuovo Ticket</a>
                </div>

                <div class="card">
                    <form action="{{ route('tickets.index') }}" method="get" class="card-body row align-items-start">

                        <div class="col-12 col-lg-8 form-group mb-4">
                            <label for="q">Cerca:</label>
                            <input type="text" name="q" id="q" class="form-control" value="{{ old('q') }}">
                        </div>

                        <div class="col-12 col-lg-4 form-group mb-4">
                            <label for="status">Stato:</label>
                            <select name="status[]" id="status" class="form-control"  multiple>
                                <option value="-1" @if(in_array(-1, old('status', []))) selected @endif>Tutti</option>
                                @foreach(\App\Enums\Status::all() as $id => $name)
                                    <option value="{{ $id }}" @if(in_array($id, old('status',[]))) selected @endif>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 col-lg-5 form-group mb-4 @if($errors->has('report_type')) is-invalid @endif">
                            <label for="company_id">Azienda:</label>
                            <select name="company_id" id="company_id" class="form-control">
                                <option value="">-</option>
                                @foreach(\App\Models\Company::orderBy('name')->get(['id','name']) as $company)
                                    <option value="{{ $company->id }}" @if(old('company_id') == $company->id) selected @endif>{{ $company->name }}</option>
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

                        <div class="col-12 text-end form-group">
                            <button class="btn btn-dark">Filtra</button>
                        </div>
                    </form>

                </div>
            </div>

            <div class="col-md-10">

                <div class="mb-4">

                    <div class="card mb-2">
                        <div class="card-header">Ticket ({{ $tickets->total() }})</div>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-bordered mb-0 table-sm align-middle">
                                <thead class="table-light">
                                <tr>
                                    <th>Titolo</th>
                                    <th>Stato</th>
                                    <th>Priorità</th>
                                    <th>Data</th>
                                    <th>Cliente</th>
                                    <th>Operatore</th>
                                    <th>Tempo Stimato</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($tickets as $ticket)
                                    <tr>
                                        <td>{{ $ticket->title }}</td>
                                        <td>{{ \App\Enums\Status::getName($ticket->status) }}</td>
                                        <td>{{ \App\Enums\Priority::getName($ticket->priority) }}</td>
                                        <td>{{ $ticket->created_at->format('d/m/Y H:i') }}</td>
                                        <td>{{ $ticket->customer->company->name ?? $ticket->customer->full_name }}</td>
                                        <td>{{ $ticket->users->implode('name', ',') }}</td>
                                        <td>{{ $ticket->tasks_sum_estimated_time ?: '-' }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-sm me-1 btn-dark"><i class="fa fa-pencil"></i> <span class="d-none d-lg-inline">Modifica</span></a>
                                                <a href="javascript:;" data-modal-url="{{ route('tickets.status.index', $ticket) }}" data-modal-classes="modal-dialog-scrollable" data-modal-title="Cambia stato Ticket" class="btn btn-sm me-1 btn-dark no-loader"><i class="fa fa-refresh"></i> <span class="d-none d-lg-inline">Stato</span></a>
                                                <a href="javascript:;" data-modal-url="{{ route('tickets.assign-user.index', $ticket) }}" data-modal-classes="modal-dialog-scrollable" data-modal-title="Assegnazione Operatore" class="btn btn-sm me-1 btn-dark no-loader"><i class="fa fa-user-nurse"></i> <span class="d-none d-lg-inline">Operatore</span></a>
                                                <a href="{{ route('tasks.index', ['ticket_id' => $ticket->id]) }}" class="btn btn-sm me-1 btn-dark no-loader"><i class="fa fa-arrow-right"></i> <span class="d-none d-lg-inline">Attività</span></a>

                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center py-4">Nessun ticket trovato!</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>


                    </div>

                    <div>
                        {{ $tickets->render() }}
                    </div>

                </div>

            </div>
        </div>
    </div>

@endsection
