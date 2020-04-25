<div id="icon_picker_modal" class="modal fade">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="photoModalLabel"><i class="fas fa-fw fa-columns mr-2"></i>Icon Picker</h5>
				<a href="javascript:void(0);"  class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</a>
			</div>
			<div class="modal-body">
				<div class="px-2 mb-3"><input type="text" id="search_icon_picker" class="form-control" placeholder="Search icon"></div>
				<div>
					<ul class="icon-picker-list">
						<li>
							<a data-class="--item-- --activeState--" data-index="--index--" title="--item--">
								<span class="--item--"></span>
								<span class="name-class">--item--</span>
							</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="modal-footer">
				<div class="w-100 text-center">
					<button type="button" id="change_icon_picker" class="btn btn-sm btn-space btn-primary"><i class="fa fa-check-circle mr-2"></i>{lang('button_use_icon')}</button>
					<a href="javascript:void(0);" class="btn btn-sm btn-space btn-light" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true"><i class="fas fa-reply"></i> {lang('button_cancel')}</span>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>