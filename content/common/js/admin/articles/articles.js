
/* action - event */
$(function () {
    Tiny_content.loadTiny('content');

    $('form').submit(function () {
        var iframe = $('#content_ifr');
        var editorContent = $('#tinymce[data-id="content"]', iframe.contents()).html();
        alert(editorContent);
        return false;
    });

//        $("#add_validationform").submit(function(e){
//
//            var content = Tiny_content.getTiny('tinymce');
// alert(content);
//            $("#content").html(content);
//
//            return false;
//
//        });
});

