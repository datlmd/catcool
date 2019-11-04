{form_hidden('manage', $manage_name)}
<div class="container-fluid  dashboard-content">
    {include file=get_theme_path('views/inc/breadcrumb.inc.tpl')}
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="card">
				<div class="card-body">
					<div class="table-responsive">
						{form_open(uri_string(), ['id' => 'filter_validationform', 'method' => 'get'])}
							<table class="table border-none">
								<tr>
									<td><b>{lang('filter_header')}</b></td>
									<td class="text-right">
										{form_input('filter_name', $this->input->get('filter_name'), ['class' => 'form-control', 'placeholder' => lang('filter_name')])}
									</td>
									<td class="text-right">{lang('limit_label')}</td>
									<td>
                                        {form_dropdown('filter_limit', get_list_limit(), $this->input->get('filter_limit'), ['class' => 'form-control form-control-sm'])}
									</td>
									<td class="text-right" width="100">

									</td>
								</tr>
							</table>
						{form_close()}
					</div>
					<button type="submit" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="{lang('filter_submit')}" data-original-title="{lang('filter_submit')}"><i class="fas fa-search"></i></button>
				</div>
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
							<span id="delete_multiple" class="btn btn-sm btn-danger" style="display: none;" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('btn_delete')}"><i class="far fa-trash-alt"></i></span>
							<a href="{$manage_url}/add{http_get_query()}" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('btn_add')}"><i class="fas fa-plus"></i></a>
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
										<th>{lang('column_title')}</th>
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
