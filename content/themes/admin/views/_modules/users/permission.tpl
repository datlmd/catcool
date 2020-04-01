{assign var="class_colum_label" value="col-12 col-sm-3 col-form-label text-sm-right"}
{assign var="class_colum_input" value="col-12 col-sm-8 col-lg-6"}
{form_hidden('manage_url', $manage_url)}
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
                    {if !empty(validation_errors())}
                        <ul class="text-danger">{validation_errors('<li>', '</li>')}</ul>
                    {/if}
                    {form_open(uri_string(), ['id' => 'edit_validationform'])}
                        <div class="form-group row">
                            {lang('text_username', 'text_username', ['class' => $class_colum_label])}
                            <div class="{$class_colum_input}">
                                <label>{$item_edit.username}</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('text_permission', 'text_permission', ['class' => $class_colum_label])}
                            <div class="{$class_colum_input}">
                                {if !empty($permissions)}
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" name="cb_permission_all" id="cb_permission_all" value="all" class="custom-control-input">
                                        <span class="custom-control-label">{lang('text_select_all')}</span>
                                    </label>
                                    <div id="list_permission" class="list_checkbox">
                                        {foreach $permissions as $permission}
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" name="permissions[]" id="permission_{$permission.id}" value="{$permission.id}" {if in_array($permission.id, array_column($user_permissions, 'foreign_key'))}checked="checked"{/if} class="custom-control-input">
                                                <span class="custom-control-label">{$permission.name}</span>
                                            </label>
                                        {/foreach}
                                    </div>
                                {/if}
                            </div>
                        </div>
                        <div class="form-group row text-center">
                            <div class="col col-sm-10 col-lg-9 offset-sm-1 offset-lg-0">
                                {form_hidden('id', $item_edit.id)}
                                {create_input_token($csrf)}
                                <button type="submit" class="btn btn-sm btn-space btn-primary"><i class="fas fa-save mr-2"></i>{lang('button_save')}</button>
                                {anchor("`$manage_url`", '<i class="fas fa-reply mr-1"></i>'|cat:lang('button_cancel'), ['class' => 'btn btn-sm btn-space btn-secondary'])}
                            </div>
                        </div>
                    {form_close()}
                </div>
            </div>
        </div>
    </div>
</div>