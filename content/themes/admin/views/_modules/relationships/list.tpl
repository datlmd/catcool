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
                            {$paging.pagination_title}
						</div>
						<div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12 mb-2 text-right">
							<span id="delete_multiple" class="btn btn-xs btn-space btn-danger" style="display: none;"><i class="far fa-trash-alt mr-2"></i>{lang('btn_delete')}</span>
                            {anchor("`$manage_url`/add", '<i class="fas fa-plus mr-1"></i>'|cat:lang('btn_add'), ['class' => 'btn btn-xs btn-space btn-primary'])}
						</div>
					</div>
					{if !empty($list)}
						<div class="table-responsive">
							<table class="table table-striped table-hover table-bordered second">
								<thead>
									<tr class="text-center">
										<th width="50">{lang('f_id')}</th>
										<th>{lang('candidate_table_label')}</th>
										<th>{lang('candidate_key_label')}</th>
										<th>{lang('foreign_table_label')}</th>
										<th>{lang('foreign_key_label')}</th>
										<th width="160">{lang('f_function')}</th>
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
												{anchor("`$manage_url`/edit/`$item.id`", '<i class="fas fa-edit"></i>', ['class' => 'btn btn-sm btn-outline-light', 'title' => lang('btn_edit')])}
												{anchor("`$manage_url`/delete/`$item.id`", '<i class="far fa-trash-alt"></i>', ['class' => 'btn btn-sm btn-outline-light', 'title' => lang('btn_delete')])}
											</div>
										</td>
										<td class="text-center">{form_checkbox('manage_ids[]', $item.id)}</td>
									</tr>
								{/foreach}
								</tbody>
							</table>
						</div>
                        {if !empty($paging.pagination_links)}
							<p><nav aria-label="Page navigation">{$paging.pagination_links}</nav></p>
                        {/if}
					{else}
						{lang('data_empty')}
					{/if}
				</div>
			</div>
		</div>
	</div>
</div>
