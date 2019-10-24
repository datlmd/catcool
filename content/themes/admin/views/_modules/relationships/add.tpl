{assign var="class_colum_label" value="col-12 col-sm-3 col-form-label text-sm-right"}
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
                            {lang('candidate_table_label', 'candidate_table_label', ['class' => $class_colum_label])}
                            <div class="{$class_colum_input}">
                                {form_input($candidate_table)}
                                {if !empty(form_error('candidate_table'))}
                                    <div class="invalid-feedback">
                                        {form_error('candidate_table')}
                                    </div>
                                {/if}
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('candidate_key_label', 'candidate_key_label', ['class' => $class_colum_label])}
                            <div class="{$class_colum_input}">
                                {form_input($candidate_key)}
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('foreign_table_label', 'foreign_table_label', ['class' => $class_colum_label])}
                            <div class="{$class_colum_input}">
                                {form_input($foreign_table)}
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('foreign_key_label', 'foreign_key_label', ['class' => $class_colum_label])}
                            <div class="{$class_colum_input}">
                                {form_input($foreign_key)}
                            </div>
                        </div>
                        <div class="form-group row text-center">
                            <div class="col col-sm-10 col-lg-9 offset-sm-1 offset-lg-0">
                                <button type="submit" class="btn btn-sm btn-space btn-primary"><i class="fas fa-plus mr-1"></i>{lang('add_submit_btn')}</button>
                                {anchor("`$manage_url`", '<i class="fas fa-reply mr-1"></i>'|cat:lang('btn_cancel'), ['class' => 'btn btn-sm btn-space btn-secondary'])}
                            </div>
                        </div>
                    {form_close()}
                </div>
            </div>
        </div>
    </div>
</div>
