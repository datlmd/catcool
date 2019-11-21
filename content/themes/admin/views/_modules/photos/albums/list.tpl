<div id="view_albums">
	{form_hidden('manage', $manage_name)}
	<div class="container-fluid  dashboard-content">
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="page-header">
					<h2 class="pageheader-title">{lang('heading_title')}</h2>
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
                            	{form_hidden('display', $display)}
								<table class="table border-none">
									<tr>
										<td><b>{lang('filter_header')}</b></td>
										<td class="text-right">
											{form_input('filter_name', $this->input->get('filter_name'), ['class' => 'form-control', 'placeholder' => lang('filter_name')])}
										</td>
										<td class="text-right">{lang('text_limit')}</td>
										<td>
											{form_dropdown('filter_limit', get_list_limit(), $this->input->get('filter_limit'), ['class' => 'form-control form-control-sm'])}
										</td>
										<td class="text-right" width="100">
											<button type="submit" class="btn btn-xs btn-primary">{lang('filter_submit')}</button>
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
					<h5 class="card-header">
						<div class="row">
							<div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
                                {anchor("`$manage_url`?display="|cat:DISPLAY_GRID, '<i class="fas fa-th"></i>', ['class' => 'btn btn-sm btn-outline-light'])}
                                {anchor("`$manage_url`?display="|cat:DISPLAY_LIST, '<i class="fas fa-list"></i>', ['class' => 'btn btn-sm btn-outline-light'])}
                                {lang('list_subheading')}
							</div>
							<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 text-right">
								<span id="delete_multiple" class="btn btn-sm btn-danger" style="display: none;" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_delete')}"><i class="far fa-trash-alt mr-2"></i></span>
								<button type="button" onclick="Photo.loadView('{$manage_url}/add');" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('add_album')}"><i class="fas fa-plus"></i></button>
							</div>
						</div>
					</h5>
					<div class="card-body">
						{if !empty($list)}
							{if $display eq DISPLAY_GRID}
								<div class="row list_photos_grid mt-3">
									{foreach $list as $item}
										<div id="photo_key_{$item.id}" class="col-xl-3 col-lg-4 col-md-4 col-sm-12 col-12 mb-3">
											<a href="javascript:void(0);" onclick="Photo.loadView('{$manage_url}/edit/{$item.id}');">
												<img src="" style="background-image: url('{image_url($item.image)}');" class="img-thumbnail img-fluid img-photo-list">
												<div class="mt-2">
													<b>{$item.title}</b>
													<br />
													{$item.description}
												</div>
											</a>
											<div class="top_right">
												<button type="button" onclick="Photo.loadView('{$manage_url}/delete/{$item.id}');" class="btn btn-xs btn-danger"><i class="fas fa-trash-alt"></i></button>
											</div>
											<div class="top_left">
												<div class="switch-button switch-button-xs catcool-right">
													{form_checkbox("published_`$item.id`", ($item.published eq STATUS_ON) ? true : false, ($item.published eq STATUS_ON) ? true : false, ['id' => 'published_'|cat:$item.id, 'data-id' => $item.id, 'data-published' => $item.published, 'class' => 'change_publish'])}
													<span><label for="published_{$item.id}"></label></span>
												</div>
											</div>
                                            </a>
										</div>
									{/foreach}
								</div>
							{else}
								<div class="table-responsive">
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
												<td class="text-center">{$item.id}</td>
												<td>
													<a href="{image_url($item.image)}" data-lightbox="photos">
														<img src="{image_url($item.image)}" class="img-thumbnail mr-1 img-fluid">
													</a>
												</td>
												<td>
													<a href="javascript:void(0);" onclick="Photo.loadView('{$manage_url}/edit/{$item.id}');" class="text-primary">{$item.title}</a><br />
													{htmlspecialchars($item.description, ENT_QUOTES,'UTF-8')}
												</td>
												<td>
													<div class="switch-button switch-button-xs catcool-center">
														{form_checkbox("published_`$item.id`", ($item.published eq STATUS_ON) ? true : false, ($item.published eq STATUS_ON) ? true : false, ['id' => 'published_'|cat:$item.id, 'data-id' => $item.id, 'data-published' => $item.published, 'class' => 'change_publish'])}
														<span><label for="published_{$item.id}"></label></span>
													</div>
												</td>
												<td class="text-center">
													<div class="btn-group ml-auto">
														<button type="button" onclick="Photo.loadView('{$manage_url}/edit/{$item.id}');" class="btn btn-sm btn-outline-light"><i class="fas fa-edit"></i></button>
														<button type="button" onclick="Photo.loadView('{$manage_url}/delete/{$item.id}');" class="btn btn-sm btn-outline-light"><i class="fas fa-trash-alt"></i></button>
													</div>
												</td>
												<td class="text-center">{form_checkbox('manage_ids[]', $item.id)}</td>
											</tr>
										{/foreach}
										</tbody>
									</table>
								</div>
							{/if}
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
</div>
<input type="hidden" name="confirm_title" value="{lang("confirm_title")}">
<input type="hidden" name="confirm_content" value="{lang("confirm_delete")}">
<input type="hidden" name="confirm_btn_ok" value="{lang("button_delete")}">
<input type="hidden" name="confirm_button_close" value="{lang("button_close")}">
