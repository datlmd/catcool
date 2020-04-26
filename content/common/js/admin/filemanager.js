var is_processing = false;

/* action - event */
$(function () {
    /** filemanager **/
    if ($('a[data-toggle=\'image\'] #button-image').length) {
        $(document).on('click', 'a[data-toggle=\'image\'] #button-image', function (e) {
            if (is_processing) {
                return false;
            }
            is_processing = true;
            e.preventDefault();
            $('[data-toggle="tooltip"]').tooltip('dispose');
            $('#modal-image').remove();//target=$element.parent().find('input').attr('id')
            var element = $(this);
            $.ajax({
                url: 'common/filemanager?target=' + encodeURIComponent(element.parent().attr('data-target')) + '&thumb=' + encodeURIComponent(element.parent().attr('data-thumb')),
                dataType: 'html',
                beforeSend: function () {
                    element.find('i').replaceWith('<i class="fas fa-spinner fa-spin mr-1"></i>');
                },
                complete: function () {
                    element.find('i').replaceWith('<i class="fas fa-pencil-alt mr-1"></i>');
                },
                success: function (html) {
                    is_processing = false;

                    //check lightbox
                    var lightbox_js = base_url + 'content/common/js/lightbox/lightbox.js';
                    var lightbox_css = base_url + 'content/common/js/lightbox/lightbox.css';
                    if (!$("link[href=\'" + lightbox_css +  "\']").length) {
                        $('<link href="'+ lightbox_css +'" rel="stylesheet"/>').appendTo('head');
                    }
                    if (!$("script[src=\'" + lightbox_js +  "\']").length) {
                        $('<script type="text/javascript" src="' + lightbox_js + '"></script>').appendTo('body');
                    }

                    $('body').append('<div id="modal-image" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">' + html + '</div>');

                    $('#modal-image').modal('show');
                    $('[data-toggle="tooltip"]').tooltip();
                },
                error: function (xhr, errorType, error) {
                    is_processing = false;
                }
            });
        });
    }
    if ($('a[data-toggle=\'image\'] #button-clear').length) {
        $(document).on('click', 'a[data-toggle=\'image\'] #button-clear', function (e) {
            e.preventDefault();
            $($(this).parent().attr('data-target')).val('');
            $(this).parent().find('img').attr('src', $(this).parent().find('img').attr('data-placeholder'));
            $($(this).parent()).parent().find('input').val('');
        });
    }
    $(document).on('hidden.bs.modal, hide.bs.modal','#modal-image', function () {
        $('#button-folder').popover('dispose');
    });
    /** filemanager **/
});

