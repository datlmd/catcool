<?php /* Smarty version 3.1.28-dev/21, created on 2019-10-29 16:23:34
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/dev/catcool/content/themes/admin/views/_modules/articles/categories/list.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:8512967535db80516492706_15824933%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '989dd157f9fcfc900e132265dfae6a58cd1eb64c' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/dev/catcool/content/themes/admin/views/_modules/articles/categories/list.tpl',
      1 => 1572231028,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8512967535db80516492706_15824933',
  'variables' => 
  array (
    'manage_name' => 0,
    'this' => 0,
    'manage_url' => 0,
    'list' => 0,
    'item' => 0,
    'paging' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.28-dev/21',
  'unifunc' => 'content_5db80517da49f1_72559860',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5db80517da49f1_72559860')) {
function content_5db80517da49f1_72559860 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '8512967535db80516492706_15824933';
echo form_hidden('manage',$_smarty_tpl->tpl_vars['manage_name']->value);?>

<div class="container-fluid  dashboard-content">
    <?php echo $_smarty_tpl->getSubTemplate (get_theme_path('views/inc/breadcrumb.inc.tpl'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="card">
				<div class="card-body">
					<div class="table-responsive">
						<?php echo form_open(uri_string(),array('id'=>'filter_validationform','method'=>'get'));?>

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

									</td>
								</tr>
							</table>
						<?php echo form_close();?>

					</div>
					<button type="submit" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="<?php echo lang('filter_submit');?>
" data-original-title="<?php echo lang('filter_submit');?>
"><i class="fas fa-search"></i></button>
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
							<h5 class="mb-0 mt-1 ml-2"><i class="fas fa-list mr-2"></i><?php echo lang('text_list');?>
</h5>
						</div>
						<div class="col-4 text-right">
							<span id="delete_multiple" class="btn btn-sm btn-danger" style="display: none;" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo lang('btn_delete');?>
"><i class="far fa-trash-alt"></i></span>
							<a href="<?php echo $_smarty_tpl->tpl_vars['manage_url']->value;?>
/add<?php echo http_get_query();?>
" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo lang('btn_add');?>
"><i class="fas fa-plus"></i></a>
						</div>
					</div>
				</div>
				<div class="card-body">
					<?php if (!empty($_smarty_tpl->tpl_vars['list']->value)) {?>
						<div class="table-responsive">
							<table class="table table-striped table-hover table-bordered second">
								<thead>
									<tr class="text-center">
										<th width="50"><?php echo lang('f_id');?>
</th>
										<th><?php echo lang('f_title');?>
</th>
										<th><?php echo lang('f_description');?>
</th>
										<th><?php echo lang('f_sort_order');?>
</th>
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
                                    <?php echo $_smarty_tpl->getSubTemplate (get_theme_path('views/inc/categories/list_manage.tpl'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('category'=>$_smarty_tpl->tpl_vars['item']->value), 0);
?>

								<?php
$_smarty_tpl->tpl_vars['item'] = $foreach_0_item_sav['item'];
}
if ($foreach_0_item_sav['s_item']) {
$_smarty_tpl->tpl_vars['item'] = $foreach_0_item_sav['s_item'];
}
?>
								</tbody>
							</table>
						</div>
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
<?php }
}
?>