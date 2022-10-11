<div class="mt-4">
    @foreach($data as $user => $days)
        @php($user = $days->first()->first()->user)
        @foreach($days as $sessions)
        <div class="card mb-4">
            <div class="card-header fw-bolder p-2"><span class="text-primary">{{$user->name }}</span> <small>{{ $sessions->first()->started_at->format('d/m/Y') }}</small></div>
            <table class="table table-sm table table-striped mb-0">
                <thead>
                <tr>
                    <th class="col-4 ">Task</th>
                    <th class="col-1"></th>
                    <th class="col-1"></th>
                    <th class="col-1 text-end">T.Impiegato</th>
                </tr>
                </thead>
                <tbody>
                @foreach($sessions->groupBy('task_id') as $sessionsByTask)
                <tr>
                    <td><strong>{{ ($task = $sessionsByTask->first()->task)->code }} - </strong>{{ $task->title}} @if($task->ticket) (<a href="{{ route('tickets.edit', $task->ticket) }}" title="{{ $task->ticket->title }}">#{{ $task->ticket->code }}</a>) @endif</td>
                    <td></td>
                    <td></td>
                    <td class="text-end">{{ gmdate('H:i:s', $sessionsByTask->sum('elapsed_time')) }}</td>
                </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-end">{{ gmdate('H:i:s', $sessions->sum('elapsed_time')) }}</td>
                </tr>
                </tfoot>

            </table>

        </div>
        @endforeach
    @endforeach
</div>
