{foreach $menu_admin as $key => $item}
	<li class="nav-item ">
		<a class="nav-link" href="{$item.slug}" data-toggle="collapse" aria-expanded="true" data-target="#submenu-{$key}" aria-controls="submenu-{$key}"><i class="fa fa-fw fa-user-circle"></i>{$item.title} <span class="badge badge-success">6</span></a>
		{if $item.subs}
			<div id="submenu-{$key}" class="collapse submenu show" style="">
				<ul class="nav flex-column">
					{foreach $item.subs as $sub}
						<li class="nav-item">
							<a class="nav-link {if $this->uri->uri_string()|strstr:$sub.slug}active{/if}" href="{base_url($sub.slug)}">{$sub.title}</a>
						</li>
					{/foreach}
				</ul>
			</div>
		{/if}
	</li>
{/foreach}