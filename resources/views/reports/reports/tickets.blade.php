<div class="mt-4">
@foreach($data as $company => $tickets)
    @php
        $estimatedTimeForCompany = 0;
        $elapsedTimeForCompany = 0;
        $decimalTimeForCompany = 0;
    @endphp

    <div class="card mb-4">
        <div class="card-header fw-bolder p-2">{{$company}} ({{ $tickets->count() }})</div>
        <table class="table table-sm table table-striped mb-0">
            <thead>
            <tr>
                <th class="col-4 ">Ticket</th>
                <th class="col-2 ">Data</th>
                <th class="col-2">Utente</th>
                <th class="col-1 text-end">T.Stimato</th>
                <th class="col-1 text-end">T.Impiegato</th>
                @if($hourly_costs) <th class="col-1 text-end">Costo</th> @endif
            </tr>
            </thead>
            <tbody>
            @foreach($tickets as $ticket)
                @php

                    $estimatedTimeForCompany += ($estimatedTime = $ticket->tasks->sum('estimated_time'));
                    $elapsedTimeForCompany += ($elapsedTime = $ticket->tasks->sum('sessions_time'));
                    $decimalTimeForCompany += ($decimalTime = ($ticket->tasks->sum('sessions_time') / 60) / 60);


                @endphp
            <tr>
                <td><strong><a class="text-dark text-decoration-none" href="{{ route('tasks.index', ['ticket_id' => $ticket->id]) }}" target="_blank" title="Vedi tutte le attività associate al Ticket">#{{ $ticket->code }}</a> - </strong>{{ $ticket->title }}

                    @if($ticket->tasks->count())

                        (

                        @foreach($ticket->tasks as $task)

                            <a href="#" class="no-loader" data-modal-classes="modal-lg modal-dialog-scrollable" data-modal-url="{{ route('tasks.show', $task) }}" data-modal-title="Anteprima Attività"  title="{{ $task->title }}">#{{ $task->code }}</a>

                            @if(!$loop->last), @endif

                        @endforeach

                        )

                    @endif


                </td>
                <td>{{ $ticket->created_at->format('d/m/Y') }}</td>
                <td>{{ $ticket->customer->full_name }}</td>
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
