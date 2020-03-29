<div id="view_albums">
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
					<h5 class="card-header">
						<div class="row">
							<div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
                                {anchor("`$manage_url`?display="|cat:DISPLAY_GRID, '<i class="fas fa-th"></i>', ['class' => 'btn btn-sm btn-outline-light'])}
                                {anchor("`$manage_url`?display="|cat:DISPLAY_LIST, '<i class="fas fa-list"></i>', ['class' => 'btn btn-sm btn-outline-light'])}
                                {lang('text_list')}
							</div>
							<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 text-right">
								<span id="delete_multiple" class="btn btn-sm btn-danger" style="display: none;" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_delete')}"><i class="fas fa-trash-alt mr-2"></i></span>
								<button type="button" onclick="Photo.loadView('{$manage_url}/add');" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_add')}"><i class="fas fa-plus"></i></button>
								<button type="button" id="btn_search" class="btn btn-sm btn-light" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('filter_header')}" data-target="#filter_manage"><i class="fas fa-filter"></i></button>
							</div>
						</div>
					</h5>
					<div class="card-body">
						{if !empty($list)}
							{if $display eq DISPLAY_GRID}
								<div class="row list_photos_grid mt-3">
									{foreach $list as $item}
										<div id="photo_key_{$item.album_id}" class="col-xl-3 col-lg-4 col-md-4 col-sm-12 col-12 mb-3">
											<a href="javascript:void(0);" onclick="Photo.loadView('{$manage_url}/edit/{$item.album_id}');">
												<img src="" style="background-image: url('{image_url($item.image)}');" class="img-thumbnail img-fluid img-photo-list">
												<div class="mt-2">
													<b>{$item.detail.name}</b>
												</div>
											</a>
											<div class="top_right">
												<button type="button" data-id="{$item.album_id}" class="btn btn-sm btn-danger btn_delete_single" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_delete')}"><i class="fas fa-trash-alt"></i></button>
											</div>
											<div class="top_left">
												<div class="switch-button switch-button-xs catcool-right">
													{form_checkbox("published_`$item.album_id`", ($item.published eq STATUS_ON) ? true : false, ($item.published eq STATUS_ON) ? true : false, ['id' => 'published_'|cat:$item.album_id, 'data-id' => $item.album_id, 'data-published' => $item.published, 'class' => 'change_publish'])}
													<span><label for="published_{$item.album_id}"></label></span>
												</div>
											</div>
                                            </a>
										</div>
									{/foreach}
								</div>
							{else}
								<table class="table table-striped table-hover table-bordered second">
									<thead>
										<tr class="text-center">
											<th width="50">{lang('column_id')}</th>
											<th>Thumb</th>
											<th>Album</th>
											<th>{lang('column_published')}</th>
											<th width="160">{lang('column_function')}</th>
											<th width="50">{form_checkbox('manage_check_all')}</th>
										</tr>
									</thead>
									<tbody>
									{foreach $list as $item}
										<tr>
											<td class="text-center">{$item.album_id}</td>
											<td>
												<a href="{image_url($item.image)}" data-lightbox="photos">
													<img src="{image_url($item.image)}" class="img-thumbnail mr-1 img-fluid">
												</a>
											</td>
											<td>
												<a href="javascript:void(0);" onclick="Photo.loadView('{$manage_url}/edit/{$item.album_id}');" class="text-primary">{$item.detail.name}</a><br />
												{htmlspecialchars($item.description, ENT_QUOTES,'UTF-8')}
											</td>
											<td>
												<div class="switch-button switch-button-xs catcool-center">
													{form_checkbox("published_`$item.album_id`", ($item.published eq STATUS_ON) ? true : false, ($item.published eq STATUS_ON) ? true : false, ['id' => 'published_'|cat:$item.album_id, 'data-id' => $item.album_id, 'data-published' => $item.published, 'class' => 'change_publish'])}
													<span><label for="published_{$item.album_id}"></label></span>
												</div>
											</td>
											<td class="text-center">
												<div class="btn-group ml-auto">
													<button type="button" onclick="Photo.loadView('{$manage_url}/edit/{$item.album_id}');" class="btn btn-sm btn-outline-light"><i class="fas fa-edit"></i></button>
													<button type="button" data-id="{$item.album_id}" class="btn btn-sm btn-outline-light btn_delete_single" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_delete')}"><i class="fas fa-trash-alt"></i></button>
												</div>
											</td>
											<td class="text-center">{form_checkbox('manage_ids[]', $item.album_id)}</td>
										</tr>
									{/foreach}
									</tbody>
								</table>
							{/if}
							{include file=get_theme_path('views/inc/paging.inc.tpl')}
						{else}
							{lang('text_no_results')}
						{/if}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<input type="hidden" name="confirm_title" value="{lang("text_confirm_title")}">
<input type="hidden" name="confirm_content" value="{lang("text_confirm_delete")}">
<input type="hidden" name="confirm_btn_ok" value="{lang("button_delete")}">
<input type="hidden" name="confirm_button_close" value="{lang("button_close")}">
