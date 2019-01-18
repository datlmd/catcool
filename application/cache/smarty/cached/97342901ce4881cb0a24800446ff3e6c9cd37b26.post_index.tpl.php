<?php
/*%%SmartyHeaderCode:16470333325c400739435fe1_08888756%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '97342901ce4881cb0a24800446ff3e6c9cd37b26' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/dev/catcool/application/modules/blog/views/post_index.tpl',
      1 => 1547700015,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16470333325c400739435fe1_08888756',
  'tpl_function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => '3.1.28-dev/21',
  'unifunc' => 'content_5c4007395ef3d7_05260869',
  'cache_lifetime' => 3600,
),true);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5c4007395ef3d7_05260869')) {
function content_5c4007395ef3d7_05260869 ($_smarty_tpl) {
?>
<!DOCTYPE HTML>
<html lang="en-EN">
<head>
	<meta charset="UTF-8">
	<title>Post example</title>
	
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
	<h1>Post example</h1>
	<p>Before using this example you must configure your database in file <em>application/config/database.php</em>, then you can follow this steps:</p>
	<ol>
		<li><a href="http://localhost/dev/catcool/blog/posts/install">Install post schema</a></li>
		<li><a href="http://localhost/dev/catcool/blog/posts/create">Create a post</a></li>
		<li><a href="http://localhost/dev/catcool/blog/posts/find/1">View post</a></li>
		<li><a href="http://localhost/dev/catcool/blog/posts/remove/1">Remove post</a></li>
	</ol>
</body>
</html><?php }
}
?>