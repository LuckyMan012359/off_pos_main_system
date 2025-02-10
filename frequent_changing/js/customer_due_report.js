$(function () {
    "use strict";

    let customerFieldRequired = $('#The_customer_field_is_required').val();
    $("#supplierReport").submit(function () {
        let customer_id = $("#customer_id").val();
        let error = false;
        if (customer_id == "") {
            $("#customer_id_err_msg").text(customerFieldRequired);
            $(".customer_id_err_msg_contnr").show(200);
            error = true;
        }
        if (error == true) {
            return false;
        }
    });
});