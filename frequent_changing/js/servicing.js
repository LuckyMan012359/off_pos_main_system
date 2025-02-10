$(function () {
    "use strict";
    let base_url = $('#base_url_').val();
    let status_change = $('#status_change').val();
    let no_permission_for_this_module = $('#no_permission_for_this_module').val();
    let ok = $("#ok").val();
    let warning = $('#warning').val();
    

    $(document).on('change', '#status', function (e) { 
        e.preventDefault();
        let himself = $(this);
        $.ajax({
            url: base_url + "Master/checkAccess",
            method: "GET",
            async: false,
            dataType: 'json',
            data: { controller: "75", function: "status" },
            success: function (response) {
                if (response == false) {
                    Swal.fire({
                        title: "Alert !",
                        text: no_permission_for_this_module,
                        showDenyButton: false,
                        showCancelButton: false,
                        confirmButtonText: ok,
                    });
                } else {
                    let id = $(himself).attr('item-id');
                    let current_status = $(himself).val();
                    Swal.fire({
                        title: warning+" !",
                        text: "Do you want to save the changes?",
                        showDenyButton: true,
                        showCancelButton: false,
                        confirmButtonText: "Save",
                        denyButtonText: `Don't save`
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "POST",
                                url: base_url+"Servicing/changeStatus/"+id,
                                data: { current_status : current_status},
                                datatype: 'json',
                                success: function (response) {
                                    if(response.status == '200'){
                                        $('#message').append(`
                                            <section class="alert-wrapper">
                                                <div class="alert alert-success alert-dismissible fade show"> 
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>
                                                    <div class="alert-body"><i class="icon fa fa-check"></i>${status_change}</div>
                                                </div>
                                            </section>
                                        `);
                                        setTimeout(function() {
                                            $('#message').html('');
                                        }, 2000);
                                    } 
                                }
                            });
                        } 
                    });
                }
            }
        });
        
    });

    $(document).on('click', '.view_invoice', function() {
        viewInvoice($(this).attr('invoice_id'));
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
        }else{
            Swal.fire({
                title: warning+" !",
                text: "Your Printer is not configured yet!",
                showDenyButton: false,
                showCancelButton: false,
                confirmButtonText: "OK",
            });
        }
    }

})