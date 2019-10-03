{if !empty(validation_errors())}
    <ul class="text-danger">{validation_errors('<li>', '</li>')}</ul>
{/if}
{form_open(uri_string(), ['id' => 'form_add_photo'])}
    <div class="form-group row text-right">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-right">
            <button type="button" onclick="Photo.submitPhoto('form_add_photo');" class="btn btn-sm btn-space btn-primary">{lang('add_submit_btn')}</button>
            <a href="#" class="btn btn-secondary btn-sm btn-space" data-dismiss="modal">{lang('btn_close')}</a>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-12 col-sm-3 col-form-label text-sm-right">
            {lang('title_label')}
        </label>
        <div class="col-12 col-sm-8 col-lg-6">
            {form_input($title)}
        </div>
    </div>
    <div class="form-group row">
        <label class="col-12 col-sm-3 col-form-label text-sm-right">
            {lang('tags_label')}
        </label>
        <div class="col-12 col-sm-8 col-lg-6">
            {form_input($tags)}
        </div>
    </div>
    <div class="form-group row">
        <label class="col-12 col-sm-3 col-form-label text-sm-right">{lang("is_comment_label")}</label>
        <div class="col-12 col-sm-8 col-lg-6">
            <div class="switch-button switch-button-sm mt-1">
                {form_checkbox($is_comment)}
                <span><label for="is_comment"></label></span>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-12 col-sm-3 col-form-label text-sm-right">{lang('published')}</label>
        <div class="col-12 col-sm-8 col-lg-6">
            <div class="switch-button switch-button-sm mt-1">
                {form_checkbox($published)}
                <span><label for="published"></label></span>
            </div>
        </div>
    </div>

    <!-- Drag and Drop container-->
    {lang('select_photos')}
    <div class="drop-drap-file" data-is-multi="false">
        <input type="file" name="file" id="file" accept="audio/*,video/*,image/*" /> {*multiple*}
        <div class="upload-area dropzone dz-clickable" id="uploadfile">
            <h5 class="dz-message"">{lang('image_upload')}</h5>
        </div>
    </div>
    <ul id="image_thumb" data-is_multi="false" class="list_album_photos row mt-2"></ul>

{form_close()}

<input type="hidden" name="confirm_title" value="{lang("confirm_title")}">
<input type="hidden" name="confirm_content" value="{lang("confirm_delete")}">
<input type="hidden" name="confirm_btn_ok" value="{lang("btn_delete")}">
<input type="hidden" name="confirm_btn_close" value="{lang("btn_close")}">