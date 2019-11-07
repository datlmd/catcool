{form_hidden('manage', $manage_name)}
<div class="container-fluid  dashboard-content">
	{include file=get_theme_path('views/inc/breadcrumb.inc.tpl')}
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
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-striped table-hover table-bordered second">
							<thead>
								<tr class="text-center">
									<th width="50">{lang('column_id')}</th>
									<th>{lang('column_title')}</th>
									<th>{lang('column_slug')}</th>
									<th>{lang('column_sort_order')}</th>
									<th>Admin</th>
									<th>{lang('column_published')}</th>
									<th width="160">{lang('column_function')}</th>
									<th width="50">{form_checkbox('manage_check_all')}</th>
								</tr>
							</thead>
							<tbody>
							{form_open(uri_string(), ['id' => 'filter_validationform', 'method' => 'get'])}
								<tr>
									<td>{form_input('filter[id]', $this->input->get('filter[id]'), ['class' => 'form-control', 'placeholder' => lang('filter_id')])}</td>
									<td>{form_input('filter[name]', $this->input->get('filter[name]'), ['class' => 'form-control', 'placeholder' => lang('filter_name')])}</td>
									<td>{form_input('filter[slug]', $this->input->get('filter[slug]'), ['class' => 'form-control', 'placeholder' => lang('filter_slug')])}</td>
									<td>{form_input('filter[sort_order]', $this->input->get('filter[sort_order]'), ['class' => 'form-control', 'placeholder' => lang('filter_sort_order')])}</td>
									<td>
										<select name="filter[is_admin]" class="form-control form-control-sm">
											<option value="">{lang('text_select')}</option>
											<option value="{STATUS_ON}" {if $this->input->get('filter[is_admin]') eq STATUS_ON}selected="selected"{/if}>Yes</option>
											<option value="{STATUS_OFF}" {if $this->input->get('filter[is_admin]') eq STATUS_OFF}selected="selected"{/if}>No</option>
										</select>
									</td>
									<td>
										<select name="filter[published]" class="form-control form-control-sm">
											<option value="">{lang('text_select')}</option>
											<option value="{STATUS_ON}" {if $this->input->get('filter[published]') eq STATUS_ON}selected="selected"{/if}>On</option>
											<option value="{STATUS_OFF}" {if $this->input->get('filter[published]') eq STATUS_OFF}selected="selected"{/if}>Off</option>
										</select>
									</td>
									<td>
										<div class="input-group input-group-sm">
											<div class="input-group-prepend">
												<span class="input-group-text border-0">{lang('text_limit')}</span>
											</div>
											{form_dropdown('filter_limit', get_list_limit(), $this->input->get('filter_limit'), ['class' => 'form-control form-control-sm'])}
										</div>

									</td>
									<td><button type="submit" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="{lang('filter_submit')}" data-original-title="{lang('filter_submit')}"><i class="fas fa-search"></i></button></td>
								</tr>
							{form_close()}
							{if !empty($list)}
								{foreach $list as $item}
									{include file='./inc/list_manage.tpl' menu=$item}
								{/foreach}
							{/if}
							</tbody>
						</table>
					</div>
					{if !empty($paging.pagination_links)}
						{include file=get_theme_path('views/inc/paging.inc.tpl')}
					{/if}
                    {if empty($list)}
						{lang('data_empty')}
					{/if}
				</div>
			</div>
		</div>
	</div>
</div>
