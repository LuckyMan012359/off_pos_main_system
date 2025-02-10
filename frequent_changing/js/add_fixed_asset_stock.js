$(function () {
    "use strict";
    let warning = $("#warning").val();
    let add_edit_mode = $("#add_mode").val();
    let yes = $("#yes").val();
    let cancel = $("#cancel").val();
    let are_you_sure = $("#are_you_sure").val();
    let Unit_Price_l= $("#Unit_Price_l").val();
    let total= $("#total").val();
    let Qty_Amount= $("#Qty_Amount").val();
    let date_field_required= $("#date_field_required").val();
    let at_least_item= $("#at_least_item").val();
    let op_precision = $("#op_precision").val();


    function calculateAll() {
        let subtotal = 0;
        let i = 1;
        $(".rowCount").each(function () {
            let id = $(this).attr("row-counter");
            let unit_price = $("#unit_price_" + id).val();
            let temp = "#sl_" + id;
            $(temp).html(i)
            i++;
            let quantity_amount = $("#quantity_amount_" + id).val();
            if ($.trim(unit_price) == "" || $.isNumeric(unit_price) == false) {
                unit_price = 0;
            }
            if ($.trim(quantity_amount) == "" || $.isNumeric(quantity_amount) == false) {
                quantity_amount = 0;
            }
            let quantity_amount_and_unit_price = parseFloat($.trim(unit_price)) * parseFloat($.trim(
                quantity_amount));
            $("#total_" + id).val(quantity_amount_and_unit_price.toFixed(op_precision));
            subtotal += parseFloat($.trim($("#total_" + id).val()));
        });

        $("#grand_total").val(Number(subtotal).toFixed(op_precision));
    }

    $(document).on('change', '#item_id', function() {
        let itemId = $(this).val();
        let itemName = $('option:selected', this).text();
        let currentId;
        let match;
        $('.rowCount').each(function(){
            currentId = $(this).attr('data-item-id');
            if(currentId == itemId){
                match = 'Match';
                return false;
            }
        });
        if(match === 'Match'){
            Swal.fire({
                title: warning + "!",
                text: 'Item is already exist in cart, Update Quantity',
                showDenyButton: false,
                showCancelButton: false,
                confirmButtonText: 'OK',
            });
        }else{
            appendCart(itemId, itemName);
        }
    });

    let rowCounter;
    if(add_edit_mode == 'Add'){
        rowCounter = 0;
    }else{
        let eidtRowCount = $('#stock_cart tbody tr').length
        rowCounter = eidtRowCount;
    }
    function appendCart(itemId, itemName) {
        let cart_row = '';
        rowCounter++
        cart_row = `<tr class="rowCount" row-counter="${rowCounter}" data-item-id="${itemId}">
                <td>
                    <div class="d-flex align-items-center">
                        <p id="sl_${rowCounter}">${rowCounter}</p>
                    </div>
                    <input type="hidden" name="item_id[]" value="${itemId}"/>
                </td>
                <td>
                    <div class="d-flex align-items-center">
                        <span>${itemName}</span>
                    </div>
                </td>
                <td>
                    <div class="input-group">
                        <input type="text" autocomplete="off" data-countid="${rowCounter}" id="quantity_amount_${rowCounter}" name="quantity_amount[]" onfocus="this.select();" class="form-control integerchk1 countID calculate_op qty_count" value=""  placeholder="${Qty_Amount}" aria-describedby="basic-addon2">
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <div class="d-flex align-items-center">
                            <input type="text" autocomplete="off" data-countid="${rowCounter}" id="unit_price_${rowCounter}" name="unit_price[]" onfocus="this.select();" class="form-control integerchk1 calculate_op countID2" placeholder="${Unit_Price_l}" value=""/>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <div class="d-flex align-items-center">
                            <input type="text" autocomplete="off" id="total_${rowCounter}" name="total[]" class="form-control" placeholder="${total}" readonly />
                        </div>
                    </div>
                </td>
                <td class="text-center">
                    <button type="button" class="new-btn-danger deleter_op h-40" data-suffix="${rowCounter}" data-item_id="${itemId}">
                        <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="18"></iconify-icon>
                    </button>
                </td>
            </tr>`;
        $('#stock_cart tbody').prepend(cart_row);
        calculateAll();
    }

    $(document).on('keyup', '.calculate_op', function() {
        calculateAll();
	});

   
    $(document).on('click', '.deleter_op', function() {
        let himself = this;
        Swal.fire({
            title: warning + "!",
            text: are_you_sure,
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: yes,
            denyButtonText: cancel
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $(himself).parent().parent().remove();
                calculateAll();
            }
        });
	});


    // Validate form
    $(document).on('submit', '#fixed_asset_stock_form', function() {
        let date = $("#date").val();
        let itemCount = $("#stock_cart tbody tr").length;
        let error = false;
        if (date == "") {
            $("#date_err_msg").text(date_field_required);
            $(".date_err_msg_contnr").show(200);
            error = true;
        }
        if (itemCount < 1) {
            $("#item_id_err_msg").text(at_least_item);
            $(".item_id_err_msg_contnr").show(200);
            error = true;
        }

        $(".countID").each(function () {
            let n = $(this).attr("data-countid");
            let quantity = $.trim($("#quantity_amount_" + n).val());
            if (quantity == '') {
                $("#quantity_amount_" + n).css({
                    "border-color": "red"
                });
                error = true;
            }else{
                $("#quantity_amount_" + n).css({
                    "border-color": "#d8d6de"
                });
            }
        });
        $(".countID2").each(function () {
            let n = $(this).attr("data-countid");
            let quantity = $.trim($("#unit_price_" + n).val());
            if (quantity == '') {
                $("#unit_price_" + n).css({
                    "border-color": "red"
                });
                error = true;
            }else{
                $("#unit_price_" + n).css({
                    "border-color": "#d8d6de"
                });
            }
        });
        if (error == true) {
            return false;
        }
    });



    $(document).on('keydown', '.integerchk1', function (e) {
        let keys = e.which || e.keyCode;
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
            (keys >= 96 && keys <= 105)
        );
    });

    $(document).on('keyup', '.integerchk1', function (e) {
        let input = $(this).val();
        let ponto = input.split('.').length;
        let slash = input.split('-').length;
        if (ponto > 2)
            $(this).val(input.substr(0, (input.length) - 1));
        $(this).val(input.replace(/[^0-9]/, ''));
        if (slash > 2)
            $(this).val(input.substr(0, (input.length) - 1));
        if (ponto == 2)
            $(this).val(input.substr(0, (input.indexOf('.') + 4)));
        if (input == '.')
            $(this).val("");
    });


});