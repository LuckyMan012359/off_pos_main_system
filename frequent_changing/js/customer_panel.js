$(function () {
    "use strict";

    /**
     * Full Screen
     */
    let base_url = $("#base_url").val();

    function toggleFullscreen(elem) {
        elem = elem || document.documentElement;
        if (
            !document.fullscreenElement &&
            !document.mozFullScreenElement &&
            !document.webkitFullscreenElement &&
            !document.msFullscreenElement
        ) {
            if (elem.requestFullscreen) {
                elem.requestFullscreen();
            } else if (elem.msRequestFullscreen) {
                elem.msRequestFullscreen();
            } else if (elem.mozRequestFullScreen) {
                elem.mozRequestFullScreen();
            } else if (elem.webkitRequestFullscreen) {
                elem.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
            }
            
        } else {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.msExitFullscreen) {
                document.msExitFullscreen();
            } else if (document.mozCancelFullScreen) {
                document.mozCancelFullScreen();
            } else if (document.webkitExitFullscreen) {
                document.webkitExitFullscreen();
            }
            

        }
    }
    $(document).on("click", "#fullscreen", function (e) {
        toggleFullscreen();
    });
    function get_cart_data() {
        $.ajax({
            url: base_url + "customer-panel-data",
            method: "POST",
            dataType:'json',
            success: function (response) {
                if(response){
                    let totalItem = $('.single-item-wrap').length;
                    if(response.items_html){
                        $(".customer_display_body").html(response.items_html);
                    }else{
                        $(".customer_display_body").empty();
                    }
                    if(response.total_sub_total){
                        $(".subtotal-amt").html(response.total_sub_total);
                    }else{
                        $(".subtotal-amt").html(parseFloat(0));
                    }
                    if(totalItem){
                        $(".item-qty").html(totalItem);
                    }else{
                        $(".item-qty").html(parseFloat(0));
                    }
                    if(response.total_item){
                        $(".total-item-amt").html(response.total_item);
                    }else{
                        $(".total-item-amt").html(parseFloat(0));
                    }
                    if(response.total_discount_amount){
                        $(".total-discount-amt").html(response.total_discount_amount);
                    }else{
                        $(".total-discount-amt").html(parseFloat(0));
                    }
                    if(response.total_discount){
                        $(".discount-amt").html(response.total_discount);
                    }else{
                        $(".discount-amt").html(parseFloat(0));
                    }
                    if(response.total_tax){
                        $(".tax-amt").html(response.total_tax);
                    }else{
                        $(".tax-amt").html(parseFloat(0));
                    }
                    if(response.total_charge){
                        $(".charge-amt").html(response.total_charge);
                    }else{
                        $(".charge-amt").html(parseFloat(0));
                    }
                    if(response.total_payable){
                        $(".total-payable-amt").html(response.total_payable);
                    }else{
                        $(".total-payable-amt").html(parseFloat(0));
                    }
                }else{
                    $(".subtotal-amt").html(parseFloat(0));
                    $(".item-qty").html(parseFloat(0));
                    $(".total-item-amt").html(parseFloat(0));
                    $(".total-discount-amt").html(parseFloat(0));
                    $(".discount-amt").html(parseFloat(0));
                    $(".tax-amt").html(parseFloat(0));
                    $(".charge-amt").html(parseFloat(0));
                    $(".total-payable-amt").html(parseFloat(0));
                }
            }
        });
    }
    setInterval(function(){
        get_cart_data();
    }, 1000);

});


