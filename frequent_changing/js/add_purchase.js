$(function () {
    "use strict";

    toastr.options = {
        positionClass: 'toast-bottom-right'
    };

    let warning = $("#warning").val();
    let name_field_required = $("#name_field_required").val();
    let The_Contact_field_required = $("#The_Contact_field_required").val();
    let The_Phone_field_is_required = $("#The_Phone_field_is_required").val();
    let add_edit_mode = $("#add_mode").val();
    let Payment_Method_Exist = $("#Payment_Method_Exist").val();
    let yes = $("#yes").val();
    let ok = $("#ok").val();
    let cancel = $("#cancel").val();
    let are_you_sure = $("#are_you_sure").val();
    let base_url_ = $("#base_url_").val();
    let csrf_value_= $("#csrf_value_").val();
    let Unit_Price_l= $("#Unit_Price_l").val();
    let total= $("#total").val();
    let Qty_Amount= $("#Qty_Amount").val();
    let supplier_field_required= $("#supplier_field_required").val();
    let date_field_required= $("#date_field_required").val();
    let at_least_item= $("#at_least_item").val();
    let op_precision = $("#op_precision").val();
    let imei_number = $("#imei_number").val();
    let serial_number = $("#serial_number").val();
    let low_qty_set = $("#low_qty_set").val();
    let select = $("#select").val();
    let no_permission_for_this_module = $('#no_permission_for_this_module').val();
    let item_id_container = [];




    $(document).on('click', '#sync_items', function(){
        $.ajax({
            type: "GET",
            url: base_url_+"Ajax/getAllItems",
            success: function (response) {
                if(response.status == 'success'){
                    let html_content = '';
                    let string = '';
                    html_content+=`<option value="">Select</option>`;
                    $.each(response.data, function (ind, val) { 
                        string = ((val.parent_name || '') !== '' ? val.parent_name + ' - ' : '') +
                        (val.name || '') +
                        ((val.brand_name || '') !== '' ? ' - ' + val.brand_name : '') +
                        ' - ' + (val.code || '');
                        html_content+=`<option value='${val.id} | ${string} | ${val.purchase_unit} | ${val.purchase_price} | ${val.conversion_rate} | ${val.type} | ${val.expiry_date_maintain}'>${string}</option>`;
                    });
                    $('#item_id').html(html_content);
                    $(".select2").select2();
                }else{
                    toastr['error']((response.data), 'Error');
                }
            }
        });
    });



    function calculateAll() {
        let subtotal = 0;
        let i = 1;
        $(".rowCount").each(function () {
            let id = $(this).attr("data-counter");
            let unit_price = $("#unit_price_" + id).val();
            let temp = "#sl_" + id;
            $(temp).html(i)
            i++;
            let quantity_amount = $("#quantity_amount_" + id).val();
            if ($.trim(unit_price) == "" || $.isNumeric(unit_price) == false) {
                unit_price = 0;
            }
            if ($.trim(quantity_amount) == "" || $.isNumeric(quantity_amount) == false) {
                quantity_amount = 0;
            }
            let quantity_amount_and_unit_price = parseFloat($.trim(unit_price)) * parseFloat($.trim(
                quantity_amount));
            $("#total_" + id).val(quantity_amount_and_unit_price.toFixed(op_precision));
            subtotal += parseFloat($.trim($("#total_" + id).val()));
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
        $("#grand_total").val(Number(grand_total).toFixed(op_precision));

        let multi_pay_sum = 0;
        $(".multi_pay_row").each(function () {
            let payment_id = $(this).attr('payment_id');
            let multi_pay = $('.multi_payment_'+payment_id).val();
            if(multi_pay == ''){
                multi_pay = 0;
            }
            multi_pay_sum += Number(multi_pay);
        });
        $('#paid').val(multi_pay_sum.toFixed(op_precision));
        let due = parseFloat(grand_total) - parseFloat(multi_pay_sum);
        $("#due").val(due.toFixed(op_precision));
    }

    function IsEmail(email) {
        let regex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
        return regex.test(email);
    }
    $(document).on('change', '#item_id', function(e) {
        let item = $(this).val();
        $('.item_id_err_msg_contnr').hide();
        if(item != ''){
            let error = 0;
            let item_details = $(this).val();
            let item_details_array = item_details.split('|');
            let item_id = item_details_array[0];
            let getType = item_details_array[5];
            let expiry_date_maintain = item_details_array[6];
            let item_name = $(this).find('option:selected').text();
            $("#hidden_input_item_type").val(getType == '0' ? 'Variation_Product' : getType);
            $("#hidden_input_item_id").val(item_id);
            $("#hidden_input_item_name").val(item_name.trim());
            if(getType != 'Medicine_Product'){
                $('#qty_modal').val(1);
            }
            $('#imei').val("");
            $('#serial').val("");
            $('#expiry_date').val("");

            $('#bulk_purchase_item_id').val(item_id);
            $('#bulk_purchase_item_type').val(getType);
            
            if(getType == 'General_Product' || getType == '0' || getType == 'Installment_Product' || (getType == 'Medicine_Product' && expiry_date_maintain == 'No')){
                $('.bulk_imei_serial_upload').hide();

                $("#qty_modal").prop("readonly", false);
                $(".rowCount").each(function() {
                    let id_temp = $(this).attr('data-item-id');
                    if(id_temp == (item_details_array[0])){
                        Swal.fire({
                            title: warning+" !",
                            text: "This Item already exist!",
                            showDenyButton: false,
                            showCancelButton: false,
                            confirmButtonText: `OK`
                        });
                        error =  1;
                    }
                });
            }

            if(getType == 'IMEI_Product' || getType == 'Serial_Product'){
                $('.bulk_imei_serial_upload').show();
                $('.expiry_add_more').html('');
                $('.imeiSerial_add_more').html('');
                $('.imeiSerial_add_more').html(`
                    <button type="button" class="mt-2 bg-blue-btn-p-14 add_imei_serial new-btn h-40">
                        <iconify-icon icon="solar:add-circle-broken" width="18"></iconify-icon>
                    </button>
                `)
                $("#qty_modal").prop("readonly", false);
            }else if(getType == 'Medicine_Product' && expiry_date_maintain == 'Yes'){
                $('.bulk_imei_serial_upload').hide();
                $("#qty_modal").val("");
                $('.imeiSerial_add_more').html('');
                $('.expiry_add_more').html('');
                $('.expiry_add_more').html(`
                    <button type="button" class="bg-blue-btn-p-14 add_new_expiry new-btn h-40">
                    <iconify-icon icon="solar:add-circle-broken" width="18"></iconify-icon>
                    </button>
                `);
                $("#qty_modal").prop("readonly", true);
            }else{
                $('.bulk_imei_serial_upload').hide();
            }

            if(error == 0){
                itemCheckBeforeAppend(getType, item_details_array, item_name.trim());
            }
        }
    });


    $(document).on('click', '.add_imei_serial', function(){
        let quantity_trigger = $('#qty_modal').val();
        $('#qty_modal').val(Number(quantity_trigger)+1);
        let type = $('#hidden_input_item_type').val();
        $(this).parent().parent().find('#imei_append').append(`
            <div class="input-group mt-2">
                <input type="text" name="expiry_imei_serial[]" class="imei_serial_data imei_serial_data_modal unique_match form-control" placeholder="${type == 'IMEI_Product' ? 'Enter IMEI Number' : ''} ${type == 'Serial_Product' ? 'Enter Serial Number' : ''}" unique-imeiserial="" stock-exist-check="" aria-describedby="basic-addon${quantity_trigger}">
                <div class="trash_trigger cursor-pointer input-group-text new-btn-danger h-40" id="basic-addon${quantity_trigger}">
                    <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="18"></iconify-icon>
                </div>
            </div>
        `);
    });


    $(document).on('click', '.add_new_expiry', function(){
        $(this).parent().parent().find('#imei_append').append(`
            <div class="input-group mb-2">
                <input type="text" class="form-control integerchk me-2 expiry_child_qty expiry-first-input" placeholder="Enter Quantity">
                <input type="text" class="form-control expiryProduct customDatepicker expiry-second-input" placeholder="Enter Expiry Date" item-quantity="" aria-describedby="basic-addon">
                <div class="expiry_trash_trigger input-group-text cursor-pointer new-btn-danger h-40" id="basic-addon">
                    <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="18"></iconify-icon>
                </div>
            </div>
        `);
        $('.customDatepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });
    });


    $(document).on('click', '.trash_trigger', function(){
        let quantity_trigger = $('#qty_modal').val();
        if(quantity_trigger == 1){
            Swal.fire({
                title: warning+" !",
                text: `The last item can't be deleted!`,
                showDenyButton: false,
                showCancelButton: false,
                confirmButtonText: `OK`
            });
        }else{
            $(this).parent().remove();
            let result = Number(quantity_trigger);
            $('#qty_modal').val(result - 1);
        }
    });

    $(document).on('click', '.expiry_trash_trigger', function(){
        let expiry_qty = $('#imei_append .input-group').length;
        if(expiry_qty == 1){
            Swal.fire({
                title: warning+" !",
                text: `The last item can't be deleted!`,
                showDenyButton: false,
                showCancelButton: false,
                confirmButtonText: `OK`
            });
        }else{
            $(this).parent().remove();
            expiryQuantitySum();
        }
    });
    
    $(document).on('keyup', '.expiry_child_qty', function(){
        let currentQty = $(this).val();
        $(this).siblings(".customDatepicker").attr('item-quantity', currentQty);
        expiryQuantitySum();
    });
    function expiryQuantitySum(){
        let expiry_each_val_sum = 0;
        let expiry_each_val = 0;
        $(`#imei_append  .expiry_child_qty`).each(function(){
            expiry_each_val = $(this).val();
            if(expiry_each_val == ''){
                expiry_each_val = 0;
            }
            expiry_each_val_sum += Number(expiry_each_val);
        });
        $('#qty_modal').val(Number(expiry_each_val_sum));
    }
    function itemCheckBeforeAppend(getType, item_details_array, item_name){
        let expiry_date_maintain = item_details_array[6];
        $('.item_header').text(item_name);
        $('.modal_item_unit').text(item_details_array[2]);
        $("#unit_price_modal").val(item_details_array[3]);
        $('#hidden_input_expiry_date_maintain').val(expiry_date_maintain);
        if(getType == 'General_Product' || getType == '' || (getType == 'Medicine_Product' && expiry_date_maintain == 'No')){
            $(".imei_p_f").addClass('d-none');
        }else if(getType == 'Medicine_Product' && expiry_date_maintain == 'Yes'){
            $(".imei_p_f").removeClass('d-none');
            $('.imei_serial_label').text(`Expiry Date`);
            $("#imei_append").html("");
            $("#imei_append").append(`
                <div class="input-group mb-2">
                    <input type="text" class="form-control integerchk me-2 expiry_child_qty expiry-first-input" placeholder="Enter Quantity">
                    <input type="text" class="form-control expiryProduct customDatepicker expiry-second-input" placeholder="Enter Expiry Date" item-quantity="" aria-describedby="basic-addon">
                    <div class="expiry_trash_trigger input-group-text cursor-pointer new-btn-danger h-40" id="basic-addon">
                        <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="18"></iconify-icon>
                    </div>
                </div>
            `);
            $('.customDatepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true
            });
        }else if(getType == 'IMEI_Product' || getType == 'Serial_Product'){
            $(".imei_p_f").removeClass('d-none');
            $('.imei_serial_label').text(`${getType == 'IMEI_Product' ? imei_number : serial_number}`);
            $("#imei_append").html("");
            $("#imei_append").append(`
                <div class="input-group mb-2">
                    <input type="text" name="expiry_imei_serial[]" class="imei_serial_data imei_serial_data_modal unique_match form-control" placeholder="${getType == 'IMEI_Product' ? 'Enter IMEI Number' : ''} ${getType == 'Serial_Product' ? 'Enter Serial Number' : ''}" unique-imeiserial="" stock-exist-check="" aria-describedby="basic-addon1">
                    <div class="trash_trigger cursor-pointer input-group-text new-btn-danger h-40" id="basic-addon1">
                        <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="18"></iconify-icon>
                    </div>
                </div>
            `);
        }else if(getType == 'Variation_Product'){
            $(".imei_p_f").addClass('d-none');
        }else if(getType == 'Installment_Product'){
            $(".imei_p_f").addClass('d-none');
        }else if(getType == 0){
            $(".imei_p_f").addClass('d-none');
        }
        $("#cartPreviewModal").modal('show');
    }

    $(document).on('keyup', '#qty_modal', function (e) {
        e.preventDefault();
        let type = $("#hidden_input_item_type").val();
        let qty = $(this).val();
        if(qty == 0){
            qty = 1;
            $(this).val(1);
        }
        if(type == 'IMEI_Product' || type == 'Serial_Product') {
            $("#imei_append").html("");
            for (let i = 0; i < qty; i++) {
                $("#imei_append").append(`
                    <div class="input-group mb-2">
                        <input type="text" name="expiry_imei_serial[]" class="imei_serial_data imei_serial_data_modal unique_match form-control" placeholder="${type == 'IMEI_Product' ? 'Enter IMEI Number' : ''} ${type == 'Serial_Product' ? 'Enter Serial Number' : ''}" unique-imeiserial="" stock-exist-check="" aria-describedby="basic-addon${i}">
                        <div class="trash_trigger input-group-text cursor-pointer new-btn-danger h-40" id="basic-addon${i}">
                            <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="18"></iconify-icon>
                        </div>
                    </div>
                `);
            }
        }
    });

    $(document).on('keyup', '.unique_match', function(){
        let imeiSerial = $.trim($(this).val());
        let himself = $(this);
        let item_id = $('#hidden_input_item_id').val();
        let item_type = $('#hidden_input_item_type').val();
        if(imeiSerial != ''){
            $.ajax({
                url: base_url_+'Sale/checkingExisOrNotIMEISerial',
                method: "POST",
                data: { item_id: item_id, item_type:item_type },
                success: function (response) {
                    if(response.status == 'success' && response.data.allimei){
                        let stockIMEISerial = response.data.allimei.split("||");
                        let matchRow = '';
                        $.each(stockIMEISerial, function (i, v) { 
                            let currentVal = $.trim(v);
                            if(imeiSerial == currentVal){
                                matchRow = 'Exist';
                            }
                        });
                        if(matchRow){
                            $(himself).attr('stock-exist-check', 'Exist');
                            toastr['error']((`${imeiSerial} ${item_type == 'IMEI_Product' ? 'IMEI' : 'Serial '} number already exist in our record!`), '');
                        }else{
                            $(himself).attr('stock-exist-check', 'NotExist');
                        }
                    }else{
                        $(himself).attr('stock-exist-check', 'NotExist');
                    }
                },
            });
        }
        
    });


    $(document).on('keyup', '.checkIMEISerialUnique', function(){
        let item_id = $(this).parent().parent().parent().attr('data-item-id');
        let item_type = $(this).parent().find('small').text();
        let imeiSerial = $.trim($(this).val());
        let himself = $(this);
        if(item_type == 'IMEI'){
            item_type = 'IMEI_Product';
        }else if(item_type == 'Serial'){
            item_type = 'Serial_Product';
        }
        if(imeiSerial != ''){
            $.ajax({
                url: base_url_+'Sale/checkingExisOrNotIMEISerial',
                method: "POST",
                data: { item_id: item_id, item_type:item_type },
                success: function (response) {
                    if(response.status == 'success' && response.data.allimei){
                        let stockIMEISerial = response.data.allimei.split("||");
                        let matchRow = '';
                        $.each(stockIMEISerial, function (i, v) { 
                            let currentVal = $.trim(v);
                            if(imeiSerial == currentVal){
                                matchRow = 'Exist';
                            }
                        });
                        if(matchRow){
                            $(himself).attr('stock-exist-check', 'Exist');
                            toastr['error']((`${imeiSerial} ${item_type == 'IMEI_Product' ? 'IMEI' : 'Serial '} number already exist in our record!`), '');
                        }else{
                            $(himself).attr('stock-exist-check', 'NotExist');
                        }
                    }else{
                        $(himself).attr('stock-exist-check', 'NotExist');
                    }
                },
            });
        }
        
    });




    $(document).on('click', '#addToCart', function(e) {
        e.preventDefault();
        let item_type = $("#hidden_input_item_type").val();
        let expiry_date_maintain = $("#hidden_input_expiry_date_maintain").val();
        let product_id = $("#hidden_input_item_id").val();
        let quantity = Number($("#qty_modal").val());
        let item_name = $("#hidden_input_item_name").val();
        let unique_err = false;
        let error = false;
        if(quantity == 0){
            error = true;
            $('#qty_modal').css("border-color","red");
        }else{
            $('#qty_modal').css("border-color","#d8d6de");
        }
        let item_type_val = "";
        let item_quantity_val = "";
        if (item_type == 'Medicine_Product' && expiry_date_maintain == 'Yes') {
            let imei_serial_data = [];
            let item_arr = [];
            $('.expiryProduct').each(function(i, obj)  {
                let getVal = $(this).val();
                let item_quantity = $(this).attr('item-quantity');
                if (getVal == ''){  
                    $(this).css("border-color","red");
                    error = true;
                }else{
                    $(this).css("border-color","#d8d6de");
                }
                imei_serial_data.push(obj.value);
                item_arr.push(item_quantity);
            });
            item_type_val = imei_serial_data.reverse();
            item_quantity_val = item_arr.reverse();
        }else if(item_type == 'IMEI_Product' || item_type == 'Serial_Product') {
            let itemsArr = new Array();
            let imei_serial_data = [];
            let description_val;
            let uniqueImeiSerial;
            let existCheck = '';
            $('.imei_serial_data').each(function(i, obj){
                // Unique or Not check
                uniqueImeiSerial = $(this).attr('unique-imeiserial');
                if(uniqueImeiSerial == '0'){
                    unique_err = true;
                }
                description_val = $(this).val();
                if(description_val == ''){
                    $(this).css("border-color","red");
                    error = true;
                }else{
                    $(this).css("border-color","#d8d6de");
                    itemsArr.push(description_val);
                }
                // Field blank validation check
                imei_serial_data.push(obj.value);
                // This IMEI or Serial already exist or not check
                let currentVal = $(this).attr('stock-exist-check');
                if(currentVal == 'Exist'){
                    existCheck = 'Exist';
                    Swal.fire({
                        title: warning+" !",
                        text: `${description_val} ${item_type == 'IMEI_Product' ? 'IMEI' : 'Serial '} number already exist in our record!`,
                        showDenyButton: false,
                        showCancelButton: false,
                        confirmButtonText: `OK`
                    });
                }
            });
            item_type_val = imei_serial_data.reverse();
            if(existCheck){
                error = true;
            }
            // Unique IMEI Number or Serial Number Check
            const isUnique = (itemsArr) => 
            itemsArr.length === new Set(itemsArr).size
            if(isUnique(itemsArr) == false){
                error = true;
            }
            if(unique_err == true){
                Swal.fire({
                    title: warning+" !",
                    text: `Duplicate ${item_type == 'IMEI_Product' ? 'IMEI' : 'Serial '} number can't be accepted`,
                    showDenyButton: false,
                    showCancelButton: false,
                    confirmButtonText: `OK`
                });
            }
            if(isUnique(itemsArr) == false){
                Swal.fire({
                    title: warning+" !",
                    text: `Duplicate ${item_type == 'IMEI_Product' ? 'IMEI' : 'Serial '} number can't be accepted`,
                    showDenyButton: false,
                    showCancelButton: false,
                    confirmButtonText: `OK`
                });
            }
        }
        if(error == true || unique_err == true){
            return false;
        }else{
            let unit_price = Number($("#unit_price_modal").val());
            let qty_modal;
            if((item_type == 'Medicine_Product') && expiry_date_maintain == 'Yes'){
                qty_modal = $('#imei_append .expiry_child_qty').length;
            }else{
                qty_modal = Number($("#qty_modal").val());
            }
            appendCart(unit_price, qty_modal, item_type_val, item_type, product_id, item_name, item_quantity_val);
            $("#imei_append").html("");
            $(".expiry_date").val("");
        }
    });

    let rowCounter
    if(add_edit_mode == 'Add'){
        rowCounter = 0;
    }else{
        let eidtRowCount = $('#purchase_cart tbody tr').length
        rowCounter = eidtRowCount;
    }
    function appendCart(unit_price, qty_modal, item_type_val, item_type, product_id, item_name, item_quantity_val="") {
        let item_details = $('#item_id').val();
        let item_details_array = item_details.split('|');
        let type = item_type;
        let qty_modal_count = qty_modal;
        let cart_row = '';
        let d_none = '';
        let p_type = '';
        let p_placeholder = '';
        let custom_date = '';
        let readonly = '';
        let validation_cls = '';
        let checkIMEISerialUnique = '';

        if (type == 'General_Product' || type == 0 || (type == 'Medicine_Product' && item_details_array[6] == 'No')){
            d_none = 'd-none';
        }else if (type == 'Variation_Product'){
            d_none = 'd-none';
        }else if (type == 'Installment_Product'){
            d_none = 'd-none';
        }else if (type == 'Medicine_Product' && item_details_array[6] == 'Yes'){
            p_type = 'Expiry Date:';
            p_placeholder = '';
            custom_date = 'customDatepicker';
            validation_cls = 'countID2';
        }else if(type == 'IMEI_Product'){
            p_type = 'IMEI:';
            p_placeholder = 'Enter IMEI Number';
            readonly = 'readonly';
            validation_cls = 'countID2';
            checkIMEISerialUnique = 'checkIMEISerialUnique';
        }else if(type == 'Serial_Product'){
            p_type = 'Serial:';
            p_placeholder = 'Enter Serial Number';
            readonly = 'readonly';
            validation_cls = 'countID2';
            checkIMEISerialUnique = 'checkIMEISerialUnique';
        }

        if (type == 'General_Product' || type == 'Variation_Product' || type == 0 || type == 'Installment_Product' || (type == 'Medicine_Product' && item_details_array[6] == 'No')) {
            rowCounter++
            cart_row = `<tr class="rowCount" data-counter="${rowCounter}" data-item-id="${product_id}">
                    <td>
                        <div class="d-flex align-items-center">
                            <p id="sl_${rowCounter}">${rowCounter}</p>
                        </div>
                        <input type="hidden" name="item_id[]" value="${item_details_array[0]}"/>
                        <input type="hidden" name="item_type[]" value="${type}"/>
                        <input type="hidden" name="conversion_rate[]" value="${item_details_array[4]}"/>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <span>${item_name}</span>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="d-flex align-items-center">
                                <small class="pe-1">${p_type}</small>
                                <input data-countid="${rowCounter}" type="text" autocomplete="off" id="serial_${rowCounter}" name="expiry_imei_serial[]" onfocus="this.select();" class="form-control ${d_none} ${validation_cls}" value="${item_type_val}" >
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="text" autocomplete="off" data-countid="${rowCounter}" id="quantity_amount_${rowCounter}" name="quantity_amount[]" onfocus="this.select();" class="form-control integerchk1 countID calculate_op qty_count" value="${qty_modal_count}"  placeholder="${Qty_Amount}" aria-describedby="basic-addon2">
                            <span class="input-group-text" id="basic-addon2">${item_details_array[2]}</span>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="d-flex align-items-center">
                                <input type="text" autocomplete="off" data-countid="${rowCounter}" id="unit_price_${rowCounter}" name="unit_price[]" onfocus="this.select();" class="form-control integerchk1 calculate_op countID" placeholder="${Unit_Price_l}" value="${Number(unit_price).toFixed(op_precision)}"/>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="d-flex align-items-center">
                                <input type="text" autocomplete="off" id="total_${rowCounter}" name="total[]" class="form-control" placeholder="${total}" readonly />
                            </div>
                        </div>
                    </td>
                    <td class="text-center">
                        <button type="button" class="new-btn-danger deleter_op h-40" data-suffix="${rowCounter}" data-item_id="${product_id}">
                            <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="18"></iconify-icon>
                        </button>
                    </td>
                </tr>`;
                
            $('.customDatepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true
            });
            $('#purchase_cart tbody').prepend(cart_row);
            item_id_container.push(item_details_array[0]);
            $('#item_id').val('').change();
            calculateAll();
            $("#cartPreviewModal").modal('hide');
        }

        if (type == 'IMEI_Product' || type == 'Serial_Product' || (type == 'Medicine_Product' && item_details_array[6] == 'Yes')){
            for(let k = 0; k < qty_modal_count; k++){
                rowCounter++
                cart_row = `<tr class="rowCount" data-counter="${rowCounter}" data-item-id="${product_id}">
                    <td>
                        <div class="d-flex align-items-center">
                            <p id="sl_${rowCounter}">${rowCounter}</p>
                        </div>
                        <input type="hidden" name="item_id[]" value="${item_details_array[0]}"/>
                        <input type="hidden" name="item_type[]" value="${type}"/>
                        <input type="hidden" name="conversion_rate[]" value="${item_details_array[4]}"/>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <span>${item_details_array[1]}</span>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center form-group">
                            <small class="pe-1">${p_type}</small>
                            <input data-type="${type}" data-countid="${rowCounter}" type="text" autocomplete="off" id="serial_${rowCounter}" name="expiry_imei_serial[]" onfocus="this.select();" class="${checkIMEISerialUnique} form-control ${validation_cls} ${custom_date}" value="${item_type_val[k]}" placeholder="${p_placeholder}">
                        </div>
                        <p class="imei-serial-err imei-serial-err-unique-${rowCounter}"></p>
                    </td>
                    <td>
                        <div class="input-group">
                            <input ${readonly} type="text" autocomplete="off" data-countid="${rowCounter}" id="quantity_amount_${rowCounter}" name="quantity_amount[]" onfocus="this.select();" class="form-control integerchk1 countID calculate_op qty_count"  value="${type == 'Medicine_Product' ? item_quantity_val[k] : '1'}"  placeholder="${Qty_Amount}" aria-describedby="basic-addon2">
                            <span class="input-group-text" id="basic-addon2">${item_details_array[2]}</span>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="d-flex align-items-center form-group">
                                <input type="text" autocomplete="off" data-countid="${rowCounter}" id="unit_price_${rowCounter}" name="unit_price[]" onfocus="this.select();" class="form-control integerchk1 calculate_op countID" placeholder="${Unit_Price_l}" value="${Number(unit_price).toFixed(op_precision)}"/>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="d-flex align-items-center form-group">
                                <input type="text" autocomplete="off" id="total_${rowCounter}" name="total[]" class="form-control" placeholder="${total}" readonly />
                            </div>
                        </div>
                    </td>
                    <td class="text-center">
                        <button type="button" class="new-btn-danger deleter_op h-40" data-suffix="${rowCounter}" data-item_id="${product_id}">
                            <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="18"></iconify-icon>
                        </button>
                    </td>
                </tr>`;
                $('.customDatepicker').datepicker({
                    format: 'yyyy-mm-dd',
                    autoclose: true
                });
                $('#purchase_cart tbody').prepend(cart_row);
                item_id_container.push(item_details_array[0]);
                $('#item_id').val('').change();
                calculateAll();
            }
        }
        setTimeout(function(){
            cartItemCounter();
            $('.customDatepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true
            });
        }, 200);
        $("#cartPreviewModal").modal('hide');
    }

    $(document).on('keyup', '.calculate_op', function() {
        calculateAll();
	});



    function cartItemCounter(){
        let qtySum = 0;
        let countQty;
        $('.qty_count').each(function(){
            countQty = $(this).val();
            qtySum += Number(countQty);
        });
        let numberOfItem = $('#purchase_cart tbody tr').length;
        $('.number_of_item').text(numberOfItem);
        $('.total_quantity_sum').text(qtySum);
    }
    cartItemCounter();

    $(document).on('keyup', '.qty_count', function(){
        cartItemCounter();
    });

    $(document).on('click', '.deleter_op', function() {
        let himself = this;
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
                $(himself).parent().parent().remove();
                calculateAll();
                cartItemCounter();
            }
        });
	});


    // Validate form
    $(document).on('submit', '#purchase_form', function() {
        let supplier_id = $("#supplier_id").val();
        let date = $("#date").val();
        let itemCount = $("#purchase_cart tbody tr").length;
        let error = false;
        let unique_err = false;
        if (supplier_id == "") {
            $("#supplier_id_err_msg").text(supplier_field_required);
            $(".supplier_id_err_msg_contnr").show(200);
            error = true;
        }
        if (date == "") {
            $("#date_err_msg").text(date_field_required);
            $(".date_err_msg_contnr").show(200);
            error = true;
        }
        if (itemCount < 1) {
            $("#item_id_err_msg").text(at_least_item);
            $(".item_id_err_msg_contnr").show(200);
            error = true;
        }
        $(".countID2").each(function () {
            let n = $(this).attr("data-countid");
            let imei_serial = $.trim($("#serial_" + n).val());
            if (imei_serial == '') {
                $("#serial_" + n).css({
                    "border-color": "red"
                });
                error = true;
            }else{
                $("#serial_" + n).css({
                    "border-color": "#d8d6de"
                });
            }
        });
        $(".countID").each(function () {
            let n = $(this).attr("data-countid");
            let quantity_amount = $.trim($("#quantity_amount_" + n).val());
            if (quantity_amount == '' || isNaN(quantity_amount)) {
                $("#quantity_amount_" + n).css({
                    "border-color": "red"
                });
                error = true;
            }else{
                $("#quantity_amount_" + n).css({
                    "border-color": "#d8d6de"
                });
            }
        });
        $(".countID").each(function () {
            let n = $(this).attr("data-countid");
            let unit_price = $.trim($("#unit_price_" + n).val());
            if (unit_price == '' || isNaN(unit_price)) {
                $("#unit_price_" + n).css({
                    "border-color": "red"
                });
                error = true;
            }else{
                $("#unit_price_" + n).css({
                    "border-color": "#d8d6de"
                });
            }
        });
        $(".multi_pay_row").each(function () {
            let payment_id = $(this).attr('payment_id');
            let multi_pay = $.trim($(".multi_payment_" + payment_id).val());
            if (multi_pay == '' || isNaN(multi_pay)) {
                $(".multi_payment_" + payment_id).css({
                    "border-color": "red"
                });
                error = true;
            }
        });
        // Warning: This Condition Can't be deleted
        if (error == true) {
            return false;
        }

        let itemsArr = new Array();
        let existCheck = '';
        $('.checkIMEISerialUnique').each(function(){
            let rowCounter = $(this).attr('data-countid');
            let item_type = $(this).attr('data-type');
            let description_val = $(this).val();
            if(description_val == ''){
                $(this).css("border-color","red");
                error = true;
            }else{
                $(this).css("border-color","#d8d6de");
                itemsArr.push(description_val);
            }
            let currentVal = $(this).attr('stock-exist-check');
            if(currentVal == 'Exist'){
                existCheck = 'Exist';
                $(`.imei-serial-err-unique-${rowCounter}`).text(`The ${item_type == 'IMEI_Product' ? 'IMEI' : 'Serial'} number is already exist in our record`);
                $(this).css("border-color","red");
            }else{
                $(`.imei-serial-err-unique-${rowCounter}`).text('');
            }
        });
        if(existCheck){
            toastr['error']((`Highlighted items already exist`), '');
            error = true;
        }
        // Unique IMEI Number or Serial Number Check
        const isUnique = (itemsArr) => 
        itemsArr.length === new Set(itemsArr).size
        if(isUnique(itemsArr) == false){
            error = true;
        }
        if(unique_err == true){
            toastr['error']((`Duplicate IMEI/Serial number can't be accepted`), '');
            error = true;
        }
        if(isUnique(itemsArr) == false){
            toastr['error']((`Duplicate IMEI/Serial number can't be accepted`), '');
        }
        $('.expiry_child_qty').each(function(){
            let expiry_child_qty = $(this).val();
            if(expiry_child_qty == ''){
                error = true;
            }
        });
        $('.customDatepicker').each(function(){
            let customDatepicker = $(this).val();
            if(customDatepicker == ''){
                error = true;
            }
        });
        if (error == true) {
            return false;
        }
    });

    //Bottom
    $(document).on('hidden.bs.modal', '#supplierModal', function() {
        $(this).find('form').trigger('reset');
    });
    $(document).on('hidden.bs.modal', '#cartPreviewModal', function() {
        $("#menu_note").val('');
    });

    $(document).on('click', '#pull_low_stock_products', function() {
        let supplier_id = $("#supplier_id").val();
        $.ajax({
            url: base_url_+'Purchase/getStockAlertListForPurchase',
            method: "POST",
            data: {
                supplier_id: supplier_id
            },
            success: function (response) {
                if(response != ''){
                    Swal.fire({
                        title: warning + "!",
                        text: low_qty_set,
                        showDenyButton: true,
                        showCancelButton: false,
                        confirmButtonText: yes,
                        denyButtonText: cancel
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            $("#purchase_cart tbody").empty();
                            $("#purchase_cart tbody").append(response)
                            setTimeout(function(){
                                $('.customDatepicker').datepicker({
                                    format: 'yyyy-mm-dd',
                                    autoclose: true
                                });
                            }, 1000);
                            $("#populate_click").val('clicked');
                            calculateAll();
                        }
                    });
                }else{
                    Swal.fire({
                        title: warning + "!",
                        text: 'No Item for this supplier',
                        showDenyButton: false,
                        showCancelButton: false,
                        confirmButtonText: ok,
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            $("#purchase_cart tbody").empty();
                            $("#purchase_cart tbody").append(response)
                            setTimeout(function(){
                                $('.customDatepicker').datepicker({
                                    format: 'yyyy-mm-dd',
                                    autoclose: true
                                });
                            }, 1000);
                            $("#populate_click").val('clicked');
                        }
                    });
                }
                
            }
        });
    });


    $(document).on('keydown', '.integerchk1', function (e) {
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
            (keys >= 96 && keys <= 105)
        );
    });

    $(document).on('keyup', '.integerchk1', function (e) {
        let input = $(this).val();
        let ponto = input.split('.').length;
        let slash = input.split('-').length;
        if (ponto > 2)
            $(this).val(input.substr(0, (input.length) - 1));
        $(this).val(input.replace(/[^0-9]/, ''));
        if (slash > 2)
            $(this).val(input.substr(0, (input.length) - 1));
        if (ponto == 2)
            $(this).val(input.substr(0, (input.indexOf('.') + 4)));
        if (input == '.')
            $(this).val("");
    });


    $(document).on('keydown', '.discount', function (e) {
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


    $(document).on('click', '.add_supplier_by_ajax', function () {
        $.ajax({
            url: base_url_ + "Master/checkAccess",
            method: "GET",
            async: false,
            dataType: 'json',
            data: { controller: "117", function: "add" },
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
                    $("#addSupplierModal").modal('show');
                }
            }
        });
    });


    $(document).on('click', '#addSupplier', function () {
        $.ajax({
            url: base_url_ + "Master/checkAccess",
            method: "GET",
            async: false,
            dataType: 'json',
            data: { controller: "117", function: "add" },
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
                    let name_supplier = $("#name_supplier").val();
                    let contact_person = $("#contact_person").val();
                    let phone = $("#phone").val();
                    let email = $("#email").val();
                    let error = 0;
                    if (name_supplier == '') {
                        error = 1;
                        $('.name_err_msg').text(name_field_required);
                        $('.name_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
                    }
                    if (contact_person == '') {
                        error = 1;
                        $('.contact_person_err_msg').text(The_Contact_field_required);
                        $('.contact_person_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
                    }
                    if (phone == '') {
                        error = 1;
                        $('.phone_err_msg').text(The_Phone_field_is_required);
                        $('.phone_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
                    }
                    if(email != '' && !IsEmail(email)){
                        error = 1;
                        $('.email_err_msg').text("The Email field should be valid!");
                        $('.email_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
                    }
                    if (error == 0) {
                        let name_supplier = $('#name_supplier').val();
                        let contact_person = $('#contact_person').val();
                        let phone = $('#phone').val();
                        let email = $('#email').val();
                        let opening_balance = $('#opening_balance').val();
                        let opening_balance_type = $('#opening_balance_type').val();
                        let supplier_description = $('#supplier_description').val();
                        let supplier_address = $('#supplier_address').val();
                        $.ajax({
                            method: "POST",
                            url: base_url_+'Purchase/addNewSupplierByAjax',
                            data: {
                                name: name_supplier,
                                contact_person: contact_person,
                                phone: phone,
                                email: email,
                                opening_balance: opening_balance,
                                opening_balance_type: opening_balance_type,
                                supplier_description: supplier_description,
                                supplier_address: supplier_address,
                            },
                            success: function (data) {
                                if (data) {
                                    let json = $.parseJSON(data);
                                    let html = '<option>'+select+'</option>';
                                    $.each(json.supplier, function (i, v) {
                                        html += '<option value="' + v.id + '">' + v.name +
                                            '</option>';
                                    });
                                    $("#supplier_id").html(html);
                                    $("#supplier_id").val(json.id).change();
                                    $("#addSupplierModal").modal('hide');
                                }
                                $("#add_supplier_form")[0].reset();
                            }
                        });
                    }
                }
            }
        });
    });


    $(document).on('change', '#payment_method_id', function(){
        let id = $(this).find(":selected").val();
        let name = $(this).find(":selected").text();
        let exist = false;
        if(id != ''){
            $("#payment_received_type tr").each(function () {
                let payment_method = $(this).attr('payment_id');
                if(payment_method == id){
                    exist = true;
                }
            });
            if(exist == true){
                Swal.fire({
                    title: warning+" !",
                    text: Payment_Method_Exist,
                    showDenyButton: false,
                    showCancelButton: false,
                    confirmButtonText: `OK`
                });
            }else{
                $('#payment_received_type').append(`
                    <tr payment_id="${id}" class="multi_pay_row">
                        <td>
                            <div class="input-group ">
                                <span class="input-group-text bg-template-c-white">${name}</span>
                                <input type="hidden" value="${id}" name="payment_id[]">
                                <input type="text" class="integerchk form-control multi_payment_${id} calculate_op" name="payment_value[]">
                                <span class="del_payment del_trigger input-group-text new-btn-danger h-40">
                                    <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="18"></iconify-icon>
                                </span>
                            </div>
                        </td>
                    </tr>
                `);
            }
        }
        
    });

    $(document).on('click', '.show_attachment_trigger', function () {
        $("#show_attachment").modal('show');
    });

    $(document).on('click', '.del_payment', function(){
        let this_c = $(this);
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
                $(this_c).parent().parent().parent().remove();
                calculateAll();
            }
        });
    });

    $(document).on('click', '.noteModalTrigger', function(){
        $('#noteModal').modal('show');
    });
    

    $(document).on('click', '#noteSubmit', function(){
        let note_value = $('#note_modal').val();
        let note_count = note_value.length;
        if(note_count < 300){
            $('#note_hidden').val(note_value);
            $('#noteModal').modal('hide');
        }else{
            $('#note_err_msg').text("Max length should be 300");
            $('.note_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
        }
    });
    

    $(document).on('change','#supplier_id' , function(e){
        let supplier_id = $(this).val();
        $.ajax({
            type: "GET",
            url: base_url_+'Purchase/getSupplierBalance',
            data: {
                supplier_id: supplier_id
            },
            success: function(data) {
                $("#remaining_balance").show();
                $("#remaining_balance").text(`Opening Balance: ${data > 0 ? data : Math. abs(data)} ${ data != 0 ? data > 0 ? '(Credit)' : '(Debit)' : ''}`);
            }
        });
        $('.supplier_id_err_msg_contnr').hide();
    });


    function supplierBalance(){
        let supplier_id = $('#supplier_id').val();
        if(supplier_id != ''){
            $.ajax({
                type: "GET",
                url: base_url_+'Purchase/getSupplierBalance',
                data: {
                    supplier_id: supplier_id
                },
                success: function(data) {
                    $("#remaining_balance").show();
                    $("#remaining_balance").text(`Opening Balance: ${data > 0 ? data : Math. abs(data)} ${ data != 0 ? data > 0 ? '(Credit)' : '(Debit)' : ''}`);
                }
            });
        }
    }
    supplierBalance();



    // Bulk Import 
    $(document).on('click', '.bulk_imei_serial_upload', function(){
        $('#bulkImportModal').modal('show');
    });

    $('#fileUploadForPurchase').on('submit', function (e) {
        e.preventDefault();
        // Check if a file is selected
        let fileInput = $('#file')[0];
        if (fileInput.files.length === 0) {
            $('.import_error_wrap .import_validation_error').html('Please select a file to upload.');
            return;
        }
        let item_id = $('#bulk_purchase_item_id').val();
        let item_type = $('#bulk_purchase_item_type').val();
        let file = fileInput.files[0];
        let allowedExtensions = /(\.xlsx)$/i;
        // Validate file type
        if (!allowedExtensions.exec(file.name)) {
            $('.import_error_wrap .import_validation_error').html('Invalid file type. Please upload an Excel file.');
            return;
        }
        let formData = new FormData();
        formData.append('file', file);
        formData.append('item_id', item_id);
        formData.append('item_type', item_type);
        // AJAX request
        $.ajax({
            url: base_url_+'Purchase/bulkImporForPurchase', // Replace with your PHP file URL
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if(response.status == 'success'){
                    $('#fileUploadForPurchase')[0].reset();
                    toastr['success']('Item Import successfully.', 'Success');
                    $('.bulk_import_at_stock_close').click();
                    setTimeout(function(){
                        imeiSerialAppendToCart(response.data);
                    },200);
                }else if(response.status == 'error'){
                    $('.name_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
                    $('#bulkImportModal .name_err_msg').html(`${response.message}`);
                }
            },
            error: function (xhr, status, error) {
                $('#bulkImportModal .name_err_msg').html(`${response.message}`);
                $('.name_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
            }
        });
    });


    function imeiSerialAppendToCart(append_arr) {
        let item_details = $('#item_id').val();
        let item_details_array = item_details.split('|');
        let product_id = item_details_array[0];
        let unit_price = item_details_array[3];
        let type = item_details_array[5];
        let cart_row = '';
        let p_type = '';
        let p_placeholder = '';
        let custom_date = '';
        let readonly = '';
        let validation_cls = '';
        let checkIMEISerialUnique = '';
        let rowCounter = 0;

        
        if(type == 'IMEI_Product'){
            p_type = 'IMEI:';
            p_placeholder = 'Enter IMEI Number';
            readonly = 'readonly';
            validation_cls = 'countID2';
            checkIMEISerialUnique = 'checkIMEISerialUnique';
        }else if(type == 'Serial_Product'){
            p_type = 'Serial:';
            p_placeholder = 'Enter Serial Number';
            readonly = 'readonly';
            validation_cls = 'countID2';
            checkIMEISerialUnique = 'checkIMEISerialUnique';
        }

        if(append_arr){
            append_arr.forEach(item => {
                rowCounter++;
                cart_row += `<tr class="rowCount" data-counter="${rowCounter}" data-item-id="${product_id}">
                    <td>
                        <div class="d-flex align-items-center">
                            <p id="sl_${rowCounter}">${rowCounter}</p>
                        </div>
                        <input type="hidden" name="item_id[]" value="${item_details_array[0]}"/>
                        <input type="hidden" name="item_type[]" value="${type}"/>
                        <input type="hidden" name="conversion_rate[]" value="${item_details_array[4]}"/>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <span>${item_details_array[1]}</span>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center form-group">
                            <small class="pe-1">${p_type}</small>
                            <input data-type="${type}" data-countid="${rowCounter}" type="text" autocomplete="off" id="serial_${rowCounter}" name="expiry_imei_serial[]" onfocus="this.select();" class="${checkIMEISerialUnique} form-control ${validation_cls} ${custom_date}" value="${item}" placeholder="${p_placeholder}">
                        </div>
                        <p class="imei-serial-err imei-serial-err-unique-${rowCounter}"></p>
                    </td>
                    <td>
                        <div class="input-group">
                            <input ${readonly} type="text" autocomplete="off" data-countid="${rowCounter}" id="quantity_amount_${rowCounter}" name="quantity_amount[]" onfocus="this.select();" class="form-control integerchk1 countID calculate_op qty_count"  value="${type == 'Medicine_Product' ? item_quantity_val[k] : '1'}"  placeholder="${Qty_Amount}" aria-describedby="basic-addon2">
                            <span class="input-group-text" id="basic-addon2">${item_details_array[2]}</span>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="d-flex align-items-center form-group">
                                <input type="text" autocomplete="off" data-countid="${rowCounter}" id="unit_price_${rowCounter}" name="unit_price[]" onfocus="this.select();" class="form-control integerchk1 calculate_op countID" placeholder="${Unit_Price_l}" value="${Number(unit_price).toFixed(op_precision)}"/>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="d-flex align-items-center form-group">
                                <input type="text" autocomplete="off" id="total_${rowCounter}" name="total[]" class="form-control" placeholder="${total}" readonly />
                            </div>
                        </div>
                    </td>
                    <td class="text-center">
                        <button type="button" class="new-btn-danger deleter_op h-40" data-suffix="${rowCounter}" data-item_id="${product_id}">
                            <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="18"></iconify-icon>
                        </button>
                    </td>
                </tr>`;
            
            });
                    
            $('#purchase_cart tbody').prepend(cart_row);
            $('#item_id').val('').change();
            calculateAll();
            setTimeout(function(){
                cartItemCounter();
            }, 200);
            $("#cartPreviewModal").modal('hide');
            $("#bulkImportModal").modal('hide'); 
        }
    }


});