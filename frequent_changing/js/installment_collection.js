$(function () {
    "use strict";
    let base_url_ = $("#base_url_").val();
    let csrf_name_= $("#csrf_name_").val();
    let csrf_value_= $("#csrf_value_").val();

    $(document).on('change','#customer_id',function(e){
        e.preventDefault();
        let customer_id = $(this).val();
        getInvoice(customer_id);
    });

    $(document).on('change','#installment_id',function(e){
        let installment_id = $(this).val();
        if(installment_id){
            $('.show_invoice').attr('href', base_url_+'Installment/installmentPrint/'+installment_id).show();
        }else{
            $('.show_invoice').hide();
        }
    });

    function  getInvoice(customer_id) {
        $.ajax({
            url: base_url_+'Ajax/getInvoiceInfo',
            method:"POST",
            async:false,
            dataType:'json',
            data:{
                csrf_name_: csrf_value_,customer_id:customer_id
            },
            success:function(response) {
                if(response){
                    $("#installment_id").html(response);
                }
            },
            error:function(){
                alert("error ddd");
            }
        });
    }
    
    let customer_id = $("#customer_id").val();
    let hide_ins_id = $("#hide_ins_id").val();
    getInvoice(customer_id);
    $("#installment_id").val(hide_ins_id).change();

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