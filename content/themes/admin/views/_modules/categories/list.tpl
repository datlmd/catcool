<div class="container-fluid  dashboard-content">
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="page-header">
				<h2 class="pageheader-title">{lang('list_heading')}</h2>
				<p class="pageheader-text">Proin placerat ante duiullam scelerisque a velit ac porta, fusce sit amet vestibulum mi. Morbi lobortis pulvinar quam.</p>
				<div class="page-breadcrumb">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
							<li class="breadcrumb-item active" aria-current="page">{lang('list_heading')}</a></li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
	</div>
    {if is_show_select_language()}
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="card">
					<h5 class="card-header">{lang('filter_header')}</h5>
					<div class="card-body">
						{form_open(uri_string(), 'id="add_validationform" method=""')}
							<div class="form-row">
								<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 mb-2">
									{lang('language_label')}
									{form_dropdown('filter_language', array_merge(['none' => lang('filter_dropdown_all')], get_multi_lang()), $this->input->get('filter_language'), 'class="form-control form-control-sm"')}
								</div>
								<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
									<button type="submit" class="btn btn-xs btn-primary">{lang('filter_submit')}</button>
								</div>
							</div>
						{form_close()}
					</div>
				</div>
			</div>
		</div>
    {/if}
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="card">
				<h5 class="card-header">{lang('list_subheading')}</h5>
				<div class="card-body">
					<p>
						{anchor('categories/manage/add', lang('btn_add'), 'class="btn btn-xs btn-space btn-primary"')}
						<span id="delete_multiple" class="btn btn-xs btn-space btn-secondary" style="display: none;">{lang('btn_delete')}</span>
					</p>
					<div class="table-responsive">
						{if !empty($list)}
							{form_hidden('manage', 'categories')}
							<table class="table table-striped table-bordered second">
								<thead>
									<tr class="text-center">
										<th width="50">{lang('f_id')}</th>
										<th>{lang('f_title')}</th>
										<th>{lang('f_description')}</th>
										<th>{lang('f_context')}</th>
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
										<td>{anchor("categories/manage/edit/`$item.id`", htmlspecialchars($item.title, ENT_QUOTES,'UTF-8'), 'class="text-primary"')}</td>
										<td>{htmlspecialchars($item.description, ENT_QUOTES,'UTF-8')}</td>
										<td>{htmlspecialchars($item.context,ENT_QUOTES,'UTF-8')}</td>
										<td class="text-center">{$item.precedence}</td>
										<td>
											<div class="switch-button switch-button-xs catcool-center">
												{form_checkbox("published_`$item.id`", $item.published, $item.published, "id='published_`$item.id`' data-id=`$item.id` class='change_publish'")}
												<span><label for="published_{$item.id}"></label></span>
											</div>
										</td>
                                        {if is_show_select_language()}
											<td class="text-center">{lang($item.language)}</td>
										{/if}
										<td class="text-center">
											<div class="btn-group ml-auto">
                                                {anchor("categories/manage/edit/`$item.id`", lang('btn_edit'), 'class="btn btn-sm btn-outline-light"')}
												{anchor("categories/manage/delete/`$item.id`", '<i class="far fa-trash-alt"></i>', 'class="btn btn-sm btn-outline-light"')}
											</div>
										</td>
										<td class="text-center">{form_checkbox('manage_ids[]', $item.id)}</td>
									</tr>
								{/foreach}
								</tbody>
							</table>
						{/if}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
