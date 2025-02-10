$(function () {
    "use strict";
    let base_url = $('#base_url_hidden').val();
    let csrf_name_= $("#csrf_name_").val();
    let csrf_value_= $("#csrf_value_").val();
    let delivery_status = $('#delivery_status_change').val();
    let delivery_status_filter = $('#delivery_status_filter').val();
    let account_field_required = $('#account_field_required').val();




    function formsubmit(){
        let error_status=false;
        let payment_method_id=$("#payment_method_id").val();
  
        if(payment_method_id == '') {
            error_status = true;
            let cl1 = ".payment_method_id_err_msg";
            let cl2 = ".payment_method_id_err_msg_contnr";
            $(cl1).text(account_field_required);
            $(cl2).show(200).delay(6000).hide(200,function(){
            });
        } else {
            $('select[name=payment_method_id]').css('border', '1px solid #ccc');
        }

        if(error_status==true){
            return false;
        }else{
            $('button[type=submit]').attr('disabled','disabled');
            return true;
        }
    }

    $(document).on('submit', '.op_formsubmit', function() {
        formsubmit();
    });
    
    $(document).on('click', '.view_challan', function() {
        viewChallan($(this).attr('sale_id'));
	});
    $(document).on('click', '.view_invoice', function() {
        viewInvoice($(this).attr('sale_id'));
    });
    $(document).on('click', '.pdf_invoice', function() {
        a4InvoicePDF($(this).attr('sale_id'));
    });
    
    $(document).ready(function(){
        $(document).on('click', '.delivered', function (e) {
            let sale_id = $(this).attr("data-id");
            $("#sale_id").val(sale_id);
            $("#supplierModal").modal("show");
        });
    });


    let copy_db = $('#copy_db_exp').val();
    let print_db = $('#print_db_exp').val();
    let excel_db = $('#excel_db_exp').val();
    let csv_db = $('#csv_db_exp').val();
    let pdf_db = $('#pdf_db_exp').val();

    $('#datatable').DataTable({
        'processing'   : true,
        'serverSide'    : true,
        'ajax'    : {
            url: base_url+'Sale/getAjaxData',
            type: "POST",
            dataType:'json',
            data:{
                delivery_status: delivery_status_filter,
                csrf_name_: csrf_value_
            },
        },
        autoWidth: false,
            ordering: true,
            order: [
                [0, "desc"]
            ],
            // dom: "Bfrtip",
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
                },
            },
            initComplete: function() {
                $('#datatable [data-bs-toggle="tooltip"]').tooltip();
                $('.select2').select2();
            },
    });

    function  viewInvoice(id) {
        let print_format = $('#print_type').val();
        if (print_format == "56mm") {
            open("print_invoice/" + id, 'Print Invoice', 'width=480,height=550');
        }else if (print_format == "80mm") {
            open("print_invoice/" + id, 'Print Invoice', 'width=685,height=550');
        } else if (print_format == "A4 Print") {
            open("print_invoice/" + id, 'Print Invoice', 'width=1600,height=550');
        } else if (print_format == "Half A4 Print") {
            open("print_invoice/" + id, 'Print Invoice', 'width=1600,height=550');
        } else if (print_format == "Letter Head") {
            open("print_invoice/" + id, 'Print Invoice', 'width=1600,height=550');
        } else if(print_format == 'No Print'){
            toastr['error'](("Printer is not configured."), '');
        }
    }

    function  a4InvoicePDF(id) {
        open("a4InvoicePDF/" + id);
    }
	
	function  viewChallan(id) {
        open("print_challan/" + id, 'Print Invoice', 'width=1600,height=550');
    }
	
    function change_date(id) {
        $('#change_date_sale_modal').val('');
        $('#sale_id_hidden').val('');
        $('#sale_id_hidden').val(id);
        $('#change_date_modal').modal('show');
    }
    $(document).on('click', '#close_change_date_modal', function() {
        $('#change_date_sale_modal').val('');
        $('#sale_id_hidden').val('');
    });

    $(document).on('click', '#save_change_date', function() {
        let change_date = $('#change_date_sale_modal').val();
        let sale_id = $('#sale_id_hidden').val();
        $.ajax({
            url:base_url+"Sale/change_date_of_a_sale_ajax",
            method:"POST",
            data:{
                sale_id : sale_id,
                change_date : change_date,
                csrf_name_: csrf_value_
            },
            success:function(response) {
                $('#change_date_sale_modal').val('');
                $('#sale_id_hidden').val('');
                $('#change_date_modal').modal('hide');
            },
            error:function(){
                alert("error");
            }
        });
    });



    $(document).on('change', '#delivery_status_trigger', function () { 
        let type_val = $(this).val();
        let get_id = $(this).parent().parent().attr('data_id');


        Swal.fire({
            title: "Alert !",
            text: 'Are You Sure?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: 'Yes',
            denyButtonText: 'Cancel'
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    method: "POST",
                    url: base_url+"Sale/deliveryStatusChange",
                    data:{
                        get_id: get_id,
                        type_val: type_val,
                    },
                    success: function (response) {
                        $('.ajax-message').html(`
                            <section class="alert-wrapper">
                                <div class="alert alert-success alert-dismissible fade show"> 
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    <div class="alert-body">
                                        <i class="m-right fa fa-check"></i>
                                        ${delivery_status}
                                    </div>
                                </div>
                            </section>
                        `);
                    }
                });
            }
        });
    });

});