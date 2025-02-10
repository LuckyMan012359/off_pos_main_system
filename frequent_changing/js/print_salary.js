$(function () {
    let title = $(".filter-modal-title").html();
    let The_Month_field_required = $("#The_Month_field_required").val();
    let The_Year_field_required = $("#The_Year_field_required").val();
    //set add salary button text
    setTimeout(() => {
        $(".dataFilterBy").html(`<iconify-icon icon="solar:add-circle-broken" width="22"></iconify-icon> ${title}`);
    }, 700);
    $(document).on('click', '.printNow', function(e){
        "use strict";
        e.preventDefault();
        //print salary
        let id = $(this).attr('data-id');
        let newWindow = open("printSalary/"+id, 'Print Salary', 'width=1600,height=550');
        newWindow.focus();
        newWindow.onload = function() {
            newWindow.document.body.insertAdjacentHTML('afterbegin');
        };
    });


    $(document).on('click', '.salary_gen_form', function () {
        let error = false;
        let month = $('.s_month').val();
        let year = $('.s_year').val();
        if (month == '') {
            error = true;
            $('.month_err_msg').text(The_Month_field_required);
            $('.month_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
        } 
        if (year == '') {
            error = true;
            $('.year_err_msg').text(The_Year_field_required);
            $('.year_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
        } 
        if(error == true){
            return false;
        }
    });
});