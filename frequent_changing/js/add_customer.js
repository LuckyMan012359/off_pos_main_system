$(function () {
    "use strict";

    let base_url = $('#base_url').val();
    let select = $('#select').val();
    let warning = $('#warning').val();
    let no_permission_for_this_module = $('#no_permission_for_this_module').val();
    let the_name_field_is_required = $('#the_name_field_is_required').val();
    
    $(document).on('keydown', '.integerchkPercent', function(e){
        let keys = e.charCode || e.keyCode || 0;
        // allow backspace, tab, delete, enter, arrows, numbers and keypad numbers ONLY
        // home, end, period, and numpad decimal
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

    $(document).on('keyup', '.integerchkPercent', function(e){
        let input = $(this).val();
        let ponto = input.split('.').length;
        let slash = input.split('-').length;
        if (ponto > 2)
            $(this).val(input.substr(0,(input.length)-1));
        $(this).val(input.replace(/[^0-9.%]/,''));
        if(slash > 2)
            $(this).val(input.substr(0,(input.length)-1));
        if (ponto ==2)
            $(this).val(input.substr(0,(input.indexOf('.')+4)));
        if(input == '.')
            $(this).val("");

    });


    $(document).on('click', '.add_group_by_ajax', function(){
        $.ajax({
            url: base_url+"Master/checkAccess",
            method: "GET",
            async: false,
            dataType: 'json',
            data: { controller: "154", function: "add" },
            success: function (response) {
                if (response == false) {
                    Swal.fire({
                        title: warning +" !",
                        text: no_permission_for_this_module,
                        showDenyButton: false,
                        showCancelButton: false,
                        confirmButtonText: 'OK',
                    });
                } else {
                    $('#addCustomerGroupModal').modal('show');
                }
            }
        });
    });


    $(document).on('click', '#addGroup', function(){
        $.ajax({
            url: base_url+"Master/checkAccess",
            method: "GET",
            async: false,
            dataType: 'json',
            data: { controller: "154", function: "add" },
            success: function (response) {
                if (response == false) {
                    Swal.fire({
                        title: warning +" !",
                        text: no_permission_for_this_module,
                        showDenyButton: false,
                        showCancelButton: false,
                        confirmButtonText: 'OK',
                    });
                } else {
                    let name = $('#group_name').val();
                    let description = $('#description_group').val();
                    let error = false;
                    if (name == '') {
                        error = true;
                        $('.group_name_err_msg').text(the_name_field_is_required);
                        $('.group_name_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
                    } 
                    if (error == false) {
                        $.ajax({
                            type: "POST",
                            url: base_url+"Ajax/addGroupByAjax",
                            data: {
                                name: name,
                                description: description,
                            },
                            success: function (response) {
                                if (response) {
                                    let json = $.parseJSON(response);
                                    let html = '<option>'+select+'</option>';
                                    $.each(json.groups, function (i, v) {
                                        html += '<option value="' + v.id + '">' + v.group_name +
                                            '</option>';
                                    });
                                    $("#group_id").html(html);
                                    $("#group_id").val(json.id).change();
                                    $("#addCustomerGroupModal").modal('hide');
                                    $('#group_name').val('');
                                    $('#description_group').val('');
                                }
                            }
                        });
                    }
                }
            }
        });
    })



    


});