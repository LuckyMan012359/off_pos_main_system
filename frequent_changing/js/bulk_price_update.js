
$(function ($) {
    "use strict"
    let base_url = $("#base_url_").val();
    let alert = $("#warning").val();
    let are_you_sure = $("#are_you_sure").val();
    let cancel = $("#cancel").val();
    let yes = $("#yes").val();
    let status_change = $("#status_change").val();
    let no_permission_for_this_module = $('#no_permission_for_this_module').val();
    let ok = $("#ok").val();
    let warning = $('#warning').val();

    let item_price_update = 'Item  price update successfully';


    $(document).on('change', '#status_trigger', function () { 
        let himSelf = $(this);
        $.ajax({
            url: base_url + "Master/checkAccess",
            method: "GET",
            async: false,
            dataType: 'json',
            data: { controller: "49", function: "enable_disable_status"},
            success: function (response) {
                if (response == false) {
                    Swal.fire({
                        title: warning+" !",
                        text: no_permission_for_this_module,
                        showDenyButton: false,
                        showCancelButton: false,
                        confirmButtonText: ok,
                    });
                } else {
                    let status = himSelf.val();
                    let get_id = himSelf.parent().parent().attr('data_id');
                    Swal.fire({
                        title: alert + "!",
                        text: are_you_sure,
                        showDenyButton: true,
                        showCancelButton: false,
                        confirmButtonText: yes,
                        denyButtonText: cancel
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            $.ajax({
                                method: "POST",
                                url: base_url+"Item/changeStatus",
                                data:{
                                    get_id : get_id,
                                    status : status,
                                },
                                success: function (response) {
                                if(response.status == 'success'){
                                    $('.ajax-message').html(`
                                        <section class="alert-wrapper">
                                            <div class="alert alert-success alert-dismissible fade show"> 
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                <div class="alert-body">
                                                    <i class="m-right fa fa-check"></i>
                                                    ${status_change}
                                                </div>
                                            </div>
                                        </section>
                                    `);
                                }
                                }
                            });
                        }
                    });
                }
            }
        });
    });

    // Add Image Modal Trigger
    jQuery(document).on('click', '.add_image_for_crop', function () {
        jQuery("#AddItemImageModal").modal('show');
        let item_id = jQuery(this).attr('data_id');
        let item_old_photo = jQuery(this).attr('data_old_photo');
        $('.item_image_id').val(item_id);
        $('.item_old_photo').val(item_old_photo);
    });

    let uploadCrop = jQuery('#upload-demo').croppie({
        enableExif: true,
        viewport: {
            width: 200,
            height: 115,
            type: 'square'
        },
        boundary: {
            width: 220,
            height: 135
        }
    });
    // Image On change trigger
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

    // Upload Image
    $(document).on('click', '.upload-result', function (ev) {
        uploadCrop.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function (resp) {
            let selected_image = $("#upload").val();
            if (selected_image == '') {
                Swal.fire({
                    title: alert,
                    text: img_select_error_msg,
                    showDenyButton: false,
                    showCancelButton: false,
                    confirmButtonText: `OK`
                });
                return false;
            } else {
                let item_id = $('.item_image_id').val();
                let item_old_photo = $('.item_old_photo').val();
                $.ajax({
                    url: base_url+"Ajax/bulkImageUpdate",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        "item_id": item_id,
                        "item_old_photo": item_old_photo,
                        "image": resp
                    },
                    success: function (data) {
                        if(data.status == 'success'){
                            $('.ajax-message').html(`
                                <section class="alert-wrapper">
                                    <div class="alert alert-success alert-dismissible fade show"> 
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        <div class="alert-body">
                                            <i class="m-right fa fa-check"></i>
                                            ${data.message}
                                        </div>
                                    </div>
                                </section>
                            `);
                            setTimeout(function(){
                                $(`.image_setter_${data.i_id}`).attr('src', base_url + 'uploads/items/' + data.image_name);
                            }, 100);
                            $('#upload-demo').html('');
                            let uploadCrop = $('#upload-demo').croppie({
                                enableExif: true,
                                viewport: {
                                    width: 200,
                                    height: 115,
                                    type: 'square'
                                },
                                boundary: {
                                    width: 220,
                                    height: 135
                                }
                            });
                        }else{
                            $('.ajax-message').html(`
                                <section class="alert-wrapper">
                                    <div class="alert alert-danger alert-dismissible fade show"> 
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        <div class="alert-body">
                                            <i class="m-right fa fa-times"></i>
                                            ${data.message}
                                        </div>
                                    </div>
                                </section>
                            `);
                        }
                        jQuery("#AddItemImageModal").modal('hide');
                        jQuery("#upload").val('');
                        let html = '<img src="' + resp + '"/>';
                        
                    }
                });
            }
        });
    });


    $(document).on('click', '.single_item_btn', function () { 
        let himSelf = $(this);
        $.ajax({
            url: base_url + "Master/checkAccess",
            method: "GET",
            async: false,
            dataType: 'json',
            data: { controller: "49", function: "enable_disable_status"},
            success: function (response) {
                if (response == false) {
                    Swal.fire({
                        title: warning+" !",
                        text: no_permission_for_this_module,
                        showDenyButton: false,
                        showCancelButton: false,
                        confirmButtonText: ok,
                    });
                } else {
                    let get_id = himSelf.attr('data_id');
                    let sale_price = himSelf.parent().parent().find('.sale_price').val();
                    let whole_sale_price = himSelf.parent().parent().find('.whole_sale_price').val();
                    $.ajax({
                        method: "POST",
                        url: base_url+"Item/bulkPriceUpdate",
                        data:{
                            item_id : get_id,
                            sale_price : sale_price,
                            whole_sale_price : whole_sale_price,
                        },
                        success: function (response) {
                            if(response.status == 'success'){
                                $('.ajax-message').html(`
                                    <section class="alert-wrapper">
                                        <div class="alert alert-success alert-dismissible fade show"> 
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            <div class="alert-body">
                                                <i class="m-right fa fa-check"></i>
                                                ${item_price_update}
                                            </div>
                                        </div>
                                    </section>
                                `);
                            }
                        }
                    });
                }
            }
        });
    });


});
