$(function () {
  "use strict";
  let base_url = $('#base_url_').val();
  let select = $("#select").val();
  let shop_name = $("#shop_name").val();
  let currency = $("#currency_").val();
  let op_precision = $("#op_precision").val();
  let price = $("#price").val();
  let code = $("#code").val();
  let Please_select_an_item = $("#Please_select_an_item").val();

  $(document).on('click', '.print_barcode', function (e) { 
      e.preventDefault();
      jQuery('#barcode_print').modal('show');
      let item_id = $(this).attr('data-item');
      let item_type = $(this).attr('data-item-type');
      if(item_type != 'Variation_Product'){
        $('#variation_show_hide').addClass('d-none');
      }else{
        $('#variation_show_hide').removeClass('d-none');
      }
      $('.item_type_r').val(item_type);
      if(item_type == 'Variation_Product'){
        $.ajax({
          type: "GET",
          url: base_url+'Item/getVariationItem/'+item_id,
          success: function (response) {
            if (response) {
              let json = $.parseJSON(response);
              let html = '<option value="">'+select+'</option>';
              $.each(json.items, function (i, v) {
                html += '<option value="' + v.id + '">' + json.item_name.name +'('+ v.name + '-' + v.code +')' +'</option>';
              });
              $("#set_variation_child").html(html);
            }
          }
        });
      }
      $('.no_of_item').val('');
      $('#barcode_wrap').html('');
      $.ajax({
          type: "GET",
          url: base_url+'Item/getItem/'+item_id,
          success: function (response) {
            if(response.status == 'success'){
              $('.item_name').text('');
              $('.item_name').text(response.data.item_info.name);
              $('.item_id_r').val(response.data.item_id);
              let barcodeValue = response.data.item_info;	
              JsBarcode("#barcode", barcodeValue, {
                width: 1,
                height: 30,
                fontSize: 10,
                textMargin: -18,
                margin: 0,
                marginTop: 0,
                marginLeft: 10,
                marginRight: 10,
                marginBottom: 0,
                borderBottom: 0,
                displayValue: false				
              });
          }
          }
      });
  });

  $(document).on('click', '#re_generate', function (e) { 
      e.preventDefault();
      let error = false;
      let no_of_item = $('.no_of_item').val();
      let item_id = $('.item_id_r').val();
      let item_type = $('.item_type_r').val();
      let variaton_value = $('#set_variation_child').val();
      if(item_type == 'Variation_Product'){
        if(variaton_value == ''){
          $('.error_variation').html(`<div class="callout callout-danger">${Please_select_an_item}</div>`)
          error = true;
        }else{
          $('.error_variation').html('');
        } 
      }
      $('#barcode_wrap').html('');
      if(error == false){
        $.ajax({
          type: "GET",
          url: base_url+'Item/getItem/'+item_id,
          success: function (response) {
              if(response.status == 'success'){
                  let selected_text = "";
                  if(item_type == 'Variation_Product'){
                    selected_text = $('#set_variation_child').find(":selected").text();
                    $('.item_name').text(selected_text);
                  }else{
                    selected_text = response.data.item_info.name;
                  }
                  let i = 0;
                  for(i = 0; i < no_of_item; i++){
                      $('#barcode_wrap').append(`
                          <div class="border-1px-dotted-ebebeb text-center op_float_left col-md-3 py-2 ${ i == 0 || i == 1 ? 'border-top-ebebeb' : '' } ${i % 2 == 0 ? 'border-r-b-l' : 'border-r-b'}">
                            <div class="text-center">
                              <span class="font-700"> ${selected_text}</span>
                            </div>
                            <svg id="barcode"></svg>
                            <div class="text-center item_description">
                              <p class="font-700">${code} :  ${ response.data.item_info.code}</p>
                              <p>${price} : ${currency} ${ Number(response.data.item_info.sale_price).toFixed(op_precision)}</p>
                              <p>${shop_name}</p>
                            </div>
                          </div>
                      `);
                  }
                  
                  let barcodeValue = response.data.item_info.code;	
                  JsBarcode("#barcode", barcodeValue, {
                    width: 1,
                    height: 30,
                    fontSize: 10,
                    textMargin: -18,
                    margin: 0,
                    marginTop: 0,
                    marginLeft: 10,
                    marginRight: 10,
                    marginBottom: 0,
                    borderBottom: 0,
                    displayValue: false			
                  });
              }
          }
        });
      }
  });

  $(document).on('click', '.print_label', function (e) { 
      e.preventDefault();
      jQuery('#label_barcode_print').modal('show');
      let item_id = $(this).attr('data-item');
      let item_type = $(this).attr('data-item-type');
      if(item_type != 'Variation_Product'){
        $('#label_variation_show_hide').addClass('d-none');
      }else{
        $('#label_variation_show_hide').removeClass('d-none');
      }
      $('.label_item_type_r').val(item_type);
      if(item_type == 'Variation_Product'){
        $.ajax({
          type: "GET",
          url: base_url+'Item/getVariationItem/'+item_id,
          success: function (response) {
            if (response) {
              let json = $.parseJSON(response);
              let html = '<option value="">'+select+'</option>';
              $.each(json.items, function (i, v) {
                html += '<option value="' + v.id + '">' + json.item_name.name +'('+ v.name + '-' + v.code +')' +'</option>';
              });
              $("#lablel_set_variation_child").html(html);
            }
          }
        });
      }
      $('.lable_no_of_item').val('');
      $('#label_barcode_wrap').html('');
      $.ajax({
          type: "GET",
          url: base_url+'Item/getItem/'+item_id,
          success: function (response) {
            if(response.status == 'success'){
              $('.label_item_name').text('');
              $('.label_item_name').text(response.data.item_info.name);
              $('.label_item_id_r').val(response.data.item_id);
              let barcodeValue = response.data.item_info.code;	
              JsBarcode("#barcode", barcodeValue, {
                width: 1,
                height: 30,
                fontSize: 10,
                textMargin: -18,
                margin: 0,
                marginTop: 0,
                marginLeft: 10,
                marginRight: 10,
                marginBottom: 0,
                borderBottom: 0,
                displayValue: false				
              });
          }
          }
      });
  });

  $(document).on('click', '#label_re_generate', function (e) { 
      e.preventDefault();
      let error = false;
      let no_of_item = $('.label_no_of_item').val();
      let item_id = $('.label_item_id_r').val();
      let item_type = $('.label_item_type_r').val();
      let variaton_value = $('#lablel_set_variation_child').val();
      if(item_type == 'Variation_Product'){
        if(variaton_value == ''){
          $('.label_error_variation').html('<div class="callout callout-danger">Please select an item</div>')
          error = true;
        }else{
          $('.label_error_variation').html('');
        } 
      }
      $('#label_barcode_wrap').html('');
      if(error == false){
        $.ajax({
          type: "GET",
          url: base_url+'Item/getItem/'+item_id,
          success: function (response) {
              if(response.status == 'success'){
                  let selected_text = "";
                  if(item_type == 'Variation_Product'){
                    selected_text = $('#lablel_set_variation_child').find(":selected").text();
                    $('.label_item_name').text(selected_text);
                  }else{
                    selected_text = response.data.item_info.name;
                  }
                  let i = 0;
                  for(i = 0; i < no_of_item; i++){
                      $('#label_barcode_wrap').append(`
                          <div style="${ no_of_item == no_of_item[i] ? '' : 'page-break-after: always;'}"></div>
                          <div class="border-1px-dotted-ebebeb text-center col-md-3 py-2 ${ i == 0 || i == 1 ? 'border-top-ebebeb' : '' } ${i % 2 == 0 ? 'border-r-b-l' : 'border-r-b'}" style="line-height: 0.5;">
                            <div class="text-center">
                              <span style="font-size: 8px;line-height: 2; padding-left: 14px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"> ${selected_text}</span>
                            </div>
                            <div class="text-center">
                              <svg id="barcode"></svg>
                            </div>
                            <div class="text-center item_description">
                              <span style="font-size: 10px; line-height: 16px;">${code} :  ${ response.data.item_info.code}</span>
                              <p style="font-700" style="font-size: 16px;line-height: 0px; padding-top: 0px;padding-bottom: 0px;">${price} : ${currency} ${ Number(response.data.item_info.sale_price).toFixed(op_precision)}</p>
                            </div>
                          </div>
                      `);
                  }
                  op_precision
                  let barcodeValue = response.data.item_info.code;	
                  JsBarcode("#barcode", barcodeValue, {
                    width: 1,
                    height: 30,
                    fontSize: 10,
                    textMargin: -18,
                    margin: 0,
                    marginTop: 0,
                    marginLeft: 10,
                    marginRight: 10,
                    marginBottom: 0,
                    borderBottom: 0,
                    displayValue: false			
                  });
              }
          }
        });
      }
  });

  $(document).on('change', '#set_variation_child', function(e){
    let variaton_item = $(this).val();
    $('.item_id_r').val('');
    $('.item_id_r').val(variaton_item);
  });

  $(document).on('change', '#set_variation_child_label', function(e){
    let variaton_item = $(this).val();
    $('.item_id_r').val('');
    $('.item_id_r').val(variaton_item);
  });
  
});