<?php /* Smarty version 3.1.28-dev/21, created on 2019-10-29 16:21:56
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/dev/catcool/content/themes/admin/views/_partials/sidebar.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:15923654995db804b4a8fdb2_12445799%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '30825693dc93ce89c9d073b2c7cb3ddce33e5433' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/dev/catcool/content/themes/admin/views/_partials/sidebar.tpl',
      1 => 1568860785,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15923654995db804b4a8fdb2_12445799',
  'variables' => 
  array (
    'this' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.28-dev/21',
  'unifunc' => 'content_5db804b4bf2860_95688506',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5db804b4bf2860_95688506')) {
function content_5db804b4bf2860_95688506 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '15923654995db804b4a8fdb2_12445799';
?>
<div class="nav-left-sidebar sidebar-dark">
	<div class="menu-list">
		<nav class="navbar navbar-expand-lg navbar-light">
			
			<a class="d-xl-none d-lg-none" href="<?php echo base_url(CATCOOL_DASHBOARD);?>
"><?php echo lang('catcool_dashboard');?>
</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav flex-column">
					<li class="nav-divider">
						Menu
					</li>
					<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['this']->value->theme->theme_path('views/inc/menu_cache.inc.tpl'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

				</ul>
			</div>
		</nav>
	</div>
</div><?php }
}
?>