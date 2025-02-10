$(function () {
    "use strict";

    toastr.options = {
        positionClass: 'toast-bottom-right'
    };

    let warning = $("#warning").val();
    let yes = $("#yes").val();
    let cancel = $("#cancel").val();
    let are_you_sure = $("#are_you_sure").val();
    let base_url_ = $("#base_url_").val();
    let date_required= $("#date_required").val();
    let supplier_id_required= $("#supplier_id_required").val();
    let account_field_required= $("#account_field_required").val();
    let status_filed_is_rquired = $("#status_filed_is_rquired").val();
    let Return_Note = $("#Return_Note").val();
    let op_precision = $("#op_precision").val();
    let quantity_ln = $("#quantity_ln").val();
    let unit_price_ln = $("#unit_price_ln").val();
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
    let add_edit_mode = $("#add_edit_mode").val();
    let imei = $("#imei_number").val();
    let serial = $("#serial_number").val();

    $(document).on('change', '#item_id', function(e) {
        let item = $(this).val();
        $('.modal_qty_err_msg_contnr').hide();
        if(item != ''){
            let error = 0;
            let item_details = $(this).val();
            let item_details_array = item_details.split('|');
            let item_id = item_details_array[0];
            let getType = item_details_array[5];
            let item_name = item_details_array[1];
            let expiry_date_maintain = item_details_array[6];
            $('#hidden_input_expiry_date_maintain').val(expiry_date_maintain)
            let status = $('#status').val();
            if(status == ''){
                Swal.fire({
                    title: "Alert",
                    text: "Please Select Status First!",
                    showDenyButton: false,
                    showCancelButton: false,
                    confirmButtonText: `OK`
                });
                error =  1;
                $(this).val("").change();
            }
            $("#hidden_input_item_type").val(getType == '0' ? 'Variation_Product' : getType);
            $("#hidden_input_item_id").val(item_id);
            $("#hidden_input_item_name").val(item_name.trim());
            if(getType != 'Medicine_Product'){
                $('#qty_modal').val(1);
            }else if(getType == 'Medicine_Product' && expiry_date_maintain == 'No'){
                $('#qty_modal').val(1);
            }
            $('#imei').val("");
            $('#serial').val("");
            $('#expiry_date').val("");
            if(getType == 'General_Product' || getType == '0' || getType == 'Installment_Product' || (getType == 'Medicine_Product' && expiry_date_maintain == 'No')){
                $("#qty_modal").prop("readonly", false);
                $(".rowCount").each(function() {
                    let id_temp = $(this).attr('data-item-id');
                    if(id_temp == (item_details_array[0])){
                        Swal.fire({
                            title: "Alert",
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
                    <button type="button" class="mt-2 new-btn bg-blue-btn-p-14 add_imei_serial">
                    <iconify-icon icon="solar:add-circle-broken" width="18"></iconify-icon>
                    </button>
                `)
                $("#qty_modal").prop("readonly", false);
            }else if(getType == 'Medicine_Product' && expiry_date_maintain == 'Yes'){
                $("#qty_modal").val("");
                $('.imeiSerial_add_more').html('');
                $('.expiry_add_more').html('');
                $('.expiry_add_more').html(`
                    <button type="button" class="mt-2 new-btn bg-blue-btn-p-14 add_new_expiry">
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


    function itemCheckBeforeAppend(getType, item_details_array, item_name){
        $('.item_header').text(item_name);
        $('.modal_item_unit').text(item_details_array[2]);
        $("#unit_price_modal").val(item_details_array[3] / item_details_array[4]);
        if(getType == 'General_Product' || getType == '' || (getType == 'Medicine_Product' && item_details_array[6] == 'No')){
            $(".imei_p_f").addClass('d-none');
        }else if(getType == 'Medicine_Product' && item_details_array[6] == 'Yes'){
            let item_id = $('#hidden_input_item_id').val();
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
                            expiryDates += `<option data-item-id="${v.item_id}" data-stock-qty="${v.stock_quantity}" value="${$.trim(v.expiry_imei_serial)}">${$.trim(v.expiry_imei_serial)}</option>`;
                        }
                    });
                }
            });
            $(".imei_p_f").removeClass('d-none');
            $('.imei_serial_label').text(`Expiry Date`);
            $("#imei_append").html("");
            $("#imei_append").append(`
                <div class="input-group mb-2">
                    <select class="select2 form-control expiryProduct" data-exist-check="" data-cart-exist-check="">
                    ${expiryDates}
                    </select>
                    <input type="text" class="form-control integerchk ms-2 expiry_child_qty expiry-first-input" placeholder="Enter Quantity">
                    <div class="expiry_trash_trigger input-group-text new-btn-danger h-40" id="basic-addon">
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
            $('.imei_serial_label').text(`${getType == 'IMEI_Product' ? 'IMEI Number' : 'Serial Number'}`);
            $("#imei_append").html("");
            $("#imei_append").append(`
                <div class="input-group mb-2">
                    <input type="text" name="expiry_imei_serial[]" class="imei_serial_data imei_serial_data_modal unique_match form-control" placeholder="${getType == 'IMEI_Product' ? 'Enter IMEI Number' : ''} ${getType == 'Serial_Product' ? 'Enter Serial Number' : ''}" unique-imeiserial="1" stock-exist-check="" aria-describedby="basic-addon00">
                    <div class="trash_trigger input-group-text new-btn-danger h-40" id="basic-addon00">
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
                            toastr['error']((`${imeiSerial} ${item_type == 'IMEI_Product' ? 'IMEI' : 'Serial '} number not found in our record!`), '');
                            $(himself).attr('stock-exist-check', 'NotExist');
                        }
                    }else{
                        toastr['error']((`${imeiSerial} ${item_type == 'IMEI_Product' ? 'IMEI' : 'Serial '} number not found in our record!`), '');
                        $(himself).attr('stock-exist-check', 'NotExist');
                    }
                },
            });
        }else{
            $(himself).attr('stock-exist-check', '');
        }
        
    });


    $(document).on('keyup', '.return_unique_match', function(){
        let item_id = $(this).parent().parent().parent().attr('data-item-id');
        let item_type = $(this).parent().find('small').text();
        let imeiSerial = $.trim($(this).val());
        let himself = $(this);
        if(item_type == 'Return IMEI'){
            item_type = 'IMEI_Product';
        }else if(item_type == 'Return Serial'){
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
    $(document).on('keyup', '#qty_modal', function (e) {
        e.preventDefault();
        let qty = $(this).val();
        let item_type = $("#hidden_input_item_type").val();
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
                    if(Number(data) >= Number(qty)){
                        doAppendExpiryIMEISerial(item_type, Number(qty));
                        $(".modal_qty_err_msg_contnr").hide();
                    }else{
                        $("#modal_qty_err_msg").text('Quantity should be less then stock');
                        $(".modal_qty_err_msg_contnr").show();
                    }
                } 
            }
        });


        function doAppendExpiryIMEISerial(item_type, qty){
            if(item_type == 'IMEI_Product' || item_type == 'Serial_Product') {
                $("#imei_append").html("");
                for (let i = 0; i < qty; i++) {
                    $("#imei_append").append(`
                        <div class="input-group mb-2">
                            <input type="text" name="expiry_imei_serial[]" class="imei_serial_data imei_serial_data_modal unique_match form-control" placeholder="${item_type == 'IMEI_Product' ? 'Enter IMEI Number' : ''} ${item_type == 'Serial_Product' ? 'Enter Serial Number' : ''}" unique-imeiserial="1" aria-describedby="basic-addon${i}" stock-exist-check="">
                            <div class="trash_trigger input-group-text new-btn-danger h-40" id="basic-addon${i}">
                                <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="18"></iconify-icon>
                            </div>
                        </div>
                    `);
                }
            }
        }
        
    });


    $(document).on('click', '.add_imei_serial', function(){
        let quantity_trigger = $('#qty_modal').val();
        $('#qty_modal').val(Number(quantity_trigger)+1);
        let type = $('#hidden_input_item_type').val();
        $(this).parent().parent().find('#imei_append').append(`
            <div class="input-group mb-2">
                <input type="text" name="expiry_imei_serial[]" class="imei_serial_data imei_serial_data_modal unique_match form-control" placeholder="${type == 'IMEI_Product' ? 'Enter IMEI Number' : ''} ${type == 'Serial_Product' ? 'Enter Serial Number' : ''}" unique-imeiserial="1" stock-exist-check="">
                <div class="trash_trigger input-group-text new-btn-danger h-40" id="basic-addon${quantity_trigger}">
                    <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="18"></iconify-icon>
                </div>
            </div>
        `);
    });

    $(document).on('click', '.add_new_expiry', function(){
        let item_id = $('#hidden_input_item_id').val();
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
                <select class="select2 form-control expiryProduct" data-exist-check="" data-cart-exist-check="">
                    ${expiryDates}
                </select>
                <input type="text" class="form-control integerchk ms-2 expiry_child_qty expiry-first-input" placeholder="Enter Quantity">
                <div class="expiry_trash_trigger input-group-text new-btn-danger h-40" id="basic-addon">
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

    $(document).on('change', '#status', function () {
        let himself = $(this);
        let status = $(this).val();
        let cartItemCounter = $('#purchase_cart tbody tr').length;
        if(cartItemCounter > 0){
            Swal.fire({
                title: warning + "!",
                text: "If you change status, cart items will be remove",
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: "OK",
                denyButtonText: `Cancel`
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $('#status_hidden').val(status);
                    $('#purchase_cart tbody').html('');
                    calculateAll();
                }else{
                    let oldStatus = $('#status_hidden').val();
                    $(himself).val(oldStatus).change();
                }
            });
            
        }else{
            $('#status_hidden').val(status);
        }

        if(status === 'taken_by_sup_money_returned'){
            $('.account_wrap').removeClass('d-none');
        }else{
            $('.account_wrap').addClass('d-none');
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


    $(document).on('click', '.trash_trigger', function(){
        let quantity_trigger = $('#qty_modal').val();
        if(quantity_trigger == 1){
            Swal.fire({
                title: "Alert",
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

    $(document).on('keyup', '.quantity', function(){
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


    function checkDistinct(array) { 
        const checkSet = new Set(array); 
        return checkSet.size === array.length;   
    } 

    $(document).on('change', '.expiryProduct', function(){
        let himself = $(this);
        let thisVal = $(this).val();
        let current = $(this).attr('data-item-id');
        let item_id = $('#item_id_'+current).val();
        let cVal = '';
        let itemExpiryArr = [];
        
        $('.expiryProduct').each(function(){
            let rowItemId = $('#item_id_'+$(this).attr('data-item-id')).val();
            cVal = $(this).val();
            // Only check expiry dates for same item
            if(item_id === rowItemId) {
                itemExpiryArr.push(cVal);
            }
        });

        let unique = checkDistinct(itemExpiryArr);
        if(!unique){
            $(this).attr('data-exist-check', 'Exist');
            Swal.fire({
                title: "Alert !",
                text: "This expiry date already exists for this item",
                showDenyButton: false,
                showCancelButton: false,
                confirmButtonText: `OK`
            });
        }else{
            $(this).attr('data-exist-check', 'NotExist');
        }

        let cartExpiry = '';
        $('.expiryDateExistCheck').each(function(){
            let cartItemId = $(this).attr('data-item-id');
            cartExpiry = $(this).val();
            // Check if same item and expiry exists in cart
            if(cartExpiry == thisVal && item_id == cartItemId){
                Swal.fire({
                    title: "Alert !",
                    text: `This item with expiry date ${thisVal} already in cart, Please update Quantity`,
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
                    }
                },
            });
        }
    });


    $(document).on('click', '#addToCart', function () { 
        let error = false;
        let unique_err = false;
        let product_type = $('#hidden_input_item_type').val();
        let product_id = $('#hidden_input_item_id').val();
        let quantity = Number($('#qty_modal').val());
        let item_name = $('#hidden_input_item_name').val();
        let unit_price = $('#unit_price_modal').val();
        let expiry_date_maintain = $('#hidden_input_expiry_date_maintain').val();
        if(quantity == 0){
            error = true;
            $('#qty_modal').css("border-color","red");
        }else{
            $('#qty_modal').css("border-color","#d8d6de");
        }
        if(unit_price == ""){ 
            $("#modal_uprice_err_msg").text('The Unit Price is required');
            $(".modal_uprice_err_msg_contnr").show();
            error = true;
            setTimeout(function () {
                $(".modal_uprice_err_msg_contnr").hide();
            }, 1000);
        }else{
            $("#modal_uprice_err_msg").text("");
            $(".modal_uprice_err_msg_contnr").hide();
        } 
        if(quantity==""){ 
            $("#modal_qty_err_msg").text('The Quantity is required');
            $(".modal_qty_err_msg_contnr").show();
            error = true;
            setTimeout(function () {
                $(".modal_qty_err_msg_contnr").hide();
            }, 1000);
        }else{
            $("#modal_qty_err_msg").text("");
            $(".modal_qty_err_msg_contnr").hide();
        }

        let product_type_val = "";
        let item_quantity_val = "";
        if (product_type == 'Medicine_Product' && expiry_date_maintain == 'Yes') {
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
            product_type_val = imei_serial_data.reverse();
            item_quantity_val = item_arr.reverse();


        }else if(product_type == 'IMEI_Product' || product_type == 'Serial_Product') {
            item_quantity_val = '';
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
                        text: `${description_val} ${product_type == 'IMEI_Product' ? 'IMEI' : 'Serial '} number not found in our record!`,
                        showDenyButton: false,
                        showCancelButton: false,
                        confirmButtonText: `OK`
                    });
                }
            });
            product_type_val = imei_serial_data.reverse();
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
                    text: `Duplicate ${product_type == 'IMEI_Product' ? 'IMEI' : 'Serial '} number can't be accepted`,
                    showDenyButton: false,
                    showCancelButton: false,
                    confirmButtonText: `OK`
                });
            }
            if(isUnique(itemsArr) == false){
                Swal.fire({
                    title: "Alert !",
                    text: `Duplicate ${product_type == 'IMEI_Product' ? 'IMEI' : 'Serial '} number can't be accepted`,
                    showDenyButton: false,
                    showCancelButton: false,
                    confirmButtonText: `OK`
                });
            } 
        }

        if(error == false){
            $.ajax({
                type: "GET",
                url: base_url_+'Purchase_return/stockCheck/'+product_id,
                success: function (response) {
                    let data = JSON.parse(response);
                    if(quantity != '' || unit_price != ''){
                        if(data >= quantity){
                            if((product_type == 'Medicine_Product') && expiry_date_maintain == 'Yes'){
                                quantity = $('#imei_append .expiry_child_qty').length;
                            }else{
                                quantity = Number($("#qty_modal").val());
                            }
                            appendCart(item_name, product_id, quantity, product_type, product_type_val,unit_price, item_quantity_val)
                        }else{
                            $("#modal_qty_err_msg").text('Return Quantity should be less then stock');
                            $(".modal_qty_err_msg_contnr").show();
                        }
                    } 
                }
            });
        }
    });


    $(document).on('keyup', '.unit_price', function(e){
        e.preventDefault();
        let n = $(this).attr("data-countid");
        let old_price = $(this).attr('unit_price'); 
        let unit_price = $(this).val(); 
        let qty = $(this).parent().parent().parent().find('.quantity').val(); 
        if(Number(old_price) < Number(unit_price)){
            Swal.fire({
                title: "Alert",
                text: 'Unit price should be less then purchase price',
                showDenyButton: false,
                showCancelButton: false,
                confirmButtonText: `OK`
            });
            $("#unit_price_" + n).val('');
            $("#unit_price_" + n).css({"border-color": "red"});
            $('#total_'+n).val((Number(qty) * Number(0)).toFixed(op_precision));
            calculateAll();
        }else{
            $('#total_'+n).val((Number(qty) * Number(unit_price)).toFixed(op_precision));
            calculateAll();
        }
    });


    let rowCounter
    if(add_edit_mode == 'add_mode'){
        rowCounter = 0;
    }else{
        let eidtRowCount = $('#purchase_cart tbody tr').length
        rowCounter = eidtRowCount;
    }
    function appendCart(item_name, product_id, quantity, product_type, product_type_val,unit_price, item_quantity_val){
        let return_status = $('#status').val();
        let item_details = $('#item_id').val();
        let item_details_array = item_details.split('|');
        let type = product_type;
        let qty_modal_count = quantity;
        let cart_row = '';

        let d_none = '';
        let p_type = '';
        let p_placeholder = '';
        let custom_date = '';
        let readonly = '';
        let validation_cls = '';
        let validation_cls2 = '';
        let checkIMEISerialUnique = '';
        let expiryDateExistCheck = '';
        let readonly_expiry = '';

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
            validation_cls2 = 'countID3';
            expiryDateExistCheck = 'expiryDateExistCheck';
            readonly_expiry = 'readonly';
        }else if(type == 'IMEI_Product'){
            p_type = 'IMEI:';
            p_placeholder = 'Enter IMEI Number';
            readonly = 'readonly';
            validation_cls = 'countID2';
            validation_cls2 = 'countID3';
            checkIMEISerialUnique = 'checkIMEISerialUnique';
        }else if(type == 'Serial_Product'){
            p_type = 'Serial:';
            p_placeholder = 'Enter Serial Number';
            readonly = 'readonly';
            validation_cls = 'countID2';
            validation_cls2 = 'countID3';
            checkIMEISerialUnique = 'checkIMEISerialUnique';
        }



        if (type == 'General_Product' || type == 'Variation_Product' || type == 0 || type == 'Installment_Product' || (type == 'Medicine_Product' && item_details_array[6] == 'No')) {
            rowCounter++
            cart_row = `<tr class="rowCount" row-counter="${rowCounter}" data-item-id="${product_id}">
                        <td>
                            <p id="sl_${rowCounter}">${rowCounter}</p>
                            <input type="hidden" name="item_id[]" id="item_id_${rowCounter}"  value="${item_details_array[0]}"/>
                            <input type="hidden" name="item_type[]" value="${type}"/>
                            <input type="hidden" name="conversion_rate[]" value="${item_details_array[4]}"/>
                        </td>
                        <td>
                            <span>${item_name}</span>
                            <div class="form-group mt-3">
                                <textarea  class="form-control h-50" id="return_note_${rowCounter}" name="return_note[]" placeholder="${Return_Note}..."></textarea>
                            </div> 
                        </td>
                        <td>
                            <div class="form-group">
                                <div class="d-flex align-items-center">
                                    <small class="pe-1">${p_type}</small>
                                    <input type="text" data-countid="${rowCounter}" autocomplete="off" name="expiry_imei_serial[]" onfocus="this.select();" id="serial_${rowCounter}" class="${d_none} form-control ${custom_date} ${validation_cls} expiryDateExistCheck" value="${product_type_val}">
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="input-group">
                                <input type="text" data-countid="${rowCounter}" id="quantity_${rowCounter}" name="quantity[]" value="${quantity}" placeholder="${quantity_ln}" onfocus="this.select();" class="form-control integerchk countID quantity" aria-describedby="basic-addon${rowCounter}">
                                <span class="input-group-text" id="basic-addon${rowCounter}">${item_details_array[2]}</span>
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <div class="d-flex align-items-center">
                                    <input type="text" data-countid="${rowCounter}" unit_price="${Number(unit_price)}" autocomplete="off" id="unit_price_${rowCounter}" name="unit_price[]" onfocus="this.select();" class="form-control integerchk1 calculate_op unit_price" placeholder="${unit_price_ln}" value="${(Number(unit_price).toFixed(op_precision))}"/>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <div class="d-flex align-items-center">
                                    <input type="text" autocomplete="off" id="total_${rowCounter}" name="total[]" class="form-control" value="${Number(quantity * unit_price).toFixed(op_precision)}" readonly />
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <button type="button" class="new-btn-danger row_delete h-40">
                                <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="18"></iconify-icon>
                            </button>
                        </td>
                    </tr>`;
            $('#purchase_cart tbody').append(cart_row);
            setTimeout(function(){
                $('.customDatepicker').datepicker({
                    format: 'yyyy-mm-dd',
                    autoclose: true
                });
            }, 200);
            calculateAll();
            $("#cartPreviewModal").modal('hide');
            $('#item_id').val('').change();
            $('#item_name_hidden').val('');
            $('#item_unit_hidden').val('');
            $('#qty_modal').val('');
        }
        if (type == 'IMEI_Product' || type == 'Serial_Product' || (type == 'Medicine_Product' && item_details_array[6] == 'Yes')) {
            for(let k = 0; k < qty_modal_count; k++){
                rowCounter++
                let imeiSerial = '';
                let return_unique_match = '';
                if(type == 'IMEI_Product' || type == 'Serial_Product'){
                    return_unique_match = 'return_unique_match';
                }
                if(return_status == 'taken_by_sup_pro_returned'){
                    imeiSerial = `<div class="d-flex align-items-center form-group mt-3">
                        <small class="pe-1">Return ${p_type}</small>
                        <input type="text" item-type="${type}" data-countid="${rowCounter}" autocomplete="off" id="rSerial_${rowCounter}" name="expiry_imei_serial_in[]" placeholder="Return ${p_placeholder}" onfocus="this.select();" class="form-control ${validation_cls2} ${custom_date} ${return_unique_match}" value="">
                    </div>
                    <p class="imei-serial-err return-imei-serial-err-unique-${rowCounter}"></p>`;
                }

                cart_row = `<tr class="rowCount" row-counter="${rowCounter}" data-item-id="${product_id}">
                    <td>
                        <p id="sl_${rowCounter}">${rowCounter}</p>
                        <input type="hidden" name="item_id[]" id="item_id_${rowCounter}"  value="${item_details_array[0]}"/>
                        <input type="hidden" name="item_type[]" value="${type}"/>
                        <input type="hidden" name="conversion_rate[]" value="${item_details_array[4]}"/>
                    </td>
                    <td>
                        <span>${item_name}</span>
                        <div class="form-group mt-3">
                            <textarea class="form-control h-50" id="return_note_${rowCounter}" name="return_note[]" placeholder="${Return_Note}..."></textarea>
                        </div> 
                    </td>
                    <td>
                        <div class="d-flex align-items-center form-group">
                            <small class="pe-1">${p_type}</small>
                            <input data-item-id="${product_id}" ${readonly_expiry} item-type="${type}" type="text" data-countid="${rowCounter}" autocomplete="off" id="serial_${rowCounter}" name="expiry_imei_serial[]" placeholder="${p_placeholder}" onfocus="this.select();" class="form-control ${validation_cls} ${expiryDateExistCheck} ${checkIMEISerialUnique}" value="${product_type_val[k]}">
                        </div>
                        <p class="imei-serial-err imei-serial-err-unique-${rowCounter}"></p>
                        ${imeiSerial}
                    </td>
                    <td>
                        <div class="input-group">
                            <input ${readonly} type="text" data-countid="${rowCounter}" id="quantity_${rowCounter}" name="quantity[]" value="${type == 'Medicine_Product' ? item_quantity_val[k] : '1'}" placeholder="${quantity_ln}" onfocus="this.select();" class="form-control integerchk countID quantity" aria-describedby="basic-addon${rowCounter}">
                            <span class="input-group-text" id="basic-addon${rowCounter}">${item_details_array[2]}</span>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="d-flex align-items-center">
                                <input type="text" autocomplete="off" data-countid="${rowCounter}" unit_price="${Number(unit_price)}" id="unit_price_${rowCounter}" name="unit_price[]" onfocus="this.select();" class="form-control integerchk1 calculate_op unit_price" placeholder="${unit_price_ln}" value="${Number(unit_price).toFixed(op_precision)}"/>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="d-flex align-items-center">
                                <input type="text" autocomplete="off" id="total_${rowCounter}" name="total[]" class="form-control" value="${Number(item_quantity_val[k] * unit_price).toFixed(op_precision)}" readonly />
                            </div>
                        </div>
                    </td>
                    <td class="text-center">
                        <button type="button" class="new-btn-danger row_delete h-40">
                            <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="18"></iconify-icon>
                        </button>
                    </td>
                </tr>`;
                $('#purchase_cart tbody').append(cart_row);
                setTimeout(function(){
                    $('.customDatepicker').datepicker({
                        format: 'yyyy-mm-dd',
                        autoclose: true
                    });
                }, 200);
                calculateAll();
                $("#cartPreviewModal").modal('hide');
                $('#item_id').val('').change();
                $('#item_name_hidden').val('');
                $('#item_unit_hidden').val('');
                $('#qty_modal').val('');
            }
            
        }
    }

    $(document).on('click', '.btn-danger', function() {
        let himself = this;
        Swal.fire({
            title: warning + '!',
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
            }
        });
	});


    function calculateAll() {
        let grand_total = 0;
        let i = 1;
        $(".rowCount").each(function () {
            let id = $(this).attr("row-counter");
            let temp = "#sl_" + id;
            $(temp).html(i)
            i++;
            let unit_price = $("#unit_price_" + id).val();
            let quantity_amount = $("#quantity_" + id).val();
            if ($.trim(unit_price) == "" || $.isNumeric(unit_price) == false) {
                unit_price = 0;
            }
            if ($.trim(quantity_amount) == "" || $.isNumeric(quantity_amount) == false) {
                quantity_amount = 0;
            }
            $("#total_" + id).val((parseFloat(unit_price) * parseFloat(quantity_amount)).toFixed(op_precision));

            grand_total += parseFloat(unit_price) * parseFloat(quantity_amount);
        });
        $("#grand_total").val('');
        $("#grand_total").val(parseFloat(grand_total).toFixed(op_precision));
    }

    // Validate form
    $(document).on('submit', '#purchase_return_form', function() {  
        let date = $("#date").val();
        let supplier_id = $("#supplier_id").val();
        let status = $("#status").val();
        let payment_method_id = $("#payment_method_id").val();
        let itemCount = $("#purchase_cart tbody tr").length;
        let error = false;
        let unique_err = false;

        if(date==""){ 
            $("#date_err_msg").text(date_required);
            $(".date_err_msg_contnr").show();
            error = true;
        }else{
            $("#date_err_msg").text("");
            $(".date_err_msg_contnr").hide();
        } 

        if (itemCount == 0) {
            $("#item_id_err_msg").text('At least 1 item is required');
            $(".item_id_err_msg_contnr").show(200);
            error = true;
        }

        if(supplier_id==""){ 
            $("#supplier_id_err_msg").text(supplier_id_required);
            $(".supplier_id_err_msg_contnr").show();
            error = true;
        }else{
            $("#supplier_id_err_msg").text("");
            $(".supplier_id_err_msg_contnr").hide();
        } 
        if(status==""){ 
            $("#status_id_err_msg").text(status_filed_is_rquired);
            $(".status_id_err_msg_contnr").show();
            error = true;
        }else{
            $("#status_id_err_msg").text("");
            $(".status_id_err_msg_contnr").hide();
        } 
        if(status === 'taken_by_sup_money_returned' && payment_method_id==""){ 
            $("#payment_method_id_err_msg").text(account_field_required);
            $(".payment_method_id_err_msg_contnr").show();
            error = true;
        }else{
            $("#payment_method_id_err_msg").text("");
            $(".payment_method_id_err_msg_contnr").hide();
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

        $(".countID3").each(function () {
            let n = $(this).attr("data-countid");
            let imei_serial = $.trim($("#rSerial_" + n).val());
            if (imei_serial == '') {
                $("#rSerial_" + n).css({
                    "border-color": "red"
                });
                error = true;
            }else{
                $("#rSerial_" + n).css({
                    "border-color": "#d8d6de"
                });
            }
        });

        $(".quantity").each(function () {
            let n = $(this).attr("data-countid");
            let quantity_amount = $.trim($("#quantity_" + n).val());
            if (quantity_amount == '' || isNaN(quantity_amount)) {
                $("#quantity_" + n).css({"border-color": "red"})
                error = true;
            }else{
                $("#quantity_" + n).css({
                    "border-color": "#d8d6de"
                });
            }
        });
        $(".unit_price").each(function () {
            let n = $(this).attr("data-countid");
            let unit_price = $.trim($("#unit_price_" + n).val());
            if (unit_price == '' || isNaN(unit_price)) {
                $("#unit_price_" + n).css({"border-color": "red"})
                error = true;
            }else{
                $("#unit_price_" + n).css({
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
                $(`.imei-serial-err-unique-${rowCounter}`).text(`The ${item_type == 'IMEI_Product' ? 'IMEI' : 'Serial'} number not exist in our record`);
            }else{
                $(`.imei-serial-err-unique-${rowCounter}`).text('');
            }
        });
        if(existCheck){
            toastr['error']((`Highlighted items not exist in our record`), '');
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
        let itemsArrReturn = new Array();
        let existCheckReturn = '';
        $('.return_unique_match').each(function(){
            let rowCounter = $(this).attr('data-countid');
            let item_type = $(this).attr('item-type');
            let description_val = $(this).val();
            if(description_val == ''){
                $(this).css("border-color","red");
                error = true;
            }else{
                $(this).css("border-color","#d8d6de");
                itemsArrReturn.push(description_val);
            }
            let currentVal = $(this).attr('stock-exist-check');
            if(currentVal == 'Exist'){
                existCheckReturn = 'Exist';
                $(this).css("border-color","red");
                $(`.return-imei-serial-err-unique-${rowCounter}`).text(`The ${item_type == 'IMEI_Product' ? 'IMEI' : 'Serial'} number is already exist in our record`);
            }else{
                $(`.return-imei-serial-err-unique-${rowCounter}`).text('');
            }
        });
        if(existCheckReturn){
            toastr['error']((`Highlighted items exist in our record`), '');
            error = true;
        }
        // Unique IMEI Number or Serial Number Check
        const isUniqueReturn = (itemsArrReturn) => 
        itemsArrReturn.length === new Set(itemsArrReturn).size
        if(isUniqueReturn(itemsArrReturn) == false){
            error = true;
        }
        if(unique_err == true){
            toastr['error']((`Duplicate IMEI/Serial number can't be accepted`), '');
            error = true;
        }
        if(isUniqueReturn(itemsArrReturn) == false){
            toastr['error']((`Duplicate IMEI/Serial number can't be accepted`), '');
        }

        if(error == true){
            return false;
        }
    
    });

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


    $(document).on('change', '#supplier_id', function() {
        let supplier_id = $(this).val();
        calculateAll();
        $.ajax({
            url: base_url_+'Purchase_return/getSupplierPurchases',
            method:"POST",
            data:{
                supplier_id : supplier_id,
            },
            success:function(response) {
              $("#purchase_id").html(response);
            },
            error:function(){
                alert("error");
            }
        }); 
    });
    $(document).on('change', '#purchase_id', function() {
        let purchase_id = $(this).val();
        $.ajax({
            url: base_url_+'Purchase_return/getItemsOfPurchase',
            method:"POST",
            data:{
                purchase_id : purchase_id, 
            },
            success:function(response) { 
              $("#item_id").html(response);
            },
            error:function(){
                alert("error");
            }
        }); 
    });

    $('.customDatepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
    });
    $(document).on('click', '.row_delete', function() {
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

});