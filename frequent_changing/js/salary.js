$(function() {
    "use strict";

    let precision = $('#precision').val();
    let account_field_required = $('#account_field_required').val();

    //check all
    checkAll();
    //check all function
    function checkAll() {
        if ($(".checkbox_user").length == $(".checkbox_user:checked").length) {
            $(".checkbox_userAll").prop("checked", true);
        } else {
            $(".checkbox_userAll").prop("checked", false);
        }
    }
    // Check or Uncheck All checkboxes
    $(document).on('click', '.checkbox_userAll', function(e){
        let checked = $(this).is(':checked');
        if (checked) {
            $(".generated_salary").each(function () {
                $(this).val('2');
            });
            $(".checkbox_user").each(function () {
                let menu_id = $(this).attr('data-menu_id');
                $(this).prop("checked", true);
                $("#qty"+menu_id).val(1);
                $("#qty"+menu_id).prop("disabled", false);
            });
            $(".checkbox_userAll").prop("checked", true);
        } else {
            $(".generated_salary").each(function () {
                $(this).val('1');
            });
            $(".checkbox_user").each(function () {
                let menu_id = $(this).attr('data-menu_id');
                $(this).prop("checked", false);
                $("#qty"+menu_id).prop("disabled", true);
                $("#qty"+menu_id).val('');
            });
            $(".checkbox_userAll").prop("checked", false);
        }
    });



    $(document).on('change', '.checkbox_user', function () {
        if ($(this).is(':checked')) {
            $(this).parent().find('.generated_salary').val('2');
        } else {
            $(this).parent().find('.generated_salary').val('1');
        }
      });


    $(document).on('click', '.checkbox_user', function(e){
        let menu_id = $(this).attr('data-menu_id');
        if ($(".checkbox_user").length == $(".checkbox_user:checked").length) {
            $(".checkbox_userAll").prop("checked", true);
            if($(this).is(':checked')){
                $("#qty"+menu_id).val(1);
                $("#qty"+menu_id).prop("disabled", false);
            }else{
                $("#qty"+menu_id).prop("disabled", true);
                $("#qty"+menu_id).val('');
            }
        } else {
            $(".checkbox_userAll").prop("checked", false);
            if($(this).is(':checked')){
                $("#qty"+menu_id).val(1);
                $("#qty"+menu_id).prop("disabled", false);
            }else{
                $("#qty"+menu_id).prop("disabled", true);
                $("#qty"+menu_id).val('');
            }
        }
    });
    $(document).on('keyup', '.cal_row', function(e){
        //calculate row
        cal_row();
    });

    $(document).on('submit', '#add_salary', function() {
        let payment_id = $('#payment_method_id').val();
        let error = false;
        if(payment_id == ''){
            $("#payment_method_id_err_msg").text(account_field_required);
            $(".payment_method_id_err_msg_contnr").show(200);
            error == true;
            return false;
        }
    });

    //call calculate row
    cal_row();
    function cal_row() {
        let total = 0;
        let addition = 0;
        let subtraction_sum = 0;
        let total_salary = 0;
        $(".row_counter").each(function () {
            let id = $(this).attr("data-id");
            let salary = $("#salary_"+id).val();
            let additional = $("#additional_"+id).val();
            let subtraction = $("#subtraction_"+id).val();
            if($.trim(salary) == "" || $.isNumeric(salary) == false){
                salary=0;
            }
            if($.trim(additional) == "" || $.isNumeric(additional) == false){
                additional=0;
            }
            if($.trim(subtraction) == "" || $.isNumeric(subtraction) == false){
                subtraction=0;
            }
            let total_row = parseFloat($.trim(salary)) + parseFloat($.trim(additional)) - parseFloat($.trim(subtraction));
            let total_addition = parseFloat($.trim(additional));
            let total_subtraction = parseFloat($.trim(subtraction));
            total_salary += parseFloat(salary);
            total+=total_row;
            addition+=total_addition;
            subtraction_sum+=total_subtraction;
            $("#total_"+id).val(Number(total_row).toFixed(precision));
        });
        $(".total_salary").html(Number(total_salary).toFixed(precision));
        $(".total_amount").html(Number(total).toFixed(precision));
        $(".total_addition").html(Number(addition).toFixed(precision));
        $(".total_subtraction").html(Number(subtraction_sum).toFixed(precision));
    }

});
