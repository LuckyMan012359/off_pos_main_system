$(function () {
    "use strict";
    let base_url = $('#base_url').val();

    let stripePayementStatus = false;
    let paypalPayementStatus = false;

    $(document).on("click", ".pay_button", function () {
        // Card Payment info
        let holder_name = $("#holder_name").val();
        let credit_card_no = $("#credit_card_no").val();
        let payment_month = $("#payment_month").val();
        let payment_year = $("#payment_year").val();
        let payment_cvc = $("#payment_cvc").val();

        let paypal = $("#paypal").is(":checked");
        let stripe = $("#stripe").is(":checked");
        if(!paypal && !stripe){
            toastr["error"]("Please Select payment method", "");
            return false;
        }
        let account_type;
        if(paypal){
            account_type = 'Paypal';
        }
        if(stripe){
            account_type = 'Stripe';
        }
        // Stripe
        if (account_type == "Stripe") {
            stripePayment({
                credit_card_no: credit_card_no,
                holder_name: holder_name,
                payment_month: payment_month,
                payment_year: payment_year,
                payment_cvc: payment_cvc,
            });
        }

        if (account_type == "Paypal") {
            paypalPayment({
                credit_card_no: credit_card_no,
                holder_name: holder_name,
                payment_month: payment_month,
                payment_year: payment_year,
                payment_cvc: payment_cvc,
            });
        }
    });

    function stripePayment(info) {
        if (info.credit_card_no == "") {
            toastr["error"]("Credit Card No Required", "");
            return false;
        }

        if (info.holder_name == "") {
            toastr["error"]("Card Holder Name Required", "");
            return false;
        }
        if (info.payment_month == "") {
            toastr["error"]("Payment Month Required", "");
            return false;
        }
        if (info.payment_year == "") {
            toastr["error"]("Payment Year Required", "");
            return false;
        }
        if (info.payment_cvc == "") {
            toastr["error"]("Payment CVV Required", "");
            return false;
        }

        let stripe_publish_key = $('#stripe_publish_key').val();
        Stripe.setPublishableKey(stripe_publish_key);
        Stripe.createToken({
            number: info.credit_card_no,
            cvc: info.payment_cvc,
            exp_month: info.payment_month,
            exp_year: info.payment_year,
        },
            stripeResponseHandler
        );
    }

    function stripeResponseHandler(status, response) {
        if (response.error) {
            toastr["error"](response.error.message, "");
        } else {
            /* token contains id, last4, and card type */
            let token = response["id"];
            let payment_company_id = $("#payment_company_id").val();
            $.ajax({
                url: base_url + "Authentication/stripeMainPaymentOnetime",
                method: "POST",
                data: {
                    token: token,
                    payment_company_id: payment_company_id,
                },
                success: function (response) {
                    let data = JSON.parse(response);
                    if (data.status == "error") {
                        toastr["error"]("Amount Must be grater than 0", "");
                        stripePayementStatus = false;
                    }
                    if (data.paid == true) {
                        stripePayementStatus = true;
                        toastr["success"]("Payment Successfully", "");
                        window.location.href = base_url+"Authentication/index";
                    } else {
                        toastr["error"]("Something Went Wrong! Please try again", "");
                        stripePayementStatus = false;
                    }
                },
            });
        }
    }

    // Paypal Handle
    function paypalPayment(info) {
        if (info.credit_card_no == "") {
            toastr["error"]("Credit Card No Required", "");
            return false;
        }
        if (info.holder_name == "") {
            toastr["error"]("Card Holder Name Required", "");
            return false;
        }
        
        if (info.payment_month == "") {
            toastr["error"]("Payment Month Required", "");
            return false;
        }
        if (info.payment_year == "") {
            toastr["error"]("Payment Year Required", "");
            return false;
        }
        if (info.payment_cvc == "") {
            toastr["error"]("Payment CVV Required", "");
            return false;
        }
        let payment_company_id = $("#payment_company_id").val();
        $.ajax({
            url: base_url + "Authentication/paypalMainPaymentOnetime",
            method: "POST",
            data: {
                info : info,
                payment_company_id: payment_company_id,
            },
            success: function (response) {
                let data = JSON.parse(response);
                if (data.status == "error" && data.code == 701) {
                    toastr["error"]("Amount Must be grater than 0", "");
                    paypalPayementStatus = false;
                }
                if (data.code == 200) {
                    paypalPayementStatus = true;
                    toastr["success"]("Payment Successfully", "");
                    window.location.href = base_url+"Authentication/index";
                } else {
                    toastr["error"]("Something Went Wrong! Maybe Wrong Credentials!", "");
                    paypalPayementStatus = false;
                }
            },
        });
    }

});