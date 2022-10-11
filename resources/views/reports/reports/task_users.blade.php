<div class="mt-4">
@foreach($data as $user => $tasks)
    @php
        $estimatedTimeForCompany = 0;
        $elapsedTimeForCompany = 0;
        $decimalTimeForCompany = 0;
    @endphp

    <div class="card mb-4">
        <div class="card-header fw-bolder p-2">{{$user}} ({{ $tasks->count() }})</div>
        <table class="table table-sm table table-striped mb-0">
            <thead>
            <tr>
                <th class="col-4 ">Task</th>
                <th class="col-2 ">Data</th>
                <th class="col-1 text-end">T.Stimato</th>
                <th class="col-1 text-end">T.Impiegato</th>
                @if($hourly_costs) <th class="col-1 text-end">Costo</th> @endif
            </tr>
            </thead>
            <tbody>
            @foreach($tasks as $task)
                @php

                    $estimatedTimeForCompany += ($estimatedTime = $task->estimated_time);
                    $elapsedTimeForCompany += ($elapsedTime = $task->sessions_time);
                    $decimalTimeForCompany += ($decimalTime = ($task->sessions_time / 60) / 60);


                @endphp
            <tr>
                <td><strong>#{{ $task->code }} - </strong>{{ $task->title }} @if($task->ticket) (<a href="{{ route('tickets.edit', $task->ticket) }}" title="{{ $task->ticket->title }}">#{{ $task->ticket->code }}</a>) @endif</td>
                <td>{{ $task->created_at->format('d/m/Y') }}</td>
                <td class="text-end">{{ $estimatedTime }}</td>
                <td class="text-end">{{ gmdate('H:i:s', $elapsedTime) }} ({{ round($decimalTime, 2) }})</td>
                @if($hourly_costs)<td class="text-end">{{ number_format($decimalTime * $hourly_costs, 2, ',','.') }} &euro;</td> @endif

            </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td></td>
                <td></td>
                <th class="text-end">{{ $estimatedTimeForCompany }}</th>
                <th class="text-end">{{ gmdate('H:i:s', $elapsedTimeForCompany) }} ({{ round($decimalTimeForCompany, 2) }})</th>
                @if($hourly_costs)<th class="text-end">{{ number_format($decimalTimeForCompany * $hourly_costs, 2, ',','.') }} &euro;</th> @endif
            </tr>
            </tfoot>
        </table>
    </div>



@endforeach
</div>
