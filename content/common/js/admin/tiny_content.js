var is_processing = false;
var Tiny_content = {
    loadTiny: function(content_id) {
        tinymce.init({
            selector: '#' + content_id,
            //skin: 'oxide-dark',
            //theme: "silver",
            //plugins: 'print preview fullpage powerpaste casechange importcss tinydrive searchreplace autolink autosave save directionality advcode visualblocks visualchars fullscreen image link media mediaembed template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists checklist wordcount tinymcespellchecker a11ychecker imagetools textpattern noneditable help formatpainter permanentpen pageembed charmap tinycomments mentions quickbars linkchecker emoticons',
            plugins: 'print preview fullpage importcss paste searchreplace autolink autosave save directionality visualblocks visualchars fullscreen image imagetools responsivefilemanager link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount textpattern noneditable help charmap quickbars emoticons code',
            //imagetools_cors_hosts: ['picsum.photos'],
            remove_script_host:false,
            menubar: false,
            toolbar: 'undo redo | fullscreen | formatselect bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist checklist | forecolor backcolor casechange permanentpen formatpainter removeformat | pagebreak | charmap emoticons | preview print | insertfile myFileManager media pageembed template link anchor codesample code | a11ycheck ltr rtl | showcomments addcomment',
            fontsize_formats: "8px 10px 12px 14px 18px 24px 36px 50px 72px",
            image_advtab: true,
            editimage: false,
            imagetools_toolbar: "alignleft aligncenter alignright image",//"rotateleft rotateright | flipv fliph | editimage imageoptions",
            //importcss_append: true,
            template_cdate_format: '[Date Created (CDATE): %d/%m/%Y : %H:%M:%S]',
            template_mdate_format: '[Date Modified (MDATE): %d/%m/%Y : %H:%M:%S]',
            height: 600,
            image_caption: true,
            quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quicktable | fontsizeselect',
            quickbars_insert_toolbar: 'formatselect blockquote quicktable myFileManager',
            //noneditable_noneditable_class: "mceNonEditable",
            toolbar_drawer: 'sliding',
            contextmenu: "link image",//right click
            //set Responsive Filemanager
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
                                    console.log($(this).attr('href'));
                                    //$('#summernote').summernote('insertImage', url, filename);
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
    loadTinyMini: function(content_id){
        tinymce.init({
            editor_selector : "mceEditor",
            selector: '#' + content_id,
            relative_urls:false,
            remove_script_host:false,
            plugins: [

                'advlist autolink lists link image charmap print preview hr anchor pagebreak',

                'searchreplace wordcount visualblocks visualchars code fullscreen',

                'insertdatetime media nonbreaking save table contextmenu directionality',

                'emoticons template paste textcolor colorpicker textpattern imagetools responsivefilemanager'

            ],
            toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | table | link image | responsivefilemanager',
            toolbar2: 'print preview media | forecolor backcolor emoticons',
            image_advtab: true,
            templates: [
                { title: 'Test template 1', content: 'Test 1' },

                { title: 'Test template 2', content: 'Test 2' }

            ],
            external_filemanager_path:"content/common/js/tinymce/filemanager/",
            filemanager_title:"Responsive Filemanager" ,
            external_plugins: { "filemanager" : "filemanager/plugin.min.js"}
        });
    },
    getTiny: function (editor_id) {
        if ( typeof editor_id == 'undefined' ) {
            return false;
        }

        return tinymce.get(editor_id).getBody().innerText;
    },
    setTiny: function(content, editor_id) {
        if ( typeof editor_id == 'undefined' ) {
            return false;
        }

        return tinymce.get(editor_id).setContent(content);
    },
    focusTiny: function(editor_id) {
        if ( typeof editor_id == 'undefined' ) {
            return false;
        }

        return tinymce.get(editor_id).focus();
    },
};

/* action - event */
$(function () {

});

