<form action="{{ route($task->exists ? 'tasks.update' : 'tasks.store', $task->id) }}" method="POST" class="row justify-content-center">
    @if($task->exists)
        @method('PUT')

    @else

        <input type="hidden" name="status" value="{{ \App\Enums\Status::OPENED }}">
        <input type="hidden" name="ticket_id" value="{{ $task->ticket_id }}">

    @endif

        <div class="col-11">

            @if($task->ticket)

                <div class="form-group mb-4">
                    <label for="title">Ticket Associato:</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ $task->ticket->code . ' - ' . $task->ticket->title }}" readonly>
                </div>

            @endif


            <div class="form-group mb-4">
                <label for="title">Titolo:</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ $task->title }}">
            </div>

            <div class="form-group mb-4">
                <label for="tags">Etichette:</label>
                <select name="tags[]" id="tags" class="form-control" multiple>
                    @foreach($tags as $tag)
                    <option value="{{ $tag }}" @if($task->tags->pluck('tag')->search($tag) !== false) selected @endif>{{ $tag }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-4">
                <label for="description">Descrizione:</label>
                <textarea class="form-control" name="description" id="description" cols="30" rows="4">{{ $task->description }}</textarea>
            </div>

            <div class="row">
                <div class="form-group mb-4 col-3">
                    <label for="estimated_time">Tempo Stimato:</label>
                    <input type="number" name="estimated_time" id="estimated_time" step="0.50" class="form-control" value="{{ $task->estimated_time }}">
                </div>

                <div class="form-group mb-4 col-4">
                    <label for="priority">Priorità:</label>
                    <select name="priority" id="priority" class="form-control">
                        <option value="">-</option>
                        @foreach(\App\Enums\Priority::all() as $source_id => $source_name)
                            <option value="{{ $source_id }}" @if($source_id == $task->priority) selected @endif>{{ $source_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-4 col-5">
                    <label for="user_id">Operatore:</label>
                    <select name="user_id" id="user_id" class="form-control">
                        <option value="">-</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" @if($user->id == $task->user_id) selected @endif>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

            </div>

        </div>
        <div class="col-12 text-end footer">
            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Annulla</button>
            <button class="btn btn-success" data-modal-action="save">Salva</button>
        </div>
</form>


<script>



    activeModal.$modal
        .one('hide.bs.modal', e => {

            // tinymce.remove('form .form-group textarea#description');

        })
        .on('submit', '.modal-body form', (e) => {

            e.preventDefault();

            let form = e.currentTarget;

            axios.post(form.action, new FormData(form))
                .then(response => {
                    activeModal.defaultResponse(response)

                    activeModal.$modal.find('.modal-footer').show();
                })
                .catch(error => activeModal.manageErrors(error));

        })
        .find('.modal-footer')
        .hide(null)


    new TomSelect(activeModal.$modal.find('select#tags')[0], {
        plugins: ['remove_button'],
        closeAfterSelect: true,
        selectOnTab: true,
        allowEmptyOption: true,
        create: true,
        render:{
            option_create: function( data, escape ){
                return `<div class="create">Aggiungi <strong>${escape(data.input)}</strong>&hellip;</div>`;
            },
            no_results: function( data, escape ){
                return `<div class="no-results">Nessun risultato per <strong>${escape(data.input)}</strong></div>`;
            },
        }
    });

    activeModal.$modal[0].querySelectorAll('select:not(#tags)').forEach(element => {

        new TomSelect(element, {
            render:{
                option_create: function( data, escape ){
                    return `<div class="create">Aggiungi <strong>${escape(data.input)}</strong>&hellip;</div>`;
                },
                no_results: function( data, escape ){
                    return `<div class="no-results">Nessun risultato per <strong>${escape(data.input)}</strong></div>`;
                },
            },
            hidePlaceholder: true,
            maxItems: 1,
            selectOnTab: true,
            closeAfterSelect: true,
            allowEmptyOption: true,
        })
    })

    // activeModal.$modal.find('select#tags').select2( {
    //     theme: 'bootstrap-5',
    //     tags: true,
    //     tokenSeparators: [',', ' '],
    //     minimumResultsForSearch: Infinity
    // });

    // initEditor('form .form-group textarea#description')


</script>
