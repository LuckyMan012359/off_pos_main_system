jQuery(function() {
    "use strict";

    let base_url = jQuery("#base_url_c").val();
    let outlet_name = jQuery("#outlet_name").val();
    let outlet_phone = jQuery("#outlet_phone").val();
    let outlet_address = jQuery("#address").val();
    let currency = jQuery("#currency").val();
    let please_select_1_customer = jQuery("#please_select_1_customer").val();
    let warning = jQuery("#warning").val();
    let ok = jQuery("#ok").val();


    //check all
    checkAll();
    //check all function
    function checkAll() {
        if (jQuery(".checkbox_user").length == jQuery(".checkbox_user:checked").length) {
            jQuery(".checkbox_userAll").prop("checked", true);
        } else {
            jQuery(".checkbox_userAll").prop("checked", false);
        }
    }
    jQuery(document).on('submit', '#due_customers', function(){
        if(jQuery(".checkbox_user:checked").length == 0){
            Swal.fire({
                title: warning + "!",
                text: please_select_1_customer,
                showDenyButton: false,
                showCancelButton: false,
                confirmButtonText: ok,
            });
            return false;
        }
    });


    // Check or Uncheck All checkboxes
    jQuery(document).on('click', '.checkbox_userAll', function(e){
        let checked = jQuery(this).is(':checked');
        if (checked) {
            jQuery(".checkbox_user").each(function () {
                let menu_id = jQuery(this).attr('data-menu_id');
                jQuery(this).prop("checked", true);
                jQuery("#qty"+menu_id).val(1);
                jQuery("#qty"+menu_id).prop("disabled", false);
            });
            jQuery(".checkbox_userAll").prop("checked", true);
        } else {
            jQuery(".checkbox_user").each(function () {
                let menu_id = jQuery(this).attr('data-menu_id');
                jQuery(this).prop("checked", false);
                jQuery("#qty"+menu_id).prop("disabled", true);
                jQuery("#qty"+menu_id).val('');
            });
            jQuery(".checkbox_userAll").prop("checked", false);
        }
    });
    jQuery(document).on('click', '.checkbox_user', function(e){
        let menu_id = jQuery(this).attr('data-menu_id');
        if (jQuery(".checkbox_user").length == jQuery(".checkbox_user:checked").length) {
            jQuery(".checkbox_userAll").prop("checked", true);
            if(jQuery(this).is(':checked')){
                jQuery("#qty"+menu_id).val(1);
                jQuery("#qty"+menu_id).prop("disabled", false);
            }else{
                jQuery("#qty"+menu_id).prop("disabled", true);
                jQuery("#qty"+menu_id).val('');
            }
        } else {
            jQuery(".checkbox_userAll").prop("checked", false);
            if(jQuery(this).is(':checked')){
                jQuery("#qty"+menu_id).val(1);
                jQuery("#qty"+menu_id).prop("disabled", false);
            }else{
                jQuery("#qty"+menu_id).prop("disabled", true);
                jQuery("#qty"+menu_id).val('');
            }
        }
    });
    

    jQuery(document).on('click', '.send_single_sms',  function(){
        let mobile = jQuery('.send_single_sms').attr('mobile');
        let customer_name = jQuery('.send_single_sms').attr('customer_name');
        let customer_due = jQuery('.send_single_sms').attr('customer_due');
        jQuery('.mobile_hidden').val('');
        jQuery('.mobile_hidden').val(mobile);
        jQuery('.message_text').val('');
        jQuery('.message_text').val(`Dear ${customer_name}, you have due of ${currency} ${customer_due}  to us, Please make your payment. Regards, Outlet: ${outlet_name}, Phone: ${outlet_phone}, Address: ${outlet_address}`);
    });

    jQuery(document).on('click', '.send_sms_trigger', function () {
        let mobile = jQuery('.mobile_hidden').val();
        let message = jQuery('.message_text').val();
        $.ajax({
            method: "POST",
            url: base_url+"Customer/sendSMSToDueCustomer",
            data: {
                mobile : mobile,
                message : message,
            },
            success: function (response) {
                if(response.status == 'success'){
                    jQuery("#ajax_message").html(`
                        <section class="alert-wrapper">
                            <div class="alert alert-success alert-dismissible fade show"> 
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>
                                <div class="alert-body"><i class="icon fa fa-check me-2"></i>
                                    ${response.data}
                                </div>
                            </div>
                        </section>
                    `);
                    setTimeout(function(){
                        jQuery("#ajax_message").html("");
                    }, 5000);
                }else{
                    jQuery("#ajax_message").html(`
                        <section class="alert-wrapper">
                            <div class="alert alert-danger alert-dismissible fade show"> 
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>
                                <div class="alert-body"><i class="icon fa fa-times me-2"></i>
                                    ${response.data}
                                </div>
                            </div>
                        </section>
                    `);
                    setTimeout(function(){
                        jQuery("#ajax_message").html("");
                    }, 5000);
                }
                jQuery('#myModal').modal('hide');
            }
        });
    });



    jQuery(document).on('click', '#bul_sms_modal_trigger', function(){
        if(jQuery(".checkbox_user:checked").length == 0){
            Swal.fire({
                title: warning + "!",
                text: please_select_1_customer,
                showDenyButton: false,
                showCancelButton: false,
                confirmButtonText: ok,
            });
            return false;
        }else{
            let selected_user =  jQuery(".checkbox_user:checked").length
            jQuery('.counter').text(selected_user);
            jQuery('#bulkSMSSend').modal('show');
            jQuery('.bulk_message_text').val("");
            jQuery('.bulk_message_text').val(`Dear [CUSTOMER_NAME], you have due of ${currency} [CUSTOMER_DUE]  to us, Please make your payment. Regards, Outlet: ${outlet_name}, Phone: ${outlet_phone}, Address: ${outlet_address}`);
        }
    });



    jQuery(document).on('click', '.bulk_send_sms_trigger', function(e){
        e.preventDefault();
        let customer_id = jQuery('input[name="customer_id[]"]').map(function () {
            return this.value;
        }).get();
        let bulk_message = jQuery('.bulk_message_text').val();
        $.ajax({
            type: "POST",
            url: base_url+"Customer/sendSMSForAllDueCustomer",
            data:{
                customer_id : customer_id,
                bulk_message: bulk_message
            },
            success: function (response) {
                console.log(response);
                if(response.status == 'success'){
                    jQuery("#ajax_message").html(`
                        <section class="alert-wrapper">
                            <div class="alert alert-success alert-dismissible fade show"> 
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>
                                <div class="alert-body"><i class="icon fa fa-check me-2"></i>
                                    ${response.data}
                                </div>
                            </div>
                        </section>
                    `);
                    setTimeout(function(){
                        jQuery("#ajax_message").html("");
                    }, 5000);
                    jQuery(".checkbox_userAll").prop("checked", false);
                    jQuery(".checkbox_user").prop("checked", false);
                }else{
                    jQuery("#ajax_message").html(`
                        <section class="alert-wrapper">
                            <div class="alert alert-danger alert-dismissible fade show"> 
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>
                                <div class="alert-body"><i class="icon fa fa-times me-2"></i>
                                    ${response.data}
                                </div>
                            </div>
                        </section>
                    `);
                    setTimeout(function(){
                        jQuery("#ajax_message").html("");
                    }, 5000);
                }
                jQuery('#bulkSMSSend').modal('hide');
                
            }
        });
    });



});
