<div class="container-fluid  dashboard-content">
    {include file=get_theme_path('views/inc/breadcrumb.inc.tpl')}
	<div class="row">
		<div class="col-xl-2 col-lg-2 col-md-3 col-sm-12 col-12">
			{include file=get_theme_path('views/inc/utilities_menu.inc.tpl') active=file_browser}
		</div>
		<div class="col-xl-10 col-lg-10 col-md-9 col-sm-12 col-12">
			<div class="card">
				<h5 class="card-header"><i class="fas fa-folder-open mr-2"></i>File Browser</h5>
				<div class="card-body">
					<div class="mb-3">
						<a href="{base_url($manage_url|cat:"/list_file?dir=content/themes")}" class="btn btn-sm btn-light {if $dir eq 'content/themes'}active{/if}">Themes</a>
						<a href="{base_url($manage_url|cat:"/list_file?dir=media")}" class="btn btn-sm btn-light mx-2 {if $dir eq 'media'}active{/if}">Media</a>
						<a href="{base_url($manage_url|cat:"/list_file?dir=content/language")}" class="btn btn-sm btn-light {if $dir eq 'content/language'}active{/if}">Language</a>
					</div>
					<!-- HTML -->
					<div id="fba" data-host="{base_url()}" data-api="{$api}" data-route="{$route}"></div>
				</div>
			</div>
		</div>
	</div>
</div>
