$(function() {
    "use strict";

    toastr.options = {
        positionClass: 'toast-bottom-right'
    };


    let base_url_ = $("#base_url_").val();
    let quantity_ln = $("#quantity").val();
    let date_field_required = $("#date_field_required").val();
    let at_least_food_menu = $("#at_least_food_menu").val();
    let select_from_outlet_id = $("#select_from_outlet_id").val();
    let select_to_outlet_id = $("#select_to_outlet_id").val();
    let select_status = $("#select_status").val();
    let outlet_id_session = $("#outlet_id_session").val();
    let select = $("#select").val();
    let are_you_sure = $("#are_you_sure").val();
    let yes = $("#yes").val();
    let cancel = $("#cancel").val();
    let warning = $("#warning").val();
    let imei = $("#imei").val();
    let serial = $("#serial").val();
    let add_edit_mode = $("#add_mode").val();
 
    $('.select2').select2();
 

    function calculateAll() {
        let i = 1;
        $(".rowCount").each(function () {
            let id = $(this).attr("row-counter");
            let temp = "#sl_" + id;
            $(temp).html(i)
            i++;
        });
    }
    calculateAll();


    $(document).on('change', '#item_id', function(e) {
        let error = false;
        let item = $(this).val();

        $(".modal_qty_err_msg_contnr").hide();
        let from_outlet = $('#from_outlet_id').val();
        if(from_outlet == ''){
            error = true;
            Swal.fire({
                title: "Alert !",
                text: "Select From Outlet Firest!",
                showDenyButton: false,
                showCancelButton: false,
                confirmButtonText: `OK`
            });
        }
        if(item != ''){
            let item_details_array = item.split('||');
            let item_id = item_details_array[0];
            let unit_price = item_details_array[2];
            let unit_name = item_details_array[3];
            let getType = item_details_array[4];
            let expiry_date_maintain = item_details_array[5];

            $('#bulk_transfer_item_id').val(item_id)
            $('#bulk_transfer_item_type').val(getType)

            let item_name = $(this).find('option:selected').text();
            $("#hidden_input_item_type").val(getType == '0' ? 'Variation_Product' : getType);
            $("#hidden_input_item_id").val(item_id);
            $("#unit_price_modal").val(unit_price);
            $("#unit_price_modal").val(unit_price);
            $("#hidden_input_unit_name").val(unit_name);
            $("#hidden_input_item_name").val(item_name.trim());
            if(getType != 'Medicine_Product'){
                $('#qty_modal').val(1);
            }
            $('#imei').val("");
            $('#serial').val("");
            $('#expiry_date').val("");

            if(getType == 'General_Product' || getType == '0' || getType == 'Installment_Product' || (getType == 'Medicine_Product' && expiry_date_maintain == 'No')){
                $("#qty_modal").prop("readonly", false);
                $(".rowCount").each(function() {
                    let id_temp = $(this).attr('data-item_id');
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
                    <button type="button" class="new-btn h-40 bg-blue-btn-p-14 add_imei_serial">
                        <iconify-icon icon="solar:add-circle-broken" width="18"></iconify-icon>
                    </button>
                `)
                $("#qty_modal").prop("readonly", false);
            }else if(getType == 'Medicine_Product' && expiry_date_maintain == 'Yes'){
                $("#qty_modal").val("");
                $('.imeiSerial_add_more').html('');
                $('.expiry_add_more').html('');
                $('.expiry_add_more').html(`
                    <button type="button" class="new-btn h-40 bg-blue-btn-p-14 add_new_expiry">
                        <iconify-icon icon="solar:add-circle-broken" width="18"></iconify-icon>
                    </button>
                `);
                $("#qty_modal").prop("readonly", true);
            }
            if(error == false){
                itemCheckBeforeAppend(getType, item_details_array, item_name.trim());
            }else{
                return false;
            }
        }
    });


    function itemCheckBeforeAppend(getType, item_details_array, item_name){
        let expiry_date_maintain = item_details_array[5];
        $('.item_header').text(item_name);
        $("#unit_price_modal").val(item_details_array[2]);
        $('.modal_item_unit').text(item_details_array[3]);
        $('#hidden_input_expiry_date_maintain').val(expiry_date_maintain);
        if(getType == 'General_Product' || getType == '' || (getType == 'Medicine_Product' && expiry_date_maintain == 'No')){
            $(".imei_p_f").addClass('d-none');
        }else if(getType == 'Medicine_Product' && expiry_date_maintain == 'Yes'){
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
            $(".imei_p_f").removeClass('d-none');
            $('.imei_serial_label').text(`Expiry Date`);
            $("#imei_append").html("");
            $("#imei_append").append(`
                <div class="input-group mb-2">
                    <select class="select2 form-control expiryProduct" data-exist-check="" data-cart-exist-check="">
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
                    <div class="new-btn-danger h-40 trash_trigger input-group-text" id="basic-addon">
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


    $(document).on('click', '.add_imei_serial', function(){
        let quantity_trigger = $('#qty_modal').val();
        $('#qty_modal').val(Number(quantity_trigger)+1);
        let type = $('#hidden_input_item_type').val();
        $(this).parent().parent().find('#imei_append').append(`
            <div class="input-group mt-2">
                <input type="text" name="expiry_imei_serial[]" class="imei_serial_data imei_serial_data_modal unique_match form-control" placeholder="${type == 'IMEI_Product' ? 'Enter IMEI Number' : ''} ${type == 'Serial_Product' ? 'Enter Serial Number' : ''}" unique-imeiserial="" aria-describedby="basic-addon${quantity_trigger}">
                <div class="new-btn-danger h-40 trash_trigger input-group-text" id="basic-addon">
                    <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="18"></iconify-icon>
                </div>
            </div>
        `);
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


    $(document).on('keyup', '.expiry_child_qty', function(){
        let himself = $(this);
        let currentVal = $(this).parent().find('.expiryProduct').val();
        if(currentVal){
            let currentQty = $(this).val();
            let stockQty = $(this).parent().find('.expiryProduct option:selected').attr('data-stock-qty');
            if(Number(currentQty) > Number(stockQty)){
                Swal.fire({
                    title: "Alert!",
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
                title: "Alert!",
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

    $(document).on('keyup', '.expiry_child_qty', function(){
        let himself = $(this);
        let currentVal = $(this).parent().find('.expiryProduct').val();
        if(currentVal){
            let currentQty = $(this).val();
            let stockQty = $(this).parent().find('.expiryProduct option:selected').attr('data-stock-qty');
            if(Number(currentQty) > Number(stockQty)){
                Swal.fire({
                    title: "Alert !",
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
                title: "Alert !",
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


    $(document).on('keyup', '.unique_match', function(){
        let imeiSerial = $.trim($(this).val());
        let himself = $(this);
        let item_id = $('#hidden_input_item_id').val();
        let item_type = $('#hidden_input_item_type').val();
        let from_outlet_id = $('#from_outlet_id').val();
        if(imeiSerial != ''){
            $.ajax({
                url: base_url_+'Sale/getIMEISerialByOutlet',
                method: "POST",
                data: { item_id: item_id, outlet_id:from_outlet_id },
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
                            let fromOutlet = $("#from_outlet_id option:selected").text();
                            $(himself).attr('stock-exist-check', 'NotExist');
                            toastr['error']((`${imeiSerial} ${item_type == 'IMEI_Product' ? 'IMEI' : 'Serial '} number not found in ${fromOutlet} outlet!`), '');
                        }
                    }else{
                        $(himself).attr('stock-exist-check', 'NotExist');
                    }
                },
            });
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
        let item_id = $(this).parent().parent().parent().attr('data-item_id');
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
        let expiry_date_maintain = $("#hidden_input_expiry_date_maintain").val();
        let item_id = $("#hidden_input_item_id").val();
        let quantity = Number($("#qty_modal").val());
        let item_name = $("#hidden_input_item_name").val();
        let item_unit = $("#hidden_input_unit_name").val();
        let unique_err = false;
        let error = false;
        if(quantity == 0){
            error = true;
            $('#qty_modal').css("border-color","red");
        }else{
            $('#qty_modal').css("border-color","#d8d6de");
        }
        let product_type_val = "";
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
            product_type_val = imei_serial_data.reverse();
            item_quantity_val = item_arr.reverse();

        }else if(item_type == 'IMEI_Product' || item_type == 'Serial_Product') {
            let itemsArr = new Array();
            let imei_serial_data = [];
            let description_val;
            let uniqueImeiSerial;
            let existCheck = '';
            $('.imei_serial_data').each(function(i,obj){
                uniqueImeiSerial = $(this).attr('unique-imeiserial');
                if(uniqueImeiSerial == '0'){
                    $(this).css("border-color","red");
                    unique_err = true;
                }
                description_val = $(this).val();
                if(description_val == ''){
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
                    let fromOutlet = $("#from_outlet_id option:selected").text();
                    Swal.fire({
                        title: "Alert !",
                        text: `${description_val} ${item_type == 'IMEI_Product' ? 'IMEI' : 'Serial '} number not found in ${fromOutlet} outlet!`,
                        showDenyButton: false,
                        showCancelButton: false,
                        confirmButtonText: `OK`
                    });
                }
            });
            product_type_val = imei_serial_data.reverse();
            item_quantity_val = '';
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
            $.ajax({
                type: "GET",
                url: base_url_+'Transfer/stockCheck/'+item_id,
                success: function (response) {
                    let data = JSON.parse(response);
                    if(quantity != ''){
                        if(Number(data) >= Number(quantity)){
                            let qty_modal;
                            if((item_type == 'Medicine_Product') && expiry_date_maintain == 'Yes'){
                                qty_modal = $('#imei_append .expiry_child_qty').length;
                            }else{
                                qty_modal = Number($("#qty_modal").val());
                            }
                            appendCart(item_id,item_type,item_name,qty_modal,item_unit,product_type_val, item_quantity_val);
                            $("#imei_append").html("");
                            $(".expiry_date").val("");
                        }else{
                            $("#modal_qty_err_msg").text('Quantity should be less then stock');
                            $(".modal_qty_err_msg_contnr").show();
                        }
                    } 
                }
            });
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




    let rowCounter
    if(add_edit_mode == 'Add'){
        rowCounter = 0;
    }else{
        let eidtRowCount = $('#transfer_cart tbody tr').length
        rowCounter = eidtRowCount;
    }
    
    function appendCart(item_id,item_type,item_name,quantity,item_unit,product_type_val="", item_quantity_val=""){
        let item_details = $('#item_id').val();
        let item_details_array = item_details.split('||');
        let cart_row = '';
        let custom_date = '';
        let readonly = '';
        let checkIMEISerialUnique = '';
        let expiryDateExistCheck = '';
        let p_type = '';
        let readonly_expiry = '';
        let qtyReadonly = '';

        if(item_type == 'IMEI_Product'){
            p_type = 'IMEI:';
            checkIMEISerialUnique = 'checkIMEISerialUnique';
            qtyReadonly = 'readonly';
        }else if(item_type == 'Serial_Product'){
            p_type = 'Serial:';
            checkIMEISerialUnique = 'checkIMEISerialUnique';
            qtyReadonly = 'readonly';
        }else if (item_type == 'Medicine_Product' && item_details_array[5] == 'Yes'){
            p_type = 'Expiry Date:';
            custom_date = 'customDatepicker';
            expiryDateExistCheck = 'expiryDateExistCheck';
            readonly_expiry = 'readonly';
        }else if(item_type == 'General_Product' || item_type == 'Variation_Product' || item_type == 0 || item_type == 'Installment_Product' || (item_type == 'Medicine_Product' && item_details_array[5] == 'No')){
            readonly = 'readonly';
        }



        if (item_type == 'General_Product' || item_type == 'Variation_Product' || item_type == 0 || item_type == 'Installment_Product' || (item_type == 'Medicine_Product' && item_details_array[5] == 'No')) {
            rowCounter++
            cart_row = `<tr class="rowCount" data-item_id="${item_id}" row-counter="${rowCounter}" data-id="${rowCounter}" id="row_${rowCounter}">
                        <td class="op_padding_left_10">
                            <p id="sl_${rowCounter}">${rowCounter}</p>
                        </td>
                        <td>
                            <span class="op_padding_bottom_5">${item_name}</span>
                            <input type="hidden" id="ingredient_id_${rowCounter}" name="ingredient_id[]" value="${item_id}"/>
                            <input type="hidden" id="${rowCounter}" name="item_type[]" value="${item_type}"/>
                        </td>
                        <td>
                            <div class="form-group">
                                <input ${readonly} type="text" autocomplete="off" id="serial_${rowCounter}" name="expiry_imei_serial[]" onfocus="this.select();" class="form-control ${custom_date}" value="">
                            </div>
                        </td>
                        <td>
                            <div class="input-group">
                                <input type="text" data-countID="${rowCounter}" id="quantity_amount_${rowCounter}" name="quantity_amount[]" value="${quantity}" placeholder="${quantity_ln}" onfocus="this.select();" class="form-control integerchk aligning countID quantity" aria-describedby="basic-addon2">
                                <span class="input-group-text" id="basic-addon2">${item_unit}</span>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center">
                                <button type="button" class="new-btn-danger h-40 row_delete">
                                    <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="18"></iconify-icon>
                                </button>
                            </div>
                        </td>
                    </tr>`;

            $('#transfer_cart tbody').append(cart_row);
            $('#ingredient_id').val('').change();
            $("#cartPreviewModal").modal('hide');
            $('#item_hidden').val('');
            $('#item_name_hidden').val('');
            $('#item_unit_hidden').val('');
            $('#qty_modal').val('');
            calculateAll();
        }

        if (item_type == 'IMEI_Product' || item_type == 'Serial_Product' || (item_type == 'Medicine_Product' && item_details_array[5] == 'Yes')){
            for(let k = 0; k < quantity; k++){
                rowCounter++
                cart_row = `<tr class="rowCount" data-item_id="${item_id}" row-counter="${rowCounter}" data-id="${rowCounter}" id="row_${rowCounter}">
                    <td class="op_padding_left_10">
                        <p id="sl_${rowCounter}">${rowCounter}</p>
                    </td>
                    <td>
                        <span class="op_padding_bottom_5">${item_name}</span>
                        <input type="hidden" id="ingredient_id_${rowCounter}" name="ingredient_id[]" value="${item_id}"/>
                        <input type="hidden" id="${rowCounter}" name="item_type[]" value="${item_type}"/>
                    </td>
                    <td>
                        <div class="d-flex align-items-center form-group">
                            <small class="pe-1">${p_type}</small>
                            <input ${readonly_expiry} item-type="${item_type}" ${readonly} type="text" autocomplete="off" data-countid="${rowCounter}" id="serial_${rowCounter}" name="expiry_imei_serial[]" onfocus="this.select();" class="${checkIMEISerialUnique} ${expiryDateExistCheck}  form-control " value="${product_type_val[k]}">
                        </div>
                        <p class="imei-serial-err imei-serial-err-unique-${rowCounter}"></p>
                    </td>
                    <td>
                        <div class="input-group">
                            <input ${readonly} ${qtyReadonly} type="text" data-countID="${rowCounter}" id="quantity_amount_${rowCounter}" name="quantity_amount[]" value="${item_type == 'Medicine_Product' ? item_quantity_val[k] : '1'}" placeholder="${quantity_ln}" onfocus="this.select();" class="form-control integerchk countID quantity" aria-describedby="basic-addon2">
                            <span class="input-group-text" id="basic-addon2">${item_unit}</span>
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center">
                            <button type="button" class="new-btn-danger h-40 row_delete">
                                <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="18"></iconify-icon>
                            </button>
                        </div>
                    </td>
                </tr>`;
                $('#transfer_cart tbody').append(cart_row);
                $('#ingredient_id').val('').change();
                $("#cartPreviewModal").modal('hide');
                $('#item_hidden').val('');
                $('#item_name_hidden').val('');
                $('#item_unit_hidden').val('');
                $('#qty_modal').val('');
                calculateAll();

            }
            
        }
    }


    $(document).on('keyup', '.quantity', function(){
        let himself = $(this);
        let currentVal = $(this).val();
        let current = $(this).attr('data-countid');
        let item_id = $('#ingredient_id_'+current).val();
        let singleExpiryDate = $('#serial_'+current).val();
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
                            title: 'Alert!',
                            text: `Maximum ${response.data.stock_quantity} can be return!`,
                            showDenyButton: true,
                            showCancelButton: false,
                            confirmButtonText: 'OK',
                            denyButtonText: cancel
                        }).then((result) => {
                            /* Read more about isConfirmed, isDenied below */
                            if (result.isConfirmed) {
                                himself.val(response.data.stock_quantity);
                            }else{
                                himself.val(0);
                            }
                        });
                    }
                }
            }
        });
    });

    
    $(document).on('change', '#from_outlet_id', function() {
        $('#transfer_cart tbody').empty();
        let outlet_id = $(this).val();
        setOutlet(outlet_id);
    });

    if(add_edit_mode == 'Add'){
        $(document).ready(function() {
            let outlet_id = outlet_id_session;
            setOutlet(outlet_id);
        });
    }

    function setOutlet(outlet_id){
        $.ajax({
            type: "GET",
            url: base_url_+'Transfer/outletWithoutSessionOutlet/'+outlet_id,
            success: function (response) {
                if(response.status == 'success'){
                    $('#to_outlet_id').html('');
                    $('#to_outlet_id').append(`<option value="">${select}</option>`);
                    $.each(response.data, function (key, item) {
                        $('#to_outlet_id').append(`<option value="${item.id}">${item.outlet_name}</option>`);
                    });
                }
            }
        });
    }


    // Validate form
    $(document).on('submit', '#transfer_form', function() {
        let date = $("#transfer_date").val();
        let ingredientCount = $("#transfer_cart tbody tr").length;
        let to_outlet_id = $("#to_outlet_id").val();
        let from_outlet_id = $("#from_outlet_id").val();
        let status_ = $("#status").val();
        let error = false;
        let unique_err = false;

        if (date == "") {
            $("#date_err_msg").text(date_field_required);
            $(".date_err_msg_contnr").show(200);
            error = true;
        }

        if (from_outlet_id == '') {
            $("#f_outlet_id_err_msg").text(select_from_outlet_id);
            $(".f_outlet_id_err_msg_contnr").show(200);
            error = true;
        }
        if (to_outlet_id == '') {
            $("#t_outlet_id_err_msg").text(select_to_outlet_id);
            $(".t_outlet_id_err_msg_contnr").show(200);
            error = true;
        }
        if (status_ == '') {
            $("#status_err_msg").text(select_status);
            $(".status_err_msg_contnr").show(200);
            error = true;
        }
       
        if (ingredientCount < 1) {
            $("#ingredient_id_err_msg").text(at_least_food_menu);
            $(".ingredient_id_err_msg_contnr").show(200);
            error = true;
        }
        let cartItem = $('#transfer_cart tbody tr').length;

        if(cartItem == 0){
            Swal.fire({
                title: warning+" !",
                text: "The Cart is emply!",
                showDenyButton: false,
                showCancelButton: false,
                confirmButtonText: 'OK',
                denyButtonText: cancel
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    this_action.parent().parent().parent().remove();
                    calculateAll();
                }
            });
        }


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

        if (error == true) {
            return false;
        }
    });

    $(document).on('click', '.row_delete', function() {
        let this_action = $(this);
        Swal.fire({
            title: warning+" !",
            text: are_you_sure,
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: yes,
            denyButtonText: cancel
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                this_action.parent().parent().parent().remove();
                calculateAll();
            }
        });
    });



     // Bulk Import 
    $(document).on('click', '.bulk_imei_serial_upload', function(){
        $('#bulkImportModal').modal('show');
    });

    $('#fileUploadForTransfer').on('submit', function (e) {
        e.preventDefault();
        // Check if a file is selected
        let fileInput = $('#file')[0];
        if (fileInput.files.length === 0) {
            $('.import_error_wrap .import_validation_error').html('Please select a file to upload.');
            return;
        }
        let item_id = $('#bulk_transfer_item_id').val();
        let item_type = $('#bulk_transfer_item_type').val();
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
            url: base_url_+'Transfer/bulkImporForTransfer', // Replace with your PHP file URL
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if(response.status == 'success'){
                    $('#fileUploadForTransfer')[0].reset();
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
                $('.name_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
                $('#bulkImportModal .name_err_msg').html(`${response.message}`);
            }
        });
    });


    function imeiSerialAppendToCart(append_arr) {
        let item_details = $('#item_id').val();
        let item_details_array = item_details.split('||');
        let item_id = item_details_array[0];
        let item_name = item_details_array[1];
        let item_unit = item_details_array[3];
        let item_type = item_details_array[4];
        let cart_row = '';
        let p_type = '';
        let p_placeholder = '';
        let readonly = '';
        let validation_cls = '';
        let checkIMEISerialUnique = '';
        let rowCounter = 0;
        
        if(item_type == 'IMEI_Product'){
            p_type = 'IMEI:';
            p_placeholder = 'Enter IMEI Number';
            readonly = 'readonly';
            validation_cls = 'countID2';
            checkIMEISerialUnique = 'checkIMEISerialUnique';
        }else if(item_type == 'Serial_Product'){
            p_type = 'Serial:';
            p_placeholder = 'Enter Serial Number';
            readonly = 'readonly';
            validation_cls = 'countID2';
            checkIMEISerialUnique = 'checkIMEISerialUnique';
        }  
        if(append_arr){
            append_arr.forEach(item => {
                rowCounter++;
                cart_row += `<tr class="rowCount" data-item_id="${item_id}" row-counter="${rowCounter}" data-id="${rowCounter}" id="row_${rowCounter}">
                    <td class="op_padding_left_10">
                        <p id="sl_${rowCounter}">${rowCounter}</p>
                    </td>
                    <td>
                        <span class="op_padding_bottom_5">${item_name}</span>
                        <input type="hidden" id="ingredient_id_${rowCounter}" name="ingredient_id[]" value="${item_id}"/>
                        <input type="hidden" id="${rowCounter}" name="item_type[]" value="${item_type}"/>
                    </td>
                    <td>
                        <div class="d-flex align-items-center form-group">
                            <small class="pe-1">${p_type}</small>
                            <input item-type="${item_type}" ${readonly} type="text" autocomplete="off" data-countid="${rowCounter}" id="serial_${rowCounter}" name="expiry_imei_serial[]" onfocus="this.select();" class="${checkIMEISerialUnique} form-control " value="${item}">
                        </div>
                        <p class="imei-serial-err imei-serial-err-unique-${rowCounter}"></p>
                    </td>
                    <td>
                        <div class="input-group">
                            <input ${readonly} type="text" data-countID="${rowCounter}" id="quantity_amount_${rowCounter}" name="quantity_amount[]" value="1" placeholder="Quantity" onfocus="this.select();" class="form-control integerchk countID quantity" aria-describedby="basic-addon2">
                            <span class="input-group-text" id="basic-addon2">${item_unit}</span>
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center">
                            <button type="button" class="new-btn-danger h-40 row_delete">
                                <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="18"></iconify-icon>
                            </button>
                        </div>
                    </td>
                </tr>`;
            });
                    
            $('#transfer_cart tbody').prepend(cart_row);
            $('#ingredient_id').val('').change();
            calculateAll();
            $('#item_name_hidden').val('');
            $('#item_unit_hidden').val('');
            $("#cartPreviewModal").modal('hide');
            $("#bulkImportModal").modal('hide'); 
            $('#item_hidden').val('');
            $('#qty_modal').val('');
        }
    }



});

