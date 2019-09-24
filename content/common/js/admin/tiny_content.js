//        autosave_ask_before_unload: true,
//        autosave_interval: "30s",
//        autosave_prefix: "{path}{query}-{id}-",
//        autosave_restore_when_empty: false,
//        autosave_retention: "2m",
//        menu: {
//            tc: {
//                title: 'TinyComments',
//                items: 'addcomment showcomments deleteallconversations'
//            }
//        },
//        content_css: [
//            '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
//            '//www.tiny.cloud/css/codepen.min.css'
//        ],
//        link_list: [
//            { title: 'My page 1', value: 'http://www.tinymce.com' },
//            { title: 'My page 2', value: 'http://www.moxiecode.com' }
//        ],
//        image_list: [
//            { title: 'My page 1', value: 'http://www.tinymce.com' },
//            { title: 'My page 2', value: 'http://www.moxiecode.com' }
//        ],
//        image_class_list: [
//            { title: 'None', value: '' },
//            { title: 'Some class', value: 'class-name' }
//        ],
//        file_picker_callback: function (callback, value, meta) {
//            /* Provide file and text for the link dialog */
//            if (meta.filetype === 'file') {
//                callback('https://www.google.com/logos/google.jpg', { text: 'My text' });
//            }
//
//            /* Provide image and alt text for the image dialog */
//            if (meta.filetype === 'image') {
//                callback('https://www.google.com/logos/google.jpg', { alt: 'My alt text' });
//            }
//
//            /* Provide alternative source and posted for the media dialog */
//            if (meta.filetype === 'media') {
//                callback('movie.mp4', { source2: 'alt.ogg', poster: 'https://www.google.com/logos/google.jpg' });
//            }
//        },
//        mentions_menu_hover: mentions_menu_hover,
//        mentions_menu_complete: mentions_menu_complete,
//        mentions_select: mentions_select,
var is_processing = false;
var Tiny_content = {
    loadTiny: function(content_id){
        tinymce.init({
            selector: '#' + content_id,
            //skin: 'oxide-dark',
            //theme: "silver",
            //plugins: 'print preview fullpage powerpaste casechange importcss tinydrive searchreplace autolink autosave save directionality advcode visualblocks visualchars fullscreen image link media mediaembed template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists checklist wordcount tinymcespellchecker a11ychecker imagetools textpattern noneditable help formatpainter permanentpen pageembed charmap tinycomments mentions quickbars linkchecker emoticons',
            plugins: 'print preview fullpage importcss paste searchreplace autolink autosave save directionality visualblocks visualchars fullscreen image responsivefilemanager link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
            imagetools_cors_hosts: ['picsum.photos'],
            remove_script_host:false,
            menubar: 'file edit view insert format tools table tc help',
            toolbar: 'undo redo | fullscreen | formatselect bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist checklist | forecolor backcolor casechange permanentpen formatpainter removeformat | pagebreak | charmap emoticons | preview print | insertfile image responsivefilemanager media pageembed template link anchor codesample | a11ycheck ltr rtl | showcomments addcomment',
            fontsize_formats: "8px 10px 12px 14px 18px 24px 36px 50px 72px",
            image_advtab: true,
            importcss_append: true,
            templates: [
                { title: 'New Table', description: 'creates a new table', content: '<div class="mceTmpl"><table width="98%%"  border="0" cellspacing="0" cellpadding="0"><tr><th scope="col"> </th><th scope="col"> </th></tr><tr><td> </td><td> </td></tr></table></div>' },
                { title: 'Starting my story', description: 'A cure for writers block', content: 'Once upon a time...' },
                { title: 'New list with dates', description: 'New List with dates', content: '<div class="mceTmpl"><span class="cdate">cdate</span><br /><span class="mdate">mdate</span><h2>My List</h2><ul><li></li><li></li></ul></div>' }
            ],
            template_cdate_format: '[Date Created (CDATE): %d/%m/%Y : %H:%M:%S]',
            template_mdate_format: '[Date Modified (MDATE): %d/%m/%Y : %H:%M:%S]',
            height: 600,
            image_caption: true,
            quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quicktable | fontsizeselect',
            quickbars_insert_toolbar: 'formatselect blockquote image quicktable',
            noneditable_noneditable_class: "mceNonEditable",
            toolbar_drawer: 'sliding',
            spellchecker_dialog: true,
            spellchecker_whitelist: ['Ephox', 'Moxiecode'],
            tinycomments_mode: 'embedded',
            content_style: ".mymention{ color: green; }",
            contextmenu: "link table",//configurepermanentpen
            mentions_selector: '.mymention',
            content_style: '.mce-annotation { background: #fff0b7; } .tc-active-annotation {background: #ffe168; color: black; }',
            //set Responsive Filemanager
            external_filemanager_path:"content/common/js/tinymce/filemanager/",
            filemanager_title:"Responsive Filemanager" ,
            external_plugins: { "filemanager" : "filemanager/plugin.min.js"}
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

