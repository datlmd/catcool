var is_processing = false;
var Photo = {
    loadImageReview: function () {
        $("html").on("dragover", function(e) { e.preventDefault(); e.stopPropagation(); /*$("h5").text("Drag here");*/});
        $("html").on("drop", function(e) { e.preventDefault(); e.stopPropagation(); });
        $('.upload-area').on('dragenter', function (e) { e.stopPropagation(); e.preventDefault(); /*$("h5").text("Drop");*/});
        $('.upload-area').on('dragover', function (e) { e.stopPropagation(); e.preventDefault(); });

        // Drop
        $('html').on('drop', function (e) {
            e.stopPropagation();
            e.preventDefault();

            //$("h5").text("Upload");
            var file = e.originalEvent.dataTransfer.files;


//            $('.drop-drap-file').append('file', file[0]);
            document.querySelector('#file').files = e.originalEvent.dataTransfer.files;
            document.querySelector('#image_file').files = e.originalEvent.dataTransfer.files;

            Article.imagesPreview(e.originalEvent.dataTransfer);
        });

        // Open file selector on div click
        $(".drop-drap-file .upload-area").click(function() {
            $(".drop-drap-file #file").click();
        });

        // file selected
        $(".drop-drap-file #file").change(function(){
            document.querySelector('#image_file').files = this.files;
            Article.imagesPreview(this);
        });
    },
    imagesPreview: function(input) {
        if (input.files) {
            var filesAmount = input.files.length;

            $('.drop-drap-file #image_thumb').html('');
            for (i = 0; i < filesAmount; i++) {
                var len = $(".drop-drap-file #image_thumb div.thumbnail").length;
                var num = Number(len);
                num = num + 1;

                var reader = new FileReader();
                reader.onload = function(event) {
                    $('.drop-drap-file #image_thumb').append('<div id="thumbnail_' + num + '" class="thumbnail"></div>');
                    $("#thumbnail_" + num).append('<a href="' + event.target.result + '" data-lightbox="photos"><img src="' + event.target.result + '" class="img-thumbnail mr-1 img-fluid"></a>');
                    $("#thumbnail_" + num).append('<span class="size">' + Article.convertSize(event.loaded) + '</span>');
                }

                reader.readAsDataURL(input.files[i]);
            }
        }
    },
    // Bytes conversion
    convertSize: function (size) {
        var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
        if (size == 0) return '0 Byte';
        var i = parseInt(Math.floor(Math.log(size) / Math.log(1024)));
        return Math.round(size / Math.pow(1024, i), 2) + ' ' + sizes[i];
    },
};
    /* action - event */
$(function () {

    Photo.loadImageReview();//khoi tao drop image

});
