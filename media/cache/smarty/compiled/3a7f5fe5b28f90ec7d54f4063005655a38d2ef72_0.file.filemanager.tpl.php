<?php /* Smarty version 3.1.28-dev/21, created on 2019-10-29 16:27:19
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/dev/catcool/application/modules/common/views/filemanager.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:16000810805db805f7ec73b1_07567335%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3a7f5fe5b28f90ec7d54f4063005655a38d2ef72' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/dev/catcool/application/modules/common/views/filemanager.tpl',
      1 => 1572227767,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16000810805db805f7ec73b1_07567335',
  'variables' => 
  array (
    'heading_title' => 0,
    'parent' => 0,
    'button_parent' => 0,
    'refresh' => 0,
    'button_refresh' => 0,
    'button_upload' => 0,
    'button_folder' => 0,
    'button_delete' => 0,
    'filter_name' => 0,
    'entry_search' => 0,
    'button_search' => 0,
    'images' => 0,
    'item' => 0,
    'image' => 0,
    'pagination' => 0,
    'target' => 0,
    'thumb' => 0,
    'directory' => 0,
    'entry_folder' => 0,
    'text_confirm' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.28-dev/21',
  'unifunc' => 'content_5db805f9551dc6_31690530',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5db805f9551dc6_31690530')) {
function content_5db805f9551dc6_31690530 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '16000810805db805f7ec73b1_07567335';
?>
<div id="filemanager" class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="photoModalLabel"><?php echo $_smarty_tpl->tpl_vars['heading_title']->value;?>
</h5>
            <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </a>
        </div>
      <div class="modal-body">
      <div id="msg"></div>
        <div class="row">
          <div class="col-sm-5"><a href="<?php echo $_smarty_tpl->tpl_vars['parent']->value;?>
" data-toggle="tooltip" title="<?php echo $_smarty_tpl->tpl_vars['button_parent']->value;?>
" id="button-parent" class="btn btn-sm btn-light"><i class="fas fa-level-up-alt"></i></a> <a href="<?php echo $_smarty_tpl->tpl_vars['refresh']->value;?>
" data-toggle="tooltip" title="<?php echo $_smarty_tpl->tpl_vars['button_refresh']->value;?>
" id="button-refresh" class="btn btn-sm btn-light"><i class="fas fa-sync"></i></a>
            <button type="button" data-toggle="tooltip" title="<?php echo $_smarty_tpl->tpl_vars['button_upload']->value;?>
" id="button-upload" class="btn btn-sm btn-primary"><i class="fas fa-upload"></i></button>
            <button type="button" data-toggle="tooltip" title="<?php echo $_smarty_tpl->tpl_vars['button_folder']->value;?>
" id="button-folder" class="btn btn-sm btn-light"><i class="fas fa-folder"></i></button>
            <button type="button" data-toggle="tooltip" title="<?php echo $_smarty_tpl->tpl_vars['button_delete']->value;?>
" id="button-delete" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
          </div>
          <div class="col-sm-7">
            <div class="input-group">
              <input type="text" name="search" value="<?php echo $_smarty_tpl->tpl_vars['filter_name']->value;?>
" placeholder="<?php echo $_smarty_tpl->tpl_vars['entry_search']->value;?>
" class="form-control">
              <span class="input-group-btn">
              <button type="button" data-toggle="tooltip" title="<?php echo $_smarty_tpl->tpl_vars['button_search']->value;?>
" id="button-search" class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button>
              </span></div>
          </div>
        </div>
        <hr />
        <?php
$foreach_0_item_sav['s_item'] = isset($_smarty_tpl->tpl_vars['item']) ? $_smarty_tpl->tpl_vars['item'] : false;
$_from = array_chunk($_smarty_tpl->tpl_vars['images']->value,4);
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['item']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
$foreach_0_item_sav['item'] = $_smarty_tpl->tpl_vars['item'];
?>
        <div class="row">
          <?php
$foreach_1_image_sav['s_item'] = isset($_smarty_tpl->tpl_vars['image']) ? $_smarty_tpl->tpl_vars['image'] : false;
$_from = $_smarty_tpl->tpl_vars['item']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['image'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['image']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['image']->value) {
$_smarty_tpl->tpl_vars['image']->_loop = true;
$foreach_1_image_sav['item'] = $_smarty_tpl->tpl_vars['image'];
?>
          <div class="col-sm-3 col-xs-6 text-center">
            <?php if ($_smarty_tpl->tpl_vars['image']->value['type'] == 'directory') {?>
              <div class="text-center"><a href="<?php echo $_smarty_tpl->tpl_vars['image']->value['href'];?>
" class="directory" style="vertical-align: middle;"><i class="fas fa-folder fa-5x"></i></a></div>
              <label>
                <input type="checkbox" name="path[]" value="<?php echo $_smarty_tpl->tpl_vars['image']->value['path'];?>
" />
                <?php echo $_smarty_tpl->tpl_vars['image']->value['name'];?>

              </label>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['image']->value['type'] == 'image') {?>
              <a href="<?php echo $_smarty_tpl->tpl_vars['image']->value['href'];?>
" class="thumbnail"><img src="<?php echo $_smarty_tpl->tpl_vars['image']->value['thumb'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['image']->value['name'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['image']->value['name'];?>
" /></a>
              <label>
                <input type="checkbox" name="path[]" value="<?php echo $_smarty_tpl->tpl_vars['image']->value['path'];?>
" />
                <?php echo $_smarty_tpl->tpl_vars['image']->value['name'];?>

              </label>
            <?php }?>
          </div>
          <?php
$_smarty_tpl->tpl_vars['image'] = $foreach_1_image_sav['item'];
}
if ($foreach_1_image_sav['s_item']) {
$_smarty_tpl->tpl_vars['image'] = $foreach_1_image_sav['s_item'];
}
?>
        </div>
        <br />
        <?php
$_smarty_tpl->tpl_vars['item'] = $foreach_0_item_sav['item'];
}
if ($foreach_0_item_sav['s_item']) {
$_smarty_tpl->tpl_vars['item'] = $foreach_0_item_sav['s_item'];
}
?>
      </div>
      <div class="modal-footer"><?php echo $_smarty_tpl->tpl_vars['pagination']->value;?>
</div>
    </div>
</div>
<?php echo '<script'; ?>
 type="text/javascript"><!--
<?php if ($_smarty_tpl->tpl_vars['target']->value) {?>
  $('a.thumbnail').on('click', function(e) {
      e.preventDefault();

      <?php if ($_smarty_tpl->tpl_vars['thumb']->value) {?>
        $('#<?php ob_start();
echo $_smarty_tpl->tpl_vars['thumb']->value;
$_tmp1=ob_get_clean();
echo $_tmp1;?>
').find('img').attr('src', $(this).find('img').attr('src'));
      <?php }?>

      $('#<?php ob_start();
echo $_smarty_tpl->tpl_vars['target']->value;
$_tmp2=ob_get_clean();
echo $_tmp2;?>
').val($(this).parent().find('input').val());

      $('#modal-image').modal('hide');
  });
<?php }?>

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
	var url = '<?php ob_start();
echo site_url("common/filemanager");
$_tmp3=ob_get_clean();
echo $_tmp3;?>
?directory=<?php ob_start();
echo $_smarty_tpl->tpl_vars['directory']->value;
$_tmp4=ob_get_clean();
echo $_tmp4;?>
';

	var filter_name = $('input[name=\'search\']').val();

	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}

	<?php if ($_smarty_tpl->tpl_vars['thumb']->value) {?>
	  url += '&thumb=' + '<?php ob_start();
echo $_smarty_tpl->tpl_vars['thumb']->value;
$_tmp5=ob_get_clean();
echo $_tmp5;?>
';
    <?php }?>

	<?php if ($_smarty_tpl->tpl_vars['target']->value) {?>
	  url += '&target=' + '<?php ob_start();
echo $_smarty_tpl->tpl_vars['target']->value;
$_tmp6=ob_get_clean();
echo $_tmp6;?>
';
    <?php }?>

	$('#modal-image').load(url);
});
//--><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript"><!--
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
				url: '<?php ob_start();
echo site_url("common/filemanager");
$_tmp7=ob_get_clean();
echo $_tmp7;?>
/upload?directory=<?php ob_start();
echo $_smarty_tpl->tpl_vars['directory']->value;
$_tmp8=ob_get_clean();
echo $_tmp8;?>
',
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
	title: '<?php ob_start();
echo $_smarty_tpl->tpl_vars['entry_folder']->value;
$_tmp9=ob_get_clean();
echo $_tmp9;?>
',
	content: function() {
		html  = '<div class="input-group">';
		html += '  <input type="text" name="folder" value="" placeholder="<?php ob_start();
echo $_smarty_tpl->tpl_vars['entry_folder']->value;
$_tmp10=ob_get_clean();
echo $_tmp10;?>
" class="form-control">';
		html += '  <span class="input-group-btn"><button type="button" title="<?php ob_start();
echo $_smarty_tpl->tpl_vars['button_folder']->value;
$_tmp11=ob_get_clean();
echo $_tmp11;?>
" id="button-create" class="btn btn-sm btn-primary"><i class="fas fa-plus-circle"></i></button></span>';
		html += '</div>';

		return html;
	}
});

$('#button-folder').on('shown.bs.popover', function() {
	$('#button-create').on('click', function() {
		$.ajax({
			url: '<?php ob_start();
echo site_url("common/filemanager");
$_tmp12=ob_get_clean();
echo $_tmp12;?>
/folder?directory=<?php ob_start();
echo $_smarty_tpl->tpl_vars['directory']->value;
$_tmp13=ob_get_clean();
echo $_tmp13;?>
',
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
	if (confirm('<?php ob_start();
echo $_smarty_tpl->tpl_vars['text_confirm']->value;
$_tmp14=ob_get_clean();
echo $_tmp14;?>
')) {
		$.ajax({
			url: '<?php ob_start();
echo site_url("common/filemanager");
$_tmp15=ob_get_clean();
echo $_tmp15;?>
/delete',
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
					$.notify(json['error'], {
						'type':'danger'
					});
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
});
//-->
<?php echo '</script'; ?>
>
<?php }
}
?>