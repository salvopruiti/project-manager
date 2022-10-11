<?php

    /** @var \Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users */

?>@extends('layouts.admin')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">

                <div class="mb-4">

                    <div class="btn-toolbar mb-3">
                        <a href="{{ route('users.create') }}" class="btn btn-dark">Nuovo Operatore</a>
                    </div>

                    <div class="card mb-2">
                        <div class="card-header">Operatori ({{ $users->total() }})</div>
                        <table class="table table-hover table-striped table-bordered mb-0 table-sm align-middle">
                            <thead class="table-light">
                            <tr>
                                <th>Nome</th>
                                <th>E-Mail</th>
                                <th>Ticket</th>
                                <th>Attività</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->tickets_count }}</td>
                                <td>{{ $user->tasks_count }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('users.edit', $user) }}" class="btn btn-sm me-1 btn-dark"><i class="fa fa-pencil"></i> Modifica</a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>


                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
