{form_hidden('manage', $manage_name)}
<div class="container-fluid  dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">{lang('add_heading')}</h2>
                <p class="pageheader-text">{lang('add_subheading')}</p>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        {$this->breadcrumb->render()}
                    </nav>
                </div>
            </div>
        </div>
    </div>
    {form_open(uri_string(), ['id' => 'add_validationform'])}
        <div class="row">
            <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12 col-lg-9 col-md-9 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">{lang('add_subheading')}</h5>
                    <div class="card-body">
                        {if !empty(validation_errors())}
                            <ul class="text-danger">{validation_errors('<li>', '</li>')}</ul>
                        {/if}
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang('title_label')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($title)}
                                {if !empty(form_error('title'))}
                                    <div class="invalid-feedback">
                                        {form_error('title')}
                                    </div>
                                {/if}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang('slug_label')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($slug)}
                                {if !empty(form_error('slug'))}
                                    <div class="invalid-feedback">
                                        {form_error('slug')}
                                    </div>
                                {/if}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang('description_label')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_textarea($description)}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang('attributes_label')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($attributes)}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang('selected_label')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($selected)}
                            </div>
                        </div>
                        <div class="form-group row text-center">
                            <div class="col col-sm-10 col-lg-9 offset-sm-1 offset-lg-0">
                                <button type="submit" class="btn btn-sm btn-space btn-primary"><i class="fas fa-plus mr-1"></i>{lang('add_submit_btn')}</button>
                                {anchor("`$manage_url`", '<i class="fas fa-undo-alt mr-1"></i>'|cat:lang('btn_cancel'), ['class' => 'btn btn-sm btn-space btn-secondary'])}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12 col-lg-3 col-md-3 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">{lang('manage_more_label')}</h5>
                    <div class="card-body">
                        <div class="form-group">
                            {lang('published_label')}
                            <div class="switch-button switch-button-xs float-right mt-1">
                                {form_checkbox($published)}
                                <span><label for="published"></label></span>
                            </div>
                        </div>
                        <div class="form-group">
                            {lang('hidden_label')}
                            <div class="switch-button switch-button-xs float-right mt-1">
                                {form_checkbox($hidden)}
                                <span><label for="hidden"></label></span>
                            </div>
                        </div>
                        <div class="form-group">
                            {lang('is_admin_label')}
                            <div class="switch-button switch-button-xs float-right mt-1">
                                {form_checkbox($is_admin)}
                                <span><label for="is_admin"></label></span>
                            </div>
                        </div>
                        <div class="form-group">
                            {lang('nav_key_label')}
                            {form_input($nav_key)}
                        </div>
                        <div class="form-group">
                            {lang('label_label')}
                            {form_input($label)}
                        </div>
                        <div class="form-group">
                            {lang('icon_label')}
                            {form_input($icon)}
                        </div>
                        <div class="form-group">
                            {lang('context_label')}
                            {form_input($context)}
                        </div>
                        <div class="form-group">
                            {lang('precedence_label')}
                            {form_input($precedence)}
                        </div>
                        <div class="form-group">
                            {lang('parent_label')}
                            <select name="parent_id" id="parent_id" class="form-control">
                                <option value="">{lang('select_dropdown_label')}</option>
                                {$output_html = '<option ##SELECTED## value="##VALUE##">##INDENT_SYMBOL####NAME##</option>'}
                                {$indent_symbol = '-&nbsp;-&nbsp;'}
                                {draw_tree_output($list_all, $output_html, 0, set_value('parent_id'), $indent_symbol)}
                            </select>
                        </div>
                        {if is_show_select_language()}
                            <div class="form-group">
                                {lang('language_label')}
                                {form_dropdown('language', get_multi_lang(), $this->_site_lang, ['id' => 'language', 'class' => 'form-control change_language'])}
                            </div>
                        {/if}
                    </div>
                </div>
            </div>
        </div>
    {form_close()}
</div>

<script src="{{js_url('js/tinymce/tinymce.min', 'common')}}"></script>
<script>
    {literal}
//    tinymce.init({
//
//        editor_selector : "mceEditor",
//
//        selector: '#description',
//        relative_urls:false,
//
//        remove_script_host:false,
//
//        plugins: [
//
//            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
//
//            'searchreplace wordcount visualblocks visualchars code fullscreen',
//
//            'insertdatetime media nonbreaking save table contextmenu directionality',
//
//            'emoticons template paste textcolor colorpicker textpattern imagetools responsivefilemanager'
//
//        ],
//
//        toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | table | link image | responsivefilemanager',
//
//        toolbar2: 'print preview media | forecolor backcolor emoticons',
//
//        image_advtab: true,
//
//        templates: [
//
//            { title: 'Test template 1', content: 'Test 1' },
//
//            { title: 'Test template 2', content: 'Test 2' }
//
//        ],
//        external_filemanager_path:"content/common/js/tinymce/filemanager/",
//        filemanager_title:"Responsive Filemanager" ,
//        external_plugins: { "filemanager" : "filemanager/plugin.min.js"}
//    });

    var mentions_menu_hover = function (userInfo, success) {
        /* request more information about the user from the server and cache it locally */
        if (!userRequest[userInfo.id]) {
            userRequest[userInfo.id] = fakeServer.fetchUser(userInfo.id);
        }
        userRequest[userInfo.id].then(function(userDetail) {
            var div = document.createElement('div');

            div.innerHTML = (
                '<div class="card">' +
                '<h1>' + userDetail.fullName + '</h1>' +
                '<img class="avatar" src="' + userDetail.image + '"/>' +
                '<p>' + userDetail.description + '</p>' +
                '</div>'
            );

            success(div);
        });
    };

    var mentions_menu_complete = function (editor, userInfo) {
        var span = editor.getDoc().createElement('span');
        span.className = 'mymention';
        span.setAttribute('data-mention-id', userInfo.id);
        span.appendChild(editor.getDoc().createTextNode('@' + userInfo.name));
        return span;
    };

    var mentions_select = function (mention, success) {
        /* `mention` is the element we previously created with `mentions_menu_complete`
         in this case we have chosen to store the id as an attribute */
        var id = mention.getAttribute('data-mention-id');
        /* request more information about the user from the server and cache it locally */
        if (!userRequest[id]) {
            userRequest[id] = fakeServer.fetchUser(id);
        }
        userRequest[id].then(function(userDetail) {
            var div = document.createElement('div');
            div.innerHTML = (
                '<div class="card">' +
                '<h1>' + userDetail.fullName + '</h1>' +
                '<img class="avatar" src="' + userDetail.image + '"/>' +
                '<p>' + userDetail.description + '</p>' +
                '</div>'
            );
            success(div);
        });
    };

    tinymce.init({
        selector: 'textarea#description',
        //plugins: 'print preview fullpage powerpaste casechange importcss tinydrive searchreplace autolink autosave save directionality advcode visualblocks visualchars fullscreen image link media mediaembed template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists checklist wordcount tinymcespellchecker a11ychecker imagetools textpattern noneditable help formatpainter permanentpen pageembed charmap tinycomments mentions quickbars linkchecker emoticons',
        plugins: 'print preview fullpage importcss paste searchreplace autolink autosave save directionality visualblocks visualchars fullscreen image responsivefilemanager link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
        imagetools_cors_hosts: ['picsum.photos'],
//        menu: {
//            tc: {
//                title: 'TinyComments',
//                items: 'addcomment showcomments deleteallconversations'
//            }
//        },
        menubar: 'file edit view insert format tools table tc help',
        toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist checklist | forecolor backcolor casechange permanentpen formatpainter removeformat | pagebreak | charmap emoticons | fullscreen  preview print | insertfile image responsivefilemanager media pageembed template link anchor codesample | a11ycheck ltr rtl | showcomments addcomment',
//        autosave_ask_before_unload: true,
//        autosave_interval: "30s",
//        autosave_prefix: "{path}{query}-{id}-",
//        autosave_restore_when_empty: false,
//        autosave_retention: "2m",
        image_advtab: true,
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
        importcss_append: true,
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
        templates: [
            { title: 'New Table', description: 'creates a new table', content: '<div class="mceTmpl"><table width="98%%"  border="0" cellspacing="0" cellpadding="0"><tr><th scope="col"> </th><th scope="col"> </th></tr><tr><td> </td><td> </td></tr></table></div>' },
            { title: 'Starting my story', description: 'A cure for writers block', content: 'Once upon a time...' },
            { title: 'New list with dates', description: 'New List with dates', content: '<div class="mceTmpl"><span class="cdate">cdate</span><br /><span class="mdate">mdate</span><h2>My List</h2><ul><li></li><li></li></ul></div>' }
        ],
        template_cdate_format: '[Date Created (CDATE): %d/%m/%Y : %H:%M:%S]',
        template_mdate_format: '[Date Modified (MDATE): %d/%m/%Y : %H:%M:%S]',
        height: 600,
        image_caption: true,
        quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quicktable',
        noneditable_noneditable_class: "mceNonEditable",
        toolbar_drawer: 'sliding',
        spellchecker_dialog: true,
        spellchecker_whitelist: ['Ephox', 'Moxiecode'],
        tinycomments_mode: 'embedded',
        content_style: ".mymention{ color: green; }",
        contextmenu: "link table",//configurepermanentpen
        mentions_selector: '.mymention',
//        mentions_menu_hover: mentions_menu_hover,
//        mentions_menu_complete: mentions_menu_complete,
//        mentions_select: mentions_select,
        content_style: '.mce-annotation { background: #fff0b7; } .tc-active-annotation {background: #ffe168; color: black; }',
        //set Responsive Filemanager
        external_filemanager_path:"content/common/js/tinymce/filemanager/",
        filemanager_title:"Responsive Filemanager" ,
        external_plugins: { "filemanager" : "filemanager/plugin.min.js"}
    });

    {/literal}
</script>
