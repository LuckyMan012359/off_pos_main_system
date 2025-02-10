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
        if($(this).is(':checked')){
            $(this).parent().find('.hidden_all').val("NO");
        }else{
            $(this).parent().find('.hidden_all').val("YES");
        }
        if($(this).parent().parent().parent().find(".child_class").length == $(this).parent().parent().parent().find(".child_class:checked").length){
            $(this).parent().parent().parent().find('.parent_class').prop("checked", true);;
        }else{
            $(this).parent().parent().parent().find('.parent_class').prop("checked", false);
        }
    });

    $(document).on('click', '.parent_class', function() {
        let checked = $(this).is(':checked');
        if(checked){
            $(this).parent().parent().find('.child_class').prop("checked", true);
            $(this).parent().parent().find('.hidden_all').val("NO");
        }else{
            $(this).parent().parent().find('.child_class').prop("checked", false);
            $(this).parent().parent().find('.hidden_all').val("YES");
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
            $(".hidden_all").each(function(){
                $(this).val("NO");
            });
            $(".checkbox_user_p").prop("checked", true);
        }else{
            $(".hidden_all").each(function(){
                $(this).val("YES");
            });
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
    
    

});