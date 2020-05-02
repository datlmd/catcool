<div id="modal_image_crop" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
    <div id="crop_manager" class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="photoModalLabel">Crop Image</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>
            <div class="modal-body p-4">
                <div class="row">
                    <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                        <div class="img-container">
                            <img id="image_cropper" src="{image_url($image_url)}" class="w-100" alt="Picture">
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                        <div class="mb-2">
                            <button type="button" id="btn_submit_crop" class="btn btn-sm btn-brand btn-space" data-toggle="tooltip" data-placement="top" title="" data-original-title="Crop Image" data-target="#filter_manage"><i class="fas fa-crop"></i> Crop Image</button>
                            <a href="javascript:void(0);" class="btn btn-sm btn-space btn-light" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><i class="fas fa-reply"></i> Close</span>
                            </a>
                        </div>

                        <!-- <h3>Preview:</h3> -->
                        <div class="docs-preview clearfix">
                            <div class="img-preview preview-lg"></div>
                            <div class="img-preview preview-md"></div>
                            <div class="img-preview preview-sm"></div>
                            <div class="img-preview preview-xs"></div>
                        </div>
                        <!-- <h3>Data:</h3> -->
                        <div class="docs-data" style="display: none;">
                            <div class="input-group input-group-sm">
                                <span class="input-group-prepend">
                                    <label class="input-group-text" for="dataX">X</label>
                                </span>
                                <input type="text" class="form-control" id="dataX" placeholder="x">
                                <span class="input-group-append">
                                    <span class="input-group-text">px</span>
                                </span>
                            </div>
                            <div class="input-group input-group-sm">
                                <span class="input-group-prepend">
                                    <label class="input-group-text" for="dataY">Y</label>
                                </span>
                                <input type="text" class="form-control" id="dataY" placeholder="y">
                                <span class="input-group-append">
                                    <span class="input-group-text">px</span>
                                </span>
                            </div>
                            <div class="input-group input-group-sm">
                                <span class="input-group-prepend">
                                    <label class="input-group-text" for="dataWidth">Width</label>
                                </span>
                                <input type="text" class="form-control" id="dataWidth" placeholder="width">
                                <span class="input-group-append">
                                    <span class="input-group-text">px</span>
                                </span>
                            </div>
                            <div class="input-group input-group-sm">
                                <span class="input-group-prepend">
                                    <label class="input-group-text" for="dataHeight">Height</label>
                                </span>
                                <input type="text" class="form-control" id="dataHeight" placeholder="height">
                                <span class="input-group-append">
                                    <span class="input-group-text">px</span>
                                </span>
                            </div>
                            <div class="input-group input-group-sm">
                                <span class="input-group-prepend">
                                    <label class="input-group-text" for="dataRotate">Rotate</label>
                                </span>
                                <input type="text" class="form-control" id="dataRotate" placeholder="rotate">
                                <span class="input-group-append">
                                    <span class="input-group-text">deg</span>
                                </span>
                            </div>
                            <div class="input-group input-group-sm">
                                <span class="input-group-prepend">
                                    <label class="input-group-text" for="dataScaleX">ScaleX</label>
                                </span>
                                <input type="text" class="form-control" id="dataScaleX" placeholder="scaleX">
                            </div>
                            <div class="input-group input-group-sm">
                                <span class="input-group-prepend">
                                    <label class="input-group-text" for="dataScaleY">ScaleY</label>
                                </span>
                                <input type="text" class="form-control" id="dataScaleY" placeholder="scaleY">
                            </div>
                        </div>
                        <!-- <h3>Toggles:</h3> -->
                        <div class="docs-toggles">
                            <label class="btn btn-outline-light active">
                                <input type="radio" class="sr-only" id="aspectRatio0" name="aspectRatio" value="1.7777777777777777">
                                <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="aspectRatio: 16 / 9">16:9</span>
                            </label>
                            <label class="btn btn-outline-light">
                                <input type="radio" class="sr-only" id="aspectRatio1" name="aspectRatio" value="1.3333333333333333">
                                <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="aspectRatio: 4 / 3">4:3</span>
                            </label>
                            <label class="btn btn-outline-light">
                                <input type="radio" class="sr-only" id="aspectRatio2" name="aspectRatio" value="1">
                                <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="aspectRatio: 1 / 1">1:1</span>
                            </label>
                            <label class="btn btn-outline-light">
                                <input type="radio" class="sr-only" id="aspectRatio3" name="aspectRatio" value="0.6666666666666666">
                                <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="aspectRatio: 2 / 3">2:3</span>
                            </label>
                            <label class="btn btn-outline-light">
                                <input type="radio" class="sr-only" id="aspectRatio4" name="aspectRatio" value="NaN">
                                <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="aspectRatio: NaN">Free</span>
                            </label>
                        </div>
                        <div class="docs-buttons">
                            <div class="btn-group">
                                <button type="button" class="btn btn-outline-light" data-method="zoom" data-option="0.1" title="Zoom In">
                                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Zoom In">
                                        <span class="fa fa-search-plus"></span>
                                    </span>
                                </button>
                                <button type="button" class="btn btn-outline-light" data-method="zoom" data-option="-0.1" title="Zoom Out">
                                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Zoom Out">
                                        <span class="fa fa-search-minus"></span>
                                    </span>
                                </button>
                                <button type="button" class="btn btn-outline-light" data-method="reset" data-toggle="tooltip" title="Reset">
                                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Reset">
                                        <span class="fas fa-sync"></span>
                                    </span>
                                </button>
                                <label class="btn btn-outline-light btn-upload m-b-0" for="inputImage" title="Upload image file">
                                    <input type="file" class="sr-only" id="inputImage" name="file" accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff">
                                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Upload image file">
                                        <span class="fa fa-upload"></span>
                                    </span>
                                </label>
                            </div>

                            <div class="btn-group">
                                <button type="button" class="btn btn-outline-light" data-method="move" data-option="-10" data-second-option="0" title="Move Left">
                                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Move Left">
                                        <span class="fa fa-arrow-left"></span>
                                    </span>
                                </button>
                                <button type="button" class="btn btn-outline-light" data-method="move" data-option="10" data-second-option="0" title="Move Right">
                                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Move Right">
                                        <span class="fa fa-arrow-right"></span>
                                    </span>
                                </button>
                                <button type="button" class="btn btn-outline-light" data-method="move" data-option="0" data-second-option="-10" title="Move Up">
                                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Move Up">
                                        <span class="fa fa-arrow-up"></span>
                                    </span>
                                </button>
                                <button type="button" class="btn btn-outline-light" data-method="move" data-option="0" data-second-option="10" title="Move Down">
                                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Move Down">
                                        <span class="fa fa-arrow-down"></span>
                                    </span>
                                </button>
                            </div>

                            <div class="btn-group">
                                <button type="button" class="btn btn-outline-light" data-method="rotate" data-option="-45" title="Rotate Left">
                                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Rotate left">
                                        <span class="fas fa-undo"></span>
                                    </span>
                                </button>
                                <button type="button" class="btn btn-outline-light" data-method="rotate" data-option="45" title="Rotate Right">
                                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Rotate Right">
                                        <span class="fa fa-redo"></span>
                                    </span>
                                </button>
                                <button type="button" class="btn btn-outline-light" data-method="scaleX" data-option="-1" title="Flip Horizontal">
                                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Flip Horizontal">
                                        <span class="fa fa-arrows-alt-h"></span>
                                    </span>
                                </button>
                                <button type="button" class="btn btn-outline-light" data-method="scaleY" data-option="-1" title="Flip Vertical">
                                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Flip Vertical">
                                        <span class="fa fa-arrows-alt-v"></span>
                                    </span>
                                </button>
                            </div>

                            <div class="btn-group btn-group-crop">
                                <button type="button" class="btn btn-outline-light" data-method="getCroppedCanvas" data-option="{ &quot;maxWidth&quot;: 4096, &quot;maxHeight&quot;: 4096 }">
                                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Download Crop">
                                      Download
                                    </span>
                                </button>
                                <button type="button" class="btn btn-outline-light" data-method="getCroppedCanvas" data-option="{ &quot;width&quot;: 320, &quot;height&quot;: 180 }">
                                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Download 320x180">
                                      320&times;180
                                    </span>
                                </button>
                                <button type="button" class="btn btn-outline-light" data-method="getCroppedCanvas" data-option="{ &quot;width&quot;: 480, &quot;height&quot;: 270 }">
                                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Download 480x270">
                                      480&times;270
                                    </span>
                                </button>
                            </div>

                            <button type="button" class="btn btn-outline-light" data-method="moveTo" data-option="0">
                                <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Move to [0,0]">
                                    Move to [0,0]
                                </span>
                            </button>
                            <button type="button" class="btn btn-outline-light" data-method="zoomTo" data-option="1">
                                <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Move to 100%">
                                    Zoom to 100%
                                </span>
                            </button>
                            <button type="button" class="btn btn-outline-light" data-method="rotateTo" data-option="180">
                                <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Rotate 180°">
                                    Rotate 180°
                                </span>
                            </button>

                            <button type="button" class="btn btn-outline-light" data-method="getData" data-option data-target="#putData">
                                <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;getData&quot;)">
                                    Get Data
                                </span>
                            </button>
                            <button type="button" class="btn btn-outline-light" data-method="getContainerData" data-option data-target="#putData">
                                <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;getContainerData&quot;)">
                                    Get Container Data
                                </span>
                            </button>
                            <button type="button" class="btn btn-outline-light" data-method="getImageData" data-option data-target="#putData">
                                <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;getImageData&quot;)">
                                    Get Image Data
                                </span>
                            </button>
                            <button type="button" class="btn btn-outline-light" data-method="getCanvasData" data-option data-target="#putData">
                                <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;getCanvasData&quot;)">
                                    Get Canvas Data
                                </span>
                            </button>
                            <button type="button" class="btn btn-outline-light" data-method="getCropBoxData" data-option data-target="#putData">
                                <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;getCropBoxData&quot;)">
                                    Get Crop Box Data
                                </span>
                            </button>

                            <textarea class="form-control" id="putData" rows="3" placeholder="Get data to here or set data with this value"></textarea>
                        </div>
                    </div>


                </div>
            </div>
        </div>

        <input type="hidden" name="image_crop_url" id="image_crop_url" value="{$image_url}">
        <input type="hidden" name="aspect_ratio" id="aspect_ratio" value="{$aspect_ratio}">
        <input type="hidden" name="min_container_width" id="min_container_width" value="{$min_container_width}">
        <input type="hidden" name="min_container_height" id="min_container_height" value="{$min_container_height}">
        <input type="hidden" name="image_mime" id="image_mime" value="{$mime}">
    </div>
</div>

<!-- Show the cropped image in modal -->
<div class="modal fade docs-cropped" id="getCroppedCanvasModal" aria-hidden="false" aria-labelledby="getCroppedCanvasTitle" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="getCroppedCanvasTitle">Cropped</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                <a class="btn btn-outline-light" id="download" href="javascript:void(0);" download="cropped.html">Download</a>
            </div>
        </div>
    </div>
</div>
<!-- /.modal -->

<script type="text/javascript">
    $('#modal_image_crop, #getCroppedCanvasModal').on('hidden.bs.modal', function() {
        $('body').addClass('modal-open');
    });

    var is_processing = false;

    $(function () {


        var console = window.console || { log: function () {

                } };
        var URL = window.URL || window.webkitURL;
        var $image = $('#image_cropper');
        var $download = $('#download');
        var $dataX = $('#dataX');
        var $dataY = $('#dataY');
        var $dataHeight = $('#dataHeight');
        var $dataWidth = $('#dataWidth');
        var $dataRotate = $('#dataRotate');
        var $dataScaleX = $('#dataScaleX');
        var $dataScaleY = $('#dataScaleY');

        var options = {
            aspectRatio: $('#aspect_ratio').val(),
            preview: '.img-preview',
            minContainerWidth: $('#min_container_width').val(),
            minContainerHeight: $('#min_container_height').val(),
            crop: function (e) {
                $dataX.val(Math.round(e.detail.x));
                $dataY.val(Math.round(e.detail.y));
                $dataHeight.val(Math.round(e.detail.height));
                $dataWidth.val(Math.round(e.detail.width));
                $dataRotate.val(e.detail.rotate);
                $dataScaleX.val(e.detail.scaleX);
                $dataScaleY.val(e.detail.scaleY);
            }
        };
        var originalImageURL = $image.attr('src');
        var uploadedImageName = 'cropped.jpg';
        var uploadedImageType = 'image/jpeg';
        var uploadedImageURL;

        // Tooltip
        $('[data-toggle="tooltip"]').tooltip();

        // Cropper

        $image.cropper(options);

        // Buttons
        if (!$.isFunction(document.createElement('canvas').getContext)) {
            $('button[data-method="getCroppedCanvas"]').prop('disabled', true);
        }

        if (typeof document.createElement('cropper').style.transition === 'undefined') {
            $('button[data-method="rotate"]').prop('disabled', true);
            $('button[data-method="scale"]').prop('disabled', true);
        }

        // Download
        if (typeof $download[0].download === 'undefined') {
            $download.addClass('disabled');
        }

        // Options
        $('.docs-toggles').on('change', 'input', function () {
            var $this = $(this);
            var name = $this.attr('name');
            var type = $this.prop('type');
            var cropBoxData;
            var canvasData;

            if (!$image.data('cropper')) {
                return;
            }

            if (type === 'checkbox') {
                options[name] = $this.prop('checked');
                cropBoxData = $image.cropper('getCropBoxData');
                canvasData = $image.cropper('getCanvasData');

                options.ready = function () {
                    $image.cropper('setCropBoxData', cropBoxData);
                    $image.cropper('setCanvasData', canvasData);
                };
            } else if (type === 'radio') {
                options[name] = $this.val();
            }

            $image.cropper('destroy').cropper(options);
        });

        // Methods
        $('.docs-buttons').on('click', '[data-method]', function () {
            var $this = $(this);
            var data = $this.data();
            var cropper = $image.data('cropper');
            var cropped;
            var $target;
            var result;

            if ($this.prop('disabled') || $this.hasClass('disabled')) {
                return;
            }

            if (cropper && data.method) {
                data = $.extend({}, data); // Clone a new one

                if (typeof data.target !== 'undefined') {
                    $target = $(data.target);

                    if (typeof data.option === 'undefined') {
                        try {
                            data.option = JSON.parse($target.val());
                        } catch (e) {
                            console.log(e.message);
                        }
                    }
                }

                cropped = cropper.cropped;

                switch (data.method) {
                    case 'rotate':
                        if (cropped && options.viewMode > 0) {
                            $image.cropper('clear');
                        }

                        break;

                    case 'getCroppedCanvas':
                        if (uploadedImageType === 'image/jpeg') {
                            if (!data.option) {
                                data.option = {

                                };
                            }

                            data.option.fillColor = '#fff';
                        }

                        break;
                }

                result = $image.cropper(data.method, data.option, data.secondOption);

                switch (data.method) {
                    case 'rotate':
                        if (cropped && options.viewMode > 0) {
                            $image.cropper('crop');
                        }

                        break;

                    case 'scaleX':
                    case 'scaleY':
                        $(this).data('option', -data.option);
                        break;

                    case 'getCroppedCanvas':
                        if (result) {
                            // Bootstrap's Modal
                            $('#getCroppedCanvasModal').modal().find('.modal-body').html(result);

                            if (!$download.hasClass('disabled')) {
                                download.download = uploadedImageName;
                                $download.attr('href', result.toDataURL(uploadedImageType));
                            }
                        }

                        break;

                    case 'destroy':
                        if (uploadedImageURL) {
                            URL.revokeObjectURL(uploadedImageURL);
                            uploadedImageURL = '';
                            $image.attr('src', originalImageURL);
                        }

                        break;
                }

                if ($.isPlainObject(result) && $target) {
                    try {
                        $target.val(JSON.stringify(result));
                    } catch (e) {
                        console.log(e.message);
                    }
                }
            }
        });

        // Keyboard
        $(document.body).on('keydown', function (e) {
            if (e.target !== this || !$image.data('cropper') || this.scrollTop > 300) {
                return;
            }

            switch (e.which) {
                case 37:
                    e.preventDefault();
                    $image.cropper('move', -1, 0);
                    break;

                case 38:
                    e.preventDefault();
                    $image.cropper('move', 0, -1);
                    break;

                case 39:
                    e.preventDefault();
                    $image.cropper('move', 1, 0);
                    break;

                case 40:
                    e.preventDefault();
                    $image.cropper('move', 0, 1);
                    break;
            }
        });

        // Import image
        var $inputImage = $('#inputImage');

        if (URL) {
            $inputImage.change(function () {
                var files = this.files;
                var file;

                if (!$image.data('cropper')) {
                    return;
                }

                if (files && files.length) {
                    file = files[0];

                    if (/^image\/\w+$/.test(file.type)) {
                        uploadedImageName = file.name;
                        uploadedImageType = file.type;

                        if (uploadedImageURL) {
                            URL.revokeObjectURL(uploadedImageURL);
                        }

                        uploadedImageURL = URL.createObjectURL(file);
                        $image.cropper('destroy').attr('src', uploadedImageURL).cropper(options);
                        $inputImage.val('');
                    } else {
                        window.alert('Please choose an image file.');
                    }
                }
            });
        } else {
            $inputImage.prop('disabled', true).parent().addClass('disabled');
        }


        $('#btn_submit_crop').click(function(e) {
            if (is_processing) {
                return false;
            }
            is_processing = true;

            var image_canvas = $image.cropper("getCroppedCanvas").toDataURL();

            $.ajax({
                url: base_url + 'images/crop',
                type: 'POST',
                dataType: 'text',
                data: {
                    'path': $("#image_crop_url").val(),
//                    'x_axis': $image_data.x,
//                    'y_axis': $image_data.y,
//                    'width': $image_data.width,
//                    'height': $image_data.height,
                    'image_data': image_canvas,
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
    });

</script>
