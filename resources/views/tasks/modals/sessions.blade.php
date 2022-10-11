<table class="table table-sm table-bordered table-striped align-middle">
    <thead>
    <tr>
        <th>Inizio</th>
        <th>Fine</th>
        <th>Operatore</th>
        <th class="text-end">Durata</th>
    </tr>
    </thead>
    <tbody>
    @foreach($task->sessions as $taskSession)
    <tr>
        <td>{{ $taskSession->started_at->format('d/m/Y H:i:s') }}</td>
        <td>{{ optional($taskSession->stopped_at)->format('d/m/Y H:i:s') ?? '- in corso -' }}</td>
        <td>{{ $taskSession->user->name }}</td>
        <td class="text-end">{{ $taskSession->elapsed_time_formatted }}</td>
    </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <td colspan="3" class="text-end">Tempo Trascorso:</td>
        <td class="text-end bold">{{ gmdate('H:i:s', $task->sessions->sum('elapsed_time')) }}</td>
    </tr>
    </tfoot>
</table>


