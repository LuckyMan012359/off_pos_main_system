
$(function () {
  "use strict"
  let get_csrf_hash = $(".get_csrf_hash").val();
  let base_url = $("#base_url_").val();

  let copy_db = $('#copy_db_exp').val();
  let print_db = $('#print_db_exp').val();
  let excel_db = $('#excel_db_exp').val();
  let csv_db = $('#csv_db_exp').val();
  let pdf_db = $('#pdf_db_exp').val();

  let APPLICATION_DEMO_TYPE = $('#APPLICATION_DEMO_TYPE').val();

  //get data using ajax datatable
  jQuery("#datatable").DataTable({
    processing: true,
    serverSide: true,
    ordering: true,
    paging: true,
    
    ajax: {
      url: base_url + "Item/getBulkAjaxData",
      type: "POST",
      dataType: "json",
      data: {
        get_csrf_token_name: get_csrf_hash,
      },
    },
    columnDefs: [
      { orderable: true, targets: [ 4, 6, 6 ] }
    ],
    
    dom: '<"top-left-item col-sm-12 col-md-6"lf> <"top-right-item col-sm-12 col-md-6"B> t <"bottom-left-item col-sm-12 col-md-6 "i><"bottom-right-item col-sm-12 col-md-6 "p>',
    
    buttons: APPLICATION_DEMO_TYPE != 'Pharmacy'  ? [{
          extend: "print",
          text: '<span style="display: flex; align-items-center; gap: 8px;"><iconify-icon icon="solar:printer-broken" width="16"></iconify-icon> '+print_db+'</span>',
          titleAttr: "print",
      },
      {
          extend: "copyHtml5",
          text: '<span style="display: flex; align-items-center; gap: 8px;"><iconify-icon icon="solar:copy-broken" width="16"></iconify-icon> '+copy_db+'</span>',
          titleAttr: "Copy",
      },
      {
          extend: "excelHtml5",
          text: '<span style="display: flex; align-items-center; gap: 8px;"><iconify-icon icon="icon-park-solid:excel" width="16"></iconify-icon> '+excel_db+'</span>',
          titleAttr: "Excel",
      },
      {
          extend: "csvHtml5",
          text: '<span style="display: flex; align-items-center; gap: 8px;"><iconify-icon icon="teenyicons:csv-outline" width="16"></iconify-icon> '+csv_db+'</span>',
          titleAttr: "CSV",
      },
      {
          extend: "pdfHtml5",
          text: '<span style="display: flex; align-items-center; gap: 8px;"><iconify-icon icon="teenyicons:pdf-outline" width="16"></iconify-icon> '+pdf_db+'</span>',
          titleAttr: "PDF",
      }
    ] : [],

    language: {
      paginate: {
        previous: "Previous",
        next: "Next",
      }
    },
    // Use drawCallback to initialize tooltips after each draw
    // Use initComplete to initialize tooltips after DataTable initialization is complete
    initComplete: function() {
      $('#datatable [data-bs-toggle="tooltip"]').tooltip();
      $('.select2').select2();
    },

  });
});
