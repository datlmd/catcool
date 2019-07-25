{form_hidden('manage', $manage_name)}
<div class="container-fluid  dashboard-content">
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="page-header">
				<h2 class="pageheader-title">{lang('list_heading')}</h2>
				<p class="pageheader-text"></p>
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
				<div class="card-body">
					<div class="table-responsive">
						{form_open(uri_string(), ['id' => 'filter_validationform', 'method' => 'get'])}
							<table class="table border-none">
								<tr>
									<td><b>{lang('filter_header')}</b></td>
									<td class="text-right">
										{form_input('filter_name', $this->input->get('filter_name'), ['class' => 'form-control', 'placeholder' => lang('filter_name')])}
									</td>
                                    {if is_show_select_language()}
										<td class="text-right" width="90">{lang('language_label')}</td>
										<td>
											{form_dropdown('filter_language', array_merge(['none' => lang('filter_dropdown_all')], get_multi_lang()), $this->input->get('filter_language'), 'class="form-control form-control-sm"')}
										</td>
                                    {/if}
									<td class="text-right">{lang('limit_label')}</td>
									<td>
                                        {form_dropdown('filter_limit', get_list_limit(), $this->input->get('filter_limit'), ['class' => 'form-control form-control-sm'])}
									</td>
									<td class="text-right" width="100">
										<button type="submit" class="btn btn-xs btn-primary"><i class="fas fa-search mr-1"></i>{lang('filter_submit')}</button>
									</td>
								</tr>
							</table>
						{form_close()}
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="card">
				<h5 class="card-header">{lang('list_subheading')}</h5>
				<div class="card-body">
					<div class="row">
						<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-2">
                        	{if $total_records > 0}
								{sprintf(lang('total_records'), $total_records)}
                        	{/if}
						</div>
						<div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12 mb-2 text-right">
							<span id="delete_multiple" class="btn btn-xs btn-space btn-danger" style="display: none;"><i class="far fa-trash-alt mr-2"></i>{lang('btn_delete')}</span>
                            {anchor("`$manage_url`/add`$params_current`", '<i class="fas fa-plus mr-1"></i>'|cat:lang('btn_add'), ['class' => 'btn btn-xs btn-space btn-primary'])}
						</div>
					</div>
					{if !empty($list)}
						<div class="table-responsive">
							<table class="table table-striped table-hover table-bordered second">
								<thead>
									<tr class="text-center">
										<th width="50">{lang('f_id')}</th>
										<th>{lang('f_title')}</th>
										<th>{lang('f_description')}</th>
										<th>{lang('f_precedence')}</th>
										<th>{lang('f_published')}</th>
										{if is_show_select_language()}<th>{lang('f_language')}</th>{/if}
										<th width="160">{lang('f_function')}</th>
										<th width="50">{form_checkbox('manage_check_all')}</th>
									</tr>
								</thead>
								<tbody>
								{foreach $list as $item}
									<tr>
										<td class="text-center">{$item.id}</td>
										<td>{anchor("$manage_url/edit/`$item.id``$params_current`", htmlspecialchars($item.title, ENT_QUOTES,'UTF-8'), 'class="text-primary"')}</td>
										<td>{htmlspecialchars($item.description, ENT_QUOTES,'UTF-8')}</td>
										<td class="text-center">{$item.precedence}</td>
										<td>
											<div class="switch-button switch-button-xs catcool-center">
												{form_checkbox("published_`$item.id`", ($item.published eq PUBLISH_STATUS_ON) ? true : false, ($item.published eq PUBLISH_STATUS_ON) ? true : false, ['id' => 'published_'|cat:$item.id, 'data-id' => $item.id, 'data-published' => $item.published, 'class' => 'change_publish'])}
												<span><label for="published_{$item.id}"></label></span>
											</div>
										</td>
										{if is_show_select_language()}<td class="text-center">{lang($item.language)}</td>{/if}
										<td class="text-center">
											<div class="btn-group ml-auto">
												{anchor("`$manage_url`/edit/`$item.id``$params_current`", '<i class="fas fa-edit"></i>', ['class' => 'btn btn-sm btn-outline-light', 'title' => lang('btn_edit')])}
												{anchor("`$manage_url`/delete/`$item.id``$params_current`", '<i class="far fa-trash-alt"></i>', ['class' => 'btn btn-sm btn-outline-light', 'title' => lang('btn_delete')])}
											</div>
										</td>
										<td class="text-center">{form_checkbox('manage_ids[]', $item.id)}</td>
									</tr>
								{/foreach}
								</tbody>
							</table>
						</div>
						{if !empty($pagination_links)}
							<p><nav aria-label="Page navigation">{$pagination_links}</nav></p>
						{/if}
					{else}
						{lang('data_empty')}
					{/if}
				</div>
			</div>
		</div>
	</div>
</div>
