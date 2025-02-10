$(function($) {
    "use strict";

    let currency = $('#currency_').val();
    let base_url = $('#base_url_').val();
    let op_precision = $("#op_precision").val();
    let i_sale = $("#i_sale_").val();
    let opening_balance_ln = $("#opening_balance").val();
    let paid_amount_ln = $("#paid_amount").val();
    let sale_ln = $("#sale_text").val();
    let customer_due_receive_ln = $("#customer_due_receive").val();
    let total_purchases_ln = $("#total_purchases").val();
    let total_purchase_return_ln = $("#total_purchase_return").val();
    let total_sale_return_ln = $("#total_sale_return").val();
    let total_expense_ln = $("#total_expense").val();
    let in_ln = $("#in_ln").val();
    let down_payment_ln = $("#down_payment").val();
    let installment_paid_amount_ln = $("#installment_paid_amount_text").val();
    let warning = $("#warning").val();
    let yes = $("#yes").val();
    let not_closed_yet = $("#not_closed_yet").val();
    let cancel = $("#cancel").val();
    let are_you_sure = $("#are_you_sure").val();
    let dummy_data_delete_alert = $("#dummy_data_delete_alert").val();
    let no_permission_for_this_module = $('#no_permission_for_this_module').val();
    let ok = $("#ok").val();

    $('.select2').select2();


    $(document).on("click", ".delete", function(e) {
        e.preventDefault();
        let linkURL = this.href;
        warnBeforeRedirect(linkURL);
    });
    
    function warnBeforeRedirect(linkURL) {
        Swal.fire({
            title: warning + "!",
            text: are_you_sure,
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: yes,
            denyButtonText: cancel,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                window.location.href = linkURL;
            }
        });
    }

    $(document).on("click", ".add_dummy_data", function(e) {
        e.preventDefault();
        let linkURL = this.href;
        warnBeforeRedirectDummyData(linkURL);
    });

    function warnBeforeRedirectDummyData(linkURL) {
        Swal.fire({
            title: warning + "!",
            text: dummy_data_delete_alert,
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: yes,
            denyButtonText: cancel,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                window.location.href = linkURL;
            }
        });
    }

    $(document).on('click', '.user-info-box .user-avatar', function(){
        $(".user_profile_active").toggle();
    });
    $(document).on('click', function(e) {
        let menu = $('.user_profile_active');
        let toggleBtn = $('.user-info-box .user-avatar');
        if (!menu.is(e.target) && !toggleBtn.is(e.target) && menu.has(e.target).length === 0) {
            menu.hide();
        }
    });


    $(document).on('click', '.show-drop-result span', function(){
        $(".lang-dropdown-active").toggle();
    });
    $(document).on('click', function(e) {
        let menu = $('.lang-dropdown-active');
        let toggleBtn = $('.show-drop-result span');
        if (!menu.is(e.target) && !toggleBtn.is(e.target) && menu.has(e.target).length === 0) {
            menu.hide();
        }
    });
    $(document).on('keydown', '.integerchk', function(e){
        let keys = e.charCode || e.keyCode || 0;
        return (
        keys == 8 ||
            keys == 9 ||
            keys == 13 ||
            keys == 46 ||
            keys == 110 ||
            keys == 86 ||
            keys == 190 ||
            (keys >= 35 && keys <= 40) ||
            (keys >= 48 && keys <= 57) ||
            (keys >= 96 && keys <= 105));
    });
    $(document).on('keyup', '.integerchk', function(e){
        let input = $(this).val();
        let ponto = input.split('.').length;
        let slash = input.split('-').length;
        if (ponto > 2)
            $(this).val(input.substr(0,(input.length)-1));
        $(this).val(input.replace(/[^0-9]/,''));
        if(slash > 2)
            $(this).val(input.substr(0,(input.length)-1));
        if (ponto ==2)
            $(this).val(input.substr(0,(input.indexOf('.')+3)));
        if(input == '.')
            $(this).val("");

    });
    //Date picker
    $('#date').datepicker({
        format: 'dd-mm-yyyy',
        /*format: 'yyyy-mm-dd',*/
        autoclose: true
    });
    $('#dates2').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
    });
    $('.customDatepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
    });
    $(".datepicker_months").datepicker({
        format: 'yyyy-M',
        autoclose: true,
        viewMode: "months",
        minViewMode: "months"
    });
    let today = new Date();
    let dd = today.getDate();
    let mm = today.getMonth()+1; //January is 0!
    let yyyy = today.getFullYear();
    if(dd<10) {
        dd = '0'+dd;
    }
    if(mm<10) {
        mm = '0'+mm;
    }
    today = yyyy + '-' + mm + '-' + dd;


    feather.replace();
    $('table').addClass('table-responsive').removeClass('table-bordered');
    let window_height = $(window).height();
    let main_header_height = $('.main-header').height();
    let user_panel_height = $('.user-panel').height();
    let left_menu_height_should_be = (parseFloat(window_height)-(parseFloat(main_header_height)+parseFloat(user_panel_height))).toFixed(2);
    left_menu_height_should_be = (parseFloat(left_menu_height_should_be)-parseFloat(60)).toFixed(2);
    $.ajax({
        url: base_url+'Register/checkRegisterAjax',
        method:"POST",
        success:function(response) {
            if(response == '2'){
                $('#close_register_button').css('display','none');
            }else{
                $('#close_register_button').css('display','block');
            }
        }
    });

    $(document).on('click', '.notif_class', function(e){
        let value = $(this).attr('data-value');
        if(value==1){
            $(".width_notification").show();
            $(this).attr('data-value',2);
        }else{
            $(".width_notification").hide();
            $(this).attr('data-value',1);
        }

    });

    $('#register_details').on('click',function(e){
        e.preventDefault();
        $.ajax({
            url: base_url+'Sale/registerDetailCalculationToShowAjax',
            method:"POST",
            success:function(response) {
                if(!IsJsonString(response)){
                    let r = confirm("Register is not open, do you want to open register?");
                    if (r == true) {
                        window.location.replace(base_url+'Register/openRegister');
                    }
                    return false;
                }

                response = JSON.parse(response);
                $('#myModal').modal('show');
                $('#opening_closing_register_time').show();
                $('#opening_register_time').html(response.opening_date_time);


                let t1 = response.opening_date_time.split(/[- :]/);
                let d1 = new Date(Date.UTC(t1[0], t1[1]-1, t1[2], t1[3], t1[4], t1[5]));
                let t2 = response.closing_date_time.split(/[- :]/);
                let d2 = new Date(Date.UTC(t2[0], t2[1]-1, t2[2], t2[3], t2[4], t2[5]));

                if(d1>d2){
                    $('#closing_register_time').html(not_closed_yet);
                }else{
                    $('#closing_register_time').html(response.closing_date_time);
                }
                let register_detail_modal_content = '';
                let customer_due_receive = (response.customer_due_receive==null)?0:response.customer_due_receive;
                let total_purchases = (response.total_purchase==null)?0:response.total_purchase;
                let total_purchase_return = (response.total_purchase_return==null)?0:response.total_purchase_return;
                let total_sale_return = (response.total_sale_return==null)?0:response.total_sale_return;
                let total_expense = (response.total_expense==null)?0:response.total_expense;
                let opening_balance = (response.opening_balance==null)?0:response.opening_balance;
                let sale_due_amount = (response.sale_due_amount==null)?0:response.sale_due_amount;
                let sale_in_card = (response.sale_in_card==null)?0:response.sale_in_card;
                let sale_in_cash = (response.sale_in_cash==null)?0:response.sale_in_cash;
                let sale_in_paypal = (response.sale_in_paypal==null)?0:response.sale_in_paypal;
                let sale_paid_amount = (response.sale_paid_amount==null)?0:response.sale_paid_amount;
                let sale_total_payable_amount = (response.sale_total_payable_amount==null)?0:response.sale_total_payable_amount;
                let down_payment_r = (response.down_payment==null)?0:response.down_payment;
                let installment_paid_amount_r = (response.installment_paid_amount==null)?0:response.installment_paid_amount;
                let total_down_payment_r = 0;
                let total_installment_paid_amount_r = 0;
                if(i_sale=="Yes"){
                        total_down_payment_r = down_payment_r;
                        total_installment_paid_amount_r = installment_paid_amount_r;
                }
                let balance = (parseFloat(opening_balance)+parseFloat(total_installment_paid_amount_r)+parseFloat(total_down_payment_r)+parseFloat(sale_paid_amount)+parseFloat(customer_due_receive)-parseFloat(total_purchases)-parseFloat(total_purchase_return)+parseFloat(total_sale_return)-parseFloat(total_expense)).toFixed(2);
                register_detail_modal_content += '<p>'+opening_balance_ln+': '+currency+' '+opening_balance+'</p>';
                register_detail_modal_content += '<p>'+sale_ln+' ('+paid_amount_ln+'): '+currency+' '+sale_paid_amount+'</p>';
                register_detail_modal_content += '<p>'+customer_due_receive_ln+': '+currency+' '+customer_due_receive+'</p>';
                register_detail_modal_content += '<p>'+total_purchases_ln+': '+currency+' '+total_purchases+'</p>';
                register_detail_modal_content += '<p>'+total_purchase_return_ln+': '+currency+' '+total_purchase_return+'</p>';
                register_detail_modal_content += '<p>'+total_sale_return_ln+': '+currency+' '+total_sale_return+'</p>';
                register_detail_modal_content += '<p>'+total_expense_ln+': '+currency+' '+total_expense+'</p>';

                if(i_sale=="Yes"){
                    register_detail_modal_content += '<p>'+down_payment_ln +': '+currency+' '+down_payment_r+'</p>';
                    register_detail_modal_content += '<p>'+installment_paid_amount_ln+': '+currency+' '+installment_paid_amount_r+'</p>';
                    register_detail_modal_content += '<p>Balance {'+opening_balance_ln+' '+sale_ln+' ('+paid_amount_ln+') '+customer_due_receive_ln+' - '+total_purchases_ln+' - '+total_purchase_return_ln+ '-' +total_sale_return_ln+ total_expense_ln + down_payment_ln + installment_paid_amount_ln + '}:' +currency+' '+balance+'</p>';
                }else{
                    register_detail_modal_content += '<p>Balance {' + opening_balance_ln + ' - ' + sale_ln + ' (' + paid_amount_ln + ')' +customer_due_receive_ln + ' - ' + total_purchases_ln + ' - ' + total_purchase_return_ln + ' ' + total_sale_return_ln + total_expense_ln +'}:'+ currency+' '+balance+'</p>';
                }

                register_detail_modal_content += '<p class="op_width_100_p op_line_height_0 op_border_bottom_pale_cornflower_blue">&nbsp;</p>';


                $.each(response.payments, function (index, value) {
                    register_detail_modal_content += '<p>'+sale_ln+ '' +in_ln+ ' ' +value.name+': '+currency+' '+value.amount+'</p>';
                });

                $('#register_details_body').html(register_detail_modal_content);

            },
            error:function(){
                alert("error");
            }
        });
    });

    $('#register_close').on('click',function(){
        let r = confirm("Are you sure to close register?");
        if (r == true) {
            $.ajax({
                url: base_url+'Sale/closeRegister',
                method:"POST",
                success:function(response) {
                    Swal.fire({
                        title: 'Alert' + "!",
                        text: "Register Closed Successfully !",
                        showDenyButton: false,
                        showCancelButton: false,
                        confirmButtonText: "OK",
                    });
                    $('#close_register_button').hide();
                },
                error:function(){
                    alert("error");
                }
            });
        }
    });

    function IsJsonString(str) {
        try {
            JSON.parse(str);
        } catch (e) {
            return false;
        }
        return true;
    }
    function todaysSummary() {
        $.ajax({
            url     : base_url+'Report/todayReport',
            method  : 'GET',
            dataType: 'JSON',
            data    : {},
            success:function(data){
                $("#purchase").text(currency + data.total_purchase_amount);
                $("#sale").text(currency +data.total_sales_amount);
                $("#totalVat").text(currency +data.total_sales_vat);
                $("#Expense").text(currency +data.expense_amount);
                $("#supplierDuePayment").text(currency +data.supplier_payment_amount);
                $("#customerDueReceive").text(currency +data.customer_receive_amount);
                $("#purchaseReturn").text(currency +data.purchase_return);
                $("#saleReturn").text(currency +data.sale_return);
                $("#waste").text(currency +data.total_loss_amount);
                $("#balance").text(currency +data.balance);
                $("#down_payment").text(currency +data.down_payment);
                $("#installment_paid_amount").text(currency +data.installment_paid_amount);
                $.ajax({
                    url     : base_url+'Report/todayReportCashStatus',
                    method  : 'GET',
                    datatype: 'JSON',
                    data    : {},
                    success:function(data){
                        let json = $.parseJSON(data);
                        let i = 1;
                        let html = '<table class="table">';
                        $.each(json, function (index, value) {
                            html+='<tr><td class="op_width_86">'+i+'. Sale in '+value.name+'</td> <td>'+currency+' '+value.total_sales_amount+'</td></tr>';
                            i++;
                        });
                        html+='</table>';
                        $("#showCashStatus").html(html);
                    }
                });
            }
        });
        $("#todaysSummary").modal("show");
    }

    function changeStatus(id) {
        $.ajax({
            url     : base_url+'Ajax/change_status_notification',
            method  : 'GET',
            dataType: 'JSON',
            data    : {
                'id' : id
            },
            success : function(data) {
                $('#id_'+id).css("background-color", "transparent");
                $('#totalNotifications').html(data.total_unread);
            },
            error   : function() {
                alert('something is wrong!');
            }
        });
    }
    function delete_row(id) {
        $.ajax({
            url     : base_url+'Ajax/delete_row_notification',
            method  : 'GET',
            dataType: 'JSON',
            data    : {
            'id' : id
            },
            success : function(data) {
                $('#id_'+id).remove();
                $('#totalNotifications').html(data.total_unread);
            },
            error   : function() {
                alert('something is wrong!');
            }
        });
    }

    $(document).on('click', '#save_and_add_more', function(){
        $('#set_save_and_add_more').val('add_more');
    });

    $(document).on('click', '.logOutTrigger', function(){
        let register_status = $('#register_status').val();
        if(register_status == '1'){
            Swal.fire({
                title: "Warning!",
                text: "Your Register is not close!",
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: "Not Now!",
                denyButtonText: `Close Now?`
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: base_url+"Authentication/logOut",
                        success: function (response) {
                            window.location.href = base_url + "Authentication/index"; 
                        }
                    });
                } else if (result.isDenied) {
                    $.ajax({
                        url: base_url + "Sale/closeRegister",
                        method: "POST",
                        success: function (response) {
                            $.ajax({
                                type: "POST",
                                url: base_url+"Authentication/logOut",
                                success: function (response) {
                                    window.location.href = base_url + "Authentication/index"; 
                                }
                            });
                        },
                        error: function () {
                            alert("error");
                        },
                    });
                }
            });


        }else{
            $.ajax({
                type: "POST",
                url: base_url+"Authentication/logOut",
                success: function (response) {
                    window.location.href = base_url + "Authentication/index"; 
                }
            }); 
        }
    });

    $(document).on('click', '.todays_summary_trigger', function(){
        jQuery('#todaysSummary').modal('show');
        $.ajax({
            type: "GET",
            url: base_url+"Sale/todaysSummary",
            success: function (response) {
                if(response.status == 'success'){

                    let todaysPurchase = 0;
                    let todaysSales = 0;
                    let todaysExpense = 0;
                    let todaysSupplierPayment = 0;
                    let todaysCustomerReceive = 0;
                    let todaysPurchaseReturn = 0;
                    let todaysSaleReturn = 0;
                    let todaysDamage = 0;
                    let todaysDownpayment = 0;
                    let todaysInstallmentPaid = 0;

                    if(response.data.todaysPurchase){
                        $('#todaysSummary #purchase').text(parseFloat(response.data.todaysPurchase).toFixed(op_precision));
                        todaysPurchase = response.data.todaysPurchase;
                    }else{
                        $('#todaysSummary #purchase').text(parseFloat(0).toFixed(op_precision));
                        todaysPurchase = 0;
                    }
                    if(response.data.todaysSales){
                        $('#todaysSummary #sale').text(parseFloat(response.data.todaysSales).toFixed(op_precision));
                        todaysSales = response.data.todaysSales;
                    }else{
                        $('#todaysSummary #sale').text(parseFloat(0).toFixed(op_precision));
                        todaysSales = 0;
                    }
                    if(response.data.todaysExpense){
                        $('#todaysSummary #Expense').text(parseFloat(response.data.todaysExpense).toFixed(op_precision));
                        todaysExpense = response.data.todaysExpense;
                    }else{
                        $('#todaysSummary #Expense').text(parseFloat(0).toFixed(op_precision));
                        todaysExpense = 0;
                    }
                    if(response.data.todaysSupplierPayment){
                        $('#todaysSummary #supplierDuePayment').text(parseFloat(response.data.todaysSupplierPayment).toFixed(op_precision));
                        todaysSupplierPayment = response.data.todaysSupplierPayment;
                    }else{
                        $('#todaysSummary #supplierDuePayment').text(parseFloat(0).toFixed(op_precision));
                        todaysSupplierPayment = 0;
                    }
                    if(response.data.todaysCustomerReceive){
                        $('#todaysSummary #customerDueReceive').text(parseFloat(response.data.todaysCustomerReceive).toFixed(op_precision));
                        todaysCustomerReceive = response.data.todaysCustomerReceive;
                    }else{
                        $('#todaysSummary #customerDueReceive').text(parseFloat(0).toFixed(op_precision));
                        todaysCustomerReceive = 0;
                    }
                    if(response.data.todaysPurchaseReturn){
                        $('#todaysSummary #purchaseReturn').text(parseFloat(response.data.todaysPurchaseReturn).toFixed(op_precision));
                        todaysPurchaseReturn = response.data.todaysPurchaseReturn;
                    }else{
                        $('#todaysSummary #purchaseReturn').text(parseFloat(0).toFixed(op_precision));
                        todaysPurchaseReturn = 0;
                    }
                    if(response.data.todaysSaleReturn){
                        $('#todaysSummary #saleReturn').text(parseFloat(response.data.todaysSaleReturn).toFixed(op_precision));
                        todaysSaleReturn = response.data.todaysSaleReturn;
                    }else{
                        $('#todaysSummary #saleReturn').text(parseFloat(0).toFixed(op_precision));
                        todaysSaleReturn = 0;
                    }
                    if(response.data.todaysDamage){
                        $('#todaysSummary #waste').text(parseFloat(response.data.todaysDamage).toFixed(op_precision));
                        todaysDamage = response.data.todaysDamage;
                    }else{
                        $('#todaysSummary #waste').text(parseFloat(0).toFixed(op_precision));
                        todaysDamage = 0;
                    }
                    if(i_sale == "Yes"){
                        if(response.data.todaysDownpayment){
                            $('#todaysSummary #down_payment_today_summery').text(parseFloat(response.data.todaysDownpayment).toFixed(op_precision));
                            todaysDownpayment = response.data.todaysDownpayment;
                        }else{
                            $('#todaysSummary #down_payment_today_summery').text(parseFloat(0).toFixed(op_precision));
                            todaysDownpayment = 0;
                        }
                        if(response.data.todaysInstallmentPaid){
                            $('#todaysSummary #installment_paid_amount').text(parseFloat(response.data.todaysInstallmentPaid).toFixed(op_precision));
                            todaysInstallmentPaid = response.data.todaysInstallmentPaid;
                        }else{
                            $('#todaysSummary #installment_paid_amount').text(parseFloat(0).toFixed(op_precision));
                            todaysInstallmentPaid = 0;
                        }
                    }
                    let balance = (todaysSales + todaysCustomerReceive + todaysDownpayment + todaysInstallmentPaid + todaysPurchaseReturn) - (todaysPurchase + todaysSupplierPayment + todaysExpense + todaysDamage + todaysSaleReturn)
                    $('#todaysSummary #balance').text(parseFloat(balance).toFixed(op_precision));
                }
            }
        });
    });

    $(document).on('click', '.quick_menus_trigger', function(){
        jQuery('#quick_menus').modal('show');
    });

    // Tooltip Call
    tippy('.tippyBtnCall', {
        theme: 'light',
        placement: 'bottom',
        animation: 'fade',
        allowHTML: true,
    });
//auto scroll on active menu
$(window).on("load", function () {
  
    // Get the active link in the sidebar
    const activeLink = $(".sidebar-menu li.active");
  
    // Check if the active link exists
    if (activeLink.length) {
      // Get the top offset of the active link
      const offsetTop = activeLink.offset().top - 400;
  
      $(".sidebar-menu").animate({
          scrollTop: offsetTop,
        },1000
      );
    }
  
  });



    function getNotification(){
        $.ajax({
            method: "POST",
            url: base_url+"Notification/notificationsAjax",
            success: function (response) {
                if(response.status == 'success'){
                    let notification = '';
                    $.each(response.data, function (i, v) { 
                        notification += `<div class="overflow-y-auto px-2">
                        <div class="relative ${v.read_status == '0' ? 'bg-unread' : ''} w-full mt-1 rounded-md overflow-hidden border-2 border-gray-100 box_notification">
                            <div class="d-flex">
                                <div class="icon">
                                    <iconify-icon icon="ic:baseline-email" width="22"></iconify-icon>
                                </div>
                                <div class="pl-3">
                                    <a href="javascript:void(0)" class="single-notification">
                                        <p class="text-gray-600 text-sm leading-tight font-bold">
                                            ${v.notifications_details}
                                        </p>                                                        
                                    </a>
                                </div>
                            </div>
                        </div>                                            
                    </div>` 
                    });
                    $('#all_notifications_show_div').html('');
                    $('#all_notifications_show_div').append(notification);
                    $('#notification-bell-count').text(response.count);
                }
            }
        });

    }

    
    function showUnreadNotification(){
        $.ajax({
            method: "POST",
            url: base_url+"Notification/unreadNotificationsAjax",
            success: function (response) {
                if(response.status == 'success'){
                    let notification = '';
                    $.each(response.data, function (i, v) { 
                        notification += `<div class="overflow-y-auto px-2">
                        <div class="relative ${v.read_status == '0' ? 'bg-unread' : ''} w-full mt-1 rounded-md overflow-hidden border-2 border-gray-100 box_notification">
                            <div class="d-flex">
                                <div class="icon">
                                    <iconify-icon icon="ic:baseline-email" width="22"></iconify-icon>
                                </div>
                                <div class="pl-3">
                                    <a href="javascript:void(0)" class="single-notification">
                                        <p class="text-gray-600 text-sm leading-tight font-bold">
                                            ${v.notifications_details}
                                        </p>                                                        
                                    </a>
                                </div>
                            </div>
                            <div class="dropdown-notifications-actions w-10">
                                <div class="d-flex">
                                    <a href="javascript:void(0)" class="dropdown-notifications-archive read_notification" data-id="${v.id}" data-read-status="${v.read_status == '0' ? '0' : '1'}">
                                        <iconify-icon icon="${v.read_status == '0' ? 'solar:eye-bold-duotone' : 'solar:eye-broken'}" width="18"></iconify-icon>
                                    </a>
                                    <a href="javascript:void(0)" class="dropdown-notifications-archive remove-single-notification" data-id="${v.id}">
                                        <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="18"></iconify-icon>
                                    </a>
                                </div>
                            </div>
                        </div>                                            
                    </div>` 
                    });
                    $('#all_notifications_show_div').html('');
                    $('#all_notifications_show_div').append(notification);
                }
            }
        });
    }

    $(document).on('click', '.notification_bell_icon_', function(){
        $.ajax({
            url: base_url + "Master/checkAccess",
            method: "GET",
            async: false,
            dataType: 'json',
            data: { controller: "320", function: "list" },
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
                    getNotification();
                }
            }
        });
    });
    $(document).on('click', '.mark-all-as-read', function(){
        $.ajax({
            url: base_url + "Master/checkAccess",
            method: "GET",
            async: false,
            dataType: 'json',
            data: { controller: "320", function: "marakAllAsRead" },
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
                    $.ajax({
                        method: "POST",
                        url: base_url+"Notification/markAsAllReadNotificationsAjax",
                        success: function (response) {
                            if(response.status == 'success'){
                                getNotification();
                            }
                        }
                    });
                }
            }
        });
    });
    $(document).on('change', '.notification-check', function() {
        let isChecked = $(this).prop('checked');
        $.ajax({
            url: base_url + "Master/checkAccess",
            method: "GET",
            async: false,
            dataType: 'json',
            data: { controller: "320", function: "unreadList" },
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
                    if(isChecked){
                        showUnreadNotification();
                    } else{
                        getNotification();
                    }
                }
            }
        });
    });
    $(document).on('click', '.remove-single-notification', function() {
        let notification_id = $(this).attr('data-id');
        $.ajax({
            url: base_url + "Master/checkAccess",
            method: "GET",
            async: false,
            dataType: 'json',
            data: { controller: "320", function: "delete" },
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
                    $.ajax({
                        type: "POST",
                        url: base_url+"Notification/deleteNotificationsAjax",
                        data: {
                            notification_id: notification_id,
                        },
                        success: function (response) {
                            if(response.status == 'success'){
                                getNotification();
                            }
                        }
                    });
                }
            }
        });
    });
    $(document).on('click', '.read_notification', function() {
        let notification_id = $(this).attr('data-id');
        let read_status = $(this).attr('data-read-status');
        $.ajax({
            url: base_url + "Master/checkAccess",
            method: "GET",
            async: false,
            dataType: 'json',
            data: { controller: "320", function: "marakAllAsRead" },
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
                    $.ajax({
                        type: "POST",
                        url: base_url+"Notification/readNotification",
                        data: {
                            notification_id: notification_id,
                            read_status: read_status,
                        },
                        success: function (response) {
                            if(response.status == 'success'){
                                getNotification();
                            }
                        }
                    });
                }
            }
        });
    });
    $(document).on('click', '.read_notification', function() {
        let notification_id = $(this).attr('data-id');
        let read_status = $(this).attr('data-read-status');
        $.ajax({
            url: base_url + "Master/checkAccess",
            method: "GET",
            async: false,
            dataType: 'json',
            data: { controller: "320", function: "marakAllAsRead" },
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
                    $.ajax({
                        type: "POST",
                        url: base_url+"Notification/readNotification",
                        data: {
                            notification_id: notification_id,
                            read_status: read_status,
                        },
                        success: function (response) {
                            if(response.status == 'success'){
                                getNotification();
                            }
                        }
                    });
                }
            }
        });
    });

    $(document).on('click', '.outlet_delete', function(e){
        e.preventDefault();
        let linkURL = this.href;
        warnAgainToDelete(linkURL);
    });
    function warnAgainToDelete(linkURL) {
        Swal.fire({
            title: "Alert!",
            text: "Are you sure!",
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: "Yes",
            denyButtonText: `Cancel`
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Warning Again !",
                    text: "Final Confirmation Before Delete",
                    showDenyButton: true,
                    showCancelButton: false,
                    confirmButtonText: "Yes",
                    denyButtonText: `Cancel`
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        window.location.href = linkURL;
                    }
                });
            }
        });

    }




    // Menu Access
    $(".menu_assign_class").each(function() {
        let this_access = $(this).attr("data-access");
        if((window.menu_objects).indexOf(this_access) > -1) {
        } else {
            if(this_access!=undefined){
                $(this).remove();
            }
        }
    });
    // Menu Access
    $(".menu_assign_class_").each(function() {
        $(this).remove();
    });



    // Menu Access
    $(".menu_assign_class").each(function() {
        let this_access = $(this).attr("module-is-hide");
        let element = $(this);  // Store the current element reference
        $.each(window.module_objects, function(index, value) {
            if (value == this_access) {
                element.remove();  // Use the stored reference
            }
        });
    });

    $('.treeview-menu').each(function(){
        let html_content = $(this).html().trim(); // Trim to remove any extra whitespace
        if(html_content === ''){
            $(this).parent().remove(); // Remove the parent if the content is empty
        }
    });




    // Get modal and buttons
    const modal = $("#message-modal");
    const openModalBtn = $("#message-modal-t");
    const closeModalBtn = $("#closeModalBtn");
    setTimeout(function(){
        modal.show();
    }, 1000)
    // Close modal on close button click
    closeModalBtn.on("click", function() {
        modal.hide();
    });
    // Close modal when clicking outside of the modal content


    function disableDevTools() {
        // Disable context menu
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
        }, false);
        // Disable various key combinations and F12
        document.addEventListener('keydown', function(e) {
            // Disable Ctrl+Shift+I (Open DevTools)
            if (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'i')) {
                e.preventDefault();
                return false;
            }
            // Disable Ctrl+Shift+C (Open DevTools in element inspection mode)
            if (e.ctrlKey && e.shiftKey && (e.key === 'C' || e.key === 'c')) {
                e.preventDefault();
                return false;
            }
            // Disable Ctrl+U (View Source)
            if (e.ctrlKey && (e.key === 'U' || e.key === 'u')) {
                e.preventDefault();
                return false;
            }
            // Disable F12 (Open DevTools)
            if (e.key === 'F12') {
                e.preventDefault();
                return false;
            }
        }, false);
        // Disable right-click
        document.addEventListener('mousedown', function(e) {
            if (e.button === 2) {
                e.preventDefault();
                return false;
            }
        }, false);
        // Attempt to detect if DevTools is open
        setInterval(function() {
            const widthThreshold = window.outerWidth - window.innerWidth > 160;
            const heightThreshold = window.outerHeight - window.innerHeight > 160;
            if (widthThreshold || heightThreshold) {
                // DevTools is likely open, you can add custom behavior here
                console.clear();
                alert("Developer tools are not allowed on this page.");
            }
        }, 1000);
    }
    // Call the function to disable developer tools
    // disableDevTools();




});