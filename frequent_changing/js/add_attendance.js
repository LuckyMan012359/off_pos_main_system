$(function () {
    "use strict";
    $('#in_time').timepicker({
        timeFormat: 'HH:mm:ss',
        interval: 15,  
        dynamic: false,
        dropdown: true,
        scrollbar: true
    });
    $('#out_time').timepicker({
        timeFormat: 'HH:mm:ss',
        interval: 15,
        dynamic: false,
        dropdown: true,
        scrollbar: true
    }); 
});