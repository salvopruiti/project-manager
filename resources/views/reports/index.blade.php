@extends('layouts.admin')

@section('content')

    <div class="container-fluid">

        <div class="row justify-content-center">

            <div class="card col-md-8">
                <form action="{{ route('reports.index') }}" method="post" class="card-body row align-items-end">
                    @csrf
                    <div class="col-12 col-lg-3 form-group mb-4 @if($errors->has('period')) is-invalid @endif">
                        <label for="period">Periodo:</label>
                        <input type="month" name="period" id="period" class="form-control @if($errors->has('period')) is-invalid @endif" value="{{ old('period', $period) }}">
                    </div>

                    <div class="col-12 col-lg-5 form-group mb-4 @if($errors->has('report_type')) is-invalid @endif">
                        <label for="report_type">Tipo Rapporto:</label>
                        <select name="report_type" id="report_type" class="form-control normal @if($errors->has('report_type')) is-invalid @endif">
                            <option value="" @if(old('report_type') == '') selected @endif>-</option>
                            <option value="tickets" @if(old('report_type') == 'tickets') selected @endif>Rapporto mensile tickets lavorati</option>
                            <option value="task_users" @if(old('report_type') == 'task_users') selected @endif>Rapporto attività eseguite per operatore</option>
                            <option value="daily_tasks" @if(old('report_type') == 'daily_tasks') selected @endif>Rapporto attività giornaliere per operatore</option>
                        </select>

                    </div>

                    <div class="col-12 col-lg-2 form-group mb-4">
                        <label for="hourly_costs">Costo (h):</label>
                        <input type="number" step="any" min="0" name="hourly_costs" id="hourly_costs" class="form-control @if($errors->has('hourly_costs')) is-invalid @endif" value="{{ old('hourly_costs', $hourly_costs ?? 0) }}">
                    </div>

                    <div class="col-12 col-lg-2 form-group mb-4">
                        <button class="btn btn-dark">Genera</button>
                    </div>
                </form>

            </div>

            <div class="col-md-10">
                @includeWhen(isset($view) && isset($data), $view ?? null)
            </div>
        </div>

    </div>

@endsection
