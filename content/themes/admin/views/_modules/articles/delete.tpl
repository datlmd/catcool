{form_hidden('manage', $manage_name)}
<div class="container-fluid  dashboard-content">
    {include file=get_theme_path('views/inc/breadcrumb.inc.tpl')}
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <h5 class="card-header"><i class="far fa-trash-alt mr-2"></i>{lang('delete_confirm')}</h5>
                <div class="card-body">
                    {form_open(uri_string(), ['id' => 'delete_validationform'])}
                        {if !empty($list_delete)}
                            <ul class="list-unstyled bullet-check font-14">
                                {foreach $list_delete as $item}
                                    <li class="text-danger">{$item.title}</li>
                                {/foreach}
                            </ul>
                        {/if}
                        <div class="form-group row text-center">
                            <div class="col col-sm-10 col-lg-9 offset-sm-1 offset-lg-0">
                                {form_hidden('ids', $ids)}
                                {form_hidden('is_delete', true)}
                                {create_input_token($csrf)}
                                <button type="submit" class="btn btn-sm btn-space btn-danger"><i class="far fa-trash-alt mr-2"></i>{lang('delete_submit_btn')}</button>
                                {anchor("`$manage_url`", lang('delete_submit_ng'), ['class' => 'btn btn-sm btn-space btn-light'])}
                            </div>
                        </div>
                    {form_close()}
                </div>
            </div>
        </div>
    </div>
</div>
