$(function () {
    "use strict";
    let base_url_ = $("#base_url_").val();
    let csrf_value_= $("#csrf_value_").val();
    let date_required= $("#date_required").val();
    let customer_id_required= $("#customer_id_required").val();
    let account_field_required= $("#account_field_required").val();
    let sale_invoice_no_required= $("#sale_invoice_no_required").val();
    let item_id_required= $("#item_id_required").val();
    let return_price_alert= $("#return_price_alert").val();
    let op_precision = $("#op_precision").val();
    let return_quantity_alert = $("#return_quantity_alert").val();
    let warning = $("#warning").val();
    let ok = $("#ok").val();
    let are_you_sure = $("#are_you_sure").val();
    let yes = $("#yes").val();
    let cancel = $("#cancel").val();
    let sale_qty_ln = $("#sale_qty").val();
    let return_qty_ln = $("#return_qty").val();
    let return_unit_price_ln = $("#return_unit_price").val();
    let sale_unit_price_ln = $("#sale_unit_price").val();
    let is_edit = $("#is_edit").val();



    $(document).on('change', '#customer_id', function() {
        let customer_id = $(this).val();
        customerOnChange(customer_id);
    });

    function customerOnChange(customer_id, old_slae_id = '', clear_cart=''){
        if(clear_cart != 'Clear Cart'){
            $('#saleReturn_cart tbody').html('');
        }
        $.ajax({
            url: base_url_+'Sale_return/getCustomerSales',
            method:"POST",
            data:{
                customer_id : customer_id, 
                old_slae_id : old_slae_id, 
                csrf_name_: csrf_value_
            },
            success:function(response) {
              $("#sale_id").html(response);
            },
            error:function(){
                alert("error");
            }
        }); 
    }
    setTimeout(function(){
        let customer_id = $('#customer_id').val();
        let old_slae_id = $('#old_slae_id').val();
        customerOnChange(customer_id, old_slae_id, 'Clear Cart');
    }, 300)

    $(document).on('change', '#sale_id', function() {
        let sale_id = $('#sale_id').val();
        $('#saleReturn_cart tbody').html('');
        $.ajax({
            url: base_url_+'Sale_return/getItemsOfSale',
            method:"POST",
            data:{
                sale_id : sale_id, 
                csrf_name_: csrf_value_
            },
            success:function(response) { 
              $("#item_id").html(response);
            },
            error:function(){
                alert("error");
            }
        }); 
        calculateAll();
    });

    $(document).on('change', '#item_id', function() {
        let error = false;
        let value = $(this).val();
        let value1 = value.split("|");


        $(".rowCount").each(function() {
            let id_temp = $(this).attr('data-item_id');
            if(id_temp == (value1[0])){
                Swal.fire({
                    title: warning+" !",
                    text: "This Item already exist!",
                    showDenyButton: false,
                    showCancelButton: false,
                    confirmButtonText: ok,
                });
                error =  true;
            }
        });

        if(error == true){
            return false;
        }


        $.ajax({
            url: base_url_+'Sale_return/getSaleItemDetails',
            method:"POST",
            data:{
                item_id : value1[0], 
                sales_id : value1[1],
                csrf_name_: csrf_value_
            },
            success:function(response) {
                let data = JSON.parse(response);
                let item_id = data.item_id;
                let sale_id = data.sale_id;
                let item_name = value1[2];
                let item_type = value1[3];
                let expiry_imei_serial = value1[4];
                let sale_qty = data.qty;
                let unit_name = data.unit_name;
                let sale_unit_price = data.menu_price_with_discount / data.qty;
                appendCart(item_id, sale_id, item_name,sale_qty, sale_unit_price, unit_name, item_type, expiry_imei_serial)
            },
            error:function(){
                alert("error");
            }
        }); 
    });


    



    $(document).on('click', '.deleter_op', function (e) { 
        e.preventDefault();
        let deleter_unique = $(this).attr('deleter_uniq');
        Swal.fire({
            title: warning + "!",
            text: are_you_sure,
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: yes,
            denyButtonText: cancel
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $('#saleReturn_cart tbody').find('#row_'+deleter_unique).remove();
                calculateAll();
            }
        });
    });


    $(document).on('keyup', '.calculate_op', function() {
        calculateAll();
	});


    function calculateAll() {
        let subtotal = 0;
        let i = 1;
        $(".rowCount").each(function () {
            let id = $(this).attr("data-id");
            let temp = "#sl_" + id;
            $(temp).html(i)
            i++;
            let return_qty = $("#return_quantity_amount_" + id).val();
            let return_unit_price = $("#unit_price_in_return_" + id).val();
            if ($.trim(return_qty) == "" || $.isNumeric(return_qty) == false) {
                return_qty = 0;
            }
            if ($.trim(return_unit_price) == "" || $.isNumeric(return_unit_price) == false) {
                return_unit_price = 0;
            }
            $("#total_" + id).val(parseFloat(return_qty) * parseFloat(return_unit_price));
            subtotal += parseFloat(return_qty) * parseFloat(return_unit_price);
        });
        if (isNaN(subtotal)) {
            subtotal = 0;
        }

        //foraddDiscount
        let disc = $("#discount").val();
        let totalDiscount = 0;
        if ($.trim(disc) == '' || $.trim(disc) == '%' || $.trim(disc) == '%%' || $.trim(disc) == '%%%' || $.trim(
            disc) == '%%%%') {
            totalDiscount = 0;
        } else {
            let Disc_fields = disc.split('%');
            console.log(Disc_fields);
            let discAmount = Disc_fields[0];
            let discP = Disc_fields[1];

            if (discP == "") {
                totalDiscount = (subtotal * (parseFloat($.trim(discAmount)) / 100));
            } else {
                if (!disc) {
                    discAmount = 0;
                }
                totalDiscount = parseFloat(discAmount);
            }
        }


        $("#subtotal").val(subtotal);
        let other = parseFloat($.trim($("#other").val()));
        if ($.trim(other) == "" || $.isNumeric(other) == false) {
            other = 0;
        }
        let grand_total = parseFloat(subtotal) + parseFloat(other) - parseFloat(totalDiscount);
        grand_total = Number(grand_total).toFixed(op_precision);
        $("#grand_total").val(grand_total);
        let paid = $("#paid").val();

        if ($.trim(paid) == "" || $.isNumeric(paid) == false) {
            paid = 0;
        }
        if (Number(paid) == 0) {
            $("#payment_method_id").prop("disabled", true);

        } else {
            $("#payment_method_id").prop("disabled", false);
        }
        let due = parseFloat(grand_total) - parseFloat(paid);
        $("#due").val(due.toFixed(op_precision));
    }


    let suffix = 0;
    function appendCart(item_id, sale_id, item_name, sale_qty, unit_price, unit_name, item_type, expiry_imei_serial) {
        suffix ++;
        let cart_row = '';
        let imeiSerial = '';
        if(item_type == "IMEI_Product" || item_type == 'Serial_Product'){
            imeiSerial = `<div class="d-flex align-items-center form-group">
            <small class="pe-1">${item_type == "IMEI_Product" ? 'IMEI:' : 'Serial:'}</small>
            <input readonly type="text" id="expiry_imei_serial${suffix}" name="expiry_imei_serial[]" class="form-control" value="${expiry_imei_serial}"/></div>`;
        }else{
            imeiSerial = `<input readonly type="hidden" id="expiry_imei_serial${suffix}" name="expiry_imei_serial[]" value="${expiry_imei_serial}"/>`;
        }
        cart_row = `<tr class="rowCount" data-id="${suffix}" data-item_id="${item_id}" id="row_${suffix}">
            <td>
                <p id="sl_${suffix}">${suffix}</p>
            </td>
            <td>
                <span>${item_name}</span>
            </td>
            <td>
                ${imeiSerial}
            </td>
            <td>
                <input type="hidden" id="item_id_${suffix}" name="item_id[]" value="${item_id}"/>
                <input type="hidden" id="item_type${suffix}" name="item_type[]" value="${item_type}"/>
                <input type="hidden" id="sale_item_id_${suffix}" name="sale_item_id[]" value="${sale_id}"/>
                <div class="input-group">
                    <input type="text" autocomplete="off" name="sale_quantity_amount[]" id="sale_quantity_amount_${suffix}" onfocus="this.select();" class="form-control integerchk1 calculate_op sale_quantity_amount" placeholder="${sale_qty_ln}"  value="${sale_qty}"  aria-describedby="basic-addon2">
                    <span class="input-group-text" id="basic-addon2">${unit_name}</span>
                </div>
            </td>
            <td>
                <div class="input-group">
                    <input data-countid="${suffix}" type="text" placeholder="${return_qty_ln}" autocomplete="off" id="return_quantity_amount_${suffix}" name="return_quantity_amount[]" onfocus="this.select();" class="form-control integerchk1 calculate_op return_quantity_amount countID" aria-describedby="basic-addon2"/>
                    <span class="input-group-text" id="basic-addon2">${unit_name}</span>
                </div>
                <p class="return_qty_err"></p>
            </td>
            <td>
                <div class="form-group">
                    <div class="d-flex align-items-center">
                        <input readonly type="text" autocomplete="off" id="unit_price_in_sale_${suffix}" name="unit_price_in_sale[]" onfocus="this.select();" class="form-control integerchk1 calculate_op unit_price_in_sale" placeholder="${sale_unit_price_ln}" value="${(Number(unit_price).toFixed(op_precision))}"/>
                    </div>
                </div>
            </td>
            <td>
                <div class="form-group">
                    <div class="d-flex align-items-center">
                        <input data-countid="${suffix}" type="text" autocomplete="off" id="unit_price_in_return_${suffix}" name="unit_price_in_return[]" onfocus="this.select();" class="form-control integerchk1 calculate_op unit_price_in_return countID" placeholder="${return_unit_price_ln}" value=""/>
                    </div>
                    <p class="return_sale_price_err"></p>
                </div>
            </td>
            <td>
                <div class="form-group">
                    <div class="d-flex align-items-center">
                        <input type="text" autocomplete="off" id="total_${suffix}" name="total[]" class="form-control aligning total" value="${Number(0).toFixed(op_precision)}" readonly />
                    </div>
                </div>
            </td>
            <td>
                <button type="button" class="new-btn-danger deleter_op h-40"  deleter_uniq="${suffix}" id="deleter_uniq_${suffix}">
                    <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="18"></iconify-icon>
                </button>
            </td>
        </tr>`;
        $('#saleReturn_cart tbody').prepend(cart_row);
        calculateAll();
    }


    $(document).on('keyup', '.return_quantity_amount', function(e){
        e.preventDefault();
        let return_qty = $(this).val();
        let sale_qty = $(this).parent().parent().parent().find('.sale_quantity_amount').val();
        let return_unit_price = $(this).parent().parent().parent().find('.unit_price_in_return').val();
        let total = Number(return_qty) * Number(return_unit_price);
        if(Number(sale_qty) < Number(return_qty)){
            $(this).parent().parent().parent().find('.return_qty_err').html(`<p class="common_err">${return_quantity_alert}</p>`);
        }else{
            $(this).parent().parent().parent().find('.total').val(Number(total).toFixed(op_precision));
            $(this).parent().parent().parent().find('.return_qty_err').html('');
        }
        calculateAll();
    });
    $(document).on('keyup', '.unit_price_in_return', function(e){
        e.preventDefault();
        let unit_price_in_sale = $(this).parent().parent().parent().find('.unit_price_in_sale').val();
        let return_price = $(this).val();
        let return_qty = $(this).parent().parent().parent().find('.return_quantity_amount').val();
        let total = Number(return_qty) * Number(return_price);
        if(Number(unit_price_in_sale) < Number(return_price)){
            $(this).parent().parent().parent().find('.return_sale_price_err').html(`<p class="common_err">${return_price_alert}</p>`);
        }else{
            $(this).parent().parent().parent().find('.return_sale_price_err').html('');
            $(this).parent().parent().parent().find('.total').val(Number(total).toFixed(op_precision));
        }
        calculateAll();
    });



    $(document).on('keyup', '.discount', function (e) {
        let input = $(this).val();
        let ponto = input.split('.').length;
        let slash = input.split('-').length;
        if (ponto > 2)
            $(this).val(input.substr(0, (input.length) - 1));
        $(this).val(input.replace(/[^0-9.%]/, ''));
        if (slash > 2)
            $(this).val(input.substr(0, (input.length) - 1));
        if (ponto == 2)
            $(this).val(input.substr(0, (input.indexOf('.') + 4)));
        if (input == '.')
            $(this).val("");
        calculateAll();
    });


    // Validate form
    $(document).on('submit', '#sale_return_form', function() {

        let error = false;
        let date = $("#date").val();
        let customer_id = $("#customer_id").val();
        let payment_method_id = $("#payment_method_id").val();
        let sale_id = $("#sale_id").val();
        let paid = Number($("#paid").val());
        let item_id = $("#item_id").val();
        let return_qty_err = $('.return_qty_err').html();
        let return_sale_price_err = $('.return_sale_price_err').html();
        if(return_qty_err){
            error = true;
        }
        if(return_sale_price_err){
            error = true;
        }
        if(date==""){ 
            $("#date_err_msg").text(date_required);
            $(".date_err_msg_contnr").show();
            error = true;
        }else{
            $("#date_err_msg").text("");
            $(".date_err_msg_contnr").hide();
        } 
        if(customer_id==""){ 
            $("#customer_id_err_msg").text(customer_id_required);
            $(".customer_id_err_msg_contnr").show();
            error = true;
        }else{
            $("#customer_id_err_msg").text("");
            $(".customer_id_err_msg_contnr").hide();
        } 
        if(paid){
            if(payment_method_id==""){ 
                $("#payment_method_id_err_msg").text(account_field_required);
                $(".payment_method_id_err_msg_contnr").show();
                error = true;
            }else{
                $("#payment_method_id_err_msg").text("");
                $(".payment_method_id_err_msg_contnr").hide();
            } 
        }


        let itemCount = $("#saleReturn_cart tbody tr").length;
        if (itemCount < 1) {
            error = true;
        }


        if(is_edit == 'No' && sale_id=="" && itemCount == 0){ 
            $("#sale_id_err_msg").text(sale_invoice_no_required);
            $(".sale_id_err_msg_contnr").show();
            error = true;
        }else{
            $("#sale_id_err_msg").text("");
            $(".sale_id_err_msg_contnr").hide();
        } 
        if(is_edit == 'No' && item_id=="" && itemCount == 0){ 
            $("#item_id_err_msg").text(item_id_required);
            $(".item_id_err_msg_contnr").show();
            error = true;
        }else{
            $("#item_id_err_msg").text("");
            $(".item_id_err_msg_contnr").hide();
        } 
        

        if(is_edit == 'Yes' && sale_id=="" && itemCount == 0){ 
            $("#sale_id_err_msg").text(sale_invoice_no_required);
            $(".sale_id_err_msg_contnr").show();
            error = true;
        }else{
            $("#sale_id_err_msg").text("");
            $(".sale_id_err_msg_contnr").hide();
        } 
        if(is_edit == 'Yes' && item_id=="" && itemCount == 0){ 
            $("#item_id_err_msg").text(item_id_required);
            $(".item_id_err_msg_contnr").show();
            error = true;
        }else{
            $("#item_id_err_msg").text("");
            $(".item_id_err_msg_contnr").hide();
        } 

        $(".countID").each(function () {
            let index = $(this).attr("data-countid");
            let return_quantity_amount = $("#return_quantity_amount_" + index).val();
            if (return_quantity_amount == '' || isNaN(return_quantity_amount)) {
                $("#return_quantity_amount_" + index).css({
                    "border-color": "red"
                }).show(200).delay(2000, function () {
                    $("#return_quantity_amount_" + index).css({
                        "border-color": "#d2d6de"
                    });
                });
                error = true;
            }else{
                $("#return_quantity_amount_" + index).css({
                    "border-color": "#d2d6de",
                });
            }
            let unit_price_in_return = $.trim($("#unit_price_in_return_" + index).val());
            if (unit_price_in_return == '' || isNaN(unit_price_in_return)) {
                $("#unit_price_in_return_" + index).css({
                    "border-color": "red"
                }).show(200).delay(2000, function () {
                    $("#unit_price_in_return_" + index).css({
                        "border-color": "#d2d6de"
                    });
                });
                error = true;
            }else{
                $("#unit_price_in_return_" + index).css({
                    "border-color": "#d2d6de",
                });
            }
        });
        if(error == true){
            return false;
        }
    });


    
    $(document).on('keydown', '.integerchk1', function(e){ 
        let keys = e.which || e.keyCode;
        return (
        keys == 8 ||
            keys == 9 ||
            keys == 13 ||
            keys == 46 ||
            keys == 110 ||
            keys == 86 ||
            keys == 190 ||
            (keys >= 35 && keys <= 40) ||
            (keys >= 48 && keys <= 57) ||
            (keys >= 96 && keys <= 105));
    });
    $(document).on('keyup', '.integerchk1', function(e){
        let input = $(this).val();
        let ponto = input.split('.').length;
        let slash = input.split('-').length;
        if (ponto > 2)
            $(this).val(input.substr(0,(input.length)-1));
        $(this).val(input.replace(/[^0-9]/,''));
        if(slash > 2)
            $(this).val(input.substr(0,(input.length)-1));
        if (ponto ==2)
            $(this).val(input.substr(0,(input.indexOf('.')+4)));
        if(input == '.')
            $(this).val("");
    });
});