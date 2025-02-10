$(function () {
    "use strict";
    let base_url = $("#base_url_").val();
    let item_type = $("#item_type").val();
    // General Product stock keeping in edit mode
    if(item_type == 'General_Product' || item_type == 'Installment_Product'){
        function generalProductStock(){
            let item_id;
            let outlet_id;
            let himself;
            $('.general_product_stock_check').each(function(){
                himself = $(this);
                item_id = $(this).attr('data-item');
                outlet_id = $(this).attr('data-outlet');
                $.ajax({
                    type: "POST",
                    url: base_url+"Item/stockQtyCheck",
                    async:   false,
                    data: {
                        item_id : item_id,
                        outlet_id : outlet_id,
                    },
                    success: function (response) {
                        if(response.status == 'success'){
                            if(response.data.stock_quantity){
                                $(himself).val(response.data.stock_quantity / response.data.conversion_rate);
                            }
                        }
                    }
                });
            });
        }
        generalProductStock();
    }

    // IMEI Serial Product stock keeping in edit mode
    if(item_type == 'IMEI_Product' || item_type == 'Serial_Product'){
        function  imeiSerialProductStock(){
            let item_id;
            let outlet_id;
            let items;
            let itemCountSum = 0;
            $('.imeiserial_product_stock_check').each(function(){
                item_id = $(this).attr('data-item');
                outlet_id = $(this).attr('data-outlet');
                $.ajax({
                    type: "POST",
                    url: base_url+"Item/imeiSerialStockCheck",
                    async:   false,
                    datatype: 'JSON',
                    data: {
                        item_id : item_id,
                        outlet_id : outlet_id,
                    },
                    success: function (response) {
                        if(response.status == 200){
                            itemCountSum = 0;
                            items = '';
                            $.each(response.data, function (key, val) {
                                itemCountSum += 1;
                                items +=`<div class="input-group mb-2">
                                            <input type="text" name="item_description[]" data-outlet="${outlet_id == val.outlet_id ? val.outlet_id : ''}" class="item_description form-control" placeholder="${val.item_type == 'IMEI_Product' ? 'Enter IMEI' : 'Enter Serial'} number" value="${val.item_description}" aria-describedby="basic-addon${key}">
                                            
                                            <div class="trash_trigger input-group-text new-btn-danger h-40" id="basic-addon${key}">
                                                <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="18"></iconify-icon>
                                            </div>
                                        </div>`;
                            });
                            $('.item_description_body_'+outlet_id).html(items);  
                            $('#outlet_'+outlet_id).val(Number(itemCountSum));
                        } 
                    }
                });
            });
        }
        imeiSerialProductStock();
    }


    // Expiry Product
    if(item_type == 'Medicine_Product'){
        function  expiryProductStock(){
            let item_id;
            let outlet_id;
            let items = '';
            let itemCountSum = 0;
            $('.Medicine_Product_stock_check').each(function(){
                item_id = $(this).attr('data-item');
                outlet_id = $(this).attr('data-outlet');
                $.ajax({
                    type: "POST",
                    url: base_url+"Item/imeiSerialStockCheck",
                    async:   false,
                    data: {
                        item_id : item_id,
                        outlet_id : outlet_id,
                    },
                    success: function (response) {
                        console.log(response)
                        if(response.status == 200){
                            itemCountSum = 0;
                            items = '';
                            $.each(response.data, function (key, val) { 
                                itemCountSum += Number(val.stock_quantity / val.conversion_rate);
                                items +=`<div class="input-group mb-2">
                                            <input type="text" class="form-control integerchk me-2 expiry_child_qty expiry-first-input" placeholder="Enter Quantity" value="${val.stock_quantity / val.conversion_rate}">
                                            <input type="text" class="form-control expiryProduct  customDatepicker expiry-second-input" placeholder="Enter Expiry Date" item-quantity="${val.stock_quantity / val.conversion_rate}" data-outlet="${val.outlet_id}" value="${val.item_description}" aria-describedby="basic-addon${key}">

                                            <div class="expiry_trash_trigger input-group-text cursor-pointer new-btn-danger h-40"  data-outlet="${val.outlet_id}" id="basic-addon${key}">
                                            <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="18"></iconify-icon>
                                            </div>
                                        </div>`
                            });
                            $('#outlet_'+outlet_id).val(Number(itemCountSum));
                            $('.item_description_body_'+outlet_id).html(items);  
                            $('.customDatepicker').datepicker({
                                format: 'yyyy-mm-dd',
                                autoclose: true
                            });
                        } 
                    }
                });
            });
        }
        expiryProductStock();
    }



    function variationOldDtaSet(){
        let serial;
        let data_item;
        $('.stock_view').each(function(){
            serial = $(this).attr("serial_e");
            data_item = $(this).attr("data-item");
            $.ajax({
                type: "POST",
                url: base_url+"Item/kepOldVariation",
                async:   false,
                data: {
                    data_item : data_item,
                },
                success: function (response) {
                    if(response.status == 200){
                        let items;

                        $.each(response.data, function (key, val) { 
                            items +=`<input type="hidden" name="outlets${serial}[]" value="${val.outlet_id}">
                                <input type="hidden" name="quantity${serial}[]" value="${val.stock_quantity / val.conversion_rate}">
                        `});
                        $('#op_stock_set_'+serial).prepend(items);
                    } 
                }
            });
        });
    }

    setTimeout(function(){
        variationOldDtaSet();
    }, 200)









});