$(function () {
    "use strict"
    let base_url = $('#base_url_').val();
    let network_printer = $('#network_printer').val();
    let windows_printer = $('#windows_printer').val();
    let are_you_sure = $('#are_you_sure').val();
    let yes = $('#yes').val();
    let cancel = $('#cancel').val();
    let alert = $('#alert').val();
    let no_permission_for_this_module = $('#no_permission_for_this_module').val();
    let ok = $("#ok").val();
    let warning = $('#warning').val();
    let update_success = $('#update_success').val();
    let insert_success = $('#insert_success').val();
    let delete_success = $('#delete_success').val();
    let title_required = $('#title_required').val();
    let Characters_Per_Line_required = $('#Characters_Per_Line_required').val();
    let Printer_IP_required = $('#Printer_IP_required').val();
    let Printer_Port_required = $('#Printer_Port_required').val();
    let Path_field_required = $('#Path_field_required').val();
    let Print_Server_URL_required = $('#Print_Server_URL_required').val();
    let Printer_Change_Successful = $('#Printer_Change_Successful').val();
    let Cash_Drawer_Change_Successful = $('#Cash_Drawer_Change_Successful').val();
    let Add_Printer = $('#Add_Printer').val();
    let Edit_Printer = $('#Edit_Printer').val();
    let select_ln = $('#select_ln').val();
    let insert_success_msg = `<section class="alert-wrapper">
                                <div class="alert alert-success alert-dismissible fade show"> 
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    <div class="alert-body">
                                        <i class="m-right fa fa-check"></i>
                                        ${insert_success}
                                    </div>
                                </div>
                            </section>`;

    let update_success_msg = `<section class="alert-wrapper">
                                <div class="alert alert-success alert-dismissible fade show"> 
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    <div class="alert-body">
                                        <i class="m-right fa fa-check"></i>
                                        ${update_success}
                                    </div>
                                </div>
                            </section>`;

    let delete_success_msg = `<section class="alert-wrapper">
                                <div class="alert alert-success alert-dismissible fade show"> 
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    <div class="alert-body">
                                        <i class="m-right fa fa-check"></i>
                                        ${delete_success}
                                    </div>
                                </div>
                            </section>`;



    
    function  printFieldHideShow(){
        let print_choise = $('#invoice_print').val();
        let print_format = $('#print_format').val();
        let inv_qr_code_status = $('#inv_qr_code_status').val();
        let printer_type  = $('.e_type ').val();
        if(print_choise == 'web_browser'){
            $('.hide_show_4').hide();
            $('.hide_show_5').hide();
            $('.hide_show_6').hide();
            $('.hide_show_7').hide();
            $('.hide_show_8').hide();
            $('.hide_show_9').hide();
            $('.hide_show_9').hide();
            $('.hide_show_10').hide();
            $('.hide_show_11').hide();
            $('.hide_show_1').show();
            if(print_format == '56mm' || print_format == '80mm'){
                $('.hide_show_2').show();
                if(inv_qr_code_status == 'Enable'){
                    $('.hide_show_3').show();
                } else {
                    $('.hide_show_3').hide();
                }
            }else{
                $('.hide_show_2').hide();
                $('.hide_show_3').hide();
            }
        } else if(print_choise == 'live_server_print'){
            $('.hide_show_1').hide();
            $('.hide_show_2').hide();
            $('.hide_show_3').hide();
            $('.hide_show_4').show();
            $('.hide_show_9').show();
            $('.hide_show_7').show();
            if(printer_type == 'network'){
                $('.hide_show_5').show();
                $('.hide_show_6').show();
                $('.hide_show_10').show();
                $('.hide_show_11').show();
            } else if(printer_type == 'windows'){
                $('.hide_show_7').show();
                $('.hide_show_8').show();

                $('.hide_show_5').hide();
                $('.hide_show_6').hide();

                $('.hide_show_10').hide();
                $('.hide_show_11').hide();
            }
        }
    }
    


    $(document).on('change','.e_type' , function(e){
        printFieldHideShow();
    });
    $(document).on('change','#print_format' , function(e){
        printFieldHideShow();
    });
    $(document).on('change','#inv_qr_code_status' , function(e){
        printFieldHideShow();
    });
    $(document).on('change','#invoice_print' , function(e){
        printFieldHideShow();
    });
   
    // Show All Printer Modal Data
    $(document).on('click', '.all_printers', function () {
        $.ajax({
            url: base_url + "Master/checkAccess",
            method: "GET",
            async: false,
            dataType: 'json',
            data: { controller: "14", function: "list" },
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
                    $("#allPrinters").modal('show');
                    fatchAllPrinters();
                }
            }
        });
    });


    // Add New Printer
    $(document).on('click', '.add_new_printer', function () {
        $.ajax({
            url: base_url + "Master/checkAccess",
            method: "GET",
            async: false,
            dataType: 'json',
            data: { controller: "14", function: "add" },
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
                    
                    resetFields();
                    $("#addPrinters").modal('show');
                    $('.modal_title').text(Add_Printer);
                    $('#edit_id').val('');
                    $('.e_type').html('').html(`
                        <option value="network">${network_printer}</option>
                        <option value="windows">${windows_printer}</option>
                    `);

                    printFieldHideShow();
                }
            }
        });
    });



    // Fetch API to show all data
    function fatchAllPrinters(){
        $.ajax({
            type: "GET",
            url: base_url+"Printer/printers",
            success: function (response) {
                $(".all_printer tbody").html("");
                $.each(response.data, function (key, item) { 
                    $(".all_printer tbody").append(`<tr>
                        <td>${key + 1}</td>
                        <td>${item.title}</td>
                        <td>${item.type}</td>
                        <td>${item.characters_per_line}</td>
                        <td>${item.printer_ip_address}</td>
                        <td>${item.printer_port}</td>
                        <td>${item.path}</td>
                        <td class="text-center">
                            <div class="btn_group_wrap">
                                <a class="btn btn-warning edit_printr_item" href="javascript:void(0)" data_id="${item.id}" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Edit">
                                    <i class="far fa-edit"></i>
                                </a>
                                <a class="delete btn btn-danger delete_item" href="javascript:void(0)" data_id="${item.id}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Delete">
                                    <i class="fa-regular fa-trash-can"></i>
                                </a>
                            </div>
                        </td>
                    </tr>`
                    );
                    $('.printer_table_trigger  [data-bs-toggle="tooltip"]').tooltip();
                });
            }
        });
    }
    fatchAllPrinters();

    // Add/Update Printer
    $(document).on('click', '.add_printer_submit', function(e){
        e.preventDefault();
        $.ajax({
            url: base_url + "Master/checkAccess",
            method: "GET",
            async: false,
            dataType: 'json',
            data: { controller: "14", function: "add" },
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
                    let error = false;
                    let title = $('.e_title').val();
                    let invoice_print = $('#invoice_print').val();
                    let type = $('.e_type').val();
                    let e_characters_per_line =  $('.e_characters_per_line').val();
                    let path_err_msg_contnr = $('.e_path').val();
                    let print_server_url_invoice = $('#print_server_url_invoice').val();
                    let e_printer_ip_address = $('.e_printer_ip_address').val();
                    let e_printer_port = $('.e_printer_port').val();

                    if (title == '') {
                        error = true;
                        $('.title_err_msg').text(title_required);
                        $('.title_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
                    }
                    if(invoice_print == 'live_server_print'){
                        if(type == 'network'){
                            if (e_printer_ip_address == '') {
                                error = true;
                                $('.printer_ip_address_err_msg').text(Printer_IP_required);
                                $('.printer_ip_address_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
                            }
                            if (e_printer_port == '') {
                                error = true;
                                $('.printer_port_err_msg').text(Printer_Port_required);
                                $('.printer_port_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
                            }
                        }else{
                            if (path_err_msg_contnr == '') {
                                error = true;
                                $('.path_err_msg').text(Path_field_required);
                                $('.path_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
                            }
                        }
                        if (e_characters_per_line == '') {
                            error = true;
                            $('.characters_per_line_err_msg').text(Characters_Per_Line_required);
                            $('.characters_per_line_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
                        }
                        if (print_server_url_invoice == '') {
                            error = true;
                            $('.print_server_url_err_msg').text(Path_field_required);
                            $('.print_server_url_err_msg_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
                        } 
                    }
                    let form_data = $('#add_printer_form').serialize();
                    let edit_id = $('#edit_id').val();
                    if(error == false){
                        if(edit_id){
                            $.ajax({
                                type: "POST",
                                url: base_url+"Printer/addEditPrinter/"+edit_id,
                                data: form_data,
                                dataType: "JSON",
                                success: function (response) {
                                    if(response.status == 'success'){
                                        $("#addPrinters").modal('hide');
                                        $('.ajax-modal-msg').html(`${update_success_msg}`);
                                        resetFields();
                                        setTimeout(function(){
                                            $('.ajax-modal-msg').html("");
                                        }, 3000);
                                        fatchAllPrinters();
                                    }
                                }
                            });
                        }else{
                            $.ajax({
                                type: "POST",
                                url: base_url+"Printer/addEditPrinter",
                                data: form_data,
                                dataType: "JSON",
                                success: function (response) {
                                    if(response.status == 'success'){
                                        let printer_html = `<option>Select</option>`;
                                        $.each(response.data, function (i, v) {
                                            printer_html += `<option value="${v.id}">${v.title}</option>`;
                                        });
                                        $("#counter_printer_id").html(printer_html);
                                        $("#counter_printer_id").val(response.printer_id).change();
      
                                        $("#addPrinters").modal('hide');
                                        $('.ajax-modal-msg').html(`${insert_success_msg}`);
                                        resetFields();
                                        setTimeout(function(){
                                            $('.ajax-modal-msg').html("");
                                        }, 3000);
                                        fatchAllPrinters();
                                    }
                                }
                            });
                        }
                    }
                }
            }
        });
    });


    // Edit Printer Data
    $(document).on('click', '.edit_printr_item', function(e){
        e.preventDefault();
        let himSelf = $(this);
        
        $.ajax({
            url: base_url + "Master/checkAccess",
            method: "GET",
            async: false,
            dataType: 'json',
            data: { controller: "14", function: "edit" },
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
                    $('.modal_title').text(Edit_Printer);
                    let item_id = himSelf.attr('data_id');
                    $("#addPrinters").modal('show');
                    $.ajax({
                        type: "POST",
                        url: base_url+"Printer/editPrinter",
                        data: {
                            item_id: item_id
                        },
                        success: function (response) {
                            if(response.status == 'success'){
                                $('#edit_id').val(response.data.id);
                                $('.e_title').val(response.data.title);
                                $('.e_characters_per_line').val(response.data.characters_per_line);
                                $('.e_printer_ip_address').val(response.data.printer_ip_address);
                                $('.e_printer_port').val(response.data.printer_port);
                                $('.e_path').val(response.data.path);
                                $('.e_type').html('').html(`
                                    <option ${response.data.type == 'network' ? 'selected' : '' } value="network">${network_printer}</option>
                                    <option ${response.data.type == 'windows' ? 'selected' : '' } value="windows">${windows_printer}</option>
                                `);
                                $('#invoice_print').html('').html(`
                                    <option ${response.data.invoice_print == 'web_browser' ? 'selected' : '' } value="web_browser">Browser Popup Print</option>
                                    <option ${response.data.invoice_print == 'live_server_print' ? 'selected' : '' } value="live_server_print">Direct Print</option>
                                `);
                                $('#print_server_url_invoice').val(response.data.print_server_url_invoice);
                                $('#print_format').html('').html(`
                                    <option ${response.data.print_format == 'No Print' ? 'selected' : '' } value="No Print">No Print</option>
                                    <option ${response.data.print_format == '56mm' ? 'selected' : '' } value="56mm">Tharmal 56mm</option>
                                    <option ${response.data.print_format == '80mm' ? 'selected' : '' } value="80mm">Tharmal 80mm</option>
                                    <option ${response.data.print_format == 'A4 Print' ? 'selected' : '' } value="A4 Print">A4 Print</option>
                                    <option ${response.data.print_format == 'Half A4 Print' ? 'selected' : '' } value="Half A4 Print">Half A4 Print</option>
                                    <option ${response.data.print_format == 'Letter Head' ? 'selected' : '' } value="Letter Head">Letter Head Print</option>
                                `);
                                $('#inv_qr_code_status').html('').html(`
                                    <option ${response.data.inv_qr_code_status == 'Enable' ? 'selected' : '' } value="Enable">Enable</option>
                                    <option ${response.data.inv_qr_code_status == 'Disable' ? 'selected' : '' } value="Disable">Disable</option>
                                `);
                                $('#qr_code_type').html('').html(`
                                    <option ${response.data.qr_code_type == 'Invoice Link' ? 'selected' : '' } value="Invoice Link">Invoice Link QR Code</option>
                                    <option ${response.data.qr_code_type == 'Zatca' ? 'selected' : '' } value="Zatca">Zatca QR Code</option>
                                `);
                                $('#fiscal_printer_status').html('').html(`
                                    <option ${response.data.fiscal_printer_status == 'ON' ? 'selected' : '' } value="ON">ON</option>
                                    <option ${response.data.fiscal_printer_status == 'OFF' ? 'selected' : '' } value="OFF">OFF</option>
                                `);
                                $('#open_cash_drawer').html('').html(`
                                    <option ${response.data.open_cash_drawer_when_printing_invoice == 'ON' ? 'selected' : '' } value="ON">ON</option>
                                    <option ${response.data.open_cash_drawer_when_printing_invoice == 'OFF' ? 'selected' : '' } value="OFF">OFF</option>
                                `);
                            }
                        }
                    });
                }
            }
        });
        setTimeout(function(){
            printFieldHideShow();
        }, 200)
    });


    // Reset Trigger to cleane input field old data
    $(document).on('click', '.reset_trigger', function(){
        resetFields();
    });
    resetFields();
    function resetFields(){
        $('.e_title').val('');
        $('.e_characters_per_line').val('');
        $('.e_printer_ip_address').val('');
        $('.e_printer_port').val('');
        $('.e_path').val('');
        $(".e_type" ).trigger("change");
        $("#fiscal_printer_status" ).trigger("change");
    }

    // Delete Printer
    $(document).on('click', '.delete_item', function () { 
        let data_id = $(this).attr('data_id');
        $.ajax({
            url: base_url + "Master/checkAccess",
            method: "GET",
            async: false,
            dataType: 'json',
            data: { controller: "14", function: "delete" },
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
                                method: "GET",
                                url: base_url+"Printer/deletePrinter/"+data_id,
                                success: function (response) {
                                    if(response.status == 'success'){
                                        $('.ajax-modal-msg').html(`${delete_success_msg}`);
                                        setTimeout(function(){
                                            $('.ajax-modal-msg').html("");
                                        }, 3000);
                                        fatchAllPrinters();
                                    }
                                }
                            });
                        }
                    });
                }
            }
        });
    });



    // Assign Printer
    $(document).on('click', '.allAssignPrinterTrigger', function(e){
        e.preventDefault();
        $.ajax({
            url: base_url + "Master/checkAccess",
            method: "GET",
            async: false,
            dataType: 'json',
            data: { controller: "21", function: "edit" },
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
                    $('#allAssignPrinter').modal('show');
                    $.ajax({
                        type: "GET",
                        url: base_url+"Printer/listAssignPrinter",
                        success: function (response) {
                            if(response.status == 'success'){
                                $(".assignerPrinters tbody").html("");
                                $.each(response.data.cashiers, function (keyC, itemC) { 
                                    let printer = '';
                                    $.each(response.data.printers, function (keyP, itemP) { 
                                        printer += `<option ${itemC.printer_id == itemP.id ? 'selected' : '' } value="${itemP.id}">
                                                    ${itemP.title}
                                                </option>`
                                    });
                                    $(".assignerPrinters tbody").append(`<tr data_cashier="${itemC.id}">
                                            <td>${keyC + 1}</td>
                                            <td>${itemC.full_name}</td>
                                            <td>
                                                <div class="form-group">
                                                    <select class="form-control select2 on_change_printer" id="cashier_printer" name="cashier_printer">
                                                        <option>${select_ln}</option>
                                                        ${printer}
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <select class="form-control select2 on_change_cash_drawer" id="open_cash_drawer" name="open_cash_drawer">
                                                        <option ${itemC.open_cash_drawer == "No" ? 'selected' : ''} value="No">No</option>
                                                        <option ${itemC.open_cash_drawer == "Yes" ? 'selected' : ''} value="Yes">Yes</option>
                                                    </select>
                                                </div>
                                            </td>
                                        </tr>`
                                    );
                                });
                                $('.select2').select2();

                            }
                        }
                    });
                }
            }
        });
    });



    // Table Dropdown Css
    $(document).on('click', '.printer_table_trigger .dropdown-toggle', function(){
        $('.dropdown-menu-right').css('inset', '0px auto auto -12px');
    });

    // Change Printer Status
    $(document).on('change', '.on_change_printer', function (e) {
        e.preventDefault();
        let himSelf = $(this);
        $.ajax({
            url: base_url + "Master/checkAccess",
            method: "GET",
            async: false,
            dataType: 'json',
            data: { controller: "21", function: "edit" },
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
                    let cashier_id = himSelf.parent().parent().attr('data_cashier');
                    let cashier_printer = himSelf.val();
                    $.ajax({
                        type: "POST",
                        url: base_url+"Printer/assignPrinter",
                        data: {cashier_id : cashier_id, cashier_printer: cashier_printer},
                        dataType: "JSON",
                        success: function (response) {
                            if(response.status == 'success'){
                                if(response.status == 'success'){
                                    toastr['success']((Printer_Change_Successful), '');
                                }
                            }
                        }
                    });
                }
            }
        });
    });


    // Change Cashier Drawer Status
    $(document).on('change', '.on_change_cash_drawer', function (e) {
        e.preventDefault();
        let himSelf = $(this);
        $.ajax({
            url: base_url + "Master/checkAccess",
            method: "GET",
            async: false,
            dataType: 'json',
            data: { controller: "21", function: "edit" },
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
                    let cashier_id = himSelf.parent().parent().attr('data_cashier');
                    let open_cash_drawer = himSelf.val();
                    $.ajax({
                        type: "POST",
                        url: base_url+"Printer/changeCashDrawer",
                        data: {cashier_id : cashier_id, open_cash_drawer: open_cash_drawer},
                        dataType: "JSON",
                        success: function (response) {
                            if(response.status == 'success'){
                                toastr['success']((Cash_Drawer_Change_Successful), '');
                            }
                        }
                    });
                }
            }
        });
    });

});
  