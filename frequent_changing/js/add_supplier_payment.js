$(function () {
    "use strict";
    let base_url_ = $("#base_url_").val();
    let currency = $("#currency_").val();
    let csrf_name_= $("#csrf_name_").val();
    let csrf_value_= $("#csrf_value_").val();


    $('#supplier_id').change(function(){
        let supplier_id = $('#supplier_id').val();
        if(supplier_id != ''){
            $.ajax({
                type: "GET",
                url: base_url_+'SupplierPayment/getSupplierDue',
                data: {
                    supplier_id: supplier_id,
                    csrf_name_: csrf_value_
                },
                success: function(data){
                    $("#remaining_due").show();
                    if(data > 0) { 
                        $("#remaining_due").html(`Credit: ${Math.abs(data)}`);
                    }else if(data < 0){
                        $("#remaining_due").html(`Debit: ${Math.abs(data)}`);
                    }else if(data == 0){
                        $("#remaining_due").html( 0 + " ");
                    }
                }
            });
        }else{
            $("#remaining_due").hide();
            $("#remaining_due").text('');
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
        
        
        $(document).on('keyup', '#amount', function(e){ 
            let amount=$('#amount').val();
            if(Number(amount)==0){              
                $("#payment_method_id").prop("disabled", true);          
            }else{            
                $("#payment_method_id").prop("disabled", false);
            }
        }); 
});