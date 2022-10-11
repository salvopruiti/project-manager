    <style>
        .timeline {
            border-left: 1px solid hsl(0, 0%, 90%);
            position: relative;
            list-style: none;
            margin-bottom: 0;
        }

        .timeline .timeline-item {
            position: relative;
        }

        .timeline .timeline-item:after {
            position: absolute;
            display: block;
            top: 0;
        }

        .timeline .timeline-item:after {
            background-color: hsl(0, 0%, 90%);
            left: -38px;
            border-radius: 50%;
            height: 11px;
            width: 11px;
            content: "";
        }
    </style>

    <ul class="timeline">

        <li class="timeline-item mb-5">
            <h5 class="fw-bold">{{ $ticket->title }}</h5>
            <p class="text-muted mb-2 fw-bold">{{ $ticket->customer->full_name }} <span class="badge bg-success">Cliente</span> - {{ $ticket->created_at->format('d/m/Y H:i') }}</p>
            <div class="card">
                <div class="card-body p-2">
                    <p class="text-muted">{!! $ticket->body !!}</p>
                </div>
            </div>

        </li>


    @foreach($ticket->notes as $note)

            <li class="timeline-item mb-5">
                <h5 class="fw-bold">Nota Interna</h5>
                <p class="text-muted mb-2 fw-bold">{{ $note->user->name }} <span class="badge bg-danger">Operatore</span> - {{ $note->created_at->format('d/m/Y H:i') }}</p>
                <div class="card">
                    <div class="card-body p-2">
                        <p class="text-muted">{!! $note->note !!}</p>

                        <div class="mt-3 text-end border-top pt-2">
                            <button class="btn btn-sm btn-danger" data-post-data="{{ json_encode(['_method' => 'DELETE']) }}" data-action="{{route('tickets.notes.destroy', [$ticket, $note])}}"><i class="fa fa-trash"></i> Elimina</button>
                        </div>
                    </div>
                </div>

            </li>

        @endforeach
    </ul>

    <div>
        <button data-modal-url="{{ route('tickets.notes.index', $ticket) }}" data-modal-classes="modal-lg" data-modal-title="Aggiungi Nota Interna" class="btn btn-dark">Aggiungi Nota Interna</button>
    </div>
