<div id="view_albums">
    {form_hidden('manage', $manage_name)}
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
                        {form_open(uri_string(), ['id' => 'delete_album'])}
                            {if !empty($list_delete)}
                                <div class="row">
                                    {foreach $list_delete as $item}
                                        <div id="photo_key_{$item.id}" class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-6 mb-3">
                                            <a href="{image_url($item.image)}" data-lightbox="photos">
                                                <img src="{image_url($item.image)}" class="img-thumbnail mr-1 img-fluid">
                                            </a>
                                            {$item.title} (ID: {$item.id})
                                        </div>
                                    {/foreach}
                                </div>
                            {/if}
                            <div class="form-group row text-center">
                                <div class="col col-sm-10 col-lg-9 offset-sm-1 offset-lg-0">
                                    {form_hidden('ids', $ids)}
                                    {form_hidden('is_delete', true)}
                                    {create_input_token($csrf)}
                                    <button type="submit" class="btn btn-sm btn-space btn-danger">{lang('delete_submit_btn')}</button>
                                    <button type="button" onclick="Photo.loadView('{get_last_url($manage_url)}');" class="btn btn-sm btn-space btn-light">{lang('delete_submit_ng')}</button>
                                </div>
                            </div>
                        {form_close()}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>