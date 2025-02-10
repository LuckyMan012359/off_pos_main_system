$(function () {
    "use strict";
    let base_url_ = $("#base_url_").val();
    $(".parent_class").each(function(){
        let this_parent_name=$(this).attr('data-name');
        if($(".child_"+this_parent_name).length == $(".child_"+this_parent_name+":checked").length) {
            $(".parent_class_"+this_parent_name).prop("checked", true);
        } else {
            $(".parent_class_"+this_parent_name).prop("checked", false);
        }
    });
    $(document).on('click', '.child_class', function() {
        let this_parent_name = $(this).attr('data-parent_name');
        if($(".child_"+this_parent_name).length == $(".child_"+this_parent_name+":checked").length) {
            $(".parent_class_"+this_parent_name).prop("checked", true);
        } else {
            $(".parent_class_"+this_parent_name).prop("checked", false);
        }
    });

    $(document).on('click', '.parent_class', function() {
        let this_name=$(this).attr('data-name');

        let checked = $(this).is(':checked');
        if(checked){
            $(".child_"+this_name).each(function(){
                $(this).prop("checked",true);
            });
        }else{
            $(".child_"+this_name).each(function(){
                $(this).prop("checked",false);
            });
        }
    });

    if($(".checkbox_user").length == $(".checkbox_user:checked").length) {
        $("#checkbox_userAll").prop("checked", true);
    } else {
        $("#checkbox_userAll").removeAttr("checked");
    }
    // Check or Uncheck All checkboxes
    $(document).on('change', '#checkbox_userAll', function() {
        let checked = $(this).is(':checked');
        if(checked){
            $(".checkbox_user").each(function(){
                $(this).prop("checked",true);
            });
            $(".checkbox_user_p").prop("checked", true);
        }else{
            $(".checkbox_user").each(function(){
                $(this).prop("checked",false);
            });
            $(".checkbox_user_p").prop("checked", false);
        }
    });
    $(document).on('click', '.checkbox_user', function() {
        if($(".checkbox_user").length == $(".checkbox_user:checked").length) {
            $("#checkbox_userAll").prop("checked", true);

        } else {
            $("#checkbox_userAll").prop("checked", false);
        }
    });
    $(document).on('submit', '#add_role', function() {
        let temp = 0 ;
        let role_name = $("#role_name").val();
        let error = false;
        if(role_name==''){
            Swal.fire({
                title: "Alert",
                text: "The Roll Name is required",
                showDenyButton: false,
                showCancelButton: false,
                confirmButtonText: `OK`
            });
            $(".error_alert_role_name").html("he Roll Name is required");
            error = true;
        }else {
            $(".error_alert_role_name").html("");
        }
        $(".child_class").each(function(){
            let checked = $(this).is(':checked');
            if(checked){
                temp++;
            }
        });
        if(temp==0){
            Swal.fire({
                title: "Alert",
                text: "At least one check access",
                showDenyButton: false,
                showCancelButton: false,
                confirmButtonText: `OK`
            });
            $(".error_alert_atleast").html("at_least_one_check_access");
            return false;
        }else {
            $(".error_alert_atleast").html("");
        }
        if(error == true){
            return false;
        }
    });
    $(document).on('click', '#will_login_yes', function() {
        $('#will_login_section').fadeIn();
    });
    $(document).on('click', '#will_login_no', function() {
        $('#will_login_section').fadeOut();
    });



    function checkDataDiv() {
        let value  = $('input[name=will_login]:checked').val();
        if(value=="Yes"){
            $('#will_login_section').fadeIn();
        }else{
            $('#will_login_section').fadeOut();
        }
    }
    checkDataDiv();
    $(document).on('click', '#will_login_yes', function() {
        $('#will_login_section').fadeIn();
    });
    $(document).on('click', '#will_login_no', function() {
        $('#will_login_section').fadeOut();
    });



    $(document).on('click', '.add_image_for_crop', function () {
        $("#AddUserImageModal").modal('show');
    });
    let uploadCrop = $('#upload-demo').croppie({
        enableExif: true,
        viewport: {
            width: 100,
            height: 100,
            type: 'square'
        },
        boundary: {
            width: 150,
            height: 150
        }
    });
    $(document).on('change', '#upload', function () {
        let reader = new FileReader();
        reader.onload = function (e) {
            uploadCrop.croppie('bind', {
                url: e.target.result
            }).then(function () {
            });
        }
        reader.readAsDataURL(this.files[0]);
    });
    $(document).on('click', '.upload-result', function (ev) {
        uploadCrop.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function (resp) {
            let selected_image = $("#upload").val();
            if (selected_image == '') {
                Swal.fire({
                    title: "Alert",
                    text: img_select_error_msg,
                    showDenyButton: false,
                    showCancelButton: false,
                    confirmButtonText: `OK`
                });
                return false;
            } else {
                $.ajax({
                    url: base_url_+"Ajax/saveUserImage",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        "image": resp
                    },
                    success: function (data) {
                        $("#AddUserImageModal").modal('hide');
                        $("#image_url").val(data.image_name);
                        $("#upload").val('');
                        let html = '<img src="' + resp + '"/>';
                        $("#upload-demo-i").html(html);
                        $("#upload-demo-trash").html('<i class="image_div_p color_red fa fa-trash"></i>');
                    }
                });
            }
        });
    });

    $(document).on('click', '.show_image_trigger', function () {
        $("#show_image").modal('show');
    });
});