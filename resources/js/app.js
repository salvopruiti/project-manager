require('./bootstrap');

import jQuery from 'jquery';
import {Modal} from './Modal';

const { zonedTimeToUtc, utcToZonedTime, format } = require('date-fns-tz')


window.$ = window.jQuery = jQuery;
window.Modal = Modal;

jQuery(function() {

    initEditor();


    $('body')
        .on(
            'click',
            'button[data-action]',
            e => {
                e.preventDefault();

                let button = $(e.currentTarget),
                    action = button.data('action'),
                    formData = button.data('postData') || {},
                    modal = new Modal('actionModal', button.data('title'));

                if(button.data('targetForm')) {
                    let form = document.querySelector(button.data('targetForm'))
                    formData = new FormData(form);
                }

                if(!button.hasClass('no-loader'))
                    button.prepend('<span class="loader pr-2"><span class="spinner-border spinner-border-sm"></span></span>');

                button.attr('disabled', true)

                axios.post(action, formData).then(
                    ({data}) => {

                        if (data.status !== undefined && data.status) {

                            modal.$modal.one('hidden.bs.modal', () => { modal.actionClose(data) });

                            if (data.message)
                                modal.confirmMessage(data.message);
                            else {
                                modal.actionClose(data).destroy();
                            }

                        } else
                            modal.setBody(data).display();

                    }
                ).catch(error => modal.manageErrors(error)).then(() => {
                    button.removeAttr('disabled').find('.loader').remove();
                })

                modal.generate().$modal.on('hidden.bs.modal', () => {
                    modal.destroy();
                });
            }
        )
        .on(
            'click',
            '[data-modal-url]',
            e => {
                e.preventDefault();

                let button = $(e.currentTarget),
                    title = button.data('modalTitle') || '',
                    url = button.attr('data-modal-url'),
                    classes = button.data('modalClasses'),
                    options = button.data('modalOptions') || {backdrop: true},
                    modal;

                if(!button.hasClass('no-loader'))
                    button.prepend('<span class="loader pr-2"><span class="spinner-border spinner-border-sm"></span></span>').attr('disabled', true);

                modal = new Modal('id', title);
                modal.generate().setOptions(options).displayLoading().$modal.on('hidden.bs.modal', () => {
                    modal.destroy();
                });

                if(classes) {
                    classes.split(' ').forEach(modalClass => modal.$modal.find('.modal-dialog').addClass(classes));
                }

                axios.get(url)
                    .then(response => modal.defaultResponse(response))
                    .catch(error => modal.manageErrors(error))
                    .then(() => {
                        button.removeAttr('disabled').find('.loader').remove();
                    })


            }
        );


    document.querySelectorAll('[data-start]').forEach(element => {

        setInterval(() => {

            let start = parseInt(element.dataset.start);

            start++;

            let date = new Date(start * 1000);

            date = utcToZonedTime(date, 'Z');

            let decimal = ((start / 60) / 60).toFixed(2);

            element.innerHTML = format(date, 'HH:mm:ss') + ' (' + decimal + ')'

            element.dataset.start = start;

        }, 1000)

    });

});

window.initEditor = (selector = '.form-group textarea.visual-editor') => {

    return tinymce.init({
        contextmenu: false,
        selector,
        statusbar: false,
        content_style: "@import url('https://fonts.googleapis.com/css?family=Nunito'); body {font-family: \"Nunito\"}",
        toolbar: [
            { name: 'history', items: [ 'undo', 'redo' ] },
            { name: 'styles', items: [ 'styles', 'fontfamily', 'fontsize' ] },
            { name: 'formatting', items: [ 'bold', 'italic', 'underline', 'forecolor', 'backcolor' ] },
            { name: 'alignment', items: [ 'alignleft', 'aligncenter', 'alignright', 'alignjustify' ] },
            { name: 'indentation', items: [ 'outdent', 'indent' ] },
            { name: 'media', items: ['image', 'code', 'fullscreen', 'media', 'link']}
        ],
        plugins: ['code','image','fullscreen', 'visualblocks', 'media', 'link'],
        language: 'it',
        automatic_uploads: true,
        language_url: '/js/it.js',
        file_picker_types: 'image',
        object_resizing: true,
        file_picker_callback: (cb, value, meta) => {
            const input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');

            input.addEventListener('change', (e) => {
                const file = e.target.files[0];

                const reader = new FileReader();
                reader.addEventListener('load', () => {
                    /*
                      Note: Now we need to register the blob in TinyMCEs image blob
                      registry. In the next release this part hopefully won't be
                      necessary, as we are looking to handle it internally.
                    */
                    const id = 'blobid' + (new Date()).getTime();
                    const blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                    const base64 = reader.result.split(',')[1];
                    const blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);

                    /* call the callback and populate the Title field with the file name */
                    cb(blobInfo.blobUri(), { title: file.name });
                });
                reader.readAsDataURL(file);
            });

            input.click();
        },
    })


}

import TomSelect from "tom-select";

window.TomSelect = TomSelect;

jQuery(function() {

    document.querySelectorAll('.form-group select').forEach(element => {

        let settings = {
            plugins: [],
            closeAfterSelect: true,
            allowEmptyOption: true,
            loadThrottle: 0,
            selectOnTab: true,
            persist: true,
            render:{
                option_create: function( data, escape ){
                    return `<div class="create">Aggiungi <strong>${escape(data.input)}</strong>&hellip;</div>`;
                },
                no_results: function( data, escape ){
                    return `<div class="no-results">Nessun risultato per <strong>${escape(data.input)}</strong></div>`;
                },
            }
        };

        if(element.multiple) {
            settings.plugins.push('remove_button');
        }

        new TomSelect(element, settings);
    })


})
