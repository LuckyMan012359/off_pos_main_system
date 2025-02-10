$(function () {
    "use strict";
    let base_url_ = $("#base_url_").val();
    let warning = $("#warning").val();
    let a_error = $("#a_error").val();
    let yes = $("#yes").val();
    let cancel = $("#cancel").val();
    let are_you_sure = $("#are_you_sure").val();
    let currency_ = $("#currency_").val();
    let customer_id = $('#customer_id').val();
    let csrf_name_= $("#csrf_name_").val();
    let csrf_value_= $("#csrf_value_").val();
    let current_due = $("#current_due").val();

    let tab_index = 4;

    // Validate form
    $(document).on('submit', '#deposit_form', function(){    
        let date = $("#date").val();
        let note = $("#note").val();
        let amount = $("#amount").val();
        let type = $("#type").val();
        
        let error = false;
            
    });

    $(document).on('hidden.bs.modal', '#supplierModal', function(){
        $(this).find('form').trigger('reset');
    });
    $(document).on('hidden.bs.modal', '#cartPreviewModal', function(){
        $("#menu_note").val('');
    });
    $(document).on('click', '#pull_low_stock_products', function(){
        let populate_click = $("#populate_click").val();
        let supplier_id = $("#supplier_id").val();

        $.ajax({
            url: base_url_+'Purchase/getStockAlertListForPurchase',
            method:"POST",
            data:{
                csrf_name_: csrf_value_,supplier_id:supplier_id
            },
            success:function(response) { 
                console.log(response);
                $("#purchase_cart tbody").empty();
                $("#purchase_cart tbody").append(response)
                $("#populate_click").val('clicked');

            },
            error:function(){
                alert("error");
            }
        });
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


});