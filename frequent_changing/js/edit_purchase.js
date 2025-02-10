$(function () {
    "use strict";

    //Initialize Select2 Elements
    $('.select2').select2();

    let warning = $("#warning").val();
    let a_error = $("#a_error").val();
    let yes = $("#yes").val();
    let cancel = $("#cancel").val();
    let are_you_sure = $("#are_you_sure").val();
    let base_url_ = $("#base_url_").val();
    let currency = $("#currency_").val();
    let csrf_name_= $("#csrf_name_").val();
    let csrf_value_= $("#csrf_value_").val();

    let suffix =$("#suffix").val();
    let item_id_container = $("#item_id_container").val();

    $('#suffix_hidden_field').val(suffix);
    
    let tab_index = 4;

    function calculateAll(){
        let subtotal = 0;
        let i = 1;
        $(".rowCount").each(function () {
            let id = $(this).attr("data-id");
            let unit_price=$("#unit_price_"+id).val();
            let temp = "#sl_"+id;
            $(temp).html(i);
            i++;
            let quantity_amount = $("#quantity_amount_"+id).val();
            if($.trim(unit_price) == "" || $.isNumeric(unit_price) == false){
                unit_price=0;
            }
            if($.trim(quantity_amount) == "" || $.isNumeric(quantity_amount) == false){
                quantity_amount=0;
            }

            let quantity_amount_and_unit_price=parseFloat($.trim(unit_price))*parseFloat($.trim(quantity_amount));

            $("#total_"+id).val(quantity_amount_and_unit_price.toFixed(2));
            subtotal += parseFloat($.trim($("#total_" + id).val()));
        });


        if (isNaN(subtotal)) {
            subtotal = 0;
        }

        //foraddDiscount
        let disc = $("#discount").val();
        let totalDiscount = 0;
        if ($.trim(disc) == '' || $.trim(disc) == '%' || $.trim(disc) == '%%' || $.trim(disc) == '%%%'  || $.trim(disc) == '%%%%' ){
            totalDiscount = 0;
        }else{
            let Disc_fields = disc.split('%');
            let discAmount = Disc_fields[0];
            let discP = Disc_fields[1];

            if (discP == "") {
                totalDiscount = (subtotal * (parseFloat($.trim(discAmount)) / 100));
            } else {
                if (!disc) {
                    discAmount = 0;
                }
                totalDiscount = parseFloat(discAmount);
            }
        }



        $("#subtotal").val(subtotal);

        let other =  parseFloat($.trim($("#other").val()));

        if($.trim(other)==""|| $.isNumeric(other)==false){
            other=0;
        }

        let grand_total = parseFloat(subtotal)  + parseFloat(other) - parseFloat(totalDiscount);

        grand_total = grand_total.toFixed(2);

        $("#grand_total").val(grand_total);

        let paid = $("#paid").val();

        if($.trim(paid)==""|| $.isNumeric(paid)==false){
            paid=0;
        }
        
        if(Number(paid)==0){  
            $("#payment_method_id").val('');
            $("#payment_method_id").prop("disabled", true);          
        }else{            
            $("#payment_method_id").prop("disabled", false);
        }


        let due = parseFloat(grand_total) - parseFloat(paid);

        $("#due").val(due.toFixed(2));
    }

    function deleter(suffix, item_id){
        Swal.fire({
            title: warning + "!",
            text: are_you_sure,
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: 'Yes',
            denyButtonText: cancel
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $("#row_"+suffix).remove();
                $("#paid").val('');
                let item_id_container_new = [];
                for(let i = 0; i < item_id_container.length; i++){
                    if(item_id_container[i] != item_id){
                        item_id_container_new.push(item_id_container[i]);
                    }
                }
                item_id_container = item_id_container_new;
                calculateAll();
            }
        });


    } 

    function updateRowNo(){ 
        let numRows=$("#purchase_cart tbody tr").length;
        for(let r=0;r<numRows;r++){
            $("#purchase_cart tbody tr").eq(r).find("td:first p").text(r+1);
        }
    }

    $(document).on('change', '#item_id', function() {
        let item_details=$('#item_id').val();
        if (item_details != '') {

            let item_details_array = item_details.split('|');
            let index = item_id_container.indexOf(item_details_array[0]);
            $("#unit_price_modal").val(item_details_array[3]);
            $("#cartPreviewModal").modal('show');


        }
    });

    $(document).on('click', '#addToCart', function(e) {
        e.preventDefault();
        let unit_price = $("#unit_price_modal").val();
        let qty_modal = $("#qty_modal").val();
        let menu_note = $("#menu_note").val();
        appendCart(unit_price,qty_modal,menu_note);
    });

    function appendCart(unit_price,qty_modal,menu_note) {
        let item_details=$('#item_id').val();
        let item_details_array = item_details.split('|');

        suffix++;
        tab_index++;
        let cart_row = '<tr class="rowCount" data-id="' + suffix + '" id="row_' + suffix + '">'+
            '<td class="op_padding_left_10"><p id="sl_' + suffix + '">'+suffix+'</p></td>'+
            '<td><span class="op_padding_bottom_5">'+item_details_array[1]+'</span></td>'+
            '<input type="hidden" id="item_id_' + suffix + '" name="item_id[]" value="' + item_details_array[0] + '"/>'+
            '<input type="hidden" id="conversion_rate_id_' + suffix + '" name="conversion_rate[]" value="' + item_details_array[4] + '"/>'+
            '<td><input type="text" autocomplete="off" id="menu_note_' + suffix + '" name="menu_note[]" onfocus="this.select();" class="form-control aligning" placeholder="" value="'+ menu_note +'" ></td>'+
            '<td><input type="text" autocomplete="off" id="unit_price_' + suffix + '" name="unit_price[]" onfocus="this.select();" class="form-control integerchk aligning calculate_op" placeholder="Unit Price" value="'+ unit_price +'"/><span class="label_aligning">'+currency+'</span></td>'+
            '<td><input type="text" autocomplete="off" data-countID="'+suffix+'" id="quantity_amount_' + suffix + '" name="quantity_amount[]" onfocus="this.select();" class="form-control integerchk aligning countID calculate_op"  value="'+ qty_modal +'"  placeholder="Qty/Amount"><span class="label_aligning">' + item_details_array[2] + '</span></td>'+
            '<td><input type="text" autocomplete="off" id="total_' + suffix + '" name="total[]" class="form-control integerchk aligning" placeholder="Total" readonly /><span class="label_aligning">'+currency+'</span></td>'+
            '<td><a class="btn btn-danger btn-xs deleter_op" data-suffix="'+ suffix +'" data-item_id="'+ item_details_array[0] +'"><i class="fa fa-trash op_color_white"></i> </a></td>'+
            '</tr>';
        tab_index++;

        $('#purchase_cart tbody').prepend(cart_row);

        item_id_container.push(item_details_array[0]);
        $('#item_id').val('').change();
        calculateAll();
        $("#cartPreviewModal").modal('hide');
    }
    $(document).on('keyup', '.calculate_op', function() {
        calculateAll();
	});
    $(document).on('click', '.deleter_op', function() {
        let suffix = $(this).data('suffix');
        let item_id = $(this).data('item_id');
        deleter(suffix, item_id);
	});


    // Validate form
    $(document).on('submit', '#purchase_form', function() {
        let supplier_id = $("#supplier_id").val();
        let payment_method_id = $("#payment_method_id").val();
        let date = $("#date").val();
        let note = $("#note").val();
        let paid = $("#paid").val();
        let itemCount = $("#purchase_cart tbody tr").length;
        let error = false;


        if(supplier_id==""){ 
            $("#supplier_id_err_msg").text("<?php echo lang('supplier_field_required'); ?>");
            $(".supplier_id_err_msg_contnr").show(200);
            error = true;
        } 
        
        if(paid=="" || paid==0){ 
            
        }else{
            if(payment_method_id==""){
                $("#payment_method_id_err_msg").text("<?php echo lang('account_field_required'); ?>");
                $(".payment_method_id_err_msg_contnr").show(200);

                error = true;
            }
        }

        if(date==""){ 
            $("#date_err_msg").text("<?php echo lang('date_field_required'); ?>");
            $(".date_err_msg_contnr").show(200);
            error = true;
        }

        if(itemCount < 1){ 
            $("#item_id_err_msg").text("<?php echo lang('at_least_item'); ?>");
            $(".item_id_err_msg_contnr").show(200);
            error = true;
        }
        $(".countID").each(function () {
            let n = $(this).attr("data-countID");
            let quantity_amount = $.trim($("#quantity_amount_"+n).val());
            if(quantity_amount == '' || isNaN(quantity_amount)){
                $("#quantity_amount_"+n).css({"border-color":"red"}).show(200).delay(2000,function(){
                    $("#quantity_amount_"+n).css({"border-color":"#d2d6de"});
                });
                error = true;
            }
        });

        if(error == true){
            return false;
        } 
    });


});