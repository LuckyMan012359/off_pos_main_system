$(function () {
  "use strict"
  let The_supplier_field_is_required = $('#The_supplier_field_is_required').val();
  $("#supplierReport").submit(function () {
    let supplier_id = $("#supplier_id").val();
    let error = false;
    if (supplier_id == "") {
      $("#supplier_id_err_msg").text(The_supplier_field_is_required);
      $(".supplier_id_err_msg_contnr").show(200);
      error = true;
    }
    if (error == true) {
      return false;
    }
  });

})