<div id="view_albums">
    {form_hidden('manage', $manage_name)}
    <div class="container-fluid  dashboard-content">
        <div class="row">
            {*{include file='breadcrumb.tpl'}*}
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title">{lang('edit_heading')}</h2>
                    <p class="pageheader-text">{lang('add_subheading')}</p>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            {$this->breadcrumb->render()}
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">{lang('add_subheading')}</h5>
                    <div class="card-body">
                        {form_open(uri_string(), ['id' => 'edit_album'])}
                            {form_hidden('id', $item_edit.id)}
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-right">
                                {create_input_token($csrf)}
                                <button type="button" onclick="Photo.submitAlbum('edit_album', true);" class="btn btn-sm btn-space btn-primary">{lang('edit_submit_btn')}</button>
                                <button type="button" onclick="Photo.loadView('{get_last_url($manage_url)}');" class="btn btn-sm btn-space btn-secondary">{lang('btn_cancel')}</button>
                            </div>
                            {if !empty(validation_errors())}
                                <ul class="text-danger">{validation_errors('<li>', '</li>')}</ul>
                            {/if}

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
                                    {lang('description_label')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    {form_textarea($description)}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                    {lang('published_label')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    <div class="switch-button switch-button-sm">
                                        {form_checkbox($published)}
                                        <span><label for="published"></label></span>
                                    </div>
                                    {if !$item_edit.published}
                                        <div class="form-group text-secondary">{lang('msg_not_active')}</div>
                                    {/if}
                                </div>
                            </div>

                            {lang('select_photos')}
                            <!-- Drag and Drop container-->
                            <div class="drop-drap-file" data-module="user" data-is-multi="false">
                                <input type="file" name="file" id="file" multiple accept="audio/*,video/*,image/*" /> {*multiple*}
                                <div class="upload-area dropzone dz-clickable"  id="uploadfile">
                                    <h5 class="dz-message"">{lang('image_upload')}</h5>
                                </div>
                            </div>
                            <ul id="image_thumb" class="row list_album_photos">
                                {if !empty($list_photo)}
                                    {foreach $list_photo as $item}
                                        <li id="photo_key_{$item.id}" data-id="{$item.id}" class="col-xl-3 col-lg-4 col-md-4 col-sm-12 col-12 mb-3">
                                            <a href="{image_url($item.image)}" data-lightbox="photos" class="col-12 col-sm-3 col-form-label text-sm-right">
                                                <img src="" style="background-image: url('{image_url($item.image)}');" class="img-thumbnail img-fluid img-photo-list">
                                            </a><br />
                                            <div class="btn btn-xs btn-danger" data-photo_key="{$item.id}" onclick="Photo.delete_div_photo(this);" style="position: absolute; top: 30px; right: 22px;"><i class="far fa-trash-alt"></i></div>

                                            <input type="hidden" name="photo_url[{$item.id}]" value="{$item.image}" class="form-control">
                                            <input type="text" name="{$item.id}" placeholder="{lang('photo_title_hover')}" value="{$item.title}" class="form-control">
                                        </li>
                                    {/foreach}
                                {/if}
                            </ul>

                        {form_close()}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="confirm_title" value="{lang("confirm_title")}">
<input type="hidden" name="confirm_content" value="{lang("confirm_delete")}">
<input type="hidden" name="confirm_btn_ok" value="{lang("btn_delete")}">
<input type="hidden" name="confirm_btn_close" value="{lang("btn_close")}">
