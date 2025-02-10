$(function () {
    "use strict";

    let APPLICATION_SaaS_TYPE = $('#APPLICATION_SaaS_TYPE').val();
    let APPLICATION_MODE = $('#APPLICATION_MODE').val();

    if(APPLICATION_SaaS_TYPE && APPLICATION_MODE == 'demo'){
        $(document).on('change', '.login_radio', function(){
            let selectedValue = $('input[name="login-radio-group"]:checked').val();
            if(selectedValue == 'Sass Admin'){
                $('#phone_number').val('admin@doorsoft.co');
                $('.password').val('123456');
            }else if(selectedValue == 'Shop Admin'){
                $('#phone_number').val('shop_admin@gmail.com');
                $('.password').val('123456');
            }
        });
    
        $(document).on('click', '.login_trigger', function(){
            let selectedValue = $('input[name="login-radio-group"]:checked').val();
            let error = false;
            if(selectedValue == undefined){
                error = true;
                $('.input-container_custom').html(`
                    <div class="alert alert-danger alert-dismissible"> 
                        <a type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></a>
                        <div class="alert-body">
                            <i class="icon fa fa-times"></i> Please login a type.
                        </div>
                    </div>`);
                setTimeout(function(){
                    $('.input-container_custom').html('');
                }, 2000)
            }
            if(error){
                return false;
            }1366
        });
    }else if(APPLICATION_MODE == 'demo'){
        $('#phone_number').val('admin@doorsoft.co');
        $('.password').val('123456');
    }

    $(document).on('click', '.view_ctrl', function(){
        let passType = $(this).parent().find('.password').attr('type');
        if(passType == 'password'){
            $(this).parent().find('.password').attr('type', 'text');
            $(this).children().attr('icon', 'solar:eye-broken');
            
        }else{
            $(this).parent().find('.password').attr('type', 'password');
            $(this).children().attr('icon', 'solar:password-broken');
        }
    });

    

});

