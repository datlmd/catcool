{if !empty(validation_errors())}
    <ul class="text-danger">{validation_errors('<li>', '</li>')}</ul>
{/if}
{form_open(uri_string(), ['id' => 'edit_validationform'])}
    <div class="form-group row text-center">
        <div class="col col-sm-10 col-lg-9 offset-sm-1 offset-lg-0">
            {form_hidden('id', $item_edit.id)}
            {create_input_token($csrf)}
            <button type="submit" class="btn btn-sm btn-space btn-primary">{lang('edit_submit_btn')}</button>
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
    <ul id="image_thumb" data-is_multi="false" class="list_album_photos row mt-2">
        {if !empty($item_edit.image)}
            <li id="photo_key_{$item_edit.id}" data-id="{$item_edit.id}" class="col-xl-3 col-lg-4 col-md-4 col-sm-12 col-12 mb-3">
                <a href="{image_url($item_edit.image)}" data-lightbox="photos">
                    <img src="" style="background-image: url('{image_url($item_edit.image)}');" class="img-thumbnail img-fluid img-photo-list">
                </a>
                <div class="btn btn-xs btn-danger top_right" data-photo_key="{$item_edit.id}" onclick="Photo.delete_div_photo(this);" ><i class="far fa-trash-alt"></i></div>
                <input type="hidden" name="photo_url[{$item_edit.id}]" value="{$item_edit.image}" class="form-control">
            </li>
        {/if}
    </ul>
{form_close()}