{assign var="class_colum_label" value="col-12 col-sm-3 col-form-label text-sm-right"}
{assign var="class_colum_input" value="col-12 col-sm-8 col-lg-6"}
{form_hidden('manage', $manage_name)}
<div class="container-fluid  dashboard-content">
    {include file=get_theme_path('views/inc/breadcrumb.inc.tpl')}
    {form_open(uri_string(), ['id' => 'validationform'])}
        {if !empty($edit_data.id)}
            {form_hidden('id', $edit_data.id)}
            {create_input_token($csrf)}
        {/if}
        <div class="row">
            {if !empty($errors)}
                <div class="col-12">
                    {include file=get_theme_path('views/inc/alert.tpl') message=$errors type='danger'}
                </div>
            {/if}
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-8">
                                <h5 class="mb-0 mt-1 ml-1"><i class="fas {if !empty($edit_data.id)}fa-edit{else}fa-plus{/if} mr-2"></i>{$text_form}</h5>
                            </div>
                            <div class="col-4 text-right">
                                <button type="submit" class="btn btn-sm btn-space btn-primary mb-0"  data-toggle="tooltip" data-placement="top" title="" data-original-title="{$text_submit}"><i class="fas fa-save"></i></button>
                                <a href="{$button_cancel}" class="btn btn-sm btn-space btn-secondary mb-0"  data-toggle="tooltip" data-placement="top" title="" data-original-title="{$text_cancel}"><i class="fas fa-reply"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            {lang('text_config_key', 'text_config_key', ['class' => $class_colum_label])}
                            <div class="{$class_colum_input}">
                                <input type="text" name="config_key" value="{set_value('config_key', $edit_data.config_key)}" id="config_key" class="form-control {if !empty($errors["config_key"])}is-invalid{/if}">
                                {if !empty($errors["config_key"])}
                                    <div class="invalid-feedback">{$errors["config_key"]}</div>
                                {/if}
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('text_config_value', 'text_config_value', ['class' => $class_colum_label])}
                            <div class="{$class_colum_input}">
                                <input type="text" name="config_value" value="{set_value('config_value', $edit_data.config_value)}" id="config_value" class="form-control {if !empty($errors["config_value"])}is-invalid{/if}">
                                {if !empty($errors["config_value"])}
                                    <div class="invalid-feedback">{$errors["config_value"]}</div>
                                {/if}
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('text_description', 'text_description', ['class' => $class_colum_label])}
                            <div class="{$class_colum_input}">
                                <textarea type="textarea" name="description" id="description" cols="40" rows="5" class="form-control">{set_value('description', $edit_data.description)}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('text_published', 'text_published', ['class' => $class_colum_label])}
                            <div class="{$class_colum_input}">
                                <div class="switch-button switch-button-xs mt-2">
                                    <input type="checkbox" name="published" value="{STATUS_ON}" {if $edit_data.id}{if $edit_data.published eq true}checked="checked"{/if}{else}checked="checked"{/if} id="published">
                                    <span><label for="published"></label></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {form_close()}
</div>
