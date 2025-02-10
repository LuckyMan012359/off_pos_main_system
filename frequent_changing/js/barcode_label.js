$(function () {
  "use strict"

    let base_url = $("#base_url").val();

    $(document).on('change', '#hide_product_name', function(){
      if ($('input#hide_product_name').is(':checked')) {
        $('.product_name').each(function(){
          $(this).hide();
        })
      }else{
        $('.product_name').each(function(){
          $(this).show();
        })
      }
    });
    $(document).on('change', '#hide_product_code', function(){
      if ($('input#hide_product_code').is(':checked')) {
        $('.product_code').each(function(){
          $(this).hide();
        })
      }else{
        $('.product_code').each(function(){
          $(this).show();
        })
      }
    });
    $(document).on('change', '#hide_product_price', function(){
      if ($('input#hide_product_price').is(':checked')) {
        $('.product_price').each(function(){
          $(this).hide();
        })
      }else{
        $('.product_price').each(function(){
          $(this).hide();
        })
      }
    });
    
    $(document).on('click', '.product_name_font_size_plus', function(){
      let current_font_size = $('.product_name span').attr('c-font-size');
      $('.product_name span').attr('c-font-size', `${parseInt(current_font_size) + 1}`);
      $('.product_name span').css('font-size', `${parseInt(current_font_size) + 1 +'px'}`);
    });
    $(document).on('click', '.product_name_font_size_minus', function(){
      let current_font_size = $('.product_name span').attr('c-font-size');
      $('.product_name span').attr('c-font-size', `${parseInt(current_font_size) - 1}`);
      $('.product_name span').css('font-size', `${parseInt(current_font_size) - 1 +'px'}`);
    });
    $(document).on('click', '.product_code_font_size_plus', function(){
      let current_font_size = $('.item_description1 .product_code').attr('c-font-size');
      $('.item_description1 .product_code').attr('c-font-size', `${parseInt(current_font_size) + 1}`);
      $('.item_description1 .product_code').css('font-size', `${parseInt(current_font_size) + 1 +'px'}`);
    });
    $(document).on('click', '.product_code_font_size_minus', function(){
      let current_font_size = $('.item_description1 .product_code').attr('c-font-size');
      $('.item_description1 .product_code').attr('c-font-size', `${parseInt(current_font_size) - 1}`);
      $('.item_description1 .product_code').css('font-size', `${parseInt(current_font_size) - 1 +'px'}`);
    });
    $(document).on('click', '.product_price_font_size_plus', function(){
      let current_font_size = $('.item_description1 .product_price').attr('c-font-size');
      $('.item_description1 .product_price').attr('c-font-size', `${parseInt(current_font_size) + 1}`);
      $('.item_description1 .product_price').css('font-size', `${parseInt(current_font_size) + 1 +'px'}`);
    });
    $(document).on('click', '.product_price_font_size_minus', function(){
      let current_font_size = $('.item_description1 .product_price').attr('c-font-size');
      $('.item_description1 .product_price').attr('c-font-size', `${parseInt(current_font_size) - 1}`);
      $('.item_description1 .product_price').css('font-size', `${parseInt(current_font_size) - 1 +'px'}`);
    });
    

    $(document).on('click', '#save_settings', function(){
      let hide_product_name = $('input#hide_product_name').is(':checked');
      let hide_product_code = $('input#hide_product_code').is(':checked');
      let hide_product_price = $('input#hide_product_price').is(':checked');
      let name_font_size = $('.product_name span').attr('c-font-size');
      let code_font_size = $('.item_description1 .product_code').attr('c-font-size');
      let price_font_size = $('.item_description1 .product_price').attr('c-font-size');

      $.ajax({
        type: "POST",
        url: base_url+"Ajax/barcodeLabelSetting",
        data: {
          hide_product_name: hide_product_name,
          hide_product_code: hide_product_code,
          hide_product_price: hide_product_price,
          name_font_size: name_font_size,
          code_font_size: code_font_size,
          price_font_size: price_font_size,
        },
        dataType: "json",
        success: function (response) {
          if(response.status == 'success'){
            $('.ajax-message').html('');
            $('.ajax-message').html(`
              <section class="alert-wrapper">
                <div class="alert alert-success alert-dismissible fade show"> 
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>
                  <div class="alert-body">
                    <i class="icon fa fa-check me-2"></i>
                    ${response.message}
                  </div>
                </div>
              </section>
            `);
            setTimeout(function(){
              $('.ajax-message').html('');
            }, 3000);
          }
        }
      });
    });

    $(document).on('click', '#resent_default', function(){
      $('input#hide_product_name').prop('checked', false);
      $('input#hide_product_code').prop('checked', false);
      $('input#hide_product_price').prop('checked', false);

      $('.product_name').css('display', 'block');
      $('.product_code').css('display', 'block');
      $('.product_price').css('display', 'block');

      $('.product_name span').css('font-size', '8px');
      $('.product_code').css('font-size', '10px');
      $('.product_price').css('font-size', '16px');

      
      $.ajax({
        type: "POST",
        url: base_url+"Ajax/barcodeLabelSetting",
        data: {
          hide_product_name: false,
          hide_product_code: false,
          hide_product_price: false,
          name_font_size: 8,
          code_font_size: 10,
          price_font_size: 16
        },
        dataType: "json",
        success: function (response) {
          if(response.status == 'success'){
            $('.ajax-message').html('');
            $('.ajax-message').html(`
              <section class="alert-wrapper">
                <div class="alert alert-success alert-dismissible fade show"> 
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>
                  <div class="alert-body">
                    <i class="icon fa fa-check me-2"></i>
                    ${response.message}
                  </div>
                </div>
              </section>
            `);
            setTimeout(function(){
              $('.ajax-message').html('');
            }, 3000);
          }
        }
      });
    });
});
