// image Upload

$('#add_image_form').on('submit', function(e){
    e.preventDefault();
    var $file = $('#add_image_field');
    var $bar = $('#add_image_field_progress');
    uploadMedia($file, $bar);
});

function uploadMedia(file, bar){
    var formData = new FormData;
    formData.append(0, file[0].files[0]);
    $.ajax({
        xhr: function(){
            var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener('progress', function (e) {
                    if(e.lengthComputable){
                        var percenct = Math.round(e.loaded / e.total * 100);
                        bar.attr('aria-now', percenct);
                        bar.css('width', percenct + "%");
                        bar.text(percenct + "%");
                    }
                });
            return xhr;
        },
        type: "POST",
        url: "/blog-cms/admin/inc/image_upload.inc.php?act=upload",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(data){
            if(data.toLowerCase() == 'success'){
                bar.addClass('bg-success');
                bar.text(data);
                window.location = window.location.href.split("?")[0] + '?upload='+data.toLowerCase();
            }else{
                bar.attr('aria-now', 100);
                bar.css('width', "100%");
                bar.addClass('bg-danger');
                bar.text(data);
                window.location = window.location.href.split("?")[0] + '?upload='+data;
            }
        },
        error: function(){
          bar.attr('aria-now', 100);
          bar.css('width', "100%");
          bar.addClass('bg-danger');
          bar.text('Error');
        }

    })
}
