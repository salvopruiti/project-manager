<div class="btn-toolbar task-{{ $task->id }}-btns">

    <div class="btn-group ms-lg-2 mt-lg-0 mt-2 me-2 me-lg-0">
        <button class="btn btn-sm btn-outline-dark" data-modal-title="Modifica Attività" data-modal-classes=" modal-lg" data-modal-url="{{ route('tasks.edit', $task) }}"><i class="fa fa-fw fa-pencil"></i></button>
    </div>

    @if($task->is_active)
    <div class="btn-group ms-lg-2 mt-lg-0 mt-2 me-2 me-lg-0">

        @if(!$task->activeSession)
        <button class="btn btn-sm no-loader btn-outline-dark" @if(!$task->user_id || !$task->is_active) disabled @endif data-action="{{route('tasks.sessions.start', $task)}}"><i class="fa-fw fa fa-play"></i> <span class="d-none d-xl-inline"></span></button>
        @else
        <button class="btn btn-sm no-loader btn-outline-dark" @if($task->activeSession->user_id != auth()->id()) disabled @endif data-action="{{route('tasks.sessions.stop', [$task, $task->activeSession])}}"><i class="fa-fw fa fa-stop"></i> <span class="d-none d-xl-inline"></span></button>
        @endif
        <button class="btn btn-sm no-loader btn-outline-dark" @if(!$task->user_id) disabled @endif data-modal-title="Storico Sessioni" data-modal-classes="modal-dialog-scrollable modal-lg" data-modal-url="{{route('tasks.sessions.index', $task)}}"><i class="fa fa-history fa-fw"></i> <span class="d-none d-xl-inline"></span></button>
    </div>

    <div class="btn-group ms-lg-2 mt-lg-0 mt-2 me-2 me-lg-0">
        <button class="btn btn-sm btn-outline-success no-loader " data-action="{{route('tasks.status.complete', $task)}}"><i class="fa fa-fw fa-check"></i> <span class="d-none d-xl-inline"></span></button>
        <button class="btn btn-sm btn-outline-warning no-loader " data-action="{{route('tasks.status.archive', $task)}}"><i class="fa fa-fw fa-archive"></i> <span class="d-none d-xl-inline"></span></button>
    </div>

    @else

    <div class="btn-group ms-lg-2 mt-lg-0 mt-2 me-2 me-lg-0">
        <button class="btn btn-sm btn-outline-success no-loader " data-post-data="{{ json_encode(['status' => \App\Enums\Status::OPENED]) }}" data-action="{{route('tasks.status.set', $task)}}"><i class="fa fa-fw fa-refresh"></i> <span class="d-none d-xl-inline"></span></button>
    </div>

    @endif

    @can('delete', $task)
    <div class="btn-group ms-lg-2 mt-lg-0 mt-2">
        <button class="btn btn-sm btn-outline-danger no-loader" data-action="{{route('tasks.destroy', $task)}}" data-post-data="{{  json_encode(['_method' => 'DELETE'])  }}"><i class="fa fa-fw fa-trash-can"></i></button>
    </div>
    @endcan
</div>
