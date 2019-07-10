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
                    {form_open(uri_string(), 'id="edit_validationform"')}
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang('title_label')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($title)}
                                {if !empty(form_error('title'))}
                                    <div class="invalid-feedback">
                                        {form_error('title')}
                                    </div>
                                {/if}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang('slug_label')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($slug)}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang('description_label')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($description)}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang('context_label')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($context)}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang('precedence_label')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($precedence)}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang('parent_label')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_dropdown($parent_id)}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang('published_lable')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                <div class="switch-button">
                                    {form_checkbox($published)}
                                    <span><label for="published"></label></span>
                                </div>
                            </div>
                        </div>
                        {if is_show_select_language()}
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                    {lang('language_label')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    {form_dropdown('language', get_multi_lang(), $item_edit['language'], 'class="form-control change_language"')}
                                </div>
                            </div>
                        {/if}
                        <div class="form-group row text-center">
                            <div class="col col-sm-10 col-lg-9 offset-sm-1 offset-lg-0">
                                {form_hidden('id', $item_edit['id'])}
                                {form_hidden($csrf)}
                                <button type="submit" class="btn btn-sm btn-space btn-primary">{lang('edit_submit_btn')}</button>
                                {anchor("`$manage_url``$params_current`", lang('btn_cancel'), 'class="btn btn-sm btn-space btn-secondary"')}
                            </div>
                        </div>
                    {form_close()}
                </div>
            </div>
        </div>
    </div>
</div>