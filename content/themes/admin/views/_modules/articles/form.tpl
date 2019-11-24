{form_hidden('manage', $manage_name)}
<div class="container-fluid  dashboard-content">
    {include file=get_theme_path('views/inc/breadcrumb.inc.tpl')}
    {form_open(uri_string(), ['id' => 'validationform'])}
        {if !empty($edit_data.article_id)}
            {form_hidden('article_id', $edit_data.article_id)}
            {create_input_token($csrf)}
        {/if}
        <div class="row">
            <div class="col-xl-9 col-lg-9 col-md-8 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-8">
                                <h5 class="mb-0 mt-1 ml-1"><i class="fas {if !empty($edit_data.article_id)}fa-edit{else}fa-plus{/if} mr-2"></i>{$text_form}</h5>
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
                                        <div class="form-group row">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                {lang('text_name')}
                                                <input type="text" name="manager_description[{$language.id}][name]" value='{set_value("manager_description[`$language.id`][name]", $edit_data.details[$language.id].name)}' id="input-name[{$language.id}]" data-slug-id="input-slug-{$language.id}" class="form-control {if !empty(form_error("manager_description[`$language.id`][name]"))}is-invalid{/if} {if empty($edit_data.article_id)}make_slug{/if}">
                                                {if !empty(form_error("manager_description[`$language.id`][name]"))}
                                                    <div class="invalid-feedback">{form_error("manager_description[`$language.id`][name]")}</div>
                                                {/if}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                {lang('text_slug')}
                                                <input type="text" name="manager_description[{$language.id}][slug]" value='{set_value("manager_description[`$language.id`][slug]", $edit_data.details[$language.id].slug)}' id="input-slug-{$language.id}" class="form-control {if !empty($errors["slug_`$language.id`"])}is-invalid{/if}">
                                                {if !empty($errors["slug_`$language.id`"])}
                                                    <div class="invalid-feedback">{$errors["slug_`$language.id`"]}</div>
                                                {/if}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                {lang('text_description')}
                                                <textarea name="manager_description[{$language.id}][description]" cols="40" rows="5" id="input-description[{$language.id}]" type="textarea" class="form-control">{set_value("manager_description[`$language.id`][description]", $edit_data.details[$language.id].description)}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                {lang('text_content')}
                                                <textarea name="manager_description[{$language.id}][content]" cols="40" rows="5" data-toggle="tinymce" id="input-content[{$language.id}]" type="textarea" class="form-control">{set_value("manager_description[`$language.id`][content]", $edit_data.details[$language.id].content)}</textarea>
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
                                                {lang("text_seo_description")}
                                                <textarea name="manager_description[{$language.id}][meta_description]" cols="40" rows="5" id="input-meta-description[{$language.id}]" type="textarea" class="form-control">{set_value("manager_description[`$language.id`][meta_description]", $edit_data.details[$language.id].meta_description)}</textarea>
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

                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">{lang('text_manage_more')}</h5>
                    <div class="card-body">
                        <div class="form-group">
                            {lang('text_published')}
                            <div class="switch-button switch-button-xs float-right mt-1">
                                <input type="checkbox" name="published" value="{STATUS_ON}" {if $edit_data.article_id}{if $edit_data.published eq true}checked="checked"{/if}{else}checked="checked"{/if} id="published">
                                <span><label for="published"></label></span>
                            </div>
                        </div>
                        <div class="form-group">
                            {lang('text_is_comment')}
                            <div class="switch-button switch-button-xs float-right mt-1">
                                <input type="checkbox" name="is_comment" value="{STATUS_ON}" {if $edit_data.article_id}{if $edit_data.is_comment eq true}checked="checked"{/if}{else}checked="checked"{/if} id="is_comment">
                                <span><label for="is_comment"></label></span>
                            </div>
                        </div>
                        <div class="form-group">
                            {lang('text_publish_date')}
                            <div class="input-group date" id="show-datetime-picker" data-target-input="nearest" data-link-format="DD/MM/YYYY HH:MM"  >
                                <input type="text" name="publish_date" id="publish_date" class="form-control datetimepicker-input" value="{$edit_data.publish_date|date_format:'d/m/Y H:i'}" data-target="#show-datetime-picker" />
                                <div class="input-group-append" data-target="#show-datetime-picker" data-toggle="datetimepicker">
                                    <button type="button" class="bg-primary"><i class="fas fa-calendar-alt"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {lang('text_image')}
                            <a href="javascript:void(0);" id="thumb-image" data-target="input-image-path" data-thumb="load-thumb-image" data-toggle="image">
                                <img src="{if !empty($edit_data.images)}{image_thumb_url($edit_data.images)}{else}{site_url(UPLOAD_IMAGE_DEFAULT)}{/if}" class="img-thumbnail w-100 mr-1 img-fluid" alt="" title="" id="load-thumb-image" data-placeholder="{site_url(UPLOAD_IMAGE_DEFAULT)}"/>
                                <button type="button" id="button-image" class="btn btn-xs btn-primary w-100 mt-1"><i class="fas fa-pencil-alt mr-1"></i>{lang('text_photo_edit')}</button>
                                <button type="button" id="button-clear" class="btn btn-xs btn-danger w-100 mt-1 mb-1"><i class="fas fa-trash mr-1"></i>{lang('text_photo_clear')}</button>
                            </a>
                            <input type="hidden" name="image" value="{$edit_data.images}" id="input-image-path" />
                        </div>
                        <div class="form-group">
                            {lang('text_category')}
                            {$output_html = '<option ##SELECTED## value="##VALUE##">##INDENT_SYMBOL####NAME##</option>'}
                            <select name="category_ids[]" id="category_ids[]" class="selectpicker form-control form-control-sm" data-style="btn-primary" data-size="8" title="{lang('text_select')}" multiple data-actions-box="false" data-live-search="true" data-selected-text-format="count > 2">
                                {draw_tree_output_name(['data' => $categories, 'key_id' => 'category_id'], $output_html, 0, $edit_data.categories)}
                            </select>
                            <div id="category_review" class="w-100 p-2 bg-light">
                                <ul class="list-unstyled bullet-check mb-0">
                                    {if $edit_data.article_id && !empty($edit_data.categories)}
                                        {foreach $edit_data.categories as $value_cate}
                                            <li>{$categories[$value_cate].name}</li>
                                        {/foreach}
                                    {/if}
                                </ul>
                            </div>
                        </div>
                        <div class="form-group">
                            {lang('text_tags')}
                            <input type="text" name="tags" value="{set_value('tags', $edit_data.tags)}" id="tags" class="form-control" data-role="tagsinput">
                        </div>
                        <div class="form-group">
                            {lang('text_author')}
                            <input type="text" name="author" value="{set_value('author', $edit_data.author)}" id="author" class="form-control">
                        </div>
                        <div class="form-group">
                            {lang('text_source')}
                            <input type="text" name="source" value="{set_value('source', $edit_data.source)}" id="source" class="form-control">
                        </div>
                        <div class="form-group">
                            {lang('text_sort_order')}
                            <input type="number" name="sort_order" value="{if $edit_data.article_id}{set_value('sort_order', $edit_data.sort_order)}{else}0{/if}" id="sort_order" min="0" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {form_close()}
</div>
