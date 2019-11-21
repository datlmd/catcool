<div id="view_albums">
	{form_hidden('manage', $manage_name)}
	<div class="container-fluid  dashboard-content">
		{include file=get_theme_path('views/inc/breadcrumb.inc.tpl')}
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="card">
					<div class="card-body">
                        {form_open(uri_string(), ['id' => 'filter_validationform', 'method' => 'get'])}
                            <ul class="list-inline mb-0">
                                <li class="list-inline-item">
                                    {lang('filter_header')}</li>
                                <li class="list-inline-item">
                                    {form_input('filter_name', $this->input->get('filter_name'), ['class' => 'form-control', 'placeholder' => lang('filter_name')])}
                                </li>
                                <li class="list-inline-item ml-2">
                                    {lang('text_limit')}
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
								<span id="delete_multiple" class="btn btn-sm btn-danger" style="display: none;" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_delete')}"><i class="far fa-trash-alt"></i></span>
								<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addphotoModal" title="{lang('button_photo_add')}"><i class="fas fa-plus"></i></button>
							</div>
						</div>
					</div>
					<div class="card-body">
						{if !empty($list)}
							{if $display eq DISPLAY_GRID}
								<div class="row list_photos_grid mt-3">
									{foreach $list as $item}
										<div id="photo_key_{$item.id}" class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
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
												<button type="button" onclick="Photo.photoEditModal({$item.id});" class="btn btn-xs btn-light" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_edit')}"><i class="fas fa-edit"></i></button>
												<button type="button" onclick="Photo.loadView('{$manage_url}/delete/{$item.id}');" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_delete')}"><i class="fas fa-trash-alt"></i></button>
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
											<th width="50">{lang('column_id')}</th>
											<th>Thumb</th>
											<th>{lang('column_name')}</th>
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
                                                {anchor("$manage_url/edit/`$item.id`", htmlspecialchars($item.title, ENT_QUOTES,'UTF-8'), 'class="text-primary" onclick="Photo.photoEditModal({$item.id});"')}<br/>
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
													<button type="button" onclick="Photo.photoEditModal({$item.id});" class="btn btn-xs btn-outline-light" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_edit')}"><i class="fas fa-edit"></i></button>
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
<!-- Modal add -->
<div class="modal fade" id="addphotoModal" tabindex="-1" role="dialog" aria-labelledby="photoModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="photoModalLabel">{lang('add_heading')}</h5>
				<a href="#" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</a>
			</div>
			<div class="modal-body">

                {if !empty(validation_errors())}
					<ul class="text-danger">{validation_errors('<li>', '</li>')}</ul>
                {/if}
                {form_open(uri_string(), ['id' => 'form_add_photo'])}
				<div class="form-group row">
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-right">
						<button type="button" onclick="Photo.submitPhoto('form_add_photo');" class="btn btn-sm btn-space btn-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_photo_add')}"><i class="fas fa-save"></i></button>
						<a href="#" class="btn btn-secondary btn-sm btn-space" data-dismiss="modal" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_close')}"><i class="fas fa-reply"></i></a>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-12 col-sm-3 col-form-label text-sm-right">
                        {lang('text_name')}
					</label>
					<div class="col-12 col-sm-8 col-lg-6">
                        {form_input($title)}
					</div>
				</div>
				<div class="form-group row">
					<label class="col-12 col-sm-3 col-form-label text-sm-right">
                        {lang('text_tags')}
					</label>
					<div class="col-12 col-sm-8 col-lg-6">
                        {form_input($tags)}
					</div>
				</div>
				<div class="form-group row">
					<label class="col-12 col-sm-3 col-form-label text-sm-right">Album</label>
					<div class="col-12 col-sm-8 col-lg-6">
						<select name="parent_id" id="parent_id" class="form-control">
							<option value="">{lang('text_select')}</option>
                            {foreach $list_album as $key => $value}
								<option value="{$key}" {if $item_edit.album_id eq $key}selected="selected"{/if}>{$value}</option>
                            {/foreach}
						</select>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-12 col-sm-3 col-form-label text-sm-right">{lang("is_comment_label")}</label>
					<div class="col-12 col-sm-8 col-lg-6">
						<div class="switch-button switch-button-sm mt-1">
                            {form_checkbox($is_comment)}
							<span><label for="is_comment"></label></span>
						</div>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-12 col-sm-3 col-form-label text-sm-right">{lang('published')}</label>
					<div class="col-12 col-sm-8 col-lg-6">
						<div class="switch-button switch-button-sm mt-1">
                            {form_checkbox($published)}
							<span><label for="published"></label></span>
						</div>
					</div>
				</div>

				<!-- Drag and Drop container-->
                {lang('select_photos')}
				<div class="drop-drap-file" data-is-multi="false">
					<input type="file" name="file" id="file" accept="audio/*,video/*,image/*" /> {*multiple*}
					<div class="upload-area dropzone dz-clickable" id="uploadfile">
						<h5 class="dz-message"">{lang('image_upload')}</h5>
					</div>
				</div>
				<ul id="image_thumb" data-is_multi="false" class="list_album_photos row mt-2"></ul>

                {form_close()}

				<input type="hidden" name="confirm_title" value="{lang("confirm_title")}">
				<input type="hidden" name="confirm_content" value="{lang("confirm_delete")}">
				<input type="hidden" name="confirm_btn_ok" value="{lang("button_delete")}">
				<input type="hidden" name="confirm_button_close" value="{lang("button_close")}">

			</div>
		</div>
	</div>
</div>