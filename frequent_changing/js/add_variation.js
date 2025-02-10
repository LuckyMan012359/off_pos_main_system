$(function () {
    "use strict";
    let variation_value = $('#variation_value').val();

    $(document).on('click', '.add_row', function(e){
        let variation_value = $("#variation_value").val();
        let html =   `<div class="form-group">
        <div class="d-flex mb-3">
            <input   onfocus="select();"  autocomplete="off"  name="variation_value[]" class="form-control check_required" value="" placeholder="`+variation_value+`" /><a class="remove_row new-btn-danger h-40 ms-3" href="javascript:void(0)"><iconify-icon icon="solar:trash-bin-minimalistic-broken" width="18"></iconify-icon></a>
        </div></div>`;
    $(".div_row").append(html);
    });

    $(document).on('click', '.remove_row', function(e){
        $(this).parent().parent().remove();
    });
    // Validate form
    $(document).on('submit', '#add_variation', function(e){
        let error = false;
        $(".check_required").each(function () {
            let this_value = $.trim($(this).val());
            if(this_value == ''){
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