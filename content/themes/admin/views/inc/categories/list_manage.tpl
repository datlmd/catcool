<tr>
	<td class="text-center">{$category.id}</td>
	<td>
        {if $sub_val}{$sub_val}{/if}
        {anchor("$manage_url/edit/`$category.id`", $category.title|unescape:"html", 'class="text-primary"')}
    </td>
	<td>
		{$category.slug}<br />
		<em>{$category.description}</em>
	</td>
	<td>{$category.context}</td>
	<td class="text-center">{$category.precedence}</td>
	<td>
		<div class="switch-button switch-button-xs catcool-center">
			{form_checkbox("published_`$category.id`", ($category.published eq STATUS_ON) ? true : false, ($category.published eq STATUS_ON) ? true : false, ['id' => 'published_'|cat:$category.id, 'data-id' => $category.id, 'data-published' => $category.published, 'class' => 'change_publish'])}
			<span><label for="published_{$category.id}"></label></span>
		</div>
	</td>
	{if is_show_select_language()}<td class="text-center">{lang($category.language)}</td>{/if}
	<td class="text-center">
		<div class="btn-group ml-auto">
			{anchor("`$manage_url`/edit/`$category.id`", '<i class="fas fa-edit"></i>', ['class' => 'btn btn-sm btn-outline-light', 'title' => lang('btn_edit')])}
			{anchor("`$manage_url`/delete/`$category.id`", '<i class="far fa-trash-alt"></i>', ['class' => 'btn btn-sm btn-outline-light', 'title' => lang('btn_delete')])}
		</div>
	</td>
	<td class="text-center">{form_checkbox('manage_ids[]', $category.id)}</td>
</tr>
{if !empty($category.subs)}
	{assign var="sub_val" value="`$sub_val` - - "}
	{foreach $category.subs as $sub}
		{include file=get_theme_path('views/inc/categories/list_manage.tpl') category=$sub sub_val=$sub_val}
	{/foreach}
{/if}
