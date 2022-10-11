<?php

    /** @var \Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|\App\Models\Company[] $companies */

?>@extends('layouts.admin')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">

                <div class="mb-4">

                    <div class="btn-toolbar mb-3">
                        <a href="{{ route('companies.create') }}" class="btn btn-dark">Nuova Azienda</a>
                    </div>

                    <div class="card mb-2">
                        <div class="card-header">Aziende ({{ $companies->total() }})</div>
                        <table class="table table-hover table-striped table-bordered mb-0 table-sm align-middle">
                            <thead class="table-light">
                            <tr>
                                <th>Nome</th>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($companies as $company)
                            <tr>
                                <td>{{ $company->name }}</td>
                                <td>{{ $company->customers_count }} clienti</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('companies.edit', $company) }}" class="btn btn-sm me-1 btn-dark"><i class="fa fa-pencil"></i> Modifica</a>
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
