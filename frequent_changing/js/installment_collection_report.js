$(function () {
    "use strict";
    let base_url_ = $("#base_url_").val();
    $(document).on('change','#customer_id',function(e){
        e.preventDefault();
        let customer_id = $(this).val();
        getInvoice(customer_id);

    });
    function  getInvoice(customer_id) {
        $.ajax({
            url: base_url_+'Ajax/getInvoiceInfo',
            method:"POST",
            async:false,
            dataType:'json',
            data:{
                customer_id:customer_id
            },
            success:function(response) {
                if(response){
                    $("#installment_id").html(response);
                }
            },
            error:function(){
                alert("error ddd");
            }
        });
    }
    let customer_id = $("#customer_id").val();
    let hide_ins_id = $("#hide_ins_id").val();
    getInvoice(customer_id);
    $("#installment_id").val(hide_ins_id).change();
});