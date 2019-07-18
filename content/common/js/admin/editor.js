var is_processing = false;
var editor;
var Editor = {
    getCkeditor: function (id_input, id_form) {

        if (!id_input.length || !id_form.length) {
            return false;
        }
        ClassicEditor
            .create(document.querySelector(id_input), {
                //extraPlugins: [ MyCustomUploadAdapterPlugin ],
                ckfinder: {
                    uploadUrl: './content/common/js/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images&responseType=json'
                },
                toolbar: ['heading', '|', 'bold', 'italic', 'underline', 'blockQuote', 'bulletedList', 'numberedList','link', 'insertTable', 'code', '|' ,'ckfinder', 'imageUpload', 'mediaEmbed', '|','undo', 'redo' ],
            })
            .then(newEditor => {
                editor = newEditor;
            })
            .catch( err => {
                console.error( err.stack );
            });
        document.querySelector(id_form).addEventListener('click', () => {
            $(id_input).val(editor.getData());
        // ...
        });
    },

};

/* action - event */
$(function () {
    if ($('.load_ckeditor').length) {
        Editor.getCkeditor('.load_ckeditor', '#' + $('form').attr('id'));
    }
});
