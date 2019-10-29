<?php /* Smarty version 3.1.28-dev/21, created on 2019-10-29 16:53:52
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/dev/catcool/content/themes/admin/views/_modules/photos/albums/list.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:13345191945db80c30020651_66212556%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'faa0b32731817c8b7f3e703facad5043e65ffb01' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/dev/catcool/content/themes/admin/views/_modules/photos/albums/list.tpl',
      1 => 1570529218,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13345191945db80c30020651_66212556',
  'variables' => 
  array (
    'manage_name' => 0,
    'this' => 0,
    'display' => 0,
    'manage_url' => 0,
    'list' => 0,
    'item' => 0,
    'paging' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.28-dev/21',
  'unifunc' => 'content_5db80c307998f3_88073126',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5db80c307998f3_88073126')) {
function content_5db80c307998f3_88073126 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '13345191945db80c30020651_66212556';
?>
<div id="view_albums">
	<?php echo form_hidden('manage',$_smarty_tpl->tpl_vars['manage_name']->value);?>

	<div class="container-fluid  dashboard-content">
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="page-header">
					<h2 class="pageheader-title"><?php echo lang('list_heading');?>
</h2>
					<p class="pageheader-text"></p>
					<div class="page-breadcrumb">
						<nav aria-label="breadcrumb">
							<?php echo $_smarty_tpl->tpl_vars['this']->value->breadcrumb->render();?>

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
							<?php echo form_open(uri_string(),array('id'=>'filter_validationform','method'=>'get'));?>

                            	<?php echo form_hidden('display',$_smarty_tpl->tpl_vars['display']->value);?>

								<table class="table border-none">
									<tr>
										<td><b><?php echo lang('filter_header');?>
</b></td>
										<td class="text-right">
											<?php echo form_input('filter_name',$_smarty_tpl->tpl_vars['this']->value->input->get('filter_name'),array('class'=>'form-control','placeholder'=>lang('filter_name')));?>

										</td>
										<td class="text-right"><?php echo lang('limit_label');?>
</td>
										<td>
											<?php echo form_dropdown('filter_limit',get_list_limit(),$_smarty_tpl->tpl_vars['this']->value->input->get('filter_limit'),array('class'=>'form-control form-control-sm'));?>

										</td>
										<td class="text-right" width="100">
											<button type="submit" class="btn btn-xs btn-primary"><?php echo lang('filter_submit');?>
</button>
										</td>
									</tr>
								</table>
							<?php echo form_close();?>

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
                                <?php echo anchor((((string)$_smarty_tpl->tpl_vars['manage_url']->value)."?display=").(DISPLAY_GRID),'<i class="fas fa-th"></i>',array('class'=>'btn btn-sm btn-outline-light'));?>

                                <?php echo anchor((((string)$_smarty_tpl->tpl_vars['manage_url']->value)."?display=").(DISPLAY_LIST),'<i class="fas fa-list"></i>',array('class'=>'btn btn-sm btn-outline-light'));?>

                                <?php echo lang('list_subheading');?>

							</div>
							<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 text-right">
								<span id="delete_multiple" class="btn btn-sm btn-danger" style="display: none;" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo lang('btn_delete');?>
"><i class="far fa-trash-alt mr-2"></i></span>
								<button type="button" onclick="Photo.loadView('<?php echo $_smarty_tpl->tpl_vars['manage_url']->value;?>
/add');" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo lang('add_album');?>
"><i class="fas fa-plus"></i></button>
							</div>
						</div>
					</h5>
					<div class="card-body">
						<?php if (!empty($_smarty_tpl->tpl_vars['list']->value)) {?>
							<?php if ($_smarty_tpl->tpl_vars['display']->value == DISPLAY_GRID) {?>
								<div class="row list_photos_grid mt-3">
									<?php
$foreach_0_item_sav['s_item'] = isset($_smarty_tpl->tpl_vars['item']) ? $_smarty_tpl->tpl_vars['item'] : false;
$_from = $_smarty_tpl->tpl_vars['list']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['item']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
$foreach_0_item_sav['item'] = $_smarty_tpl->tpl_vars['item'];
?>
										<div id="photo_key_<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
" class="col-xl-3 col-lg-4 col-md-4 col-sm-12 col-12 mb-3">
											<a href="javascript:void(0);" onclick="Photo.loadView('<?php echo $_smarty_tpl->tpl_vars['manage_url']->value;?>
/edit/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
');">
												<img src="" style="background-image: url('<?php echo image_url($_smarty_tpl->tpl_vars['item']->value['image']);?>
');" class="img-thumbnail img-fluid img-photo-list">
												<div class="mt-2">
													<b><?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
</b>
													<br />
													<?php echo $_smarty_tpl->tpl_vars['item']->value['description'];?>

												</div>
											</a>
											<div class="top_right">
												<button type="button" onclick="Photo.loadView('<?php echo $_smarty_tpl->tpl_vars['manage_url']->value;?>
/delete/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
');" class="btn btn-xs btn-danger"><i class="fas fa-trash-alt"></i></button>
											</div>
											<div class="top_left">
												<div class="switch-button switch-button-xs catcool-right">
													<?php echo form_checkbox("published_".((string)$_smarty_tpl->tpl_vars['item']->value['id']),$_smarty_tpl->tpl_vars['item']->value['published'] == STATUS_ON ? true : false,$_smarty_tpl->tpl_vars['item']->value['published'] == STATUS_ON ? true : false,array('id'=>('published_').($_smarty_tpl->tpl_vars['item']->value['id']),'data-id'=>$_smarty_tpl->tpl_vars['item']->value['id'],'data-published'=>$_smarty_tpl->tpl_vars['item']->value['published'],'class'=>'change_publish'));?>

													<span><label for="published_<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
"></label></span>
												</div>
											</div>
                                            </a>
										</div>
									<?php
$_smarty_tpl->tpl_vars['item'] = $foreach_0_item_sav['item'];
}
if ($foreach_0_item_sav['s_item']) {
$_smarty_tpl->tpl_vars['item'] = $foreach_0_item_sav['s_item'];
}
?>
								</div>
							<?php } else { ?>
								<div class="table-responsive">
									<table class="table table-striped table-hover table-bordered second">
										<thead>
											<tr class="text-center">
												<th width="50"><?php echo lang('f_id');?>
</th>
												<th>Thumb</th>
												<th>Album</th>
												<th><?php echo lang('f_published');?>
</th>
												<th width="160"><?php echo lang('f_function');?>
</th>
												<th width="50"><?php echo form_checkbox('manage_check_all');?>
</th>
											</tr>
										</thead>
										<tbody>
										<?php
$foreach_1_item_sav['s_item'] = isset($_smarty_tpl->tpl_vars['item']) ? $_smarty_tpl->tpl_vars['item'] : false;
$_from = $_smarty_tpl->tpl_vars['list']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['item']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
$foreach_1_item_sav['item'] = $_smarty_tpl->tpl_vars['item'];
?>
											<tr>
												<td class="text-center"><?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
</td>
												<td>
													<a href="<?php echo image_url($_smarty_tpl->tpl_vars['item']->value['image']);?>
" data-lightbox="photos">
														<img src="<?php echo image_url($_smarty_tpl->tpl_vars['item']->value['image']);?>
" class="img-thumbnail mr-1 img-fluid">
													</a>
												</td>
												<td>
													<a href="javascript:void(0);" onclick="Photo.loadView('<?php echo $_smarty_tpl->tpl_vars['manage_url']->value;?>
/edit/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
');" class="text-primary"><?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
</a><br />
													<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['description'],ENT_QUOTES,'UTF-8');?>

												</td>
												<td>
													<div class="switch-button switch-button-xs catcool-center">
														<?php echo form_checkbox("published_".((string)$_smarty_tpl->tpl_vars['item']->value['id']),$_smarty_tpl->tpl_vars['item']->value['published'] == STATUS_ON ? true : false,$_smarty_tpl->tpl_vars['item']->value['published'] == STATUS_ON ? true : false,array('id'=>('published_').($_smarty_tpl->tpl_vars['item']->value['id']),'data-id'=>$_smarty_tpl->tpl_vars['item']->value['id'],'data-published'=>$_smarty_tpl->tpl_vars['item']->value['published'],'class'=>'change_publish'));?>

														<span><label for="published_<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
"></label></span>
													</div>
												</td>
												<td class="text-center">
													<div class="btn-group ml-auto">
														<button type="button" onclick="Photo.loadView('<?php echo $_smarty_tpl->tpl_vars['manage_url']->value;?>
/edit/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
');" class="btn btn-sm btn-outline-light"><i class="fas fa-edit"></i></button>
														<button type="button" onclick="Photo.loadView('<?php echo $_smarty_tpl->tpl_vars['manage_url']->value;?>
/delete/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
');" class="btn btn-sm btn-outline-light"><i class="fas fa-trash-alt"></i></button>
													</div>
												</td>
												<td class="text-center"><?php echo form_checkbox('manage_ids[]',$_smarty_tpl->tpl_vars['item']->value['id']);?>
</td>
											</tr>
										<?php
$_smarty_tpl->tpl_vars['item'] = $foreach_1_item_sav['item'];
}
if ($foreach_1_item_sav['s_item']) {
$_smarty_tpl->tpl_vars['item'] = $foreach_1_item_sav['s_item'];
}
?>
										</tbody>
									</table>
								</div>
							<?php }?>
							<?php if (!empty($_smarty_tpl->tpl_vars['paging']->value['pagination_links'])) {?>
                                <?php echo $_smarty_tpl->getSubTemplate (get_theme_path('views/inc/paging.inc.tpl'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

							<?php }?>
						<?php } else { ?>
							<?php echo lang('data_empty');?>

						<?php }?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<input type="hidden" name="confirm_title" value="<?php echo lang("confirm_title");?>
">
<input type="hidden" name="confirm_content" value="<?php echo lang("confirm_delete");?>
">
<input type="hidden" name="confirm_btn_ok" value="<?php echo lang("btn_delete");?>
">
<input type="hidden" name="confirm_btn_close" value="<?php echo lang("btn_close");?>
">
<?php }
}
?>