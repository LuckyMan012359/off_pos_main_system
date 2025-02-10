$(function () {
    "use strict";
    let The_items_field_is_required = $('#The_items_field_is_required').val();
    let The_customer_field_is_required = $('#The_customer_field_is_required').val();
    let The_supplier_field_is_required = $('#The_supplier_field_is_required').val();
    let The_date_field_is_required = $('#The_date_field_is_required').val();
    let The_outlet_field_is_required = $('#The_outle_field_is_required').val();
    let The_Employee_field_is_required = $('#The_Employee_field_is_required').val();
    let The_Product_field_is_required = $('#The_Product_field_is_required').val();
    let base_url = $("#base_url_").val();


    $(document).on('click', '.dailySummaryReport', function(){
        let error = false;
        let outlet_id = $('#outlet_id').val();
        if (outlet_id == '') {
            error = true;
            $('#outlet_id_err_msg').text(The_outlet_field_is_required);
            $('.outlet_id_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
        }
        if(error == true){
            return false;
        }
    });


    $(document).on('change', '.dailySummaryDate', function(){
        let dailySummaryDate = $(this).val();
        let setUrl = `${base_url}Report/printDailySummaryReport/${dailySummaryDate}`;
        $('.printURLSet').attr('href', setUrl);
    });


    $(document).on('click', '.employeeSaleReport', function(){
        let error = false;
        let user_id = $('#user_id').val();
        if (user_id == '') {
            error = true;
            $('#user_id_err_msg').text(The_Employee_field_is_required);
            $('.user_id_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
        }
        if(error == true){
            return false;
        }
    });

    $(document).on('click', '.customerDueReceiveReport', function(){
        let error = false;
        let customer_id = $('#customer_id').val();
        if (customer_id == '') {
            error = true;
            $('#customer_id_err_msg').text(The_customer_field_is_required);
            $('.customer_id_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
        }
        if(error == true){
            return false;
        }
    });

   

    $(document).on('click', '.supplierLedgerReport', function(){
        let error = false;
        let supplier_id = $('#supplier_id').val();
        if (supplier_id == '') {
            error = true;
            $('#supplier_id_err_msg').text(The_supplier_field_is_required);
            $('.supplier_id_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
        }
        let startDate = $('#startDate').val();
        let endDate = $('#endDate').val();
        if(startDate != '' && endDate == ''){
            error = true;
            $('#endDate_err_msg').text(The_date_field_is_required);
            $('.endDate_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
        }else if(endDate != '' && startDate == ''){
            error = true;
            $('#startDate_err_msg').text(The_date_field_is_required);
            $('.startDate_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
        }
        if(error == true){
            return false;
        }
    });
    
    $(document).on('click', '.customerLedgerReport', function(){
        let error = false;
        let customer_id = $('#customer_id').val();
        if (customer_id == '') {
            error = true;
            $('#customer_id_err_msg').text(The_customer_field_is_required);
            $('.customer_id_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
        }

        let startDate = $('#startDate').val();
        let endDate = $('#endDate').val();
        if(startDate != '' && endDate == ''){
            error = true;
            $('#endDate_err_msg').text(The_date_field_is_required);
            $('.endDate_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
        }else if(endDate != '' && startDate == ''){
            error = true;
            $('#startDate_err_msg').text(The_date_field_is_required);
            $('.startDate_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
        }
        if(error == true){
            return false;
        }
    });



    $(document).on('click', '.servicingReport', function(){
        let error = false;
        let employee_id = $('#employee_id').val();
        if(employee_id == ''){
            error = true;
            $('#employee_id_err_msg').text(The_Employee_field_is_required);
            $('.employee_id_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
        }
        if(error == true){
            return false;
        }
    });



    $(document).on('click', '.productSaleReport', function(){
        let error = false;
        let items_id = $('#items_id').val();
        if(items_id == ''){
            error = true;
            $('#items_id_err_msg').text(The_Product_field_is_required);
            $('.items_id_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
        }
        if(error == true){
            return false;
        }
    });


    // $(document).on('click', '.installmentReport', function(){
    //     let error = false;
    //     let customer_id = $('#customer_id').val();
    //     if(customer_id == ''){
    //         error = true;
    //         $('#customer_id_err_msg').text(The_customer_field_is_required);
    //         $('.customer_id_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
    //     }
    //     if(error == true){
    //         return false;
    //     }
    // });

    $(document).on('click', '.installmentDueReport', function(){
        let error = false;
        let customer_id = $('#customer_id').val();
        if(customer_id == ''){
            error = true;
            $('#customer_id_err_msg').text(The_customer_field_is_required);
            $('.customer_id_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
        }
        if(error == true){
            return false;
        }
    });



    $(document).on('click', '.itemMoving', function(){
        let error = false;
        let item_id = $('#item_id').val();
        if(item_id == ''){
            error = true;
            $('#item_id_err_msg').text(The_items_field_is_required);
            $('.item_id_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
        }
        if(error == true){
            return false;
        }
    });


    $(document).on('click', '.priceHistory', function(){
        let error = false;
        let item_id = $('#item_id').val();
        if(item_id == ''){
            error = true;
            $('#item_id_err_msg').text(The_items_field_is_required);
            $('.item_id_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
        }
        if(error == true){
            return false;
        }
    });






























    $(document).on('submit', '#productPurchaseReport', function() {
        let items_id = $("#items_id").val();
        let menu_note = $("#menu_note").val();
        let error = false;
        if(menu_note==''){
            if(items_id==""){
                $("#items_id_err_msg").text(The_items_field_is_required);
                $(".items_id_err_msg_contnr").show(200);
                error = true;
            }
        }
        if(error == true){
            return false;
        }
    });






});