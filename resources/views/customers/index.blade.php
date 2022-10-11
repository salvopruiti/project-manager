<?php

    /** @var \Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|\App\Models\Customer[] $customers */

?>@extends('layouts.admin')

@section('content')

    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-10 mb-4">

                <div class="btn-toolbar mb-3">
                    <a href="{{ route('customers.create') }}" class="btn btn-dark">Nuovo Cliente</a>
                </div>

                <div class="card">
                    <form action="{{ route('customers.index') }}" method="get" class="card-body row align-items-start">

                        <div class="col-12 col-lg-8 form-group mb-4">
                            <label for="q">Cerca:</label>
                            <input type="text" name="q" id="q" class="form-control" value="{{ old('q') }}">
                        </div>

                        <div class="col-12 col-lg-5 form-group mb-4">
                            <label for="company_id">Azienda:</label>
                            <select name="company_id" id="company_id" class="form-control" >
                                <option value="">Tutte</option>
                                @foreach(\App\Models\Company::orderBy('name')->get(['id','name']) as $company)
                                    <option value="{{ $company->id }}" @if(old('company_id') == $company->id) selected @endif>{{ $company->name }}</option>
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
                        <div class="card-header">Clienti ({{ $customers->total() }})</div>
                        <table class="table table-hover table-striped table-bordered mb-0 table-sm align-middle">
                            <thead class="table-light">
                            <tr>
                                <th>Nome</th>
                                <th>Cognome</th>
                                <th>Azienda</th>
                                <th>E-Mail</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($customers as $customer)
                            <tr>
                                <td>{{ $customer->first_name }}</td>
                                <td>{{ $customer->last_name }}</td>
                                <td>{{ $customer->company->name ?? '- Nessuna Azienda -' }}</td>
                                <td>{{ $customer->email }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('customers.edit', $customer) }}" class="btn btn-sm me-1 btn-dark"><i class="fa fa-pencil"></i> Modifica</a>
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
