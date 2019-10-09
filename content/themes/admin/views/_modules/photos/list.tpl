<div id="view_albums">
	{form_hidden('manage', $manage_name)}
	<div class="container-fluid  dashboard-content">
		<div class="row border-bottom mb-4">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="page-heade">
					<h2 class="pageheader-title float-left mr-3">{lang('list_heading')}</h2>
                    <div class="page-breadcrumb float-left">
                        <nav aria-label="breadcrumb">
                            {$this->breadcrumb->render()}
                        </nav>
                    </div>
					<p class="pageheader-text"></p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="card">
					<div class="card-body">
                        {form_open(uri_string(), ['id' => 'filter_validationform', 'method' => 'get'])}
                            <ul class="list-inline float-right mb-0">
                                <li class="list-inline-item">
                                    {lang('filter_header')}</li>
                                <li class="list-inline-item">
                                    {form_input('filter_name', $this->input->get('filter_name'), ['class' => 'form-control', 'placeholder' => lang('filter_name')])}
                                </li>
                                <li class="list-inline-item ml-2">
                                    {lang('limit_label')}
                                </li>
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
                                {anchor("`$manage_url`?display="|cat:DISPLAY_GRID, '<i class="fas fa-th"></i>', ['class' => 'btn btn-sm btn-outline-light'])}
                                {anchor("`$manage_url`?display="|cat:DISPLAY_LIST, '<i class="fas fa-list"></i>', ['class' => 'btn btn-sm btn-outline-light'])}
								<span class="ml-2">{lang('list_subheading')}</span>
							</div>
							<div class="col-4 text-right">
								<span id="delete_multiple" class="btn btn-sm btn-danger" style="display: none;" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('btn_delete')}"><i class="far fa-trash-alt"></i></span>
								<button type="button" class="btn btn-sm btn-primary" onclick="Photo.photoAddModal(this);" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('btn_add_photo')}"><i class="fas fa-plus"></i></button>
							</div>
						</div>
					</div>
					<div class="card-body">
						{if !empty($list)}
							{if $display eq DISPLAY_GRID}
								<div class="row list_photos_grid mt-3">
									{foreach $list as $item}
										<div id="photo_key_{$item.id}" class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
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
												<button type="button" onclick="Photo.photoEditModal({$item.id});" class="btn btn-xs btn-light" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('btn_edit')}"><i class="fas fa-edit"></i></button>
												<button type="button" onclick="Photo.loadView('{$manage_url}/delete/{$item.id}');" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('btn_delete')}"><i class="fas fa-trash-alt"></i></button>
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

<div id="load_view_modal"></div>
