$(function () {
    "use strict";

    $(".parent_class").each(function(){
        let this_parent_name=$(this).attr('data-name');
        if($(".child_"+this_parent_name).length == $(".child_"+this_parent_name+":checked").length) {
            $(".parent_class_"+this_parent_name).prop("checked", true);
        } else {
            $(".parent_class_"+this_parent_name).prop("checked", false);
        }
    });
    $(document).on('click', '.child_class', function() {
        let this_parent_name = $(this).attr('data-parent_name');
        if($(".child_"+this_parent_name).length == $(".child_"+this_parent_name+":checked").length) {
            $(".parent_class_"+this_parent_name).prop("checked", true);
        } else {
            $(".parent_class_"+this_parent_name).prop("checked", false);
        }
    });

    $(document).on('click', '.parent_class', function() {
        let this_name=$(this).attr('data-name');

        let checked = $(this).is(':checked');
        if(checked){
            $(".child_"+this_name).each(function(){
                $(this).prop("checked",true);
            });
        }else{
            $(".child_"+this_name).each(function(){
                $(this).prop("checked",false);
            });
        }
    });

    if($(".checkbox_user").length == $(".checkbox_user:checked").length) {
        $("#checkbox_userAll").prop("checked", true);
    } else {
        $("#checkbox_userAll").removeAttr("checked");
    }
    // Check or Uncheck All checkboxes
    $(document).on('change', '#checkbox_userAll', function() {
        let checked = $(this).is(':checked');
        if(checked){
            $(".checkbox_user").each(function(){
                $(this).prop("checked",true);
            });
            $(".checkbox_user_p").prop("checked", true);
        }else{
            $(".checkbox_user").each(function(){
                $(this).prop("checked",false);
            });
            $(".checkbox_user_p").prop("checked", false);
        }
    });
    $(document).on('click', '.checkbox_user', function() {
        if($(".checkbox_user").length == $(".checkbox_user:checked").length) {
            $("#checkbox_userAll").prop("checked", true);

        } else {
            $("#checkbox_userAll").prop("checked", false);
        }
    });
    $(document).on('submit', '#add_role', function() {
        let temp = 0 ;
        let role_name = $("#role_name").val();
        let error = false;
        if(role_name==''){
            Swal.fire({
                title: "Alert",
                text: "The Roll Name is required",
                showDenyButton: false,
                showCancelButton: false,
                confirmButtonText: `OK`
            });
            $(".error_alert_role_name").html("required_roll_name");
            error = true;
        }else {
            $(".error_alert_role_name").html("");
        }
        $(".child_class").each(function(){
            let checked = $(this).is(':checked');
            if(checked){
                temp++;
            }
        });
        if(temp==0){
            Swal.fire({
                title: "Alert",
                text: "At least one check access",
                showDenyButton: false,
                showCancelButton: false,
                confirmButtonText: `OK`
            });
            $(".error_alert_atleast").html("at_least_one_check_access");
            return false;
        }else {
            $(".error_alert_atleast").html("");
        }
        if(error == true){
            return false;
        }
    });
    

});