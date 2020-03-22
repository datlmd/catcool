<div class="modal fade" id="formPhotoModal" tabindex="-1" role="dialog" aria-labelledby="photoModalLabel" aria-hidden="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="photoModalLabel">{$text_form}</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>
            <div class="modal-body">
                {form_open(uri_string(), ['id' => 'validationform'])}
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            <!-- Drag and Drop container-->
                            {lang('select_photos')}
                            <div class="drop-drap-file" data-is-multi="false">
                                <input type="file" name="file" id="file" accept="audio/*,video/*,image/*" /> {*multiple*}
                                <div class="upload-area dropzone dz-clickable" id="uploadfile">
                                    <h5 class="dz-message"">{lang('image_upload')}</h5>
                                </div>
                            </div>
                            <ul id="image_thumb" data-is_multi="false" class="list_album_photos row">
                                {if $edit_data.image}
                                    <li id="photo_key_{$edit_data.photo_id}" data-id="{$edit_data.photo_id}">
                                        <a href="{image_url($edit_data.image)}" data-lightbox="photos">
                                            <img src="{image_url($edit_data.image)}" class="img-fluid">
                                        </a>
                                        <input type="hidden" name="photo_url[{$edit_data.photo_id}]" value="{$edit_data.image}" class="form-control">
                                    </li>
                                {/if}
                            </ul>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="row mb-1">
                                <div class="col text-right">
                                    {if $edit_data.album_id}
                                        <button type="button" onclick="Photo.submitPhoto('validationform', true);" class="btn btn-sm btn-space btn-primary mb-0" data-toggle="tooltip" data-placement="top" title="" data-original-title="{$text_submit}"><i class="fas fa-save"></i></button>
                                    {else}
                                        <button type="button" onclick="Photo.submitPhoto('validationform');" class="btn btn-sm btn-space btn-primary mb-0" data-toggle="tooltip" data-placement="top" title="" data-original-title="{$text_submit}"><i class="fas fa-save"></i></button>
                                    {/if}
                                    <a href="#" class="btn btn-sm btn-space btn-light mb-0" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true"><i class="fas fa-reply"></i> {lang('button_cancel')}</span>
                                    </a>
                                </div>
                            </div>
                            {if !empty($errors)}
                                {include file=get_theme_path('views/inc/alert.tpl') message=$errors type='danger'}
                            {/if}
                            <div class="tab-regular">
                                {include file=get_theme_path('views/inc/tab_language.inc.tpl') languages=$list_lang}
                                <div class="tab-content border-0 p-3" id="myTabContent">
                                    {foreach $list_lang as $language}
                                        <div class="tab-pane fade {if $language.active}show active{/if}" role="tabpanel" id="lanuage-{$language.id}"  aria-labelledby="language-tab-{$language.id}">
                                            <div class="form-group row">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    {lang('text_name')}
                                                    <input type="text" name="manager_description[{$language.id}][name]" value='{set_value("manager_description[`$language.id`][name]", $edit_data.details[$language.id].name)}' id="input-name[{$language.id}]" data-slug-id="input-slug-{$language.id}" class="form-control {if !empty(form_error("manager_description[`$language.id`][name]"))}is-invalid{/if}">
                                                    {if !empty(form_error("manager_description[`$language.id`][name]"))}
                                                        <div class="invalid-feedback">{form_error("manager_description[`$language.id`][name]")}</div>
                                                    {/if}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    {lang('text_description')}
                                                    <textarea name="manager_description[{$language.id}][description]" cols="20" rows="2" id="input-description[{$language.id}]" type="textarea" class="form-control">{set_value("manager_description[`$language.id`][description]", $edit_data.details[$language.id].description)}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    {lang("text_seo_title")}
                                                    <input type="text" name="manager_description[{$language.id}][meta_title]" value='{set_value("manager_description[`$language.id`][meta_title]", $edit_data.details[$language.id].meta_title)}' id="input-meta-title[{$language.id}]" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    {lang("text_seo_description")}
                                                    <textarea name="manager_description[{$language.id}][meta_description]" cols="20" rows="2" id="input-meta-description[{$language.id}]" type="textarea" class="form-control">{set_value("manager_description[`$language.id`][meta_description]", $edit_data.details[$language.id].meta_description)}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    {lang("text_seo_keyword")}
                                                    <input type="text" name="manager_description[{$language.id}][meta_keyword]" value='{set_value("manager_description[`$language.id`][meta_keyword]", $edit_data.details[$language.id].meta_keyword)}' id="input-meta-keyword[{$language.id}]" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    {/foreach}
                                </div>
                            </div>
                            <h3>{lang('text_manage_more')}</h3>
                            <div class="form-group">
                                {lang('text_published')}
                                <div class="switch-button switch-button-xs float-right mt-1">
                                    <input type="checkbox" name="published" value="{STATUS_ON}" {if $edit_data.photo_id}{if $edit_data.published eq true}checked="checked"{/if}{else}checked="checked"{/if} id="published">
                                    <span><label for="published"></label></span>
                                </div>
                            </div>
                            <div class="form-group">
                                {lang('text_is_comment')}
                                <div class="switch-button switch-button-xs float-right mt-1">
                                    <input type="checkbox" name="is_comment" value="{STATUS_ON}" {if $edit_data.photo_id}{if $edit_data.is_comment eq true}checked="checked"{/if}{else}checked="checked"{/if} id="is_comment">
                                    <span><label for="is_comment"></label></span>
                                </div>
                            </div>
                            <div class="form-group">
                                {lang('text_album')}
                                <select name="album_id" id="album_id" class="form-control">
                                    <option value="">{lang('text_select')}</option>
                                    {foreach $list_album as $key => $value}
                                        <option value="{$key}" {if $edit_data.album_id eq $key}selected="selected"{/if}>{$value}</option>
                                    {/foreach}
                                </select>
                            </div>
                            <div class="form-group">
                                {lang('text_tags')}
                                <input type="text" name="tags" value="{set_value('tags', $edit_data.tags)}" id="tags" class="form-control" data-role="tagsinput">
                            </div>

                            <div class="form-group">
                                {lang('text_sort_order')}
                                <input type="number" name="sort_order" value="{if $edit_data.photo_id}{set_value('sort_order', $edit_data.sort_order)}{else}0{/if}" id="sort_order" min="0" class="form-control">
                            </div>
                        </div>
                    </div>
                {form_close()}
            </div>
        </div>
    </div>
</div>
