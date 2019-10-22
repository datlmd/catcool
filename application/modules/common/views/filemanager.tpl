<div id="filemanager" class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="photoModalLabel">{$heading_title}</h5>
            <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </a>
        </div>
      <div class="modal-body">
      <div id="msg"></div>
        <div class="row">
          <div class="col-sm-5"><a href="{$parent}" data-toggle="tooltip" title="{$button_parent}" id="button-parent" class="btn btn-sm btn-light"><i class="fas fa-level-up-alt"></i></a> <a href="{$refresh}" data-toggle="tooltip" title="{$button_refresh}" id="button-refresh" class="btn btn-sm btn-light"><i class="fas fa-sync"></i></a>
            <button type="button" data-toggle="tooltip" title="{$button_upload}" id="button-upload" class="btn btn-sm btn-primary"><i class="fas fa-upload"></i></button>
            <button type="button" data-toggle="tooltip" title="{$button_folder}" id="button-folder" class="btn btn-sm btn-light"><i class="fas fa-folder"></i></button>
            <button type="button" data-toggle="tooltip" title="{$button_delete}" id="button-delete" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
          </div>
          <div class="col-sm-7">
            <div class="input-group">
              <input type="text" name="search" value="{$filter_name}" placeholder="{$entry_search}" class="form-control">
              <span class="input-group-btn">
              <button type="button" data-toggle="tooltip" title="{$button_search}" id="button-search" class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button>
              </span></div>
          </div>
        </div>
        <hr />
        {foreach array_chunk($images, 4) as $item}
        <div class="row">
          {foreach $item as $image}
          <div class="col-sm-3 col-xs-6 text-center">
            {if $image['type'] == 'directory'}
              <div class="text-center"><a href="{$image['href']}" class="directory" style="vertical-align: middle;"><i class="fas fa-folder fa-5x"></i></a></div>
              <label>
                <input type="checkbox" name="path[]" value="{$image['path']}" />
                {$image['name']}
              </label>
            {/if}
            {if $image['type'] == 'image'}
              <a href="{$image['href']}" class="thumbnail"><img src="{$image['thumb']}" alt="{$image['name']}" title="{$image['name']}" /></a>
              <label>
                <input type="checkbox" name="path[]" value="{$image['path']}" />
                {$image['name']}
              </label>
            {/if}
          </div>
          {/foreach}
        </div>
        <br />
        {/foreach}
      </div>
      <div class="modal-footer">{$pagination}</div>
    </div>
</div>
<script type="text/javascript"><!--
{if $target}
  $('a.thumbnail').on('click', function(e) {
      e.preventDefault();

      {if $thumb}
        $('#{{$thumb}}').find('img').attr('src', $(this).find('img').attr('src'));
      {/if}

      $('#{{$target}}').val($(this).parent().find('input').val());

      $('#modal-image').modal('hide');
  });
{/if}

$('a.directory').on('click', function(e) {
	e.preventDefault();
	$('#modal-image').load($(this).attr('href'));
});

$('.pagination a').on('click', function(e) {
	e.preventDefault();

	$('#modal-image').load($(this).attr('href'));
});

$('#button-parent').on('click', function(e) {
	e.preventDefault();

	$('#modal-image').load($(this).attr('href'));
});

$('#button-refresh').on('click', function(e) {
	e.preventDefault();

	$('#modal-image').load($(this).attr('href'));
});

$('input[name=\'search\']').on('keydown', function(e) {
	if (e.which == 13) {
		$('#button-search').trigger('click');
	}
});

$('#button-search').on('click', function(e) {
	var url = '{{site_url("common/filemanager")}}?directory={{$directory}}';

	var filter_name = $('input[name=\'search\']').val();

	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}

	{if $thumb}
	  url += '&thumb=' + '{{$thumb}}';
    {/if}

	{if $target}
	  url += '&target=' + '{{$target}}';
    {/if}

	$('#modal-image').load(url);
});
//--></script>
<script type="text/javascript"><!--
$('#button-upload').on('click', function() {
	$('#form-upload').remove();

	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file[]" value="" multiple="multiple" /></form>');

	$('#form-upload input[name=\'file[]\']').trigger('click');

	if (typeof timer != 'undefined') {
    	clearInterval(timer);
	}

	timer = setInterval(function() {
		if ($('#form-upload input[name=\'file[]\']').val() != '') {
			clearInterval(timer);

			$.ajax({
				url: '{{site_url("common/filemanager")}}/upload?directory={{$directory}}',
				type: 'post',
				dataType: 'json',
				data: new FormData($('#form-upload')[0]),
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function() {
					$('#button-upload i').replaceWith('<i class="fas fa-spinner fa-spin"></i>');
					$('#button-upload').prop('disabled', true);
				},
				complete: function() {
					$('#button-upload i').replaceWith('<i class="fas fa-upload"></i>');
					$('#button-upload').prop('disabled', false);
				},
				success: function(json) {
					$('#msg').html(json);
					if (json['error']) {
						$.notify(json['error'], {
							'type':'danger'
						});
						return false;
					}

					if (json['success']) {
						$.notify(json['success']);

						$('#button-refresh').trigger('click');
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}
	}, 500);
});

$('#button-folder').popover({
	html: true,
	placement: 'bottom',
	trigger: 'click',
	title: '{{$entry_folder}}',
	content: function() {
		html  = '<div class="input-group">';
		html += '  <input type="text" name="folder" value="" placeholder="{{$entry_folder}}" class="form-control">';
		html += '  <span class="input-group-btn"><button type="button" title="{{$button_folder}}" id="button-create" class="btn btn-sm btn-primary"><i class="fas fa-plus-circle"></i></button></span>';
		html += '</div>';

		return html;
	}
});

$('#button-folder').on('shown.bs.popover', function() {
	$('#button-create').on('click', function() {
		$.ajax({
			url: '{{site_url("common/filemanager")}}/folder?directory={{$directory}}',
			type: 'post',
			dataType: 'json',
			data: 'folder=' + encodeURIComponent($('input[name=\'folder\']').val()),
			beforeSend: function() {
				$('#button-create').prop('disabled', true);
			},
			complete: function() {
				$('#button-create').prop('disabled', false);
			},
			success: function(json) {
				if (json['error']) {
					$.notify(json['error'], {
						'type':'danger'
					});
					return false;
				}

				if (json['success']) {
					$.notify(json['success']);
					$('#button-refresh').trigger('click');
				}

				$('#button-folder').popover('dispose');
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				$('#button-folder').popover('dispose');
			}
		});
	});
});

$('#modal-image #button-delete').on('click', function(e) {
	if (confirm('{{$text_confirm}}')) {
		$.ajax({
			url: '{{site_url("common/filemanager")}}/delete',
			type: 'post',
			dataType: 'json',
			data: $('input[name^=\'path\']:checked'),
			beforeSend: function() {
				$('#button-delete').prop('disabled', true);
			},
			complete: function() {
				$('#button-delete').prop('disabled', false);
			},
			success: function(json) {
				if (json['error']) {
					alert(json['error']);
				}

				if (json['success']) {
					alert(json['success']);

					$('#button-refresh').trigger('click');
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}
});
//-->
</script>
