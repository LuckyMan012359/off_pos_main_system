$(function ($) {
    "use strict";
    let base_url_ = $("#base_url_").val();
    let select = $("#select").val();
    let add_edit_mode = $("#add_edit_mode").val();
    let name_field_required = $("#name_field_required").val();
    let The_Contact_field_required = $("#The_Contact_field_required").val();
    let The_Phone_field_is_required = $("#The_Phone_field_is_required").val();
    let The_Unit_Name_field_is_required = $("#The_Unit_Name_field_is_required").val();
    let Expiry_Quantitty_Field_required = $("#Expiry_Quantitty_Field_required").val();
    let op_precision = $("#op_precision").val();
    let ok = $("#ok").val();
    let warning = $('#warning').val();
    let no_permission_for_this_module = $('#no_permission_for_this_module').val();
    let the_name_field_is_required = $('#the_name_field_is_required').val();
    let alert = $("#alert_").val();
    let yes = $("#yes").val();
    let img_select_error_msg = $("#img_select_error_msg").val();
    let unit_type = $('#select_unit_type').val();
    let item_type_global = $('#type').val();
    //Initialize Select2 Elements
    $('.select2').select2();
    $(document).on('keydown', '.integerchk', function (e) {
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
    onkeydown = function (e) {
        if (e.which == 13) {
            e.preventDefault();
        }
    }


    let old_type = $('#type').val();
    // Item Type Change Validation
    $(document).on('change', '#type',function(){
        let item_type = $(this).val();
        let demoType = $('#APPLICATION_DEMO_TYPE').val();
        let application_mode = $('#APPLICATION_MODE').val();
        // Valid demo types based on item_type
        if(application_mode == 'demo'){
            let valid = false;
            if ((item_type == 'General_Product') && (demoType == 'General Store' || demoType == 'Service Center' || demoType == 'Beauty Pourlar' || demoType == 'All Type')) {
                valid = true;
            } else if ((item_type == 'Variation_Product') && (demoType == 'Fashion Shop' || demoType == 'All Type')) {
                valid = true;
            } else if ((item_type == 'IMEI_Product') && (demoType == 'Mobile Shop' || demoType == 'All Type')) {
                valid = true;
            } else if ((item_type == 'Serial_Product') && (demoType == 'Computer Shop' || demoType == 'All Type')) {
                valid = true;
            } else if ((item_type == 'Medicine_Product') && (demoType == 'Pharmacy' || demoType == 'All Type')) {
                valid = true;
            } else if ((item_type == 'Installment_Product') && (demoType == 'Installment Sale' || demoType == 'All Type')) {
                valid = true;
            } else if ((item_type == 'Service_Product') && (demoType == 'Service Center' || demoType == 'Beauty Pourlar' || demoType == 'All Type')) {
                valid = true;
            }
            // If the selected type is not valid, revert to the old type
            if (!valid) {
                Swal.fire({
                    title: alert,
                    html: `Type changing is disabled in demo, to check other demos please click here: <a href="https://dsbeta.work/dsdemo/off_pos.php" class="base-color-c" target="_blank">ALL_DEMO_LINK</a>`,
                    showDenyButton: false,
                    showCancelButton: false,
                    confirmButtonText: `OK`
                });
                let originalText = old_type;
                let modifiedText = originalText.replace(/_/g, " ");
                $(this).val(old_type);
                $('.item_type_group #select2-type-container').text(modifiedText);
            } else {
                old_type = item_type;
            }
        }
        
        fieldHideShowByItemType();
    });



    function fieldHideShowByItemType() {
        let item_type = $('.check_type').val();
        $("#conversion_rate").removeAttr('readonly');
        $("#discount_price").removeAttr('readonly');
        $("#alert_quantity").removeAttr('readonly');
        $("#sale_unit_id").removeAttr('disabled');
        $("#purchase_unit_id").removeAttr('disabled');
        $("#has_offer").removeAttr('disabled');
        $("#large_image").removeAttr('disabled');
        $("#details_modal_image").removeAttr('disabled');

        if(item_type == "General_Product"){
            $('#variation_wrap').removeClass('d-block');
            $('#variation_wrap').addClass('d-none');
            $('.for_items').removeClass('off-d-none');
            $('.for_installment').addClass('off-d-none');
            $('.disable_service_field').removeClass('off-d-none');
            $('#select_unit_type').prop('disabled', false);
            $('.double_unit_hide_show').addClass('d-none');
            $('.single_unit_hide_show').removeClass('d-none');
            $('.common_warranty').removeClass('d-none');
            $('.common_guarantee').removeClass('d-none');
            $('.generic_name').hide();
            $('.rack_no').hide();

            $('#sale_price_group').removeClass('d-none');
            $('#purchase_price_group').removeClass('d-none');
            $('#whole_sale_price_group').removeClass('d-none');
            $('#opening_stock_group').removeClass('d-none');
            $('#sale_price_group').removeClass('d-none');
            $('#alert_quantity_group').removeClass('d-none');
            $('#combo_item_cart').hide();
            $('#sale_price').prop('readonly', false);
            $('.expiry_maintain_wrapper').hide();

        }else if(item_type=="Variation_Product"){
            $('#variation_wrap').removeClass('d-none');
            $('#variation_wrap').addClass('d-block');
            $('#variation_wrap .select2-container--default').css('width', '100%');
            $("#opening_stock").attr('readonly','readonly');
            $("#discount_price").attr('readonly','readonly');
            $("#alert_quantity").attr('readonly','readonly');
            $('.for_items').removeClass('off-d-none');
            $('.for_installment').addClass('off-d-none');
            $('.disable_service_field').removeClass('off-d-none');
            $('#select_unit_type').prop('disabled', false);
            $('.double_unit_hide_show').addClass('d-none');
            $('.single_unit_hide_show').removeClass('d-none');
            $('.common_warranty').removeClass('d-none');
            $('.common_guarantee').removeClass('d-none');
            $('.generic_name').hide();
            $('.rack_no').hide();

            $('#sale_price_group').addClass('d-none');
            $('#purchase_price_group').addClass('d-none');
            $('#whole_sale_price_group').addClass('d-none');
            $('#opening_stock_group').addClass('d-none');
            $('#alert_quantity_group').addClass('d-none');
            $('#combo_item_cart').hide();
            $('#sale_price').prop('readonly', false);
            $('.expiry_maintain_wrapper').hide();

        }else if(item_type=="IMEI_Product"){
            $('#variation_wrap').removeClass('d-block');
            $('#variation_wrap').addClass('d-none');
            $('.for_items').removeClass('off-d-none');
            $('.for_installment').addClass('off-d-none');
            $('.disable_service_field').removeClass('off-d-none');
            $('#select_unit_type').prop('disabled', true);
            $('.double_unit_hide_show').addClass('d-none');
            $('.single_unit_hide_show').removeClass('d-none');
            $('#select_unit_type').val(1).change();
            $('.common_warranty').removeClass('d-none');
            $('.common_guarantee').removeClass('d-none');
            $('.generic_name').hide();
            $('.rack_no').hide();

            $('#sale_price_group').removeClass('d-none');
            $('#purchase_price_group').removeClass('d-none');
            $('#whole_sale_price_group').removeClass('d-none');
            $('#opening_stock_group').removeClass('d-none');
            $('#sale_price_group').removeClass('d-none');
            $('#alert_quantity_group').removeClass('d-none');
            $('#combo_item_cart').hide();
            $('#sale_price').prop('readonly', false);
            $('.expiry_maintain_wrapper').hide();

        }else if(item_type=="Serial_Product"){
            $('#variation_wrap').removeClass('d-block');
            $('#variation_wrap').addClass('d-none');
            $('.for_items').removeClass('off-d-none');
            $('.for_installment').addClass('off-d-none');
            $('.disable_service_field').removeClass('off-d-none');
            $('#select_unit_type').prop('disabled', true);
            $('.double_unit_hide_show').addClass('d-none');
            $('.single_unit_hide_show').removeClass('d-none');
            $('#select_unit_type').val(1).change();
            $('.common_warranty').removeClass('d-none');
            $('.common_guarantee').removeClass('d-none');
            $('.generic_name').hide();
            $('.rack_no').hide();

            $('#sale_price_group').removeClass('d-none');
            $('#purchase_price_group').removeClass('d-none');
            $('#whole_sale_price_group').removeClass('d-none');
            $('#opening_stock_group').removeClass('d-none');
            $('#sale_price_group').removeClass('d-none');
            $('#alert_quantity_group').removeClass('d-none');
            $('#combo_item_cart').hide();
            $('#sale_price').prop('readonly', false);
            $('#sale_price_group').show();
            $('.expiry_maintain_wrapper').hide();

        }else if(item_type=="Medicine_Product"){
            $('#variation_wrap').removeClass('d-block');
            $('#variation_wrap').addClass('d-none');
            $('#sale_price_group').removeClass('d-none');
            $('.for_items').removeClass('off-d-none');
            $('.for_installment').addClass('off-d-none');
            $('#select_unit_type').prop('disabled', false);
            $('.double_unit_hide_show').addClass('d-none');
            $('.single_unit_hide_show').removeClass('d-none');
            $('.common_warranty').addClass('d-none');
            $('.common_guarantee').addClass('d-none');
            $('.generic_name').show();
            $('.rack_no').show();

            $('#sale_price_group').removeClass('d-none');
            $('#purchase_price_group').removeClass('d-none');
            $('#whole_sale_price_group').removeClass('d-none');
            $('#opening_stock_group').removeClass('d-none');
            $('#sale_price_group').removeClass('d-none');
            $('#alert_quantity_group').removeClass('d-none');
            $('#combo_item_cart').hide();
            $('#sale_price').prop('readonly', false);
            $('#sale_price_group').show();
            $('.expiry_maintain_wrapper').show();


        }else if(item_type == 'Installment_Product'){
            $('.for_items').addClass('off-d-none');
            $('.for_installment').removeClass('off-d-none');
            $('.disable_service_field').removeClass('off-d-none');
            $('#select_unit_type').prop('disabled', true);
            $('.double_unit_hide_show').addClass('d-none');
            $('.single_unit_hide_show').removeClass('d-none');
            $('#select_unit_type').val(1).change();
            $('.common_warranty').removeClass('d-none');
            $('.common_guarantee').removeClass('d-none');
            $('.generic_name').hide();
            $('.rack_no').hide();

            $('#sale_price_group').removeClass('d-none');
            $('#purchase_price_group').removeClass('d-none');
            $('#whole_sale_price_group').removeClass('d-none');
            $('#opening_stock_group').removeClass('d-none');
            $('#sale_price_group').removeClass('d-none');
            $('#alert_quantity_group').removeClass('d-none');
            $('#combo_item_cart').hide();
            $('#sale_price').prop('readonly', false);
            $('#sale_price_group').show();
            $('.expiry_maintain_wrapper').hide();


        }else if(item_type == 'Service_Product'){
            $('.disable_service_field').addClass('off-d-none');
            $('.generic_name').hide();
            $('.rack_no').hide();

            $('#sale_price_group').removeClass('d-none');
            $('#purchase_price_group').removeClass('d-none');
            $('#whole_sale_price_group').removeClass('d-none');
            $('#opening_stock_group').removeClass('d-none');
            $('#sale_price_group').removeClass('d-none');
            $('#alert_quantity_group').removeClass('d-none');
            $('#combo_item_cart').hide();
            $('#sale_price').prop('readonly', false);
            $('#sale_price_group').show();
            $('.expiry_maintain_wrapper').hide();

        }else if(item_type == 'Combo_Product'){
            $('.generic_name').hide();
            $('.rack_no').hide();
            $('#variation_wrap').addClass('d-none');
            $('#whole_sale_price_group').hide();
            $('#purchase_price_group').hide();
            $('#opening_stock_group').hide();
            $('#supplier_id_group').hide();
            $('#select_unit_type_group').hide();
            $('#alert_quantity_group').hide();
            $('.single_unit_hide_show').hide();
            $('#brand_wrap').hide();
            $('#combo_item_cart').show();
            $('#sale_price').prop('readonly', true);
            $('#sale_price_group').hide();
            $('.expiry_maintain_wrapper').hide();

        }else{
            $('.for_installment').addClass('off-d-none');
            $('.for_items').removeClass('off-d-none');
            $(".variation_div_0").hide();
        }
    }
    fieldHideShowByItemType();

    $(document).on('change', '.check_box_trigger', function(){
        if ($(this).is(":checked")){
            $(this).parent().find('.checkbox_el').val('on');
        }else{
            $(this).parent().find('.checkbox_el').val('off');
        }
    });


    $(document).on('change', '#expiry_date_maintain', function(){
        $('#opening_stock').val('');
        $('.quantity_trigger ').val('');
        $('.item_append ').html('');
    });


    $(document).on('change', '#combo_item', function(){
        let item_id = $(this).val();
        let exist_check = '';
        $('#combo_table tbody tr').each(function(){
            if($(this).attr('data-item_id') == item_id){
                Swal.fire({
                    title: alert,
                    text: `This item already in cart`,
                    showDenyButton: false,
                    showCancelButton: false,
                    confirmButtonText: `OK`
                });
                exist_check = 'Yes';
            }
        });


        if(exist_check == ''){
            let item_name = $('option:selected', this).text();
            let item_price = $('option:selected', this).attr('data-item-price');
            let html = '';
            html +=`<tr data-item_id="${item_id}">
                <td class="sn_counter"></td>
                <td>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input check_box_trigger" type="checkbox" id="inlineCheckbox1" checked>
                        <label class="form-check-label" for="inlineCheckbox1"></label>
                        <input type="hidden" name="item_show_in_invoice[]" class="checkbox_el">
                    </div>
                </td>
                <td>
                    <p>${item_name}</p>
                </td>
                <td>
                    <div class="form-group">
                        <input  autocomplete="off" type="text" onfocus="select();" name="combo_item_qty[]" class="form-control integerchk comboCalculation quantity" placeholder="Quantity" value="1">
                        <input type="hidden" name="combo_item_id[]" value="${item_id}">
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <input  autocomplete="off" type="text" onfocus="select();" name="combo_item_unitprice[]" class="form-control integerchk comboCalculation unit_price" placeholder="Unit Price" value="${item_price}">
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <input  autocomplete="off" type="text" onfocus="select();" name="" class="form-control integerchk combo_total" placeholder="Total" value="${ 1 * parseFloat(item_price)}" readonly>
                    </div>
                </td>
                <td>
                    <span class="combo_trash_trigger cursor-pointer new-btn-danger justify-content-center d-inline-flex">
                        <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="18"></iconify-icon>
                    </span>
                </td>
            </tr>`;
            $('#combo_table tbody').append(html);
            comboSnSetter();
            setTimeout(function(){
                comboCalculation();
            }, 200);
        }

    });

    $(document).on('click', '.combo_trash_trigger', function(){
        $(this).parent().parent().remove();
        comboSnSetter();
        comboCalculation();
    });

    function comboSnSetter(){
        let i = 1;
        $('#combo_table tbody tr').each(function(){
            $(this).find('.sn_counter').text(i++);
        });
    }

    $(document).on('keyup', '.comboCalculation', function(){
        let cThis = $(this);
        comboCalculation(cThis);
    });

    function comboCalculation(cThis){
        let unit_price = $(cThis).parent().parent().parent().find('.unit_price').val();
        let quantity = $(cThis).parent().parent().parent().find('.quantity').val();
        if(isNaN(quantity) || quantity == ''){
            quantity = 0;
        }else{
            quantity = parseFloat(quantity);
        }
        if(isNaN(unit_price) || unit_price == ''){
            unit_price = 0;
        }else{
            unit_price = parseFloat(unit_price);
        }
        $(cThis).parent().parent().parent().find('.combo_total').val(quantity * unit_price);
        let total = 0;
        let totalSum = 0;
        $('.combo_total').each(function(){
            total = $(this).val();
            if(isNaN(total) || total == ''){
                total = 0;
            }else{
                total = parseFloat(total);
                totalSum += total;
            }
        });
        $('.combo_sale_subtotal').val(parseFloat(totalSum))
        $('#sale_price').val(parseFloat(totalSum))
    }




    // Opening Stock Validation 
    $(document).on('focus', '#opening_stock', function(){
        $('#opening_stock_modal').modal('show');
        let type = $('.check_type').find(":selected").val();
        let expiry_date_maintain = $('#expiry_date_maintain').find(":selected").val();
        $('.expiry_add_more').html('');
        $('.expiry_heading').text('');
        $(".quantity_trigger").prop("readonly", false);
        if(type == 'IMEI_Product' || type == 'Serial_Product'){
            $('.imeiSerial_add_more').html('');
            $('.imeiSerial_add_more').html(`
                <button type="button" class="mt-2 new-btn h-40 bg-blue-btn-p-14 add_imei_serial">
                <iconify-icon icon="solar:add-circle-broken" width="18"></iconify-icon>
                </button>
            `)
        }else if(type == 'Medicine_Product' && expiry_date_maintain == 'Yes'){
            $('.imeiSerial_add_more').html('');
            $('.expiry_add_more').html(`
                <button type="button" class="mt-2 new-btn h-40 bg-blue-btn-p-14 add_new_expiry">
                <iconify-icon icon="solar:add-circle-broken" width="18"></iconify-icon>
                </button>
            `);
            $('.expiry_heading').text('Total');
            $(".quantity_trigger").prop("readonly", true);
        }else if(type == 'Variation_Product'){
            $('.expiry_add_more').html('');
            $('.expiry_heading').text('');
            $(".quantity_trigger").prop("readonly", false);  
        }else{
            $('.expiry_add_more').html('');
            $('.form_clear_trigger').html('');
            $('.expiry_heading').text('');
            $(".quantity_trigger").prop("readonly", false);  
        }
    });

    $(document).on('click', '.add_new_expiry', function(){
        let outlet = $(this).parent().attr('data-id');
        $('.item_description_body_'+outlet).append(`
            <div class="input-group mb-2">
                <input type="text" class="form-control integerchk expiry_child_qty me-2 expiry-first-input" placeholder="Enter Quantity">
                <input type="text" class="form-control expiryProduct customDatepicker expiry-second-input" placeholder="Enter Expiry Date" item-quantity="" data-outlet="${outlet}" aria-describedby="basic-addon">
                <div class="expiry_trash_trigger input-group-text new-btn-danger h-40" data-outlet="${outlet}" id="basic-addon">
                <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="18"></iconify-icon>
                </div>
            </div>
        `);
        $('.customDatepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });
    });

    $(document).on('click', '.expiry_trash_trigger', function(){
        let outlet = $(this).attr('data-outlet');
        $(this).parent().remove();
        expiryQuantitySum(outlet);
    });

    $(document).on('keyup', '.expiry_child_qty', function(){
        let outlet =  $(this).parent().parent().attr("data-id");
        let currentQty = $(this).val();
        $(this).siblings(".customDatepicker").attr('item-quantity', currentQty);
        expiryQuantitySum(outlet);
    });
    function expiryQuantitySum(outlet){
        let expiry_each_val_sum = 0;
        let expiry_each_val;
        $(`.item_description_body_${outlet}  .expiry_child_qty`).each(function(){
            expiry_each_val = $(this).val();
            if(expiry_each_val == ''){
                expiry_each_val = 0;
            }
            expiry_each_val_sum += Number(expiry_each_val);
        });
        $('#outlet_'+outlet).val(Number(expiry_each_val_sum));
    }

    $(document).on('focus', '.opening_stock_variation', function(){

        let item_id = $(this).attr('data-item');
        let item_opening_stock =$(this).attr('serial');
        $('.variation_opening_main').val('');
        $('.variation_opening_main').val(item_opening_stock);
        $('#opening_stock_modal').modal('show');
        $('.variation_product_stock_check').attr('data-item',item_id);

        setTimeout(function(){
            variationProductStockShow();
        }, 100);
    });
    function variationProductStockShow(){
        let item_id;
        let outlet_id;
        let himself;

        let stockQty = 0;
        let conversion = 0;

        $('.variation_product_stock_check').each(function(){
            himself = $(this);
            item_id = $(this).attr('data-item');
            outlet_id = $(this).attr('data-outlet');
            
            $.ajax({
                type: "POST",
                url: base_url_+"Item/stockQtyCheck",
                async:   false,
                data: {
                    item_id : item_id,
                    outlet_id : outlet_id,
                },
                success: function (response) {
                    console.log(response);
                    if(response.status == 'success'){
                        stockQty = response.data.stock_quantity;
                        conversion = response.data.conversion_rate;
                        $('#outlet_'+outlet_id).val(stockQty ? stockQty / conversion : 0);
                    }
                }
            });
        });
    }


    $(document).on('keyup', '.quantity_trigger', function(){
        let type = $('.check_type').find(":selected").val();
        if(type == 'IMEI_Product' || type == 'Serial_Product'){
            let quantity = $(this).val();
            let outlet = $(this).attr('data-outlet');
            $('.item_description_body_'+outlet).html('');
            if($.isNumeric(quantity)){
                if(quantity > 1000){
                    Swal.fire({
                        title: alert,
                        text: `Maximum quantity of 500 can be given for ${type == "IMEI_Product" ? 'IMEI Number' : 'Serial Number'}.`,
                        showDenyButton: false,
                        showCancelButton: false,
                        confirmButtonText: `OK`
                    });
                    $(this).val('');
                } else{
                    for(let i = 0; i < Number(quantity); i++){
                        $('.item_description_body_'+outlet).prepend(`
                            <div class="input-group mt-2">
                                <input type="text" name="item_description[]" data-outlet="${outlet}" class="item_description unique_match form-control" placeholder="${type == 'IMEI_Product' ? 'Enter IMEI Number' : ''} ${type == 'Serial_Product' ? 'Enter Serial Number' : ''}" unique-imeiserial="" aria-describedby="basic-addon${i}">
                                <span class="input-group-text trash_trigger new-btn-danger h-40" data-outlet="${outlet}" id="basic-addon${i}">
                                <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="18"></iconify-icon>
                                </span>
                            </div>
                        `);
                    }
                }
            }else{
                $(this).val('');
            }
            
        }
    });

    $(document).on('focusout', '.unique_match', function(){
        let imeiSerial = $(this).val();
        let himself = $(this);
        let type = $('.check_type').find(":selected").val();
        $.ajax({
            url: base_url_+'Item/imeiSerialCheck',
            method: "POST",
            data: {
                imeiSerial: imeiSerial,
                type: type
            },
            success: function (response) {
                if(response != ''){
                    Swal.fire({
                        title: alert,
                        text: `This ${type == 'IMEI_Product' ? 'IMEI' : 'Serial '} number already exist!`,
                        showDenyButton: false,
                        showCancelButton: false,
                        confirmButtonText: `OK`
                    });
                    $(himself).attr('unique-imeiserial', '0');
                }else{
                    $(himself).attr('unique-imeiserial', '1');
                }
            },
        });
    });


    function checkDistinct(array) { 
        const checkSet = new Set(array); 
        return checkSet.size === array.length;   
    } 

    $(document).on('change', '.expiryProduct', function(){
        let outlet_id = $(this).attr('data-outlet');
        let thisVal = $(this).val();
        let cVal = '';
        let expiryArr = [];
        $(`.item_description_body_${outlet_id} .expiryProduct`).each(function(){
            cVal = $(this).val();
            expiryArr.push(cVal);
        });
        let unique = checkDistinct(expiryArr);
        if(!unique){
            $(this).attr('data-exist-check', 'Exist');
        }else{
            $(this).attr('data-exist-check', 'NotExist');
        }
        if(!unique){
            Swal.fire({
                title:  warning+" !",
                text: `This ${thisVal} already in list, Please update Quantity`,
                showDenyButton: false,
                showCancelButton: false,
                confirmButtonText: `OK`
            });
        }
    });

    $(document).on('click', '#oppening_stock_submit', function(){
        let type = $('.check_type').find(":selected").val();
        let purchase_price = $('#purchase_price').val();
        let opening_stock = $('#opening_stock').val();
        let expiry_date_maintain = $('#expiry_date_maintain').val();
        let quantity;
        let outlet;
        let quantitySum = 0;
        let item_description;
        let error = false;
        let unique_err = false;
        let description_val;
        let expiry_child_qty;
        let customDatepicker;
        let item_quantity;
        let uniqueImeiSerial;

        if(type == 'General_Product' || type == 'IMEI_Product' || type == 'Serial_Product' || type == 'Medicine_Product' || type == 'Installment_Product'){
            if(purchase_price == ''){
                Swal.fire({
                    title: alert,
                    text: `You must enter purchase price if you enter opening stock, otherwise the system can not calculate the stock value of this item`,
                    showDenyButton: false,
                    showCancelButton: false,
                    confirmButtonText: `OK`
                });
            }
        }

        if(type == 'General_Product' || type == 'Installment_Product' || (type == 'Medicine_Product' && expiry_date_maintain == 'No')){
            $('.item_append').html('');
            $('.quantity_trigger').each(function(){
                quantity = $(this).val();
                outlet = $(this).attr('data-outlet');
                if(quantity){
                    quantitySum += parseInt(quantity);
                }
                $('.item_append').prepend(`
                    <input type="hidden" name="outlets[]" value="${outlet}">
                    <input type="hidden" name="quantity[]" value="${quantity}">
                    <input type="hidden" name="item_description[]" value="">
                `)
            });
            $('#opening_stock').val(quantitySum);
        }else if(type == 'IMEI_Product' || type == 'Serial_Product'){
            let itemsArr = new Array();
            $('.item_description').each(function(){
                uniqueImeiSerial = $(this).attr('unique-imeiserial');
                if(uniqueImeiSerial == '0'){
                    unique_err = true;
                }
                description_val = $(this).val();
                if(description_val == ''){
                    error = true;
                }else{
                    itemsArr.push(description_val);
                }
            });
            // Unique IMEI Number or Serial Number Check
            const isUnique = (itemsArr) => 
            itemsArr.length === new Set(itemsArr).size
            if(isUnique(itemsArr) == false){
                error = true;
            }
            if(unique_err == true){
                Swal.fire({
                    title: alert,
                    text: `Duplicate ${type == 'IMEI_Product' ? 'IMEI' : 'Serial '} number can't be accepted`,
                    showDenyButton: false,
                    showCancelButton: false,
                    confirmButtonText: `OK`
                });
            }
            if(error == false){
                $('.quantity_trigger').each(function(){
                    quantity = $(this).val();
                    if(quantity){
                        quantitySum += parseInt(quantity);
                    }
                });
                $('.item_append').html('');
                $('.item_description').each(function(){
                    outlet = $(this).attr('data-outlet');
                    item_description = $(this).val();
                    $('.item_append').prepend(`
                        <input type="hidden" name="outlets[]" value="${outlet}">
                        <input type="hidden" name="quantity[]" value="1">
                        <input type="hidden" name="item_description[]" value="${item_description}">
                    `);
                });
                $('#opening_stock').val(quantitySum);
            }else{
                if(isUnique(itemsArr) == false){
                    Swal.fire({
                        title: alert,
                        text: `Duplicate ${type == 'IMEI_Product' ? 'IMEI' : 'Serial '} number can't be accepted`,
                        showDenyButton: false,
                        showCancelButton: false,
                        confirmButtonText: `OK`
                    });
                }else{
                    Swal.fire({
                        title: alert,
                        text: `Duplicate ${type == 'IMEI_Product' ? 'IMEI' : 'Serial '} number can't be accepted`,
                        showDenyButton: false,
                        showCancelButton: false,
                        confirmButtonText: `OK`
                    });
                }
            }
        }else if(type == 'Medicine_Product'){
            let existMatch = '';
            let existCheck = '';
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
            });

            if(existMatch == 'Match'){
                Swal.fire({
                    title:  warning+" !",
                    text: `Expiry Date Confilicted, Please update quantity`,
                    showDenyButton: false,
                    showCancelButton: false,
                    confirmButtonText: `OK`
                });
            }
 

            $('.expiry_child_qty').each(function(){
                expiry_child_qty = $(this).val();
                if(expiry_child_qty == ''){
                    Swal.fire({
                        title:  warning+" !",
                        text: `${Expiry_Quantitty_Field_required}`,
                        showDenyButton: false,
                        showCancelButton: false,
                        confirmButtonText: `OK`
                    });
                    error = true;
                }
            });
            $('.customDatepicker').each(function(){
                customDatepicker = $(this).val();
                if(customDatepicker == ''){
                    error = true;
                }
            });

            if(error == false){
                $('.quantity_trigger').each(function(){
                    quantity = $(this).val();
                    if(quantity){
                        quantitySum += parseInt(quantity);
                    }
                });
                $('.item_append').html('');
                $('.customDatepicker').each(function(){
                    outlet = $(this).attr('data-outlet');
                    item_quantity = $(this).attr('item-quantity');
                    item_description = $(this).val();
                    $('.item_append').prepend(`
                        <input type="hidden" name="outlets[]" value="${outlet}">
                        <input type="hidden" name="quantity[]" value="${item_quantity}">
                        <input type="hidden" name="item_description[]" value="${item_description}">
                    `);
                });
                $('#opening_stock').val(quantitySum);
            }

        }else if(type == 'Variation_Product'){
            let stock_field = $('.variation_opening_main').val();
            $('#op_stock_set_'+stock_field).html('');
            $('.quantity_trigger').each(function(){
                quantity = $(this).val();
                outlet = $(this).attr('data-outlet');
                if(quantity){
                    quantitySum += parseInt(quantity);
                }
                $('#op_stock_set_'+stock_field).append(`
                    <input type="hidden" name="outlets${stock_field}[]" value="${outlet}">
                    <input type="hidden" name="quantity${stock_field}[]" value="${quantity}">
                `)
            });
            $('#opening_stock_variation_'+stock_field).val(quantitySum);
        }
        
        if(error == true || unique_err == true){
            return false;
        }else{
            $('#opening_stock_modal').modal('hide');
            $('#opening_stock').prop('readonly', true);
        }
    });

    $(document).on('click', '.add_imei_serial', function(){
        let outlet = $(this).parent().parent().find('.quantity_trigger').attr('data-outlet');
        let quantity_trigger = $(this).parent().parent().find('.quantity_trigger').val();
        $(this).parent().parent().find('.quantity_trigger').val(Number(quantity_trigger)+1);
        let type = $('.check_type').find(":selected").val();
        $(this).parent().parent().find('.form_clear_trigger').append(`
            <div class="input-group mt-2">
                <input type="text" name="item_description[]" data-outlet="${outlet}" class="item_description unique_match form-control" placeholder="${type == 'IMEI_Product' ? 'Enter IMEI Number' : ''} ${type == 'Serial_Product' ? 'Enter Serial Number' : ''}" unique-imeiserial="" aria-describedby="basic-addon${quantity_trigger}">
                <div class="trash_trigger input-group-text new-btn-danger h-40" data-outlet="${outlet}" id="basic-addon${quantity_trigger}">
                <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="18"></iconify-icon>
                </div>
            </div>
        `);
    });

    $(document).on('click', '.trash_trigger', function(){
        $(this).parent().remove();
        let getOutlet = $(this).parent().find('.item_description').attr('data-outlet');
        let quantity_trigger = $('#outlet_'+getOutlet).val();
        let result = Number(quantity_trigger);
        $('#outlet_'+getOutlet).val(result - 1);
    });

    // Add Category Modal Trigger
    $(document).on('click', '.add_category_by_ajax', function () {
        $.ajax({
            url: base_url_ + "Master/checkAccess",
            method: "GET",
            async: false,
            dataType: 'json',
            data: { controller: "60", function: "add" },
            success: function (response) {
                if (response == false) {
                    Swal.fire({
                        title:  warning+" !",
                        text: no_permission_for_this_module,
                        showDenyButton: false,
                        showCancelButton: false,
                        confirmButtonText: ok,
                    });
                } else {
                    $("#addCategoryModal").modal('show');
                }
            }
        });
    });


    // Add Category By Ajax
    $(document).on('click', '#addCategory', function () {
        $.ajax({
            url: base_url_ + "Master/checkAccess",
            method: "GET",
            async: false,
            dataType: 'json',
            data: { controller: "60", function: "add" },
            success: function (response) {
                if (response == false) {
                    Swal.fire({
                        title:  warning+" !",
                        text: no_permission_for_this_module,
                        showDenyButton: false,
                        showCancelButton: false,
                        confirmButtonText: ok,
                    });
                } else {
                    let name_cat = $("#name_cat").val();
                    let error = 0;
                    if (name_cat == '') {
                        error = 1;
                        let cl1 = ".cat_name_err_msg";
                        let cl2 = ".cat_name_err_msg_contnr";
                        $(cl1).text(name_field_required);
                        $(cl2).show(200).delay(6000).hide(200, function () {});
                    } else {
                        $("#name_cat").css('border', '1px solid #ccc');
                    }
                    if (error == 0) {
                        let name_cat = $("#name_cat").val();
                        let description_cat = $("#description_cat").val();
                        $.ajax({
                            type: 'POST',
                            url: base_url_+'Ajax/addCategoryByAjax',
                            data: {
                                name: name_cat,
                                description: description_cat,
                            },
                            success: function (data) {
                                if (data) {
                                    let json = $.parseJSON(data);
                                    let html = '<option>'+select+'</option>';
                                    $.each(json.categories, function (i, v) {
                                        html += '<option value="' + v.id + '">' + v.name +
                                            '</option>';
                                    });
                                    $("#category_id").html(html);
                                    $("#category_id").val(json.id).change();
                                    $("#addCategoryModal").modal('hide');
                                }
                            }
                        });
                    } 
                }
            }
        });
    });


    // Add Rack Modal Trigger
    $(document).on('click', '.add_rack_by_ajax', function () {
        $.ajax({
            url: base_url_ + "Master/checkAccess",
            method: "GET",
            async: false,
            dataType: 'json',
            data: { controller: "304", function: "add" },
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
                    $("#addRackModal").modal('show');
                }
            }
        });
    });



    // Add Rack By Ajax
    $(document).on('click', '#addRack', function () {
        $.ajax({
            url: base_url_ + "Master/checkAccess",
            method: "GET",
            async: false,
            dataType: 'json',
            data: { controller: "304", function: "add" },
            success: function (response) {
                if (response == false) {
                    Swal.fire({
                        title:  warning+" !",
                        text: no_permission_for_this_module,
                        showDenyButton: false,
                        showCancelButton: false,
                        confirmButtonText: ok,
                    });
                } else {
                    let name_rack = $("#name_rack").val();
                    let description_rack = $("#description_rack").val();
                    let error = false;
                    if (name_rack == '') {
                        error = true;
                        $('.rack_name_err_msg').text(the_name_field_is_required);
                        $('.rack_name_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
                    }
                    if (error == false) {
                        $.ajax({
                            type: 'POST',
                            url: base_url_+'Ajax/addRackByAjax',
                            data: {
                                name: name_rack,
                                description: description_rack
                            },
                            success: function (data) {
                                if (data) {
                                    let json = $.parseJSON(data);
                                    let html = '<option>'+select+'</option>';
                                    $.each(json.racks, function (i, v) {
                                        html += '<option value="' + v.id + '">' + v.name +
                                            '</option>';
                                    });
                                    $("#rack_id").html(html);
                                    $("#rack_id").val(json.id).change();
                                    $("#addRackModal").modal('hide');
                                    $("#name_rack").val('');
                                    $("#description_rack").val('');
                                }
                            }
                        });
                    } 
                }
            }
        });
    });










    // Image Crop
    $(document).on('click', '.add_image_for_crop_variation', function(){
        let image_preview = $(this).attr('src');
        $('.set_preview_img').attr('src', image_preview);
    });


    // Email Validation
    function IsEmail(email) {
        let regex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
        return regex.test(email);
    }

    // Add Supplier Modal Trigger
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
                        title:  warning+" !",
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

    // Add Supplier By Ajax
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
                        title:  warning+" !",
                        text: no_permission_for_this_module,
                        showDenyButton: false,
                        showCancelButton: false,
                        confirmButtonText: ok,
                    });
                } else {
                    let name_supplier = $("#name_supplier").val();
                    let contact_person = $("#contact_person").val();
                    let email = $("#email").val();
                    let phone = $("#phone").val();
                    let error = 0;
                    if (name_supplier == '') {
                        error = 1;
                        $('.sup_name_err_msg').text(name_field_required);
                        $('.sup_name_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
                    }
                    if(email != '' && !IsEmail(email)){
                        error = 1;
                        $('.email_err_msg').text("The Email field should be valid!");
                        $('.email_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
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
                    if (error == 0) {
                        let data = $("form#add_supplier_form").serialize();
                        $.ajax({
                            type: 'GET',
                            url: base_url_+'Ajax/addSupplierByAjax',
                            datatype: 'json',
                            data: data,
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


    // Add Brand Modal Trigger
    $(document).on('click', '.add_brand_by_ajax', function () {
        $.ajax({
            url: base_url_ + "Master/checkAccess",
            method: "GET",
            async: false,
            dataType: 'json',
            data: { controller: "297", function: "add" },
            success: function (response) {
                if (response == false) {
                    Swal.fire({
                        title:  warning+" !",
                        text: no_permission_for_this_module,
                        showDenyButton: false,
                        showCancelButton: false,
                        confirmButtonText: ok,
                    });
                } else {
                    $("#addBrandModal").modal('show');
                }
            }
        });
        
    });
    // Add Brand By Ajax
    $(document).on('click', '#addBrand', function () {
        $.ajax({
            url: base_url_ + "Master/checkAccess",
            method: "GET",
            async: false,
            dataType: 'json',
            data: { controller: "297", function: "add" },
            success: function (response) {
                if (response == false) {
                    Swal.fire({
                        title:  warning+" !",
                        text: no_permission_for_this_module,
                        showDenyButton: false,
                        showCancelButton: false,
                        confirmButtonText: ok,
                    });
                } else {
                    let name_brand = $("#name_brand").val();
                    let description_brand = $("#description_brand").val();
                    let error = 0;
                    if (name_brand == '') {
                        error = 1;
                        let cl1 = ".brand_name_err_msg";
                        let cl2 = ".brand_name_err_msg_contnr";
                        $(cl1).text(name_field_required);
                        $(cl2).show(200).delay(6000).hide(200, function () {});
                    } else {
                        $("#name_brand").css('border', '1px solid #ccc');
                    }
                    if (error == 0) {
                        $.ajax({
                            type: 'POST',
                            url: base_url_+'Ajax/addBrandByAjax',
                            data: {
                                name: name_brand,
                                description: description_brand,
                            },
                            success: function (data) {
                                if (data) {
                                    let json = $.parseJSON(data);
                                    let html = '<option>'+select+'</option>';
                                    $.each(json.brands, function (i, v) {
                                        html += '<option value="' + v.id + '">' + v.name +
                                            '</option>';
                                    });
                                    $("#brand_id").html(html);
                                    $("#brand_id").val(json.id).change();
                                    $("#addBrandModal").modal('hide');
                                    $("form#add_brand_form")[0].reset();
                                }
                            }
                        });
                    }
                }
            }
        });
    });

    $(document).on('submit', '#item_form', function () {
        let error = false;
        let item_type = $('#type').val();
        let name = $('#name').val();
        let purchase_price = $('#purchase_price').val();
        let sale_price = $('#sale_price').val();
        let select_unit_type =  $('#select_unit_type').find(":selected").val();
        let unit_id =  $('#unit_id').find(":selected").val();
        let purchase_unit_id =  $('#purchase_unit_id').find(":selected").val();
        let sale_unit_id =  $('#sale_unit_id').find(":selected").val();
        let conversion_rate =  $('#conversion_rate').val();
        let category_id =  $('#category_id').val();
        let opening_stock = $('#opening_stock').val();

        if(item_type == 'General_Product' || item_type == 'IMEI_Product' || item_type == 'Serial_Product' || item_type == 'Medicine_Product' || item_type == 'Installment_Product'){
            if((opening_stock != '' || opening_stock != 0) && purchase_price == ''){
                Swal.fire({
                    title: alert,
                    text: `You must enter purchase price if you enter opening stock, otherwise the system can not calculate the stock value of this item`,
                    showDenyButton: false,
                    showCancelButton: false,
                    confirmButtonText: `OK`
                });
                error = true;
            }
        }

        if(item_type == 'Combo_Product'){
            let combo_item = $('#combo_table tbody tr').length;
            if(combo_item == '' || combo_item == 0){
                Swal.fire({
                    title: alert,
                    text: `Minimum 1 combo item is required`,
                    showDenyButton: false,
                    showCancelButton: false,
                    confirmButtonText: `OK`
                });
                error = true;
            }
            $('#combo_table tbody tr').each(function(){
                if($(this).find('.quantity').val() == ''){
                    $(this).find('.quantity').css({
                        'border':'1px solid red',
                    });
                    error = true;
                }else{
                    $(this).find('.quantity').css({
                        'border':'1px solid #dfdbdb',
                    });
                }
                if($(this).find('.unit_price').val() == ''){
                    $(this).find('.unit_price').css({
                        'border':'1px solid red',
                    });
                    error = true;
                }else{
                    $(this).find('.unit_price').css({
                        'border':'1px solid #dfdbdb',
                    });
                }
            });
        }

        if (name == "") {
            $("#name_err_msg").text('The Name field is requied');
            $(".name_err_msg_contnr").show(200);
            error = true;
        }
        if (category_id == "") {
            $("#category_id_err_msg").text('The Category field is requied');
            $(".category_id_err_msg_contnr").show(200);
            error = true;
        }

        if(item_type != 'Combo_Product'){
            if (select_unit_type == 1) {
                if(item_type != 'Service_Product'){
                    if (unit_id == "") {
                        $("#unit_id_err_msg").text('The Unit field is requied');
                        $(".unit_id_err_msg_contnr").show(200);
                        error = true;
                    }
                }
            }else if(select_unit_type == 2){
                if(item_type != 'Service_Product'){
                    if (purchase_unit_id == "") {
                        $("#purchase_unit_id_err_msg").text('The Unit field is requied');
                        $(".purchase_unit_id_err_msg_contnr").show(200);
                        error = true;
                    }
                    if (sale_unit_id == "") {
                        $("#sale_unit_id_err_msg").text('The Unit field is requied');
                        $(".sale_unit_id_err_msg_contnr").show(200);
                        error = true;
                    }
                    if (conversion_rate == "") {
                        $("#conversion_rate_err_msg").text('The Unit field is requied');
                        $(".conversion_rate_err_msg_contnr").show(200);
                        error = true;
                    }
                }
            }
            if(item_type != 'Variation_Product'){
                if(item_type != 'Service_Product'){
                    let stockCount = $('#opening_stock').val();
                    let purchase_price = $('#purchase_price').val();
                    if(stockCount && purchase_price == ''){
                        $("#purchase_price_err_msg").text('The Purchase Price field is requied');
                        $(".purchase_price_err_msg_contnr").show(200);
                        error = true;
                    }
                    if (sale_price == "") {
                        $("#sale_price_err_msg").text('The Sale Price field is requied');
                        $(".sale_price_err_msg_contnr").show(200);
                        error = true;
                    }
                }
            }
            $(".required_check").each(function () {
                let value = $(this).val();
                if (value == '') {
                    $(this).css({
                        "border-color": "red"
                    }).show(200).delay(2000, function () {
                        $(this).css({
                            "border-color": "#d2d6de"
                        });
                    });
                    error = true;
                }
            });
        }

        console.log(error)

        if (error == true) {
            return false;
        }
    });

    // Add Purchase Unit
    $(document).on('click', '#addPurchaseUnit', function () {
        $.ajax({
            url: base_url_ + "Master/checkAccess",
            method: "GET",
            async: false,
            dataType: 'json',
            data: { controller: "65", function: "add" },
            success: function (response) {
                if (response == false) {
                    Swal.fire({
                        title:  warning+" !",
                        text: no_permission_for_this_module,
                        showDenyButton: false,
                        showCancelButton: false,
                        confirmButtonText: ok,
                    });
                } else {
                    let unit_name = $("#unit_name_p").val();
                    let error = 0;
                    if (unit_name == '') {
                        error = 1;
                        let cl1 = ".unit_name_err_msg";
                        let cl2 = ".unit_name_err_msg_contnr";
                        $(cl1).text(The_Unit_Name_field_is_required);
                        $(cl2).show(200).delay(6000).hide(200, function () {});
                    } else {
                        $("#unit_name").css('border', '1px solid #ccc');
                    }
                    if (error == 0) {
                        let data = $("form#add_purchase_unit_form").serialize();
                        $.ajax({
                            type: 'get',
                            url: base_url_+'Ajax/addUnitByAjax',
                            datatype: 'json',
                            data: data,
                            success: function (data) {
                                if (data) {
                                    let json = $.parseJSON(data);
                                    let html = '<option>'+select+'</option>';
                                    $.each(json.units, function (i, v) {
                                        html += '<option value="' + v.id + '">' + v
                                            .unit_name + '</option>';
                                    });
                                    $("#purchase_unit_id").html(html);
                                    $("#sale_unit_id").html(html);
                                    $("#purchase_unit_id").val(json.id).change();
                                    $("#addPurchaseUnitModal").modal('hide');
                                }
                            }
                        });
                    }
                }
            }
        });
    });


    // Add Unit Modal Trigger
    $(document).on('click', '.add_purchase_unit_by_ajax', function () {
        $.ajax({
            url: base_url_ + "Master/checkAccess",
            method: "GET",
            async: false,
            dataType: 'json',
            data: { controller: "65", function: "add" },
            success: function (response) {
                if (response == false) {
                    Swal.fire({
                        title:  warning+" !",
                        text: no_permission_for_this_module,
                        showDenyButton: false,
                        showCancelButton: false,
                        confirmButtonText: ok,
                    });
                } else {
                    $("#addPurchaseUnitModal").modal('show');
                }
            }
        });
    });
    // Add Sale Modal Trigger
    $(document).on('click', '.add_sale_unit_by_ajax', function () {
        let unit_type = $(this).attr('data-unit-type');
        $('#set_unit_type').val(unit_type);
        $.ajax({
            url: base_url_ + "Master/checkAccess",
            method: "GET",
            async: false,
            dataType: 'json',
            data: { controller: "65", function: "add" },
            success: function (response) {
                if (response == false) {
                    Swal.fire({
                        title:  warning+" !",
                        text: no_permission_for_this_module,
                        showDenyButton: false,
                        showCancelButton: false,
                        confirmButtonText: ok,
                    });
                } else {
                    $("#addSaleUnitModal").modal('show');
                }
            }
        });
        
    });
    // Add Unit By Ajax
    $(document).on('click', '#addSaleUnit', function () {
        $.ajax({
            url: base_url_ + "Master/checkAccess",
            method: "GET",
            async: false,
            dataType: 'json',
            data: { controller: "65", function: "add" },
            success: function (response) {
                if (response == false) {
                    Swal.fire({
                        title:  warning+" !",
                        text: no_permission_for_this_module,
                        showDenyButton: false,
                        showCancelButton: false,
                        confirmButtonText: ok,
                    });
                } else {
                    let unit_name = $("#unit_name_sale").val();
                    let error = 0;
                    if (unit_name == '') {
                        error = 1;
                        let cl1 = ".sale_unit_name_err_msg";
                        let cl2 = ".sale_unit_name_err_msg_contnr";
                        $(cl1).text(The_Unit_Name_field_is_required);
                        $(cl2).show(200).delay(6000).hide(200, function () {});
                    } else {
                        $("#unit_name").css('border', '1px solid #ccc');
                    }
                    if (error == 0) {
                        let get_unit_type = $('#set_unit_type').val();
                        let data = $("form#add_sale_unit_form").serialize();
                        $.ajax({
                            type: 'get',
                            url: base_url_+'Ajax/addUnitByAjax',
                            datatype: 'json',
                            data: data,
                            success: function (data) {
                                if (data) {
                                    let json = $.parseJSON(data);
                                    let html = '<option>'+select+'</option>';
                                    $.each(json.units, function (i, v) {
                                        html += '<option value="' + v.id + '">' + v
                                            .unit_name + '</option>';
                                    });
                                    if(get_unit_type == 'Single Unit'){
                                        $("#unit_id").html(html);
                                        $("#unit_id").val(json.id).change();
                                    }else if(get_unit_type == 'Double Unit'){
                                        $("#sale_unit_id").html(html);
                                        $("#sale_unit_id").val(json.id).change();
                                    }
                                    $("#addSaleUnitModal").modal('hide');
                                }
                            }
                        });
                    }
                }
            }
        });
    });

    // Add Category
    $(document).on('hidden.bs.modal', '#addCategoryModal', function () {
        $("#name_cat").val('');
        $("#description_cat").val('');
    });

    // Add Purchase Unit
    $(document).on('hidden.bs.modal', '#addPurchaseUnitModal', function () {
        $("#unit_name_p").val('');
        $("#description_p").val('');
    });

    // Add Sale Unit
    $(document).on('hidden.bs.modal', '#addSaleUnitModal', function () {
        $("#unit_name_sale").val('');
        $("#description_s").val('');
    });
    $(document).on('change', '.unit_type', function(){
        let getUnit = $(this).val();
        if(getUnit == 1){
            $('#unit_id').val('').change();
        }else if (getUnit == 2) {
            $('#purchase_unit_id').val('').change();
            $('#sale_unit_id').val('').change();
            $('#conversion_rate').val('');
        }
    });
    // Unit Type Validation
    $(document).on('change', '#select_unit_type', function(e) {
        e.preventDefault();
        let getUnit = $(this).val();
        setUnitType(getUnit);
        profitMargin();
    });
    $(document).ready(function() {
        let getUnit = unit_type;
        setUnitType(getUnit);
    });
    function setUnitType(getUnit){
        if(getUnit == 1){
            $(".single_unit_hide_show").removeClass('d-none');
            $(".double_unit_hide_show").addClass('d-none');
        }else if (getUnit == 2) {
            $(".double_unit_hide_show").removeClass('d-none');
            $(".single_unit_hide_show").addClass('d-none');
        }
    }

    // Image Crop Plugin
    // Add Image Modal Trigger
    $(document).on('click', '.add_image_for_crop', function () {
        $("#AddItemImageModal").modal('show');
    });
    // Image Modal Trigger
    $(document).on('click', '.image_div_p', function(ev){
        $(".uploa-main-wrap #upload-demo-i").html('');
        $(".uploa-main-wrap #upload-demo-trash").html('');
        $("#image_url").val('');
        $(".upload_demo_single .cr-image").removeAttr("src");
    });
    // Image Show Trigger
    $(document).on('click', '.show_image_trigger', function () {
        $("#show_image").modal('show');
    });
    let uploadCrop = $('#upload-demo').croppie({
        enableExif: true,
        viewport: {
            width: 200,
            height: 115,
            type: 'square'
        },
        boundary: {
            width: 220,
            height: 135
        }
    });
    // Image On change trigger
    $(document).on('change', '#upload', function () {
        let reader = new FileReader();
        reader.onload = function (e) {
            uploadCrop.croppie('bind', {
                url: e.target.result
            }).then(function () {
            });
        }
        reader.readAsDataURL(this.files[0]);
    });
    // Upload Image
    $(document).on('click', '.upload-result', function (ev) {
        uploadCrop.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function (resp) {
            let selected_image = $("#upload").val();
            if (selected_image == '') {
                Swal.fire({
                    title: alert,
                    text: img_select_error_msg,
                    showDenyButton: false,
                    showCancelButton: false,
                    confirmButtonText: `OK`
                });
                return false;
            } else {
                $.ajax({
                    url: base_url_+"Ajax/saveItemImage",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        "image": resp
                    },
                    success: function (data) {
                        $("#AddItemImageModal").modal('hide');
                        $("#image_url").val(data.image_name);
                        $("#upload").val('');
                        let html = '<img src="' + resp + '"/>';
                        $("#upload-demo-i").html(html);
                        $("#upload-demo-trash").html(`<iconify-icon icon="solar:trash-bin-minimalistic-broken" width="18" class="image_div_p"></iconify-icon>`);
                    }
                });
            }
        });
    });
    // Show Guideline
    $(document).on('click', '.show_guide', function () {
        let guide = $(this).attr('data-guide');
        $(".show_guide_text").html(guide);
        $("#guideModal").modal('show');
    });




    function profitMargin(){
        let purchase_price = $('#purchase_price').val();
        let profit_margin = $('#profit_margin_val').val();
        let conversion_rate = $('#conversion_rate').val();
        let sale_price_main = $('#sale_price').val();
        sale_price_main = parseFloat(sale_price_main);
        if (isNaN(sale_price_main)) {
            sale_price_main = 0;
        }
        let select_unit_type = $('#select_unit_type').val();
        let sale_price = 0;
        if(profit_margin){
            if(select_unit_type == '1' && purchase_price){
                sale_price = parseFloat(purchase_price) * parseInt(profit_margin) / 100;
            }else if(select_unit_type == '2' && purchase_price && conversion_rate){
                let converted_price = (parseFloat(purchase_price) / parseFloat(conversion_rate));
                sale_price = (parseFloat(converted_price) * parseInt(profit_margin)) / 100;
            }
        }else{
            sale_price = sale_price_main;
        }
        $('#sale_price').val(parseFloat(sale_price).toFixed(op_precision));
    }
    if(add_edit_mode == 'add_mode'){
        profitMargin();
    }
    
    $(document).on('keydown', '#profit_margin_val', function(){
        profitMargin();
    });
    $(document).on('keydown', '#purchase_price', function(){
        profitMargin();
    });
    $(document).on('keydown', '#conversion_rate', function(){
        profitMargin();
    });


});