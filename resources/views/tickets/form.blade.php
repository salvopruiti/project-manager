<?php

    /**
     * @var \App\Models\Ticket $ticket
     * @var \App\Models\Customer[]|\Illuminate\Database\Eloquent\Collection $customers
     * @var \App\Models\Customer[]|\Illuminate\Database\Eloquent\Collection $companyCustomers
     */

?>@extends('layouts.admin')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">

                <div class="mb-4">

                    <div class="btn-toolbar mb-3">
                        <a href="{{ route('tickets.index') }}" class="btn btn-dark">Annulla</a>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">@if($ticket->exists) Modifica @else Nuovo @endif Ticket</div>
                        <form action="{{ route($ticket->exists ? 'tickets.update' : 'tickets.store', $ticket) }}" class="card-body row" method="post">
                            @csrf
                            @if($ticket->exists) @method('PUT') @endif


                            <div class="form-group mb-4 col-12 col-sm-8">
                                <label for="customer_id">Autore del Ticket:</label>
                                <select name="customer_id" id="customer_id" class="form-control @if($errors->has('customer_id')) is-invalid @endif">
                                    <option value="">-</option>
                                    @foreach($customers->sortBy(['company.name', 'first_name', 'last_name'])->groupBy('company_id') as $company => $companyCustomers)
                                        <optgroup label="{{ $companyCustomers[0]->company->name ?? '- Nessuna Azienda -' }}">
                                            @foreach($companyCustomers as $companyCustomer)
                                                <option value="{{ $companyCustomer->id }}" @if(old('customer_id', $ticket->customer_id) == $companyCustomer->id) selected @endif>{{ $companyCustomer->first_name }} {{ $companyCustomer->last_name }}</option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                                @if($errors->has('customer_id'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('customer_id') }}
                                    </div>
                                @endif
                            </div>

                            <div class="form-group mb-4 col-12 col-sm-4">
                                <label for="status">Stato:</label>
                                <select name="status" id="status" class="form-control @if($errors->has('status')) is-invalid @endif">
                                    <option value="">-</option>
                                    @foreach(\App\Enums\Status::all() as $source_id => $source_name)
                                        <option value="{{ $source_id }}" @if($source_id == old('status', $ticket->status)) selected @endif>{{ $source_name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('status'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('status') }}
                                    </div>
                                @endif
                            </div>

                            <div class="form-group mb-4 col-12 col-sm-6">
                                <label for="category_id">Categoria:</label>
                                <select name="category_id" id="category_id" class="form-control @if($errors->has('category_id')) is-invalid @endif">
                                    <option value="">-</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @if(old('category_id', $ticket->category_id) == $category->id) selected @endif>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('category_id'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('category_id') }}
                                    </div>
                                @endif
                            </div>



                            <div class="form-group mb-4 col-12 col-sm-3">
                                <label for="source">Origine del Ticket:</label>
                                <select name="source" id="source" class="form-control @if($errors->has('source')) is-invalid @endif">
                                    <option value="">-</option>
                                    @foreach(\App\Enums\Source::all() as $source_id => $source_name)
                                        <option value="{{ $source_id }}" @if($source_id == old('source', $ticket->source)) selected @endif>{{ $source_name }}</option>
                                  @endforeach
                                </select>
                                @if($errors->has('source'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('source') }}
                                    </div>
                                @endif
                            </div>

                            <div class="form-group mb-4 col-12 col-sm-3">
                                <label for="priority">Priorità:</label>
                                <select name="priority" id="priority" class="form-control @if($errors->has('priority')) is-invalid @endif">
                                    <option value="">-</option>
                                    @foreach(\App\Enums\Priority::all() as $source_id => $source_name)
                                        <option value="{{ $source_id }}" @if($source_id == old('priority', $ticket->priority)) selected @endif>{{ $source_name }}</option>
                                  @endforeach
                                </select>
                                @if($errors->has('priority'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('priority') }}
                                    </div>
                                @endif
                            </div>

                            <div class="form-group mb-4 col-12">
                                <label for="title">Titolo:</label>
                                <input type="text" name="title" id="title" class="form-control @if($errors->has('title')) is-invalid @endif" value="{{ old('title', $ticket->title) }}">
                                @if($errors->has('title'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('title') }}
                                    </div>
                                @endif
                            </div>

                            <input type="hidden" name="create_tasks" value="0">

                            @if(!$ticket->exists)
                            <div class="form-group mb-4 col-12">
                                <label for="body" class="has-validation">Contenuto:</label>
                                <textarea name="body" id="body" cols="30" rows="10" class="form-control visual-editor @if($errors->has('body')) is-invalid @endif">{{ old('body', $ticket->body) }}</textarea>
                                @if($errors->has('body'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('body') }}
                                    </div>
                                @endif
                            </div>

                            <div class="form-group mb-4 col-12">
                                <label><input type="checkbox" name="create_task" id=""> Crea attività automaticamente</label>
                            </div>
                            @endif

                            <div class="col-12">
                                <button class="btn btn-success">Salva</button>
                            </div>

                        </form>
                    </div>

                </div>

            @if($ticket->exists)

                <div class="tasks-container">
                    @include('tickets.parts.tasks')
                </div>


                <div class="notes-container">
                    @include('tickets.parts.notes')
                </div>

            @endif

            </div>
        </div>
    </div>
@endsection

@push('after_scripts')




@endpush
