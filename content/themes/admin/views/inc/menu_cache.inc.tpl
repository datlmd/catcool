{foreach $menu_admin as $key => $item}
	<li class="nav-item">
		<a class="nav-link {if $item.selected|strstr:$this->uri->segment(1,'none')}collapsed{/if}" href="{$item.slug}" {if $item.subs}data-toggle="collapse" aria-expanded="true"{/if} data-target="#submenu-{$key}" aria-controls="submenu-{$key}">{$item.title} <span class="badge badge-success">6</span></a>
		{if $item.subs}
			<div id="submenu-{$key}" class="collapse submenu {if $item.selected|strstr:$this->uri->segment(1,'none')}show{/if}" style="">
				<ul class="nav flex-column">
					{foreach $item.subs as $sub}
						<li class="nav-item">
							<a class="nav-link {if $sub.selected|strstr:$this->uri->segment(1,'none')}active{/if}" href="{base_url($sub.slug)}">{$sub.title}</a>
						</li>
					{/foreach}
				</ul>
			</div>
		{/if}
	</li>
{/foreach}