<div id="view_albums">
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
							<div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12 mb-2">
								{lang('list_subheading')}
							</div>
							<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-2 text-right">
								{anchor("`$manage_url`?display="|cat:DISPLAY_GRID, '<i class="fas fa-th"></i>', ['class' => 'btn btn-sm btn-outline-light'])}
								{anchor("`$manage_url`?display="|cat:DISPLAY_LIST, '<i class="fas fa-list"></i>', ['class' => 'btn btn-sm btn-outline-light'])}
							</div>
						</div>
					</h5>
					<div class="card-body">
						<div class="row">
							<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-2">
								{$paging.pagination_title}
							</div>
							<div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12 mb-2 text-right">
								<span id="delete_multiple" class="btn btn-xs btn-space btn-danger" style="display: none;">{lang('btn_delete')}</span>
								<button type="button" class="btn btn-xs btn-space btn-primary" onclick="Photo.photoAddModal(this);"><i class="fas fa-plus mr-1"></i>{lang('btn_add_photo')}</button>
							</div>
						</div>
						{if !empty($list)}
							{if $display eq DISPLAY_GRID}
								<div class="row list_photos_grid mt-3">
									{foreach $list as $item}
										<div id="photo_key_{$item.id}" class="col-xl-3 col-lg-4 col-md-4 col-sm-12 col-12 mb-3">
											<a href="{image_url($item.image)}" data-lightbox="photos">
												<img src="" style="background-image: url('{image_url($item.image)}');" class="img-thumbnail img-fluid img-photo-list">
											</a>
											<div class="mt-2">
                                                {if !empty($item.title)}<strong>{$item.title}</strong><br />{/if}
												<small>
													{if isset($list_album[$item.album_id])}
														Album: {anchor("photos/albums/manage/edit/`$item.album_id`", {$list_album[$item.album_id]}, 'class="text-primary"')}
													{else}
														No album
													{/if}
												</small>
											</div>
											<div class="top_right">
												<button type="button" onclick="Photo.photoEditModal({$item.id});" class="btn btn-sm btn-light"><i class="fas fa-edit"></i></button>
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
							{/if}
							<div class="table-responsive">
								<table class="table table-striped table-hover table-bordered second">
									<thead>
										<tr class="text-center">
											<th width="50">{lang('f_id')}</th>
											<th>Thumb</th>
											<th>{lang('f_title')}</th>
											<th>{lang('f_published')}</th>
											<th width="160">{lang('f_function')}</th>
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
                                                {anchor("$manage_url/edit/`$item.id`", htmlspecialchars($item.title, ENT_QUOTES,'UTF-8'), 'class="text-primary"')}<br/>
                                                <small>
                                                    {if isset($list_album[$item.album_id])}
                                                        Album: {anchor("photos/albums/manage/edit/`$item.album_id`", {$list_album[$item.album_id]}, 'class="text-primary"')}
                                                    {else}
                                                        No album
                                                    {/if}
                                                </small>
                                            </td>
											<td>
												<div class="switch-button switch-button-xs catcool-center">
													{form_checkbox("published_`$item.id`", ($item.published eq STATUS_ON) ? true : false, ($item.published eq STATUS_ON) ? true : false, ['id' => 'published_'|cat:$item.id, 'data-id' => $item.id, 'data-published' => $item.published, 'class' => 'change_publish'])}
													<span><label for="published_{$item.id}"></label></span>
												</div>
											</td>
											<td class="text-center">
												<div class="btn-group ml-auto">
													{anchor("`$manage_url`/edit/`$item.id`", '<i class="far fa-edit"></i>', 'class="btn btn-sm btn-outline-light"')}
													{anchor("`$manage_url`/delete/`$item.id`", '<i class="far fa-trash-alt"></i>', ['class' => 'btn btn-sm btn-outline-light'])}
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
</div>

<div id="load_view_modal"></div>
