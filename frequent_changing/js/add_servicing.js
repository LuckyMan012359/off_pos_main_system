$(function () {
    "use strict";
    
    $(document).on('keyup', '#servicing_charge', function(e) {
        dueCalculate();
    });
    $(document).on('keyup', '#paid_amount_service', function(e) {
        dueCalculate();
    });

    function dueCalculate(){
        let serv_temp = 0;
        let paid_temp = 0;
        let servicing_charge = $("#servicing_charge").val();
        let paid_amount = $(".paid_amount").val();
        if(servicing_charge){
            serv_temp = Number(servicing_charge);
        }
        if(paid_amount){
            paid_temp = Number(paid_amount);
        }
        $('#due_amount').val(Number(serv_temp) - Number(paid_temp));
    }
});