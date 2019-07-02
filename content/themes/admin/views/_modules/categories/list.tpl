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
		{print_flash_alert()}
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="card">
				<h5 class="card-header">{lang('list_subheading')}</h5>
				<div class="card-body">
					<p>{anchor('categories/manage/add', lang('list_add'), 'class="btn btn-brand"')}</p>
					<div class="table-responsive">
						{if !empty($list)}
							<table class="table table-striped table-bordered second">
								<thead>
									<tr class="text-center">
										<th width="50">{lang('f_id')}</th>
										<th>{lang('f_title')}</th>
										<th>{lang('f_description')}</th>
										<th>{lang('f_context')}</th>
										<th>{lang('f_precedence')}</th>
										<th>{lang('f_published')}</th>
										<th width="160">{lang('list_function')}</th>
									</tr>
								</thead>
								<tbody>
								{foreach $list as $item}
									<tr>
										<td class="text-center">{$item.id}</td>
										<td>{htmlspecialchars($item.title, ENT_QUOTES,'UTF-8')}</td>
										<td>{htmlspecialchars($item.description, ENT_QUOTES,'UTF-8')}</td>
										<td>{htmlspecialchars($item.context,ENT_QUOTES,'UTF-8')}</td>
										<td class="text-center">{$item.precedence}</td>
										<td class="text-center">{htmlspecialchars($item.published,ENT_QUOTES,'UTF-8')}</td>
										<td class="text-center">
											<div class="btn-group ml-auto">
                                                {anchor("categories/manage/edit/`$item.id`", lang('list_edit'), 'class="btn btn-sm btn-outline-light"')}
												<button class="btn btn-sm btn-outline-light">
													<i class="far fa-trash-alt"></i>
												</button>
											</div>
										</td>
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
<!-- Modal -->