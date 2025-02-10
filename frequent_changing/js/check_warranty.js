$(function () {
    "use strict";
    let base_url = $('#base_url_').val();
    $(document).on('change', '#customer_id', function(){
        let customer_id = $(this).val();
        $.ajax({
            type: "POST",
            url: base_url+"Warranty/getInvoiceByCustomerId",
            data: {
                customer_id: customer_id,
            },
            success: function (response) {
                if(response){
                    $('#sele_invoice').html(response);
                }
            }
        });
    });
    $(document).on('change', '#sele_invoice', function(){
        let sale_id = $(this).val();
        if(sale_id){
            open(base_url+"Warranty/print_invoice/" + sale_id, 'Print Invoice', 'width=1600,height=550');
        }
    });
});
