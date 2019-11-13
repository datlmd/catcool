{form_hidden('manage', $manage_name)}
<div class="container-fluid  dashboard-content">
    {include file=get_theme_path('views/inc/breadcrumb.inc.tpl')}
	<div class="row collapse {if $filter_active}show{/if}" id="filter_manage">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="card">
				{form_open(uri_string(), ['id' => 'filter_validationform', 'method' => 'get'])}
				<div class="card-header">
					<div class="row">
						<div class="col-6">
							<h5 class="mb-0 mt-1 ml-2"><i class="fas fa-filter mr-2"></i>{lang('filter_header')}</h5>
						</div>
						<div class="col-6 text-right">
							<button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-search mr-1"></i>{lang('filter_submit')}</button>
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 mb-2">
							{lang('filter_name')}
							{form_input('filter[name]', $this->input->get('filter[name]'), ['class' => 'form-control form-control-sm', 'placeholder' => lang('filter_name')])}
						</div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 mb-2">
							{lang('filter_id')}
							{form_input('filter[id]', $this->input->get('filter[id]'), ['class' => 'form-control form-control-sm', 'placeholder' => lang('filter_id')])}

						</div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 mb-2">
							{lang('text_is_admin')}
							<select name="filter[is_admin]" class="form-control form-control-sm">
								<option value="">{lang('text_select')}</option>
								<option value="{STATUS_ON}" {if $this->input->get('filter[is_admin]') == STATUS_ON}selected="selected"{/if}>Yes</option>
								<option value="{STATUS_OFF}" {if $this->input->get('filter[is_admin]') != null && $this->input->get('filter[is_admin]') == STATUS_OFF}selected="selected"{/if}>No</option>
							</select>
						</div>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 mb-2">
							{lang('text_limit')}
							{form_dropdown('filter_limit', get_list_limit(), $this->input->get('filter_limit'), ['class' => 'form-control form-control-sm'])}
						</div>
					</div>
				</div>
				{form_close()}
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="card">
				<div class="card-header">
					<div class="row">
						<div class="col-8">
							<h5 class="mb-0 mt-1 ml-2"><i class="fas fa-list mr-2"></i>{lang('text_list')}</h5>
						</div>
						<div class="col-4 text-right">
							<span id="delete_multiple" class="btn btn-sm btn-danger" style="display: none;" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_delete')}"><i class="far fa-trash-alt"></i></span>
							<a href="{$manage_url}/add{http_get_query()}" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_add')}"><i class="fas fa-plus"></i></a>
							<button type="button" id="btn_search" class="btn btn-sm btn-light" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('filter_header')}" data-target="#filter_manage"><i class="fas fa-filter"></i></button>
						</div>
					</div>
				</div>
				<div class="card-body">
					{if !empty($list)}
						<div class="table-responsive">
							<table class="table table-striped table-hover table-bordered second">
								<thead>
									<tr class="text-center">
										<th width="50">{lang('column_id')}</th>
										<th>{lang('column_name')}</th>
										<th>{lang('column_description')}</th>
										<th>{lang('column_sort_order')}</th>
										<th>{lang('column_published')}</th>
										<th width="160">{lang('column_function')}</th>
										<th width="50">{form_checkbox('manage_check_all')}</th>
									</tr>
								</thead>
								<tbody>
								{foreach $list as $item}
                                    {include file=get_theme_path('views/inc/categories/list_manage.tpl') category=$item}
								{/foreach}
								</tbody>
							</table>
						</div>
                        {if !empty($paging.pagination_links)}
                            {include file=get_theme_path('views/inc/paging.inc.tpl')}
                        {/if}
					{else}
						{lang('data_empty')}
					{/if}
				</div>
			</div>
		</div>
	</div>
</div>
