$(function () {
    "use strict";
    let account_field_required = $("#account_field_required").val();
    let total_amount_equal_check_sale_total = $("#total_amount_equal_check_sale_total").val();
    let base_url = $("#base_url").val();
    let alert_msg = $("#alert").val();
    let cancel_msg = $("#cancel").val();
    let op_precision = $("#op_precision").val();
    let check_issue_date = $("#check_issue_date").val();
    let check_no = $("#check_no").val();
    let check_expiry_date = $("#check_expiry_date").val();
    let mobile_no = $("#mobile_no").val();
    let transaction_no = $("#transaction_no").val();
    let card_holder_name = $("#card_holder_name").val();
    let card_holding_number = $("#card_holding_number").val();
    let paypal_email = $("#paypal_email").val();
    let stripe_email = $("#stripe_email").val();
    let note = $("#note").val();
    let The_customer_field_is_required = $('#The_customer_field_is_required').val();
    let The_items_field_is_required = $('#The_items_field_is_required').val();
    let The_price_field_is_required = $('#The_price_field_is_required').val();
    let The_number_of_installment_required = $('#The_number_of_installment_required').val();
    let The_total_field_is_required = $('#The_total_field_is_required').val();
    let The_installment_duration_field_is_required = $('#The_installment_duration_field_is_required').val();
    let The_down_payment_field_is_required = $('#The_down_payment_field_is_required').val();
    let The_remaining_field_is_required = $('#The_remaining_field_is_required').val();

    $(document).on('keydown', '.discount', function(e){
        let keys = e.charCode || e.keyCode || 0;
        // allow backspace, tab, delete, enter, arrows, numbers and keypad numbers ONLY
        // home, end, period, and numpad decimal
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

    $(document).on('keyup', '.discount', function(e){
        let input = $(this).val();
        let ponto = input.split('.').length;
        let slash = input.split('-').length;
        if (ponto > 2)
            $(this).val(input.substr(0,(input.length)-1));
        $(this).val(input.replace(/[^0-9.%]/,''));
        if(slash > 2)
            $(this).val(input.substr(0,(input.length)-1));
        if (ponto ==2)
            $(this).val(input.substr(0,(input.indexOf('.')+4)));
        if(input == '.')
            $(this).val("");

    });

    $(document).on('submit', '#installment_form', function(e){
        let error=false;
        let down_payment=$('#down_payment_cal').val();
        if(Number(down_payment)>0){ 
            let payment_method_id = $("#payment_method_id").val();
            if(payment_method_id==""){
                $("#payment_method_id_err_msg").text(account_field_required);
                $(".payment_method_id_err_msg_contnr").show(200);
                error = true;
            }
        }
        let item_type=$('#item_type').val();
        if(item_type == 'IMEI_Product' || item_type == 'Serial_Product') { 
            let expiry_imei_serial=$('#expiry_imei_serial').val();
            if(expiry_imei_serial == ""){
                $("#imei_serial_field_err_msg").text(`The ${item_type == 'IMEI_Product' ? 'IMEI' : 'Serial'} number field is requied`);
                $(".imei_serial_field_err_msg_contnr").show(200);
                error = true;
            }
        }
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
    
    $(document).on('keyup', '#down_payment_cal', function(){ 
        let amount = $(this).val();
        if(Number(amount)==0){              
            $("#payment_method_id").prop("disabled", true);          
        }else{            
            $("#payment_method_id").prop("disabled", false);
        }
    }); 

    $(document).on('change click','.item_id',function(){
        imeiSerialFieldHideShow();
        let item_id = $('option:selected', this).val();
        let item_type = $('option:selected', this).attr('data-item-type');
        let price = $('option:selected', this).attr('data-price');
        let item_name = $('option:selected', this).text();
        let old_imei_serial = $('#expiry_imei_serial').val();
        $('.modal_hidden_type').val(item_type);
        if(item_type == 'IMEI_Product' || item_type == 'Serial_Product'){
            $('.imei_serial_label').text(`${item_type == 'IMEI_Product' ? 'IMEI' : 'Serial'} Number`);
            $('#imei_serial_modal .modal-title').text(`${item_name}`);
            $.ajax({
                url: base_url + "Sale/getIMEISerial",
                method: "POST",
                async: false,
                dataType: 'json',
                data: { item_id: item_id },
                success: function (response) {
                    let imeiHtml = '';
                    imeiHtml = `<option value="">Select ${item_type == 'IMEI_Product' ? 'IMEI' : 'Serial'}</option>`;
                    if(response.data.allimei){
                        let stockIMEI = response.data.allimei.split("||");
                        $.each(stockIMEI, function (i, v) { 
                            imeiHtml += `<option ${$.trim(old_imei_serial) == $.trim(v) ? 'selected' : '' } value="${$.trim(v)}">${$.trim(v)}</option>`;
                        });
                    }
                    $('#IMEI_Serial').html('');
                    $('#IMEI_Serial').append(imeiHtml);
                }
            });
            $('#imei_serial_modal').modal('show');
        }
        $("#price").val(Number(price ? price : 0).toFixed(op_precision));
        calculate();
    });


    function imeiSerialFieldHideShow(){
        let item_type = $('option:selected', '.item_id').attr('data-item-type');
        if(item_type == 'IMEI_Product' || item_type == 'Serial_Product'){
            $('.imeiSerialHideShow').show();
        }else{
            $('.imeiSerialHideShow').hide();
        }
    }
    imeiSerialFieldHideShow();


    $(document).on('click', '#imei_serial_submit', function(){
        let error = false;
        let item_type = $('.modal_hidden_type').val();
        let imei_serial = $('#IMEI_Serial').val();
        if(imei_serial == ''){
            error = true;
            $("#imei_serial_err_msg").text(`The ${item_type == 'IMEI_Product' ? 'IMEI' : 'Serial'} number field is requied`);
            $(".imei_serial_err_msg_contnr").show(200);
        }
        if(error == true){
            return false;
        }else{
            $('#item_type').val($.trim(item_type));
            $('#expiry_imei_serial').val($.trim(imei_serial));
            $('#imei_serial_modal').modal('hide');
        }
    });



    $(document).on('click','.next_button',function(e){
        e.preventDefault();
        let error = false;
        let item_id = $('#item_id').val();
        let price = $('#price').val();
        let number_of_installment = Number($("#number_of_installment").val());
        let total = $('#total').val();
        let installment_type = Number($("#installment_type").val());
        if(item_id == ''){
            error = true;
            $('#item_id_err_msg').text(The_items_field_is_required);
            $('.item_id_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
        }
        if(price == ''){
            error = true;
            $('#price_err_msg').text(The_price_field_is_required);
            $('.price_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
        }
        if(number_of_installment == ''){
            error = true;
            $('#number_of_installment_err_msg').text(The_number_of_installment_required);
            $('.number_of_installment_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
        }
        if(total == ''){
            error = true;
            $('#total_err_msg').text(The_total_field_is_required);
            $('.total_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
        }
        if(installment_type == ''){
            error = true;
            $('#installment_duration_err_msg').text(The_installment_duration_field_is_required);
            $('.installment_duration_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
        }
        if(error == true){
            return false;
        }
        let html = '';
        let selected_date = $(".date").val();
        let remaining = Number($("#remaining").val());
        let divided_remaining = remaining/number_of_installment;
        let divided_result_floor = Math.floor(divided_remaining);
        let divided_result_floor_mul = divided_result_floor*number_of_installment;
        let total_divided_last_value = remaining-divided_result_floor_mul;
        let first_value = divided_result_floor+total_divided_last_value;
        let installment_type_temp = installment_type;
        for(let i=1;i<=number_of_installment;i++){
            let d = new Date(selected_date);
            let next_month = new Date(d.setDate(d.getDate() + installment_type_temp));
            let rightNow = new Date();
            let output_date = next_month.toISOString().slice(0,10).replace(/-/g,"-");
            if(i==1){
                html += `
                    <tr>
                        <td valign="middle">${i}</td>
                        <td>
                            <div class="form-group">
                                <input type="hidden" name="paid_status[]" value="Unpaid">
                                <input type="text" class="form-control amount_of_payment check_required integerchk1" value="${(first_value).toFixed(op_precision)}" onfocus="select()" name="amount_of_payment[]">
                            </div>
                        </td>
                        <td>
                        <div class="form-group">
                            <input type="text" class="form-control customDatepicker check_required" value="${output_date}" readonly name="payment_date[]">
                        </div>
                        </td>
                        <td>
                            <button type="button" class="new-btn-danger h-40">
                                <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="18" class="delete_row del-btn-c"></iconify-icon>
                            </button>
                        </td>
                    </tr>`;
            }else{
                html+=`
                    <tr>
                        <td>${i}</td>
                        <td>
                            <div class="form-group">
                                <input type="hidden" name="paid_status[]" value="Unpaid">
                                <input type="text" class="form-control amount_of_payment check_required integerchk1" value="${(divided_result_floor).toFixed(op_precision)}" onfocus="select()" name="amount_of_payment[]">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input type="text" class="form-control customDatepicker  check_required" value="${output_date}" readonly name="payment_date[]">
                            </div>
                        </td>
                        <td>
                            <button type="button" class="new-btn-danger h-40">
                                <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="18" class="delete_row del-btn-c"></iconify-icon>
                            </button>
                        </td>
                    </tr>`;
            }
            installment_type_temp = installment_type_temp+installment_type;
        }
        $(".show_tb_data").html(html);
        calculateAddedAmount();
        $('.customDatepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });
    });

    $(document).on('keyup','.change_data',function(e){
        e.preventDefault();
        calculate();
    });

    $(document).on('click','.check_required_field',function(e){
        let error = false;
        let customer_id = $('#customer_id').val();
        let item_id = $('#item_id').val();
        let price = $('#price').val();
        let number_of_installment = $('#number_of_installment').val();
        let percentage_of_interest = $('#percentage_of_interest').val();
        let total = $('#total').val();
        let down_payment_cal = $('#down_payment_cal').val();
        let remaining = $('#remaining').val();
        let installment_type = $('#installment_type').val();

        if(customer_id == ''){
            error = true;
            $('#customer_id_err_msg').text(The_customer_field_is_required);
            $('.customer_id_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
        }
        if(item_id == ''){
            error = true;
            $('#item_id_err_msg').text(The_items_field_is_required);
            $('.item_id_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
        }
        if(price == ''){
            error = true;
            $('#price_err_msg').text(The_price_field_is_required);
            $('.price_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
        }
        if(number_of_installment == ''){
            error = true;
            $('#number_of_installment_err_msg').text(The_number_of_installment_required);
            $('.number_of_installment_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
        }
        if(percentage_of_interest == ''){
            error = true;
            $('#percentage_of_interest_err_msg').text(The_down_payment_field_is_required);
            $('.percentage_of_interest_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
        }
        if(total == ''){
            error = true;
            $('#total_err_msg').text(The_total_field_is_required);
            $('.total_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
        }
        if(remaining == ''){
            error = true;
            $('#remaining_err_msg').text(The_remaining_field_is_required);
            $('.remaining_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
        }
        if(installment_type == ''){
            error = true;
            $('#installment_duration_err_msg').text(The_installment_duration_field_is_required);
            $('.installment_duration_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
        }

        $(".amount_of_payment").each(function () {
            let this_value = $(this).val();
            if(this_value == '' || isNaN(this_value) || !(Number(this_value))){
                $(this).css({"border-color":"red"});
                error = true;
            }else{
                $(this).css({"border":"1px solid #ccc"});
            }
        });

        let total_amount =Number($(".total_amount").text());
        if(remaining!=total_amount){
            Swal.fire({
                title: "Warning !",
                text: total_amount_equal_check_sale_total,
                showDenyButton: false,
                showCancelButton: false,
                confirmButtonText: 'OK'
            });
            return false;
        }
        if(error == true){
            return false;
        }
    });

    $(document).on('keyup','.amount_of_payment',function(e){
        e.preventDefault();
        calculateAddedAmount();
    });

    $(document).on('click','.delete_row',function(e){
        e.preventDefault();
        $(this).parent().parent().remove();
        $("#number_of_installment").val($(".amount_of_payment").length);
        calculateAddedAmount();
    });

    function  getDiscountPercentage (total_amount,discount_amount,qty) {
        let totalDiscount = 0;
        if (discount_amount == '' || discount_amount == '%' || discount_amount == '%%' || discount_amount == '%%%'  || discount_amount == '%%%%' ){
            totalDiscount = 0;
        }else{
            let Disc_fields = discount_amount.split('%');
            let discAmount = Disc_fields[0];
            let discP = Disc_fields[1];
            if (discP == "") {
                totalDiscount = (total_amount * (parseFloat($.trim(discAmount)) / 100));
            } else {
                if (!discount_amount) {
                    discAmount = 0;
                }
                totalDiscount = parseFloat(discAmount);
            }
        }
        return totalDiscount*qty;
    }


    function calculate() {
        let price  = Number($("#price").val());
        let shipping_other  = Number($("#shipping_other").val());
        let down_payment  = Number($("#down_payment_cal").val());
        let discount  = $("#discount").val();
        let percentage_of_interest  = $("#percentage_of_interest").val();
        let amount_interest_shipping  = (price - discount) + ((price - discount)/100 * percentage_of_interest) + shipping_other;
        let plan_discount = getDiscountPercentage(price,discount,1);
        $("#total").val((amount_interest_shipping).toFixed(op_precision));
        $("#remaining").val((amount_interest_shipping-down_payment).toFixed(op_precision));
    }

    function calculateAddedAmount() {
        let total_amount = 0;
        $(".amount_of_payment").each(function () {
            let this_value = Number($(this).val());
            total_amount+=this_value;
        });
        $(".total_amount").html(total_amount.toFixed(op_precision));
    }


    $(document).on('change', '#payment_method_id', function (e) {
        e.preventDefault();
        let account_type = $(this).find(":selected").attr('data-type');
        $('#account_type').val(account_type);
        if(account_type == 'Cash' && account_type != undefined){
            $('#show_account_type').html(`
                <div class="form-group mb-2">
                    <label>${note}</label>
                    <input type="text" name="p_note" class="form-control" placeholder="${note}">
                </div>
            `);
        }else if(account_type == 'Bank_Account' && account_type != undefined){
            $('#show_account_type').html(`
                <div class="form-group mb-2">
                    <label>${check_no}</label>
                    <input type="text" name="check_no" class="form-control" placeholder="${check_no}">
                </div>
                <div class="form-group mb-2">
                    <label>${check_issue_date}</label>
                    <input type="text" name="check_issue_date" class="form-control" placeholder="${check_issue_date}">
                </div>
                <div class="form-group mb-2">
                    <label>${check_expiry_date}</label>
                    <input type="text" name="check_expiry_date" class="form-control" placeholder="${check_expiry_date}">
                </div>
            `);
        }else if(account_type == 'Card' && account_type != undefined){
            $('#show_account_type').html(`
                <div class="form-group mb-2">
                    <label>${card_holder_name}</label>
                    <input type="text" name="card_holder_name" class="form-control" placeholder="${card_holder_name}">
                </div>
                <div class="form-group mb-2">
                    <label>${card_holding_number}</label>
                    <input type="text" name="card_holding_number" class="form-control" placeholder="${card_holding_number}">
                </div>
            `);
        }else if(account_type == 'Mobile_Banking' && account_type != undefined){
            $('#show_account_type').html(`
                <div class="form-group mb-2">
                    <label>${mobile_no}</label>
                    <input type="text" name="mobile_no" class="form-control" placeholder="${mobile_no}">
                </div>
                <div class="form-group mb-2">
                    <label>${transaction_no}</label>
                    <input type="text" name="transaction_no" class="form-control" placeholder="${transaction_no}">
                </div>
            `);
        }else if(account_type == 'Paypal' && account_type != undefined){
            $('#show_account_type').html(`
                <div class="form-group mb-2">
                    <label>${paypal_email}</label>
                    <input type="text" name="paypal_email" class="form-control" placeholder="${paypal_email}">
                </div>
            `);
        }else if(account_type == 'Stripe' && account_type != undefined){
            $('#show_account_type').html(`
                <div class="form-group mb-2">
                    <label>${stripe_email}</label>
                    <input type="text" name="stripe_email" class="form-control" placeholder="${stripe_email}">
                </div>
            `);
        }else{
            $('#show_account_type').html('');
        }
    });
});