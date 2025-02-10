$(function () {
    "use strict";

    let warning = $("#warning").val();
    let a_error = $("#a_error").val();
    let yes = $("#yes").val();
    let cancel = $("#cancel").val();
    let are_you_sure = $("#are_you_sure").val();
    let base_url_ = $("#base_url_").val();
    let currency = $("#currency_").val();
    let csrf_name_= $("#csrf_name_").val();
    let csrf_value_= $("#csrf_value_").val();

    let item_id_container = $("#item_id_container").val();
    
    let suffix =$("#suffix").val();


    $(document).on('keydown', '.discount', function(e){
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

    $(document).on('keyup', '.discount', function(e){
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
    //Initialize Select2 Elements
    $('.select2').select2();

    function cal_disc(disc,sub_total) {
        let totalDiscount = 0;
        if ($.trim(disc) == '' || $.trim(disc) == '%' || $.trim(disc) == '%%' || $.trim(disc) == '%%%'  || $.trim(disc) == '%%%%'){
            totalDiscount = 0;
        }else{
            let Disc_fields = disc.split('%');
            let discAmount = Disc_fields[0];
            let discP = Disc_fields[1];
            if (discP == "") {
                totalDiscount = (sub_total * (parseFloat($.trim(discAmount)) / 100));
            } else {
                if (!disc) {
                    discAmount = 0;
                }
                totalDiscount = parseFloat(discAmount);
            }
            return totalDiscount;
        }
    }
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


        $("#subtotal").val(subtotal.toFixed(2));

        let other =  parseFloat($.trim($("#other").val()));

        let disc =$("#discount").val();

        let total_discount = cal_disc(disc,subtotal);
        if($.trim(other)==""|| $.isNumeric(other)==false){
            other=0;
        }
        if($.trim(disc)==""){
            total_discount=0;
        }

        let grand_total = parseFloat(subtotal)  + parseFloat(other) - total_discount;

        grand_total = grand_total.toFixed(2);

        $("#grand_total").val(grand_total);

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
        let numRows=$("#quotation_cart tbody tr").length;
        for(let r=0;r<numRows;r++){
            $("#quotation_cart tbody tr").eq(r).find("td:first p").text(r+1);
        }
    }

    $('#suffix_hidden_field').val(suffix);
      
    let tab_index = 4;

    $(document).on('change', '#item_id', function() {
        let item_details=$('#item_id').val();
        if (item_details != '') { 

            let item_details_array = item_details.split('|');
            let index = item_id_container.indexOf(item_details_array[0]);

            if (index > -1) {
                Swal.fire({
                    title: warning + "!",
                    text: "This Item already exist!",
                    showDenyButton: false,
                    showDenyButton: false,
                    showDenyButton: "OK"
                });
                $('#item_id').val('').change();
                return false;
            } 

            suffix++;
            tab_index++;

            let cart_row = '<tr class="rowCount" data-id="' + suffix + '" id="row_' + suffix + '">'+
                '<td class="op_padding_left_10"><p id="sl_' + suffix + '">'+suffix+'</p></td>'+
                '<td><span class="op_padding_bottom_5">'+item_details_array[1]+'</span></td>'+
                '<input type="hidden" id="item_id_' + suffix + '" name="item_id[]" value="' + item_details_array[0] + '"/>'+
                '<td><input type="text" autocomplete="off" id="unit_price_' + suffix + '" name="unit_price[]" onfocus="this.select();" class="form-control integerchk aligning calculate_op" placeholder="Unit Price" value="'+ item_details_array[3] +'" /><span class="label_aligning">'+currency+'</span></td>'+
                '<td><input type="text" autocomplete="off" data-countID="'+suffix+'" id="quantity_amount_' + suffix + '" name="quantity_amount[]" onfocus="this.select();" class="form-control integerchk aligning countID calculate_op"  placeholder="Qty/Amount"  ><span class="label_aligning">' + item_details_array[2] + '</span></td>'+
                '<td><input type="text" autocomplete="off" id="total_' + suffix + '" name="total[]" class="form-control aligning" placeholder="Total" readonly /><span class="label_aligning">'+currency+'</span></td>'+
                '<td><input type="text" autocomplete="off" id="" name="description[]" class="form-control" placeholder="description" /></td>'+
                '<td><a class="btn btn-danger btn-xs m-0 deleter_op" data-suffix="'+ suffix +'" data-item_id="'+ item_details_array[0] +'" ><i class="fa fa-trash op_color_white"></i> </a></td>'+
                '</tr>';
            tab_index++;
            $('#quotation_cart tbody').append(cart_row);

            item_id_container.push(item_details_array[0]);
            $('#item_id').val('').change();
            calculateAll();
        }
    });
    
    $(document).on('keyup', '.calculate_op', function() {
        calculateAll();
	});
    $(document).on('click', '.deleter_op', function() {
        let suffix = $(this).data('suffix');
        let item_id = $(this).data('item_id');
        deleter(suffix, item_id);
	});
    
        
    // Validate form
    $(document).on('submit', '#quotation_form', function() {
        let supplier_id = $("#supplier_id").val();
        let date = $("#date").val();
        let note = $("#note").val();
        let paid = $("#paid").val();
        let itemCount = $("#quotation_cart tbody tr").length;
        let error = false;


        if(supplier_id==""){ 
            $("#supplier_id_err_msg").text("<?php echo lang('supplier_field_required'); ?>");
            $(".supplier_id_err_msg_contnr").show(200);
            error = true;
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

        if(paid==""){ 
            $("#paid_err_msg").text("<?php echo lang('paid_field_required'); ?>");
            $(".paid_err_msg_contnr").show(200);
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