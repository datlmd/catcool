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
									<td class="text-right" width="90">Modules</td>
									<td>
										{if !empty($list_module)}
											<select name="filter_module" class="form-control form-control-sm">
												{foreach $list_module as $value}
													<option value="{$value.id}" {if $this->input->get('filter_module') eq $value.id}selected="selected"{/if}>{$value.module}{if !empty($value.sub_module)} - Sub: {$value.sub_module}{/if}</option>
												{/foreach}
											</select>
                                        {/if}
									</td>
									<td class="text-right" width="100">
										<button type="submit" class="btn btn-xs btn-primary"><i class="fas fa-search mr-1"></i>{lang('filter_submit')}</button>
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
				<h5 class="card-header">{lang('list_subheading')}</h5>
				<div class="card-body">
					<div class="row">
						<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-2">
							Module: {$module.module|capitalize}
							{if !empty($module.sub_module)} - Sub: {$module.sub_module|capitalize}{/if}
						</div>
						<div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12 mb-2 text-right">
							<button type="button" class="btn btn-xs btn-space btn-primary" data-toggle="modal" data-target="#addLang"><i class="fas fa-plus mr-1"></i>{lang('btn_add')}</button>
							<button type="button" onclick="save_translate()" class="btn btn-xs btn-space btn-secondary"><i class="fas fa-save mr-1"></i>{lang('edit_submit_btn')}</button>
							<button type="button" onclick="write_translate({$module.id})" class="btn btn-xs btn-space btn-success"><i class="fas fa-sync mr-1"></i>{lang('btn_write')}</button>
						</div>
					</div>
					<input type="hidden" name="module_id" value="{$module.id}">
					{if !empty($list) && !empty($module)}
						<div class="table-responsive">
                            {form_open('catcool/translations/manage/edit', ['id' => 'save_validationform'])}
                            	{form_hidden('module_id', $module.id)}
                                <table class="table table-striped table-hover table-bordered second">
                                    <thead>
                                        <tr class="text-center">
                                            <th>Key</th>
                                            {foreach $list_lang as $lang}
                                                <th>{$lang.name|capitalize}</th>
                                            {/foreach}
                                            <th width="80"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    {foreach $list as $key => $item}
                                        <tr id="{$key}">
                                            <td>{$key}</td>
                                            {foreach $list_lang as $lang}
                                                <td>
                                                    {if isset($item[$lang.id])}
                                                        <textarea id="{$key}_{$lang.id}" name="translate[{$key}][{$lang.id}]" class="form-control">{$item[$lang.id].lang_value}</textarea>
                                                    {else}
                                                        <textarea id="{$key}_{$lang.id}" name="translate[{$key}][{$lang.id}]" class="form-control"></textarea>
                                                    {/if}
                                                </td>
                                            {/foreach}
                                            <td class="text-center">
                                                <div class="btn-group ml-auto">
													<button type="button" class="btn btn-sm btn-outline-light" data-module="{$module.id}" data-key="{$key}" onclick="delete_translate(this)" title="{lang('btn_delete')}"><i class="far fa-trash-alt"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    {/foreach}
                                    </tbody>
                                </table>
                            {form_close()}
						</div>
					{else}
						{lang('data_empty')}
					{/if}
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal add -->
<div class="modal fade" id="addLang" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addModalLabel">{lang('add_heading')}</h5>
				<a href="#" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</a>
			</div>
			<div class="modal-body">
				<div id="add_validation_error" class="text-danger"></div>
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    {form_open('catcool/translations/manage/add', ['id' => 'add_lang_form'])}
						<div class="form-group row">
							<label class="col-12 col-sm-3 col-form-label text-sm-right">
								Key:
							</label>
							<div class="col-12 col-sm-8 col-lg-6">
								<input type="text" name="add_key" value="" class="form-control">
							</div>
						</div>
						{foreach $list_lang as $lang}
							<div class="form-group row">
								<label class="col-12 col-sm-3 col-form-label text-sm-right">
									{$lang.name|capitalize}
								</label>
								<div class="col-12 col-sm-8 col-lg-6">
									<textarea id="add_value_{$lang.id}" name="add_value[{$lang.id}]" class="form-control"></textarea>
								</div>
							</div>
						{/foreach}
						<div class="form-group row text-center">
							<div class="col-12 col-sm-3"></div>
							<div class="col-12 col-sm-8 col-lg-6">
								<input type="hidden" name="module_id" value="{$module.id}">
								<button type="button" onclick="add_translate()" class="btn btn-sm btn-space btn-primary">{lang('add_submit_btn')}</button>
								{anchor("`$manage_url`", lang('btn_close'), ['data-dismiss' => 'modal', 'class' => 'btn btn-sm btn-space btn-secondary'])}
							</div>
						</div>
                    {form_close()}
				</div>
			</div>
            {*<div class="modal-footer text-center">*}
            {*<button type="submit" class="btn btn-sm btn-space btn-primary">{lang('add_submit_btn')}</button>*}
            {*<a href="#" class="btn btn-secondary btn-sm btn-space" data-dismiss="modal">Close</a>*}
            {*</div>*}
		</div>
	</div>
</div>
<script>
    function add_translate() {
        $('#add_validation_error').html('');
        $.ajax({
            url: $("#add_lang_form").attr('action'),
            type: 'POST',
            data: $("#add_lang_form").serialize(),
            success: function (data) {
                var response = JSON.stringify(data);
                response     = JSON.parse(response);
                if (response.status == 'ng') {
                    $('#add_validation_error').html(response.msg);
                    return false;
                }

                location.reload();
            },
            error: function (xhr, errorType, error) {
            }
        });
    }
    function save_translate() {
        $.ajax({
            url: $("#save_validationform").attr('action'),
            type: 'POST',
            data: $("#save_validationform").serialize(),
            success: function (data) {
                var response = JSON.stringify(data);
                response     = JSON.parse(response);
                if (response.status == 'ng') {
                    $.notify(response.msg);
                    return false;
                }

                location.reload();
            },
            error: function (xhr, errorType, error) {
            }
        });
    }
    function delete_translate(obj) {
        $.confirm({
            title: '{{lang("confirm_title")}}',
            content: '{{lang("confirm_delete")}}',
            icon: 'fa fa-question',
            //theme: 'bootstrap',
            closeIcon: true,
            //animation: 'scale',
            typeAnimated: true,
            type: 'red',
            buttons: {
                formSubmit: {
                    text: '{{lang("btn_delete")}}',
                    btnClass: 'btn-danger',
                    keys: ['y', 'enter', 'shift'],
                    action: function(){
                        var key = $(obj).attr("data-key");
                        $.ajax({
                            url: 'catcool/translations/manage/delete',
                            type: 'POST',
                            data: {
								module_id: $(obj).attr("data-module"),
								key: key
                            },
                            success: function (data) {
                                var response = JSON.stringify(data);
                                response     = JSON.parse(response);
                                if (response.status == 'ng') {
                                    $.notify(response.msg, {
										'type':'danger'
                                    });
                                    return false;
                                }

								$('#' + key).fadeOut(300, function(){ $(this).remove();});
                                $.notify(response.msg)
                            },
                            error: function (xhr, errorType, error) {
                            }
                        });
                    }
                },
                cancel: {
                    text: '{{lang("btn_close")}}',
                    keys: ['n']
                },
            }
        });
    }
    function write_translate(module_id) {
        $.confirm({
            title: '{{lang("confirm_title")}}',
            content: '{{lang("confirm_write")}}',
            icon: 'fa fa-question',
            //theme: 'bootstrap',
            closeIcon: true,
            //animation: 'scale',
            typeAnimated: true,
            type: 'blue',
            buttons: {
                formSubmit: {
                    text: '{{lang("btn_write")}}',
                    btnClass: 'btn-danger',
                    keys: ['y', 'enter', 'shift'],
                    action: function(){
                        $.ajax({
                            url: 'catcool/translations/manage/write',
                            type: 'POST',
                            data: {
                                module_id: module_id
                            },
                            success: function (data) {
                                var response = JSON.stringify(data);
                                response     = JSON.parse(response);
                                $.notify(response.msg)
                            },
                            error: function (xhr, errorType, error) {
                            }
                        });
                    }
                },
                cancel: {
                    text: '{{lang("btn_close")}}',
                    keys: ['n']
                },
            }
        });
    }
</script>
