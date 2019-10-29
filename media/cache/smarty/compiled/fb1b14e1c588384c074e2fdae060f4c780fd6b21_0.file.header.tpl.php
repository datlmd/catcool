<?php /* Smarty version 3.1.28-dev/21, created on 2019-10-29 16:21:55
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/dev/catcool/content/themes/admin/views/_partials/header.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:3964330685db804b3b5ad36_21662012%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fb1b14e1c588384c074e2fdae060f4c780fd6b21' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/dev/catcool/content/themes/admin/views/_partials/header.tpl',
      1 => 1572227767,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3964330685db804b3b5ad36_21662012',
  'variables' => 
  array (
    'site_name' => 0,
    'value' => 0,
    'this' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.28-dev/21',
  'unifunc' => 'content_5db804b456fcb2_12642641',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5db804b456fcb2_12642641')) {
function content_5db804b456fcb2_12642641 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '3964330685db804b3b5ad36_21662012';
?>
<div class="dashboard-header">
	<nav class="navbar navbar-expand-lg bg-white fixed-top">
		<a class="navbar-brand" href="<?php echo site_url();?>
"><?php if ($_smarty_tpl->tpl_vars['site_name']->value) {
echo $_smarty_tpl->tpl_vars['site_name']->value;
} else { ?>Cat Cool<?php }?></a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse " id="navbarSupportedContent">
			<ul class="navbar-nav ml-auto navbar-right-top">
				<li class="nav-item">

					<div id="custom-search" class="top-search-bar">
						<?php if (is_multi_lang() == true) {?>
							<select onchange="javascript:window.location.href='<?php echo base_url();?>
languages/switch_lang/' + this.value;" class="form-control form-control-sm">
								<?php
$foreach_0_value_sav['s_item'] = isset($_smarty_tpl->tpl_vars['value']) ? $_smarty_tpl->tpl_vars['value'] : false;
$foreach_0_value_sav['s_key'] = isset($_smarty_tpl->tpl_vars['key']) ? $_smarty_tpl->tpl_vars['key'] : false;
$_from = get_list_lang();
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['value'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['value']->_loop = false;
$_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
$foreach_0_value_sav['item'] = $_smarty_tpl->tpl_vars['value'];
?>
									<option value=<?php echo $_smarty_tpl->tpl_vars['value']->value['code'];?>
  <?php if ($_smarty_tpl->tpl_vars['value']->value['code'] == $_smarty_tpl->tpl_vars['this']->value->session->userdata("site_lang")) {?>selected="selected"<?php }?>>
										<?php echo lang($_smarty_tpl->tpl_vars['value']->value['code']);?>

									</option>
								<?php
$_smarty_tpl->tpl_vars['value'] = $foreach_0_value_sav['item'];
}
if ($foreach_0_value_sav['s_item']) {
$_smarty_tpl->tpl_vars['value'] = $foreach_0_value_sav['s_item'];
}
if ($foreach_0_value_sav['s_key']) {
$_smarty_tpl->tpl_vars['key'] = $foreach_0_value_sav['s_key'];
}
?>
							</select>
						<?php }?>
					</div>
				</li>
				<li class="nav-item dropdown notification">
					<a class="nav-link nav-icons" href="#" id="navbarDropdownMenuLink1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-fw fa-bell"></i> <span class="indicator"></span></a>
					<ul class="dropdown-menu dropdown-menu-right notification-dropdown">
						<li>
							<div class="notification-title"> Notification</div>
							<div class="notification-list">
								<div class="list-group">
									<a href="#" class="list-group-item list-group-item-action active">
										<div class="notification-info">
											<div class="notification-list-user-img"><img src="<?php echo theme_url('assets/images/avatar-2.jpg');?>
" alt="" class="user-avatar-md rounded-circle"></div>
											<div class="notification-list-user-block"><span class="notification-list-user-name">Jeremy Rakestraw</span>accepted your invitation to join the team.
												<div class="notification-date">2 min ago</div>
											</div>
										</div>
									</a>
								</div>
							</div>
						</li>
						<li>
							<div class="list-footer"> <a href="#">View all notifications</a></div>
						</li>
					</ul>
				</li>
				<li class="nav-item dropdown connection">
					<a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-fw fa-th"></i> </a>
					<ul class="dropdown-menu dropdown-menu-right connection-dropdown">
						<li class="connection-list">
							<div class="row">
								<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
									<a href="#" class="connection-item"><img src="<?php echo theme_url('assets/images/github.png');?>
" alt="" > <span>Github</span></a>
								</div>
								<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
									<a href="#" class="connection-item"><img src="<?php echo theme_url('assets/images/dribbble.png');?>
" alt="" > <span>Dribbble</span></a>
								</div>
								<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
									<a href="#" class="connection-item"><img src="<?php echo theme_url('assets/images/dropbox.png');?>
" alt="" > <span>Dropbox</span></a>
								</div>
							</div>
							<div class="row">
								<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
									<a href="#" class="connection-item"><img src="<?php echo theme_url('assets/images/bitbucket.png');?>
" alt=""> <span>Bitbucket</span></a>
								</div>
								<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
									<a href="#" class="connection-item"><img src="<?php echo theme_url('assets/images/mail_chimp.png');?>
" alt="" ><span>Mail chimp</span></a>
								</div>
								<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
									<a href="#" class="connection-item"><img src="<?php echo theme_url('assets/images/slack.png');?>
" alt="" > <span>Slack</span></a>
								</div>
							</div>
						</li>
						<li>
							<div class="conntection-footer"><a href="#">More</a></div>
						</li>
					</ul>
				</li>
				<li class="nav-item dropdown nav-user">
					<a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?php echo theme_url('assets/images/avatar-1.jpg');?>
" alt="" class="user-avatar-md rounded-circle"></a>
					<div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">
						<div class="nav-user-info">
							<h5 class="mb-0 text-white nav-user-name">John Abraham </h5>
							<span class="status"></span><span class="ml-2">Available</span>
						</div>
						<a class="dropdown-item" href="#"><i class="fas fa-user mr-2"></i>Account</a>
						<a class="dropdown-item" href="#"><i class="fas fa-cog mr-2"></i>Setting</a>
						<a class="dropdown-item" href="<?php echo base_url('users/manage/logout');?>
"><i class="fas fa-power-off mr-2"></i><?php echo lang('logout');?>
</a>
					</div>
				</li>
			</ul>
		</div>
	</nav>
</div>
<?php }
}
?>