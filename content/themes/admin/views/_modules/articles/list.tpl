{form_hidden('manage', $manage_name)}
<div class="container-fluid dashboard-content">
	{include file=get_theme_path('views/inc/breadcrumb.inc.tpl')}
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="card">
				<div class="card-body">
					{form_open(uri_string(), ['id' => 'filter_validationform', 'method' => 'get'])}
						<ul class="list-inline float-right mb-0">
							<li class="list-inline-item">{lang('filter_header')}</li>
							<li class="list-inline-item">
								{form_input('filter_name', $this->input->get('filter_name'), ['class' => 'form-control', 'placeholder' => lang('filter_name')])}
							</li>
							{if is_show_select_language()}
								<li class="list-inline-item ml-2">{lang('language_label')}</li>
								<li class="list-inline-item">
									{form_dropdown('filter_language', array_merge(['none' => lang('filter_dropdown_all')], get_multi_lang()), $this->input->get('filter_language'), 'class="form-control form-control-sm"')}
								</li>
							{/if}
							<li class="list-inline-item ml-2">{lang('limit_label')}</li>
							<li class="list-inline-item">
								{form_dropdown('filter_limit', get_list_limit(), $this->input->get('filter_limit'), ['class' => 'form-control form-control-sm'])}
							</li>
							<li class="list-inline-item ml-2">
								<button type="submit" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="{lang('filter_submit')}" data-original-title="{lang('filter_submit')}"><i class="fas fa-search"></i></button>
							</li>
						</ul>
					{form_close()}
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
							<h5 class="mb-0 mt-1 ml-2"><i class="fas fa-list mr-2"></i>{lang('list_subheading')}</h5>
						</div>
						<div class="col-4 text-right">
							<span id="delete_multiple" class="btn btn-sm btn-danger" style="display: none;" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('btn_delete')}"><i class="far fa-trash-alt"></i></span>
							<a href="{$manage_url}/add" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('btn_add')}"><i class="fas fa-plus"></i></a>
						</div>
					</div>
				</div>
				<div class="card-body">
					{if !empty($list)}
						<div class="table-responsive">
							<table class="table table-striped table-hover table-bordered second">
								<thead>
									<tr class="text-center">
										<th width="50">{lang('f_id')}</th>
										<th>Thumb</th>
										<th>{lang('f_title')}</th>
										<th>{lang('f_published')}</th>
										{if is_show_select_language()}<th>{lang('f_language')}</th>{/if}
										<th width="160">{lang('f_function')}</th>
										<th width="50">{form_checkbox('manage_check_all')}</th>
									</tr>
								</thead>
								<tbody>
								{foreach $list as $item}
									<tr>
										<td class="text-center">{anchor("$manage_url/edit/`$item.id`", $item.id, 'class="text-primary"')}</td>
										<td class="text-center">
											<div class="thumbnail">
												<a href="{image_url($item.images)}" data-lightbox="photos">
													<img src="{image_url($item.images)}" class="img-thumbnail mr-1 img-fluid">
												</a>
											</div>
										</td>
										<td>
                                            {anchor("$manage_url/edit/`$item.id`", htmlspecialchars($item.title, ENT_QUOTES,'UTF-8'), 'class="text-primary"')}<br/>
											<span class="list_datetime">{$item.ctime}</span><br />
											{htmlspecialchars($item.description, ENT_QUOTES,'UTF-8')}
										</td>
										<td>
											<div class="switch-button switch-button-xs catcool-center">
												{form_checkbox("published_`$item.id`", ($item.published eq STATUS_ON) ? true : false, ($item.published eq STATUS_ON) ? true : false, ['id' => 'published_'|cat:$item.id, 'data-id' => $item.id, 'data-published' => $item.published, 'class' => 'change_publish'])}
												<span><label for="published_{$item.id}"></label></span>
											</div>
										</td>
										{if is_show_select_language()}<td class="text-center">{lang($item.language)}</td>{/if}
										<td class="text-center">
											<div class="btn-group ml-auto">
												<a href="{$manage_url}/edit/{$item.id}" class="btn btn-sm btn-outline-light" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('btn_edit')}"><i class="fas fa-edit"></i></a>
												<a href="{$manage_url}/delete/{$item.id}" class="btn btn-sm btn-outline-light" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('btn_delete')}"><i class="far fa-trash-alt"></i></a>
											</div>
										</td>
										<td class="text-center">{form_checkbox('manage_ids[]', $item.id)}</td>
									</tr>
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
