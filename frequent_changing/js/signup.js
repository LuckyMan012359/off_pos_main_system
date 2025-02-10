$(function () {
    "use strict";
    let base_url = $('#base_url').val();


    let stripePayementStatus = false;
    let paypalPayementStatus = false;


    $(document).on('change', '#plan_id', function(){
        pricingPlanDiv();
    });


    $(document).on('change', '#payment_type', function(){
        let payment_type = $(this).val();
        let html = '';
        if(payment_type == 'One Time' || payment_type == ''){
            html = `<option value="">Select</option>
                <option value="Paypal">Paypal</option>
                <option value="Stripe">Stripe</option>`;
        } else if(payment_type == 'Recurring') {
            html = `<option value="">Select</option>
                <option value="Paypal">Paypal</option>`
        } 
        $('#payment_mothod').html('').html(html);
    });


    function IsEmail(email) {
        var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if(!regex.test(email)) {
           return false;
        }else{
           return true;
        }
    }


    function pricingPlanDiv(){
        let plan_id = $('#plan_id').val();
        if(plan_id){
            $.ajax({
                type: "POST",
                url: base_url+"Authentication/planCheck",
                data: {
                    plan_id:plan_id
                },
                dataType: "json",
                success: function (response) {
                    if(response.status == 'success' && response.data.free_trial_status == 'Free'){
                        $('.pricing_plan_div').hide();
                        $('.signup-btn').show(200);
                    }else if(response.status == 'success' && response.data.free_trial_status == 'Paid'){
                        $('.pricing_plan_div').show();
                        $('.signup-btn').hide(200);
                    }
                }
            });
        }else{
            $('.pricing_plan_div').hide();
        }
    }
    pricingPlanDiv();



    function uniqueEmailValidationCheck(email_address){
        let exist = 'No';
        $.ajax({
            type: "POST",
            url: base_url+"Authentication/uniqueEmailValidateInSignup",
            async: false,
            data: {
                email_address:email_address,
            },
            success: function (response) {
                if(response.status == 'success'){
                    exist = 'Yes';
                }
            }
        });
        return exist;
    }

    $(document).on('submit', '#singup_form', function () {
        let error = false;
        let payment_type = $('#payment_type').val();
        let payment_mothod = $('#payment_mothod').val();
        let plan_id = $('#plan_id').val();
        let trialCheck = $('option:selected', '#plan_id').attr('data-pricing_plan_status');

        
        let full_name = $('#full_name').val();
        if (full_name == "") {
            let msg =  `<div class="d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                    <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                </svg> 
                <span class="ps-2">
                    The Author Name field is requied
                </span>
            </div>`;
            $(".author_name_err_msg").html(msg);
            $(".author_name_err_msg_contnr").show(200);
            error = true;
        }else{
            $(".author_name_err_msg").html('');
            $(".author_name_err_msg_contnr").hide(200);
        }

        let email_address = $('#email_address').val();
        if (email_address == "") {
            let msg =  `<div class="d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                    <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                </svg> 
                <span class="ps-2">
                    The Email Address field is requied
                </span>
            </div>`;
            $(".email_address_err_msg").html(msg);
            $(".email_address_err_msg_contnr").show(200);
            error = true;
        }else if(IsEmail(email_address) == false){
            let msg =  `<div class="d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                    <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                </svg> 
                <span class="ps-2">
                    The Email Address is not valid!
                </span>
            </div>`;
            $(".email_address_err_msg").html(msg);
            $(".email_address_err_msg_contnr").show(200);
            error = true;
        }else if(uniqueEmailValidationCheck(email_address) == 'Yes'){
            let msg =  `<div class="d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                    <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                </svg> 
                <span class="ps-2">
                    The Email is already exist, use diffrent email.
                </span>
            </div>`;
            $(".email_address_err_msg").html(msg);
            $(".email_address_err_msg_contnr").show(200);
            error = true;
        }else{
            $(".email_address_err_msg").html('');
            $(".email_address_err_msg_contnr").hide(200);
        }

        let password = $('#password').val();
        let confirm_password = $('#confirm_password').val();
        if(password == ''){
            let msg =  `<div class="d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                    <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                </svg> 
                <span class="ps-2">
                    The Password field is requied
                </span>
            </div>`;
            $(".password_err_msg").html(msg);
            $(".password_err_msg_contnr").show(200);
            error = true;
        }else{
            $(".password_err_msg").html('');
            $(".password_err_msg_contnr").hide(200);
        }
        if(confirm_password == ''){
            let msg =  `<div class="d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                    <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                </svg> 
                <span class="ps-2">
                    The Confirm Password field is requied
                </span>
            </div>`;
            $(".confirm_password_err_msg").html(msg);
            $(".confirm_password_err_msg_contnr").show(200);
            error = true;
        }else{
            $(".confirm_password_err_msg").html('');
            $(".confirm_password_err_msg_contnr").hide(200);
        }

        if((password && confirm_password) && (password != confirm_password)){
            let msg =  `<div class="d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                    <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                </svg> 
                <span class="ps-2">
                    The Password & Confirm Password does't match
                </span>
            </div>`;
            $(".password_err_msg").html(msg);
            $(".password_err_msg_contnr").show(200);
            error = true;
        }else{
            $(".password_err_msg").html('');
            $(".password_err_msg_contnr").hide(200);
        }


        let business_name = $('#business_name').val();
        if (business_name == "") {
            let msg =  `<div class="d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                    <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                </svg> 
                <span class="ps-2">
                    The Business Name field is requied
                </span>
            </div>`;
            $(".business_name_err_msg").html(msg);
            $(".business_name_err_msg_contnr").show(200);
            error = true;
        }else{
            $(".business_name_err_msg").html('');
            $(".business_name_err_msg_contnr").hide(200);
        }


        let phone_number = $('#phone_number').val();
        if (phone_number == "") {
            let msg =  `<div class="d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                    <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                </svg> 
                <span class="ps-2">
                    The Phone Number field is requied
                </span>
            </div>`;
            $(".phone_number_err_msg").html(msg);
            $(".phone_number_err_msg_contnr").show(200);
            error = true;
        }else{
            $(".phone_number_err_msg").html('');
            $(".phone_number_err_msg_contnr").hide(200);
        }


        let zone = $('#zone').val();
        if (zone == "") {
            let msg =  `<div class="d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                    <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                </svg> 
                <span class="ps-2">
                    The Zone field is requied
                </span>
            </div>`;
            $(".zone_err_msg").html(msg);
            $(".zone_err_msg_contnr").show(200);
            error = true;
        }else{
            $(".zone_err_msg").html('');
            $(".zone_err_msg_contnr").hide(200);
        }

        if (plan_id == "") {
            let msg =  `<div class="d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                    <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                </svg> 
                <span class="ps-2">
                    The Pricing Plan field is requied
                </span>
            </div>`;
            $(".plan_id_err_msg").html(msg);
            $(".plan_id_err_msg_contnr").show(200);
            error = true;
        }else{
            $(".plan_id_err_msg").html('');
            $(".plan_id_err_msg_contnr").hide(200);
        }

        if(plan_id != '' && trialCheck == 'Paid'){
            if (payment_type == "") {
                let msg =  `<div class="d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                    </svg> 
                    <span class="ps-2">
                        The Payment Type field is requied
                    </span>
                </div>`;
                $(".payment_type_err_msg").html(msg);
                $(".payment_type_err_msg_contnr").show(200);
                error = true;
            }else{
                $(".payment_type_err_msg").html('');
                $(".payment_type_err_msg_contnr").hide(200);
            }
            if (payment_mothod == "") {
                let msg =  `<div class="d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                    </svg> 
                    <span class="ps-2">
                        The Payment Method field is requied
                    </span>
                </div>`;
                $(".payment_method_err_msg").html(msg);
                $(".payment_method_err_msg_contnr").show(200);
                error = true;
            }else{
                $(".payment_method_err_msg").html('');
                $(".payment_method_err_msg_contnr").hide(200);
            }

            
            if(payment_mothod == 'Paypal' || payment_mothod == 'Stripe'){
                let holder_name = $('#holder_name').val();
                let credit_card_no = $('#credit_card_no').val();
                let payment_month = $('#payment_month').val();
                let payment_year = $('#payment_year').val();
                let payment_cvc = $('#payment_cvc').val();

                if (holder_name == "") {
                    let msg =  `<div class="d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                        </svg> 
                        <span class="ps-2">
                            The Holder Name field is requied
                        </span>
                    </div>`;
                    $(".holder_name_err_msg").html(msg);
                    $(".holder_name_err_msg_contnr").show(200);
                    error = true;
                }else{
                    $(".holder_name_err_msg").html('');
                    $(".holder_name_err_msg_contnr").hide(200);
                }
                if (credit_card_no == "") {
                    let msg =  `<div class="d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                        </svg> 
                        <span class="ps-2">
                            The Credit Card No field is requied
                        </span>
                    </div>`;
                    $(".credit_card_no_err_msg").html(msg);
                    $(".credit_card_no_err_msg_contnr").show(200);
                    error = true;
                }else{
                    $(".credit_card_no_err_msg").html('');
                    $(".credit_card_no_err_msg_contnr").hide(200);
                }
                if (payment_month == "") {
                    let msg =  `<div class="d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                        </svg> 
                        <span class="ps-2">
                            The Payment Month field is requied
                        </span>
                    </div>`;
                    $(".payment_month_err_msg").html(msg);
                    $(".payment_month_err_msg_contnr").show(200);
                    error = true;
                }else{
                    $(".payment_month_err_msg").html('');
                    $(".payment_month_err_msg_contnr").hide(200);
                }
                if (payment_year == "") {
                    let msg =  `<div class="d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                        </svg> 
                        <span class="ps-2">
                            The Payment Year field is requied
                        </span>
                    </div>`;
                    $(".payment_year_err_msg").html(msg);
                    $(".payment_year_err_msg_contnr").show(200);
                    error = true;
                }else{
                    $(".payment_year_err_msg").html('');
                    $(".payment_year_err_msg_contnr").hide(200);
                }
                if (payment_cvc == "") {
                    let msg =  `<div class="d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                        </svg> 
                        <span class="ps-2">
                            The Payment CVC field is requied
                        </span>
                    </div>`;
                    $(".payment_cvc_err_msg").html(msg);
                    $(".payment_cvc_err_msg_contnr").show(200);
                    error = true;
                }else{
                    $(".payment_cvc_err_msg").html('');
                    $(".payment_cvc_err_msg_contnr").hide(200);
                }
            }
        }

        if (error == true) {
            return false;
        }
    });



    
    $(document).on("click", ".pay_button", function () {
        // Card Payment info
        let holder_name = $("#holder_name").val();
        let credit_card_no = $("#credit_card_no").val();
        let payment_month = $("#payment_month").val();
        let payment_year = $("#payment_year").val();
        let payment_cvc = $("#payment_cvc").val();
        let account_type = $('option:selected', '#payment_mothod').val();

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
            let plan_id = $('#plan_id').find(":selected").val();
            $.ajax({
                url: base_url + "Authentication/stripeMainPayment",
                method: "POST",
                data: {
                    token: token,
                    plan_id: plan_id,
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
                        $('.signup-btn').show(200);
                        $('.login-button').click();
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
        let plan_id = $('#plan_id').find(":selected").val();
        $.ajax({
            url: base_url + "Authentication/paypalMainPayment",
            method: "POST",
            data: {
                info : info,
                plan_id: plan_id,
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
                    $('.signup-btn').show(200);
                    $('.login-button').click();
                } else {
                    toastr["error"]("Something Went Wrong! Maybe Wrong Credentials!", "");
                    paypalPayementStatus = false;
                }
            },
        });
    }

});