<form action="{{route('tickets.status.store', $ticket)}}" class="row justify-content-center">

    <div class=" col-10">

        <div class="form-group mb-4">
            <label for="status">Stato Ticket:</label>
            <select name="status" id="status" class="form-control">
                <option value="">-</option>
                @foreach(\App\Enums\Status::all() as $id => $name)
                    <option value="{{ $id }}" @if($id == $ticket->status) selected @endif>{{ $name }}</option>
                @endforeach
            </select>
        </div>

        <input type="hidden" name="update_tasks_status" value="0">

        @if( $ticket->tasks_count > 0)
        <div class="form-group mb-4">
            <label><input type="checkbox" name="update_tasks_status" id="" value="1"> Aggiorna anche lo stato delle attività associate ({{ $ticket->tasks_count }}) </label>
        </div>
        @endif

    </div>

    <div class="col-12 text-end footer">
        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Annulla</button>
        <button class="btn btn-success" data-modal-action="save">Salva</button>
    </div>

</form>

<script>



    activeModal.$modal
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

    activeModal.$modal.find('select').select2( {
        theme: 'bootstrap-5',
        minimumResultsForSearch: Infinity
    });


</script>
