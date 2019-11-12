{form_hidden('manage', $manage_name)}
<div class="container-fluid  dashboard-content">
    {include file=get_theme_path('views/inc/breadcrumb.inc.tpl')}
    {form_open(uri_string(), ['id' => 'validationform'])}
        {if !empty($edit_data.menu_id)}
            {form_hidden('menu_id', $edit_data.menu_id)}
            {create_input_token($csrf)}
        {/if}
        <div class="row">
            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-8">
                                <h5 class="mb-0 mt-1 ml-1"><i class="fas {if !empty($edit_data.menu_id)}fa-edit{else}fa-plus{/if} mr-2"></i>{$text_form}</h5>
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
                                            <label class="col-12 col-sm-2 col-form-label text-sm-right">
                                                {lang('text_title')}
                                            </label>
                                            <div class="col-12 col-sm-8 col-lg-8">
                                                <input type="text" name="manager_description[{$language.id}][name]" value='{set_value("manager_description[`$language.id`][name]", $edit_data.details[$language.id].name)}' id="input-name[{$language.id}]" data-slug-id="input-slug-{$language.id}" class="form-control {if !empty(form_error("manager_description[`$language.id`][name]"))}is-invalid{/if}">
                                                {if !empty(form_error("manager_description[`$language.id`][name]"))}
                                                    <div class="invalid-feedback">{form_error("manager_description[`$language.id`][name]")}</div>
                                                {/if}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-2 col-form-label text-sm-right">
                                                {lang('text_description')}
                                            </label>
                                            <div class="col-12 col-sm-8 col-lg-8">
                                                <textarea name="manager_description[{$language.id}][description]" cols="40" rows="5" id="input-description[{$language.id}]" type="textarea" class="form-control">{set_value("manager_description[`$language.id`][description]", $edit_data.details[$language.id].description)}</textarea>
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
                                <input type="checkbox" name="published" value="{STATUS_ON}" {if $edit_data.menu_id}{if $edit_data.published eq true}checked="checked"{/if}{else}checked="checked"{/if} id="published">
                                <span><label for="published"></label></span>
                            </div>
                        </div>
                        <div class="form-group">
                            {lang('text_hidden')}
                            <div class="switch-button switch-button-xs float-right mt-1">
                                <input type="checkbox" name="hidden" value="{STATUS_ON}" {if $edit_data.menu_id}{if $edit_data.hidden eq true}checked="checked"{/if}{else}checked="checked"{/if} id="hidden">
                                <span><label for="hidden"></label></span>
                            </div>
                        </div>
                        <div class="form-group">
                            {lang('text_is_admin')}
                            <div class="switch-button switch-button-xs float-right mt-1">
                                <input type="checkbox" name="is_admin" value="{STATUS_ON}" {if $edit_data.menu_id}{if $edit_data.is_admin eq true}checked="checked"{/if}{else}checked="checked"{/if} id="is_admin">
                                <span><label for="is_admin"></label></span>
                            </div>
                        </div>
                        <div class="form-group">
                            {lang('text_slug')}
                            <input type="text" name="slug" value="{set_value('slug', $edit_data.slug)}" id="slug" class="form-control {if !empty($errors["slug"])}is-invalid{/if}">
                            {if !empty($errors["slug"])}
                                <div class="invalid-feedback">{$errors["slug"]}</div>
                            {/if}
                        </div>
                        <div class="form-group">
                            {lang('text_attributes')}
                            <input type="text" name="attributes" value="{set_value('attributes', $edit_data.attributes)}" id="attributes" class="form-control">
                        </div>
                        <div class="form-group">
                            {lang('text_selected')}
                            <input type="text" name="selected" value="{set_value('selected', $edit_data.selected)}" id="selected" class="form-control">
                        </div>
                        <div class="form-group">
                            {lang('text_nav_key')}
                            <input type="text" name="nav_key" value="{set_value('nav_key', $edit_data.nav_key)}" id="nav_key" class="form-control">
                        </div>
                        <div class="form-group">
                            {lang('text_label')}
                            <input type="text" name="label" value="{set_value('label', $edit_data.label)}" id="label" class="form-control">
                        </div>
                        <div class="form-group">
                            {lang('text_icon')}
                            <input type="text" name="icon" value="{set_value('icon', $edit_data.icon)}" id="icon" class="form-control">
                        </div>
                        <div class="form-group">
                            {lang('text_context')}
                            <input type="text" name="context" value="{set_value('context', $edit_data.context)}" id="context" class="form-control">
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
                                {draw_tree_output_name(['data' => $list_patent, 'key_id' => 'menu_id', 'id_root' => $edit_data.menu_id], $output_html, 0, $edit_data.parent_id)}
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {form_close()}
</div>
