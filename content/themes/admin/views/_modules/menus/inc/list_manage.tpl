<tr>
	<td class="text-center">{$menu.id}</td>
    <td>{if !empty($menu.icon)}<i class="{$menu.icon}"></i>{/if}</td>
	<td>
        {if $sub_val}{$sub_val}{/if}
        {anchor("$manage_url/edit/`$menu.id`", $menu.title|unescape:"html", 'class="text-primary"')}
    </td>
	<td>
		{$menu.slug}<br />
		<em>{$menu.description}</em>
	</td>
	<td class="text-center">{$menu.precedence}</td>
	<td>
		<div class="switch-button switch-button-xs catcool-center">
			{form_checkbox("published_`$menu.id`", ($menu.published eq STATUS_ON) ? true : false, ($menu.published eq STATUS_ON) ? true : false, ['id' => 'published_'|cat:$menu.id, 'data-id' => $menu.id, 'data-published' => $menu.published, 'class' => 'change_publish'])}
			<span><label for="published_{$menu.id}"></label></span>
		</div>
	</td>
	{if is_show_select_language()}<td class="text-center">{lang($menu.language)}</td>{/if}
	<td class="text-center">
		<div class="btn-group ml-auto">
			{anchor("`$manage_url`/edit/`$menu.id`", '<i class="fas fa-edit"></i>', ['class' => 'btn btn-sm btn-outline-light', 'title' => lang('btn_edit')])}
			{anchor("`$manage_url`/delete/`$menu.id`", '<i class="far fa-trash-alt"></i>', ['class' => 'btn btn-sm btn-outline-light', 'title' => lang('btn_delete')])}
		</div>
	</td>
	<td class="text-center">{form_checkbox('manage_ids[]', $menu.id)}</td>
</tr>
{if !empty($menu.subs)}
	{assign var="sub_val" value="`$sub_val` - - "}
	{foreach $menu.subs as $sub}
		{include file='./inc/list_manage.tpl' menu=$sub sub_val=$sub_val}
	{/foreach}
{/if}
