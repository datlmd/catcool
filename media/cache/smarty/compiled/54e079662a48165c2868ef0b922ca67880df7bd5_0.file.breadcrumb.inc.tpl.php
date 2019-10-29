<?php /* Smarty version 3.1.28-dev/21, created on 2019-10-29 16:21:57
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/dev/catcool/content/themes/admin/views/inc/breadcrumb.inc.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:6049431725db804b57c5539_76374768%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '54e079662a48165c2868ef0b922ca67880df7bd5' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/dev/catcool/content/themes/admin/views/inc/breadcrumb.inc.tpl',
      1 => 1572227767,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6049431725db804b57c5539_76374768',
  'variables' => 
  array (
    'this' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.28-dev/21',
  'unifunc' => 'content_5db804b58bb390_98926881',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5db804b58bb390_98926881')) {
function content_5db804b58bb390_98926881 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '6049431725db804b57c5539_76374768';
?>
<div class="row mb-3">
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
		<div class="page-heade">
			<h2 class="pageheader-title float-left mr-3"><?php echo lang('heading_title');?>
</h2>
			<div class="page-breadcrumb float-left">
				<nav aria-label="breadcrumb">
					<?php echo $_smarty_tpl->tpl_vars['this']->value->breadcrumb->render();?>

				</nav>
			</div>
			<p class="pageheader-text"></p>
		</div>
	</div>
</div>
<?php }
}
?>