{*<div class="loading"><span class="dashboard-spinner spinner-xs"></span></div>*}
<div class="dashboard-main-wrapper">
	{$header}
	{$sidebar}
	<div class="dashboard-wrapper {if empty(config_item('enable_scroll_menu_admin'))}nav-left-sidebar-content-scrolled{/if}">
		{$content}
		{$footer}
	</div>
</div>
{print_flash_alert()}