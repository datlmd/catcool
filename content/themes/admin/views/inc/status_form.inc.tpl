<div class="card bg-light">
	<div class="card-body">
		<div class="form-group row">
			<label class="col-4">Status</label>
			<div class="col-8">
                {if $edit_data.published eq true}
					<span class="badge-dot badge-success mr-1"></span>Active
				{else}
					<span class="badge-dot border border-dark mr-1"></span>Disabled
                {/if}
			</div>
		</div>
		<div class="form-group row">
			<label class="col-4">Created at</label>
			<div class="col-8">
                {$edit_data.ctime}
			</div>
		</div>
		<div class="form-group row">
			<label class="col-4">Updated at</label>
			<div class="col-8">
                {$edit_data.mtime}
			</div>
		</div>
	</div>
</div>
