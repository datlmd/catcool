<?php /* Smarty version 3.1.28-dev/21, created on 2019-10-29 16:23:36
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/dev/catcool/content/themes/admin/views/inc/categories/list_manage.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:6694706015db805185111e2_56415839%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'edb2a2fb4694ff5185ba492eca75d3073111da5a' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/dev/catcool/content/themes/admin/views/inc/categories/list_manage.tpl',
      1 => 1572233115,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6694706015db805185111e2_56415839',
  'variables' => 
  array (
    'category' => 0,
    'sub_val' => 0,
    'manage_url' => 0,
    'sub' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.28-dev/21',
  'unifunc' => 'content_5db80519234d13_11777848',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5db80519234d13_11777848')) {
function content_5db80519234d13_11777848 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '6694706015db805185111e2_56415839';
?>
<tr>
	<td class="text-center"><?php echo $_smarty_tpl->tpl_vars['category']->value['category_id'];?>
</td>
	<td>
        <?php if ($_smarty_tpl->tpl_vars['sub_val']->value) {
echo $_smarty_tpl->tpl_vars['sub_val']->value;
}?>
        <?php echo anchor(((string)$_smarty_tpl->tpl_vars['manage_url']->value)."/edit/".((string)$_smarty_tpl->tpl_vars['category']->value['category_id']),htmlspecialchars_decode($_smarty_tpl->tpl_vars['category']->value['detail']['title'], ENT_QUOTES),'class="text-primary"');?>

    </td>
	<td>
		<?php echo $_smarty_tpl->tpl_vars['category']->value['detail']['slug'];?>
<br />
		<em><?php echo $_smarty_tpl->tpl_vars['category']->value['detail']['description'];?>
</em>
	</td>
	<td class="text-center"><?php echo $_smarty_tpl->tpl_vars['category']->value['sort_order'];?>
</td>
	<td>
		<div class="switch-button switch-button-xs catcool-center">
			<?php echo form_checkbox("published_".((string)$_smarty_tpl->tpl_vars['category']->value['category_id']),STATUS_ON,$_smarty_tpl->tpl_vars['category']->value['published'] == STATUS_ON ? STATUS_ON : STATUS_OFF,array('id'=>('published_').($_smarty_tpl->tpl_vars['category']->value['category_id']),'data-id'=>$_smarty_tpl->tpl_vars['category']->value['category_id'],'data-published'=>$_smarty_tpl->tpl_vars['category']->value['published'],'class'=>'change_publish'));?>

			<span><label for="published_<?php echo $_smarty_tpl->tpl_vars['category']->value['category_id'];?>
"></label></span>
		</div>
	</td>
	<td class="text-center">
		<div class="btn-group ml-auto">
			<?php echo anchor((((string)$_smarty_tpl->tpl_vars['manage_url']->value)."/edit/".((string)$_smarty_tpl->tpl_vars['category']->value['category_id'])).(http_get_query()),'<i class="fas fa-edit"></i>',array('class'=>'btn btn-sm btn-outline-light','title'=>lang('btn_edit')));?>

			<?php echo anchor(((string)$_smarty_tpl->tpl_vars['manage_url']->value)."/delete/".((string)$_smarty_tpl->tpl_vars['category']->value['category_id']),'<i class="far fa-trash-alt"></i>',array('class'=>'btn btn-sm btn-outline-light','title'=>lang('btn_delete')));?>

		</div>
	</td>
	<td class="text-center"><?php echo form_checkbox('manage_ids[]',$_smarty_tpl->tpl_vars['category']->value['category_id']);?>
</td>
</tr>
<?php if (!empty($_smarty_tpl->tpl_vars['category']->value['subs'])) {?>
	<?php $_smarty_tpl->tpl_vars["sub_val"] = new Smarty_Variable(((string)$_smarty_tpl->tpl_vars['sub_val']->value)." - - ", null, 0);?>
	<?php
$foreach_0_sub_sav['s_item'] = isset($_smarty_tpl->tpl_vars['sub']) ? $_smarty_tpl->tpl_vars['sub'] : false;
$_from = $_smarty_tpl->tpl_vars['category']->value['subs'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['sub'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['sub']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['sub']->value) {
$_smarty_tpl->tpl_vars['sub']->_loop = true;
$foreach_0_sub_sav['item'] = $_smarty_tpl->tpl_vars['sub'];
?>
		<?php echo $_smarty_tpl->getSubTemplate (get_theme_path('views/inc/categories/list_manage.tpl'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('category'=>$_smarty_tpl->tpl_vars['sub']->value,'sub_val'=>$_smarty_tpl->tpl_vars['sub_val']->value), 0);
?>

	<?php
$_smarty_tpl->tpl_vars['sub'] = $foreach_0_sub_sav['item'];
}
if ($foreach_0_sub_sav['s_item']) {
$_smarty_tpl->tpl_vars['sub'] = $foreach_0_sub_sav['s_item'];
}
?>
<?php }

}
}
?>