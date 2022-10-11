export class Modal {

    $body = $('body');
    defaultLoader = "<h4 class='loading' style=\"padding: 10px; text-align: center;\"><i class=\"fa fa-spin fa-cog fa-2x\" style=\"vertical-align:middle\"></i> Caricamento...</h4>";
    defaultOptions = {};

    constructor(id, title, body = '', options = {}) {
        this.id = id;
        this.body = body;
        this.title = title;
        this.options = options;
    }

    setOptions(options) {
        this.options = options;
        return this;
    }

    setBody(body) {
        this.blody = body;
        if(this.$modal)
            this.$modal.find('.modal-body').html(body);

        return this;
    }

    setTitle(title) {
        this.title = title;

        if(this.$modal)
            this.$modal.find('.modal-title').html(title);

        return this;
    }

    generate() {

        this.$body.append(`
         <div class="modal fade" id="${this.id}" tabIndex="-1" role="dialog" aria-labelledby="${this.id}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header p-2"><strong class="modal-title">${this.title}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">${this.body}</div>
                        <div class="modal-footer text-center p-2">
                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Chiudi</button>
                        </div>
                    </div>
                </div>
        </div>`);

        this.$modal = this.$body.find('#'+this.id);

        return this;

    }

    displayLoading(loader = null) {
        return this.setBody(loader || this.defaultLoader).display();
    }

    display() {
        window.activeModal = this;

        if(undefined === this.bsModal)
            this.bsModal = new bootstrap.Modal('#'+this.id, _.merge(this.defaultOptions, this.options));

        this.bsModal.show();

        return this;
    }

    destroy() {

        if(this.bsModal) {
            this.bsModal.dispose();
            delete (this.bsModal);
        }

        if(this.$modal) {

            this.$modal.remove();
            delete(this.$modal);

        }
        window.activeModal = null;
        return this;
    }

    hide() {
        this.bsModal.hide();
        return this;
    }

    actionClose(data = {}) {

        if (data.refresh)
            location.reload();
        else if (data.selector && data.html) {
            if (!data.replace)
                $(data.selector).html(data.html);
            else
                $(data.selector).prop('outerHTML', data.html);
        }

        return this;
    }

    prepend(selector, html) {

        this.$modal.find(`.modal-body ${selector}`).remove();
        this.$modal.find('.modal-body').prepend(html);
        return this;
    }

    confirmMessage(message) {

        this
            .setBody(`<div style="padding: 10px; text-align: center;"><i class="fa fa-check text-success fa-3x" style="vertical-align:middle"></i> <strong>${message}</div>`)
            .display();

        this.$modal.find('.loading').remove();
        this.$modal.find('.modal-footer button.close').removeClass('btn-dark').addClass('btn-success');
        return this;
    }

    errorMessage(message) {

        let response = `<div class="error-box">${message}</div>`

        if("object" === typeof(message)) {

            response = `<div class="error-box">
                            <h5 style="padding: 10px; text-align: left;" class="text-danger">
                                <i class="fa fa-times text-danger fa-2x" style="vertical-align:middle"></i> ${message.message}
                            </h5>`

            if (message.errors) {

                response += `<div class="row"><ul class="col-sm-10 offset-sm-1 text-danger">`;

                Object.keys(message.errors).forEach(key => {
                    response += "<li><strong>" + message.errors[key][0] + "</strong></li>"
                })

                response += "</ul></div>";
            }

            response += "</div>";

        }

        this.prepend('.error-box', response).display();

        this.$modal.find('.loading').remove();
        this.$modal.find('.modal-footer button.close').removeClass('btn-dark').addClass('btn-danger');

        return this;
    }

    defaultResponse({data}) {

        if (data.status !== undefined && data.status) {

            this.$modal.one('hidden.bs.modal', () => { this.actionClose(data) });

            if (data.message) {

                if(data.timeout && !(data.timeout % 1000)) {

                    let timeout = data.timeout / 1000,
                        message = data.message + ' (chiusura automatica tra ' + timeout + ' secondi)',
                        interval = setInterval(() => {
                            timeout--;
                            message = data.message + ' (chiusura automatica tra ' + timeout + ' secondi)'
                            this.confirmMessage(message);
                        }, 1000)

                    this.confirmMessage(message);

                    setTimeout(() => {

                        clearInterval(interval);
                        this.hide();

                    }, data.timeout);

                } else
                    this.confirmMessage(data.message);

            } else {
                this.actionClose(data).hide();
            }

        } else
            this.setBody(data).display();

        return this;
    }

    manageErrors(error) {

        if (!error.response) {
            this.errorMessage(JSON.stringify(error));
            throw error;
            return;
        }
        switch (error.response.status) {
            case 404:
                this.errorMessage({message: 'Pagina non trovata'});
                break;

            case 405:
            case 500:
            default:
                this.errorMessage(error.response.data);
                break;
        }
    }
}
