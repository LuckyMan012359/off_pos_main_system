$(function () {
    "use strict";
    
    const cropImg = $('.img-container > img');
    cropImg.cropper({
        movable: true,
        zoomable: true,
        rotatable: false,
        scalable: false,
    });

    
    const sleep = (n) => new Promise(r => setTimeout(r, n));

    async function previewFile() {
        $('#crop_image_modal').modal('show');
        await sleep(500);
        let file   = document.querySelector('#crop_image').files[0];
        let reader = new FileReader();
        reader.onloadend = function () {
            $('.img-container > img').show(); 
            cropImg.cropper('replace',reader.result);
        }
        if (file) {
          reader.readAsDataURL(file);
        } else {
            cropImg.cropper('replace','');
        }
    }
    
    $(document).on('change', '#crop_image', previewFile);

    $(document).on('click','#crop_result',function() {
        let imgBlob = cropImg.cropper('getCroppedCanvas').toDataURL();
        $('#cropped_logo').val(imgBlob);
        $('#show_id').attr('src',imgBlob);
        $('#crop_image_modal').modal('hide');
    });


    $(document).on('click', '.close_modal_crop', function(e) {
        closeModal('crop_image');
    });


    // preview the selected images
    $(document).on("click", ".show_preview", function (e) {
        e.preventDefault();
        let preview_old = $("#show_id").attr("src");
        if(preview_old == ''){
            let file_path = $(this).attr("data-file_path");
            $("#show_id").attr("src", file_path);
            $("#show_id").css("width", "unset");
        }
        $("#logo_preview").modal("show");
    });




});

