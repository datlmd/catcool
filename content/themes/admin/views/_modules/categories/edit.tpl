<div class="container-fluid  dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">{lang('add_heading')}</h2>
                <p class="pageheader-text">{lang('add_subheading')}</p>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">{lang('list_heading')}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{lang('add_heading')}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    {print_flash_alert()}
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <h5 class="card-header">{lang('add_subheading')}</h5>
                <div class="card-body">
                    {form_open(uri_string(), 'id="edit_validationform" data-parsley-validate="" novalidate=""')}
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang('title_label')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($title, '', 'required="" placeholder="Type something" class="form-control"')}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang('slug_label')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($slug, '', 'required="" placeholder="" class="form-control"')}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang('description_label')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($description, '', 'required="" placeholder="Type something" class="form-control"')}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang('context_label')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($context, '', 'required="" placeholder="Type something" class="form-control"')}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang('precedence_label')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($precedence, '', 'required="" placeholder="Type something" class="form-control"')}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang('parent_label')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($parent_id, '', 'required="" placeholder="Type something" class="form-control"')}
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
                                    {form_dropdown('language', get_multi_lang(), $item_edit['language'], 'class="btn btn-primary btn-lg"')}
                                </div>
                            </div>
                        {/if}
                        <div class="form-group row text-center">
                            <div class="col col-sm-10 col-lg-9 offset-sm-1 offset-lg-0">
                                {form_hidden('id', $item_edit['id'])}
                                {form_hidden($csrf)}
                                <button type="submit" class="btn btn-space btn-primary">{lang('add_submit_btn')}</button>
                                <button type="reset" class="btn btn-space btn-secondary">Cancel</button>
                            </div>
                        </div>
                    {form_close()}
                </div>
            </div>
        </div>
    </div>
</div>