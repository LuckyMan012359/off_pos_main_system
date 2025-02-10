$(function () {
  "use strict";
  //use for every report view
  let today = new Date();
  let dd = today.getDate();
  let mm = today.getMonth() + 1; //January is 0!
  let yyyy = today.getFullYear();

  if (dd < 10) {
      dd = "0" + dd;
  }

  if (mm < 10) {
      mm = "0" + mm;
  }
  today = yyyy + "-" + mm + "-" + dd;

  //get title and datatable id name from hidden input filed that is before in the table in view page for every datatable
  let datatable_name = $(".datatable_name").attr("data-id_name");
  let title = $(".datatable_name").attr("data-title");
  let TITLE = title + ", " + today;
  $("#" + datatable_name).DataTable({
      autoWidth: false,
      ordering: true,
      "order": false,
      dom: "Bfrtip",
      buttons: ["csv", "excel", "pdf", "print", "colvis"],
      language: {
          paginate: {
              previous: "<i class='fas fa-chevron-left'></i>",
              next: "<i class='fas fa-chevron-right'></i>",
          },
      },
  });
  $("#customerReport").submit(function () {
      let customer_id = $("#customer_id").val();
      let customer_field_required = $(".customer_field_required").val();
      let error = false;
      if (customer_id == "") {
          $("#customer_id_err_msg").text(customer_field_required);
          $(".customer_id_err_msg_contnr").show(200);
          error = true;
      }
      if (error == true) {
          return false;
      }
  });
});