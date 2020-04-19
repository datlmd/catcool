{form_hidden('manage_url', $manage_url)}
<div class="container-fluid  dashboard-content">
	{include file=get_theme_path('views/inc/breadcrumb.inc.tpl')}
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="card">
				<h5 class="card-header">{lang('heading_title')}</h5>
				<div class="card-body">
					{ul(lang('builder_caution'), ['class' => 'list-unstyled arrow'])}
					{if !empty(validation_errors())}
						<ul class="text-danger">{validation_errors('<li>', '</li>')}</ul>
					{/if}
					{if !empty($error_created)}
						{ul($error_created, ['class' => 'text-danger'])}
					{/if}
                    {form_open(uri_string(), ['id' => 'add_validationform'])}
						<div class="form-group row">
							<label class="col-12 col-sm-3 col-form-label required-label text-sm-right">
								{lang('module_name')}
							</label>
							<div class="col-12 col-sm-8 col-lg-6">
								{form_input('module_name', $this->input->post('module_name'), ['class' => 'form-control'])}
								Ex: Tags
							</div>
						</div>
						<div class="form-group row">
							<label class="col-12 col-sm-3 col-form-label required-label text-sm-right">
								{lang('controller_name')}
							</label>
							<div class="col-12 col-sm-8 col-lg-6">
                                {form_input('controller_name', $this->input->post('controller_name'), ['class' => 'form-control'])}
								Ex: Tags or Manage - Submodule: Groups
							</div>
						</div>
						<div class="form-group row">
							<label class="col-12 col-sm-3 col-form-label required-label text-sm-right">
								{lang('model_name')}
							</label>
							<div class="col-12 col-sm-8 col-lg-6">
								{form_input('model_name', $this->input->post('model_name'), ['class' => 'form-control'])}
								Ex: Tag - Submodule: Group
							</div>
						</div>
						<div class="form-group row">
							<label class="col-12 col-sm-3 col-form-label required-label text-sm-right">
								{lang('table_name')}
							</label>
							<div class="col-12 col-sm-8 col-lg-6">
								{form_input('table_name', $this->input->post('table_name'), ['class' => 'form-control'])}
								Ex: tag (If null = model)
							</div>
						</div>
						<div class="form-group row text-center">
							<div class="col-12 col-sm-3 col-form-label text-sm-right"></div>
							<div class="col-12 col-sm-8 col-lg-6">
								<button type="submit" class="btn btn-sm btn-space btn-primary"><i class="fas fa-plus mr-1"></i>{lang('btn_create_module')}</button>
								<button type="reset" class="btn btn-sm btn-space btn-secondary"><i class="fas fa-undo mr-1"></i>{lang('button_reset')}</button>
							</div>
						</div>
					{form_close()}
				</div>
			</div>
		</div>
	</div>
</div>
