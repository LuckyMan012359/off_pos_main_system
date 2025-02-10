$(function() {
    "use strict";
    function change_div() {
        let type = Number($(".type").val());
        $(".discount_div").hide();
        $(".free_item_div").hide();
        $(".coupon_code").hide();
        $(".discount_both").hide();
        if(type==1){
            $(".discount_div").show();
            $(".discount_both").show();
        }else if (type==2){
            $(".free_item_div").show();
        }else if (type==3){
            $(".coupon_code").show();
            $(".discount_both").show();
        }
    }
    $(document).on('change', '.type', function () {
        change_div();
    });
    change_div();
});

