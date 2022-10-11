<?php

    /**
     * @var \App\Models\User $user
     */

?>@extends('layouts.admin')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">

                <div class="mb-4">

                    <div class="btn-toolbar mb-3">
                        <a href="{{ route('users.index') }}" class="btn btn-dark">Annulla</a>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">@if($user->exists) Modifica @else Nuovo @endif Operatore</div>
                        <form action="{{ route($user->exists ? 'users.update' : 'users.store', $user) }}" class="card-body row" method="post">
                            @csrf
                            @if($user->exists) @method('PUT') @endif

                            <div class="form-group mb-4 col-12 col-sm-6">
                                <label for="name">Nome:</label>
                                <input type="text" name="name" id="name" class="form-control @if($errors->has('name')) is-invalid @endif" value="{{ old('name', $user->name) }}">
                                @if($errors->has('name'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('name') }}
                                    </div>
                                @endif
                            </div>

                            <div class="form-group mb-4 col-12 col-sm-6">
                                <label for="email">Indirizzo E-Mail:</label>
                                <input type="email" name="email" id="email" class="form-control @if($errors->has('email')) is-invalid @endif" value="{{ old('email', $user->email) }}">
                                @if($errors->has('email'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('email') }}
                                    </div>
                                @endif
                            </div>

                            @if($user->id)

                            <div class="w-100 mb-3"><strong>Cambia Password</strong> (lascia vuoto per non modificare)</div>

                            @endif

                            <div class="form-group mb-4 col-12 col-sm-6">
                                <label for="password">Password:</label>
                                <input type="password" name="password" id="password" class="form-control @if($errors->has('password')) is-invalid @endif">
                                @if($errors->has('password'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('password') }}
                                    </div>
                                @endif
                            </div>

                            <div class="form-group mb-4 col-12 col-sm-6">
                                <label for="password_confirmation">Conferma Password:</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control @if($errors->has('password')) is-invalid @endif">
                                @if($errors->has('password_confirmation'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('password_confirmation') }}
                                    </div>
                                @endif
                            </div>

                            <div class="col-12">
                                <button class="btn btn-success">Salva</button>
                            </div>

                        </form>
                    </div>

                    @if($user->exists && $user->isNot(auth()->user()))

                    <div class="card text-white bg-danger bg-opacity-50">
                        <div class="card-header bg-danger">
                            Elimina Operatore
                        </div>
                        <form class="card-body" method="post" action="{{ route('users.destroy', $user) }}">
                            @csrf
                            @method('DELETE')


                            <p>Desideri eliminare l'operatore <strong>{{ $user->name }}</strong>? L'operazione non può essere annullata!</p>

                            <button class="btn btn-danger"><i class="fa fa-trash"></i> Conferma Eliminazione</button>

                        </form>
                    </div>


                    @endif
                </div>

            </div>
        </div>
    </div>
@endsection

@push('after_scripts')




@endpush
