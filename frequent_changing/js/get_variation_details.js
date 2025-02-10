$(function () {
    "use strict";
    let hidden_alert = $("#warning").val();
    let hidden_ok = $(".hidden_ok").val();
    let hidden_cancel = $(".hidden_cancel").val();
    let are_you_sure = $("#are_you_sure").val();
    let delete_confirmation = $("#delete_confirmation").val();
    let base_url = $("#base_url_").val();
    let img_select_error_msg = $("#img_select_error_msg").val();
    let get_csrf_token_name = $("#get_csrf_token_name").val();
    let get_csrf_hash = $("#get_csrf_hash").val();
    let guide_purchase_price = $("#guide_purchase_price").val();
    let guide_sale_price = $("#guide_sale_price").val();
    let guide_wholesale_price = $("#guide_wholesale_price").val();
    let add_edit_mode = $("#add_edit_mode").val();
    let The_Variation_Attribute_field_required = $("#The_Variation_Attribute_field_required").val();


    function set_data_attribute() {
        let i =0;
        $(".counter_variation_id").each(function () {
            $(this).attr('name',"variations[]");
            $(this).attr('id',"variation_"+i);
            $(this).attr('data-id',i);
            i++;
        });
        i =0;
        $(".add_row").each(function () {
            $(this).attr('data-id',i);
            i++;
        });
        i =0;
        $(".add_variation_div_child").each(function () {
            $(this).attr('data-id',i);
            $(this).attr('id',"add_variation_div_child_"+i);
            i++;
        });
        i =0;
        $(".child_row_counter").each(function () {
            let parent_id = $(this).parent().parent().parent().attr('data-id');
            $(this).attr('id',"variation_"+parent_id);
            $(this).attr('data-id',parent_id);
            i++;
        });
        i =0;
        $(".child_row_attribute").each(function () {
            $(this).attr('name',"child_row_attribute"+i+"[]");
            i++;
        });
        i =0;
        $(".show_details_view").each(function () {
            $(this).attr('data-id',i);
            i++;
        });
        i =0;
        $(".arrow_status").each(function () {
            $(this).attr('id',"arrow_status_"+i);
            i++;
        });
        i =0;
        $(".image_div").each(function () {
            $(this).attr('id',"image_div_"+i);
            $(this).attr('data-id',i);
            i++;
        });
        i =0;
        $(".add_image_for_crop_variation").each(function () {
            $(this).attr('data-id',i);
            $(this).attr('id',"add_image_for_crop_variation_"+i);
            i++;
        });
        i =0;
        $(".variation_product_images").each(function () {
            $(this).attr('data-id',i);
            $(this).attr('id',"variation_product_images_"+i);
            $(this).attr('name',"variation_product_images[]");
            i++;
        });
        i =0;
        $(".default_sale_price_variation").each(function () {
            $(this).attr('data-id',i);
            $(this).attr('id',"default_sale_price_variation_"+i);
            $(this).attr('name',"default_sale_price_variation[]");
            i++;
        });
        i =0;
        $(".default_purchase_price_variation").each(function () {
            $(this).attr('data-id',i);
            $(this).attr('id',"default_purchase_price_variation_"+i);
            $(this).attr('name',"default_purchase_price_variation[]");
            i++;
        });
        i =0;
        $(".default_whole_sale_price_variation").each(function () {
            $(this).attr('data-id',i);
            $(this).attr('id',"default_whole_sale_price_variation_"+i);
            $(this).attr('name',"default_whole_sale_price_variation[]");
            i++;
        });
        i =0;
        $(".opening_stock_variation").each(function () {
            $(this).attr('serial',i);
            $(this).attr('id',"opening_stock_variation_"+i);
            $(this).attr('name',"opening_stock_variation[]");
            i++;
        });
        i =0;
        $(".op_stock_set").each(function () {
            $(this).attr('data-id',i);
            $(this).attr('id',"op_stock_set_"+i);
            i++;
        });
        i =0;
        $(".code_variation").each(function () {
            $(this).attr('data-id',i);
            $(this).attr('id',"code_variation_"+i);
            $(this).attr('name',"code_variation[]");
            i++;
        });
        i =0;
        $(".alert_quantity_variation").each(function () {
            $(this).attr('data-id',i);
            $(this).attr('id',"alert_quantity_variation_"+i);
            $(this).attr('name',"alert_quantity_variation[]");
            i++;
        });
        i =0;
        $(".row_remove_variation").each(function () {
            $(this).attr('data-id',i);
            i++;
        });
        i =0;
        $(".show_details_view_sub_div1").each(function () {
            $(this).attr('id',"show_details_view_sub_div1"+i);
            i++;
        });
        i =0;
        $(".show_details_view_sub_div2").each(function () {
            $(this).attr('id',"show_details_view_sub_div2"+i);
            i++;
        });
        i =0;
        $(".show_details_view_sub_div3").each(function () {
            $(this).attr('id',"show_details_view_sub_div3"+i);
            i++;
        });
        i =0;
        $(".show_details_view_sub_div4").each(function () {
            $(this).attr('id',"show_details_view_sub_div4"+i);
            i++;
        });
        i =1;
        $(".counter_variation").each(function () {
            $(this).html(i);
            i++;
        });
    }

    function returnStringCustom(int_value) {
        return String("00" + int_value).slice(-2)
    }

    function set_variation_code(){
        let i =1;
        let parent_code = $("#code_").val();
        $(".code_variation").each(function () {
            let sub_code = returnStringCustom(i);
            $(this).val(parent_code+"-"+sub_code);
            i++;
        });
        $(".code_variation_header").each(function () {
            let sub_code = returnStringCustom(i);
            $(this).text(`(${parent_code} - ${sub_code})`);
            i++;
        });
    }
    set_data_attribute();
    set_variation_code();
    
    $(document).on('change', '.get_variation_details', function(e){
        let this_id = $(this).find(":selected").attr('data-id');
        let row_id = $(this).attr('data-id');
        let status = true;
        let this_attribute_already_selected = $(".this_attribute_already_selected").val();
        let selected_value = $(".child_row_counter"+row_id).attr('data-selected_value');
        $.ajax({
            url: base_url + 'Ajax/getVariationDetails',
            method: "POST",
            data: {
                variant_id: this_id,
                selected_value: selected_value,
                row_id: row_id
            },
            success: function(data) {
                $(".child_row_counter"+row_id).html(data);
                set_data_attribute();
            }
        });
    });

    $(document).on('change', '.counter_variation_id', function () { 
        let values = new Set();
        let duplicates = [];
        $('.counter_variation_id').each(function(){
            let attrValue = $(this).val();
            if (values.has(attrValue)) {
                duplicates.push(attrValue);
            } else {
                values.add(attrValue);
            }
        });
        if (duplicates.length > 0) {
            Swal.fire({
                title: 'Alert !',
                text: `This attribute already exist! change value.`,
                showDenyButton: false,
                showCancelButton: false,
                confirmButtonText: `OK`
            });
            $(this).parent().parent().remove();
        }
    });


    $(document).on('keyup', '#code_', function(e){
        set_variation_code();
    });

    $(document).on('click', '.add_row', function(e){
        e.preventDefault();
        let row_id = $(this).attr('data-id');
        $("#attribute_name_id").val(row_id);
        $("#add_variation_attribute_modal").modal('show');
        $("#attribute_name").focus();
        set_data_attribute();
    });

    $(document).on('click', '.add_new_attribute', function(e){
        e.preventDefault();
        let attribute_name = $('#attribute_name').val();
        let attribute_name_id = $("#attribute_name_id").val();
        if(attribute_name){
            $(".child_row_counter"+attribute_name_id).append('<option selected value="'+attribute_name+'">'+attribute_name+'</option>');
            $("#attribute_name").val('');
            $("#add_variation_attribute_modal").modal('hide');
        }else{
            $('.attr_error_msg').html(`<div class="callout callout-danger">${The_Variation_Attribute_field_required}</div>`)
        }
    });

    $(document).on('keydown', '#attribute_name', function (e) { 
        $('.attr_error_msg').html('');
    });

    $(document).on('click', '.show_details_view', function(e){
        e.preventDefault();
        let row_id  = Number($(this).attr('data-id'));
        let status = Number($("#arrow_status_"+row_id).attr('data-status'));
        if(status==1){
            $("#arrow_status_"+row_id).attr('data-status',2);
            $("#arrow_status_"+row_id).attr('icon','solar:arrow-down-broken');
            $("#arrow_status_"+row_id).attr('width','22');
            $("#show_details_view_sub_div1"+row_id).fadeIn(333);
            $("#show_details_view_sub_div2"+row_id).fadeIn(333);
            $("#show_details_view_sub_div3"+row_id).fadeIn(333);
            $("#show_details_view_sub_div4"+row_id).fadeIn(333);
        }else{
            $("#arrow_status_"+row_id).attr('data-status',1);
            $("#arrow_status_"+row_id).attr('icon', 'solar:arrow-up-broken');
            $("#show_details_view_sub_div1"+row_id).fadeOut(333);
            $("#show_details_view_sub_div2"+row_id).fadeOut(333);
            $("#show_details_view_sub_div3"+row_id).fadeOut(333);
            $("#show_details_view_sub_div4"+row_id).fadeOut(333);
        }
    });

    

    $(document).on('click', '.add_variation', function(e){
        e.preventDefault();
        let row_id = $(".bottom_border").length;
        let Used_for_variations = $(".Used_for_variations").val();
        let Visible_on_the_product_page = $(".Visible_on_the_product_page").val();
        let actions = $(".actions").val();
        let add_row = $(".add_row_text").val();
        let hidden_variation_data = $(".hidden_variation_data").html();

        let html = `<tr class="bottom_border bb_10_px_white">
                        <td>
                            <select class="form-control select2 counter_variation_id get_variation_details">
                                `+hidden_variation_data+`
                            </select>
                        </td>
                        <td>
                            <select class="w-100 form-control child_row_attribute check_required child_row_counter`+row_id+`">
                            </select>
                                <a href="javascript:void(0)" class="new-btn bg-blue-btn-p-14 mt-2 add_row margin_top_2 pull-right"><iconify-icon icon="solar:add-circle-broken" width="22"></iconify-icon></a>
                        </td>
                        <td class="c_center">
                            <a class="remove_row new-btn-danger" href="javascript:void(0)">
                                <iconify-icon icon="solar:trash-bin-minimalistic-broken" class="color-red" width="22"></iconify-icon>
                            </a>
                        </td>
                    </tr>`;
        $(".add_variation_div").append(html);
        set_data_attribute();

        //initial select2
        $('#variation_'+row_id).select2();
        $(".child_row_counter"+row_id).select2({
            multiple: true,
            placeholder: 'Select',
            allowClear: true
        });
        $(".child_row_counter"+row_id).val('placeholder').trigger("change");
    });

    setTimeout(function () {
        $(".child_row_attribute").each(function () {
            $(this).select2({
                multiple: true,
                placeholder: 'Select',
                allowClear: true
            });
            $(this).val('placeholder').trigger("change");
        });
    }, 2000);


    $(document).on('click', '.remove_row', function(e){
        e.preventDefault();
        let this_action = $(this);
        Swal.fire({
            title: "Warning !",
            text: "Are you sure? you want to delete this row!",
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: "Yes",
            denyButtonText: "Cancel"
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                this_action.parent().parent().remove();
                set_data_attribute();
            }
        });

        
    });


    $(document).on('click', '.add_image_for_crop_variation', function(e){
        let this_row = $(this).attr("data-id");
        $("#hidden_row_image_variation").val(this_row);
        $("#add_variation_image_modal").modal('show');
    });

    let uploadCropVariation = $('#upload-demo_variation').croppie({
        enableExif: true,
        viewport: {
            width: 200,
            height: 200,
            type: 'square'
        },
        boundary: {
            width: 250,
            height: 250
        }
    });

    $(document).on('change', '.variation_image', function(){
        let reader = new FileReader();
        reader.onload = function (e) {
            uploadCropVariation.croppie('bind', {
                url: e.target.result
            }).then(function(){

            });
        }
        reader.readAsDataURL(this.files[0]);
    });

    $(document).on('click', '.upload-result_variaton', function(ev){
        uploadCropVariation.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function (resp) {
            let selected_image =  $(".variation_image").val();
            if(selected_image==''){
                Swal.fire({
                    title: 'Alert !',
                    text: img_select_error_msg,
                    showDenyButton: false,
                    showCancelButton: false,
                    confirmButtonText: `OK`
                });
                return false;
            }else{
                $.ajax({
                    url: base_url+"Ajax/saveItemImage",
                    type: "POST",
                    dataType: 'json',
                    data: {"image":resp},
                    success: function (data) {
                        let hidden_row_image_variation = $("#hidden_row_image_variation").val();
                        $("#add_variation_image_modal").modal('hide');
                        $("#variation_product_images_"+hidden_row_image_variation).val(data.image_name);
                        $(".variation_image").val('');
                        $(".cr-image").attr('src','');
                        $("#add_image_for_crop_variation_"+hidden_row_image_variation).attr("src",base_url+"uploads/items/"+data.image_name);
                        $("#image_div_"+hidden_row_image_variation).show();
                    }
                });
            }

        });
    });

    $(document).on('click', '.image_div', function(ev){
        let row_id = $(this).attr('data-id');
        $("#add_image_for_crop_variation_"+row_id).attr("src",base_url+"uploads/site_settings/image_thumb.png");
        $("#variation_product_images_"+row_id).val('');
        $(this).hide();
    });

    $(document).on('click', '.row_remove_variation', function(ev){
        let row_id = $(this).attr('data-id');
        let this_action = $(this);
        Swal.fire({
            title: "Alert !",
            text: delete_confirmation,
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: "Yes",
            denyButtonText: "Cancel"
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                this_action.parent().parent().parent().parent().remove();
                $("#show_details_view_sub_div1"+row_id).remove();
                $("#show_details_view_sub_div2"+row_id).remove();
                $("#show_details_view_sub_div3"+row_id).remove();
                $("#show_details_view_sub_div4"+row_id).remove();
                set_variation_code();
                set_data_attribute();
            }
        });
    });

    $(document).on('click', '.generate_variation', function(e){
        $('#variation_edit_object').val('');
        e.preventDefault();
        let arr1 = [];
        let arr2 = [];
        let arr3 = [];
        let arr4 = [];
        let arr5 = [];
        let j = 1;
        $(".get_variation_details").each(function () {
            let row_id = $(this).attr('data-id');
            let attribute_values = $(".child_row_counter"+row_id).val();
            for(let i=0;i<attribute_values.length;i++){
                if(j==1){
                    arr1.push(attribute_values[i]);
                }else if(j==2){
                    arr2.push(attribute_values[i]);
                }else if(j==3){
                    arr3.push(attribute_values[i]);
                }else if(j==4){
                    arr4.push(attribute_values[i]);
                }else if(j==5){
                    arr5.push(attribute_values[i]);
                }
            }
            j++;
        });
        let total_array = (j-1);
        let newArr = [];
        if(total_array==1){
            arr1.map((item1) => {
                newArr.push(item1);
            });
        }else if(total_array==2){
            arr1.map((item1) => {
                arr2.map((item2) => {
                    newArr.push(item1 +" - "+ item2);
                });
            });
        }else if(total_array==3){
            arr1.map((item1) => {
                arr2.map((item2) => {
                    arr3.map((item3) => {
                        newArr.push(item1 +" - "+ item2 +" - "+ item3);
                    });
                });
            });
        }else if(total_array==4){
            arr1.map((item1) => {
                arr2.map((item2) => {
                    arr3.map((item3) => {
                        arr4.map((item4) => {
                            newArr.push(item1 +" - "+ item2 +" - "+ item3 +" - "+ item4);
                        });
                    });
                });
            });
        }else if(total_array==5){
            arr1.map((item1) => {
                arr2.map((item2) => {
                    arr3.map((item3) => {
                        arr4.map((item4) => {
                            arr5.map((item5) => {
                                newArr.push(item1 +" - "+ item2 +" - "+ item3 +" - "+ item4 +" - "+ item5);
                            });
                        });
                    });
                });
            });
        }
        //generate now the variation details
        $("#variation_container_div").empty();
        let html = ``;
        let Default_Sale_Price = $(".Default_Sale_Price").val();
        let Default_Purchase_Price = $(".Default_Purchase_Price").val();
        let Default_Whole_Sale_Price = $(".Default_Whole_Sale_Price").val();
        let opening_stock = $(".opening_stock").val();
        let guide_opening_stock = $("#guide_opening_stock").val();
        let purchase_price = $("#purchase_price").val();
        let whole_sale_price = $("#whole_sale_price").val();
        let sale_price = $("#sale_price").val();
        let code_ = $(".code_").val();
        let alert_quantity = $(".alert_quantity").val();
        for(let i =0;i<newArr.length;i++){
            html += `<tr class="heading_tr">
                        <th colspan="4">
                        <input type="hidden" value="`+newArr[i]+`" name="variation_name[]"> #<span class="counter_variation"></span>  ${newArr[i]} <span class="code_variation_header"></span>          
                            <div class="pull-right">
                                <span class="cursor_tr show_details_view"> 
                                    <iconify-icon data-status="1" class="arrow_status" icon="solar:arrow-up-broken" width="22"></iconify-icon>
                                </span>
                                <span class="cursor_pointer">
                                    <iconify-icon icon="solar:trash-bin-minimalistic-broken" class="row_remove_variation color-red" width="22"></iconify-icon>
                                </span>
                            </div>
                        </th>
                    </tr>
                    <tr class="display_none show_details_view_sub_div1">
                        <td class="op_width_20_p form-group txt-uh-41 c_center" rowspan="2">
                            <input type="hidden" class="variation_product_images" value="">
                            <img class="width_45_p add_image_for_crop_variation cursor_tr" src="`+base_url+`uploads/site_settings/image_thumb.png">
                            <iconify-icon icon="solar:trash-bin-minimalistic-broken" class="image_div display_none color-red" width="22"></iconify-icon>
                        </td>
                        <td class="op_width_20_p form-group">
                            <div class="d-flex justify-content-between">
                                <label>`+Default_Sale_Price+` <span class="required_star">*</span></label>
                                <span><i data-tippy-content="${guide_sale_price}" class="fa-regular fa-circle-question tippyBtnCall font-16 theme-color"></i></span>
                            </div>
                            <input type="text" class="form-control integerchk default_sale_price_variation check_required_variation" onfocus="select()" placeholder="`+Default_Sale_Price+`" value="`+sale_price+`">
                        </td>
                        <td class="op_width_20_p form-group">
                            <div class="d-flex justify-content-between">
                                <label>`+Default_Whole_Sale_Price+` <span class="required_star">*</span></label>
                                <span><i data-tippy-content="${guide_wholesale_price}" class="fa-regular fa-circle-question tippyBtnCall font-16 theme-color"></i></span>
                            </div>
                            <input type="text" class="form-control integerchk default_whole_sale_price_variation check_required_variation" onfocus="select()" placeholder="`+Default_Whole_Sale_Price+`" value="`+whole_sale_price+`">
                        </td> 
                        <td class="op_width_20_p form-group">
                            <div class="d-flex justify-content-between">
                                <label>`+Default_Purchase_Price+` <span class="required_star">*</span></label>
                                <span><i data-tippy-content="${guide_purchase_price}" class="fa-regular fa-circle-question tippyBtnCall font-16 theme-color"></i></span>
                            </div>
                            <input type="text" class="form-control integerchk default_purchase_price_variation check_required_variation" onfocus="select()" placeholder="`+Default_Purchase_Price+`" value="`+purchase_price+`">
                        </td>
                    </tr>

         

                    <tr class="display_none show_details_view_sub_div3">
                        <td class="op_width_20_p form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label>`+opening_stock+`</label>
                                <span><i data-tippy-content="${guide_opening_stock}" class="fa-regular fa-circle-question tippyBtnCall font-16 theme-color"></i></span>
                            </div>
                            <input type="number" onfocus="select()" class="form-control opening_stock_variation" placeholder="`+opening_stock+`">
                            <div class="op_stock_set">
                            </div>
                        </td>
                        <td class="op_width_20_p form-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <label>`+code_+` <span class="required_star">*</span></label>
                            </div>
                            <input type="text" onfocus="select()" class="form-control code_variation check_required_variation check_required_variation" placeholder="`+code_+`">
                        </td>
                        <td class="op_width_20_p form-group" colspan="2">
                            <div class="d-flex justify-content-between align-items-center">
                                <label>`+alert_quantity+`</label>
                                <span><i data-tippy-content="${guide_opening_stock}" class="fa-regular fa-circle-question tippyBtnCall font-16 theme-color"></i></span>
                            </div>
                            <input type="number" onfocus="select()" class="form-control alert_quantity_variation" placeholder="`+alert_quantity+`">
                        </td>  
                    </tr>`;
        }




        $("#variation_container_div").html(html);

        tippy('.tippyBtnCall', {
            theme: 'light',
            placement: 'bottom',
            animation: 'fade',
            allowHTML: true,
        });

        set_data_attribute();
        set_variation_code();

        $('.variation_div_2').removeClass('d-none');
        $('.variation_div_2').addClass('d-block');

        $(".variation_div_1").hide();
        $(".variation_div_2").fadeIn(222);
    });
    $(document).on('click', '.back_to_attribute', function(e){
        e.preventDefault();
        if(add_edit_mode == 'edit_mode'){
            $('.counter_variation_id').each(function(){
                let selectedOption = $(this).find(":selected").val();
                $(this).val(selectedOption).change();
            });
        }

        $('.item_append').html('');
        let attention_variation  = $("#attention_variation").val();
        $('#variation_wrap .select2-container--default').css('width', '100%');
        Swal.fire({
            title: "Warning !",
            text: attention_variation,
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: "OK",
            denyButtonText: "Cancel"
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $(".variation_div_1").fadeIn(222);
                $(".variation_div_2").hide();
                $("#variation_container_div").html("");
                $('.variation_div_2').removeClass('d-block');
                $('.variation_div_2').addClass('d-none');
            }
        });

    });


    $(document).on('submit', '#item_form', function(e){
        let error = false;
        let focus_status = 1;
        $(".check_required_variation").each(function () {
            let value = $(this).val();
            let row_id = $(this).attr('data-id');
            if(value==''){
                let status = Number($("#arrow_status_"+row_id).attr('data-status'));
                $("#arrow_status_"+row_id).removeAttr('icon');
                $("#arrow_status_"+row_id).attr('icon', 'solar:arrow-down-broken');
                $("#show_details_view_sub_div1"+row_id).fadeIn(333);
                $("#show_details_view_sub_div2"+row_id).fadeIn(333);
                $("#show_details_view_sub_div3"+row_id).fadeIn(333);
                $("#show_details_view_sub_div4"+row_id).fadeIn(333);
                $("#arrow_status_"+row_id).attr('data-status',2);

                if(focus_status==1){
                    $(this).focus();
                    focus_status++;
                }
                $(this).css({"border-color":"red"});
                error = true;
            }else{
                $(this).css({"border-color":"#d2d6de"});
            }
        });

        if(error == true){
            return false;
        }
    });


});