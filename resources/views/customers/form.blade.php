<?php

    /**
     * @var \App\Models\Customer $customer
     * @var \App\Models\Company[]|\Illuminate\Database\Eloquent\Collection $companies
     */

?>@extends('layouts.admin')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">

                <div class="mb-4">

                    <div class="btn-toolbar mb-3">
                        <a href="{{ route('customers.index') }}" class="btn btn-dark">Annulla</a>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">@if($customer->exists) Modifica @else Nuovo @endif Cliente</div>
                        <form action="{{ route($customer->exists ? 'customers.update' : 'customers.store', $customer) }}" class="card-body row" method="post">
                            @csrf
                            @if($customer->exists) @method('PUT') @endif

                            <div class="form-group mb-4 col-12 col-sm-6 col-lg-4">
                                <label for="first_name">Nome:</label>
                                <input type="text" name="first_name" id="first_name" class="form-control @if($errors->has('first_name')) is-invalid @endif" value="{{ old('first_name', $customer->first_name) }}">
                                @if($errors->has('first_name'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('first_name') }}
                                    </div>
                                @endif
                            </div>

                            <div class="form-group mb-4 col-12 col-sm-6 col-lg-4">
                                <label for="last_name">Cognome:</label>
                                <input type="text" name="last_name" id="last_name" class="form-control @if($errors->has('last_name')) is-invalid @endif" value="{{ old('last_name', $customer->last_name) }}">
                                @if($errors->has('last_name'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('last_name') }}
                                    </div>
                                @endif
                            </div>

                            <div class="form-group mb-4 col-12 col-sm-6 col-lg-4">
                                <label for="email">Indirizzo E-Mail:</label>
                                <input type="email" name="email" id="email" class="form-control @if($errors->has('email')) is-invalid @endif" value="{{ old('email', $customer->email) }}">
                                @if($errors->has('email'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('email') }}
                                    </div>
                                @endif
                            </div>

                            <div class="form-group mb-4 col-12 col-sm-8 col-lg-6">
                                <label for="company_id">Azienda:</label>
                                <select name="company_id" id="company_id" class="form-control @if($errors->has('company_id')) is-invalid @endif">
                                    <option value="">- Nessuna Azienda -</option>
                                    @foreach($companies as $company)
                                    <option value="{{ $company->id }}" @if(old('company_id', $customer->company_id) == $company->id) selected @endif>{{ $company->name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('company_id'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('company') }}
                                    </div>
                                @endif
                            </div>


                            <div class="col-12">
                                <button class="btn btn-success">Salva</button>
                            </div>

                        </form>
                    </div>

                    @if($customer->exists)

                    <div class="card text-white bg-danger bg-opacity-50">
                        <div class="card-header bg-danger">
                            Elimina cliente
                        </div>
                        <form class="card-body" method="post" action="{{ route('customers.destroy', $customer) }}">
                            @csrf
                            @method('DELETE')


                            <p>Desideri eliminare il cliente <strong>{{ $customer->full_name }}</strong>? L'operazione non può essere annullata!</p>

                            <button class="btn btn-danger"><i class="fa fa-trash"></i> Conferma Eliminazione</button>

                        </form>
                    </div>


                    @endif
                </div>

            </div>
        </div>
    </div>

@endsection
