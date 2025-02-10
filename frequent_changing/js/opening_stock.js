$(function () {
    "use strict";
    let base_url = $('#base_url').val();
    $(document).on('focus', '.check_item_type', function(){
        let currentItem = $(this).attr('data-current-item');
        $('.current_item').val('');
        $('.current_item').val(currentItem);
        let itemType = $(this).attr('data-information');
        let intemInfo = itemType.split('||');
        $('.product_info').val('');
        $('.product_info').val(itemType);
        $('#hidden_input_item_type').val('');
        $('#hidden_input_item_type').val(intemInfo[2]);
        $('.item_header').text(intemInfo[1]);
        if(intemInfo[2] == 'Medicine_Product' || intemInfo[2] == 'IMEI_Product' || intemInfo[2] == 'Serial_Product'){
            $('#itemTypeModal').modal('show');
            if(intemInfo[2] == 'Medicine_Product'){
                $(".imei_p_f").addClass('d-none');
                $(".serial_p_f").addClass('d-none');
                $(".expiry_p_f").removeClass('d-none');
                $("#imei_append").html("");
                $("#serial_append").html("");
            }else if(intemInfo[2] == 'IMEI_Product'){
                $(".imei_p_f").removeClass('d-none');
                $(".expiry_p_f").addClass('d-none');
                $(".serial_p_f").addClass('d-none');
                $("#imei_append").html("");
                $("#imei_append").append(`
                    <input type="text" autocomplete="off" class="form-control imei_serial_data imei_serial_data_modal mb-2"
                    name="expiry_imei_serial[]"  placeholder="IMEI Number">
                `);
                $("#expiry_append").html("");
                $("#serial_append").html("");
            }else if(intemInfo[2] == 'Serial_Product'){
                $(".expiry_p_f").addClass('d-none');
                $(".imei_p_f").addClass('d-none');
                $(".serial_p_f").removeClass('d-none');
                $("#serial_append").append('');
                $("#serial_append").append(`
                    <input type="text" autocomplete="off" class="form-control imei_serial_data imei_serial_data_modal mb-2"
                    name="expiry_imei_serial[]" placeholder="Serial Number">
                `);
                $("#expiry_append").html("");
                $("#imei_append").html("");
            }
        }
    });


    $(document).on('keyup', '#quantity', function (e) {
        e.preventDefault();
        let qty = $(this).val();
        let type = $("#hidden_input_item_type").val();
        if(qty == 0){
            qty = 1;
            $(this).val(1);
        }
        if(type == 'IMEI_Product') {
            $("#imei_append").html("");
            for (let i = 0; i < qty; i++) {
                $("#imei_append").append(`
                    <input type="text" autocomplete="off" class="form-control imei_serial_data imei_serial_data_modal mb-2"
                    name="expiry_imei_serial[]" id="imei" placeholder="IMEI Number" onfocus="this.select();">
                `);
            }
        }else if(type == 'Serial_Product') {
            $("#serial_append").html("");
            for (let i = 0; i < qty; i++) {
                $("#serial_append").append(`
                    <input type="text" autocomplete="off" class="form-control imei_serial_data imei_serial_data_modal mb-2"
                    name="expiry_imei_serial[]" id="serial" placeholder="Serial Number" onfocus="this.select();">
                `);
            }
        }
    });



    $(document).on('click', '#addToCart', function(e) {
        e.preventDefault();
        let product_type = $("#hidden_input_item_type").val();
        let quantity = Number($("#quantity").val());
        let error = false;
        if(quantity == 0){
            error = true;
            $('#quantity').css("border-color","red");
        }else{
            $('#quantity').css("border-color","#d8d6de");
        }
        let product_type_val = "";
        if (product_type == 'Medicine_Product') {
            let get_exp_date = $(".expiry_date").val();
            if (get_exp_date == ''){
                $('.expiry_date').css("border-color","red");
                error = true;
            }
            product_type_val = get_exp_date;
        }else if(product_type == 'IMEI_Product' || product_type == 'Serial_Product') {
            let imei_serial_data = [];
            $('.imei_serial_data_modal').each(function(i, obj)  {
                let getVal = $(this).val();
                if (getVal == ''){  
                    $(this).css("border-color","red");
                    error = true;
                }else{
                    $(this).css("border-color","#d8d6de");
                }
                imei_serial_data.push(obj.value);
            });
            product_type_val = imei_serial_data.reverse();
        }
        if(error == false){
            appendCart(quantity, product_type_val, product_type);
            $('#quantity').val(1);
        }
    });




    function appendCart(quantity, product_type_val, product_type) {
        let productInfo = $('.product_info').val();
        let productDetails = productInfo.split('||');

        let currentItem = $('.current_item').val();
        $('.'+currentItem).parent().remove();

        let cart_row = '';
        if (product_type == 'IMEI_Product' || product_type == 'Serial_Product'){
            for(let k = 0; k < quantity; k++){
                cart_row = `<div class="form-group op_outlet_set">
                    <label class="txt_outlet_1">${productDetails[4]}</label>
                    <input type="hidden" name="item_id[]" value="${productDetails[0]}">
                    <input type="hidden" name="item_type[]" value="${productDetails[2]}">
                    <input type="text" name="item_description[]" calss="form-control" value="${product_type_val[k]}">
                    <input type="hidden" name="outlet_id[]" value="${productDetails[3]}">
                    <input type="hidden" name="stock_quantity[]" class="form-control" value="1">
                </div>`;
                $(`#item_append_${productDetails[0]}`).prepend(cart_row);
            }
        }
        $("#itemTypeModal").modal('hide');
    }



    let page = 1,
		pagelimit = 10,
		totalrecord = 0;

	fetchData();
	// handling the prev-btn
	$(".prev-btn").on("click", function(){
		if (page > 1) {
			page--;
			fetchData();
		}
		console.log("Prev Page: " + page);
	});

	// handling the next-btn
	$(".next-btn").on("click", function(){
		if (page * pagelimit < totalrecord) {
			page++;
			fetchData();
		}
		console.log("Next Page: " + page);
	});

	function fetchData() {
		$.ajax({
			url: base_url+"Ajax/getItemForSetOpeningStock",
			type: "GET",
			data: {
				page: page,
				pagelimit: pagelimit
			},
			success: function(response) {
                console.log(response);
				if (response.success) {
					let dataArr = response.success.data;
					totalrecord = response.success.totalrecord;
					let html = "";
					for (let i = 0; i < dataArr.length; i++) {
                        console.log(dataArr[i].id);
						html += "<div class='sample-user'>"+
							"<h3>ID: " + dataArr[i].id + "</h3>"+
							"<p>Name: " + dataArr[i].name + "</p>" +
							"<p>Type: " + dataArr[i].type + "</p>" +
						"</div>"+
						"<hr />";
					}
					$("#result").html(html);
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log(jqXHR);
				console.log(textStatus);
				console.log(errorThrown);
			}
		});
	}
});