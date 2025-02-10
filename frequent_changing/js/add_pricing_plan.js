$(function () {
    "use strict";
    


    $(document).on('change', '#free_trial_status', function(){
        fieldHideShowByTrialStatus();
    });
    $(document).on('change', '#payment_type', function(){
        fieldHideShowByTrialStatus();
    });
    $(document).on('change', '#price_interval', function(){
        fieldHideShowByTrialStatus();
    });


    function fieldHideShowByTrialStatus(){
        let free_trial_status = $('#free_trial_status').val();
        let payment_type = $('#payment_type').val();
        let price_interval = $('#price_interval').val();
        if(free_trial_status == 'Free'){
            $('.field_no_1').hide();
            $('.field_no_2').hide();
            $('.field_no_3').hide();
            $('.field_no_4').hide();
            $('.field_no_5').hide();

            $('.field_no_7').show();
            $('.field_no_8').show();
            $('.field_no_9').show();
            $('.field_no_10').show();
            $('.field_no_11').show();
        }else if(free_trial_status == 'Paid'){
            if(payment_type == 'Recurring'){
                $('.field_no_2').show();
                $('.field_no_3').show();
            }else{
                $('.field_no_2').hide();
                $('.field_no_3').hide();
            }
            if(price_interval == 'Monthly' || price_interval == 'Yearly'){
                $('.field_no_10').hide();
            }else{
                $('.field_no_10').show();
            }
            $('.field_no_1').show();
            $('.field_no_4').show();
            $('.field_no_5').show();
            $('.field_no_7').show();
            $('.field_no_8').show();
            $('.field_no_9').show();
            $('.field_no_11').show();
        }
    }

    fieldHideShowByTrialStatus();
});