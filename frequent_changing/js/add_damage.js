$(function () {
    "use strict";

    toastr.options = {
        positionClass: 'toast-bottom-right'
    };

    let add_edit_mode = $("#add_mode").val();
    let warning = $("#warning").val();
    let yes = $("#yes").val();
    let cancel = $("#cancel").val();
    let total= $("#total").val();
    let are_you_sure = $("#are_you_sure").val();
    let base_url_ = $("#base_url_").val();
    let Loss_Amt = $("#Loss_Amt").val();
    let responsible_person_field_required = $("#responsible_person_field_required").val();
    let date_field_required = $("#date_field_required").val();
    let at_least_item = $("#at_least_item").val();
    let item_id_container = [];
    let op_precision = $("#op_precision").val();
    let Qty_Amount= $("#Qty_Amount").val();
    let imei = $("#imei").val();
    let serial = $("#serial").val();


    function calculateAll(){
        let total_loss = 0;
        let i = 1;
        $(".rowCount").each(function () {
            let rowCount = $(this).attr("row-counter");
            let damage_quantity = $("#damage_quantity_"+rowCount).val();
            let temp = "#sl_"+rowCount;
            $(temp).html(i);
            i++;
            if (typeof(damage_quantity) !== "undefined" && damage_quantity !== null) {
                let last_purchase_price = $("#loss_amount_"+rowCount).val();
                if($.trim(damage_quantity) == "" || $.isNumeric(damage_quantity) == false){
                    damage_quantity=0;
                }
                if($.trim(last_purchase_price) == "" || $.isNumeric(last_purchase_price) == false){
                    last_purchase_price=0;
                }
                let loss_amount = parseFloat($.trim(damage_quantity)) * parseFloat($.trim(last_purchase_price));
                $("#total_"+rowCount).val((parseFloat(damage_quantity) * parseFloat(last_purchase_price)).toFixed(op_precision));
                total_loss += parseFloat(loss_amount);
            }
        });
        $("#total_loss").val(total_loss.toFixed(op_precision)); 
    }
    calculateAll();

    

    $(document).on('change', '#item_id', function(e) {
        let item = $(this).val();
        $(".modal_qty_err_msg_contnr").hide();
        if(item != ''){
            let error = 0;
            let item_details = $(this).val();
            let item_details_array = item_details.split('|');
            let item_id = item_details_array[0];
            let getType = item_details_array[4];
            
            let item_name = $(this).find('option:selected').text();
            $("#hidden_input_item_type").val(getType == '0' ? 'Variation_Product' : getType);
            $("#hidden_input_item_id").val(item_id);
            $("#hidden_input_item_name").val(item_name.trim());
            $("#last_three_purchase_avg").val(item_details_array[3]);
            if(getType != 'Medicine_Product'){
                $('#qty_modal').val(1);
            }
            $('#imei').val("");
            $('#serial').val("");
            $('#expiry_date').val("");
            
            if(getType == 'General_Product' || getType == '0' || getType == 'Installment_Product' || (getType == 'Medicine_Product' && item_details_array[5] == 'No')){
                $("#qty_modal").prop("readonly", false);
                $(".rowCount").each(function() {
                    let id_temp = $(this).attr('data-item-id');
                    if(id_temp == (item_details_array[0])){
                        Swal.fire({
                            title: "Alert !",
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
                $('.expiry_add_more').html('');
                $('.imeiSerial_add_more').html('');
                $('.imeiSerial_add_more').html(`
                    <button type="button" class="mt-2 new-btn h-40 bg-blue-btn-p-14 add_imei_serial">
                        <iconify-icon icon="solar:add-circle-broken" width="18"></iconify-icon>
                    </button>
                `)
                $("#qty_modal").prop("readonly", false);

            }else if(getType == 'Medicine_Product' && item_details_array[5] == 'Yes'){
                $("#qty_modal").val("");
                $('.imeiSerial_add_more').html('');
                $('.expiry_add_more').html('');
                $('.expiry_add_more').html(`
                    <button type="button" class="mt-2 new-btn h-40 bg-blue-btn-p-14 add_new_expiry">
                        <iconify-icon icon="solar:add-circle-broken" width="18"></iconify-icon>
                    </button>
                `);
                $("#qty_modal").prop("readonly", true);
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
                <input type="text" name="expiry_imei_serial[]" class="imei_serial_data imei_serial_data_modal unique_match form-control expiryDateExistCheck" placeholder="${type == 'IMEI_Product' ? 'Enter IMEI Number' : ''} ${type == 'Serial_Product' ? 'Enter Serial Number' : ''}" unique-imeiserial="" aria-describedby="basic-addon${quantity_trigger}">
                <div class="new-btn-danger h-40 trash_trigger input-group-text" id="basic-addon${quantity_trigger}">
                    <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="18"></iconify-icon>
                </div>
            </div>
        `);
    });


    $(document).on('click', '.add_new_expiry', function(){
        let item_id = $('#hidden_input_item_id').val();
        let item_type = $('#hidden_input_item_type').val();
        let expiryDates = '';
        $.ajax({
            url: base_url_ + "Sale/getExpiryByOutlet",
            method: "POST",
            async: false,
            dataType: 'json',
            data: { item_id: item_id },
            success: function (response) {
                expiryDates = `<option value="">Select Expiry</option>`;
                $.each(response.data, function (i, v) { 
                    if(v.stock_quantity != 0){
                        expiryDates += `<option data-stock-qty="${v.stock_quantity}" value="${$.trim(v.expiry_imei_serial)}">${$.trim(v.expiry_imei_serial)}</option>`;
                    }
                });
            }
        });

        $(this).parent().parent().find('#imei_append').append(`
            <div class="input-group mb-2">
                <select class="select2 form-control expiryProduct">
                ${expiryDates}
                </select>
                <input type="text" class="form-control integerchk ms-2 expiry_child_qty expiry-first-input" placeholder="Enter Quantity">
                <div class="new-btn-danger h-40 expiry_trash_trigger input-group-text" id="basic-addon">
                    <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="18"></iconify-icon>
                </div>
            </div>
        `);
        $('.select2').select2();
        $('.customDatepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });
    });


    $(document).on('click', '.trash_trigger', function(){
        let quantity_trigger = $('#qty_modal').val();
        if(quantity_trigger == 1){
            Swal.fire({
                title: "Alert !",
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
                title: "Alert !",
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


    $(document).on('keyup', '.expiry_child_qty', function(){
        let himself = $(this);
        let currentVal = $(this).parent().find('.expiryProduct').val();
        if(currentVal){
            let currentQty = $(this).val();
            let stockQty = $(this).parent().find('.expiryProduct option:selected').attr('data-stock-qty');
            if(Number(currentQty) > Number(stockQty)){
                Swal.fire({
                    title: warning + "!",
                    text: `Maximum ${stockQty} can be return!`,
                    showDenyButton: true,
                    showCancelButton: false,
                    confirmButtonText: 'OK',
                    denyButtonText: cancel
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        himself.val(stockQty);
                        expiryQuantitySum()
                    } else{
                        himself.val(0)
                        expiryQuantitySum()
                    }
                });
            }
        }else{
            
            Swal.fire({
                title: warning + "!",
                text: `Select Expiry First!`,
                showCancelButton: false,
                confirmButtonText: 'OK',
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    himself.val(Number(0))
                    expiryQuantitySum()
                }
            });
        }
    });
    function itemCheckBeforeAppend(getType, item_details_array, item_name){
        $('.item_header').text(item_name);
        $('.modal_item_unit').text(item_details_array[2]);
        $("#unit_price_modal").val(item_details_array[3]);
        $("#hidden_input_expiry_date_maintain").val(item_details_array[5]);
        if(getType == 'General_Product' || getType == '' || (getType == 'Medicine_Product' && item_details_array[5] == 'No')){
            $(".imei_p_f").addClass('d-none');
        }else if(getType == 'Medicine_Product' && item_details_array[5] == 'Yes'){
            let item_id = $('#hidden_input_item_id').val();
            let item_type = $('#hidden_input_item_type').val();
            let expiryDates = '';
            $.ajax({
                url: base_url_ + "Sale/getExpiryByOutlet",
                method: "POST",
                async: false,
                dataType: 'json',
                data: { item_id: item_id },
                success: function (response) {
                    expiryDates = `<option value="">Select Expiry</option>`;
                    $.each(response.data, function (i, v) { 
                        if(v.stock_quantity != 0){
                            expiryDates += `<option data-stock-qty="${v.stock_quantity}" value="${$.trim(v.expiry_imei_serial)}">${$.trim(v.expiry_imei_serial)}</option>`;
                        }
                    });
                }
            });

            $(".imei_p_f").removeClass('d-none');
            $('.imei_serial_label').text(`Expiry Date`);
            $("#imei_append").html("");
            $("#imei_append").append(`
                <div class="input-group mb-2">
                    <select class="select2 form-control expiryProduct">
                    ${expiryDates}
                    </select>
                    <input type="text" class="form-control integerchk ms-2 expiry_child_qty expiry-first-input" placeholder="Enter Quantity">
                    <div class="new-btn-danger h-40 expiry_trash_trigger input-group-text" id="basic-addon">
                        <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="18"></iconify-icon>
                    </div>
                </div>
            `);
            $('.select2').select2();
            $('.customDatepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true
            });
        }else if(getType == 'IMEI_Product' || getType == 'Serial_Product'){
            $(".imei_p_f").removeClass('d-none');
            $('.imei_serial_label').text(`${getType == 'IMEI_Product' ? imei : serial}`);
            $("#imei_append").html("");
            $("#imei_append").append(`
                <div class="input-group mb-2">
                    <input type="text" name="expiry_imei_serial[]" class="imei_serial_data imei_serial_data_modal unique_match form-control" placeholder="${getType == 'IMEI_Product' ? 'Enter IMEI Number' : ''} ${getType == 'Serial_Product' ? 'Enter Serial Number' : ''}" unique-imeiserial="" aria-describedby="basic-addon1">
                    <div class="new-btn-danger h-40 trash_trigger input-group-text" id="basic-addon1">
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
                        <input type="text" name="expiry_imei_serial[]" class="imei_serial_data imei_serial_data_modal unique_match form-control" placeholder="${type == 'IMEI_Product' ? 'Enter IMEI Number' : ''} ${type == 'Serial_Product' ? 'Enter Serial Number' : ''}" unique-imeiserial="" aria-describedby="basic-addon${i}">
                        <div class="new-btn-danger h-40 trash_trigger input-group-text" id="basic-addon${i}">
                            <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="18"></iconify-icon>
                        </div>
                    </div>
                `);
            }
        }
    });
    

    function checkDistinct(array) { 
        const checkSet = new Set(array); 
        return checkSet.size === array.length;   
    } 

    $(document).on('change', '.expiryProduct', function(){
        let himself = $(this);
        let thisVal = $(this).val();
        let cVal = '';
        let expiryArr = [];
        $('.expiryProduct').each(function(){
            cVal = $(this).val();
            expiryArr.push(cVal);
        });
        let unique = checkDistinct(expiryArr);
        if(!unique){
            $(this).attr('data-exist-check', 'Exist');
        }else{
            $(this).attr('data-exist-check', 'NotExist');
        }

        let cartExpiry = '';
        $('.expiryDateExistCheck').each(function(){
            cartExpiry = $(this).val();
            if(cartExpiry == thisVal){
                Swal.fire({
                    title: "Alert !",
                    text: `This ${thisVal} already in cart, Please update Quantity`,
                    showDenyButton: false,
                    showCancelButton: false,
                    confirmButtonText: `OK`
                });
                himself.attr('data-cart-exist-check', 'CExist');
            }else{
                himself.attr('data-exist-check', 'CNotExist');
            }
        });
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
                        }else{
                            $(himself).attr('stock-exist-check', 'NotExist');
                            toastr['error']((`${imeiSerial} ${item_type == 'IMEI_Product' ? 'IMEI' : 'Serial '} number not exist in our record!`), '');

                        }
                    }else{
                        $(himself).attr('stock-exist-check', 'NotExist');
                        toastr['error']((`${imeiSerial} ${item_type == 'IMEI_Product' ? 'IMEI' : 'Serial '} number not exist in our record!`), '');
                    }
                },
            });
        }
        
    });

    $(document).on('click', '#addToCart', function(e) {
        e.preventDefault();
        let item_type = $("#hidden_input_item_type").val();
        let product_id = $("#hidden_input_item_id").val();
        let quantity = Number($("#qty_modal").val());
        let item_name = $("#hidden_input_item_name").val();
        let last_three_purchase_avg = $("#last_three_purchase_avg").val();
        let expiry_date_maintain = $("#hidden_input_expiry_date_maintain").val();
        let unique_err = false;
        let error = false;


        $.ajax({
            type: "GET",
            url: base_url_+'Transfer/stockCheck/'+product_id,
            async: false,
            success: function (response) {
                let data = JSON.parse(response);
                if(quantity != ''){
                    if(Number(data) < Number(quantity)){
                        error = true;
                        $("#modal_qty_err_msg").text('Quantity should be less then stock');
                        $(".modal_qty_err_msg_contnr").show();
                    }else{
                        $(".modal_qty_err_msg_contnr").hide();
                    }
                } 
            }
        });

        if(quantity == 0){
            error = true;
            $('#qty_modal').css("border-color","red");
        }else{
            $('#qty_modal').css("border-color","#d8d6de");
        }
        let  item_type_val = "";
        let item_quantity_val = "";
        if (item_type == 'Medicine_Product' && expiry_date_maintain == 'Yes') {
            let imei_serial_data = [];
            let item_arr = [];
            let existMatch = '';
            let existCheck = '';
            let cExistMatch = '';
            let cExitData = '';
            $('.expiryProduct').each(function(i, obj)  {
                let getVal = $(this).val();
                existCheck = $(this).attr('data-exist-check');
                if(existCheck == 'Exist'){
                    existMatch = 'Match';
                    error = true;
                }
                if (getVal == ''){  
                    $(this).css("border-color","red");
                    error = true;
                }else{
                    $(this).css("border-color","#d8d6de");
                }
                imei_serial_data.push(obj.value);
                let cartExist = $(this).attr('data-cart-exist-check')
                if(cartExist == 'CExist'){
                    cExistMatch = 'CMatch';
                    cExitData = getVal;
                    error = true;
                }
            });

            if(existMatch == 'Match'){
                Swal.fire({
                    title: "Alert !",
                    text: `Expiry Date Confilicted, Please update quantity`,
                    showDenyButton: false,
                    showCancelButton: false,
                    confirmButtonText: `OK`
                });
            }
            if(cExistMatch == 'CMatch'){
                Swal.fire({
                    title: "Alert !",
                    text: `${cExitData} already in cart, please update quantity`,
                    showDenyButton: false,
                    showCancelButton: false,
                    confirmButtonText: `OK`
                });
            }

            $('.expiry_child_qty').each(function(i, obj)  {
                let getVal = $(this).val();
                if (getVal == ''){  
                    $(this).css("border-color","red");
                    error = true;
                }else{
                    $(this).css("border-color","#d8d6de");
                }
                item_arr.push(getVal);
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
                if(currentVal == 'NotExist'){
                    existCheck = 'NotExist';
                    Swal.fire({
                        title: "Alert !",
                        text: `${description_val} ${item_type == 'IMEI_Product' ? 'IMEI' : 'Serial '} number not found in our record!`,
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
                    title: "Alert !",
                    text: `Duplicate ${item_type == 'IMEI_Product' ? 'IMEI' : 'Serial '} number can't be accepted`,
                    showDenyButton: false,
                    showCancelButton: false,
                    confirmButtonText: `OK`
                });
            }
            if(isUnique(itemsArr) == false){
                Swal.fire({
                    title: "Alert !",
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
            let qty_modal;
            if((item_type == 'Medicine_Product') && expiry_date_maintain == 'Yes'){
                qty_modal = $('#imei_append .expiry_child_qty').length;
            }else{
                qty_modal = Number($("#qty_modal").val());
            }
            appendCart(qty_modal, item_type, product_id, item_name,  item_type_val, item_quantity_val,  last_three_purchase_avg);
            $("#imei_append").html("");
            $(".expiry_date").val("");
        }
        
    });

    let rowCounter
    if(add_edit_mode == 'Add'){
        rowCounter = 0;
    }else{
        let eidtRowCount = $('#damage_cart tbody tr').length
        rowCounter = eidtRowCount;
    }
    function appendCart(qty_modal, item_type, product_id, item_name,  item_type_val="", item_quantity_val="", last_three_purchase_avg="") {
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
        let expiryDateExistCheck = '';
        let readonly_expiry = '';


        if (type == 'General_Product' || type == 0 || (type == 'Medicine_Product' && item_details_array[5] == 'No')){
            d_none = 'd-none';
        }else if (type == 'Variation_Product'){
            d_none = 'd-none';
        }else if (type == 'Installment_Product'){
            d_none = 'd-none';
        }else if (type == 'Medicine_Product' && item_details_array[5] == 'Yes'){
            p_type = 'Expiry Date:';
            p_placeholder = '';
            custom_date = 'customDatepicker';
            validation_cls = 'countID2';
            expiryDateExistCheck = 'expiryDateExistCheck';
            readonly_expiry = 'readonly';
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

        if (type == 'General_Product' || type == 'Variation_Product' || type == 0 || type == 'Installment_Product' || (type == 'Medicine_Product' && item_details_array[5] == 'No')) {
            rowCounter++
            cart_row = `<tr class="rowCount" row-counter="${rowCounter}" data-item-id="${product_id}">
                    <td>
                        <div class="d-flex align-items-center">
                            <p id="sl_${rowCounter}">${rowCounter}</p>
                        </div>
                        <input type="hidden" id="item_id_${rowCounter}" name="item_id[]" value="${item_details_array[0]}"/>
                        <input type="hidden" name="item_type[]" value="${type}"/>
                        <input type="hidden" name="conversion_rate[]" value="${item_details_array[4]}"/>
                        <input type="hidden" id="last_purchase_price_${rowCounter}" name="last_purchase_price[]" value="${last_three_purchase_avg}"/>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <span>${item_name}</span>
                        </div>
                    </td>
                    <td>
                        <div class="input-group d-flex align-items-center">
                            <small class="pe-1">${p_type}</small>
                            <input data-countid="${rowCounter}" type="text" autocomplete="off" id="serial_${rowCounter}" name="expiry_imei_serial[]" onfocus="this.select();" class="form-control ${d_none} ${custom_date} ${validation_cls}" value="${ item_type_val}" >
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="text" autocomplete="off" data-countid="${rowCounter}" id="damage_quantity_${rowCounter}" name="damage_quantity[]" onfocus="this.select();" class="form-control integerchk1 countID calculate_op qty_count" value="${qty_modal_count}"  placeholder="${Qty_Amount}" aria-describedby="basic-addon2">
                            <span class="input-group-text" id="basic-addon2">${item_details_array[2]}</span>
                        </div>
                    </td>
                    <td>
                        <div class="input-group d-flex align-items-center">
                            <input type="text" autocomplete="off" data-countid="${rowCounter}" id="loss_amount_${rowCounter}" name="loss_amount[]" onfocus="this.select();" class="form-control integerchk1 calculate_op countID3" placeholder="${Loss_Amt}" value=""/>
                        </div>
                    </td>
                    <td>
                        <div class="input-group d-flex align-items-center">
                            <input type="text" autocomplete="off" id="total_${rowCounter}" name="total_amount[]" class="form-control" placeholder="${total}" readonly />
                        </div>
                    </td>
                    <td class="text-center">
                        <button type="button" class="new-btn-danger h-40 deleter_op" data-suffix="${rowCounter}" data-item_id="${product_id}">
                            <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="18"></iconify-icon>
                        </button>
                    </td>
                </tr>`;
                
            console.log(cart_row);
            $('#damage_cart tbody').prepend(cart_row);
            $('.customDatepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true
            });
            item_id_container.push(item_details_array[0]);
            $('#item_id').val('').change();
            calculateAll();
            $("#cartPreviewModal").modal('hide');
        }

        if (type == 'IMEI_Product' || type == 'Serial_Product' || (type == 'Medicine_Product' && item_details_array[5] == 'Yes')){
            for(let k = 0; k < qty_modal_count; k++){
                rowCounter++
                cart_row = `<tr class="rowCount" row-counter="${rowCounter}" data-item-id="${product_id}">
                    <td>
                        <div class="d-flex align-items-center">
                            <p id="sl_${rowCounter}">${rowCounter}</p>
                        </div>
                        <input type="hidden" name="item_id[]" id="item_id_${rowCounter}" value="${item_details_array[0]}"/>
                        <input type="hidden" name="item_type[]" value="${type}"/>
                        <input type="hidden" name="conversion_rate[]" value="${item_details_array[4]}"/>
                        <input type="hidden" id="last_purchase_price_${rowCounter}" name="last_purchase_price[]" value="${last_three_purchase_avg}"/>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <span>${item_details_array[1]}</span>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center form-group">
                            <small class="pe-1">${p_type}</small>
                            <input ${readonly_expiry} item-type="${type}" data-countid="${rowCounter}" type="text" autocomplete="off" id="serial_${rowCounter}" name="expiry_imei_serial[]" onfocus="this.select();" class="${checkIMEISerialUnique} form-control ${validation_cls} ${expiryDateExistCheck}" value="${ item_type_val[k]}" placeholder="${p_placeholder}">
                        </div>
                        <p class="imei-serial-err imei-serial-err-unique-${rowCounter}"></p>
                    </td>
                    <td>
                        <div class="input-group">
                            <input ${readonly} type="text" autocomplete="off" data-countid="${rowCounter}" id="damage_quantity_${rowCounter}" name="damage_quantity[]" onfocus="this.select();" class="form-control integerchk1 countID calculate_op qty_count"  value="${type == 'Medicine_Product' ? item_quantity_val[k] : '1'}"  placeholder="${Qty_Amount}" aria-describedby="basic-addon2">
                            <span class="input-group-text" id="basic-addon2">${item_details_array[2]}</span>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center form-group">
                            <input type="text" autocomplete="off" data-countid="${rowCounter}" id="loss_amount_${rowCounter}" name="loss_amount[]" onfocus="this.select();" class="form-control integerchk1 calculate_op countID3" placeholder="${Loss_Amt}" value=""/>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center form-group">
                            <input type="text" autocomplete="off" id="total_${rowCounter}" name="total_amount[]" class="form-control" placeholder="${total}" readonly />
                        </div>
                    </td>
                    <td class="text-center">
                        <a class="new-btn-danger h-40 deleter_op" data-suffix="${rowCounter}" data-item_id="${product_id}">
                        <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="18"></iconify-icon>
                        </a>
                    </td>
                </tr>`;
                $('#damage_cart tbody').prepend(cart_row);
                item_id_container.push(item_details_array[0]);
                $('#item_id').val('').change();
                calculateAll();
            }
        }
        setTimeout(function(){
            cartItemCounter();
        }, 200);
        $("#cartPreviewModal").modal('hide');
    }

    $(document).on('keyup', '.calculate_op', function() {
        calculateAll();
	});



    $(document).on('keyup', '.qty_count', function(){
        cartItemCounter();
        let himself = $(this);
        let currentVal = $(this).val();
        let current = $(this).attr('data-countid');
        let item_id = $('#item_id_'+current).val();
        let singleExpiryDate = $('#serial_'+current).val();
        calculateAll();
        $.ajax({
            type: "POST",
            url: base_url_+"Sale/singleExpiryDateStockCheck",
            async: false,
            data: {
                expiry_imei_serial: singleExpiryDate,
                item_id: item_id,
            },
            success: function (response) {
                if(response.status == 'success'){
                    if(Number(currentVal) > Number(response.data.stock_quantity)){
                        Swal.fire({
                            title: warning + '!',
                            text: `Maximum ${response.data.stock_quantity} can be return!`,
                            showDenyButton: true,
                            showCancelButton: false,
                            confirmButtonText: 'OK',
                            denyButtonText: cancel
                        }).then((result) => {
                            /* Read more about isConfirmed, isDenied below */
                            if (result.isConfirmed) {
                                himself.val(response.data.stock_quantity);
                                calculateAll();
                            }else{
                                himself.val(0);
                                calculateAll();
                            }
                        });
                    }
                }
            }
        });
    });


    function cartItemCounter(){
        let qtySum = 0;
        let countQty;
        $('.qty_count').each(function(){
            countQty = $(this).val();
            qtySum += Number(countQty);
        });
        let numberOfItem = $('#damage_cart tbody tr').length;
        $('.number_of_item').text(numberOfItem);
        $('.total_quantity_sum').text(qtySum);
    }
    cartItemCounter();

    

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
                            if(imeiSerial === currentVal){
                                matchRow = 'Exist';
                            }
                        });
                        if(matchRow){
                            $(himself).attr('stock-exist-check', 'Exist');
                        }else{
                            $(himself).attr('stock-exist-check', 'NotExist');
                            toastr['error']((`${imeiSerial} ${item_type == 'IMEI_Product' ? 'IMEI' : 'Serial '} number not found in our record!`), '');
                        }
                    }else{
                        $(himself).attr('stock-exist-check', 'NotExist');
                        toastr['error']((`${imeiSerial} ${item_type == 'IMEI_Product' ? 'IMEI' : 'Serial '} number not found in our record!`), '');
                    }
                },
            });
        }
    });


    $(document).on('keyup', '#qty_modal', function (e) {
        e.preventDefault();
        let qty = $(this).val();
        let item_id = $('#hidden_input_item_id').val();
        if(qty == 0){
            qty = 1;
            $(this).val(1);
        }
        $.ajax({
            type: "GET",
            url: base_url_+'Transfer/stockCheck/'+item_id,
            success: function (response) {
                let data = JSON.parse(response);
                if(qty != ''){
                    if(Number(data) < Number(qty)){
                        $("#modal_qty_err_msg").text('Quantity should be less then stock');
                        $(".modal_qty_err_msg_contnr").show();
                    }else{
                        $(".modal_qty_err_msg_contnr").hide();
                    }
                } 
            }
        });
    });

    // Validate form
    $(document).on('submit', '#damage_form', function() {
        let date = $("#damage_date").val();
        let employee_id = $("#employee_id").val();
        let itemCount = $("#damage_cart tbody tr").length;
        let error = false;
        let unique_err =  false;
        
      
        if (date == "") {
            $("#date_err_msg").text(date_field_required);
            $(".date_err_msg_contnr").show(200);
            error = true;
        }
        if(employee_id==""){ 
            $("#employee_id_err_msg").text(responsible_person_field_required);
            $(".employee_id_err_msg_contnr").show(200);
            error = true;
        } 
        if (itemCount < 1) {
            $("#item_id_err_msg").text(at_least_item);
            $(".item_id_err_msg_contnr").show(200);
            error = true;
        }


        setTimeout(function(){
            $(".employee_id_err_msg_contnr").hide(200);
            $(".item_id_err_msg_contnr").hide(200);
        }, 3000);

        if(error == true){
            return false;
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
            let quantity_amount = $.trim($("#damage_quantity_" + n).val());
            if (quantity_amount == '' || isNaN(quantity_amount)) {
                $("#damage_quantity_" + n).css({
                    "border-color": "red"
                });
                error = true;
            }else{
                $("#damage_quantity_" + n).css({
                    "border-color": "#d8d6de"
                });
            }
        });

        $(".countID3").each(function () {
            let n = $(this).attr("data-countid");
            let unit_price = $.trim($("#loss_amount_" + n).val());
            if (unit_price == '' || isNaN(unit_price)) {
                $("#loss_amount_" + n).css({
                    "border-color": "red"
                });
                error = true;
            }else{
                $("#loss_amount_" + n).css({
                    "border-color": "#d8d6de"
                });
            }
        });


        let itemsArr = new Array();
        let existCheck = '';
        $('.checkIMEISerialUnique').each(function(){
            let rowCounter = $(this).attr('data-countid');
            let item_type = $(this).attr('item-type');
            let description_val = $(this).val();
            if(description_val == ''){
                $(this).css("border-color","red");
                error = true;
            }else{
                $(this).css("border-color","#d8d6de");
                itemsArr.push(description_val);
            }
            let currentVal = $(this).attr('stock-exist-check');
            if(currentVal == 'NotExist'){
                existCheck = 'NotExist';
                $(this).css("border-color","red");
                $(`.imei-serial-err-unique-${rowCounter}`).text(`The ${item_type == 'IMEI_Product' ? 'IMEI' : 'Serial'} number is not exist in our record`);
                $(this).css("border-color","red");
            }else{
                $(`.imei-serial-err-unique-${rowCounter}`).text('');
            }
        });
        if(existCheck){
            toastr['error']((`Highlighted items not exist`), '');
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

});