{assign var="menu_main" value=get_menu_by_position()}
<ul class="nav nav-pills" id="mainNav">
	{if !empty($menu_main)}
		{foreach $menu_main as $key => $item}
			<li class="dropdown">
				<a class="dropdown-item dropdown-toggle" href="{base_url({$item.detail.slug})}">
					{$item.detail.name}
				</a>
				{if $item.subs}
					<ul class="dropdown-menu">
						{foreach $item.subs as $sub}
							<li>
								<a class="dropdown-item" href="{base_url({$sub.detail.slug})}">
									{$sub.detail.name}
								</a>
							</li>
						{/foreach}
					</ul>
				{/if}
			</li>
		{/foreach}
	{/if}
</ul>