{form_hidden('manage', $manage_name)}
<div class="container-fluid  dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">{lang('add_heading')}</h2>
                <p class="pageheader-text">{lang('add_subheading')}</p>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        {$this->breadcrumb->render()}
                    </nav>
                </div>
            </div>
        </div>
    </div>
    {form_open(uri_string(), ['id' => 'add_validationform'])}
        <div class="row">
            <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12 col-lg-9 col-md-9 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">{lang('add_subheading')}</h5>
                    <div class="card-body">
                        {if !empty(validation_errors())}
                            <ul class="text-danger">{validation_errors('<li>', '</li>')}</ul>
                        {/if}
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang('text_title')}
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
                                {if !empty(form_error('slug'))}
                                    <div class="invalid-feedback">
                                        {form_error('slug')}
                                    </div>
                                {/if}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang('description_label')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_textarea($description)}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang('attributes_label')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($attributes)}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang('selected_label')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($selected)}
                            </div>
                        </div>
                        <div class="form-group row text-center">
                            <div class="col col-sm-10 col-lg-9 offset-sm-1 offset-lg-0">
                                <button type="submit" class="btn btn-sm btn-space btn-primary"><i class="fas fa-plus mr-1"></i>{lang('add_submit_btn')}</button>
                                {anchor("`$manage_url`", '<i class="fas fa-reply mr-1"></i>'|cat:lang('btn_cancel'), ['class' => 'btn btn-sm btn-space btn-secondary'])}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12 col-lg-3 col-md-3 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">{lang('manage_more_label')}</h5>
                    <div class="card-body">
                        <div class="form-group">
                            {lang('published_label')}
                            <div class="switch-button switch-button-xs float-right mt-1">
                                {form_checkbox($published)}
                                <span><label for="published"></label></span>
                            </div>
                        </div>
                        <div class="form-group">
                            {lang('hidden_label')}
                            <div class="switch-button switch-button-xs float-right mt-1">
                                {form_checkbox($hidden)}
                                <span><label for="hidden"></label></span>
                            </div>
                        </div>
                        <div class="form-group">
                            {lang('is_admin_label')}
                            <div class="switch-button switch-button-xs float-right mt-1">
                                {form_checkbox($is_admin)}
                                <span><label for="is_admin"></label></span>
                            </div>
                        </div>
                        <div class="form-group">
                            {lang('nav_key_label')}
                            {form_input($nav_key)}
                        </div>
                        <div class="form-group">
                            {lang('label_label')}
                            {form_input($label)}
                        </div>
                        <div class="form-group">
                            {lang('icon_label')}
                            {form_input($icon)}
                        </div>
                        <div class="form-group">
                            {lang('context_label')}
                            {form_input($context)}
                        </div>
                        <div class="form-group">
                            {lang('sort_order_label')}
                            {form_input($sort_order)}
                        </div>
                        <div class="form-group">
                            {lang('parent_label')}
                            <select name="parent_id" id="parent_id" class="form-control">
                                <option value="">{lang('select_dropdown_label')}</option>
                                {$output_html = '<option ##SELECTED## value="##VALUE##">##INDENT_SYMBOL####NAME##</option>'}
                                {$indent_symbol = '-&nbsp;-&nbsp;'}
                                {draw_tree_output($list_all, $output_html, 0, set_value('parent_id'), $indent_symbol)}
                            </select>
                        </div>
                        {if is_show_select_language()}
                            <div class="form-group">
                                {lang('language_label')}
                                {form_dropdown('language', get_list_lang(), $this->_site_lang, ['id' => 'language', 'class' => 'form-control change_language'])}
                            </div>
                        {/if}
                    </div>
                </div>
            </div>
        </div>
    {form_close()}
</div>
