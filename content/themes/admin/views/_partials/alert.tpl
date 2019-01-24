<div class="container-fluid  dashboard-content">
<div class="card">
	<div class="card-body">
		<div class="alert alert-{if $type}{$type}{else}info{/if}">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			{$message}
		</div>
	</div>
</div>
</div>