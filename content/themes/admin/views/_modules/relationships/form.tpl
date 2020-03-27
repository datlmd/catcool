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
                            {lang('text_candidate_table', 'text_candidate_table', ['class' => $class_colum_label])}
                            <div class="{$class_colum_input}">
                                <input type="text" name="candidate_table" value="{set_value('candidate_table', $edit_data.candidate_table)}" id="candidate_table" class="form-control {if !empty($errors["candidate_table"])}is-invalid{/if}">
                                {if !empty($errors["candidate_table"])}
                                    <div class="invalid-feedback">{$errors["candidate_table"]}</div>
                                {/if}
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('text_candidate_key', 'text_candidate_key', ['class' => $class_colum_label])}
                            <div class="{$class_colum_input}">
                                <input type="text" name="candidate_key" value="{set_value('candidate_key', $edit_data.candidate_key)}" id="candidate_key" class="form-control {if !empty($errors["candidate_key"])}is-invalid{/if}">
                                {if !empty($errors["candidate_key"])}
                                    <div class="invalid-feedback">{$errors["candidate_key"]}</div>
                                {/if}
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('text_foreign_table', 'text_foreign_table', ['class' => $class_colum_label])}
                            <div class="{$class_colum_input}">
                                <input type="text" name="foreign_table" value="{set_value('foreign_table', $edit_data.foreign_table)}" id="foreign_table" class="form-control {if !empty($errors["foreign_table"])}is-invalid{/if}">
                                {if !empty($errors["foreign_table"])}
                                    <div class="invalid-feedback">{$errors["foreign_table"]}</div>
                                {/if}
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('text_foreign_key', 'text_foreign_key', ['class' => $class_colum_label])}
                            <div class="{$class_colum_input}">
                                <input type="text" name="foreign_key" value="{set_value('foreign_key', $edit_data.foreign_key)}" id="foreign_key" class="form-control {if !empty($errors["foreign_key"])}is-invalid{/if}">
                                {if !empty($errors["foreign_key"])}
                                    <div class="invalid-feedback">{$errors["foreign_key"]}</div>
                                {/if}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {form_close()}
</div>
