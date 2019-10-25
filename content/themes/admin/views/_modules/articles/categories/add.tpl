{form_hidden('manage', $manage_name)}
<div class="container-fluid  dashboard-content">
    {include file=get_theme_path('views/inc/breadcrumb.inc.tpl')}
    {form_open(uri_string(), ['id' => 'add_validationform'])}
        <div class="row">
            <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12 col-lg-9 col-md-9 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-8">
                                <h5 class="mb-0 mt-1 ml-1"><i class="fas fa-plus mr-2"></i>{lang('add_subheading')}</h5>
                            </div>
                            <div class="col-4 text-right">
                                <button type="submit" class="btn btn-sm btn-space btn-primary mb-0"  data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('add_submit_btn')}"><i class="fas fa-save"></i></button>
                                <a href="{$manage_url}" class="btn btn-sm btn-space btn-secondary mb-0"  data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('btn_cancel')}"><i class="fas fa-reply"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="p-3">

                        <div class="tab-regular">
                            <ul class="nav nav-tabs border-bottom" id="myTab" role="tablist">
                                {foreach $list_language as $language}
                                    <li class="nav-item">
                                        <a class="nav-link p-2 pr-3 pl-3" id="language-tab-{$language.id}" data-toggle="tab" href="#lanuage-{$language.id}" role="tab" aria-controls="lanuage-{$language.id}" aria-selected="false">{$language.name}</a>
                                    </li>
                                {/foreach}
                            </ul>

                            <div class="tab-content border-0" id="myTabContent">
                                {foreach $list_language as $language}
                                <div class="tab-pane fade show" role="tabpanel" id="lanuage-{$language.id}"  aria-labelledby="language-tab-{$language.id}">
                                    {if !empty(validation_errors())}
                                        <ul class="text-danger">{validation_errors('<li>', '</li>')}</ul>
                                    {/if}
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
                                            {form_textarea($seo_description)}
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
                                    <div class="form-group row text-center">
                                        <div class="col col-sm-10 col-lg-9 offset-sm-1 offset-lg-0">
                                            <button type="submit" class="btn btn-sm btn-space btn-primary"><i class="fas fa-plus mr-1"></i>{lang('add_submit_btn')}</button>
                                            {anchor("`$manage_url`", '<i class="fas fa-reply mr-1"></i>'|cat:lang('btn_cancel'), ['class' => 'btn btn-sm btn-space btn-secondary'])}
                                        </div>
                                    </div>
                                </div>
                                {/foreach}
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
                            {lang('context_label')}
                            {form_input($context)}
                        </div>
                        <div class="form-group">
                            {lang('precedence_label')}
                            {form_input($precedence)}
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
