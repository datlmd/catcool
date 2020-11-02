<div id="modal_image_crop" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
    <div id="crop_manager" class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="photoModalLabel">{lang('text_crop_image')}</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>
            <div class="modal-body p-4">
                <div id="custom-preview-wrapper"></div>
                <div class="image-wrapper" id="image-cropper-wrapper">
                    <img id="image_cropper" src="{image_url($image_url)}?{time()}">
                </div>
                <button type="button" id="btn_submit_crop" class="btn btn-sm btn-brand btn-space" data-toggle="tooltip" data-placement="top" title="" data-original-title="{lang('text_crop_image')}" data-target="#filter_manage"><i class="fas fa-crop"></i> {lang('text_crop_image')}</button>
            </div>
        </div>

        <input type="hidden" name="image_crop_url" id="image_crop_url" value="{$image_url}">
        <input type="hidden" name="aspect_ratio" id="aspect_ratio" value="{$aspect_ratio}">
        <input type="hidden" name="min_container_width" id="min_container_width" value="{$min_container_width}">
        <input type="hidden" name="min_container_height" id="min_container_height" value="{$min_container_height}">
        <input type="hidden" name="image_mime" id="image_mime" value="{$mime}">
    </div>
</div>
<style>
    .image-wrapper {
        max-width: 600px;
        min-width: 200px;
    }
    #image-cropper-wrapper .rcrop-outer-wrapper{
        opacity: .75;
    }
    #image-cropper-wrapper .rcrop-outer{
        background: #000
    }
    #image-cropper-wrapper .rcrop-croparea-inner{
        border: 1px dashed #fff;
    }

    #image-cropper-wrapper .rcrop-handler-corner{
        width:12px;
        height: 12px;
        background: none;
        border : 0 solid #51aeff;
    }
    #image-cropper-wrapper .rcrop-handler-top-left{
        border-top-width: 4px;
        border-left-width: 4px;
        top:-2px;
        left:-2px
    }
    #image-cropper-wrapper .rcrop-handler-top-right{
        border-top-width: 4px;
        border-right-width: 4px;
        top:-2px;
        right:-2px
    }
    #image-cropper-wrapper .rcrop-handler-bottom-right{
        border-bottom-width: 4px;
        border-right-width: 4px;
        bottom:-2px;
        right:-2px
    }
    #image-cropper-wrapper .rcrop-handler-bottom-left{
        border-bottom-width: 4px;
        border-left-width: 4px;
        bottom:-2px;
        left:-2px
    }
    #image-cropper-wrapper .rcrop-handler-border{
        display: none;
    }

    #image-cropper-wrapper .clayfy-touch-device.clayfy-handler{
        background: none;
        border : 0 solid #51aeff;
        border-bottom-width: 6px;
        border-right-width: 6px;
    }
</style>

<script>

    var is_processing = false;

    $(document).ready(function(){
        'use strict';

        $('#image_cropper__').rcrop({
            minSize : [200,200],
            preserveAspectRatio : true,
            grid : true,
            full : true,

            preview : {
                display: true,
                size : [100,100],
            }
        });
        setTimeout(function(){
            $('#image_cropper').rcrop({
                    minSize : [200,200],
                    preview : {
                        display: true,
                        size : [100,100],
                        wrapper : '#custom-preview-wrapper'
                    }
                }
            );
        },500);

    });
    $(document).on("click", '#btn_submit_crop', function(event) {

        if (is_processing) {
            return false;
        }
        is_processing = true;

        var srcOriginal = $('#image_cropper').rcrop('getDataURL');

        $.ajax({
            url: base_url + 'images/crop',
            type: 'POST',
            data: {
                'path': $("#image_crop_url").val(),
                'image_data': srcOriginal,
                'mime': $("#image_mime").val(),
            },
            dataType: 'json',
            beforeSend: function() {
                $(this).find('i').replaceWith('<i class="fas fa-spinner fa-spin"></i>');
                $(this).prop('disabled', true);
            },
            complete: function() {
                $(this).find('i').replaceWith('<i class="fas fa-crop"></i>');
                $(this).prop('disabled', false);
                //$('.image-setting').popover('dispose');
            },
            success: function(json) {
                is_processing = false;
                if (json['error']) {
                    $.notify(json['error'], {
                        'type':'danger'
                    });
                }
                if (json['success']) {
                    if ($("#filemanager").length) {
                        $('#filemanager #button-refresh').trigger('click');
                    } else if ($(".image-crop-target").length) {
                        $(".image-crop-target a").attr("href", json['image']);
                        $(".image-crop-target img").attr("src", json['image']);
                    }

                    $("#modal_image_crop").modal("hide");
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                is_processing = false;
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                $('.image-setting').popover('dispose');
            }
        });
    });
</script>
