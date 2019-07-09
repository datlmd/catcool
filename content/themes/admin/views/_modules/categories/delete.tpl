<div class="container-fluid  dashboard-content">
    <div class="row">
        {*{include file='breadcrumb.tpl'}*}
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">{lang('delete_heading')}</h2>
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
                <h5 class="card-header">{lang('delete_confirm')}</h5>
                <div class="card-body">
                    {form_hidden('manage', 'categories')}
                    {form_open(uri_string(), 'id="delete_validationform"')}
                        {if !empty($list_delete)}
                            <ul>
                            {foreach $list_delete as $item}
                                <li>{$item.title}</li>
                            {/foreach}
                                </ul>
                        {/if}
                        <div class="form-group row text-center">
                            <div class="col col-sm-10 col-lg-9 offset-sm-1 offset-lg-0">
                                {form_hidden('ids', $ids)}
                                {form_hidden($csrf)}
                                <button type="submit" class="btn btn-space btn-primary">{lang('edit_submit_btn')}</button>
                                {anchor('categories/manage', lang('delete_submit_ng'), 'class="btn btn-space btn-secondary"')}
                            </div>
                        </div>
                    {form_close()}
                </div>
            </div>
        </div>
    </div>
</div>