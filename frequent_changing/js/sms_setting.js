$(function () {
    "use strict";


    $(document).on('change', '#enable_status', function() {
        checkRequried();
    });
    checkRequried();
    function  checkRequried() {
        let this_value = $("#enable_status").val();
        if(Number(this_value)==1){
            $(".required_star").show();
        }else{
            $(".required_star").hide();
        }
    }

});