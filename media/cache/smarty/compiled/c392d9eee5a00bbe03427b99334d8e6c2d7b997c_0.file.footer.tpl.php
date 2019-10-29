<?php /* Smarty version 3.1.28-dev/21, created on 2019-10-29 16:21:56
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/dev/catcool/content/themes/admin/views/_partials/footer.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:2518271065db804b46c8d02_16639250%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c392d9eee5a00bbe03427b99334d8e6c2d7b997c' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/dev/catcool/content/themes/admin/views/_partials/footer.tpl',
      1 => 1547979833,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2518271065db804b46c8d02_16639250',
  'has_nocache_code' => false,
  'version' => '3.1.28-dev/21',
  'unifunc' => 'content_5db804b498ea95_90090429',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5db804b498ea95_90090429')) {
function content_5db804b498ea95_90090429 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '2518271065db804b46c8d02_16639250';
?>
<div class="footer">
	<div class="container-fluid">
		<div class="row">
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
				Copyright © <?php echo date('Y');?>
 CatCool. All rights reserved. Dashboard by <a href="https://colorlib.com/wp/">Dat Le</a>.
				<br/>Page rendered in: <strong>___theme_time___</strong> seconds.
			</div>
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
				<div class="text-md-right footer-links d-none d-sm-block">
					<a href="javascript: void(0);">About</a>
					<a href="javascript: void(0);">Support</a>
					<a href="javascript: void(0);">Contact Us</a>
				</div>
			</div>
		</div>
	</div>
</div><?php }
}
?>