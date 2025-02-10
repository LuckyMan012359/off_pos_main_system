$(function () {
    "use strict";
    let base_url_ = $("#base_url_").val();
    let csrf_name_= $("#csrf_name_").val();
    let csrf_value_= $("#csrf_value_").val();
    let currency = $("#currency_").val();
    let The_items_field_is_required = $("#The_items_field_is_required").val();
    let The_outlet_field_is_required = $("#The_outlet_field_is_required").val();



    $(document).on('change', '#food_id', function() {
        let value = this.value;
        if(value){
            $('#category_id').prop('disabled', true);
            $('#item_id').prop('disabled', true);
        }else{
            $('#category_id').prop('disabled', false);
            $('#item_id').prop('disabled', false);
        }
    });
    $(document).on('change', '#item_id', function() {
        let item_id = this.value;
        let category_id = $('select.category_id').find(':selected').val();
        if(item_id || category_id){
            $('#food_id').prop('disabled', true);
        }else{
            $('#food_id').prop('disabled', false);
        }
    });
    $(document).on('change', '#category_id', function() {
        let category_id = this.value;
        if(category_id){
            $('#food_id').prop('disabled', true);
        }else{
            $('#food_id').prop('disabled', false);
        }

        let options = '';
        $.ajax({
            type : 'get',
            url : base_url_+'Stock/getIngredientInfoAjax',
            data: {category_id: category_id,csrf_name_: csrf_value_},
            datatype: 'json',
            success : function(data){
                let json = $.parseJSON(data);
                options += '<option  value="">Item</option>';
                $.each(json, function (i, v) {
                    options += '<option  value="'+v.id+'">'+v.name+'('+v.code+')</option>';
                });
                $('#item_id').html(options);
            }
        });
    });

    $(document).ready(function () {
        $('.variation_table').each(function(){
            let uniq_table_key = $(this).attr('data-unique');
            $(`.unique_table${uniq_table_key}`).each(function(){
                let unique_table = $(`.unique_table${uniq_table_key} tbody tr`).length;
                if(unique_table == 0){
                   $(this).parent().parent().css('display', 'none');
                   $(this).parent().parent().attr('data-item', '');
                   $(this).parent().parent().removeClass('serial_counter');
                }
            });
        });
    });

    $(document).ready(function () {
        $('.serial_counter').each(function(key, val){
            let data_item = $(this).attr('data-item');
            if(data_item != ''){
                $(this).find('.key_generate').text(key+1)
            }
        });
    });
    

    $(document).ready(function(){
        let category_id = $('select.category_id').find(':selected').val();
        let item_id = $('select.item_id').find(':selected').val();
        let food_id = $('select.food_id').find(':selected').val();
        if(food_id){
            $('#category_id').prop('disabled', false);
            $('#item_id').prop('disabled', false);

        }else if(item_id || category_id){
            $('#category_id').prop('disabled', false);
            $('#item_id').prop('disabled', false);
        }
        else{
            if(food_id){
                $('#category_id').prop('disabled', true);
                $('#item_id').prop('disabled', true);
            }

        }
        if(category_id){
            let options = '';
            let selectedID=$("#hiddentIngredientID").val();
            $.ajax({
                type : 'get',
                url : base_url_+'Stock/getIngredientInfoAjax',
                data: {category_id: category_id,csrf_name_: csrf_value_},
                datatype: 'json',
                success : function(data){
                    let json = $.parseJSON(data);
                    options += '<option  value="">Item</option>';
                    $.each(json, function (i, v) {
                        options += '<option  value="'+v.id+'">'+v.name+'('+v.code+')</option>';
                    });
                    $('#item_id').html(options);
                    $('#item_id').val(selectedID).change();
                }
            });
        }
        $('#stockValue').text($('#grandTotal').val());
    });


    $(document).on('click', '.stockReport', function () {  
        let error = false;
        let filterOption = $('input[name="filterOption"]:checked').val();
        let item_id = $('#item_id').val();
        let outlet_id = $('#outlet_id').val();
        if(filterOption == 'OutletFilter'){
            if(item_id == ''){
                error = true;
                $('#item_id_err_msg').text(The_items_field_is_required);
                $('.item_id_err_msg_contnr').show(200);
            }
        }else{
            $('.item_id_err_msg_contnr').hide();
            if(outlet_id == ''){
                error = true;
                $('#outlet_id_err_msg').text(The_outlet_field_is_required);
                $('.outlet_id_err_msg_contnr').show(200);
            }
        }
        if(error == true){
            return false;
        }
    });





});