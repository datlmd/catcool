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
                                {lang('description_label')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_textarea($description)}
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang("slug_label")}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($slug)}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang("content_label")}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($content)}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang("seo_title_label")}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($seo_title)}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang("seo_description_label")}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($seo_description)}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang("seo_keyword_label")}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($seo_keyword)}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang("publish_date_label")}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($publish_date)}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang("is_comment_label")}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($is_comment)}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang("images_label")}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($images)}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang("categories_label")}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($categories)}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang("tags_label")}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($tags)}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang("author_label")}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($author)}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang("source_label")}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($source)}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang("user_ip_label")}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($user_ip)}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang("counter_view_label")}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($counter_view)}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang("counter_comment_label")}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($counter_comment)}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang("counter_like_label")}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($counter_like)}
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
                                {lang('precedence_label')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($precedence)}
                            </div>
                        </div>
                        {if is_show_select_language()}
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                    {lang('language_label')}
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    {form_dropdown('language', get_multi_lang(), $item_edit.language, ['class' => 'form-control'])}
                                </div>
                            </div>
                        {/if}
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang('published_lable')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                <div class="switch-button switch-button-sm">
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
                                <button type="submit" class="btn btn-sm btn-space btn-primary">{lang('edit_submit_btn')}</button>
                                {anchor("`$manage_url``$params_current`", lang('btn_cancel'), ['class' => 'btn btn-sm btn-space btn-secondary'])}
                            </div>
                        </div>
                    {form_close()}
                </div>
            </div>
        </div>
    </div>
</div>