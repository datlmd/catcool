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
											{form_dropdown('filter_language', array_merge(['none' => lang('filter_dropdown_all')], get_multi_lang()), $this->input->get('filter_language'), ['class' => 'form-control form-control-sm'])}
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
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-right">
							<span id="delete_multiple" class="btn btn-xs btn-space btn-danger" style="display: none;"><i class="far fa-trash-alt mr-2"></i>{lang('btn_delete')}</span>
                            {anchor("`$manage_url`/add`$params_current`", '<i class="fas fa-plus mr-1"></i>'|cat:lang('btn_add'), ['class' => 'btn btn-xs btn-space btn-primary'])}
						</div>
					</div>
					<input type="hidden" name="module_id" value="{$module.id}">
					{if !empty($list)}
						<div class="table-responsive">
							<table class="table table-striped table-hover table-bordered second">
								<thead>
									<tr class="text-center">
										<th>Key</th>
                                        {foreach $list_lang as $lang}
											<th>Value {$lang.name}</th>
										{/foreach}
										<th width="160">{lang('f_function')}</th>
										<th width="50">{form_checkbox('manage_check_all')}</th>
									</tr>
								</thead>
								<tbody>
								{foreach $list as $key => $item}
									<tr>
										<td>{$key}</td>
                                        {foreach $list_lang as $lang}
											<td>

												<input type="text" id="{$key}_{$lang.id}" name="{$key}_{$lang.id}" value="{if isset($item[$lang.id])}{$item[$lang.id].lang_value}{/if}" class="form-control">
											</td>
                                        {/foreach}

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
					{else}
						{lang('data_empty')}
					{/if}
				</div>
			</div>
		</div>
	</div>
</div>
