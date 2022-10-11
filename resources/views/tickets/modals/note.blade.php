<form action="{{route('tickets.notes.store', $ticket)}}" class="row justify-content-center">

    <div class="col-12">

        <div class="form-group mb-4">
            <textarea name="note" id="note" cols="30" rows="10" class="form-control">   </textarea>
        </div>

    </div>

    <div class="col-12 text-end footer">
        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Annulla</button>
        <button class="btn btn-success" data-modal-action="save">Salva</button>
    </div>

</form>

<script>



    activeModal.$modal
        .on('hide.bs.modal', (e) => {
            tinymce.activeEditor.destroy();
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

    initEditor('textarea#note');


</script>
