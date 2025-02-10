$(function () {
    "use strict";
    let encrypted_id = $("#encrypted_id").val();
    let in_Default = (encrypted_id == 0)? "'now'": "''";
    let out_Default = (encrypted_id != 0)? "'now'": "''";

    $(function () {
        $('#in_time').timepicker({
            timeFormat: 'HH:mm:ss',
            interval: 15,  
            defaultTime: in_Default,
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });
        $('#out_time').timepicker({
            timeFormat: 'HH:mm:ss',
            interval: 15,  
            defaultTime: out_Default,
            dynamic: false,
            dropdown: true,
            scrollbar: true
        }); 

    })

});