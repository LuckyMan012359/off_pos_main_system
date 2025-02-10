$(function () {
    "use strict";
    let The_customer_field_is_required = $('#The_customer_field_is_required').val();
    let The_supplier_field_is_required = $('#The_supplier_field_is_required').val();
    let The_date_field_is_required = $('#The_date_field_is_required').val();
    let The_outlet_field_is_required = $('#The_outle_field_is_required').val();
    let The_registerDetails_field_is_required = $('#The_registerDetails_field_is_required').val();
    let base_url = $('#base_url').val();

    // Register Report
    function registerReportByDate(){
        let selectDate = $('.registerStartDate').val();
        let user_id = $('#user_id').val();
        let outlet_id = $('#outlet_id').val();
        $.ajax({
            type: "POST",
            url: base_url+"Report/registerIndividualByDate",
            data: {
                selectDate: selectDate,
                user_id: user_id,
                outlet_id: outlet_id,
            },
            dataType: "json",
            success: function (response) {
                let htmlContent = '';
                htmlContent += `<option value="">Select Register</option>`
                if(response.status == 'success'){
                    $.each(response.data, function (i, v) { 
                        htmlContent += `<option value="${v.id}">${v.opening_balance_date_time}  ${v.closing_balance_date_time ? ' - ' + v.closing_balance_date_time : ''}</option>`
                    });
                }
                $('#registerDetails').html('');
                $('#registerDetails').html(htmlContent);
            }
        });
    }


    
    $(document).on('change', '.registerStartDate', function(){
        registerReportByDate();
    });
    $(document).on('change', '#user_id', function(){
        registerReportByDate();
    });
    $(document).on('change', '#outlet_id', function(){
        registerReportByDate();
    });
    registerReportByDate();

    $(document).on('submit', '#registerReport', function(){
        let error = false;
        let start_date = $('#startDate').val();
        if (start_date == '') {
            error = true;
            $('#startDate_err_msg').text(The_date_field_is_required);
            $('.startDate_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
        }
        let outlet_id = $('#outlet_id').val();
        if (outlet_id == '') {
            error = true;
            $('#outlet_id_err_msg').text(The_outlet_field_is_required);
            $('.outlet_id_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
        }
        let registerDetails = $('#registerDetails').val();
        if (registerDetails == '') {
            error = true;
            $('#registerDetails_err_msg').text(The_registerDetails_field_is_required);
            $('.registerDetails_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
        }
        if(error == true){
            return false;
        }
    });


    $("#customerReport").submit(function () {
        let error = false;
        let customer_id = $("#customer_id").val();
        if (customer_id == "") {
            $("#customer_id_err_msg").text(The_customer_field_is_required);
            $(".customer_id_err_msg_contnr").show(200);
            error = true;
        }
        if (error == true) {
            return false;
        }
    });

    $("#supplierReport").submit(function () {
        let error = false;
        let supplier_id = $("#supplier_id").val();
        if (supplier_id == "") {
            $("#supplier_id_err_msg").text(The_supplier_field_is_required);
            $(".supplier_id_err_msg_contnr").show(200);
            error = true;
        }
        if (error == true) {
            return false;
        }
    });




});