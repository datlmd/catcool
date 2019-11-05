{form_hidden('manage', $manage_name)}
<div class="container-fluid  dashboard-content">
    {include file=get_theme_path('views/inc/breadcrumb.inc.tpl')}
    {form_open(uri_string(), ['id' => 'validationform'])}
        {if !empty($edit_data.category_id)}
            {form_hidden('category_id', $edit_data.category_id)}
            {create_input_token($csrf)}
        {/if}
        <div class="row">
            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-8">
                                <h5 class="mb-0 mt-1 ml-1"><i class="fas {if !empty($edit_data.category_id)}fa-edit{else}fa-plus{/if} mr-2"></i>{$text_form}</h5>
                            </div>
                            <div class="col-4 text-right">
                                <button type="submit" class="btn btn-sm btn-space btn-primary mb-0"  data-toggle="tooltip" data-placement="top" title="" data-original-title="{$text_submit}"><i class="fas fa-save"></i></button>
                                <a href="{$button_cancel}" class="btn btn-sm btn-space btn-secondary mb-0"  data-toggle="tooltip" data-placement="top" title="" data-original-title="{$text_cancel}"><i class="fas fa-reply"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        {if !empty($errors)}
                            {include file=get_theme_path('views/inc/alert.tpl') message=$errors type='danger'}
                        {/if}
                        <div class="tab-regular">
                            {if count($list_lang) > 1}
                                <ul class="nav nav-tabs border-bottom" id="myTab" role="tablist">
                                    {foreach $list_lang as $language}
                                        <li class="nav-item">
                                            <a class="nav-link p-2 pl-3 pr-3 {if $language.active}active{/if}" id="language-tab-{$language.id}" data-toggle="tab" href="#lanuage-{$language.id}" role="tab" aria-controls="lanuage-{$language.id}" aria-selected="{if $language.active}true{else}false{/if}">{$language.icon}{$language.name}</a>
                                        </li>
                                    {/foreach}
                                </ul>
                            {/if}
                            <div class="tab-content border-0 p-3" id="myTabContent">
                                {foreach $list_lang as $language}
                                    <div class="tab-pane fade {if $language.active}show active{/if}" role="tabpanel" id="lanuage-{$language.id}"  aria-labelledby="language-tab-{$language.id}">
                                        <div class="form-group row required has-error">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                                {lang('text_title')}
                                            </label>
                                            <div class="col-12 col-sm-8 col-lg-8">
                                                <input type="text" name="article_category_description[{$language.id}][title]" value='{set_value("article_category_description[`$language.id`][title]", $edit_data.details[$language.id].title)}' id="input-title[{$language.id}]" data-slug-id="input-slug-{$language.id}" class="form-control {if !empty(form_error("article_category_description[`$language.id`][title]"))}is-invalid{/if} {if empty($edit_data.category_id)}make_slug{/if}">
                                                {if !empty(form_error("article_category_description[`$language.id`][title]"))}
                                                    <div class="invalid-feedback">{form_error("article_category_description[`$language.id`][title]")}</div>
                                                {/if}
                                            </div>
                                        </div>
                                        <div class="form-group row required">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                                {lang('text_slug')}
                                            </label>
                                            <div class="col-12 col-sm-8 col-lg-8">
                                                <input type="text" name="article_category_description[{$language.id}][slug]" value='{set_value("article_category_description[`$language.id`][slug]", $edit_data.details[$language.id].slug)}' id="input-slug-{$language.id}" class="form-control {if !empty($errors["slug_`$language.id`"])}is-invalid{/if}">
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
                                                <textarea name="article_category_description[{$language.id}][description]" cols="40" rows="5" id="input-description[{$language.id}]" type="textarea" class="form-control">{set_value("article_category_description[`$language.id`][description]", $edit_data.details[$language.id].description)}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                                {lang("text_seo_title")}
                                            </label>
                                            <div class="col-12 col-sm-8 col-lg-8">
                                                <input type="text" name="article_category_description[{$language.id}][meta_title]" value='{set_value("article_category_description[`$language.id`][meta_title]", $edit_data.details[$language.id].meta_title)}' id="input-meta-title[{$language.id}]" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                                {lang("text_seo_description")}
                                            </label>
                                            <div class="col-12 col-sm-8 col-lg-8">
                                                <textarea name="article_category_description[{$language.id}][meta_description]" cols="40" rows="5" id="input-meta-description[{$language.id}]" type="textarea" class="form-control">{set_value("article_category_description[`$language.id`][meta_description]", $edit_data.details[$language.id].meta_description)}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                                {lang("text_seo_keyword")}
                                            </label>
                                            <div class="col-12 col-sm-8 col-lg-8">
                                                <input type="text" name="article_category_description[{$language.id}][meta_keyword]" value='{set_value("article_category_description[`$language.id`][meta_keyword]", $edit_data.details[$language.id].meta_keyword)}' id="input-meta-keyword[{$language.id}]" class="form-control">
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
                                <input type="checkbox" name="published" value="{STATUS_ON}" {if $edit_data.published}checked="checked"{/if} id="published">
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
                            <input type="number" name="sort_order" value="{set_value('sort_order', $edit_data.sort_order)}" id="sort_order" min="0" class="form-control">
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
            </div>
        </div>
    {form_close()}
</div>
