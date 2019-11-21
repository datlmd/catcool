<!-- Modal add -->
<div class="modal fade" id="photoModal" tabindex="-1" role="dialog" aria-labelledby="photoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="photoModalLabel">{lang('add_heading')}</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>
            <div class="modal-body">

                {if !empty(validation_errors())}
                    <ul class="text-danger">{validation_errors('<li>', '</li>')}</ul>
                {/if}
                {form_open(uri_string(), ['id' => 'form_edit_photo'])}
                    <div class="form-group row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-right">
                            {form_hidden('id', $item_edit.id)}
                            {create_input_token($csrf)}
                            <button type="button" onclick="Photo.submitPhoto('form_edit_photo');" class="btn btn-sm btn-space btn-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_save')}"><i class="fas fa-save"></i></button>
                            <a href="#" class="btn btn-secondary btn-sm btn-space" data-dismiss="modal" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_close')}"><i class="fas fa-reply"></i></a>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">
                            {lang('text_name')}
                        </label>
                        <div class="col-12 col-sm-8 col-lg-6">
                            {form_input($title)}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">
                            {lang('text_tags')}
                        </label>
                        <div class="col-12 col-sm-8 col-lg-6">
                            {form_input($tags)}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Album</label>
                        <div class="col-12 col-sm-8 col-lg-6">
                            <select name="parent_id" id="parent_id" class="form-control">
                                <option value="">{lang('text_select')}</option>
                                {foreach $list_album as $key => $value}
                                    <option value="{$key}" {if $item_edit.album_id eq $key}selected="selected"{/if}>{$value}</option>
                                {/foreach}
                            </select>
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

            </div>
        </div>
    </div>
</div>