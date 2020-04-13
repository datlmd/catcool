<div class="nav-left-sidebar sidebar-dark">
	<div class="menu-list">
		<button type="button" class="btn btn-xs btn-light border-0 d-xl-block d-lg-block d-none navbar-light float-right btn-scroll" onclick="Catcool.scrollMenu();"><span class="navbar-toggler-icon"></span></button>
		<nav class="navbar navbar-expand-lg navbar-light">
			{*{anchor('admin', 'Bootstrap','class=d-xl-none d-lg-none')}*}
			<a class="d-xl-none d-lg-none logo-image-mobile" href="{site_url()}"><img src="{theme_url(config_item('image_logo_url'))}" alt="logo" ></a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu_admin" aria-controls="menu_admin" aria-expanded="false" aria-label="Menu Admin">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="menu_admin">
				<ul class="navbar-nav flex-column">
					<li class="nav-divider d-xl-block d-lg-block d-none pb-3"></li>
					<li class="nav-divider d-xl-none d-lg-none pb-0">
						<span class="text-secondary">{$this->session->userdata('full_name')} ({$this->session->userdata('username')})</span>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{base_url(CATCOOL_DASHBOARD)}"><i class="fas fa-home"></i>{lang('catcool_dashboard')}</a>
					</li>
					{include file=$this->theme->theme_path('views/inc/menu_cache.inc.tpl')}
					<li class="nav-item d-xl-none d-lg-none">
						<a class="nav-link" href="{base_url('users/manage/edit/'|cat:$this->session->userdata('user_id'))}"><i class="fas fa-user"></i>{lang('text_profile')}</a>
					</li>
					<li class="nav-item d-xl-none d-lg-none">
						<a class="nav-link" href="{base_url('users/manage/logout')}"><i class="fas fa-power-off"></i>{lang('logout')}</a>
					</li>
				</ul>
			</div>
		</nav>
	</div>
</div>