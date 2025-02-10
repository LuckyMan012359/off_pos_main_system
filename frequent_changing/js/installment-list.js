$(function () {
    "use strict";
    let base_url_ = $("#base_url_").val();

    $(document).on('click', '.show_preview', function () { 
        let get_file = $(this).attr('get-file');
        let get_title = $(this).attr('get-title');
        $("#myModalLabel").text('');
        $("#myModalLabel").text(get_title);
        $("#show_id_installment").attr("src", "");
        $("#show_id_installment").attr("src", base_url_+'uploads/customers/'+get_file);
        $("#exampleModal").modal('show');
    });

});