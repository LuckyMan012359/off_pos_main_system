$(function () {
    "use strict";
    let check_issue_date = $("#check_issue_date").val();
    let check_no = $("#check_no").val();
    let check_expiry_date = $("#check_expiry_date").val();
    let mobile_no = $("#mobile_no").val();
    let transaction_no = $("#transaction_no").val();
    let card_holder_name = $("#card_holder_name").val();
    let card_holding_number = $("#card_holding_number").val();
    let op_precision = $("#op_precision").val();
    let paypal_email = $("#paypal_email").val();
    let stripe_email = $("#stripe_email").val();
    let note = $("#note").val();
    let base_url_ = $("#base_url_").val();
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
    
    $(document).on('keyup', '#amount', function(e){ 
        let amount=$('#amount').val();
        if(Number(amount)==0){              
            $("#payment_method_id").prop("disabled", true);          
        }else{            
            $("#payment_method_id").prop("disabled", false);
        }
    }); 

    $(document).on('change','#customer_id' , function(e){
        let customer_id = $('#customer_id').val();
        let csrf_name_= $("#csrf_name_").val();
        let csrf_value_= $("#csrf_value_").val();
        let current_due = $("#current_due").val();
        $.ajax({
            type: "GET",
            url: base_url_+'Customer_due_receive/getCustomerDue',
            data: {
                customer_id: customer_id,
                csrf_name_: csrf_value_
            },
            success: function(data) {
                $("#remaining_due").show();
                if(data < 0) { 
                    $("#remaining_due").html(`Credit: ${Math.abs(data).toFixed(op_precision)}`);
                }else if(data > 0){
                    $("#remaining_due").html(`Debit: ${Math.abs(data).toFixed(op_precision)}`);
                }else if(data == 0){
                    $("#remaining_due").html( 0 + " ");
                }
            }
        });
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
});