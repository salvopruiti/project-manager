<?php

    /** @var \App\Models\Ticket $ticket */

?><form action="{{route('tickets.assign-user.store', $ticket)}}" class="row justify-content-center">

    <div class=" col-10">

        <div class="form-group mb-4">
            <label for="user">Operatore:</label>
            <select name="user" id="user" class="form-control">
                <option value="">-</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" @if($ticket->users->pluck('id')->search($user->id) !== false) selected @endif>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
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
