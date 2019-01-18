<?php /* Smarty version 3.1.28-dev/21, created on 2019-01-17 05:59:21
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/dev/catcool/application/modules/blog/views/post.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:7955062025c400ba9790410_20731838%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'de0d96416b28f2ea905b0f7a943580757a9cbc8e' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/dev/catcool/application/modules/blog/views/post.tpl',
      1 => 1547701160,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7955062025c400ba9790410_20731838',
  'variables' => 
  array (
    'post' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.28-dev/21',
  'unifunc' => 'content_5c400ba97f32e0_75324063',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5c400ba97f32e0_75324063')) {
function content_5c400ba97f32e0_75324063 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '7955062025c400ba9790410_20731838';
?>
<!DOCTYPE HTML>
<html lang="en-EN">
<head>
	<meta charset="UTF-8">
	<title><?php echo $_smarty_tpl->tpl_vars['post']->value->title();?>
</title>

	<style type="text/css">

		body {
			background-color: #fff;
			margin: 40px;
			font-family: Lucida Grande, Verdana, Sans-serif;
			font-size: 14px;
			color: #4F5155;
		}

		a {
			color: #003399;
			background-color: transparent;
			font-weight: normal;
		}

		h1 {
			color: #444;
			background-color: transparent;
			border-bottom: 1px solid #D0D0D0;
			font-size: 16px;
			font-weight: bold;
			margin: 24px 0 2px 0;
			padding: 5px 0 6px 0;
		}
	</style>
</head>
<body>
<h1><?php echo $_smarty_tpl->tpl_vars['post']->value['title'];?>
</h1>
<?php echo $_smarty_tpl->tpl_vars['post']->value->content();?>

</body>
</html><?php }
}
?>