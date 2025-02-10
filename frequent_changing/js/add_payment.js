$(function () {
    "use strict";
    $(document).on('change', '#company', function(){
        let plan_cost = $('option:selected', this).attr('data-cost');
        let data_trial_status = $('option:selected', this).attr('data-trial-status');
        if(data_trial_status == 'Free'){
            Swal.fire({
                title: "Alert !",
                text: 'This Company under free trial.',
                confirmButtonColor: "#8b5cf6",
                confirmButtonText: 'OK',
                showCancelButton: false,
            });
            $('#payment_price').val(parseFloat(0));
        }else{
            $('#payment_price').val(parseFloat(plan_cost));
        }
    });
});