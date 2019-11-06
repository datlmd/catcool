<tr>
	<td class="text-center">{$menu.menu_id}</td>
    <td>{if !empty($menu.icon)}<i class="{$menu.icon}"></i>{/if}</td>
	<td>
		<a href="{$manage_url}/edit/{$menu.menu_id}" class="text-primary">
			{if !empty($parent_name)}{$parent_name} > {/if}
			{$menu.detail.title}
		</a>
	</td>
	<td>
		{$menu.slug}<br />
		<em>{$menu.detail.description}</em>
	</td>
	<td class="text-center">{$menu.sort_order}</td>
	<td>
		<div class="switch-button switch-button-xs catcool-center">
			{form_checkbox("published_`$menu.menu_id`", ($menu.published eq STATUS_ON) ? true : false, ($menu.published eq STATUS_ON) ? true : false, ['id' => 'published_'|cat:$menu.menu_id, 'data-id' => $menu.menu_id, 'data-published' => $menu.published, 'class' => 'change_publish'])}
			<span><label for="published_{$menu.menu_id}"></label></span>
		</div>
	</td>
	<td class="text-center">
		<div class="btn-group ml-auto">
			{anchor("`$manage_url`/edit/`$menu.menu_id`", '<i class="fas fa-edit"></i>', ['class' => 'btn btn-sm btn-outline-light', 'title' => lang('button_edit')])}
			{anchor("`$manage_url`/delete/`$menu.menu_id`", '<i class="far fa-trash-alt"></i>', ['class' => 'btn btn-sm btn-outline-light', 'title' => lang('button_delete')])}
		</div>
	</td>
	<td class="text-center">{form_checkbox('manage_ids[]', $menu.menu_id)}</td>
</tr>
{if !empty($menu.subs)}
	{if !empty($parent_name)}
		{assign var="parent_name" value="`$parent_name` > `$menu.detail.title`"}
	{else}
		{assign var="parent_name" value="`$menu.detail.title`"}
	{/if}
	{foreach $menu.subs as $sub}
		{include file='./inc/list_manage.tpl' menu=$sub parent_name=$parent_name}
	{/foreach}
{/if}
