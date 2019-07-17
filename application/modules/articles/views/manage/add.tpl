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
                        <div class="form-group">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                {lang('title_label')}
                                {form_input($title)}
                                {if !empty(form_error('title'))}
                                    <div class="invalid-feedback">
                                        {form_error('title')}
                                    </div>
                                {/if}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                {lang("slug_label")}
                                {form_input($slug)}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                {lang('description_label')}
                                {form_textarea($description)}
                            </div>
                        </div>
                        <div class="form-group content-heigt">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                {lang("content_label")}
                                {form_textarea($content)}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                {lang("seo_title_label")}
                                {form_input($seo_title)}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                {lang("seo_description_label")}
                                {form_textarea($seo_description)}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                {lang("seo_keyword_label")}
                                {form_input($seo_keyword)}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                <button type="submit" class="btn btn-sm btn-space btn-primary">{lang('add_submit_btn')}</button>
                                {anchor("`$manage_url``$params_current`", lang('btn_cancel'), ['class' => 'btn btn-sm btn-space btn-secondary'])}
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
                            {lang('published_lable')}
                            <div class="switch-button switch-button-xs float-right">
                                {form_checkbox($published)}
                                <span><label for="published"></label></span>
                            </div>
                        </div>
                        <div class="form-group">
                            {lang("publish_date_label")}
                            {form_input($publish_date)}
                        </div>
                        <div class="form-group">
                            {lang("is_comment_label")}
                            <div class="switch-button switch-button-xs float-right">
                                {form_checkbox($is_comment)}
                                <span><label for="is_comment"></label></span>
                            </div>
                        </div>
                        <div class="form-group">
                            {lang("images_label")}
                            {form_input($images)}
                        </div>
                        <div class="form-group">
                            {lang("categories_label")}
                            {form_input($categories)}
                        </div>
                        <div class="form-group">
                            {lang("tags_label")}
                            {form_input($tags)}
                        </div>
                        <div class="form-group">
                            {lang("author_label")}
                            {form_input($author)}
                        </div>
                        <div class="form-group">
                            {lang("source_label")}
                            {form_input($source)}
                        </div>
                        <div class="form-group">
                            {lang('precedence_label')}
                            {form_input($precedence)}
                        </div>
                        {if is_show_select_language()}
                            <div class="form-group">
                                {lang('language_label')}
                                {form_dropdown('language', get_multi_lang(), $this->_site_lang, ['id' => 'language', 'class' => 'form-control change_language'])}
                                {* css: change_language dung de load lai ddanh muc cha*}
                            </div>
                        {/if}
                    </div>
                </div>
            </div>
        </div>
    {form_close()}
</div>
