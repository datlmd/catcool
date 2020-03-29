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
						<div class="col-xl-8 col-lg-8 col-md-8 col-sm-6 col-12 mb-2">
                            {lang('filter_name')}
                            {form_input('filter[name]', $this->input->get('filter[name]'), ['class' => 'form-control form-control-sm', 'placeholder' => lang('filter_name')])}
						</div>
						<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
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
							<span id="delete_multiple" class="btn btn-sm btn-danger" style="display: none;" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_delete')}"><i class="fas fa-trash-alt"></i></span>
							<a href="{$manage_url}/add{http_get_query()}" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_add')}"><i class="fas fa-plus"></i></a>
							<button type="button" id="btn_search" class="btn btn-sm btn-light" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('filter_header')}" data-target="#filter_manage"><i class="fas fa-filter"></i></button>
						</div>
					</div>
				</div>
				<div class="card-body">
					{if !empty($list)}
						<table class="table table-striped table-hover table-bordered second">
							<thead>
								<tr class="text-center">
									<th width="50">{lang('column_id')}</th>
									<th>{lang('text_candidate_table')}</th>
									<th>{lang('text_candidate_key')}</th>
									<th>{lang('text_foreign_table')}</th>
									<th>{lang('text_foreign_key')}</th>
									<th width="160">{lang('column_function')}</th>
									<th width="50">{form_checkbox('manage_check_all')}</th>
								</tr>
							</thead>
							<tbody>
							{foreach $list as $item}
								<tr>
									<td class="text-center">{$item.id}</td>
									<td class="text-center">{anchor("$manage_url/edit/`$item.id`", htmlspecialchars($item.candidate_table, ENT_QUOTES,'UTF-8'), 'class="text-primary"')}</td>
									<td class="text-center">{$item.candidate_key}</td>
									<td class="text-center">{$item.foreign_table}</td>
									<td class="text-center">{$item.foreign_key}</td>
									<td class="text-center">
										<div class="btn-group ml-auto">
											<a href="{$manage_url}/edit/{$item.id}" class="btn btn-sm btn-outline-light" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_edit')}"><i class="fas fa-edit"></i></a>
											<button type="button" data-id="{$item.id}" class="btn btn-sm btn-outline-light btn_delete_single" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_delete')}"><i class="fas fa-trash-alt"></i></button>
										</div>
									</td>
									<td class="text-center">{form_checkbox('manage_ids[]', $item.id)}</td>
								</tr>
							{/foreach}
							</tbody>
						</table>
						{include file=get_theme_path('views/inc/paging.inc.tpl')}
					{else}
						{lang('text_no_results')}
					{/if}
				</div>
			</div>
		</div>
	</div>
</div>
