<?php

    /**
     * @var \App\Models\Category $category
     * @var \App\Models\Category[]|\Illuminate\Database\Eloquent\Collection $categories
     */

?>@extends('layouts.admin')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">

                <div class="mb-4">

                    <div class="btn-toolbar mb-3">
                        <a href="{{ route('categories.index') }}" class="btn btn-dark">Annulla</a>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">@if($category->exists) Modifica @else Nuova @endif Categoria</div>
                        <form action="{{ route($category->exists ? 'categories.update' : 'categories.store', $category) }}" class="card-body row" method="post">
                            @csrf
                            @if($category->exists) @method('PUT') @endif

                            <div class="form-group mb-4 col-12 col-sm-8 col-lg-6">
                                <label for="name">Nome:</label>
                                <input type="text" name="name" id="name" class="form-control @if($errors->has('name')) is-invalid @endif" value="{{ old('name', $category->name) }}">
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

                    @if($category->exists)

                    <div class="card text-white bg-danger bg-opacity-50">
                        <div class="card-header bg-danger">
                            Elimina Categoria
                        </div>
                        <form class="card-body" method="post" action="{{ route('categories.destroy', $category) }}">
                            @csrf
                            @method('DELETE')


                            <p>Desideri eliminare la categoria <strong>{{ $category->name }}</strong>? L'operazione non può essere annullata!</p>

                            <button class="btn btn-danger"><i class="fa fa-trash"></i> Conferma Eliminazione</button>

                        </form>
                    </div>


                    @endif
                </div>

            </div>
        </div>
    </div>

@endsection
