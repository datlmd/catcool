{assign var="class_colum_label" value="col-12 col-sm-3 col-form-label required-label text-sm-right"}
{assign var="class_colum_input" value="col-12 col-sm-8 col-lg-6"}
{form_hidden('manage_url', $manage_url)}
<div class="container-fluid  dashboard-content">
    {form_open(uri_string(), ['id' => 'validationform'])}
        <div class="row">
            <div class="col-sm-7 col-12">
                {include file=get_theme_path('views/inc/breadcrumb.inc.tpl')}
            </div>
            <div class="col-sm-5 col-12 mb-2 mb-sm-0 text-right">
                <button type="submit" class="btn btn-sm btn-space btn-primary mb-0"  data-toggle="tooltip" data-placement="top" title="" data-original-title="{$text_submit}"><i class="fas fa-save"></i></button>
                <a href="{$button_cancel}" class="btn btn-sm btn-space btn-secondary mb-0"  data-toggle="tooltip" data-placement="top" title="" data-original-title="{$text_cancel}"><i class="fas fa-reply"></i></a>
            </div>
        </div>
        {if !empty($edit_data.country_id)}
            {form_hidden('id', $edit_data.country_id)}
            {create_input_token($csrf)}
        {/if}
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                {if !empty($errors)}
                    <div class="col-12">
                        {include file=get_theme_path('views/inc/alert.tpl') message=$errors type='danger'}
                    </div>
                {/if}
                <div class="card">
                    <h5 class="card-header"><i class="fas {if !empty($edit_data.country_id)}fa-edit{else}fa-plus{/if} mr-2"></i>{$text_form}</h5>
                    <div class="card-body">
                        <div class="form-group row">
                            {lang('text_name', 'text_name', ['class' => 'col-12 col-sm-3 col-form-label required-label text-sm-right'])}
                            <div class="col-12 col-sm-8 col-lg-6">
                                <input type="text" name="name" value="{set_value('name', $edit_data.name)}" id="name" class="form-control {if !empty($errors["name"])}is-invalid{/if}">
                                {if !empty($errors["name"])}
                                    <div class="invalid-feedback">{$errors["name"]}</div>
                                {/if}
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('text_iso_code_2', 'text_iso_code_2', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
                            <div class="col-12 col-sm-8 col-lg-6">
                                <input type="text" name="iso_code_2" value="{set_value('iso_code_2', $edit_data.iso_code_2)}" id="iso_code_2" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('text_iso_code_3', 'text_iso_code_3', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
                            <div class="col-12 col-sm-8 col-lg-6">
                                <input type="text" name="iso_code_3" value="{set_value('iso_code_3', $edit_data.iso_code_3)}" id="iso_code_3" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('text_address_format', 'text_address_format', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
                            <div class="col-12 col-sm-8 col-lg-6">
                                <input type="text" name="address_format" value="{set_value('address_format', $edit_data.address_format)}" id="address_format" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('text_postcode_required', 'text_postcode_required', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
                            <div class="col-12 col-sm-8 col-lg-6">
                                <div class="switch-button switch-button-xs mt-2">
                                    {if isset($edit_data.postcode_required)}
                                        <input type="checkbox" name="postcode_required" value="{STATUS_ON}" {set_checkbox('postcode_required', STATUS_ON, ($edit_data.postcode_required == STATUS_ON))} id="postcode_required">
                                    {else}
                                        <input type="checkbox" name="postcode_required" value="{STATUS_ON}" {set_checkbox('postcode_required', STATUS_ON, true)} id="postcode_required">
                                    {/if}
                                    <span><label for="postcode_required"></label></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('text_published', 'text_published', ['class' => 'col-12 col-sm-3 col-form-label text-sm-right'])}
                            <div class="col-12 col-sm-8 col-lg-6">
                                <div class="switch-button switch-button-xs mt-2">
                                    {if isset($edit_data.published)}
                                        <input type="checkbox" name="published" value="{STATUS_ON}" {set_checkbox('published', STATUS_ON, ($edit_data.published == STATUS_ON))} id="published">
                                    {else}
                                        <input type="checkbox" name="published" value="{STATUS_ON}" {set_checkbox('published', STATUS_ON, true)} id="published">
                                    {/if}
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
