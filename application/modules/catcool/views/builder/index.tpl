{form_hidden('manage', $manage_name)}
<div class="container-fluid  dashboard-content">
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="page-header">
				<h2 class="pageheader-title">{lang('module_heading')}</h2>
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
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="card">
				<h5 class="card-header">{lang('module_subheading')}</h5>
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
							<label class="col-12 col-sm-3 col-form-label text-sm-right">
								{lang('module_name')}
							</label>
							<div class="col-12 col-sm-8 col-lg-6">
								{form_input('module_name', $this->input->post('module_name'), ['class' => 'form-control'])}
							</div>
						</div>
						<div class="form-group row">
							<label class="col-12 col-sm-3 col-form-label text-sm-right">
								{lang('controller_name')}
							</label>
							<div class="col-12 col-sm-8 col-lg-6">
                                {form_input('controller_name', $this->input->post('controller_name'), ['class' => 'form-control'])}
							</div>
						</div>
						<div class="form-group row">
							<label class="col-12 col-sm-3 col-form-label text-sm-right">
								{lang('model_name')}
							</label>
							<div class="col-12 col-sm-8 col-lg-6">
								{form_input('model_name', $this->input->post('model_name'), ['class' => 'form-control'])}
							</div>
						</div>
						<div class="form-group row">
							<label class="col-12 col-sm-3 col-form-label text-sm-right">
								{lang('table_name')}
							</label>
							<div class="col-12 col-sm-8 col-lg-6">
								{form_input('table_name', $this->input->post('table_name'), ['class' => 'form-control'])}
							</div>
						</div>
						<div class="form-group row text-center">
							<div class="col col-sm-10 col-lg-9 offset-sm-1 offset-lg-0">
								<button type="submit" class="btn btn-sm btn-space btn-primary">{lang('add_submit_btn')}</button>
								{anchor("`$manage_url``$params_current`", lang('btn_cancel'), ['class' => 'btn btn-sm btn-space btn-secondary'])}
							</div>
						</div>
					{form_close()}
				</div>
			</div>
		</div>
	</div>
</div>