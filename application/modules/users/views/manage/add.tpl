{assign var="class_colum_lable" value="col-12 col-sm-3 col-form-label text-sm-right"}
{assign var="class_colum_input" value="col-12 col-sm-8 col-lg-6"}
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
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <h5 class="card-header">{lang('add_subheading')}</h5>
                <div class="card-body">
                    {if !empty(validation_errors())}
                        <ul class="text-danger">{validation_errors('<li>', '</li>')}</ul>
                    {/if}
                    {form_open(uri_string(), ['id' => 'add_validationform'])}
                        <div class="form-group row">
                            {lang('title_label', 'title_label', ['class' => $class_colum_lable])}
                            <div class="{$class_colum_input}">
                                {form_input($title)}
                                {if !empty(form_error('title'))}
                                    <div class="invalid-feedback">
                                        {form_error('title')}
                                    </div>
                                {/if}
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('description_label', 'description_label', ['class' => $class_colum_lable])}
                            <div class="{$class_colum_input}">
                                {form_textarea($description)}
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang("username_label")}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($username)}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang("password_label")}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($password)}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang("email_label")}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($email)}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang("activation_selector_label")}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($activation_selector)}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang("activation_code_label")}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($activation_code)}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang("forgotten_password_selector_label")}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($forgotten_password_selector)}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang("forgotten_password_code_label")}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($forgotten_password_code)}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang("forgotten_password_time_label")}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($forgotten_password_time)}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang("remember_selector_label")}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($remember_selector)}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang("remember_code_label")}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($remember_code)}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang("created_on_label")}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($created_on)}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang("last_login_label")}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($last_login)}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang("active_label")}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($active)}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang("first_name_label")}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($first_name)}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang("last_name_label")}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($last_name)}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang("company_label")}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($company)}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang("phone_label")}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($phone)}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang("address_label")}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($address)}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang("dob_label")}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($dob)}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang("gender_label")}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($gender)}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang("image_label")}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($image)}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang("super_admin_label")}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($super_admin)}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang("status_label")}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($status)}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang("is_delete_label")}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($is_delete)}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang("ip_address_label")}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($ip_address)}
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('precedence_label', 'precedence_label', ['class' => $class_colum_lable])}
                            <div class="{$class_colum_input}">
                                {form_input($precedence)}
                            </div>
                        </div>
                        {if is_show_select_language()}
                            <div class="form-group row">
                                {lang('language_label', 'language', ['class' => $class_colum_lable])}
                                <div class="{$class_colum_input}">
                                    {form_dropdown('language', get_multi_lang(), $this->_site_lang, ['id' => 'language', 'class' => 'form-control'])}
                                </div>
                            </div>
                        {/if}
                        <div class="form-group row">
                            {lang('published_lable', 'published_lable', ['class' => $class_colum_lable])}
                            <div class="{$class_colum_input}">
                                <div class="switch-button switch-button-sm mt-2">
                                    {form_checkbox($published)}
                                    <span><label for="published"></label></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row text-center">
                            <div class="col col-sm-10 col-lg-9 offset-sm-1 offset-lg-0">
                                <button type="submit" class="btn btn-sm btn-space btn-primary"><i class="fas fa-plus mr-1"></i>{lang('add_submit_btn')}</button>
                                {anchor("`$manage_url``$params_current`", '<i class="fas fa-undo-alt mr-1"></i>'|cat:lang('btn_cancel'), ['class' => 'btn btn-sm btn-space btn-secondary'])}
                            </div>
                        </div>
                    {form_close()}
                </div>
            </div>
        </div>
    </div>
</div>
