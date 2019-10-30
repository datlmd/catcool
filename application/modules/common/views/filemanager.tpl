<div id="filemanager" class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="photoModalLabel">{$heading_title}</h5>
            <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </a>
        </div>
        <div class="modal-body">
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
                        </span>
                    </div>
                </div>
            </div>
            <hr />
            <div id="msg" class="text-secondary"></div>
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
{form_hidden('file_thumb', $thumb)}
{form_hidden('file_target', $target)}
{form_hidden('file_directory', $directory)}
{form_hidden('entry_folder', $entry_folder)}
{form_hidden('button_folder', $button_folder)}
{form_hidden('text_confirm', $text_confirm)}
<script>
    var is_processing = false;
    var file_thumb = $('input[name=\'file_thumb\']');
    var file_target = $('input[name=\'file_target\']');
    var file_directory = $('input[name=\'file_directory\']');
    var entry_folder = $('input[name=\'entry_folder\']');
    var button_folder = $('input[name=\'button_folder\']');

    if (file_target.length) {
        $('a.thumbnail').on('click', function (e) {
            e.preventDefault();

            if (file_thumb.length) {
                $('#' + file_thumb.val()).attr('src', $(this).find('img').attr('src'));
            }
            $('#' + file_target.val()).val($(this).parent().find('input').val());

            $('#modal-image').modal('hide');
        });
    }

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
        var url = 'common/filemanager?directory=' + file_directory;

        var filter_name = $('input[name=\'search\']').val();

        if (filter_name) {
            url += '&filter_name=' + encodeURIComponent(filter_name);
        }

        if (file_thumb.length) {
            url += '&thumb=' + file_thumb.val();
        }

        if (file_target.length) {
            url += '&target=' + file_target.val();
        }

        $('#modal-image').load(url);
    });

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

                var progress = '<div class="progress">';
                progress += '<div id="progress-bar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" style="width: 0%"></div>';
                progress += '</div>';
                $('#filemanager #msg').append(progress);

                $.ajax({
                    url: 'common/filemanager/upload?directory=' + file_directory,
                    type: 'post',
                    dataType: 'json',
                    data: new FormData($('#form-upload')[0]),
                    cache: false,
                    contentType: false,
                    processData: false,
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();

                        xhr.upload.addEventListener("progress", function(evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = evt.loaded / evt.total;
                                percentComplete = parseInt(percentComplete * 100);

                                $('#progress-bar').attr("aria-valuenow", percentComplete);
                                $('#progress-bar').attr("style", 'width: ' + percentComplete + '%;');
                            }
                        }, false);

                        return xhr;
                    },
                    beforeSend: function() {
                        $('#button-upload i').replaceWith('<i class="fas fa-spinner fa-spin"></i>');
                        $('#button-upload').prop('disabled', true);
                    },
                    complete: function() {
                        $('#button-upload i').replaceWith('<i class="fas fa-upload"></i>');
                        $('#button-upload').prop('disabled', false);
                    },
                    success: function(json) {
                        $('#filemanager #msg').html(json);
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
        title: entry_folder,
        content: function() {
            html  = '<div class="input-group">';
            html += '  <input type="text" name="folder" value="" placeholder="' + entry_folder + '" class="form-control">';
            html += '  <span class="input-group-btn"><button type="button" title="' + button_folder + '" id="button-create" class="btn btn-sm btn-primary"><i class="fas fa-plus-circle"></i></button></span>';
            html += '</div>';

            return html;
        }
    });

    $('#button-folder').on('shown.bs.popover', function() {
        $('#button-create').on('click', function() {
            $.ajax({
                url: 'common/filemanager/folder?directory=' + file_directory,
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
        if (confirm($('input[name=\'text_confirm\']').val())) {
            $.ajax({
                url: 'common/filemanager/delete',
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

    $(function () {
        $("html").on("dragover", function (e) {
            e.preventDefault();
            e.stopPropagation();
            /*$("h5").text("Drag here");*/
        });
        $("html").on("drop", function (e) {
            e.preventDefault();
            e.stopPropagation();
        });
        $('#filemanager').on('dragenter', function (e) {
            e.stopPropagation();
            e.preventDefault();
            /*$("h5").text("Drop");*/
        });
        $('#filemanager').on('dragover', function (e) {
            e.stopPropagation();
            e.preventDefault();
        });

        // Drop
        $('#filemanager').on('drop', function (e) {
            e.stopPropagation();
            e.preventDefault();

            $('#form-upload').remove();

            $('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file[]" value="" multiple="multiple" /></form>');

            var file = e.originalEvent.dataTransfer.files;
            var formdata = new FormData();

            if (file.length > 0) {
                for (var i = 0; i < file.length; i++) {
                    formdata.append("file[]", file[i]);
                }

                if (typeof timer != 'undefined') {
                    clearInterval(timer);
                }

                var progress = '<div class="progress">';
                progress += '<div id="progress-bar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" style="width: 0%"></div>';
                progress += '</div>';
                $('#filemanager #msg').append(progress);

                timer = setInterval(function() {
                    clearInterval(timer);

                    $.ajax({
                        url: 'common/filemanager/upload?directory=' + file_directory,
                        type: 'post',
                        dataType: 'json',
                        data: formdata,
                        cache: false,
                        contentType: false,
                        processData: false,
                        xhr: function () {
                            var xhr = new window.XMLHttpRequest();

                            xhr.upload.addEventListener("progress", function (evt) {
                                if (evt.lengthComputable) {
                                    var percentComplete = evt.loaded / evt.total;
                                    percentComplete = parseInt(percentComplete * 100);

                                    $('#progress-bar').attr("aria-valuenow", percentComplete);
                                    $('#progress-bar').attr("style", 'width: ' + percentComplete + '%;');
                                }
                            }, false);

                            return xhr;
                        },
                        beforeSend: function () {
                            $('#button-upload i').replaceWith('<i class="fas fa-spinner fa-spin"></i>');
                            $('#button-upload').prop('disabled', true);
                        },
                        complete: function () {
                            $('#button-upload i').replaceWith('<i class="fas fa-upload"></i>');
                            $('#button-upload').prop('disabled', false);
                        },
                        success: function (json) {
                            $('#filemanager #msg').html(json);
                            if (json['error']) {
                                $.notify(json['error'], {
                                    'type': 'danger'
                                });
                                return false;
                            }

                            if (json['success']) {
                                $.notify(json['success']);

                                $('#button-refresh').trigger('click');
                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                    });
                }, 500);
            }

        });
    });
</script>
