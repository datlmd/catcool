<?php /* Smarty version 3.1.28-dev/21, created on 2019-10-29 16:21:57
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/dev/catcool/content/themes/admin/views/_layouts/default.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:15164025915db804b5c31b88_48568695%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b386e7f29f9e938bdd3af7c6fc81771ee5a19610' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/dev/catcool/content/themes/admin/views/_layouts/default.tpl',
      1 => 1568856450,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15164025915db804b5c31b88_48568695',
  'variables' => 
  array (
    'header' => 0,
    'sidebar' => 0,
    'content' => 0,
    'footer' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.28-dev/21',
  'unifunc' => 'content_5db804b5d30944_76980760',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5db804b5d30944_76980760')) {
function content_5db804b5d30944_76980760 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '15164025915db804b5c31b88_48568695';
?>

<div class="dashboard-main-wrapper">
	<?php echo $_smarty_tpl->tpl_vars['header']->value;?>

	<?php echo $_smarty_tpl->tpl_vars['sidebar']->value;?>

	<div class="dashboard-wrapper">
		<?php echo $_smarty_tpl->tpl_vars['content']->value;?>

		<?php echo $_smarty_tpl->tpl_vars['footer']->value;?>

	</div>
</div>
<?php echo print_flash_alert();

}
}
?>