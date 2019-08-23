{assign var="class_colum_lable" value="col-12 col-sm-3 col-form-label text-sm-right"}
{assign var="class_colum_input" value="col-12 col-sm-8 col-lg-6"}
{form_hidden('manage', $manage_name)}
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
                            {lang('module_label', 'module_label', ['class' => $class_colum_lable])}
                            <div class="{$class_colum_input}">
                                {form_input($module)}
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('sub_module_label', 'sub_module_label', ['class' => $class_colum_lable])}
                            <div class="{$class_colum_input}">
                                {form_textarea($sub_module)}
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('published_lable', 'published_lable', ['class' => $class_colum_lable])}
                            <div class="{$class_colum_input}">
                                <div class="switch-button switch-button-sm mt-2">
                                    {form_checkbox($published)}
                                    <span><label for="published"></label></span>
                                </div>
                                {if !$item_edit.published}
                                    <div class="form-group text-secondary">{lang('msg_not_active')}</div>
                                {/if}
                            </div>
                        </div>
                        <div class="form-group row text-center">
                            <div class="col col-sm-10 col-lg-9 offset-sm-1 offset-lg-0">
                                {form_hidden('id', $item_edit.id)}
                                {form_hidden($csrf)}
                                <button type="submit" class="btn btn-sm btn-space btn-primary"><i class="fas fa-save mr-2"></i>{lang('edit_submit_btn')}</button>
                                {anchor("`$manage_url``$params_current`", '<i class="fas fa-undo-alt mr-1"></i>'|cat:lang('btn_cancel'), ['class' => 'btn btn-sm btn-space btn-secondary'])}
                            </div>
                        </div>
                    {form_close()}
                </div>
            </div>
        </div>
    </div>
</div>