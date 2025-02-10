$(function () {
    "use strict"

    let last_three_note = $('#last_three_note').val();
    let lat_costing = $('#lat_costing').val();
    let Costing_formula_calculation = $('#Costing_formula_calculation').val();
    let The_Costing_Method_field_required = $('#The_Costing_Method_field_required').val();
    let The_items_field_is_required = $("#The_items_field_is_required").val();
    let The_date_field_is_required = $("#The_date_field_is_required").val();

    $(document).on('change', '#calculation_formula', function(){
        callPurchaseFormula($(this).val());
    });

    function callPurchaseFormula(claculateFormula){
        $("#toolTipGuide").html('');
        if(claculateFormula == 'AVG'){
            $("#toolTipGuide").html(`<i data-tippy-content="${last_three_note}" class="fa-regular fa-circle-question tippyBtnCall font-16 theme-color"></i>`);
        }else if(claculateFormula == 'PP_Price'){
            $("#toolTipGuide").html(`<i data-tippy-content="${lat_costing}" class="fa-regular fa-circle-question tippyBtnCall font-16 theme-color"></i>`);
        }else{
            $("#toolTipGuide").html(`<i data-tippy-content="${Costing_formula_calculation}" class="fa-regular fa-circle-question tippyBtnCall font-16 theme-color"></i>`);
        }
        tippy('.tippyBtnCall', {
            theme: 'light',
            placement: 'bottom',
            animation: 'fade',
            allowHTML: true,
        });
    }
    callPurchaseFormula($('#calculation_formula').val());


    $(document).on('click', '.profitLossReport', function(){
        let calculation_formula = $('#calculation_formula').val();
        let error = false;
        if(calculation_formula == ''){
            error  = true;
            $('#calculation_formula_err_msg').text(The_Costing_Method_field_required);
            $('.calculation_formula_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
        }
        if(error == true){
            return false;
        }
    });


    $(document).on('click', '.productProfitReport', function(){
        let error = false;
        let item_id = $('#item_id').val();
        let calculation_formula = $('#calculation_formula').val();
        if(item_id == ''){
            error  = true;
            $('#item_id_err_msg').text(The_items_field_is_required);
            $('.item_id_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
        }
        if(calculation_formula == ''){
            error  = true;
            $('#calculation_formula_err_msg').text(The_Costing_Method_field_required);
            $('.calculation_formula_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
        }
        if(error == true){
            return false;
        }
    });
  
    
});