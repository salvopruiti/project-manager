<?php

    /**
     * @var \App\Models\Company $company
     * @var \App\Models\Company[]|\Illuminate\Database\Eloquent\Collection $companies
     */

?>@extends('layouts.admin')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">

                <div class="mb-4">

                    <div class="btn-toolbar mb-3">
                        <a href="{{ route('companies.index') }}" class="btn btn-dark">Annulla</a>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">@if($company->exists) Modifica @else Nuova @endif Azienda</div>
                        <form action="{{ route($company->exists ? 'companies.update' : 'companies.store', $company) }}" class="card-body row" method="post">
                            @csrf
                            @if($company->exists) @method('PUT') @endif

                            <div class="form-group mb-4 col-12 col-sm-8 col-lg-6">
                                <label for="name">Nome:</label>
                                <input type="text" name="name" id="name" class="form-control @if($errors->has('name')) is-invalid @endif" value="{{ old('name', $company->name) }}">
                                @if($errors->has('name'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('name') }}
                                    </div>
                                @endif
                            </div>

                            <div class="col-12">
                                <button class="btn btn-success">Salva</button>
                            </div>

                        </form>
                    </div>

                    @if($company->exists)

                    <div class="card text-white bg-danger bg-opacity-50">
                        <div class="card-header bg-danger">
                            Elimina Azienda
                        </div>
                        <form class="card-body" method="post" action="{{ route('companies.destroy', $company) }}">
                            @csrf
                            @method('DELETE')


                            <p>Desideri eliminare l'azienda <strong>{{ $company->name }}</strong>? L'operazione non può essere annullata!</p>

                            <button class="btn btn-danger"><i class="fa fa-trash"></i> Conferma Eliminazione</button>

                        </form>
                    </div>


                    @endif
                </div>

            </div>
        </div>
    </div>

@endsection
