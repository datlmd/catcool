{form_hidden('manage', $manage_name)}
<div class="container-fluid  dashboard-content">
    {form_open(uri_string(), ['id' => 'validationform'])}
        <div class="row">
            <div class="col-7">
                {include file=get_theme_path('views/inc/breadcrumb.inc.tpl')}
            </div>
            <div class="col-5 text-right">
                <button type="submit" class="btn btn-sm btn-space btn-primary mb-0"  data-toggle="tooltip" data-placement="top" title="" data-original-title="{$text_submit}"><i class="fas fa-save"></i></button>
                <a href="{$button_cancel}" class="btn btn-sm btn-space btn-secondary mb-0"  data-toggle="tooltip" data-placement="top" title="" data-original-title="{$text_cancel}"><i class="fas fa-reply"></i></a>
            </div>
        </div>
        {if !empty($edit_data.category_id)}
            {form_hidden('category_id', $edit_data.category_id)}
            {create_input_token($csrf)}
        {/if}
        <div class="row">
            {if !empty($errors)}
                <div class="col-12">
                    {include file=get_theme_path('views/inc/alert.tpl') message=$errors type='danger'}
                </div>
            {/if}
            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header"><i class="fas {if !empty($edit_data.category_id)}fa-edit{else}fa-plus{/if} mr-2"></i>{$text_form}</h5>
                    <div class="card-body p-0 pt-3 bg-light">
                        <div class="tab-regular">
                            {include file=get_theme_path('views/inc/tab_language.inc.tpl') languages=$list_lang}
                            <div class="tab-content border-0 p-3" id="cate_tab_content">
                                {foreach $list_lang as $language}
                                    <div class="tab-pane fade {if $language.active}show active{/if}" role="tabpanel" id="lanuage_content_{$language.id}"  aria-labelledby="language_tab_{$language.id}">
                                        <div class="form-group row required has-error">
                                            <label class="col-12 col-sm-3 col-form-label required-lable text-sm-right">
                                                {lang('text_name')}
                                            </label>
                                            <div class="col-12 col-sm-8 col-lg-8">
                                                <input type="text" name="manager_description[{$language.id}][name]" value='{set_value("manager_description[`$language.id`][name]", $edit_data.details[$language.id].name)}' id="input-name[{$language.id}]" data-slug-id="input-slug-{$language.id}" class="form-control {if !empty(form_error("manager_description[`$language.id`][name]"))}is-invalid{/if} {if empty($edit_data.category_id)}make_slug{/if}">
                                                {if !empty(form_error("manager_description[`$language.id`][name]"))}
                                                    <div class="invalid-feedback">{form_error("manager_description[`$language.id`][name]")}</div>
                                                {/if}
                                            </div>
                                        </div>
                                        <div class="form-group row required">
                                            <label class="col-12 col-sm-3 col-form-label required-lable text-sm-right">
                                                {lang('text_slug')}
                                            </label>
                                            <div class="col-12 col-sm-8 col-lg-8">
                                                <input type="text" name="manager_description[{$language.id}][slug]" value='{set_value("manager_description[`$language.id`][slug]", $edit_data.details[$language.id].slug)}' id="input-slug-{$language.id}" class="form-control {if !empty($errors["slug_`$language.id`"])}is-invalid{/if}">
                                                {if !empty($errors["slug_`$language.id`"])}
                                                    <div class="invalid-feedback">{$errors["slug_`$language.id`"]}</div>
                                                {/if}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                                {lang('text_description')}
                                            </label>
                                            <div class="col-12 col-sm-8 col-lg-8">
                                                <textarea name="manager_description[{$language.id}][description]" cols="40" rows="2" id="input-description[{$language.id}]" type="textarea" class="form-control">{set_value("manager_description[`$language.id`][description]", $edit_data.details[$language.id].description)}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                                {lang("text_seo_title")}
                                            </label>
                                            <div class="col-12 col-sm-8 col-lg-8">
                                                <input type="text" name="manager_description[{$language.id}][meta_title]" value='{set_value("manager_description[`$language.id`][meta_title]", $edit_data.details[$language.id].meta_title)}' id="input-meta-title[{$language.id}]" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                                {lang("text_seo_description")}
                                            </label>
                                            <div class="col-12 col-sm-8 col-lg-8">
                                                <textarea name="manager_description[{$language.id}][meta_description]" cols="40" rows="2" id="input-meta-description[{$language.id}]" type="textarea" class="form-control">{set_value("manager_description[`$language.id`][meta_description]", $edit_data.details[$language.id].meta_description)}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                                {lang("text_seo_keyword")}
                                            </label>
                                            <div class="col-12 col-sm-8 col-lg-8">
                                                <input type="text" name="manager_description[{$language.id}][meta_keyword]" value='{set_value("manager_description[`$language.id`][meta_keyword]", $edit_data.details[$language.id].meta_keyword)}' id="input-meta-keyword[{$language.id}]" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                {/foreach}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">{lang('text_manage_more')}</h5>
                    <div class="card-body">
                        <div class="form-group">
                            {lang('text_published')}
                            <div class="switch-button switch-button-xs float-right mt-1">
                                <input type="checkbox" name="published" value="{STATUS_ON}" {if $edit_data.category_id}{if $edit_data.published eq true}checked="checked"{/if}{else}checked="checked"{/if} id="published">
                                <span><label for="published"></label></span>
                            </div>
                        </div>
                        <div class="form-group">
                            {lang("text_image")}
                            <!-- Drag and Drop container-->
                            <a href="javascript:void(0);" id="thumb-image" data-target="input-image-path" data-thumb="load-thumb-image" data-toggle="image">
                                <img src="{if !empty($edit_data.image)}{image_thumb_url($edit_data.image)}{else}{site_url(UPLOAD_IMAGE_DEFAULT)}{/if}" class="img-thumbnail w-100 mr-1 img-fluid" alt="" title="" id="load-thumb-image" data-placeholder="{site_url(UPLOAD_IMAGE_DEFAULT)}"/>
                                <button type="button" id="button-image" class="btn btn-xs btn-primary w-100 mt-1"><i class="fas fa-pencil-alt mr-1"></i>{lang('text_photo_edit')}</button>
                                <button type="button" id="button-clear" class="btn btn-xs btn-danger w-100 mt-1 mb-1"><i class="fas fa-trash mr-1"></i>{lang('text_photo_clear')}</button>
                            </a>
                            <input type="hidden" name="image" value="{$edit_data.image}" id="input-image-path" />
                        </div>
                        <div class="form-group">
                            {lang('text_sort_order')}
                            <input type="number" name="sort_order" value="{if $edit_data.category_id}{set_value('sort_order', $edit_data.sort_order)}{else}0{/if}" id="sort_order" min="0" class="form-control">
                        </div>
                        <div class="form-group">
                            {lang('text_parent')}
                            <select name="parent_id" id="parent_id" class="form-control">
                                <option value="">{lang('text_select')}</option>
                                {$output_html = '<option ##SELECTED## value="##VALUE##">##INDENT_SYMBOL####NAME##</option>'}
                                {draw_tree_output_name(['data' => $list_patent, 'key_id' => 'category_id', 'id_root' => $edit_data.category_id], $output_html, 0, $edit_data.parent_id)}
                            </select>
                        </div>
                    </div>
                </div>
                {if $edit_data.category_id}
                    {include file=get_theme_path('views/inc/status_form.inc.tpl')}
                {/if}
            </div>
        </div>
    {form_close()}
</div>
