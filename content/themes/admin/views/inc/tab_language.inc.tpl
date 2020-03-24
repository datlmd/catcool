{if count($languages) > 1}
	<ul class="nav nav-tabs border-bottom pl-3" id="myTab" role="tablist">
		{foreach $languages as $language}
			<li class="nav-item">
				<a class="nav-link p-2 pl-3 pr-3 {if $language.active}active{/if}" id="language_tab_{$language.id}" data-toggle="tab" href="#lanuage_content_{$language.id}" role="tab" aria-controls="lanuage_content_{$language.id}" aria-selected="{if $language.active}true{else}false{/if}">{$language.icon}{$language.name}</a>
			</li>
		{/foreach}
	</ul>
{/if}