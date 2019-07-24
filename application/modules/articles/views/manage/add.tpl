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
    {form_open_multipart(uri_string(), ['id' => 'add_validationform'])}
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
                        <div class="form-group content-height">
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
                            {lang("is_comment_label")}
                            <div class="switch-button switch-button-xs float-right">
                                {form_checkbox($is_comment)}
                                <span><label for="is_comment"></label></span>
                            </div>
                        </div>
                        <div class="form-group">
                            {lang("publish_date_label")}
                            <div class="input-group date" id="show-datetime-picker" data-target-input="nearest" data-link-format="DD/MM/YYYY HH:MM"  >
                                <input type="text" name="publish_date" id="publish_date" class="form-control datetimepicker-input" data-target="#show-datetime-picker" />
                                <div class="input-group-append" data-target="#show-datetime-picker" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {lang("images_label")}
                            <!-- Drag and Drop container-->
                            <div class="drop-drap-file" data-module="article" data-is-multi="alse">
                                <input type="file" name="file" id="file" size="20" />
                                <div class="upload-area dropzone dz-clickable"  id="uploadfile">
                                    <h5 class="dz-message"">{lang('image_upload')}</h5>
                                </div>
                                <div id="image_thumb"></div>
                            </div>
                        </div>
                        {if !empty($categories)}
                            <div class="form-group">
                                {lang("categories_label")}<br />
                                {foreach $categories as $category}
                                    <label class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" name="categories[]" id="categories_{$category.id}" value="{$category.id}" class="custom-control-input">
                                        <span class="custom-control-label">{$category.title}</span>
                                    </label>
                                {/foreach}
                                <div id="add_more_data"></div>
                                <a href="#" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#addNewModal">
                                    {lang('btn_add_modal')}
                                </a>
                            </div>
                        {/if}
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
<!-- Load modal-->
{include file=$this->theme->theme_path('views/inc/category/modal_create.tpl') content='article'}
