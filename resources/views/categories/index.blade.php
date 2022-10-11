<?php

    /** @var \Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|\App\Models\Category[] $categories */

?>@extends('layouts.admin')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">

                <div class="mb-4">

                    <div class="btn-toolbar mb-3">
                        <a href="{{ route('categories.create') }}" class="btn btn-dark">Nuova Categoria</a>
                    </div>

                    <div class="card mb-2">
                        <div class="card-header">Categorie ({{ $categories->total() }})</div>
                        <table class="table table-hover table-striped table-bordered mb-0 table-sm align-middle">
                            <thead class="table-light">
                            <tr>
                                <th>Nome</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $category)
                            <tr>
                                <td>{{ $category->name }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm me-1 btn-dark"><i class="fa fa-pencil"></i> Modifica</a>
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
