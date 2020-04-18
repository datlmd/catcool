<div class="nav-left-sidebar sidebar-dark {if empty(config_item('enable_scroll_menu_admin'))}nav-left-sidebar-scrolled{/if}">
	<div class="menu-list">
		<button type="button" class="btn btn-xs btn-light border-0 d-xl-block d-lg-block d-none navbar-light btn-scroll" onclick="Catcool.scrollMenu();"><span class="navbar-toggler-icon"></span></button>
		{* su dung cho thiet bi di dong *}
		<nav class="navbar navbar-expand-lg navbar-light d-xl-none d-lg-none">
			{*{anchor('admin', 'Bootstrap','class=d-xl-none d-lg-none')}*}
			<a class="d-xl-none d-lg-none logo-image-mobile" href="{site_url()}"><img src="{img_url(config_item('image_logo_url'), 'common')}" alt="logo" ></a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu_admin" aria-controls="menu_admin" aria-expanded="false" aria-label="Menu Admin">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="menu_admin">
				<ul class="navbar-nav flex-column">
					<li class="nav-divider pb-0">
						<span class="badge badge-info"><i class="fas fa-user-circle mr-1"></i>{$this->session->userdata('full_name')} ({$this->session->userdata('username')})</span>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{base_url(CATCOOL_DASHBOARD)}"><i class="fas fa-home"></i>{lang('catcool_dashboard')}</a>
					</li>
					{foreach $menu_admin as $key => $item}
						<li class="nav-item">
							<a class="nav-link {if $item.selected|strstr:$this->uri->segment(1,'none')}collapsed active show{/if}" href="{$item.slug}" {if $item.subs}data-toggle="collapse" aria-expanded="true"{/if} data-target="#submenu-{$key}" aria-controls="submenu-{$key}">
								{if !empty($item.icon)}<i class="{$item.icon}"></i>{/if}{$item.detail.name}
							</a>
							{if $item.subs}
								<div id="submenu-{$key}" class="collapse submenu {if $item.selected|strstr:$this->uri->segment(1,'none')}show{/if}" style="">
									<ul class="nav flex-column">
										{foreach $item.subs as $sub}
											<li class="nav-item">
												<a class="nav-link {if $sub.selected|strstr:$this->uri->segment(1,'none')}active{/if}" href="{base_url($sub.slug)}"><i class="fas fa-angle-double-right mr-2"></i>{$sub.detail.name}</a>
											</li>
										{/foreach}
									</ul>
								</div>
							{/if}
						</li>
					{/foreach}
					<li class="nav-item">
						<a class="nav-link" href="{base_url('users/manage/edit/'|cat:$this->session->userdata('user_id'))}"><i class="fas fa-user"></i>{lang('text_profile')}</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{base_url('users/manage/logout')}"><i class="fas fa-power-off"></i>{lang('logout')}</a>
					</li>
				</ul>
			</div>
		</nav>
		{* end su dung cho thiet bi di dong *}
		{* su dung cho pc *}
		<div class="d-xl-block d-lg-block d-none">
			{foreach $menu_admin as $key => $item}
				<a class="{if $item.selected|strstr:$this->uri->segment(1,'none')}active{/if}" href="{$item.slug}" {if $item.subs}data-toggle="modal" data-target="#popup_menu_left_{$key}"{/if}>
					<div class="menu-left-icon">
						<i class="{if !empty($item.icon)}{$item.icon}{else}fas fa-angle-double-right{/if}"></i>
						<div class="tooltiptext">{$item.detail.name}</div>
					</div>
				</a>
			{/foreach}
		</div>
	</div>
</div>
<!-- Modal popup submenu -->
{foreach $menu_admin as $key => $item}
	{if $item.subs}
		<div class="modal fade popup-sub-menu-left" id="popup_menu_left_{$key}" tabindex="-1" role="dialog" aria-labelledby="modal_label_{$key}" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="modal_label_{$key}"><i class="mr-2 {if !empty($item.icon)}{$item.icon}{else}fas fa-angle-double-right{/if}"></i>{$item.detail.name}</h5>
						<a href="#" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</a>
					</div>
					<div class="modal-body">
						<div class="row">
						{foreach $item.subs as $sub}
							<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-6 text-center mt-2 mb-4">
								<div class="menu-sub-left-icon">
									<a class=" {if $sub.selected|strstr:$this->uri->segment(1,'none')}active{/if}" href="{base_url($sub.slug)}">
										<i class="{if !empty($sub.icon)}{$sub.icon}{else}fas fa-angle-double-right{/if}"></i>
									</a>
								</div>
								<p class="text-dark mt-2">{$sub.detail.name}</p>
							</div>
						{/foreach}
						</div>
					</div>
				</div>
			</div>
		</div>
	{/if}
{/foreach}
