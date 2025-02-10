$(function () {
    "use strict";
    let The_items_field_is_required = $('#The_items_field_is_required').val();
    let The_customer_field_is_required = $('#The_customer_field_is_required').val();
    // Validate form
    $(document).on('submit', '#productSaleReport', function() {
        let items_id = $("#items_id").val();
        let customer_id = $("#customer_id").val();
        let menu_note = $("#menu_note").val();
        let error = false;

        if(menu_note==''){
            if(items_id==""){
                $("#items_id_err_msg").text(The_items_field_is_required);
                $(".items_id_err_msg_contnr").show(200);
                error = true;
            }
            if(customer_id==""){
                $("#customer_id_err_msg").text(The_customer_field_is_required);
                $(".customer_id_err_msg_contnr").show(200);
                error = true;
            }
        }
        if(error == true){
            return false;
        }
    });

});