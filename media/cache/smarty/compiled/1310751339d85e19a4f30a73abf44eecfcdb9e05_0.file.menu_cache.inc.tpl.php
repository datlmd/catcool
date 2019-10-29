<?php /* Smarty version 3.1.28-dev/21, created on 2019-10-29 16:21:56
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/dev/catcool/content/themes/admin/views/inc/menu_cache.inc.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:17324080045db804b4cb3122_57826089%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1310751339d85e19a4f30a73abf44eecfcdb9e05' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/dev/catcool/content/themes/admin/views/inc/menu_cache.inc.tpl',
      1 => 1567567899,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17324080045db804b4cb3122_57826089',
  'variables' => 
  array (
    'menu_admin' => 0,
    'item' => 0,
    'this' => 0,
    'key' => 0,
    'sub' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.28-dev/21',
  'unifunc' => 'content_5db804b5023928_48681464',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5db804b5023928_48681464')) {
function content_5db804b5023928_48681464 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '17324080045db804b4cb3122_57826089';
$foreach_0_item_sav['s_item'] = isset($_smarty_tpl->tpl_vars['item']) ? $_smarty_tpl->tpl_vars['item'] : false;
$foreach_0_item_sav['s_key'] = isset($_smarty_tpl->tpl_vars['key']) ? $_smarty_tpl->tpl_vars['key'] : false;
$_from = $_smarty_tpl->tpl_vars['menu_admin']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['item']->_loop = false;
$_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
$foreach_0_item_sav['item'] = $_smarty_tpl->tpl_vars['item'];
?>
	<li class="nav-item">
        <a class="nav-link <?php if (strstr($_smarty_tpl->tpl_vars['item']->value['selected'],$_smarty_tpl->tpl_vars['this']->value->uri->segment(1,'none'))) {?>collapsed<?php }?>" href="<?php echo $_smarty_tpl->tpl_vars['item']->value['slug'];?>
" <?php if ($_smarty_tpl->tpl_vars['item']->value['subs']) {?>data-toggle="collapse" aria-expanded="true"<?php }?> data-target="#submenu-<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" aria-controls="submenu-<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
"><?php if (!empty($_smarty_tpl->tpl_vars['item']->value['icon'])) {?><i class="<?php echo $_smarty_tpl->tpl_vars['item']->value['icon'];?>
"></i><?php }
echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
 <span class="badge badge-success">6</span></a>
		<?php if ($_smarty_tpl->tpl_vars['item']->value['subs']) {?>
			<div id="submenu-<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" class="collapse submenu <?php if (strstr($_smarty_tpl->tpl_vars['item']->value['selected'],$_smarty_tpl->tpl_vars['this']->value->uri->segment(1,'none'))) {?>show<?php }?>" style="">
				<ul class="nav flex-column">
					<?php
$foreach_1_sub_sav['s_item'] = isset($_smarty_tpl->tpl_vars['sub']) ? $_smarty_tpl->tpl_vars['sub'] : false;
$_from = $_smarty_tpl->tpl_vars['item']->value['subs'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['sub'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['sub']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['sub']->value) {
$_smarty_tpl->tpl_vars['sub']->_loop = true;
$foreach_1_sub_sav['item'] = $_smarty_tpl->tpl_vars['sub'];
?>
						<li class="nav-item">
							<a class="nav-link <?php if (strstr($_smarty_tpl->tpl_vars['sub']->value['selected'],$_smarty_tpl->tpl_vars['this']->value->uri->segment(1,'none'))) {?>active<?php }?>" href="<?php echo base_url($_smarty_tpl->tpl_vars['sub']->value['slug']);?>
"><?php if (!empty($_smarty_tpl->tpl_vars['sub']->value['icon'])) {?><i class="<?php echo $_smarty_tpl->tpl_vars['sub']->value['icon'];?>
"></i><?php }
echo $_smarty_tpl->tpl_vars['sub']->value['title'];?>
</a>
						</li>
					<?php
$_smarty_tpl->tpl_vars['sub'] = $foreach_1_sub_sav['item'];
}
if ($foreach_1_sub_sav['s_item']) {
$_smarty_tpl->tpl_vars['sub'] = $foreach_1_sub_sav['s_item'];
}
?>
				</ul>
			</div>
		<?php }?>
	</li>
<?php
$_smarty_tpl->tpl_vars['item'] = $foreach_0_item_sav['item'];
}
if ($foreach_0_item_sav['s_item']) {
$_smarty_tpl->tpl_vars['item'] = $foreach_0_item_sav['s_item'];
}
if ($foreach_0_item_sav['s_key']) {
$_smarty_tpl->tpl_vars['key'] = $foreach_0_item_sav['s_key'];
}
}
}
?>