$(function () {
  "use strict";
  let base_url = $('#base_url_').val();
  let no_permission_for_this_module = $('#no_permission_for_this_module').val();
  let ok = $("#ok").val();
  let warning = $('#warning').val();
  $(document).on('click', '.print_barcode', function (e) { 
      e.preventDefault();
      let himself = $(this);
      $.ajax({
        url: base_url + "Master/checkAccess",
        method: "GET",
        async: false,
        dataType: 'json',
        data: { controller: "109", function: "print_barcode" },
        success: function (response) {
          if (response == false) {
            Swal.fire({
              title: warning+" !",
              text: no_permission_for_this_module,
              showDenyButton: false,
              showCancelButton: false,
              confirmButtonText: ok,
            });
          } else {
            jQuery('#barcode_print').modal('show');
            let purchase_id = himself.attr('data-id');
            $('#barcode_wrap').html('');
            $.ajax({
              type: "POST",
              url: base_url+'Purchase/getPurchasesItems/'+purchase_id,
              data: {
                purchase_id: purchase_id,
              },
              success: function (response) {
                  if(response.status == 'success'){
                    let item_name = '';
                    $.each(response.data, function (i, v) { 
                      if(v.parent_name){
                        item_name = v.parent_name + '(' + v.child_name + ')';
                      }else{
                        item_name = v.child_name;
                      }
                      $('#barcode_wrap').append(`
                        
                        <div class="border-1px-dotted-ebebeb text-center op_float_left col-md-3 py-2 ${ i == 0 || i == 1 ? 'border-top-ebebeb' : '' } ${i % 2 == 0 ? 'border-r-b-l' : 'border-r-b'}">
                          <div class="text-center">
                            <span class="font-700"> Name: ${ item_name }</span>
                          </div>
                          <svg id="barcode${i}"></svg>
                          <div class="text-center">
                            <small class="font-700">Code: ${ v.code }</small>
                          </div>
                        </div>
                      `);
                      let barcodeValue = v.code;	
                      JsBarcode(`#barcode${i}`, barcodeValue, {
                        width: 1,
                        height: 30,
                        fontSize: 10,
                        textMargin: -18,
                        margin: 0,
                        marginTop: 0,
                        marginLeft: 7,
                        marginRight: 7,
                        marginBottom: 0,
                        borderBottom: 0,
                        displayValue: false			
                      });
                    });
                  }
              }
            });
          }
        }
    });
  });

  $(document).on('click', '.m_close_trigger',function () {
    $('.modal').hide();
    $('.modal-backdrop').attr('class', '');
  });



});