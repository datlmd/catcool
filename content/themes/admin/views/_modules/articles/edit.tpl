{form_hidden('manage', $manage_name)}
<div class="container-fluid  dashboard-content">
    {include file=get_theme_path('views/inc/breadcrumb.inc.tpl')}
    {form_open_multipart(uri_string(), ['id' => 'edit_validationform'])}
        <div class="row">
            <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12 col-lg-9 col-md-9 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-8">
                                <h5 class="mb-0 mt-1 ml-1"><i class="far fa-edit mr-2"></i>{lang('add_subheading')}</h5>
                            </div>
                            <div class="col-4 text-right">
                                {form_hidden('id', $item_edit.id)}
                                {create_input_token($csrf)}
                                <button type="submit" class="btn btn-sm btn-space btn-primary mb-0"  data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('edit_submit_btn')}"><i class="fas fa-save"></i></button>
                                <a href="{$manage_url}" class="btn btn-sm btn-space btn-secondary mb-0"  data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('btn_cancel')}"><i class="fas fa-undo-alt"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        {if !empty(validation_errors())}
                            <ul class="text-danger">{validation_errors('<li>', '</li>')}</ul>
                        {/if}
                        <div class="form-group">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                {lang('title_label')}
                                {form_input($title)}
                                {if !empty(form_error('title'))}
                                    <div class="invalid-feedback">
                                        {form_error('title')}
                                    </div>
                                {/if}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                {lang("slug_label")}
                                {form_input($slug)}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                {lang('description_label')}
                                {form_textarea($description)}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                {lang("content_label")}
                                {form_textarea($content)}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                {lang("seo_title_label")}
                                {form_input($seo_title)}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                {lang("seo_description_label")}
                                {form_textarea($seo_description)}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                {lang("seo_keyword_label")}
                                {form_input($seo_keyword)}
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
                            {if !$item_edit.published}
                                <div class="form-group text-secondary">{lang('msg_not_active')}</div>
                            {/if}
                        </div>
                        <div class="form-group">
                            {lang("is_comment_label")}
                            <div class="switch-button switch-button-xs float-right mt-1">
                                {form_checkbox($is_comment)}
                                <span><label for="is_comment"></label></span>
                            </div>
                        </div>
                        <div class="form-group">
                            {lang("publish_date_label")}
                            <div class="input-group date" id="show-datetime-picker" data-target-input="nearest" data-link-format="DD/MM/YYYY HH:MM"  >
                                <input type="text" name="publish_date" id="publish_date" class="form-control datetimepicker-input" value="{$item_edit.publish_date|date_format:'d/m/Y H:i'}" data-target="#show-datetime-picker" />
                                <div class="input-group-append" data-target="#show-datetime-picker" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {lang("images_label")}
                            <!-- Drag and Drop container-->
                            {form_hidden('images', $item_edit.images)}
                            <div class="drop-drap-file" data-module="article" data-is-multi="false">
                                <a href="" id="thumb-image" data-target-input="input-image" data-toggle="image" >
                                    <img src="{image_url($item_edit.images)}" class="img-thumbnail mr-1 img-fluid" alt="" title="" />
                                </a>
                                <input type="hidden" name="image" value="" id="input-image" />
                            </div>
                        </div>
                        <div class="form-group">
                            {lang("categories_label")}
                            <div id="list_category" class="list_checkbox">
                                <div id="add_more_data"></div>
                                {if !empty($categories)}
                                    {foreach $categories as $category}
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" name="category_ids[]" id="category_{$category.id}" {if strpos($categorie_item, $category.id) !== false}checked="checked"{/if} value="{$category.id}" class="custom-control-input">
                                            <span class="custom-control-label">{$category.title}</span>
                                        </label>
                                    {/foreach}
                                {/if}
                            </div>
                            {*<a href="#" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#addNewModal">*}
                                {*{lang('btn_add_modal')}*}
                            {*</a>*}
                        </div>
                        <div class="form-group">
                            {lang("tags_label")}
                            {form_input($tags)}
                        </div>
                        <div class="form-group">
                            {lang("author_label")}
                            {form_input($author)}
                        </div>
                        <div class="form-group">
                            {lang("source_label")}
                            {form_input($source)}
                        </div>
                        <div class="form-group">
                            {lang('precedence_label')}
                            {form_input($precedence)}
                        </div>
                        {if is_show_select_language()}
                            <div class="form-group">
                                {lang('language_label')}
                                {form_dropdown('language', get_multi_lang(), $item_edit.language, ['class' => 'form-control change_language_article'])}
                                {* css: change_language dung de load lai ddanh muc cha*}
                            </div>
                        {/if}
                    </div>
                </div>
            </div>
        </div>
    {form_close()}
</div>
<!-- Load modal-->
{include file=$this->theme->theme_path('views/inc/articles/modal_create_category.tpl') content='article'}
{*https://summernote.org/*}
{*https://demo.opencart.com/admin*}
<script>$(document).ready(function() {
        $('[data-toggle=\'summernote\']').each(function() {
            var element = this;
            if ($(this).attr('data-lang')) {
                $('head').append('<script type="text/javascript" src="view/javascript/summernote/lang/summernote-' + $(this).attr('data-lang') + '.js"></script>');
}

$(element).summernote({
lang: $(this).attr('data-lang'),
disableDragAndDrop: true,
height: 300,
emptyPara: '',
codemirror: {
mode: 'text/html',
htmlMode: true,
lineNumbers: true,
theme: 'monokai'
},
fontsize: ['8', '9', '10', '11', '12', '14', '16', '18', '20', '24', '30', '36', '48', '64'],
toolbar: [
['style', ['style']],
['font', ['bold', 'underline', 'clear']],
['fontname', ['fontname']],
['fontsize', ['fontsize']],
['color', ['color']],
['para', ['ul', 'ol', 'paragraph']],
['table', ['table']],
['insert', ['link', 'image', 'video']],
['view', ['fullscreen', 'codeview', 'help']]
],
popover: {
image: [
['custom', ['imageAttributes']],
['imagesize', ['imageSize100', 'imageSize50', 'imageSize25']],
['float', ['floatLeft', 'floatRight', 'floatNone']],
['remove', ['removeMedia']]
],
},
buttons: {
image: function() {
var ui = $.summernote.ui;
var button = ui.button({
contents: '<i class="note-icon-picture" />',
tooltip: $.summernote.lang[$.summernote.options.lang].image.image,
click: function() {
$('#modal-image').remove();
$.ajax({
url: 'index.php?route=common/filemanager&user_token=' + getURLVar('user_token'),
dataType: 'html',
beforeSend: function() {
$('#button-image i').replaceWith('<i class="fa fa-circle-o-notch fa-spin"></i>');
$('#button-image').prop('disabled', true);
},
complete: function() {
$('#button-image i').replaceWith('<i class="fa fa-upload"></i>');
$('#button-image').prop('disabled', false);
},
success: function(html) {
$('body').append('<div id="modal-image" class="modal">' + html + '</div>');
$('#modal-image').modal('show');
$('#modal-image').delegate('a.thumbnail', 'click', function(e) {
e.preventDefault();
$(element).summernote('insertImage', $(this).attr('href'));
$('#modal-image').modal('hide');
});
}
});
}
});
return button.render();
}
}
});
});
});
</script>
