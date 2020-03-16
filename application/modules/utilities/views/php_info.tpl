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
				<div class="card-header">
					<div class="row">
						<div class="col-8">
							<h5 class="mb-0 mt-1 ml-2"><i class="fas fa-list mr-2"></i>{lang('text_list')}</h5>
						</div>
						<div class="col-4 text-right">
							<span id="delete_multiple" class="btn btn-sm btn-danger" style="display: none;" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_delete')}"><i class="fas fa-trash-alt"></i></span>
							<a href="{$manage_url}/add{http_get_query()}" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('button_add')}"><i class="fas fa-plus"></i></a>
							<button type="button" id="btn_search" class="btn btn-sm btn-light" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('filter_header')}" data-target="#filter_manage"><i class="fas fa-filter"></i></button>
						</div>
					</div>
				</div>
				<div class="card-body">
					{if !empty($info_list)}

						{foreach $info_list as $key => $item}
							<h3 class="text-center">{$key}</h3>
							{foreach $item as $name => $value}
								<div class="form-group row">
									<label class="col-12 col-sm-4 col-form-label text-sm-right"><strong>{$name}</strong></label>
									<div class="col-12 col-sm-8 col-lg-6 pt-1">
										{if is_array($value) && count($value) == 2 && $value[0] == $value[1]}
											{$value[0]}
										{elseif is_array($value)}
                                            {foreach $value as $val}
												{$val}
                                            {/foreach}
										{else}
											{$value}
										{/if}
									</div>
								</div>
							{/foreach}
						{/foreach}


					{else}
						{lang('text_no_results')}
					{/if}
				</div>
			</div>
		</div>
	</div>
</div>
