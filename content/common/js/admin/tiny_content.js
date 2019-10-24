var is_processing = false;
var Tiny_content = {
    loadTiny: function(content_id, max_height) {
        if (typeof max_height === 'undefined') {
            max_height = 400;
        }

        tinymce.init({
            selector: '#' + content_id,
            //skin: 'oxide-dark',
            //themes: "silver",
            //plugins: 'print preview fullpage powerpaste casechange importcss tinydrive searchreplace autolink autosave save directionality advcode visualblocks visualchars fullscreen image link media mediaembed template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists checklist wordcount tinymcespellchecker a11ychecker imagetools textpattern noneditable help formatpainter permanentpen pageembed charmap tinycomments mentions quickbars linkchecker emoticons',
            plugins: 'print preview fullpage importcss paste searchreplace autolink autosave save directionality visualblocks visualchars fullscreen image imagetools responsivefilemanager link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount textpattern noneditable help charmap quickbars emoticons code',
            //imagetools_cors_hosts: ['picsum.photos'],
            remove_script_host:false,
            menubar: false,
            toolbar: 'undo redo | formatselect bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | outdent indent | link myFileManager media | numlist bullist checklist | table | fontselect fontsizeselect | forecolor backcolor casechange permanentpen formatpainter removeformat | pagebreak codesample | fullscreen preview code | help', /* charmap emoticons a11ycheck ltr rtl */
            fontsize_formats: "8px 10px 12px 14px 18px 24px 36px 50px 72px",
            image_caption: true,
            image_advtab: true,
            imagetools_toolbar: "alignleft aligncenter alignright image",//"rotateleft rotateright | flipv fliph | editimage imageoptions",
            //importcss_append: true,
            template_cdate_format: '[Date Created (CDATE): %d/%m/%Y : %H:%M:%S]',
            template_mdate_format: '[Date Modified (MDATE): %d/%m/%Y : %H:%M:%S]',
            height: max_height,
            quickbars_selection_toolbar: 'bold italic underline blockquote | quicklink | alignleft aligncenter alignright',
            quickbars_insert_toolbar: 'formatselect blockquote quicktable myFileManager',
            toolbar_drawer: 'sliding',
            contextmenu: "link image",/*right click*/
            setup: (editor) => {
                editor.ui.registry.addButton('myFileManager', {
                    icon: 'image',
                    tooltip: 'File Manager',
                    onAction: () => {
                        $('#modal-image').remove();
                        $.ajax({
                            url: 'common/filemanager',
                            dataType: 'html',
                            beforeSend: function() {
                                $('#button-image i').replaceWith('<i class="fas fa-circle-notch fa-spin"></i>');
                                $('#button-image').prop('disabled', true);
                            },
                            complete: function() {
                                $('#button-image i').replaceWith('<i class="fas fa-upload"></i>');
                                $('#button-image').prop('disabled', false);
                            },
                            success: function(html) {
                                $('body').append('<div id="modal-image" class="modal">' + html + '</div>');

                                $('#modal-image').modal('show');
                                $('#modal-image').delegate('a.thumbnail', 'click', function(e) {
                                    e.preventDefault();
                                    // editor.insertContent('<figure class="image"><img src="' + $(this).attr('href') + '"><figcaption></figcaption></figure>');
                                    editor.insertContent('<img src="' + $(this).attr('href') + '">');

                                    $('#modal-image').modal('hide');
                                });
                            }
                        });
                    }
                });
            },//end setup
        });

        return true;
    },
};
