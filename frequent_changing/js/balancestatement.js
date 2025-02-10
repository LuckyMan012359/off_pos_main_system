$(function () {
    "use strict";
    $(document).on('submit', '#balanceStatement', function () {
        let error = false;
        let account_name = $('#account_id').val();
        let startdate = $('#startdate').val();
        let enddate = $('#enddate').val();
        if (account_name == "") {
            $("#account_err_msg").text('The  Account name is required');
            $(".account_err_msg_contnr").show(200);
            error = true;
        }
        if (startdate == "") {
            $("#startdate_err_msg").text('The  start date is required');
            $(".startdate_err_msg_contnr").show(200);
            error = true;
        }
        if (enddate == "") {
            $("#enddate_err_msg").text('The  end date is required');
            $(".enddate_err_msg_contnr").show(200);
            error = true;
        }
        if(error == true){
            return false;
        }
    });
    

});