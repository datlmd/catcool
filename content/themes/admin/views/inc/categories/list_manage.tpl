<tr>
	<td class="text-center">{$category.category_id}</td>
	<td>
        {if $sub_val}{$sub_val}{/if}
        {anchor("$manage_url/edit/`$category.category_id`", $category.detail.title|unescape:"html", 'class="text-primary"')}
    </td>
	<td>
		{$category.detail.slug}<br />
		<em>{$category.detail.description}</em>
	</td>
	<td class="text-center">{$category.sort_order}</td>
	<td>
		<div class="switch-button switch-button-xs catcool-center">
			{form_checkbox("published_`$category.category_id`", STATUS_ON, ($category.published eq STATUS_ON) ? STATUS_ON : STATUS_OFF, ['id' => 'published_'|cat:$category.category_id, 'data-id' => $category.category_id, 'data-published' => $category.published, 'class' => 'change_publish'])}
			<span><label for="published_{$category.category_id}"></label></span>
		</div>
	</td>
	<td class="text-center">
		<div class="btn-group ml-auto">
			{anchor("`$manage_url`/edit/`$category.category_id`"|cat:http_get_query(), '<i class="fas fa-edit"></i>', ['class' => 'btn btn-sm btn-outline-light', 'title' => lang('btn_edit')])}
			{anchor("`$manage_url`/delete/`$category.category_id`", '<i class="far fa-trash-alt"></i>', ['class' => 'btn btn-sm btn-outline-light', 'title' => lang('btn_delete')])}
		</div>
	</td>
	<td class="text-center">{form_checkbox('manage_ids[]', $category.category_id)}</td>
</tr>
{if !empty($category.subs)}
	{assign var="sub_val" value="`$sub_val` - - "}
	{foreach $category.subs as $sub}
		{include file=get_theme_path('views/inc/categories/list_manage.tpl') category=$sub sub_val=$sub_val}
	{/foreach}
{/if}
