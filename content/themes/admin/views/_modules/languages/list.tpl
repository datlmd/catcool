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
							<span id="delete_multiple" class="btn btn-sm btn-danger" style="display: none;" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_delete')}"><i class="fas fa-trash-alt"></i></span>
							<a href="{$manage_url}/add{http_get_query()}" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_add')}"><i class="fas fa-plus"></i></a>
						</div>
					</div>
				</div>
				<div class="card-body">
					{if !empty($list)}
						<table class="table table-striped table-hover table-bordered second">
							<thead>
								<tr class="text-center">
									<th width="50">{lang('column_id')}</th>
									<th>{lang('column_name')}</th>
									<th>{lang('column_code')}</th>
									<th>{lang('column_icon')}</th>
									<th>{lang('column_published')}</th>
									<th width="160">{lang('column_function')}</th>
									<th width="50">{form_checkbox('manage_check_all')}</th>
								</tr>
							</thead>
							<tbody>
							{foreach $list as $item}
								<tr>
									<td class="text-center">{$item.id}</td>
									<td>{anchor("$manage_url/edit/`$item.id`", htmlspecialchars($item.name, ENT_QUOTES,'UTF-8'), 'class="text-primary"')}</td>
									<td>{htmlspecialchars($item.code, ENT_QUOTES,'UTF-8')}</td>
									<td class="text-center">{if !empty($item.icon)}<i class="{$item.icon}"></i>{/if}</td>
									<td>
										<div class="switch-button switch-button-xs catcool-center">
											{form_checkbox("published_`$item.id`", ($item.published eq STATUS_ON) ? true : false, ($item.published eq STATUS_ON) ? true : false, ['id' => 'published_'|cat:$item.id, 'data-id' => $item.id, 'data-published' => $item.published, 'class' => 'change_publish'])}
											<span><label for="published_{$item.id}"></label></span>
										</div>
									</td>
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
