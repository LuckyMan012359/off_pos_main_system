$(function () {
    "use strict"
    let base_url = $("#base_url_").val();
    let alert = $("#warning").val();
    let are_you_sure = $("#are_you_sure").val();
    let cancel = $("#cancel").val();
    let yes = $("#yes").val();
    let status_change = $("#status_change").val();
    let get_csrf_hash = $(".get_csrf_hash").val();
    let no_permission_for_this_module = $('#no_permission_for_this_module').val();
    let ok = $("#ok").val();
    let warning = $('#warning').val();

    $(document).on('change', '#status_trigger', function () { 
        let himSelf = $(this);
        $.ajax({
            url: base_url + "Master/checkAccess",
            method: "GET",
            async: false,
            dataType: 'json',
            data: { controller: "125", function: "status_change" },
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
                    let type_val = himSelf.val();
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
                                url: base_url+"Transfer/changeStatus",
                                data:{
                                    get_id : get_id,
                                    type_val : type_val,
                                },
                                success: function (response) {
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
                            });
                        }
                    });
                }
            }
        });
    });


    let copy_db = $('#copy_db_exp').val();
    let print_db = $('#print_db_exp').val();
    let excel_db = $('#excel_db_exp').val();
    let csv_db = $('#csv_db_exp').val();
    let pdf_db = $('#pdf_db_exp').val();

      //get data using ajax datatable
  $("#datatable").DataTable({
    processing: true,
    serverSide: true,
    ordering: true,
    paging: true,
    pageLength: 10, // Default number of records to display
    lengthMenu: [
        [10, 20, 50, 100, 1000, 2000, -1], // Add '-1' for "All" option
        [10, 20, 50, 100, 1000, 2000, "All"] // Label for the options
    ],
    responsive: true, // Enable responsiveness
    ajax: {
      url: base_url + "Transfer/getAjaxData",
      type: "POST",
      dataType: "json",
      data: {
        get_csrf_token_name: get_csrf_hash
      },
    },
    columnDefs: [
      { orderable: true, targets: [ 4, 6, 7 ] }
    ],

    dom: '<"top-left-item col-sm-12 col-md-6"lf> <"top-right-item col-sm-12 col-md-6"B> t <"bottom-left-item col-sm-12 col-md-6 "i><"bottom-right-item col-sm-12 col-md-6 "p>',
    buttons: [{
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
    },

    
],

    language: {
      paginate: {
        previous: "Previous",
        next: "Next",
      }
    },
    initComplete: function() {
        $('#datatable [data-bs-toggle="tooltip"]').tooltip();
        $('.select2').select2();
    },
  });

});