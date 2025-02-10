$(function () {
    "use strict"
    let stripePayementStatus = false;
    let paypalPayementStatus = false;
    toastr.options = {
        positionClass: 'toast-bottom-right'
    };
    const ps = new PerfectScrollbar(".pos__menu__list", {
        wheelSpeed: 2,
        wheelPropagation: true,
        minScrollbarLength: 20,
    });
    ps.update();
    const br = new PerfectScrollbar(".brand__sub__menu", {
        wheelSpeed: 2,
        wheelPropagation: true,
        minScrollbarLength: 20,
    });
    br.update();
    let no_permission_for_this_module = $('#no_permission_for_this_module').val();
    let pharmacy_search_place_holder_pos = $('#pharmacy_search_place_holder_pos').val();
    let other_search_place_holder_pos = $('#other_search_place_holder_pos').val();
    let The = $('#The').val();
    let field_is_required = $('#field_is_required').val();
    let The_discount_code_field_required = $('#The_discount_code_field_required').val();
    let The_coupon_code_field_required = $('#The_coupon_code_field_required').val();
    let print_format = $('#print_format').val();
    let invoice_print = $('#invoice_print').val();
    let Place_Order = $("#Place_Order").val();
    let direct_cart = $("#direct_cart").val();
    let base_url = $('#base_url').val();
    let warning = $('#alert').val();
    let phone_ln = $('#phone_ln').val();
    let email_ln = $('#email_ln').val();
    let ok = $('#ok').val();
    let yes = $('#yes').val();
    let cancel = $('#cancel').val();
    let sure_delete_this_sale = $('#sure_delete_this_sale').val();
    let no_access = $('#no_access').val();
    let default_cursor_position = $('#default_cursor_position').val();
    let please_select_an_order = $('#please_select_an_order').val();
    let please_select_hold_sale = $('#please_select_hold_sale').val();
    let sure_delete_this_hold = $('#sure_delete_this_hold').val();
    let are_you_delete_all_hold_sale = $('#are_you_delete_all_hold_sale').val();
    let no_hold = $('#no_hold').val();
    let select_a_customer = $('#select_a_customer').val();
    let edit_warning = $('#edit_warning').val();
    let collect_tax = $('#collect_tax').val();
    let collect_gst = $('#tax_is_gst').val();
    let gst_state_code = $('#gst_state_code').val();
    let csrf_value_ = $("#csrf_value_").val();
    let op_precision = $("#op_precision").val();
    let op_decimals_separator = $("#op_decimals_separator").val();
    let op_thousands_separator = $("#op_thousands_separator").val();
    let allow_less_sale = $("#allow_less_sale").val();
    let check_issue_date_lan = $("#check_issue_date_lan").val();
    let check_no_lan = $("#check_no_lan").val();
    let check_expiry_date_lan = $("#check_expiry_date_lan").val();
    let mobile_no_lan = $("#mobile_no_lan").val();
    let transaction_no_lan = $("#transaction_no_lan").val();
    let card_holder_name_lan = $("#card_holder_name_lan").val();
    let card_holding_number_lan = $("#card_holding_number_lan").val();
    let paypal_email_lan = $("#paypal_email_lan").val();
    let stripe_email_lan = $("#stripe_email_lan").val();
    let note_lan = $("#note_lan").val();
    let cart_empty = $("#cart_empty").val();
    let sms_enable_status = $("#sms_enable_status").val();
    let smtp_enable_status = $("#smtp_enable_status").val();
    let send_invoice_whatsapp = $("#send_invoice_whatsapp").val();
    let product_display = $("#product_display").val();
    let dummy_data_delete_alert = $("#dummy_data_delete_alert").val();
    let select = $("#select").val();
    let customer = $("#customer").val();
    let edit_mode = $("#old_sale_id").val();
    let session_uer_id = $("#session_uer_id").val();
    let role = $("#role").val();
    let grocery_experience = $("#grocery_experience").val();
    let view_purchase_price = $("#view_purchase_price").val();
    let Alternative_Medicine_will_shown_here = $("#Alternative_Medicine_will_shown_here").val();
    let already_added = $("#already_added").val();
    let default_customer = $("#default_customer").val();
    let edit_sale_customer = Number($("#edit_sale_customer").val());
    let invoice_logo_session = $("#invoice_logo_session").val(); 
    let business_name = $("#business_name").val(); 
    let outlet_address = $("#outlet_address").val(); 
    let outlet_name = $("#outlet_name").val(); 
    let outlet_id = $("#outlet_id").val(); 
    let outlet_email = $("#outlet_email").val(); 
    let outlet_phone = $("#outlet_phone").val(); 
    let tax_title = $("#tax_title").val(); 
    let tax_registration_no = $("#tax_registration_no").val(); 
    let invoice_ln = $("#invoice_ln").val(); 
    let bill_to_ln = $("#bill_to_ln").val(); 
    let invoice_no_ln = $("#invoice_no_ln").val(); 
    let date_ln = $("#date_ln").val(); 
    let op_date_format = $("#op_date_format").val();
    let item_ln = $("#item_ln").val(); 
    let code_ln = $("#code_ln").val(); 
    let brand_ln = $("#brand_ln").val(); 
    let sn_ln = $("#sn_ln").val(); 
    let unit_price_ln = $("#unit_price_ln").val(); 
    let qty_ln = $("#qty_ln").val(); 
    let discount_ln = $("#discount_ln").val(); 
    let total_ln = $("#total_ln").val(); 
    let term_conditions = $("#term_conditions").html(); 
    let invoice_footer = $("#invoice_footer").text(); 
    let given_amount_ln = $("#given_amount_ln").val(); 
    let change_amount_ln = $("#change_amount_ln").val(); 
    let payment_method_ln = $("#payment_method_ln").val(); 
    let due_amount_ln = $("#due_amount_ln").val(); 
    let paid_amount_ln = $("#paid_amount_ln").val(); 
    let total_payable_ln = $("#total_payable_ln").val(); 
    let charge_ln = $("#charge_ln").val(); 
    let letter_head_gap = $("#letter_head_gap").val(); 
    let letter_footer_gap = $("#letter_footer_gap").val();
    let tax_ln = $("#tax_ln").val();
    let sub_total_ln = $("#sub_total_ln").val();
    let authorized_signature_ln = $("#authorized_signature_ln").val();
    let challan_ln = $("#challan_ln").val();
    let invoice_configuration = $("#invoice_configuration").val();


    // #################### Helper Function Start ####################
    // window.addEventListener("beforeunload", function (event) {
    //     // Show a confirmation message to the user
    //     event.returnValue = "Are you sure you want to leave?"; // This triggers the alert
    // });

    function limitWords(str, limit = 1) {
        const words = str.split(' ');
        const limitedWords = words.slice(0, limit);
        const result = limitedWords.join(' ');
        return words.length > limit ? result + ' ..' : result;
    }

    function getAmtPCustom(amount) {
        if (isNaN(amount)) {
            amount = 0;
        }
        let precision = op_precision || 0;
        let decimalsSeparator = op_decimals_separator || '.';
        let thousandsSeparator = op_thousands_separator || '';
    
        // Truncate the amount to the specified precision
        let factor = Math.pow(10, precision);
        amount = Math.floor(amount * factor) / factor;
    
        // Format the amount
        let strAmount = amount.toLocaleString(undefined, {
            minimumFractionDigits: precision,
            maximumFractionDigits: precision,
            useGrouping: !!thousandsSeparator
        });
    
        // Replace default decimal separator with custom one
        if (decimalsSeparator !== '.') {
            strAmount = strAmount.replace('.', decimalsSeparator);
        }
    
        // Replace default thousands separator with custom one
        if (thousandsSeparator !== ',') {
            strAmount = strAmount.replace(/,/g, thousandsSeparator);
        }
    
        return strAmount;
    }

    function dateFormat(paramDate = '') {
        if (paramDate === '') return '';
        const separate = paramDate.split(" ");
        let time = '';
        if (separate[1]) {
            time = ` <span class='time_design'>${separate[1]}</span>`;
        }
        const date = new Date(separate[0]);
        if (isNaN(date)) return ''; 
        let formattedDate;
        switch (op_date_format) {
            case 'd/m/Y':
                formattedDate = `${String(date.getDate()).padStart(2, '0')}/${String(date.getMonth() + 1).padStart(2, '0')}/${date.getFullYear()}`;
                break;
            case 'm/d/Y':
                formattedDate = `${String(date.getMonth() + 1).padStart(2, '0')}/${String(date.getDate()).padStart(2, '0')}/${date.getFullYear()}`;
                break;
            case 'Y/m/d':
                formattedDate = `${date.getFullYear()}/${String(date.getMonth() + 1).padStart(2, '0')}/${String(date.getDate()).padStart(2, '0')}`;
                break;
            default:
                formattedDate = `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`;
        }
        return formattedDate + time;
    }
    // #################### Helper Function End ####################


    // #################### Index DB Store Start ####################
    let is_offline_system;
    function checkInternetConnection(){
        $.ajax({
            url: base_url+'internet-check',  
            method: 'GET',
            cache: false,
            success: function() {
                // setItemStockInIndexDB();
                is_offline_system = '1';
                $('#is_offline_system').val('1');
                let request = indexedDB.open("off_pos", 2);
                request.onsuccess = function(event) {
                    let db = event.target.result;
                    let transaction = db.transaction(["sales"], "readonly");
                    let objectStore = transaction.objectStore("sales");
                    let countRequest = objectStore.count();
                    countRequest.onsuccess = function() {
                        if(countRequest.result > 0){
                            $('.online_sync').click();
                            toastr['success']('Offline Sync Successfully done.', 'Success');
                        }else{
                            $('.online_sync .sync_counter').text('');;
                        }
                    };
                    countRequest.onerror = function(event) {
                        console.log("Error counting sales:", event.target.error);
                    };
                };
                request.onerror = function(event) {
                    console.log("Error opening database:", event.target.error);
                };
                $('.online_offline_txt').text('Online');
                $('.online_sync').addClass('bg__green');
                $('.online_sync').removeClass('bg__red');
            },
            error: function() {
                is_offline_system = '0';
                let request = indexedDB.open("off_pos", 2);
                request.onsuccess = function(event) {
                    let db = event.target.result;
                    let transaction = db.transaction(["sales"], "readonly");
                    let objectStore = transaction.objectStore("sales");
                    let countRequest = objectStore.count();
                    countRequest.onsuccess = function() {
                        if(countRequest.result > 0){
                            $('.online_sync .sync_counter').text('').text(`( ${countRequest.result} )`);
                        }
                        if (!localStorage.getItem('offlineWarningShown')) {
                            toastr['warning']('Your internet is unavailable, you are going to offline mode.', 'Warning');
                            localStorage.setItem('offlineWarningShown', 'true');
                        }
                    };
                    countRequest.onerror = function(event) {
                        console.log("Error counting sales:", event.target.error);
                    };
                };
                request.onerror = function(event) {
                    console.log("Error opening database:", event.target.error);
                };
                $('.online_offline_txt').text('Offline');
                $('.online_sync').addClass('bg__red');
                $('.online_sync').removeClass('bg__green');
            }
        });
    }
    setInterval(function () {
        checkInternetConnection();
    }, 3000);
    // #################### Index DB Store End ####################


    $(document).on('keyup', '.select2-search__field', function(){
        $('.select2-results__message').text('').html(`<button type="button" class="add_as_new_customer"><iconify-icon icon="solar:add-circle-broken"></iconify-icon> Add as new customer</button>`);
    });
    $(document).on('click', '.add_as_new_customer', function(){
        $('#add_customer_modal').addClass('active');
        $('.pos__modal__overlay').fadeIn(300);
        let customer_name = $('.select2-search__field').val();
        $('#customer_phone_modal').val(customer_name);
        $("#walk_in_customer").val('').trigger('change');
        setTimeout(function(){
            $('.select2-dropdown').css('z-index', '1');
        }, 100);
        $('#add_or_edit_text').text(`Add Customer`);
        $('#customer_name_modal').focus();
    });

    function itemInfoSetter(){
        $.ajax({
            type: "GET",
            url: base_url+"Sale/itemInfoSetter",
            success: function (response) {
                let response2 = JSON.parse(response.data);
                window.items = response2;
                showAllItems('','');
                $('.item_counter').text(parseInt(window.items.length));
            }
        });
    }
    itemInfoSetter();


    

    function searchPlaceHolderSetter(){
        let generic_name_search = $('input[name="generic_serch_option_checkbox"]:checked').val();
        if(generic_name_search == 'Yes'){
            $('#search').attr('placeholder', 'Search by generic name');
        }else{
            $('#search').attr('placeholder', 'Search by name, code, category');
        }
    }
    searchPlaceHolderSetter();
    


    // Menu Access Check
    setTimeout(function(){
        $('.sub__menu__list').each(function(){
            let sub_mentu = $.trim($(this).html());
            if(sub_mentu == ''){
                $(this).parent().remove();
            }
        });
    }, 300);

    $(".menu_assign_class").each(function() {
        let this_access = $(this).attr("data-access");
        if((window.menu_objects).indexOf(this_access) > -1) {
    
        } else {
            if(this_access!=undefined){
                $(this).remove();
            }
        }
    });

    $(document).on('click', '.have_sub_menu', function(){
        $('.have_sub_menu').removeClass('submenu_active')
        $(this).addClass('submenu_active')
    });

    // Left Sidebar Menu End
    function checkItemShortType(param){
        if (param == 'General_Product'){
            return 'General';
        }else if(param == 'Medicine_Product'){
            return 'Medicine';
        }else if(param == 'IMEI_Product'){
            return 'IMEI';
        }else if(param == 'Serial_Product'){
            return 'Serial';
        }else if(param == 'Variation_Product'){
            return 'Variation';
        }else if(param == 'Installment_Product'){
            return 'Installment';
        }else if(param == 'Service_Product'){
            return 'Service';
        }
    }

    // Added By Azhar
    function customDecimalRound(number, multiply_by, precision) {
        let factor = Math.pow(10, precision);
        let integerPart = Math.floor(number);
        let decimalPart = number - integerPart;
        let roundedDecimal = Math.round(decimalPart * factor / multiply_by) * multiply_by /factor;
        return (integerPart + roundedDecimal).toFixed(precision);
    }

    


    // Code optimize by Azhar ** Final **
    $(document).on('keydown', '.integerchk', function (e) {
        let keys = e.charCode || e.keyCode || 0;
        // allow backspace, tab, delete, enter, arrows, numbers and keypad numbers ONLY
        // home, end, period, and numpad decimal
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

    // Code optimize by Azhar ** Final **
    $(document).on('keyup', '.integerchk', function (e) {
        let input = $(this).val();
        let ponto = input.split('.').length;
        let slash = input.split('-').length;
        if (ponto > 2)
            $(this).val(input.substr(0, (input.length) - 1));
        $(this).val(input.replace(/[^0-9]/, ''));
        if (slash > 2)
            $(this).val(input.substr(0, (input.length) - 1));
        if (ponto == 2)
            $(this).val(input.substr(0, (input.indexOf('.') + 3)));
        if (input == '.')
            $(this).val("");
    });

    // Code optimize by Azhar ** Final **
    function checkPercentageOrPlain(value) {
        if (value) {
            if (value.indexOf("%") > -1) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    // Code optimize by Azhar ** Final **
    function singleSubtotalCalculateByPriceDiscount(price, discount){
        let subtotal;
        if (checkPercentageOrPlain(discount)) {
            let discountWithoutPercent = discount.replace('%', '');
            let percentCalculate = Number(price) * Number(discountWithoutPercent) / 100;
            subtotal = Number(price) - percentCalculate;
        } else {
            subtotal = Number(price) - Number(discount);
        }
        return subtotal;
    }

    // Code optimize by Azhar ** Final **
    function subtotalCalculateByPriceQtyDiscount(price, quantity, discount){
        let subtotal;
        if (checkPercentageOrPlain(discount)) {
            let discountWithoutPercent = discount.replace('%', '');
            let percentCalculate = Number(price) * Number(discountWithoutPercent) / 100;
            subtotal = Number(price) - percentCalculate;
            subtotal = Number(subtotal) * Number(quantity);
        } else {
            subtotal = (Number(price) * Number(quantity)) - Number(discount);
        }
        return subtotal;
    }

    // Code optimize by Azhar ** Final **
    function percentValueCalculateByPriceQtyDiscount(price, quantity, discount){
        let subtotal;
        let percentValue;
        if (checkPercentageOrPlain(discount)) {
            let discountWithoutPercent = discount.replace('%', '');
            let percentCalculate = Number(price) * Number(discountWithoutPercent) / 100;
            subtotal = Number(price) - percentCalculate;
            percentValue = price - subtotal;
        } else {
            subtotal = (Number(price) - (Number(discount)) * Number(quantity));
            percentValue = price - subtotal;
        }
        return percentValue;
    }

    // Code optimize by Azhar ** Final **
    function dateMonthYearFinder(wg, sale_date) {
        let currentDate = new Date(Date.parse(sale_date));
        let futureDate = new Date(currentDate.getFullYear(), currentDate.getMonth() + Number(wg), currentDate.getDate());
        return futureDate.toISOString().slice(0, 10);
    }


    // Code optimize by Azhar ** Final **
    function formatDate(date, format) {
        let formattedDate = "";
        let currentDate = new Date(date)
        let day = currentDate.getDate();
        let month = currentDate.getMonth() + 1;
        let year = currentDate.getFullYear();
        format = format.toLowerCase();
        // Replace 'Y', 'm', 'd', 'y' with actual date values
        formattedDate = format.replace('y', year)
                            .replace('m', (month < 10 ? '0' : '') + month)
                            .replace('d', (day < 10 ? '0' : '') + day);
        return formattedDate;
    }
   
    // Code optimize by Azhar ** Final **
    $(document).on('click', '.sms_enable_status', function(){
        if(sms_enable_status != '1'){
            Swal.fire({
                title: warning + "!",
                text: 'Your SMS is not configured yet!, configure first.',
                confirmButtonColor: "#8b5cf6",
                confirmButtonText: ok,
                showCancelButton: false,
            });
            $(this).prop('checked', false);
        }
    });

    // Code optimize by Azhar ** Final **
    $(document).on('click', '.smtp_enable_status', function(){
        if(is_offline_system == '1'){
            if(smtp_enable_status != '1'){
                Swal.fire({
                    title: warning + "!",
                    text: 'Your SMTP is not configured yet!, configure first.',
                    confirmButtonColor: "#8b5cf6",
                    confirmButtonText: ok,
                    showCancelButton: false,
                });
                $(this).prop('checked', false);
            }
        }else{
            $(this).prop('checked', false);
        }
    });

    // Code optimize by Azhar ** Final **
    function posDefaultCursor(){
        if(default_cursor_position == 'Search Box'){
            $('#search').focus();
        }else if(default_cursor_position == 'Barcode Box'){
            $('#search_barcode').focus();
        }
    }
    setTimeout(function(){
        posDefaultCursor();
    }, 100)


    // Code optimize by Azhar ** Final **
    $(document).on('click', '#go_to_dashboard', function(){
        window.location.href = base_url+'Dashboard/dashboard';
    });

    // Code optimize by Azhar ** Final **
    function searchItemAndConstructGallery(searchedValue, sort_id='',is_main_search='') {
        let resultObject = search(searchedValue, window.items,sort_id,is_main_search);
        return resultObject;
    }

    function searchItemAndConstructGalleryAlternative(searchedValue, sort_id='',is_main_search='') {
        let resultObject = searchAlternative(searchedValue, window.items,sort_id,is_main_search);
        return resultObject;
    }



    // Code optimize by Azhar ** Final **
    function getNewDateTime() {
        let refresh = 1000; // Refresh rate in milli seconds
        setTimeout(display_date_time, refresh);
    }

    // Code optimize by Azhar ** Final **
    function display_date_time() {
        //for date and time
        let today = new Date();
        let dd = today.getDate();
        let mm = today.getMonth() + 1; //January is 0!
        let yyyy = today.getFullYear();
        if (dd < 10) {
            dd = "0" + dd;
        }
        if (mm < 10) {
            mm = "0" + mm;
        }
        let time_a = new Date().toLocaleTimeString();
        let today_date = yyyy + "-" + mm + "-" + dd;
        tippy(".time__date", {
            content: `<div class="text-center"><span>${today_date}</span><br><span>${time_a}</span></div>`,
            allowHTML: true,
            // animation: "scale",
        });
        $("#closing_register_time").html(today_date + " " + time_a);
        getNewDateTime();
    }
    display_date_time();



    // Code optimize by Azhar ** Final **
    function opDateFormat($date = '') {
        let date_format = $('#op_date_format').val();
        let formatted = new Date($date);
        if (date_format == 'd/m/Y') {
            date_format = 'dd/mm/yy';
        }
        if (date_format == 'm/d/Y') {
            date_format = 'mm/dd/yy';
        }
        if (date_format == 'Y/m/d') {
            date_format = 'yy/mm/dd';
        }
        return $.datepicker.formatDate(date_format, formatted);
    }



    // Code optimize by Azhar ** Final **
    function put_cart_content() {
        let total_items_in_cart = Number($("#total_items_in_cart_with_quantity").text());
        let sub_total = parseFloat($("#sub_total_show").text());
        let discounted_sub_total_amount = parseFloat($("#discounted_sub_total_amount").text());
        let total_vat = parseFloat($("#show_vat_modal").text());
        let total_payable = parseFloat($("#total_payable").text());
        let total_discount_amount = parseFloat($("#all_items_discount").text());
        let delivery_charge = Number($("#show_charge_amount").text());
        let sub_total_discount = Number($("#sub_total_discount").text());
        let sub_total_discount_value = $("#show_discount_amount").text();

        let order = {
            total_items_in_cart: getAmtPCustom(total_items_in_cart),
            sub_total: getAmtPCustom(sub_total),
            total_vat: getAmtPCustom(total_vat),
            total_payable: getAmtPCustom(total_payable),
            total_discount_amount: getAmtPCustom(total_discount_amount),
            actual_discount: getAmtPCustom(discounted_sub_total_amount),
            sub_total_discount: getAmtPCustom(sub_total_discount),
            delivery_charge: getAmtPCustom(delivery_charge),
            sub_total_discount_value: getAmtPCustom(sub_total_discount_value),
            items: []
        };

        if ($(".single_order").length > 0) {
            $(".single_order").each(function (i, obj) {
                let item_id = Number($(this).attr("id").substr(15));
                let item_name = $(this).find(".first_column").text();
                let item_vat = $("#item_vat_percentage_table" + item_id).text() || '';
                let item_note = $(".item_modal_description_table_" + item_id).text() || '';
                let item_unit_price = $("#item_price_table_" + item_id).text() || '';
                let item_quantity = $("#item_quantity_table_" + item_id).text() || '';
                let item_total_price_table = $("#item_total_price_table_" + item_id).text() || '';
                let item_g_w = $("#item_g_w_table_" + item_id).text() || '';
                let discount = $("#percentage_table_" + item_id).text() || '';
                let item = {
                    item_id: $.trim(item_id),
                    item_name: $.trim(item_name),
                    item_note: $.trim(item_note),
                    item_g_w: $.trim(item_g_w),
                    item_total_price_table: getAmtPCustom($.trim(item_total_price_table)),
                    discount: getAmtPCustom($.trim(discount)),
                    item_vat: getAmtPCustom($.trim(item_vat)),
                    item_unit_price: getAmtPCustom($.trim(item_unit_price)),
                    item_quantity: getAmtPCustom($.trim(item_quantity))
                };
                order.items.push(item);
            });
        }
        let order_object = JSON.stringify(order);
        $.ajax({
            url: base_url + "put-customer-panel-data",
            method: "POST",
            dataType: 'json',
            data: {
                order: order_object
            },
            success: function (response) {
            }
        });
    }

    function percentContainCheck(value){
        if (/%$/.test(value)) {
            return true;
        } else {
            return false;
        }
    }


    // Code optimize by Azhar ** Final **
    $(document).on('keyup', '#search_barcode', function(e){
        let this_value = $(this).val();
        let key = e.which;
        let default_unit = 1;
        let p_code = this_value;
        if(key == 13 && this_value != ""){
            let scanned_code = this_value;
            let scanned_code_lenght = scanned_code.length;
            if(Number(scanned_code_lenght) == 12){
                p_code = scanned_code.substr(4, 3);
                let p_unit_1 = Number(scanned_code.substr(7, 2));
                let p_unit_2 = (scanned_code.substr(9, 3));
                default_unit = Number(p_unit_1 +"."+ p_unit_2);
            }
            let item = findItemInfoByItemCode(p_code);
            if(item){
                if(item.item_type == 'IMEI_Product' || item.item_type == 'Serial_Product' || item.item_type == 'Medicine_Product'){
                    if (window.matchMedia("(min-width: 320px) and (max-width: 575.98px)").matches) {
                        $('.item-modal-top-header').css({
                            'grid-template-columns':'1fr',
                        });
                    }else{
                        $('.item-modal-top-header').css({
                            'grid-template-columns':'32% 32% 32%',
                        });
                    }
                    itemAppentToCart(item.item_id,item.item_type,item.is_promo,default_unit);
                }else{
    
                    let current_row = '';
                    let current_item_price = '';
                    let matchRow = '';
                    let qty = 0;
                    $('.order_holder .single_order').each(function(){
                        current_row = $(this).attr('data_cart_item_id');
                        current_item_price = $(`#item_price_table_${item.item_id}`).text();
                        if(item.item_id == current_row){
                            qty = $(`#item_quantity_table_${current_row}`).text();
                            $(`#item_quantity_table_${current_row}`).text(parseFloat(qty) + 1);
                            $(`#item_price_without_discount_${current_row}`).text(parseFloat(current_item_price) * (parseFloat(qty) + 1));
                            if(item.is_promo == 'Yes' && item.promo_discount){
                                if(!percentContainCheck(item.promo_discount)){
                                    $(`#percentage_table_${current_row}`).val(parseFloat(item.promo_discount) * (parseFloat(qty) + 1) );
                                }
                            }
                            toastr['success'](('The Quantity has been increased.'), '');
                            matchRow = '1';
                            cartItemCalculationInPOS();
                        }
                    });
                    
                    if(matchRow == ''){
                        generalItemdirectAddToCart(item.item_id,item.item_type,default_unit);
                        $('.item-modal-top-header').css({
                            'grid-template-columns':'65% 33%',
                        });
                        $('.modal_stock_wrapper p').css({
                            'text-align':'left',
                        });
                    }
                }
                $('#edit_item_modal_header').text(`${item.item_name} (${item.item_code})`);
                $(this).val('');
            } else{
                toastr['error'](('Item now found!'), '');
            }
        }
    });

    // Code optimize by Azhar ** Final **
    $(document).on('click', '#edit_customer', function () {
        if(is_offline_system == '1'){
            $.ajax({
                url: base_url + "Master/checkAccess",
                method: "GET",
                async: false,
                dataType: 'json',
                data: { controller: "147", function: "edit" },
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
                        let selected_customer_id = $('#walk_in_customer').val();
                        let selected_customer_name = $('option:selected', '#walk_in_customer').attr('data-customer-name');
                        if (selected_customer_name == 'Walk-in Customer') {
                            toastr['error']((edit_warning), '');
                        } else {
                            $('#add_or_edit_text').html('Edit Customer');
                            getCustomerForEdit(selected_customer_id);
                        }
                    }
                }
            });
        }
    });


    // Code optimize by Azhar ** Final **
    $(document).on("click", "#open_finalize_discount", function (e) {
        e.preventDefault();
        let sub_total_discount = $('#sub_total_discount').val();
        let dis_permission_status = $('#sub_total_discount_finalize').attr('varified-status');

        if(dis_permission_status == 'Yes'){
            $('#sub_total_discount_finalize').parent().show();
        }else{
            $('#sub_total_discount_finalize').parent().hide();
        }
        if(sub_total_discount){
            toastr['error'](('Discount already given'), '');
        }else{
            $("#sub_total_discount_finalize").focus();
            $("#finalize_discount_modal").addClass("active");
            $(".pos__modal__overlay").fadeIn(300);
        }
    });



    $(document).on('click', '.finalize_dis_submit', function(){
        let sub_total_discount_finalize = $('#sub_total_discount_finalize').val();
        if(sub_total_discount_finalize){
            $('#finalize_discount_modal').removeClass('active');
        }else{
            let user_id = $('#session_uer_id').val();
            let discount_permission_code = $('.discount_permission_code_f').val();
            let error = false;
            if(discount_permission_code == ''){
                error = true;
                $('.discount_err_message_f').parent().show();
                $('.discount_err_message_f').text(The_discount_code_field_required)
                return false
            }else{
                $.ajax({
                    method: "POST",
                    url: base_url+"Sale/checUserDiscountPermission",
                    data: {
                        user_id: user_id,
                        discount_permission_code: discount_permission_code,
                    },
                    success: function (response) {
                        if(response.status == 'success'){
                            $('.discount_err_message_f').parent().hide();
                            $('#sub_total_discount_finalize').parent().show();
                            $('#sub_total_discount_finalize').attr('varified-status', 'Yes');
                        }else{
                            $('.discount_err_message').text(response.message)
                            $('.discount_err_message').parent().show();
                        }
                    }
                });
            }
        }
    });


    // Code optimize by Azhar ** Final **
    $('#please_read_close_button,#please_read_close_button_cross').on('click', function () {
        $('#please_read_modal').slideUp('500');
    });


    // Code optimize by Azhar ** Final **
    $(document).on('click', '#calculator_button', function (e) {
        if ($('#calculator_main').css('display') == 'none') {
            $("#cal_open_status").val(1);
        } else {
            $('#calculator_main').css('display', 'none');
            $("#cal_open_status").val(2);
        }
    });


    // Code optimize by Azhar ** Final **
    function set_calculator_position() {
        $('.overlayForCalculator').css('display', 'block');
        $('#calculator_main').css('display', 'block');
        if ($(window).width() > 992) {
            let calculator_button_top = $("#calculator_button").offset().top;
            let calculator_button_left = $("#calculator_button").offset().left;
            let calculator_button_height = $("#calculator_button").height();
            let calculator_button_width = $("#calculator_button").width();
            let calculator_width = $("#calculator_main").width();
            let left_for_calculator =
                calculator_button_left +
                calculator_button_width +
                calculator_button_width -
                calculator_width;
                let total_top_for_calculator =
                calculator_button_top + calculator_button_height + 5;
            $("#calculator_main")
                .css("top", calculator_button_top + 40)
                .css("left", calculator_button_left - 100);
        } else {
            $("#calculator_main").css({
                top: '40%',
                left: '50%',
                transform: 'translate(-50%, -50%)'
            });
        }
    }

    // Code optimize by Azhar ** Final **
    $(document).on('click', '.calculator_button', function () {
        set_calculator_position();
    });

    // Code optimize by Azhar ** Final **
    $(document).on('click', function(event) {
        // Close the calculator after clicking on the window
        if (!$(event.target).closest('.calculator_button').length && !$(event.target).closest('#calculator_main').length ) {
            $('.overlayForCalculator').css('display', 'none');
            $('#calculator_main').css('display', 'none');
        }
    });


    // Code optimize by Azhar ** Final **
    $(document).on('click', '#keyboard_short_cut', function () {
        $("#show_keyboard_short_cut").addClass("active");
        $(".pos__modal__overlay").fadeIn(200);
    });

    // Code optimize by Azhar ** Final **
    $(document).on('click', '.keyboard_short_cut', function () {
        $("#show_keyboard_short_cut").addClass("active");
        $(".pos__modal__overlay").fadeIn(200);
    });

    // Code optimize by Azhar ** Final **
    function holdSaleModalDataClear(){
        // Hold Modal
        $('.modifier_item_details_holder').html('');
        $('#hold_customer_name').text('');
        $('#last_ten_customer_mobile').text('');
        $('#sub_total_show_hold').text(Number(0).toFixed(op_precision));
        $('#total_items_in_cart_hold').text(Number(0));
        $('#total_items_qty_in_cart_hold').text(Number(0));
        $('#hold_all_tax_amount').text(Number(0).toFixed(op_precision));
        $('#delivery_charge_hold').text(Number(0).toFixed(op_precision));
        $('#sub_total_discount_hold').text(Number(0).toFixed(op_precision));
        $('#all_items_discount_hold').text(Number(0).toFixed(op_precision));
        $('#total_payable_hold').text(Number(0).toFixed(op_precision));
        // Other
        $('#hold_customer_id').text('');
        $("#sub_total_hold").text(Number(0).toFixed(op_precision));
        $("#total_item_discount_hold").text(Number(0).toFixed(op_precision));
        $("#discounted_sub_total_amount_hold").text(Number(0).toFixed(op_precision));
    }

    // Code optimize by Azhar ** Final **
    $(document).on('click', '#open_hold_sales', function () {
        $("#show_sale_hold_modal").addClass("active");
        $(".pos__modal__overlay").fadeIn(200);
        getAllHoldSales();
        recentSaleModalDataClear();
        holdSaleModalDataClear();
    });


    // Code optimize by Azhar ** Final **
    $(document).on('click', '.open_hold_sales', function () {
        $("#show_sale_hold_modal").addClass("active");
        $(".pos__modal__overlay").fadeIn(200);
        getAllHoldSales();
        recentSaleModalDataClear();
        holdSaleModalDataClear();
    });


    // Code optimize by Azhar ** Final **
    $(document).on('mouseover', '.single_hold_sale,.single_last_ten_sale', function () {
        $(this).css('background-color', '#cfcfcf');
    });

    // Code optimize by Azhar ** Final **
    $(document).on('mouseout', '.single_hold_sale,.single_last_ten_sale', function () {
        $(this).css('background-color', '#ffffff');
        if ($(this).attr('data-selected') == 'selected') {
            $(this).css('background-color', '#cfcfcf');
        }
    });


   
    // Code optimize by Azhar ** Final **
    $(document).on('click', '.single_hold_sale', function () {
        let hold_id = $(this).attr('id').substr(5);
        $('.single_hold_sale').css('background-color', '#ffffff');
        $('.single_hold_sale').attr('data-selected', 'unselected');
        $(this).css('background-color', '#cfcfcf');
        $(this).attr('data-selected', 'selected');
        if(is_offline_system == '1'){
            $.ajax({
                url: base_url + "Sale/get_single_hold_info_by_ajax",
                method: "POST",
                data: {
                    hold_id: hold_id,
                    csrf_offpos: csrf_value_
                },
                success: function (response) {
                    response = JSON.parse(response);
                    let totalQty = 0;
                    $('#hold_customer_id').html(response.customer_id);
                    $('#hold_customer_name').html(response.customer_name);
                    let draw_table_for_hold_order = '';
                    for (let key in response.items) {
                        let this_item = response.items[key];
                        let comboHtml = '';
    
                        if(this_item.item_type == 'Combo_Product'){
                            $.ajax({
                                type: "POST",
                                url: base_url+"Sale/getAllHoldComboItems",
                                async: false,
                                data: {
                                    hold_item_id: this_item.id
                                },
                                dataType: "JSON",
                                success: function (response) {
                                    if(this_item.item_type == 'Combo_Product'){
                                        let comboName = 0;
                                        let comboQty = 0;
                                        let comboUnitPrice = 0;
                                        let combSubTotal = 0;
                                        let combChildId = '';
                                        let comboType = '';
                                        let combParentId = '';
                                        let combSellerId = '';
                                        let combIFSale = '';
                                        let combItemShownInInvoice = '';
                                        $.each(response.data, function (ind, val) { 
                                            comboName = val.item_name;
                                            comboType = val.combo_item_type;
                                            comboQty = val.combo_item_qty;
                                            comboUnitPrice = val.combo_item_price;
                                            combSubTotal = parseFloat(parseFloat(val.combo_item_qty) * parseFloat(val.combo_item_price)).toFixed(op_precision);
                                            combChildId = val.combo_item_id;
                                            combParentId = this_item.food_menu_id;
                                            combSellerId = val.combo_item_seller_id;
                                            combIFSale = true;
                                            combItemShownInInvoice = val.show_in_invoice == 'Yes' ? true : false;
                                            if(combIFSale){
                                                comboHtml +=`<div class="combo_cart_item combo_item_div_${combChildId}"  data-is_combo="Yes">
                                                    <div data-id="${combChildId}" class="customer_panel single_order_column first_column">
                                                        
                                                        <span id="combo_item_name_table_${combChildId}">${comboName}</span>
                                                        <span id="combo_item_type_table_${combChildId}">${comboType}</span>
                                                        <span class="d-none" id="combo_seller_table_${combChildId}">${combSellerId}</span>
                                                        <span class="d-none" id="combo_inv_show_table_${combChildId}">${combItemShownInInvoice ? 'Yes' : 'No'}</span>
                                                        <span class="d-none" id="combo_ifsale_table_${combChildId}">${combIFSale ? 'Yes' : 'No'}</span>
                                                    </div>
                                                    <div class="single_order_column second_column text-center"> 
                                                        <span id="combo_item_price_table_${combChildId}">${parseFloat(comboUnitPrice).toFixed(op_precision)}</span>
                                                    </div>
                                                    <div class="single_order_column third_column text-center">
                                                        <span class="4_cp_qty_${combChildId} qty_item_custom cart_quantity" id="combo_item_quantity_table_${combChildId}">${parseFloat(comboQty)}</span> 
                                                    </div>
                                                    <div class="single_order_column forth_column text-center">
                                                        <span class="hold_special_textbox" id="hold_percentage_table_${combChildId}">${parseFloat(0).toFixed(op_precision)}</span>
                                                    </div>
                                                    <div class="single_order_column fifth_column text-right"> 
                                                        <span id="combo_item_total_price_table_${combChildId}">${parseFloat(combSubTotal).toFixed(op_precision)}</span>
                                                    </div>
                                                </div>`;
                                            }
                                        });
                                    }
                                    
                                }
                            });
                        }
                        totalQty+=Number(this_item.qty);
                        let discount_value = (this_item.menu_discount_value != "") ? this_item.menu_discount_value : Number(0).toFixed(op_precision);
                        let expiry_imei_serial = '';
                        if((this_item.item_type == 'IMEI_Product' || this_item.item_type == 'Serial_Product' || this_item.item_type == 'Medicine_Product') && this_item.expiry_imei_serial){
                            expiry_imei_serial = `<span class="recent_imei_serial_note" id="expiry_imei_serial">${checkItemShortType(this_item.item_type)}: <span class="expiry_imei_serial_${this_item.food_menu_id}">${$.trim(this_item.expiry_imei_serial)}</span></span>`;
                        }else{
                            expiry_imei_serial = '';
                        }
                        draw_table_for_hold_order += `
                        <div data-variation-parent="${this_item.parent_id}" class="single_item_modifier" id="hold_order_for_item_${this_item.food_menu_id}">
                            <div class="first_portion">
                                <span class="item_vat_hold d-none" id="hold_item_vat_percentage_table${this_item.food_menu_id}">${this_item.menu_vat_percentage}</span>
                                <span class="item_discount_hold d-none" id="hold_item_discount_table${this_item.food_menu_id}">${this_item.discount_amount}</span>
                                <span class="item_price_without_discount_hold d-none" id="hold_item_price_without_discount_${this_item.food_menu_id}">${this_item.menu_price_without_discount}</span>
                                <div class="single_order_column_hold first_column column">
                                    <span id="hold_item_name_table_${this_item.food_menu_id}">${ (this_item.parent_name ? this_item.parent_name + ' ' : '') + this_item.item_name +'('+ this_item.code +')'}</span>
                                </div>
                                <div class="single_order_column_hold second_column column">
                                    <span id="hold_item_price_table_${this_item.food_menu_id}">${parseFloat(this_item.menu_unit_price).toFixed(op_precision)}</span>
                                </div>
                                <div class="single_order_column_hold third_column column">
                                    <span id="hold_item_quantity_table_${this_item.food_menu_id}">${this_item.qty}</span>
                                </div>
                                <div class="single_order_column_hold forth_column column">
                                    <span class="hold_special_textbox" id="hold_percentage_table_${this_item.food_menu_id}">${discount_value}</span>
                                </div>
                                <div class="single_order_column_hold fifth_column column">
                                    <span id="hold_item_total_price_table_${this_item.food_menu_id}">${parseFloat(this_item.menu_price_with_discount).toFixed(op_precision)}</span>
                                </div>
                            </div>
                            ${expiry_imei_serial}
                            ${comboHtml}
                        </div>`;
                        if(this_item.promo_item_object){
                            let jsonObj = jQuery.parseJSON(this_item.promo_item_object);
                            draw_table_for_hold_order+=`<div class="single_item_modifier" id="hold_order_for_item_${this_item.food_menu_id}">
                                    <div class="first_portion">
                                        <span class="item_vat_hold d-none" id="hold_item_vat_percentage_table${this_item.food_menu_id}">0</span>
                                        <span class="item_discount_hold d-none" id="hold_item_discount_table${this_item.food_menu_id}">0</span>
                                        <span class="item_price_without_discount_hold d-none" id="hold_item_price_without_discount_${this_item.food_menu_id}">0</span>
                                        <div class="single_order_column_hold first_column column">
                                            <span id="hold_item_name_table_${this_item.food_menu_id}">${jsonObj.promo_item_name} <small class="font-style-i">Frre Item</small></span>
                                        </div>
                                        <div class="single_order_column_hold second_column column"> 
                                            <span id="hold_item_price_table_${this_item.food_menu_id}">${Number(0).toFixed(op_precision)}</span>
                                        </div>
                                        <div class="single_order_column_hold third_column column">
                                            <span id="hold_item_quantity_table_${this_item.food_menu_id}">${jsonObj.promo_item_qty}</span>
                                        </div>
                                        <div class="single_order_column_hold forth_column column">
                                            <span class="hold_special_textbox" id="hold_percentage_table_${this_item.food_menu_id}">${Number(0)}</span>
                                        </div>
                                        <div class="single_order_column_hold fifth_column column"> 
                                            <span id="hold_item_total_price_table_${this_item.food_menu_id}">${Number(0).toFixed(op_precision)}</span>
                                        </div>
                                    </div>
                                </div>`;
                        }
                        draw_table_for_hold_order += '</div>';
                    }
                    $(".item_modifier_details .modifier_item_details_holder").empty();
                    $(".item_modifier_details .modifier_item_details_holder").prepend(draw_table_for_hold_order);
                    $('#total_items_in_cart_hold').text(response.total_items);
                    $('#hold_all_tax_amount').text(Number(response.vat).toFixed(op_precision));
                    $('#total_items_qty_in_cart_hold').text(totalQty);
                    let sub_total_discount_hold = (response.sub_total_discount_value != "") ? Number(response.sub_total_discount_value).toFixed(op_precision) : Number(0).toFixed(op_precision);
                    $("#sub_total_show_hold").text(parseFloat(response.sub_total).toFixed(op_precision));
                    $("#sub_total_hold").text(Number(response.sub_total).toFixed(op_precision));
                    $("#total_item_discount_hold").text(Number(response.total_item_discount_amount).toFixed(op_precision));
                    $("#discounted_sub_total_amount_hold").text(Number(response.sub_total_discount_amount).toFixed(op_precision));
                    $("#sub_total_discount_hold").text(Number(sub_total_discount_hold).toFixed(op_precision));
                    let total_vat_section_to_show = '';
                    $.each(JSON.parse(response.sale_vat_objects), function (key, value) {
                        total_vat_section_to_show += `<span class="tax_field_order_details" id="tax_field_order_details_${value.tax_field_id}">${value.tax_field_type}</span> 
                            <span class="tax_field_amount_order_details" id="tax_field_amount_order_details_${value.tax_field_id}">${parseFloat(value.tax_field_amount).toFixed(op_precision)}</span><br>`;
                    });
                    $("#all_items_discount_hold").text(parseFloat(response.total_discount_amount).toFixed(op_precision));
                    $("#delivery_charge_hold").text(parseFloat(response.delivery_charge).toFixed(op_precision));
                    $("#total_payable_hold").text(parseFloat(response.total_payable).toFixed(op_precision));
                }
            });
        }else{
            let db;
            const request = indexedDB.open("off_pos_3", 3);
            request.onerror = function(event) {
                console.error("Database error: " + event.target.error);
            };
            request.onsuccess = function(event) {
                db = event.target.result;
                const transaction = db.transaction(["draft_sales"], "readonly");
                const objectStore = transaction.objectStore("draft_sales");
                const getRequest = objectStore.get(parseInt(hold_id));
                getRequest.onerror = function(event) {
                    console.log("Error fetching hold sale:", event.target.error);
                };
                getRequest.onsuccess = function(event) {
                    const holdOrder = event.target.result;
                    if (holdOrder) {
                        let response = holdOrder.order;
                        let draw_table_for_hold_order = '';
                        let totalQty = 0;
                        let expiry_imei_serial = '';
                        for (let key in response.items) {
                            let this_item = response.items[key];
                            totalQty += Number(this_item.item_quantity);
                            let discount_value = (this_item.item_discount != "") ? this_item.item_discount : Number(0).toFixed(op_precision);
                            if ((this_item.item_type == 'IMEI_Product' || this_item.item_type == 'Serial_Product' || this_item.item_type == 'Medicine_Product') && this_item.expiry_imei_serial) {
                                expiry_imei_serial = `<span class="recent_imei_serial_note" id="expiry_imei_serial">${checkItemShortType(this_item.item_type)}: <span class="expiry_imei_serial_${this_item.item_id}">${$.trim(this_item.expiry_imei_serial)}</span></span>`;
                            } else {
                                expiry_imei_serial = '';
                            }
                            draw_table_for_hold_order += `
                                <div class="single_item_modifier" id="hold_order_for_item_${this_item.item_id}">
                                    <div class="first_portion">
                                        <span class="item_vat_hold d-none" id="hold_item_vat_percentage_table${this_item.item_id}">${this_item.menu_taxes}</span>
                                        <span class="item_type d-none" id="item_type_table${this_item.item_id}">${this_item.item_type}</span>
                                        <span class="item_discount_hold d-none" id="hold_item_discount_table${this_item.item_id}">${this_item.item_discount_amount}</span>
                                        <span class="item_price_without_discount_hold d-none" id="hold_item_price_without_discount_${this_item.item_id}">${this_item.item_price_without_discount}</span>
                                        <div class="single_order_column_hold first_column column">
                                            <span id="hold_item_name_table_${this_item.item_id}">${this_item.item_name}</span>
                                            ${expiry_imei_serial}
                                        </div>
                                        <div class="single_order_column_hold second_column column">
                                            <span id="hold_item_price_table_${this_item.item_id}">${this_item.item_unit_price}</span>
                                        </div>
                                        <div class="single_order_column_hold third_column column">
                                            <span id="hold_item_quantity_table_${this_item.item_id}">${this_item.item_quantity}</span>
                                        </div>
                                        <div class="single_order_column_hold forth_column column">
                                            <span class="hold_special_textbox" id="hold_percentage_table_${this_item.item_id}">${discount_value}</span>
                                        </div>
                                        <div class="single_order_column_hold fifth_column column">
                                            <span id="hold_item_total_price_table_${this_item.item_id}">${this_item.item_price_with_discount}</span>
                                        </div>
                                    </div>
                                    <div class="second_portion">
                                        <span id="hold_item_note_table_${this_item.item_id}">${this_item.menu_note}</span>
                                    </div>
                                </div>`;
                            if (this_item.is_promo_item_exist) {
                                draw_table_for_hold_order += `<div class="single_item_modifier" id="hold_order_for_item_${this_item.item_id}">
                                        <div class="first_portion">
                                            <span class="item_vat_hold d-none" id="hold_item_vat_percentage_table${this_item.item_id}">0</span>
                                            <span class="item_discount_hold d-none" id="hold_item_discount_table${this_item.item_id}">0</span>
                                            <span class="item_price_without_discount_hold d-none" id="hold_item_price_without_discount_${this_item.item_id}">0</span>
                                            <div class="single_order_column_hold first_column column">
                                                <span id="hold_item_name_table_${this_item.item_id}">${this_item.freeItemName} <small class="font-style-i">Free Item</small></span>
                                            </div>
                                            <div class="single_order_column_hold second_column column"> 
                                                <span id="hold_item_price_table_${this_item.item_id}">${Number(0).toFixed(op_precision)}</span>
                                            </div>
                                            <div class="single_order_column_hold third_column column">
                                                <span id="hold_item_quantity_table_${this_item.item_id}">${this_item.freeItemGetQty}</span>
                                            </div>
                                            <div class="single_order_column_hold forth_column column">
                                                <span class="hold_special_textbox" id="hold_percentage_table_${this_item.item_id}">${Number(0)}</span>
                                            </div>
                                            <div class="single_order_column_hold fifth_column column"> 
                                                <span id="hold_item_total_price_table_${this_item.item_id}">${Number(0).toFixed(op_precision)}</span>
                                            </div>
                                        </div>
                                    </div>`;
                            }
                        }
                        $(".item_modifier_details .modifier_item_details_holder").empty();
                        $(".item_modifier_details .modifier_item_details_holder").prepend(draw_table_for_hold_order);
                        $('#total_items_in_cart_hold').text(response.total_items_in_cart);
                        $('#hold_all_tax_amount').text(Number(response.total_vat).toFixed(op_precision));
                        $('#total_items_qty_in_cart_hold').text(totalQty);
                        let customer_phone = (response.customer_phone_number == null || response.customer_phone_number == 'null' || response.customer_phone_number == "") ? '' : response.customer_phone_number;
                        $('#hold_customer_name').text(`${response.customer_name} ${customer_phone != '' ? '(' + customer_phone + ')' : ''}` );
                        let sub_total_discount_hold = (response.sub_total_discount_value != "") ? Number(response.sub_total_discount_value).toFixed(op_precision) : Number(0).toFixed(op_precision);
                        $("#sub_total_show_hold").text(parseFloat(response.sub_total).toFixed(op_precision));
                        $("#sub_total_hold").text(Number(response.sub_total).toFixed(op_precision));
                        $("#total_item_discount_hold").text(Number(response.total_item_discount_amount).toFixed(op_precision));
                        $("#discounted_sub_total_amount_hold").text(Number(response.sub_total_with_discount).toFixed(op_precision));
                        $("#sub_total_discount_hold").text(Number(sub_total_discount_hold).toFixed(op_precision));
                        let total_vat_section_to_show = '';
                        $.each(response.sale_vat_objects, function (key, value) {
                            total_vat_section_to_show += `<span class="tax_field_order_details" id="tax_field_order_details_${value.tax_field_id}">${value.tax_field_type}</span> 
                                <span class="tax_field_amount_order_details" id="tax_field_amount_order_details_${value.tax_field_id}">${parseFloat(value.tax_field_amount).toFixed(op_precision)}</span><br>`;
                        });
                        $("#all_items_discount_hold").text(parseFloat(response.total_discount_amount).toFixed(op_precision));
                        $("#delivery_charge_hold").text(parseFloat(response.delivery_charge).toFixed(op_precision));
                        $("#total_payable_hold").text(parseFloat(response.total_payable).toFixed(op_precision));
                    }
                };
            };
        }
        
    });



    // Code optimize by Azhar ** Final **
    $(document).on('click', '.single_last_ten_sale', function () {
        $('.single_last_ten_sale').css('background-color', '#ffffff');
        $('.single_last_ten_sale').attr('data-selected', 'unselected');
        $(this).attr('data-selected', 'selected');
        $(this).css('background-color', '#cfcfcf');
        if(is_offline_system == '1'){
            let sale_id = $(this).attr('id').substr(9);
            $.ajax({
                url: base_url + "Sale/get_all_information_of_a_sale_ajax",
                method: "POST",
                data: {
                    sale_id: sale_id,
                    csrf_offpos: csrf_value_
                },
                success: function (response) {
                    response = JSON.parse(response);
                    let totalQty = 0;
                    $('#last_10_customer_id').html(response.customer_id);
                    $('#last_10_customer_name').html(`${response.customer_name}`);
                    $('#last_ten_customer_mobile').html(`${response.c_phone ? '(' + response.c_phone + ')' : ''}`);
                    $('#last_10_order_date_time').html(opDateFormat(response.date_time) + ' ' + response.order_time);
                    let draw_table_for_last_ten_sales_order = '';
                    for (let key in response.items) {
                        let this_item = response.items[key];
                        let is_free_text = '';
                        if(this_item.is_promo_item == ''){
                            is_free_text = `<small class="font-style-i">(Frre Item)</small>`;
                        }else{
                            is_free_text = '';
                        }
                        totalQty+=Number(this_item.qty);
                        let discount_value = (this_item.menu_discount_value != "") ? this_item.menu_discount_value : Number(0).toFixed(op_precision);
                        let expiry_imei_serial = '';
                        if((this_item.item_type == 'IMEI_Product' || this_item.item_type == 'Serial_Product' || this_item.item_type == 'Medicine_Product') && this_item.expiry_imei_serial){
                            expiry_imei_serial = `<span class="recent_imei_serial_note" id="expiry_imei_serial">${checkItemShortType(this_item.item_type)}: <span class="expiry_imei_serial_${this_item.food_menu_id}">${$.trim(this_item.expiry_imei_serial)}</span></span>`;
                        }else{
                            expiry_imei_serial = '';
                        }
                        draw_table_for_last_ten_sales_order += `
                            <div class="single_item_modifier" id="last_10_order_for_item_${this_item.food_menu_id}">
                                <div class="first_portion">
                                    <span class="item_vat_hold d-none" id="last_10_item_vat_percentage_table${this_item.food_menu_id}">${this_item.menu_taxes}</span>
                                    <span class="item_type d-none" id="item_type_table${this_item.food_menu_id}">${this_item.item_type}</span>
                                    <span class="item_discount_hold d-none" id="last_10_item_discount_table${this_item.food_menu_id}">${parseFloat(this_item.discount_amount).toFixed(op_precision)}</span>
                                    <span class="item_price_without_discount_hold d-none" id="last_10_item_price_without_discount_${this_item.food_menu_id}">${parseFloat(this_item.menu_price_without_discount).toFixed(op_precision)}</span>
                                    <div class="single_order_column_hold first_column column">
                                        <span id="last_10_item_name_table_${this_item.food_menu_id}">${this_item.item_name +'('+ this_item.code +')'}  ${is_free_text}</span>
                                    </div>
                                    <div class="single_order_column_hold second_column column">
                                        <span id="last_10_item_price_table_${this_item.food_menu_id}">${parseFloat(this_item.menu_unit_price).toFixed(op_precision)}</span>
                                    </div>
                                    <div class="single_order_column_hold third_column column">
                                        <span id="last_10_item_quantity_table_${this_item.food_menu_id}">${this_item.qty}</span>
                                    </div>
                                    <div class="single_order_column_hold forth_column column">
                                        <span class="hold_special_textbox" id="last_10_percentage_table_${this_item.food_menu_id}">${discount_value}</span>
                                    </div>
                                    <div class="single_order_column_hold fifth_column column">
                                        <span id="last_10_item_total_price_table_${this_item.food_menu_id}">${parseFloat(this_item.menu_price_with_discount).toFixed(op_precision)}</span>
                                    </div>
                                </div>
                                ${expiry_imei_serial}`;
                                if (this_item.menu_note !== "") {
                                    draw_table_for_last_ten_sales_order += `<span class="cart_item_modal_des_last_ten_sale item_modal_description_table_${this_item.food_menu_id}">${this_item.menu_note !== '' ? this_item.menu_note : ''}</span>`;
                                }
                        draw_table_for_last_ten_sales_order += `</div>`;
                    }
                    $(".item_modifier_details .modifier_item_details_holder").empty();
                    $(".item_modifier_details .modifier_item_details_holder").prepend(draw_table_for_last_ten_sales_order);
                    $('#total_items_in_cart_last_10').text(response.total_items);
                    $('#last_10_order_invoice_no').text(response.sale_no);
                    $('#total_items_qty_in_cart_last_10').text(totalQty);
                    $("#sub_total_show_last_10").text(parseFloat(response.sub_total).toFixed(op_precision));
                    $("#sub_total_last_10").text(parseFloat(response.sub_total).toFixed(op_precision));
                    $("#total_item_discount_last_10").text(parseFloat(response.total_item_discount_amount).toFixed(op_precision));
                    $("#discounted_sub_total_amount_last_10").text(parseFloat(response.sub_total_discount_amount).toFixed(op_precision));
                    $("#sub_total_discount_last_10").text(parseFloat(response.sub_total_discount_amount).toFixed(op_precision));
                    $("#all_items_vat_last_10").text(Number(response.vat).toFixed(op_precision));
                    $("#all_items_discount_last_10").text(parseFloat(response.total_discount_amount).toFixed(op_precision));
                    $("#delivery_charge_last_10").text(parseFloat(response.delivery_charge).toFixed(op_precision));
                    $("#paid_amount_last_10").text(parseFloat(response.paid_amount).toFixed(op_precision));
                    $("#due_amount_last_10").text(parseFloat(response.due_amount).toFixed(op_precision));
                    $("#total_payable_last_10").text(parseFloat(response.total_payable).toFixed(op_precision));
                }
            });
        }else{

            let sale_no = $(this).find('.first_column').text();

            let db;
            const request = indexedDB.open("off_pos", 2);
            request.onerror = function(event) {
                console.error("Database error: " + event.target.error);
            };
            request.onsuccess = function(event) {
                db = event.target.result;
                const transaction = db.transaction(["sales"], "readonly");
                const objectStore = transaction.objectStore("sales");
                const getRequest = objectStore.getAll();
                getRequest.onerror = function(event) {
                    console.log("Error fetching Rcent sale:", event.target.error);
                };
                getRequest.onsuccess = function(event) {
                    const recentSale = event.target.result;
                    if (recentSale) {
                        let find_this_item = '';
                        recentSale.forEach(record => {
                            if(record.sale_no == sale_no){
                                find_this_item = record;
                                return
                            }
                        });
                        let single_item = JSON.parse(find_this_item.order);
                        $('#last_10_customer_id').html(find_this_item.customer_id);
                        $('#last_10_customer_name').html(`${find_this_item.customer_name}`);
                        $('#last_ten_customer_mobile').html('');
                        $('#last_10_order_date_time').html((find_this_item.sale_date) + ' ' + find_this_item.sale_time);
                        let itemCount = 0;
                        let totalQty = 0;
                        let discount_value = '';
                        let draw_table_for_last_ten_sales_order = '';
                        let expiry_imei_serial = '';
                        let is_free_text = '';
                        
                        single_item.items.forEach(function(this_item){
                            itemCount++;
                            if(this_item.is_promo_item == ''){
                                is_free_text = `<small class="font-style-i">(Frre Item)</small>`;
                            }else{
                                is_free_text = '';
                            }
                            totalQty+=Number(this_item.item_quantity);
                            discount_value = (this_item.item_discount != "") ? this_item.item_discount : Number(0).toFixed(op_precision);
                            if((this_item.item_type == 'IMEI_Product' || this_item.item_type == 'Serial_Product' || this_item.item_type == 'Medicine_Product') && this_item.expiry_imei_serial){
                                expiry_imei_serial = `<span class="recent_imei_serial_note" id="expiry_imei_serial">${checkItemShortType(this_item.item_type)}: <span class="expiry_imei_serial_${this_item.item_id}">${$.trim(this_item.expiry_imei_serial)}</span></span>`;
                            }else{
                                expiry_imei_serial = '';
                            }
                            draw_table_for_last_ten_sales_order += `
                                <div class="single_item_modifier" id="last_10_order_for_item_${this_item.item_id}">
                                    <div class="first_portion">
                                        <span class="item_vat_hold d-none" id="last_10_item_vat_percentage_table${this_item.item_id}">${this_item.item_vat}</span>
                                        <span class="item_type d-none" id="item_type_table${this_item.item_id}">${this_item.item_type}</span>
                                        <span class="item_discount_hold d-none" id="last_10_item_discount_table${this_item.item_id}">${parseFloat(this_item.item_discount_amount).toFixed(op_precision)}</span>
                                        <span class="item_price_without_discount_hold d-none" id="last_10_item_price_without_discount_${this_item.item_id}">${parseFloat(this_item.item_price_without_discount).toFixed(op_precision)}</span>
                                        <div class="single_order_column_hold first_column column">
                                            <span id="last_10_item_name_table_${this_item.item_id}">${this_item.item_name}  ${is_free_text}</span>
                                        </div>
                                        <div class="single_order_column_hold second_column column">
                                            <span id="last_10_item_price_table_${this_item.item_id}">${parseFloat(this_item.is_promo_item == '' ? 0 : this_item.item_unit_price).toFixed(op_precision)}</span>
                                        </div>
                                        <div class="single_order_column_hold third_column column">
                                            <span id="last_10_item_quantity_table_${this_item.item_id}">${this_item.item_quantity}</span>
                                        </div>
                                        <div class="single_order_column_hold forth_column column">
                                            <span class="hold_special_textbox" id="last_10_percentage_table_${this_item.item_id}">${discount_value}</span>
                                        </div>
                                        <div class="single_order_column_hold fifth_column column">
                                            <span id="last_10_item_total_price_table_${this_item.item_id}">${parseFloat(this_item.is_promo_item == '' ? 0 : this_item.item_price_with_discount).toFixed(op_precision)}</span>
                                        </div>
                                    </div>
                                    ${expiry_imei_serial}`;
                                    if (this_item.item_description !== "") {
                                        draw_table_for_last_ten_sales_order += `<span class="cart_item_modal_des_last_ten_sale item_modal_description_table_${this_item.item_id}">${this_item.item_description !== '' ? this_item.item_description : ''}</span>`;
                                    }
                            draw_table_for_last_ten_sales_order += `</div>`;
                        });
                        paid_amount_last_10
                        $(".item_modifier_details .modifier_item_details_holder").empty();
                        $(".item_modifier_details .modifier_item_details_holder").prepend(draw_table_for_last_ten_sales_order);
                        $('#total_items_in_cart_last_10').text(itemCount);
                        $('#last_10_order_invoice_no').text(sale_no);
                        $('#total_items_qty_in_cart_last_10').text(totalQty);
                        $("#sub_total_show_last_10").text(parseFloat(single_item.sub_total).toFixed(op_precision));
                        $("#sub_total_last_10").text(parseFloat(single_item.sub_total).toFixed(op_precision));
                        $("#total_item_discount_last_10").text(parseFloat(single_item.item_discount_amount).toFixed(op_precision));
                        $("#discounted_sub_total_amount_last_10").text(parseFloat(single_item.sub_total_discount_amount).toFixed(op_precision));
                        $("#sub_total_discount_last_10").text(parseFloat(single_item.sub_total_discount_amount).toFixed(op_precision));
                        $("#all_items_vat_last_10").text(Number(single_item.total_vat).toFixed(op_precision));
                        $("#all_items_discount_last_10").text(parseFloat(single_item.total_discount_amount).toFixed(op_precision));
                        $("#delivery_charge_last_10").text(parseFloat(single_item.delivery_charge).toFixed(op_precision));
                        $("#paid_amount_last_10").text(parseFloat(find_this_item.paid_amount).toFixed(op_precision));
                        $("#due_amount_last_10").text(parseFloat(find_this_item.due_amount).toFixed(op_precision));
                        $("#total_payable_last_10").text(parseFloat(single_item.total_payable).toFixed(op_precision));
                    }
                };
            }; 
        }
        
    });


    // Code optimize by Azhar ** Final **
    $(document).on('click', '#delete_all_hold_sales_button', function () {
        if ($('.detail_hold_sale_holder .single_hold_sale').length > 0) {
            if(is_offline_system == '1'){
                $.ajax({
                    url: base_url + "Master/checkAccess",
                    method: "GET",
                    async: false,
                    dataType: 'json',
                    data: { controller: "138", function: "delete" },
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
                            Swal.fire({
                                title: warning + '!',
                                text: are_you_delete_all_hold_sale,
                                showDenyButton: true,
                                showCancelButton: false,
                                confirmButtonText: yes,
                                denyButtonText: cancel
                            }).then((result) => {
                                /* Read more about isConfirmed, isDenied below */
                                if (result.isConfirmed) {
                                    $.ajax({
                                        url: base_url + "Sale/delete_all_holds_with_information_by_ajax",
                                        method: "POST",
                                        data: {
                                            csrf_offpos: csrf_value_
                                        },
                                        success: function (response) {
                                            if (response == 1) {
                                                $('.hold_sale_modal_info_holder .detail_hold_sale_holder .hold_sale_left .detail_holder').empty();
                                            }
                                            holdSaleModalDataClear();
                                            $('#show_sale_hold_modal').removeClass('active');
                                            $(".pos__modal__overlay").fadeOut(300);
                                        }
                                    });
                                }
                            });
                        }
                    }
                });
            }else{
                Swal.fire({
                    title: warning + '!',
                    text: are_you_delete_all_hold_sale,
                    showDenyButton: true,
                    showCancelButton: false,
                    confirmButtonText: yes,
                    denyButtonText: cancel
                }).then((result) => {
                    if (result.isConfirmed) {
                        let request = indexedDB.open('off_pos_3', 3);
                        request.onerror = function(event) {
                            console.error("Database error: " + event.target.error);
                        };
                        request.onsuccess = function(event) {
                            let db = event.target.result;
                            let transaction = db.transaction(['draft_sales'], 'readwrite');
                            let objectStore = transaction.objectStore('draft_sales');
                            let clearRequest = objectStore.clear();
                            clearRequest.onerror = function(event) {
                                console.error("Error clearing data: " + event.target.error);
                            };
                            clearRequest.onsuccess = function(event) {
                                $('.hold_sale_modal_info_holder .detail_hold_sale_holder .hold_sale_left .detail_holder').empty();
                                holdSaleModalDataClear();
                                $('#show_sale_hold_modal').removeClass('active');
                                $(".pos__modal__overlay").fadeOut(300);
                                toastr['success'](('All Hold Sales deleted successfully'), 'Success');
                            };
                        };
                    }
                });
            }
        } else {
            toastr['error']((no_hold), '');
        }
    });


    
    // Code optimize by Azhar ** Final **
    $(document).on('click', '#hold_delete_button', function () {
        if ($('.single_hold_sale[data-selected=selected]').length > 0) {
            let hold_id = $('.single_hold_sale[data-selected=selected]').attr('id').substr(5);

            if(is_offline_system == '1'){
                $.ajax({
                    url: base_url + "Master/checkAccess",
                    method: "GET",
                    async: false,
                    dataType: 'json',
                    data: { controller: "138", function: "delete" },
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
                            Swal.fire({
                                title: warning + '!',
                                text: sure_delete_this_hold,
                                showDenyButton: true,
                                showCancelButton: false,
                                confirmButtonText: yes,
                                denyButtonText: cancel
                            }).then((result) => {
                                /* Read more about isConfirmed, isDenied below */
                                if (result.isConfirmed) {
                                    $.ajax({
                                        url: base_url + "Sale/delete_all_information_of_hold_by_ajax",
                                        method: "POST",
                                        data: {
                                            hold_id: hold_id,
                                            csrf_offpos: csrf_value_
                                        },
                                        success: function (response) {
                                            getAllHoldSales();
                                            holdSaleModalDataClear();
                                        }
                                    });
                                } 
                            });
                        }
                    }
                });
            }else{
                Swal.fire({
                    title: warning + '!',
                    text: sure_delete_this_hold,
                    showDenyButton: true,
                    showCancelButton: false,
                    confirmButtonText: yes,
                    denyButtonText: cancel
                }).then((result) => {
                    if (result.isConfirmed) {
                        let request = indexedDB.open('off_pos_3', 3);
                        request.onerror = function(event) {
                            console.error("Database error: " + event.target.error);
                        };
                        request.onsuccess = function(event) {
                            let db = event.target.result;
                            let transaction = db.transaction(['draft_sales'], 'readwrite');
                            let objectStore = transaction.objectStore('draft_sales');
                            
                            let getRequest = objectStore.get(parseInt(hold_id));
                            getRequest.onsuccess = function(event) {
                                let data = event.target.result;
                                if (data) {
                                    let deleteRequest = objectStore.delete(data.id);
                                    deleteRequest.onsuccess = function(event) {
                                        getAllHoldSales();
                                        holdSaleModalDataClear();
                                        toastr['success'](('Hold Sale deleted successfully'), 'Success');
                                    };
                                } else {
                                    toastr['error'](('Hold Sale Not Found'), '');
                                }
                            };
                        };
                    }
                });
            }
            
        } else {
            toastr['error']((please_select_hold_sale), '');
        }
    });

    // Code optimize by Azhar ** Final **
    $(document).on('click', '#last_ten_delete_button', function () {
        if ($('.single_last_ten_sale[data-selected=selected]').length > 0) {

            let recent_sale = $('.single_last_ten_sale[data-selected=selected]').attr('id').substr(9);

            if(is_offline_system == '1'){
                let sale_id = $('.single_last_ten_sale[data-selected=selected]').attr('id').substr(9);
                $.ajax({
                    url: base_url + "Master/checkAccess",
                    method: "GET",
                    async: false,
                    dataType: 'json',
                    data: { controller: "138", function: "delete" },
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
                            Swal.fire({
                                title: warning + '!',
                                text: sure_delete_this_sale,
                                showDenyButton: true,
                                showCancelButton: false,
                                confirmButtonText: yes,
                                denyButtonText: cancel
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $.ajax({
                                        url: base_url + "Sale/cancel_particular_order_ajax",
                                        method: "POST",
                                        data: {
                                            sale_id: sale_id,
                                            csrf_offpos: csrf_value_
                                        },
                                        success: function (response) {
                                            $("#last_ten_sales_button").click();
                                            recentSaleModalDataClear();
                                        }
                                    });
                                }
                            });
                        }
                    }
                });
            } else {
                let db;
                const request = indexedDB.open("off_pos", 2);
                request.onerror = function(event) {
                    console.error("Database error: " + event.target.error);
                };
                request.onsuccess = function(event) {
                    db = event.target.result;
                    const transaction = db.transaction(["sales"], "readwrite");
                    const objectStore = transaction.objectStore("sales");
                    const getRequest = objectStore.get(parseInt(recent_sale));
                    getRequest.onerror = function(event) {
                        console.log("Error fetching Rcent sale:", event.target.error);
                    };
                    getRequest.onsuccess = function(event) {
                        const recentSale = event.target.result;
                        if (recentSale) {
                            let deleteRequest = objectStore.delete(recentSale.id);
                            deleteRequest.onsuccess = function(event) {
                                getLastSale('', '', '', '');
                                toastr['success'](('Recent Sale deleted successfully'), 'Success');
                            };
                        } else {
                            toastr['error'](('Recent Sale Not Found'), '');
                        }
                    };
                }; 
            }    
        } else {
            toastr['error']((please_select_an_order), '');
        }
    });


    // Code optimize by Azhar ** Final **
    $(document).on('click', '#last_ten_print_invoice_button', function () {
        if ($('.single_last_ten_sale[data-selected=selected]').length > 0) {
            let sale_id = $('.single_last_ten_sale[data-selected=selected]').attr('id').substr(9);
            if(is_offline_system == '1'){
                printInvoice(sale_id);
            }else{
                const request = indexedDB.open("off_pos", 2);
                request.onsuccess = function(event) {
                    const db = event.target.result;
                    const transaction = db.transaction(["sales"], "readonly");
                    const objectStore = transaction.objectStore("sales");
                    // Get all records and sort by timestamp to get latest
                    const getAllRequest = objectStore.getAll();
                    getAllRequest.onsuccess = function(event) {
                        const allRecords = event.target.result;
                        if(allRecords.length > 0) {
                            allRecords.forEach(record => {
                                // If all AJAX requests are done, clear the 'sales' object store
                                if (record.id == parseInt(sale_id)) {
                                    printOfflineInvoice(record)
                                }
                            });
                        } 
                    };
                    getAllRequest.onerror = function(event) {
                        console.log("Error fetching records:", event);
                        toastr['error']("Error fetching records", '');
                    };
                };
                request.onerror = function(event) {
                    console.log("Error opening database:", event);
                    toastr['error']("Error opening database", '');
                };
            }
        } else {
            toastr['error']((please_select_an_order), '');
        }
    });


    // Code optimize by Azhar ** Final **
    $(document).on('click', '#last_ten_print_challan_button', function () {
        if ($('.single_last_ten_sale[data-selected=selected]').length > 0) {
            let sale_id = $('.single_last_ten_sale[data-selected=selected]').attr('id').substr(9);
            if(is_offline_system == '1'){
                printChallan(sale_id);
            }else{

                const request = indexedDB.open("off_pos", 2);
                request.onsuccess = function(event) {
                    const db = event.target.result;
                    const transaction = db.transaction(["sales"], "readonly");
                    const objectStore = transaction.objectStore("sales");
                    // Get all records and sort by timestamp to get latest
                    const getAllRequest = objectStore.getAll();
                    getAllRequest.onsuccess = function(event) {
                        const allRecords = event.target.result;
                        if(allRecords.length > 0) {
                            allRecords.forEach(record => {
                                if (record.id == parseInt(sale_id)) {
                                    printOfflineChallan(record);
                                }
                            });
                        } 
                    };
                    getAllRequest.onerror = function(event) {
                        console.log("Error fetching records:", event);
                        toastr['error']("Error fetching records", '');
                    };
                };
                request.onerror = function(event) {
                    console.log("Error opening database:", event);
                    toastr['error']("Error opening database", '');
                };
            }
        } else {
            toastr['error']((please_select_an_order), '');
        }


    });


    // Code optimize by Azhar ** Final **
    function bin2hex (s) {
        let i
        let l
        let o = ''
        let n
        s += ''
        for (i = 0, l = s.length; i < l; i++) {
            n = s.charCodeAt(i)
                .toString(16)
            o += n.length < 2 ? '0' + n : n
        }
        return o
    }

    // Code optimize by Azhar ** Final **
    $(document).on('click', '#print_last_invoice', function () {
        if(is_offline_system == '1'){
            let last_sale_id = ($("#last_sale_id").val());
            if (last_sale_id) {
                printInvoice(last_sale_id);
            } else {
                toastr['error']((please_select_an_order), '');
            }
        }else{
            const request = indexedDB.open("off_pos", 2);
            request.onsuccess = function(event) {
                const db = event.target.result;
                const transaction = db.transaction(["sales"], "readonly");
                const objectStore = transaction.objectStore("sales");
                // Get all records and sort by timestamp to get latest
                const getAllRequest = objectStore.getAll();
                getAllRequest.onsuccess = function(event) {
                    const allRecords = event.target.result;
                    if(allRecords.length > 0) {
                        let completedRequests = 0; 
                        const totalRequests = allRecords.length;
                        allRecords.forEach(record => {
                            completedRequests++;
                            // If all AJAX requests are done, clear the 'sales' object store
                            if (completedRequests === totalRequests) {
                                printOfflineInvoice(record)
                            }
                        });
                    } 
                };
                getAllRequest.onerror = function(event) {
                    console.log("Error fetching records:", event);
                    toastr['error']("Error fetching records", '');
                };
            };
            request.onerror = function(event) {
                console.log("Error opening database:", event);
                toastr['error']("Error opening database", '');
            };
        }
    });

    // Code optimize by Azhar ** Final **
    $(document).on('click', '.print_last_invoice', function () {
        if(is_offline_system == '1'){
            let last_sale_id = ($("#last_sale_id").val());
            if (last_sale_id) {
                printInvoice(last_sale_id);
            } else {
                toastr['error']((please_select_an_order), '');
            }
        }else{
            const request = indexedDB.open("off_pos", 2);
            request.onsuccess = function(event) {
                const db = event.target.result;
                const transaction = db.transaction(["sales"], "readonly");
                const objectStore = transaction.objectStore("sales");
                // Get all records and sort by timestamp to get latest
                const getAllRequest = objectStore.getAll();
                getAllRequest.onsuccess = function(event) {
                    const allRecords = event.target.result;
                    if(allRecords.length > 0) {
                        let completedRequests = 0; 
                        const totalRequests = allRecords.length;
                        allRecords.forEach(record => {
                            completedRequests++;
                            // If all AJAX requests are done, clear the 'sales' object store
                            if (completedRequests === totalRequests) {
                                printOfflineInvoice(record)
                            }
                        });
                    } 
                };
                getAllRequest.onerror = function(event) {
                    console.log("Error fetching records:", event);
                    toastr['error']("Error fetching records", '');
                };
            };
            request.onerror = function(event) {
                console.log("Error opening database:", event);
                toastr['error']("Error opening database", '');
            };
        }
    });

    // Code optimize by Azhar ** Final **
    $(document).on('click', '#hold_edit_in_cart_button', function () {

        $('#draft_sale_customer_status').val('Yes');

        let this_action = $(this);
        if(is_offline_system == '1'){
            if ($('.single_hold_sale[data-selected=selected]').length > 0) {
                $.ajax({
                    url: base_url + "Sale/checkAccess",
                    method: "GET",
                    async: false,
                    dataType: 'json',
                    data: { controller: "138", function: "add" },
                    success: function (response) {
                        if (response == false) {
                            toastr['error']((no_access), '');
                        } else {
                            let hold_id = $('.single_hold_sale[data-selected=selected]').attr('id').substr(5);
                            let total_items_in_cart = $('.order_holder .single_order').length;
                            if (total_items_in_cart > 0) {
                                Swal.fire({
                                    title: warning + "!",
                                    text: `Are you sure? previous cart data will be empty!`,
                                    showDenyButton: true,
                                    showCancelButton: false,
                                    confirmButtonText: yes,
                                    denyButtonText: cancel
                                }).then((result) => {
                                    /* Read more about isConfirmed, isDenied below */
                                    if (result.isConfirmed) {
                                        $(".order_holder").empty();
                                        clearFooterCartCalculation();
                                        getDetailsOfParticularHold(hold_id);
                                    }
                                });
                            } else {
                                clearFooterCartCalculation();
                                getDetailsOfParticularHold(hold_id);
                            }
                        }
                    }
                });
            } else {
                toastr['error']((please_select_hold_sale), '');
            }
        }else{
            let hold_id = $('.single_hold_sale[data-selected=selected]').attr('id').substr(5);
            let total_items_in_cart = $('.order_holder .single_order').length;
            if (total_items_in_cart > 0) {
                Swal.fire({
                    title: warning + "!",
                    text: `Are you sure? previous cart data will be empty!`,
                    showDenyButton: true,
                    showCancelButton: false,
                    confirmButtonText: yes,
                    denyButtonText: cancel
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $(".order_holder").empty();
                        clearFooterCartCalculation();
                        getDetailsOfParticularHold(hold_id);
                    }
                });
            } else {
                clearFooterCartCalculation();
                getDetailsOfParticularHold(hold_id);
            }
        }
        
    });


    // Code optimize by Azhar ** Final **
    $(document).on('click', '#hold_sales_close_button, #hold_sales_close_button_cross', function () {
        holdSaleModalDataClear();
        $('#show_sale_hold_modal').removeClass("active");
        $(".pos__modal__overlay").fadeOut(300);
    });

    // Code optimize by Azhar ** Final **
    $('#finalize_order_cancel_button').on('click', function () {
        resetFinalizeModal();
    });

    // Code optimize by Azhar ** Final **
    //load first category's items default at site load
    $(".specific_category_items_holder:first").show('1000');


    // Code optimize by Azhar ** Final **
    //get all images based on category when category button is clicked
    $(document).on('click', '.category_button', function () {
        let cat_id = $(this).attr('data-id');
        if(cat_id!=undefined){
            showAllItemByCategory(cat_id);
        }else{
            cat_id = '';
            showAllItemByCategory(cat_id);
        }

        setTimeout(function() {
            $('.category_items').animate({
                scrollTop: $("#searched_item_found").offset().top
            },100);
        },100);
    });

    // Code optimize by Azhar ** Final **
    //get all images based on category when category button is clicked
    $('.brand_button').on('click', function () {
        let brand_id = $(this).attr('id').substr(15);
        $("#search").val('');
        $('#alternative_item_render').html(`<h6>${Alternative_Medicine_will_shown_here} <iconify-icon icon="solar:smile-circle-broken"></iconify-icon></h6>`);
        showAllItems(brand_id,'');
    });

    // Code optimize by Azhar ** Final **
    $(document).on('click', '.button_category_show_all', function () {
        $("#search").val('');
        $('#alternative_item_render').html(`<h6>${Alternative_Medicine_will_shown_here} <iconify-icon icon="solar:smile-circle-broken"></iconify-icon></h6>`);
        showAllItems('','');
    });


    // Code optimize by Azhar ** Final **
    //when anything is searched
    $(document).on('keyup', '#search', function (e) {
        let searched_string = $(this).val().trim();
        let foundItems = searchItemAndConstructGallery(searched_string,'',1);
        let searched_category_items_to_show = `<div id="searched_item_found" class="specific_category_items_holder d-block"><div class="single-inner-div ${grocery_experience == 'Medicine' || grocery_experience == 'Grocery' ? 'grocery_single_on' : 'grocery_single_off'}">`;
        if(grocery_experience == 'Medicine' || grocery_experience == 'Grocery'){
            for (let key in foundItems) {
                if(foundItems[key].item_type != '0'){
                    if (foundItems.hasOwnProperty(key)) {
                        searched_category_items_to_show += `
                        <div item-type="${foundItems[key].item_type}" expiry_date_maintain="${foundItems[key].expiry_date_maintain}" plain-id="${foundItems[key].item_id}" data-last_purchase_price="${foundItems[key].last_purchase_price}" data-whole_sale_price="${foundItems[key].whole_sale_price}" data-sale_price="${foundItems[key].price}" class="single_item grocery_medicine_el    brand_${foundItems[key].brand_id} ${product_display == 'Image View' ? '' : 'bg-box-view'} d-flex align-items-center" id="item_${foundItems[key].item_id}">
                            <p class="item_name mt-0" data-tippy-content="${foundItems[key].item_name}(${foundItems[key].item_code})">
                                ${limitWords(foundItems[key].item_name, 3)} (${foundItems[key].item_code}) 
                                
                                ${grocery_experience != 'Medicine' ? (limitWords(foundItems[key].brand_name, 3)) : (limitWords(foundItems[key].supplier_name, 3))} 
                                
                                ${foundItems[key].generic_name ? '<br> <small class="generic_small">Generic Name: ' + limitWords(foundItems[key].generic_name, 2) + '</small>' : ''}
                            </p>
                            <p class="d-none generic_name generic_name_gm ${$.trim(foundItems[key].generic_name) ? '' : 'd-none'}" data-tippy-content="${$.trim(foundItems[key].generic_name) ? $.trim(foundItems[key].generic_name) : ''}">Generic Name: ${$.trim(foundItems[key].generic_name) ? $.trim(foundItems[key].generic_name) : ''}</p>
                            <p class="item_price item_price_gm">
                                Sale Price: <span id="price_${foundItems[key].item_id}">${parseFloat(foundItems[key].price).toFixed(op_precision)}</span><br>
                                <span>${ (foundItems[key].rack_name == '' || foundItems[key].rack_name == 'null' || foundItems[key].rack_name == null || foundItems[key].rack_name == 'NULL') ?  '' : 'Rack No : '+foundItems[key].rack_name}</span> 
                            </p>
                            <span class="item_vat_percentage d-none">${foundItems[key].vat_percentage}</span>
                        </div>`;
                    }
                }
            }
        }else{
            for (let key in foundItems) {
                if(foundItems[key].item_type != '0'){
                    if (foundItems.hasOwnProperty(key)) {
                        searched_category_items_to_show += `
                        <div item-type="${foundItems[key].item_type}" expiry_date_maintain="${foundItems[key].expiry_date_maintain}" plain-id="${foundItems[key].item_id}" data-last_purchase_price="${foundItems[key].last_purchase_price}" data-whole_sale_price="${foundItems[key].whole_sale_price}" data-sale_price="${foundItems[key].price}" class="single_item brand_${foundItems[key].brand_id} ${product_display == 'Image View' ? '' : 'bg-box-view'}" id="item_${foundItems[key].item_id}">
                            <div class="single-item-img">
                                <img src="${foundItems[key].image}" alt="" class="${product_display == 'Image View' ? 'd-block' : 'd-none'}">
                            </div>
                            <p class="item_name" data-tippy-content="${foundItems[key].item_name}(${foundItems[key].item_code})">${foundItems[key].item_name}${foundItems[key].brand_name} (${foundItems[key].item_code})</p>
                            <p class="generic_name ${$.trim(foundItems[key].generic_name) ? '' : 'd-none'}" data-tippy-content="${$.trim(foundItems[key].generic_name) ? $.trim(foundItems[key].generic_name) : ''}">${$.trim(foundItems[key].generic_name) ? $.trim($.trim(foundItems[key].generic_name)) : ''}</p>
                            <p class="item_price">SP: <span id="price_${foundItems[key].item_id}">${parseFloat(foundItems[key].price).toFixed(op_precision)}</span></p>
                            <span class="item_vat_percentage d-none">${foundItems[key].vat_percentage}</span>
                        </div>`;
                    }
                }
            }
        }
        if(searched_string){
            if(foundItems[0]){
                let array_as = {};            
                if(foundItems[0].item_type != '0'){
                    if (foundItems.hasOwnProperty(0)) {
                        if(foundItems[0].generic_name){
                            console.log(foundItems[0].generic_name);
                            let foundItemsForItems = searchItemAndConstructGalleryAlternative(foundItems[0].generic_name,'','');
                            for (let key1 in foundItemsForItems) {
                            if(foundItemsForItems[key1].item_type != '0'){
                                if (foundItemsForItems.hasOwnProperty(key1)) {
                                    if(!array_as[foundItemsForItems[key1].item_id]){
                                        array_as[foundItemsForItems[key1].item_id] = foundItemsForItems[key1].item_id;
                                    }
                                }
                            }
                            }
                        }
                    }
                }
                let alternativeProduct = '';
                for (let ar in array_as) {
                    let item_details = findItemByItemId(ar);
                    if(item_details.item_type != '0'){
                        let if_exist = true;
                        for (let key in foundItems) {
                            if(foundItems[key].item_id==ar){
                                if_exist = false;
                            }
                        }
                        if(if_exist==true){
                            alternativeProduct+=`<div class="alternative-medicine single_item medicine_el  brand_${item_details.brand_id}" item-type="${item_details.item_type}" plain-id="${item_details.item_id}" data-last_purchase_price="${item_details.last_purchase_price}" data-whole_sale_price="${item_details.whole_sale_price}" data-sale_price="${item_details.price}" id="item_${item_details.item_id}">
                            <p class="item_name" data-tippy-content="${item_details.item_name}(${item_details.item_code})">${item_details.item_name}${item_details.brand_name} (${item_details.item_code})</p>
                            <p class="generic_name ${$.trim(item_details.generic_name) ? '' : 'd-none'}" data-tippy-content="${$.trim(item_details.generic_name) ? $.trim(item_details.generic_name) : ''}">${$.trim(item_details.generic_name) ? $.trim($.trim(item_details.generic_name)) : ''}</p>
                            <p class="item_price">SP: <span id="price_${item_details.item_id}">${parseFloat(item_details.price).toFixed(op_precision)}</span></p>
                            <span class="item_vat_percentage d-none">${item_details.vat_percentage}</span>
                        </div>`;
                        }
                    }
                }
                
                if(alternativeProduct){
                    $('#alternative_item_render').html('');
                    $('#alternative_item_render').html(alternativeProduct);
                    $('#main_left').addClass('alternative-exist');
                }else{
                    $('#main_left').removeClass('alternative-exist');
                    $('#alternative_item_render').html(`<h6>${Alternative_Medicine_will_shown_here} <iconify-icon icon="solar:smile-circle-broken"></iconify-icon></h6>`);
                }
                setTimeout(function(){
                    $(".grocery_medicine_el").eq(0).addClass('active_gm');
                }, 100);
            }
        }else{
            $('#alternative_item_render').html('');
            $('#main_left').removeClass('alternative-exist');
            $('#alternative_item_render').html(`<h6>${Alternative_Medicine_will_shown_here} <iconify-icon icon="solar:smile-circle-broken"></iconify-icon></h6>`);
        }
        searched_category_items_to_show += `<div></div>`;
        $("#searched_item_found").remove();
        $('.specific_category_items_holder').hide('1000');
        $(".category_items").html(searched_category_items_to_show);
    });


    // Code optimize by Azhar ** Final **
    $(document).on('click', '.model_price_three', function () {
        let value = $(this).find(".s_sale").text()
        $('#modal_item_price').text(value);
        $('#modal_item_price_input_field').val(value);
        updateCartItemPrice();
    });

    // Code optimize by Azhar ** Final **

    $(document).on('keyup', '.comboCalculation', function(){
        let cThis = $(this);
        comboCalculation(cThis);
    });

    function comboCalculation(cThis){
        let unit_price = $(cThis).parent().parent().find('.combo_unit_price').val();
        let quantity = $(cThis).parent().parent().find('.combo_quantity').val();
        let combIFSale;
        if(isNaN(quantity) || quantity == ''){
            quantity = 0;
        }else{
            quantity = parseFloat(quantity);
        }
        if(isNaN(unit_price) || unit_price == ''){
            unit_price = 0;
        }else{
            unit_price = parseFloat(unit_price);
        }
        $(cThis).parent().parent().find('.subtotal_combo').text(parseFloat(quantity * unit_price).toFixed(op_precision));
        let total = 0;
        let totalSum = 0;
        $('.subtotal_combo').each(function(){
            combIFSale = $(this).parent().parent().find('.to_sales_item').is(':checked');
            if(combIFSale){
                total = $(this).text();
                if(isNaN(total) || total == ''){
                    total = 0;
                }else{
                    total = parseFloat(total);
                    totalSum += total;
                }
            }
        });
        $('#modal_item_price_input_field').val(parseFloat(totalSum).toFixed(op_precision));
        $('#s_price').text(parseFloat(totalSum).toFixed(op_precision));
    }



    //when single ite is clicked pop-up modal is appeared
    $(document).on('click', '.single_item', function () {
        let selector = $('.single-inner-div').find('.active_gm');
        selector.removeClass('active_gm');
        $('.single_item').removeClass('active_gm_temp');
        $(this).addClass('active_gm_temp');
        let itemName = $(this).find('.item_name').text();
        let cartItemLength = $('.order_holder .single_order').length;
        let item_type = $(this).attr('item-type');
        let expiry_date_maintain = $(this).attr('expiry_date_maintain');
        let item_id = $(this).attr('plain-id');
        $('#bulk_import_for_sale_item_id').val(item_id);
        $('#bulk_import_for_sale_item_type').val(item_type);
        $('#bulk_import_at_stock_item_id').val(item_id);
        $('#bulk_import_at_stock_item_type').val(item_type);
        let is_promo = $(this).attr('is_promo');
        $('#edit_item_modal_header').text(itemName);
    
        if(item_type == 'Service_Product'){
            $('.service_disabled').css({
                'pointer-events':'none',
                'opacity':'0.5',
                'cursor':'not-allowed',
            });
        } else {
            $('.service_disabled').css({
                'pointer-events':'unset',
                'opacity':'unset',
                'cursor':'unset',
            });
        }
        
        if(item_type == 'IMEI_Product' || item_type == 'Serial_Product'){
            $('.bulk_imei_serial_upload').show();
        }else{
            $('.bulk_imei_serial_upload').hide();
        }

        if(item_type == 'Medicine_Product' && expiry_date_maintain == 'No'){
            $('.item_enable_disable').prop('disabled', false);
        }
        if(item_type == 'IMEI_Product' || item_type == 'Serial_Product' || (item_type == 'Medicine_Product' && expiry_date_maintain == 'Yes')){
            if (window.matchMedia("(min-width: 320px) and (max-width: 575.98px)").matches) {
                $('.item-modal-top-header').css({
                    'grid-template-columns':'1fr',
                });
            }else{
                $('.item-modal-top-header').css({
                    'grid-template-columns':'32% 32% 32%',
                });
            }
            $('#IMEI_Serial').attr('tabindex', '0');
            if(item_type == 'IMEI_Product' || item_type == 'Serial_Product'){
                $('.item_enable_disable').css({
                    'cursor':'not-allowed',
                });
            }else{
                $('.item_enable_disable').css({
                    'cursor':'pointer',
                });
            }
        }else{
            $('#modal_item_price_input_field').focus();
            $('.item_enable_disable').css({
                'cursor':'pointer',
            });
            $('.item-modal-top-header').css({
                'grid-template-columns':'65% 33%',
            });
            $('.modal_stock_wrapper p').css({
                'text-align':'left',
            });
        }

        if(item_type == 'Combo_Product'){
            $('.combo_product_html_render').show();
        }else{
            $('.combo_product_html_render').hide();
        }

        $('#seller_id').attr('tabindex', '-1');
        if(cartItemLength == '0'){
            itemAppentToCart(item_id, item_type, is_promo, 1);
        }else{
            let current_row = '';
            let matchRow = '';
            let item_type_single = '';
            $('.order_holder .single_order').each(function(){
                item_type_single = $(this).find('.item_type ').text();
                current_row = $(this).attr('data_cart_item_id');
                if(item_type_single != 'IMEI_Product' && item_type_single != 'Serial_Product' && item_type_single != 'Medicine_Product'){
                    if(item_id == current_row){
                        $(this).find('.edit_item').click();
                        matchRow = '1';
                    }
                }else if(item_type_single == 'Medicine_Product' &&  expiry_date_maintain == 'No'){
                    if(item_id == current_row){
                        $(this).find('.edit_item').click();
                        matchRow = '1';
                    } 
                }
            });
            if(matchRow == ''){
                itemAppentToCart(item_id, item_type, is_promo, 1); 
            }
        }
    });

    function itemAppentToCart(item_id, item_type, is_promo, default_qty){
        if(is_offline_system == '1'){
            if(item_type != 'Service_Product' && item_type != 'Combo_Product'){
                if(item_type == 'Variation_Product'){
                    callAddToCartModal(item_id, item_type, default_qty);
                }else{
                    $.ajax({
                        url: base_url + "Sale/stockCheckingForThisOutletById",
                        method: "POST",
                        dataType: 'json',
                        async: false,
                        data: { item_id: item_id},
                        success: function (response) {
                            if(response.status == 'success'){
                                $('.current_stock_t').text((Number(response.data)).toFixed(op_precision));
                                $('#current_stock_hidden').val((Number(response.data)).toFixed(op_precision));
                                if(Number(response.data) > 0){ 
                                    if(is_promo == 'Yes'){
                                        callAddToCartModal(item_id, item_type, default_qty);
                                    }else if(direct_cart == 'Yes' && item_type == 'General_Product'){
                                        generalItemdirectAddToCart(item_id, item_type, default_qty)
                                    }else{
                                        callAddToCartModal(item_id, item_type, default_qty);
                                    }
                                }else{
                                    if(is_promo == 'Yes' && allow_less_sale == 'Yes'){
                                        callAddToCartModal(item_id, item_type, default_qty);
                                    }else if(direct_cart == 'Yes' && item_type == 'General_Product' && allow_less_sale == 'Yes'){
                                        generalItemdirectAddToCart(item_id, item_type, default_qty)
                                    }else if(allow_less_sale == 'Yes'){
                                        callAddToCartModal(item_id, item_type, default_qty);
                                    }else{
                                        toastr['error'](("Over selling is not allowed!"), '');
                                        if($(`#item_${item_id}`).hasClass('active_gm_temp')){
                                            $(`#item_${item_id}`).removeClass('active_gm_temp');
                                        }
                                    }
                                }
                            }
                        }
                    });
                }
            }else if(item_type == 'Service_Product'){
                callAddToCartModal(item_id, item_type, default_qty)
            }else if(item_type == 'Combo_Product'){
                callAddToCartModal(item_id, item_type, default_qty)
            }else{
                generalItemdirectAddToCart(item_id, item_type, default_qty)
            }
        } else {
            if(item_type != 'Service_Product' && item_type != 'Combo_Product'){
                if(item_type == 'Variation_Product'){
                    callAddToCartModal(item_id, item_type, default_qty);
                }else{

                    // Open a connection to the IndexedDB database
                    let request = indexedDB.open('off_pos_2', 2);

                    request.onerror = function(event) {
                        console.log("Error opening the database:", event.target.error ? event.target.error.message : "Unknown error");
                    };

                    request.onsuccess = function(event) {
                        let db = event.target.result;
                        // Start a transaction to read from the database
                        let transaction = db.transaction(['items'], 'readonly');
                        let objectStore = transaction.objectStore('items');
                        // Use getAll() to read all data from the 'items' object store
                        let getAllRequest = objectStore.getAll();
                        getAllRequest.onsuccess = function(event) {
                            let items = event.target.result;
                            let product = items[0].find(function(item) {
                                return item.id == item_id;
                            });
                            if(product){
                                $('.current_stock_t').text((Number(product.stock_qty - product.out_qty)).toFixed(op_precision));
                                $('#current_stock_hidden').val((Number(product.stock_qty - product.out_qty)).toFixed(op_precision));
                                if(Number(product.stock_qty - product.out_qty) > 0){ 
                                    if(is_promo == 'Yes'){
                                        callAddToCartModal(item_id, item_type, default_qty);
                                    }else if(direct_cart == 'Yes' && item_type == 'General_Product'){
                                        generalItemdirectAddToCart(item_id, item_type, default_qty)
                                    }else{
                                        callAddToCartModal(item_id, item_type, default_qty);
                                    }
                                }else{
                                    if(is_promo == 'Yes' && allow_less_sale == 'Yes'){
                                        callAddToCartModal(item_id, item_type, default_qty);
                                    }else if(direct_cart == 'Yes' && item_type == 'General_Product' && allow_less_sale == 'Yes'){
                                        generalItemdirectAddToCart(item_id, item_type, default_qty)
                                    }else if(allow_less_sale == 'Yes'){
                                        callAddToCartModal(item_id, item_type, default_qty);
                                    }else{
                                        toastr['error'](("Over selling is not allowed!"), '');
                                    }
                                }  
                            }
                        };
                        getAllRequest.onerror = function(event) {
                            console.log("Error reading data:", event.target.error.message);
                        };
                    };
                }
            }else if(item_type == 'Service_Product'){
                callAddToCartModal(item_id, item_type, default_qty)
            }else if(item_type == 'Combo_Product'){
                callAddToCartModal(item_id, item_type, default_qty)
            }else{
                generalItemdirectAddToCart(item_id, item_type, default_qty)
            }
        }
    }


    function generalItemdirectAddToCart(item_id, item_type, default_qty){
        let customerPrice = 0;
        let cDiscount = 0;
        let qtyItem = default_qty;
        let readonlyAttr = '';
        let customerPriceType = $("#walk_in_customer option:selected").attr("price_type");
        let customerDiscount = $("#walk_in_customer option:selected").attr("discount");
        let item_object = findItemByItemId(item_id);
        if(customerPriceType == 1){
            customerPrice = item_object.price;
        }else if(customerPriceType == 2){
            customerPrice = item_object.whole_sale_price;
        }else{
            customerPrice = item_object.price;
        }

        if(item_object.is_promo == 'Yes'){
            if(item_object.promo_discount){
                cDiscount = item_object.promo_discount;
            }else{
                cDiscount = 0;
            }
            $(`#percentage_table_${item_object.item_id}`).prop('readonly', true);
        }else{
            if(customerDiscount){
                cDiscount = customerDiscount;
            }else{
                cDiscount = 0;
            }
        }
        modalFieldHideShowByItemType(item_type, item_object.expiry_date_maintain)
        let draw_table_for_order = '';
        draw_table_for_order = `<div class="single_order" is_promo="${item_object.is_promo}" data-qty_default="1" data-sale-unit="${item_object.sale_unit_name}" id="order_for_item_${item_id}" data-single-order-row-no="" data_cart_item_id="${item_id}">
            <div class="first_portion">
                <span id="item_seller_table${item_id}" class="d-none"></span>
                <span class="item_type d-none" id="item_type_table${item_id}">${item_type}</span>
                <span class="item_vat d-none" id="item_vat_percentage_table${item_id}">${item_object.tax_information}</span>
                <span class="item_discount d-none" id="item_discount_table${item_id}">${percentValueCalculateByPriceQtyDiscount(customerPrice, qtyItem, cDiscount)}</span>
                <span class="item_price_without_discount d-none" id="item_price_without_discount_${item_id}">${Number(customerPrice) * Number(qtyItem)}</span>
                <div class="single_order_column first_column">
                    <iconify-icon icon="solar:pen-broken" class="op_cursor_pointer edit_item" id="edit_item_${item_id}" width="22"></iconify-icon>
                    <span id="item_name_table_${item_id}">${item_object.item_name + '(' + item_object.item_code + ')'}</span>
                </div>
                <div class="single_order_column second_column">
                    <span id="item_price_table_${item_id}">${customerPrice}</span>
                </div>
                <div class="single_order_column third_column">
                    <iconify-icon icon="uil:minus" class="decrease_item_table op_cursor_pointer" id="decrease_item_table_${item_id}" width="22"></iconify-icon>
                    <span class="cart_quantity" id="item_quantity_table_${item_id}">${qtyItem}</span> 
                    <iconify-icon icon="uil:plus" class="increase_item_table op_cursor_pointer" id="increase_item_table_${item_id}" width="22"></iconify-icon>
                </div>
                <div class="single_order_column forth_column">
                    <input type="" name="" onfocus="select();" inline_dis_column="${item_id}" placeholder="Amt or %" class="special_textbox access_control inline_dis_column" id="percentage_table_${item_id}" value="${cDiscount == '' ? Number(0) : cDiscount}" ${readonlyAttr}>
                </div>
                <div class="single_order_column fifth_column">
                    <span id="item_total_price_table_${item_id}">${subtotalCalculateByPriceQtyDiscount(customerPrice,qtyItem,cDiscount)}</span> 
                    <iconify-icon icon="solar:trash-bin-minimalistic-broken" data-remove-order-row-no="" class="remove_this_item_from_cart" width="22"></iconify-icon>
                </div>
            </div>
            <span class="cart_item_modal_des item_modal_description_table_${item_id}"></span>
        </div>`;

        posDefaultCursor();
        $('#search').val('');
        $('#search_barcode').val('');

        $(".order_holder").append(draw_table_for_order);
        if(edit_mode == ''){
            storageCartDataInLocal();
        }
        itemModalHiddenDataClear();
        setTimeout(function(){
            cartItemCalculationInPOS();
        }, 300);
        cartMobileItemCount();
        cartMobileSuccessMsgAndItemCount();
    }
    


    function callAddToCartModal(item_id, item_type, default_unit){
        // Modal Field Hide Show By Item Type
        productSound1.play();
        let combo_checker = '';
        let modalQty = 0;
        let discount_global = '';
        let customer_price_type = $("#walk_in_customer option:selected").attr("price_type");
        let customer_discount = $("#walk_in_customer option:selected").attr("discount");
        let item_object = findItemByItemId(item_id);
        modalFieldHideShowByItemType(item_type, item_object.expiry_date_maintain);
        if(item_type == 'General_Product'){
            modalQty = 1;
            $('#item_quantity_modal_input').val(Number(default_unit));
            $('#sale_unit_name_modal').text(item_object.sale_unit_name);
            $('.item-modal-top-header').show();
            $('.modal_qty_area').removeClass('item_modal_quantity_area_disabled');
        }else if(item_type == 'Installment_Product'){
            modalQty = 1;
            $('#item_quantity_modal_input').val(Number(default_unit));
            $('#sale_unit_name_modal').text(item_object.sale_unit_name);
            $('.item-modal-top-header').show();
            $('.modal_qty_area').removeClass('item_modal_quantity_area_disabled');
        }else if(item_type == 'IMEI_Product' || item_type == 'Serial_Product'){

            $('.item_type_heading').text(`Available ${item_type == 'IMEI_Product' ? 'IMEI Number' : 'Serial Number'}`);
            modalQty = 1;
            $('#item_quantity_modal_input').val(Number(0));

            if(is_offline_system == '1'){
                $('#sale_unit_name_modal').text(item_object.sale_unit_name);
                $.ajax({
                    url: base_url + "Sale/getIMEISerial",
                    method: "POST",
                    async: false,
                    dataType: 'json',
                    data: { item_id: item_id },
                    success: function (response) {
                        let imeiHtml = '';
                        imeiHtml = `<option value="">Select ${item_type == 'IMEI_Product' ? 'IMEI' : 'Serial'}</option>`;
                        if(response.data.allimei){
                            let stockIMEI = response.data.allimei.split("||");
                            $.each(stockIMEI, function (i, v) { 
                                imeiHtml += `<option value="${$.trim(v)}">${$.trim(v)}</option>`;
                            });
                        }
                        $('#IMEI_Serial').html('');
                        $('#IMEI_Serial').append(imeiHtml);
                    }
                });
                $('.item-modal-top-header').show();
                $('.modal_qty_area').removeClass('item_modal_quantity_area_disabled');
            } else{
                // Open a connection to the IndexedDB database
                let request = indexedDB.open('off_pos_2', 2);

                request.onerror = function(event) {
                    console.log("Error opening the database:", event.target.error ? event.target.error.message : "Unknown error");
                };

                request.onsuccess = function(event) {
                    let db = event.target.result;
                    // Start a transaction to read from the database
                    let transaction = db.transaction(['items'], 'readonly');
                    let objectStore = transaction.objectStore('items');
                    // Use getAll() to read all data from the 'items' object store
                    let getAllRequest = objectStore.getAll();
                    getAllRequest.onsuccess = function(event) {
                        let items = event.target.result;
                        let product = items[0].find(function(item) {
                            return item.id == item_id;
                        });
                        // console.log(product);
                        if(product){
                            let imeiHtml = '';
                            imeiHtml = `<option value="">Select ${item_type == 'IMEI_Product' ? 'IMEI' : 'Serial'}</option>`;
                            if(product.allimei){
                                product.allimei.map(function(imei_serial) {
                                    imeiHtml += `<option value="${$.trim(imei_serial.single_imei_serial)}">${$.trim(imei_serial.single_imei_serial)}</option>`;
                                });
                            }
                            $('#IMEI_Serial').html('');
                            $('#IMEI_Serial').append(imeiHtml);
                            $('.item-modal-top-header').show();
                            $('.modal_qty_area').removeClass('item_modal_quantity_area_disabled');
                        }
                    };
                    getAllRequest.onerror = function(event) {
                        console.log("Error reading data:", event.target.error.message);
                    };
                };
            }
            
        }else if(item_type == 'Medicine_Product'){
            $('.item_type_heading').text('Expiry Dates');
            if(is_offline_system == '1'){
                $('#sale_unit_name_modal').text(item_object.sale_unit_name);
                if(item_object.expiry_date_maintain == 'Yes'){
                    modalQty = 0;
                    $('#item_quantity_modal_input').val(Number(0));
                    $.ajax({
                        url: base_url + "Sale/getExpiryByOutlet",
                        method: "POST",
                        async: false,
                        dataType: 'json',
                        data: { item_id: item_id },
                        success: function (response) {
                            let expiryHtml = '';
                            expiryHtml = `<option value="">Select Expiry</option>`;
                            if(response.data){
                                $.each(response.data, function (i, v) { 
                                    if(v.stock_quantity != 0){
                                        expiryHtml += `<option value="${$.trim(v.expiry_imei_serial)}">${$.trim(v.expiry_imei_serial)}</option>`;
                                    }
                                });
                            }
                            $('#IMEI_Serial').html('');
                            $('#IMEI_Serial').append(expiryHtml);
                        }
                    });
                }else{
                    modalQty = 1;
                    $('#item_quantity_modal_input').val(Number(1));
                }
            } else {
                if(item_object.expiry_date_maintain == 'Yes'){
                    // Open a connection to the IndexedDB database
                    let request = indexedDB.open('off_pos_2', 2);
                    request.onerror = function(event) {
                        console.log("Error opening the database:", event.target.error ? event.target.error.message : "Unknown error");
                    };
                    request.onsuccess = function(event) {
                        let db = event.target.result;
                        // Start a transaction to read from the database
                        let transaction = db.transaction(['items'], 'readonly');
                        let objectStore = transaction.objectStore('items');
                        // Use getAll() to read all data from the 'items' object store
                        let getAllRequest = objectStore.getAll();
                        getAllRequest.onsuccess = function(event) {
                            let items = event.target.result;
                            let product = items[0].find(function(item) {
                                return item.id == item_id;
                            });
                            if(product){
                                modalQty = 0;
                                $('#item_quantity_modal_input').val(Number(0));
                                let expiryHtml = '';
                                expiryHtml = `<option value="">Select Expiry</option>`;
                                if(product.allexpiry){
                                    product.allexpiry.map(function(single_expiry) {
                                        for (let key_date in single_expiry) {
                                            expiryHtml += `<option value="${$.trim(key_date)}">${$.trim(key_date)}</option>`;
                                        }
                                    });
                                }
                                $('#IMEI_Serial').html('');
                                $('#IMEI_Serial').append(expiryHtml);
                            }
                        };
                        getAllRequest.onerror = function(event) {
                            console.log("Error reading data:", event.target.error.message);
                        };
                    };
                }else{
                    modalQty = 1;
                    $('#item_quantity_modal_input').val(Number(1));
                }
            }
            $('.item-modal-top-header').show();
            $('.modal_qty_area').removeClass('item_modal_quantity_area_disabled');
        }else if(item_type == 'Variation_Product'){
            $('.current_stock_t').text(Number(0).toFixed(op_precision));
            $('.item_type_variation_heading').text('Variations');
            $('#variation_parent').text(item_id);
            modalQty = 0;
            $('#item_quantity_modal_input').val(Number(0));

            if(is_offline_system == '1'){
                $.ajax({
                    url: base_url + "Sale/getVariationByItemId",
                    method: "POST",
                    async: false,
                    dataType: 'json',
                    data: { item_id: item_id },
                    success: function (response) {
                        if(response.status == 'success'){
                            let variationHtml = '';
                            $.each(response.data, function (i, v) { 
                                variationHtml += `<div data-variation-parent="${item_id}" class="container variationSingleItem" data-is-promo="" data-item-id="${v.id}" id="item-id-${v.id}" data-item-name="${v.parent_name +' ' + v.name + '('+v.code+')'}" data-sale-price="${v.sale_price ? v.sale_price : 0}" data-whole-sale-price="${v.whole_sale_price ? v.whole_sale_price : 0}" data-purchase-price="${v.purchase_price ? v.purchase_price : 0 }" data-menu-tax='${v.tax_information}' data-sale-unit="${v.sale_unit_name}">
                                    <span>${v.name}</span>
                                    <span class="pl-10">Price: ${v.sale_price}</span>
                                    <input type="radio" name="variation_items">
                                    <span class="checkmark"></span>
                                </div>`;
                            });
                            $('.variationProductHtmlRender').html('');
                            $('.variationProductHtmlRender').append(variationHtml);
                        }
                    }
                });
            } else {
                // Open a connection to the IndexedDB database
                let request = indexedDB.open('off_pos_2', 2);
                request.onerror = function(event) {
                    console.log("Error opening the database:", event.target.error ? event.target.error.message : "Unknown error");
                };
                request.onsuccess = function(event) {
                    let db = event.target.result;
                    // Start a transaction to read from the database
                    let transaction = db.transaction(['items'], 'readonly');
                    let objectStore = transaction.objectStore('items');
                    // Use getAll() to read all data from the 'items' object store
                    let getAllRequest = objectStore.getAll();
                    getAllRequest.onsuccess = function(event) {
                        let items = event.target.result;
                        let product = items[0].find(function(item) {
                            return item.id == item_id;
                        });
                        if(product){
                            let variationHtml = '';
                            let item_obj;
                            $.each(product.variations, function (i, v) { 
                                console.log();
                                item_obj = findItemByItemId(v.vId);
                                variationHtml += `<div data-variation-parent="${product.id}" class="container variationSingleItem" data-is-promo="" data-item-id="${v.vId}" id="item-id-${v.vId}" data-item-name="${product.name +' ' + v.name + '('+v.code+')'}" data-sale-price="${item_obj.price ? item_obj.price : 0}" data-whole-sale-price="${item_obj.whole_sale_price ? item_obj.whole_sale_price : 0}" data-purchase-price="${item_obj.purchase_price ? item_obj.purchase_price : 0 }" data-menu-tax='${item_obj.tax_information}' data-sale-unit="${item_obj.sale_unit_name}">
                                    <span>${v.name}</span>
                                    <span class="pl-10">Price: ${item_obj.price}</span>
                                    <input type="radio" name="variation_items">
                                    <span class="checkmark"></span>
                                </div>`;
                            });
                            $('.variationProductHtmlRender').html('');
                            $('.variationProductHtmlRender').append(variationHtml);
                        }
                    };
                    getAllRequest.onerror = function(event) {
                        console.log("Error reading data:", event.target.error.message);
                    };
                };
            }

            $('.item-modal-top-header').show();
        }else if(item_type == 'Combo_Product'){
            if(is_offline_system == '1'){
                $('.item-modal-top-header').hide();
                $('.modal_qty_area').addClass('item_modal_quantity_area_disabled');
                $.ajax({
                    url: base_url + "Sale/getComboItemCheck",
                    method: "POST",
                    async: false,
                    dataType: 'json',
                    data: { item_id: item_id },
                    success: function (response) {
                        if(response.status == 'success'){
                            if(!response.data.combo_items){
                                Swal.fire({
                                    title: warning + "!",
                                    text: `No Combo  items found of this  product.`,
                                    showDenyButton: false,
                                    showCancelButton: false,
                                    confirmButtonText: ok,
                                });
                                combo_checker = 'Not Exist';
                            }
                            let html = '';
                            let html2 = '<option value="">Select Employee</option>';
                            $.each(response.data.sellers, function (i, v) { 
                                html2+=`<option value="${v.id}">${v.full_name}</option>`;
                            });
                            $.each(response.data.combo_items, function (i, v) { 
                                html +=`<li>
                                    <div>${i + 1}</div>
                                    <div class="text-center">
                                        <label class="container">
                                            <input type="checkbox" class="show_in_invoice" ${v.show_invoice == 'Yes' ? 'checked' : ''}>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="text-center">
                                        <label class="container">
                                            <input type="checkbox" class="to_sales_item" checked>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div>
                                        <p class="combo_name">${v.item_name}</p>
                                        <input type="hidden" class="combo_type" value="${v.type}">
                                        <input type="hidden" class="combo_child_id" value="${v.child_combo_item_id}">
                                        <input type="hidden" class="combo_parent_id" value="${v.combo_parent_id}">
                                    </div>
                                    <div>
                                        <input type="text" class="form-control combo_quantity  comboCalculation" value="${parseFloat(v.quantity)}">
                                    </div>
                                    <div>
                                        <input type="text" class="form-control combo_unit_price  comboCalculation" value="${parseFloat(v.unit_price)}">
                                    </div>
                                    <div>
                                        <p class="subtotal_combo comboCalculation text-center">${(parseFloat(v.quantity) * parseFloat(v.unit_price)).toFixed(op_precision)}</p>
                                    </div>
                                    <div>
                                        <select class="inline_seller_id select2">
                                            ${html2}
                                        </select>
                                    </div>
                                </li>`;
                            });
                            $('.combo_product_html_render .combo_modal_body').html('');
                            $('.combo_product_html_render .combo_modal_body').append(html);
                            $(".select2").select2();
                        }
                    }
                });
            }else {
                toastr['error'](("In Offline Sync can't sale combo items"), '');
            }
        }else{
            modalQty = 1;
            $('#item_quantity_modal_input').val(Number(default_unit));
        }

        posDefaultCursor();
        $('#search').val('');
        $('#search_barcode').val('');
        cartItemCalculationInPOS();
        // Item Info
        $('#modal_item_name').text(item_object.item_name + '(' + item_object.item_code + ')');
        $('#modal_is_promo').text(item_object.is_promo);
        $('#modal_promo_buy_qty').text(item_object.promo_qty);
        $('#modal_promo_get_qty').text(item_object.promo_get_qty);
        $('#modal_promo_discount').text(item_object.promo_discount);
        $('#modal_promo_item_id').text(item_object.promo_item_id);
        $('#modal_promo_type').text(item_object.promo_type);
        $('#modal_item_id').text(item_object.item_id);
        $('#modal_item_type').text(item_object.item_type);
        $('#modal_item_sale_unit').text(item_object.sale_unit_name);
        $('#modal_item_vat_percentage').text(item_object.tax_information);
        if(view_purchase_price == 'Yes'){
            $('#w_s_price').text(Number(item_object.whole_sale_price).toFixed(op_precision));
            $('#m_p_price').text(Number(item_object.last_purchase_price / item_object.conversion_rate).toFixed(op_precision));
        }else{
            $('#w_s_price').text(Number(0).toFixed(op_precision));
            $('#m_p_price').text(Number(0).toFixed(op_precision));
        }
        $('#s_price').text(Number(item_object.price).toFixed(op_precision));

        // Promotion Check And Discount Set
        if(item_object.is_promo == 'Yes'){
            discount_global = item_object.promo_discount ? item_object.promo_discount : 0;
            $('#promotion-text').html('');
            $('#promotion-text').html(item_object.promo_description);
            $('#modal_discount').prop('readonly', true);
        }else{
            discount_global = customer_discount ? customer_discount : 0;
            $('#promotion-text').html('');
            $('#modal_discount').prop('readonly', false);
        }

        // Price Set According to customer price type and discount
        let modal_subtotal = 0;
        $('#modal_discount').val(discount_global);
        if(customer_price_type == 2){
            $('#modal_item_price_input_field').val(Number(item_object.whole_sale_price).toFixed(op_precision));
            $(".whole_price_class").click();
            modal_subtotal = subtotalCalculateByPriceQtyDiscount(item_object.whole_sale_price,modalQty,discount_global);
        }else{
            $('#modal_item_price_input_field').val(Number(item_object.price).toFixed(op_precision));
            $(".sale_price_class").click();
            modal_subtotal = subtotalCalculateByPriceQtyDiscount(item_object.price,modalQty,discount_global);
        }
        if(item_type == 'General_Product' || item_type == 'Variation_Product' || item_type == 'Installment_Product' || item_type == 'Service_Product'){
            $('#modal_total_price').text(Number(modal_subtotal).toFixed(op_precision));
        }else{
            $('#modal_total_price').text(Number(0).toFixed(op_precision));
        }
        if(item_type == 'Combo_Product'){
            if(combo_checker == ''){
                $('#item_modal').addClass('active');
                $(".pos__modal__overlay").fadeIn(200);
            }
        }else{
            $('#item_modal').addClass('active');
            $(".pos__modal__overlay").fadeIn();
        }
        if(item_type == 'IMEI_Product' || item_type == 'Serial_Product' || (item_type == 'Medicine_Product' && item_object.expiry_date_maintain == 'Yes')){
            setTimeout(function(){
                let op1 = $("#IMEI_Serial").data("select2");    
                op1.open();
                $('#seller_wrapper .select2-container .select2-selection--single').attr('tabindex', '-1');
            }, 1500);
        }
    }


    function modalFieldHideShowByItemType(item_type, expiry_date_maintain){
        if(item_type == 'General_Product'){
            $('.Available_IMEI_Srial').hide();
            $('.variationProductHtmlRenderWrap').hide();
            $('#modal_item_price_input_field').prop('readonly', false);
            $('#modal_discount').prop('readonly', false);
            $('#item_quantity_modal_input').prop('readonly', false);
            $('.modal_increase_item_table').prop('disabled', false);
            $('.modal_decrease_item_table').prop('disabled', false);
        }else if(item_type == 'Installment_Product'){
            $('.Available_IMEI_Srial').hide();
            $('.variationProductHtmlRenderWrap').hide();
            $('#modal_item_price_input_field').prop('readonly', false);
            $('#modal_discount').prop('readonly', false);
            $('#item_quantity_modal_input').prop('readonly', false);
            $('.modal_increase_item_table').prop('disabled', false);
            $('.modal_decrease_item_table').prop('disabled', false);
        }else if(item_type == 'IMEI_Product' || item_type == 'Serial_Product'){
            $('.Available_IMEI_Srial').show();
            $('.variationProductHtmlRenderWrap').hide();
            $('#modal_item_price_input_field').prop('readonly', false);
            $('#modal_discount').prop('readonly', false);
            $('#item_quantity_modal_input').prop('readonly', true);
            $('.modal_increase_item_table').prop('disabled', true);
            $('.modal_decrease_item_table').prop('disabled', true);
        }else if(item_type == 'Medicine_Product'){
            if(expiry_date_maintain == 'Yes'){
                $('.Available_IMEI_Srial').show();
                $('#item_quantity_modal_input').prop('readonly', true);
                $('.modal_increase_item_table').prop('disabled', true);
                $('.modal_decrease_item_table').prop('disabled', true);
                $('#modal_item_price_input_field').prop('readonly', false);
                $('#modal_discount').prop('readonly', false);
            }else{
                $('.Available_IMEI_Srial').hide();
            }
            $('.variationProductHtmlRenderWrap').hide();
        }else if(item_type == 'Variation_Product' || item_type == '0'){
            $('.Available_IMEI_Srial').hide();
            $('.variationProductHtmlRenderWrap').show();
            $('#modal_item_price_input_field').prop('readonly', true);
            $('#modal_discount').prop('readonly', true);
            $('.modal_increase_item_table').prop('disabled', true);
            $('.modal_decrease_item_table').prop('disabled', true);
            $('#item_quantity_modal_input').prop('readonly', true);
        }else if(item_type == 'Service_Product'){
            $('.Available_IMEI_Srial').hide();
            $('.variationProductHtmlRenderWrap').hide();
            $('#modal_item_price_input_field').prop('readonly', false);
            $('#modal_discount').prop('readonly', false);
            $('.modal_increase_item_table').prop('disabled', false);
            $('.modal_decrease_item_table').prop('disabled', false);
            $('#item_quantity_modal_input').prop('readonly', false);
        }else if(item_type == 'Combo_Product'){
            $('.Available_IMEI_Srial').hide();
            $('.variationProductHtmlRenderWrap').hide();
        }
    }


    $(document).on('click', '.variationSingleItem', function(){
        let subtotal = 0;
        let cutomerPriceType = $('option:selected','#walk_in_customer').attr('price_type');
        let cutomerDiscount = $('option:selected','#walk_in_customer').attr('discount');
        let item_id = $(this).attr('data-item-id');
        let item_parent_id = $(this).attr('data-variation-parent');
        let item_name = $(this).attr('data-item-name');
        let salePrice = $(this).attr('data-sale-price');
        let wholePrice = $(this).attr('data-whole-sale-price');
        let purchasePrice = $(this).attr('data-purchase-price');
        let saleUnit = $(this).attr('data-sale-unit');
        let modal_item_vat_percentage = $(this).attr('data-menu-tax');
        let modalQty = Number($('#item_quantity_modal_input').val());
        if(modalQty){
            modalQty = modalQty;
        }else{
            modalQty = 1;
            $('#item_quantity_modal_input').val(1);
        }
        if(is_offline_system == '1'){
            $.ajax({
                type: "POST",
                url: base_url+"Sale/stockCheckingForThisOutletById",
                async: false,
                data: {
                    item_id: item_id,
                },
                success: function (response) {
                    if(response.status == 'success'){
                        $('.current_stock_t').text((Number(response.data)).toFixed(op_precision));
                        $('#current_stock_hidden').val(Number(response.data));
                    }
                }
            });
        } else {
            // Open a connection to the IndexedDB database
            let request = indexedDB.open('off_pos_2', 2);
            request.onerror = function(event) {
                console.log("Error opening the database:", event.target.error ? event.target.error.message : "Unknown error");
            };
            request.onsuccess = function(event) {
                let db = event.target.result;
                // Start a transaction to read from the database
                let transaction = db.transaction(['items'], 'readonly');
                let objectStore = transaction.objectStore('items');
                // Use getAll() to read all data from the 'items' object store
                let getAllRequest = objectStore.getAll();
                getAllRequest.onsuccess = function(event) {
                    let items = event.target.result;
                    let product = items[0].find(function(item) {
                        return item.id == item_parent_id;
                    });
                    if(product){
                        $.each(product.variations, function (i, v) { 
                            if(v.vId == item_id){
                                $('.current_stock_t').text((Number(v.stock_in) - Number(v.stock_out)).toFixed(op_precision));
                                $('#item_quantity_modal_input').val(parseFloat(1));
                            }
                        });
                    }
                };
                getAllRequest.onerror = function(event) {
                    console.log("Error reading data:", event.target.error.message);
                };
            };
        }
        
        $('.modal_increase_item_table').prop('disabled', false);
        $('.modal_decrease_item_table').prop('disabled', false);
        $('#item_quantity_modal_input').prop('readonly', false);
        $('#modal_item_price_input_field').prop('readonly', false);
        $('#modal_discount').prop('readonly', false);
        $('#s_price').text(Number(salePrice).toFixed(op_precision));
        if(view_purchase_price == 'Yes'){
            $('#w_s_price').text(Number(wholePrice).toFixed(op_precision));
            $('#m_p_price').text(Number(purchasePrice).toFixed(op_precision));
        }else{
            $('#w_s_price').text(Number(0).toFixed(op_precision));
            $('#m_p_price').text(Number(0).toFixed(op_precision));
        }
        $('#modal_item_id').text(item_id);
        $('#modal_item_name').text(item_name);
        $('#modal_item_vat_percentage').text(modal_item_vat_percentage);
        $('#modal_item_sale_unit').text(saleUnit);
        $('#sale_unit_name_modal').text(saleUnit);
        if(cutomerPriceType == 1){
            $('#modal_item_price_input_field').val(Number(salePrice).toFixed(op_precision));
            $(".sale_price_class").click();
            subtotal = subtotalCalculateByPriceQtyDiscount(parseFloat(salePrice), modalQty, cutomerDiscount);
        }else if(cutomerPriceType == 2){
            $('#modal_item_price_input_field').val(Number(wholePrice).toFixed(op_precision));
            $(".whole_price_class").click();
            subtotal = subtotalCalculateByPriceQtyDiscount(parseFloat(wholePrice), modalQty, cutomerDiscount);
        }else{
            $('#modal_item_price_input_field').val(Number(salePrice).toFixed(op_precision));
            $(".sale_price_class").click();
            subtotal = subtotalCalculateByPriceQtyDiscount(parseFloat(salePrice), modalQty, cutomerDiscount);
        }
        if(cutomerDiscount){
            $('#modal_discount').val(cutomerDiscount);
        }else{
            $('#modal_discount').val(0);
        }
        $('#modal_total_price').text(parseFloat(subtotal));
    });


    $(document).on('click', '.variationProductHtmlRender .container', function(){
        $(".variationProductHtmlRender .container").removeClass("v-active");
        $(this).addClass("v-active");
    });



    // Code optimize by Azhar ** Final **
    //when add to card button is clicked information goes to table of middle to top
    $(document).on('click', '#add_to_cart', function () {
        $('#search').val('');
        $('#search_barcode').val('');
        let error = false;
        let readonlyAttr = '';
        let default_qty_amt = 1;
        // Setter And Getter Item Modal 
        let item_name = $.trim($('#modal_item_name').text());
        let item_id = $.trim($('#modal_item_id').text());
        let variation_parent = $.trim($('#variation_parent').text());
        let sale_unit_name = $.trim($('#modal_item_sale_unit').text());
        let item_type = $.trim($('#modal_item_type').text());
        let expiry_date_maintain = $(`#item_${item_id}`).attr('expiry_date_maintain');
        let modal_item_vat_percentage = $.trim($('#modal_item_vat_percentage').text());
        let modal_item_price = $.trim($('#modal_item_price_input_field').val());
        let item_quantity_modal_input = $.trim($('#item_quantity_modal_input').val());
        
        let modal_discount = $.trim($('#modal_discount').val() ?? 0);
        let item_total_price = $.trim($('#modal_total_price').text());
        let seller_id = $('#seller_id').val();
        let IMEI_Serial = $.trim($('#IMEI_Serial').val());
        let modal_item_note = $.trim($('#modal_item_note').val());
        // Promotion Setting And Getter 
        let is_promo = $.trim($('#modal_is_promo').text());
        let promotionId = $.trim($('#modal_promo_item_id').text());
        let promotionName = $.trim($(`#item_${promotionId} .item_name`).attr('data-tippy-content'));
        let buyPromoQty = $.trim($('#modal_promo_buy_qty').text());
        let getPromoQty = $.trim($('#modal_promo_get_qty').text());
        let itemPromoNo = parseInt(Number(item_quantity_modal_input) / Number(buyPromoQty)) * parseInt(getPromoQty);
        let cartItemLength = $('.order_holder .single_order').length;
        let sale_unit_name_modal = $('#sale_unit_name_modal').text();
        if(modal_discount == ''){
            modal_discount = 0;
        }
        let current_stock = $('.current_stock_t').text();
        // Alear When Modal Quantity is "0"
        if(item_type != 'Combo_Product' && Number(item_quantity_modal_input) == 0){
            Swal.fire({
                title: warning + "!",
                text: `Select at least 1 Quantity`,
                showDenyButton: false,
                showCancelButton: false,
                confirmButtonText: ok,
            });
            error = true;
        }
        // Item Type Wise Condition Set
        if(item_type == 'General_Product'){
        }else if(item_type == 'IMEI_Product' || item_type == 'Serial_Product' || (item_type == 'Medicine_Product' && expiry_date_maintain == 'Yes')){
            let expiry_imei_serial = $.trim($('#IMEI_Serial').val());
            if(expiry_imei_serial == ''){
                $('#expiry_imei_serial_err_msg').text(`${The} ${checkItemShortType(item_type)} ${field_is_required}`);
                $('.expiry_imei_serial_msg_contnr').show(200).delay(6000).hide(200, function () {});
                error = true;
            }
        }else if(item_type == 'Variation_Product'){
            let variationSelect = $('.variationProductHtmlRender .v-active').length;
            if(Number(variationSelect) == Number(0)){
                Swal.fire({
                    title: warning + "!",
                    text: `No Item is select! Please select an Item`,
                    showDenyButton: false,
                    showCancelButton: false,
                    confirmButtonText: ok,
                });
                error = true;
            }
        }else if(item_type == 'Combo_Product'){
            item_name = $('#edit_item_modal_header').text();
            let if_exit_combo_parent = $(`.order_holder #order_for_item_${item_id}`).length;
            if(if_exit_combo_parent){
                $(`.order_holder #order_for_item_${item_id}`).find('.remove_this_item_from_cart').click();
            }
            let to_sale_item = $('.to_sales_item:checked').length;
            item_quantity_modal_input = 1;
            if(to_sale_item == 0){
                Swal.fire({
                    title: warning+" !",
                    text: 'No Item is select',
                    showDenyButton: false,
                    showCancelButton: false,
                    confirmButtonText: ok,
                }); 
                error = true;
            }
        }


        if(item_type == 'Medicine_Product' && (Number(current_stock) < Number(item_quantity_modal_input))){
            toastr['error'](('Over selling is not allowed for medicine product!'), '');
            error = true;
            return false;
        }


        // Return False When error occur
        if(error == true){
            return false;
        }else{
            $('#item_modal').removeClass('active');
            $(".pos__modal__overlay").fadeOut(300);
            posDefaultCursor();
            setTimeout(function(){
                let selector = $('.single-inner-div').find('.active_gm_temp');
                selector.removeClass('active_gm_temp');
                selector.addClass('active_gm');
                $('#search').val('')
                $('#search_barcode').val('')
            }, 500);
        }

        if(cartItemLength == '0'){
            newItemAppentToCart();  
        }else{
            let current_row = '';
            let matchRow = '';
            let item_type_single = '';
            $('.order_holder .single_order').each(function(){
                item_type_single = $(this).find('.item_type ').text();
                current_row = $(this).attr('data_cart_item_id');
                if(item_type_single != 'IMEI_Product' && item_type_single != 'Serial_Product' && item_type_single != 'Medicine_Product'){
                    if(item_id == current_row){
                        matchRow = '1';
                    }
                }else{
                    let imei_serial_expiry = $(this).find('#expiry_imei_serial span').eq(0).text();
                    if(item_id == current_row &&  imei_serial_expiry == IMEI_Serial){
                        matchRow = '2';
                    }
                }
            });
            if(item_type == 'Combo_Product'){
                newItemAppentToCart();
            }else{
                if(matchRow == '1'){
                    oldItemAppentToCart();
                } else if(matchRow == '2'){
                    oldItemAppentToCartIMEISerialExpiry();
                } else{
                    newItemAppentToCart();
                }
            }
        }

        function oldItemAppentToCartIMEISerialExpiry(){
            $(`.imei_serial_expiry_${IMEI_Serial} #item_seller_table${item_id}`).text(seller_id);
            $(`.imei_serial_expiry_${IMEI_Serial} #item_price_table_${item_id}`).text($.trim(modal_item_price));
            $(`.imei_serial_expiry_${IMEI_Serial} #item_total_price_table_${item_id}`).text($.trim(item_total_price));
            $(`.imei_serial_expiry_${IMEI_Serial} #item_quantity_table_${item_id}`).text($.trim(item_quantity_modal_input));
            $(`.imei_serial_expiry_${IMEI_Serial} #item_price_without_discount_${item_id}`).text(`${Number($.trim(modal_item_price)) * Number($.trim(item_quantity_modal_input))}`);
            $(`.imei_serial_expiry_${IMEI_Serial} .imei_serial_expiry_${IMEI_Serial} #percentage_table_${item_id}`).val($.trim(modal_discount));
            $(`.imei_serial_expiry_${IMEI_Serial} .expiry_imei_serial_${item_id}`).text($.trim(IMEI_Serial));
            $(`.imei_serial_expiry_${IMEI_Serial} .item_modal_description_table_${item_id}`).text($.trim(modal_item_note));
            $(`.imei_serial_expiry_${IMEI_Serial} #free_item_quantity_table_${item_id}`).text($.trim(itemPromoNo));
            itemModalHiddenDataClear();
            increaseFreeItemQty(1,  item_quantity_modal_input, item_id)
        }
        function oldItemAppentToCart(){
            $(`#item_seller_table${item_id}`).text(seller_id);
            $(`#item_price_table_${item_id}`).text($.trim(modal_item_price));
            $(`#item_total_price_table_${item_id}`).text($.trim(item_total_price));
            $(`#item_quantity_table_${item_id}`).text($.trim(item_quantity_modal_input));
            $(`#item_price_without_discount_${item_id}`).text(`${Number($.trim(modal_item_price)) * Number($.trim(item_quantity_modal_input))}`);
            $(`#percentage_table_${item_id}`).val($.trim(modal_discount));
            $(`.expiry_imei_serial_${item_id}`).text($.trim(IMEI_Serial));
            $(`.item_modal_description_table_${item_id}`).text($.trim(modal_item_note));
            $(`#free_item_quantity_table_${item_id}`).text($.trim(itemPromoNo));
            itemModalHiddenDataClear();
            increaseFreeItemQty(1,  item_quantity_modal_input, item_id)
        }
        function newItemAppentToCart(){
            let draw_table_for_order = '';
            let expiry_imei_serial = '';
            let promotionHtml = '';
            if(item_type == 'IMEI_Product' || item_type == 'Serial_Product'|| (item_type == 'Medicine_Product' && expiry_date_maintain == 'Yes')){
                expiry_imei_serial = `<span class="imei_serial_note" id="expiry_imei_serial">${checkItemShortType(item_type)}: <span class="expiry_imei_serial_${item_id}">${IMEI_Serial}</span></span>`;
            }else{
                expiry_imei_serial = '';
            }


            let comboHtml = '';
            if(item_type == 'Combo_Product'){
                let comboName = 0;
                let comboQty = 0;
                let comboUnitPrice = 0;
                let combSubTotal = 0;
                let combChildId = '';
                let comboType = '';
                let combParentId = '';
                let combSellerId = '';
                let combIFSale = '';
                let combItemShownInInvoice = '';
                $('.combo_product_html_render .combo_modal_body li').each(function(){
                    comboName = $(this).find('.combo_name').text();
                    comboType = $(this).find('.combo_type').val();
                    comboQty = $(this).find('.combo_quantity').val();
                    comboUnitPrice = $(this).find('.combo_unit_price').val();
                    combSubTotal = $(this).find('.subtotal_combo').text();
                    combSubTotal = $(this).find('.subtotal_combo').text();
                    combChildId = $(this).find('.combo_child_id').val();
                    combParentId = $(this).find('.combo_parent_id').val();
                    combSellerId = $(this).find('.inline_seller_id').val();
                    combIFSale = $(this).find('.to_sales_item').is(':checked');
                    combItemShownInInvoice = $(this).find('.show_in_invoice').is(':checked');

                    if(combIFSale){
                        comboHtml +=`<div class="combo_cart_item combo_item_div_${combChildId}"  data-is_combo="Yes">
                            <div data-id="${combChildId}" class="customer_panel single_order_column first_column">
                                <iconify-icon icon="solar:pen-broken" class="op_cursor_pointer" width="22" data-parent_id=""></iconify-icon>
                                <span id="combo_item_name_table_${combChildId}">${comboName}</span>
                                <span id="combo_item_type_table_${combChildId}">${comboType}</span>
                                <span class="d-none" id="combo_seller_table_${combChildId}">${combSellerId}</span>
                                <span class="d-none" id="combo_inv_show_table_${combChildId}">${combItemShownInInvoice ? 'Yes' : 'No'}</span>
                                <span class="d-none" id="combo_ifsale_table_${combChildId}">${combIFSale ? 'Yes' : 'No'}</span>
                            </div>
                            <div class="single_order_column second_column text-center"> 
                                <span id="combo_item_price_table_${combChildId}">${parseFloat(comboUnitPrice).toFixed(op_precision)}</span>
                            </div>
                            <div class="single_order_column third_column">
                                <iconify-icon icon="uil:minus" class="alert_combo_item_increase op_cursor_pointer decrease_item_table" id="combo_decrease_item_table_${combChildId}" width="22"></iconify-icon>
                                <span class="4_cp_qty_${combChildId} qty_item_custom cart_quantity" id="combo_item_quantity_table_${combChildId}">${parseFloat(comboQty)}</span> 
                                <iconify-icon icon="bitcoin-icons:plus-outline" class="alert_combo_item_increase op_cursor_pointer" id="increase_item_table_${combChildId}" width="22"></iconify-icon>
                            </div>
                            <div class="single_order_column forth_column">
                                <input type="" name="" onfocus="select();" placeholder="Amt or %" class="discount_cart_input" value="0" disabled>
                            </div>
                            <div class="single_order_column fifth_column text-right"> 
                                <span id="combo_item_total_price_table_${combChildId}">${parseFloat(combSubTotal).toFixed(op_precision)}</span>
                                <iconify-icon icon="solar:trash-bin-minimalistic-broken" data-id="${combChildId}" class="combo-item-remove removeCartItemCombo"></iconify-icon>
                            </div>
                        </div>`;
                    }
                });
            }


            if(is_promo == 'Yes'){
                readonlyAttr = 'readonly';
                if(itemPromoNo > 0){
                    promotionHtml +=`<div class="free-item free_item_div_${item_id}" data-free-item-id="${promotionId}" data-get_fm_id="${item_id}" data-is_free="Yes">
                        <div data-id="${item_id}" class="customer_panel single_order_column first_column">
                        <iconify-icon icon="solar:pen-broken" class="op_cursor_pointer edit_item" width="22" data-parent_id=""></iconify-icon>
                            <span id="free_item_name_table_${item_id}">${promotionName}</span>
                            <span class="d-none" id="free_item_buy_table_${item_id}">${buyPromoQty}</span>
                            <span class="d-none" id="free_item_get_table_${item_id}">${getPromoQty}</span>
                        </div>
                        <div class="single_order_column second_column text-center"> 
                            <span id="free_item_price_table_${item_id}">${Number(0).toFixed(op_precision)}</span>
                        </div>
                        <div class="single_order_column third_column">
                            <iconify-icon icon="uil:minus" class="alert_free_item_increase op_cursor_pointer decrease_item_table" id="free_decrease_item_table_${item_id}" width="22"></iconify-icon>
                            <span class="4_cp_qty_${item_id} qty_item_custom cart_quantity" id="free_item_quantity_table_${item_id}">${itemPromoNo}</span> 
                            <iconify-icon icon="bitcoin-icons:plus-outline" class="alert_free_item_increase op_cursor_pointer" id="increase_item_table_${item_id}" width="22"></iconify-icon>
                        </div>
                        <div class="single_order_column forth_column">
                            <input type="" name="" onfocus="select();" placeholder="Amt or %" class="discount_cart_input" value="0" disabled>
                        </div>
                        <div class="single_order_column fifth_column text-right"> 
                            <span id="free_item_total_price_table_${item_id}">${Number(0).toFixed(op_precision)}</span>
                            <iconify-icon icon="solar:trash-bin-minimalistic-broken" data-id="${item_id}" class="free-item-remove removeCartItemFree"></iconify-icon>
                        </div>
                    </div>`;
                }
            }


            draw_table_for_order = `<div data-sale-unit="${sale_unit_name_modal}" data-variation-parent="${variation_parent}" class="single_order imei_serial_expiry_${IMEI_Serial}" is_promo="${is_promo}" data-qty_default="${default_qty_amt}" data-sale-unit="${sale_unit_name}" id="order_for_item_${item_id}" data-single-order-row-no="" data_cart_item_id="${item_id}">
                <div class="first_portion">
                    <span id="item_seller_table${item_id}" class="d-none">${seller_id}</span>
                    <span class="expiry_date_maintain d-none" id="expiry_date_maintain_${item_id}">${expiry_date_maintain}</span>
                    <span class="item_type d-none" id="item_type_table${item_id}">${item_type}</span>
                    <span class="item_vat d-none" id="item_vat_percentage_table${item_id}">${modal_item_vat_percentage}</span>
                    <span class="item_discount d-none" id="item_discount_table${item_id}">${percentValueCalculateByPriceQtyDiscount(modal_item_price, item_quantity_modal_input, modal_discount)}</span>
                    <span class="item_price_without_discount d-none" id="item_price_without_discount_${item_id}">${Number(modal_item_price) * Number(item_quantity_modal_input)}</span>
                    <div class="single_order_column first_column">
                        <iconify-icon icon="solar:pen-broken" class="op_cursor_pointer edit_item" width="22" id="edit_item_${item_id}"></iconify-icon>
                        <span id="item_name_table_${item_id}">${item_name}</span>
                    </div>
                    <div class="single_order_column second_column">
                        <span id="item_price_table_${item_id}">${modal_item_price}</span>
                    </div>
                    <div class="single_order_column third_column ${item_type == 'Combo_Product' ? 'combo_parent_inc_dec' : ''}">
                        <iconify-icon icon="uil:minus" class="decrease_item_table op_cursor_pointer" id="decrease_item_table_${item_id}" width="22"></iconify-icon>
                        <span class="cart_quantity" id="item_quantity_table_${item_id}">${item_quantity_modal_input}</span> 
                        <iconify-icon icon="uil:plus" class="increase_item_table op_cursor_pointer" id="increase_item_table_${item_id}" width="22"></iconify-icon>
                    </div>
                    <div class="single_order_column forth_column ${item_type == 'Combo_Product' ? 'combo_parent_inc_dec' : ''}">
                        <input type="" name="" onfocus="select();" inline_dis_column="${item_id}" placeholder="Amt or %" class="special_textbox access_control inline_dis_column" id="percentage_table_${item_id}" value="${modal_discount == '' ? Number(0) : modal_discount}" ${readonlyAttr}>
                    </div>
                    <div class="single_order_column fifth_column">
                        <span id="item_total_price_table_${item_id}">${item_total_price}</span> 
                        <iconify-icon icon="solar:trash-bin-minimalistic-broken" data-remove-order-row-no="" class="remove_this_item_from_cart" width="22"></iconify-icon>
                    </div>
                </div>
                ${expiry_imei_serial}
                <span class="cart_item_modal_des item_modal_description_table_${item_id}">${modal_item_note}</span>
                ${promotionHtml}
                ${comboHtml}
            </div>`;

            $(".order_holder").append(draw_table_for_order);
            $('#search').val('');
            $('#search_barcode').val('');
            if(edit_mode == ''){
                storageCartDataInLocal();
            }
            itemModalHiddenDataClear();
        }
        $('#search').val('');
        $('#search_barcode').val('');
        cartItemCalculationInPOS();
        if(edit_mode == ''){
            storageCartDataInLocal();
        }
        if ($(window).width() < 991) {
            cartMobileSuccessMsgAndItemCount();
            cartMobileItemCount();
        }
        setTimeout(function(){
            posDefaultCursor();
        }, 100)

    });
    function cartMobileSuccessMsgAndItemCount(){
        toastr.options = {
            "toas-container": "toast-top-right"
        };
        toastr.success('Product Successfully added in cart', '');
    }
    function cartMobileRemoveMsgAndItemCount(){
        toastr.options = {
            "toas-container": "toast-top-right"
        };
        toastr.success('Product Successfully remove from cart', '');
    }
    function cartMobileItemCount(){
        let cart_item = $('.single_order').length;
        $('.mobile_cart_count').text(`(${cart_item})`);
    }
    setTimeout(function(){
        cartMobileItemCount();
    }, 200);


    function itemModalHiddenDataClear(){
        $('#variation_parent').text('');
        $('#modal_item_name').text('');
        $('#modal_is_promo').text('');
        $('#modal_promo_buy_qty').text('');
        $('#modal_promo_get_qty').text('');
        $('#modal_promo_discount').text('');
        $('#modal_promo_item_id').text('');
        $('#modal_promo_type').text('');
        $('#modal_item_id').text('');
        $('#modal_item_type').text('');
        $('#modal_item_sale_unit').text('');
        $('#sale_unit_name_modal').text('');
        $('#modal_item_vat_percentage').text('');
        $('#m_p_price').text('');
        $('#w_s_price').text('');
        $('#s_price').text('');
        $('#modal_item_note').val('');
        $('.current_stock_t').text(Number(0).toFixed(op_precision));
        $('#current_stock_hidden').text(Number(0).toFixed(op_precision));
    }
    function storageCartDataInLocal(){
        localStorage['cart_html'] = $(".order_holder").html();
    }

    $(document).on('click', '.close_item_modal', function(){
        itemModalHiddenDataClear();
    });
    $(document).on('click', '.close_item_modal', function(){
        itemModalHiddenDataClear();
    });


    $(document).on('change', '#IMEI_Serial', function(){
        let item_id = $('#modal_item_id').text();
        let item_type = $('#modal_item_type').text();
        let sale_unit = $('#modal_item_sale_unit').text();
        let singleExpiryDate = $(this).val();
        let current_stock_hidden = $('#current_stock_hidden').val();
        let customer_price_type = $("#walk_in_customer option:selected").attr("price_type");
        if(item_type == 'Medicine_Product'){
            if(singleExpiryDate == ''){
                $('#item_quantity_modal_input').prop('readonly', true);
                $('.modal_increase_item_table').prop('disabled', true);
                $('.modal_decrease_item_table').prop('disabled', true);
                $('#sale_unit_name_modal').text('');
                $('#item_quantity_modal_input').val(0);
                $('#modal_total_price').text(Number(0).toFixed(op_precision));
                $('.current_stock_t').text(Number(current_stock_hidden).toFixed(op_precision));
            }else{

                $('#item_quantity_modal_input').prop('readonly', false);
                $('.modal_increase_item_table').prop('disabled', false);
                $('.modal_decrease_item_table').prop('disabled', false);
                $('#sale_unit_name_modal').text(sale_unit);

                if(is_offline_system == '1'){
                    $.ajax({
                        type: "POST",
                        url: base_url+"Sale/singleExpiryDateStockCheck",
                        async: false,
                        data: {
                            expiry_imei_serial: singleExpiryDate,
                            item_id: item_id,
                        },
                        success: function (response) {
                            if(response.status == 'success'){
                                $('.current_stock_t').text((Number(response.data.stock_quantity)).toFixed(op_precision));
                                $('#item_quantity_modal_input').val(parseFloat(1));
                            }
                        }
                    });
                }else{
                    
                    // Open a connection to the IndexedDB database
                    let request = indexedDB.open('off_pos_2', 2);
                    request.onerror = function(event) {
                        console.log("Error opening the database:", event.target.error ? event.target.error.message : "Unknown error");
                    };
                    request.onsuccess = function(event) {
                        let db = event.target.result;
                        // Start a transaction to read from the database
                        let transaction = db.transaction(['items'], 'readonly');
                        let objectStore = transaction.objectStore('items');
                        // Use getAll() to read all data from the 'items' object store
                        let getAllRequest = objectStore.getAll();
                        getAllRequest.onsuccess = function(event) {
                            let items = event.target.result;
                            let product = items[0].find(function(item) {
                                return item.id == item_id;
                            });
                            if(product){
                                if(product.allexpiry){
                                    product.allexpiry.map(function(single_expiry) {
                                        for (let key_date in single_expiry) {
                                            if(singleExpiryDate == key_date){
                                                $('.current_stock_t').text((Number(single_expiry[key_date])).toFixed(op_precision));
                                                $('#item_quantity_modal_input').val(parseFloat(1));
                                            }
                                        }
                                    });
                                }
                            }
                        };
                        getAllRequest.onerror = function(event) {
                            console.log("Error reading data:", event.target.error.message);
                        };
                    };
                }
                if(customer_price_type == 2){
                    $(".whole_price_active").click();
                }else{
                    $(".sale_price_active").click();
                }
            }
        }else if(item_type == 'IMEI_Product' || item_type == 'Serial_Product'){
            if(singleExpiryDate == ''){
                $('.current_stock_t').text(parseFloat(current_stock_hidden).toFixed(op_precision));
                $('#item_quantity_modal_input').val(0);
            }else{
                $('.current_stock_t').text(parseFloat(1).toFixed(op_precision));
                $('#item_quantity_modal_input').val(1);
                if(customer_price_type == 2){
                    $(".whole_price_active").click();
                }else{
                    $(".sale_price_active").click();
                }
            }
        }
    });

    // Code optimize by Azhar ** Final **
    $(document).on('click', '#cancel_button', function () {
        //get total items in cart
        let total_items_in_cart = $('.order_holder .single_order').length;
        if (total_items_in_cart > 0) {
            Swal.fire({
                title: warning + "!",
                text: `Total Items in cart ${total_items_in_cart}`,
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: yes,
                denyButtonText: cancel
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    clearFooterCartCalculation(); 
                    $('.order_table_holder .order_holder').empty();
                    $('.main_top').find('button').css('background-color', '#F3F3F3');
                    $('.main_top').find('button').attr('data-selected', 'unselected');
                    $("#walk_in_customer").val('').trigger('change');
                    $("#select_employee_id").val('').trigger('change');
                    $('#place_edit_order').text('Payment');
                } 
            });
        }
    });

    // Code optimize by Azhar ** Final **
    $(document).on('keyup', '#modal_item_price_input_field', function(){
        let discount = $('#modal_discount').val();
        let modalPrice = $(this).val();
        let modalQty = $('#item_quantity_modal_input').val();
        let subtotal = subtotalCalculateByPriceQtyDiscount(modalPrice, modalQty, discount);
        $('#modal_total_price').text(Number(subtotal).toFixed(op_precision));
    });

    // Code optimize by Azhar ** Final **
    function itemModalQtyUpDown(modalQty){
        let single_item_subtotal;
        let item_type = $(`#modal_item_type`).text();
        let fixedCurrentStock = $('.current_stock_t').text();
        let discount = $('option:selected', "#walk_in_customer").attr('discount');
        let modalPrice = $('#modal_item_price_input_field').val();
        let modal_discount =  $('#modal_discount').val();

        if(item_type == 'Medicine_Product' && (Number(fixedCurrentStock) < Number(modalQty))){
            toastr['error'](('Over selling is not allowed for medicine product!'), '');
            return false;
        }else if(allow_less_sale == 'No' && (Number(fixedCurrentStock) < Number(modalQty)) && item_type != 'Service_Product'){
            let curr_qty = $('.current_stock_t').text();
            $('#item_quantity_modal_input').val(Number(fixedCurrentStock));
            toastr['error'](('Over selling is not allowed!'), '');
            return false;
        }else if(item_type != 'Service_Product'){
            $('.current_stock_t').text((Number(fixedCurrentStock)).toFixed(op_precision));
        }
        let modal_promo_discount = $('#modal_promo_discount').text();
        if(modal_promo_discount){
            $('#modal_discount').val(modal_promo_discount);
            single_item_subtotal = subtotalCalculateByPriceQtyDiscount(modalPrice,modalQty,modal_promo_discount);
        }else{
            if(modal_discount){
                $('#modal_discount').val(modal_discount);
            }else{
                $('#modal_discount').val(discount);
            }
            single_item_subtotal = subtotalCalculateByPriceQtyDiscount(modalPrice,modalQty,discount);
        }
        $('#modal_total_price').text(Number(single_item_subtotal).toFixed(op_precision));
    }

    // Code optimize by Azhar ** Final **
    $(document).on('keyup', '#item_quantity_modal_input', function(){
        let modalQty = $(this).val();
        itemModalQtyUpDown(modalQty); 
    });

    // Code optimize by Azhar ** Final **
    $(document).on('click', '.modal_decrease_item_table', function(){
        let modalQty = $('#item_quantity_modal_input').val();
        if(Number(modalQty) > 1){
            $('#item_quantity_modal_input').val(Number(modalQty) - 1);
            itemModalQtyUpDown(Number(modalQty) - 1); 
        }
    });

    // Code optimize by Azhar ** Final **
    $(document).on('click', '.modal_increase_item_table', function(){
        let modalQty = $('#item_quantity_modal_input').val();
        $('#item_quantity_modal_input').val(Number(modalQty) + 1);
        itemModalQtyUpDown(Number(modalQty) + 1); 
    });

    // Code optimize by Azhar ** Final **
    $(document).on('click', '.edit_item', function (event) {
        $("#item_modal").addClass("active");
        $(".pos__modal__overlay").fadeIn(200);
        let item_id = $(this).attr('id').substr(10);
        let item_obj = findItemByItemId(item_id);

        // Promotion Setter And Getter
        $('#modal_is_promo').text(item_obj.is_promo);
        $('#modal_promo_buy_qty').text(item_obj.promo_qty);
        $('#modal_promo_get_qty').text(item_obj.promo_get_qty);
        $('#modal_promo_type').text(item_obj.promo_type);
        $('#modal_promo_discount').text(item_obj.promo_discount);
        $("#promotion-text").html(item_obj.promo_description);

        let single_item_subtotal;
        let price_type = $('#walk_in_customer').find(':selected').attr('price_type');
        let variationParent_id = item_obj.parent_id;
        let last_purchase_price = item_obj.last_purchase_price ? item_obj.last_purchase_price : 0;
        let whole_sale_price = item_obj.whole_sale_price ? item_obj.whole_sale_price : 0;
        let sale_price = item_obj.price ? item_obj.price : 0;
        let item_type = item_obj.item_type;

        if(item_type != 'Combo_Product'){
            $('.combo_product_html_render').hide();
        }else{
            $('.combo_product_html_render').show();
        }

        if(item_type == 'IMEI_Product' || item_type == 'Serial_Product' || (item_type == 'Medicine_Product' && item_obj.expiry_date_maintain == 'Yes')){
            if (window.matchMedia("(min-width: 320px) and (max-width: 575.98px)").matches) {
                $('.item-modal-top-header').css({
                    'grid-template-columns':'1fr',
                });
            }else{
                $('.item-modal-top-header').css({
                    'grid-template-columns':'32% 32% 32%',
                });
            }
        }else{
            $('.item-modal-top-header').css({
                'grid-template-columns':'65% 33%',
            });
        }
        
        editModalFieldHideShowByItemType(item_type)

        // Modal Value Set
        let item_name = $(this).siblings('span').text();
        $('#modal_item_name').text(item_name)
        $('#modal_item_id').text(item_id)
        // Set Unit Type
        $('#modal_item_sale_unit').text(item_obj.sale_unit_name);
        $('#sale_unit_name_modal').text(item_obj.sale_unit_name);
        let currentItemPrice = $(this).parent().parent().find('.second_column span').eq(0).text();
        let item_quantity = $(this).parent().parent().find('.third_column .cart_quantity').text();
        let discount = $(this).parent().parent().find('.forth_column .inline_dis_column').val();

        $('#modal_item_price_input_field').val(currentItemPrice);
        $('#modal_discount').val(discount)

        $('#item_quantity_modal_input').val($.trim(item_quantity));
        $('#edit_item_modal_header').text(item_name);
        $('#modal_item_type').text(item_type);
        let itemNoteOldValue = $(this).parent().parent().parent().find('.cart_item_modal_des span').text();
        if($.trim(itemNoteOldValue) == ''){
            $('#modal_item_note').val('');
        }else{
            $('#modal_item_note').val(itemNoteOldValue);
        }

        if(item_type == 'Service_Product'){
            $('.service_disabled').css({
                'pointer-events':'none',
                'opacity':'0.5',
                'cursor':'not-allowed',
            });
        } else {
            $('.service_disabled').css({
                'pointer-events':'unset',
                'opacity':'unset',
                'cursor':'unset',
            });
        }


        // Get Item Id and Set Current Stock
        if(is_offline_system == '1'){
            if(item_type != 'Service_Product' && item_type != 'Combo_Product'){
                $.ajax({
                    url: base_url + "Sale/stockCheckingForThisOutletById",
                    method: "POST",
                    async: false,
                    dataType: 'json',
                    data: { item_id: item_id },
                    success: function (response) {
                        $('.current_stock_t').text((Number(response.data)).toFixed(op_precision));
                        $('#current_stock_hidden').val((Number(response.data)).toFixed(op_precision));
                    }
                });
            }else{
                $('.current_stock_t').text(Number(0).toFixed(op_precision));
            }
        }else{
            if(item_type != 'Service_Product' && item_type != 'Combo_Product'){
                // Open a connection to the IndexedDB database
                let request = indexedDB.open('off_pos_2', 2);
                request.onerror = function(event) {
                    console.log("Error opening the database:", event.target.error ? event.target.error.message : "Unknown error");
                };
                request.onsuccess = function(event) {
                    let db = event.target.result;
                    // Start a transaction to read from the database
                    let transaction = db.transaction(['items'], 'readonly');
                    let objectStore = transaction.objectStore('items');
                    // Use getAll() to read all data from the 'items' object store
                    let getAllRequest = objectStore.getAll();
                    getAllRequest.onsuccess = function(event) {
                        let items = event.target.result;
                        let product = items[0].find(function(item) {
                            return item.id == item_id;
                        });
                        if(product){
                            $('.current_stock_t').text((Number(product.stock_qty - product.out_qty)).toFixed(op_precision));
                            $('#current_stock_hidden').val((Number(product.stock_qty - product.out_qty)).toFixed(op_precision)); 
                        }
                    };
                    getAllRequest.onerror = function(event) {
                        console.log("Error reading data:", event.target.error.message);
                    };
                };
            
            }
        }
        
        
        if(item_type == 'General_Product'){
            $('.item-modal-top-header').show();
            $('.modal_qty_area').removeClass('item_modal_quantity_area_disabled');
        }else if(item_type == 'Installment_Product'){
            $('.item-modal-top-header').show();
            $('.modal_qty_area').removeClass('item_modal_quantity_area_disabled');
        }else if(item_type == 'IMEI_Product' || item_type == 'Serial_Product'){
            let cartImeiSerial = $(this).parent().parent().parent().find('.imei_serial_note span').eq(0).text();
            if(is_offline_system == '1'){
                $.ajax({
                    url: base_url + "Sale/getIMEISerial",
                    method: "POST",
                    async: false,
                    dataType: 'json',
                    data: { item_id: item_id, item_type:item_type },
                    success: function (response) {
                        let imeiHtml = '';
                        imeiHtml = `<option value="">Select ${item_type == 'IMEI_Product' ? 'IMEI' : 'Serial'}</option>`;
                        if(response.data.allimei){
                            let stockIMEI = response.data.allimei.split("||");
                            $.each(stockIMEI, function (i, v) { 
                                imeiHtml += `<option ${$.trim(cartImeiSerial) == $.trim(v) ? 'selected' : ''} value="${$.trim(v)}">${v}</option>`;
                            });
                        }
                        $('#IMEI_Serial').html('');
                        $('#IMEI_Serial').append(imeiHtml);
                        setTimeout(function(){
                            $('#IMEI_Serial').val(cartImeiSerial).trigger('change');
                            $('#item_quantity_modal_input').val(item_quantity);
                        }, 500);
                    }
                });
                $('.item-modal-top-header').show();
                $('.modal_qty_area').removeClass('item_modal_quantity_area_disabled');
            }else{
                // Open a connection to the IndexedDB database
                let request = indexedDB.open('off_pos_2', 2);
                request.onerror = function(event) {
                    console.log("Error opening the database:", event.target.error ? event.target.error.message : "Unknown error");
                };
                request.onsuccess = function(event) {
                    let db = event.target.result;
                    // Start a transaction to read from the database
                    let transaction = db.transaction(['items'], 'readonly');
                    let objectStore = transaction.objectStore('items');
                    // Use getAll() to read all data from the 'items' object store
                    let getAllRequest = objectStore.getAll();
                    getAllRequest.onsuccess = function(event) {
                        let items = event.target.result;
                        let product = items[0].find(function(item) {
                            return item.id == item_id;
                        });
                        if(product){
                            let imeiHtml = '';
                            imeiHtml = `<option value="">Select ${item_type == 'IMEI_Product' ? 'IMEI' : 'Serial'}</option>`;
                            if(product.allimei){
                                product.allimei.map(function(imei_serial) {
                                    imeiHtml += `<option ${$.trim(cartImeiSerial) == $.trim(imei_serial.single_imei_serial) ? 'selected' : ''} value="${$.trim(imei_serial.single_imei_serial)}">${$.trim(imei_serial.single_imei_serial)}</option>`;
                                });
                            }
                            $('#IMEI_Serial').html('');
                            $('#IMEI_Serial').append(imeiHtml);
                            $('.item-modal-top-header').show();
                            $('.modal_qty_area').removeClass('item_modal_quantity_area_disabled');
                        }
                    };
                    getAllRequest.onerror = function(event) {
                        console.log("Error reading data:", event.target.error.message);
                    };
                };
            }
            
        }else if(item_type == 'Medicine_Product'){
            if(item_obj.expiry_date_maintain == 'No'){
                $('.Available_IMEI_Srial').hide();
            }else{
                $('.Available_IMEI_Srial').show();
            }
            $('.item_type_heading').text('Expiry Dates');
            let cartExpiryDate = $(this).parent().parent().parent().find('.imei_serial_note span').eq(0).text();
            if(is_offline_system == '1'){
                $.ajax({
                    url: base_url + "Sale/getExpiryByOutlet",
                    method: "POST",
                    async: false,
                    dataType: 'json',
                    data: { item_id: item_id },
                    success: function (response) {
                        let expiryHtml = '';
                        expiryHtml = `<option value="">Select Expiry</option>`;
                        if(response.data){
                            $.each(response.data, function (i, v) { 
                                if(v.stock_quantity != 0){
                                    expiryHtml += `<option ${$.trim(cartExpiryDate) == v.expiry_imei_serial ? 'selected' : ''} value="${$.trim(v.expiry_imei_serial)}">${$.trim(v.expiry_imei_serial)}</option>`;
                                }
                                if($.trim(cartExpiryDate) == v.expiry_imei_serial){
                                    $('.current_stock_t').text((Number(v.stock_quantity)).toFixed(op_precision));
                                    $('#current_stock_hidden').val((Number(v.stock_quantity)).toFixed(op_precision));
                                }
                            });
                        }
                        $('#IMEI_Serial').html('');
                        $('#IMEI_Serial').append(expiryHtml);
                        setTimeout(function(){
                            $('#IMEI_Serial').val(cartExpiryDate).trigger('change');
                            $('#item_quantity_modal_input').val(item_quantity);
                        }, 500);
                    }
                });
                $('.item-modal-top-header').show();
                $('.modal_qty_area').removeClass('item_modal_quantity_area_disabled');
            }else{
                if(item_obj.expiry_date_maintain == 'Yes'){
                    // Open a connection to the IndexedDB database
                    let request = indexedDB.open('off_pos_2', 2);
                    request.onerror = function(event) {
                        console.log("Error opening the database:", event.target.error ? event.target.error.message : "Unknown error");
                    };
                    request.onsuccess = function(event) {
                        let db = event.target.result;
                        // Start a transaction to read from the database
                        let transaction = db.transaction(['items'], 'readonly');
                        let objectStore = transaction.objectStore('items');
                        // Use getAll() to read all data from the 'items' object store
                        let getAllRequest = objectStore.getAll();
                        getAllRequest.onsuccess = function(event) {
                            let items = event.target.result;
                            let product = items[0].find(function(item) {
                                return item.id == item_id;
                            });
                            if(product){
                                $('#item_quantity_modal_input').val(Number(0));
                                let expiryHtml = '';
                                expiryHtml = `<option value="">Select Expiry</option>`;
                                if(product.allexpiry){
                                    product.allexpiry.map(function(single_expiry) {
                                        for (let key_date in single_expiry) {
                                            expiryHtml += `<option ${$.trim(cartExpiryDate) == key_date ? 'selected' : ''} value="${$.trim(key_date)}">${$.trim(key_date)}</option>`;
                                            if($.trim(cartExpiryDate) == key_date){
                                                $('.current_stock_t').text((Number(single_expiry[key_date])).toFixed(op_precision));
                                                $('#current_stock_hidden').val((Number(single_expiry[key_date])).toFixed(op_precision));
                                            }

                                        }
                                    });
                                }
                                $('#IMEI_Serial').html('');
                                $('#IMEI_Serial').append(expiryHtml);
                            }
                        };
                        getAllRequest.onerror = function(event) {
                            console.log("Error reading data:", event.target.error.message);
                        };
                    };
                }else{
                    $('#item_quantity_modal_input').val(Number(1));
                }
            }
            
        }else if(item_type == 'Variation_Product' || item_type == '0'){
            $('.item_type_variation_heading').text('Variations');
            $('#variation_parent').text(variationParent_id);
            $('#item_quantity_modal_input').val(Number(item_quantity));
            if(is_offline_system == '1'){
                $.ajax({
                    url: base_url + "Sale/getVariationByItemId",
                    method: "POST",
                    async: false,
                    dataType: 'json',
                    data: { item_id: variationParent_id },
                    success: function (response) {
                        if(response.status == 'success'){
                            let variationHtml = '';
                            $.each(response.data, function (i, v) { 
                                variationHtml += `<div class="container variationSingleItem ${v.id == item_id ? 'v-active' : ''}" data-is-promo="" data-item-id="${v.id}" id="item-id-${v.id}" data-item-name="${v.parent_name +' ' + v.name + '('+v.code+')'}" data-sale-price="${v.sale_price ? v.sale_price : 0}" data-whole-sale-price="${v.whole_sale_price ? v.whole_sale_price : 0}" data-purchase-price="${v.purchase_price ? v.purchase_price : 0 }" data-menu-tax='${v.tax_information}' data-sale-unit="${v.sale_unit_name}">
                                    <span>${v.name}</span>
                                    <span class="pl-10">Price: ${v.sale_price}</span>
                                    <input type="radio" name="variation_items">
                                    <span class="checkmark"></span>
                                </div>`;
                            });
                            $('.variationProductHtmlRender').html('');
                            $('.variationProductHtmlRender').append(variationHtml);
                        }
                    }
                });
                $('.item-modal-top-header').show();
                $('.modal_qty_area').removeClass('item_modal_quantity_area_disabled');
            }else{
                // Open a connection to the IndexedDB database
                let request = indexedDB.open('off_pos_2', 2);
                request.onerror = function(event) {
                    console.log("Error opening the database:", event.target.error ? event.target.error.message : "Unknown error");
                };
                request.onsuccess = function(event) {
                    let db = event.target.result;
                    // Start a transaction to read from the database
                    let transaction = db.transaction(['items'], 'readonly');
                    let objectStore = transaction.objectStore('items');
                    // Use getAll() to read all data from the 'items' object store
                    let getAllRequest = objectStore.getAll();
                    getAllRequest.onsuccess = function(event) {
                        let items = event.target.result;
                        let product = items[0].find(function(item) {
                            return item.id == item_id;
                        });
                        if(product){
                            let variationHtml = '';
                            let item_obj;
                            $.each(product.variations, function (i, v) { 
                                item_obj = findItemByItemId(v.vId);
                                variationHtml += `<div data-variation-parent="${product.id}" class="container variationSingleItem" data-is-promo="" data-item-id="${v.vId}" id="item-id-${v.vId}" data-item-name="${product.name +' ' + v.name + '('+v.code+')'}" data-sale-price="${item_obj.price ? item_obj.price : 0}" data-whole-sale-price="${item_obj.whole_sale_price ? item_obj.whole_sale_price : 0}" data-purchase-price="${item_obj.purchase_price ? item_obj.purchase_price : 0 }" data-menu-tax='${item_obj.tax_information}' data-sale-unit="${item_obj.sale_unit_name}">
                                    <span>${v.name}</span>
                                    <span class="pl-10">Price: ${item_obj.price}</span>
                                    <input type="radio" name="variation_items">
                                    <span class="checkmark"></span>
                                </div>`;
                            });
                            $('.variationProductHtmlRender').html('');
                            $('.variationProductHtmlRender').append(variationHtml);
                        }
                    };
                    getAllRequest.onerror = function(event) {
                        console.log("Error reading data:", event.target.error.message);
                    };
                };
            }
        }else if(item_type == 'Combo_Product'){
            $('.item-modal-top-header').hide();
            $('.modal_qty_area').addClass('item_modal_quantity_area_disabled');
            $.ajax({
                url: base_url + "Sale/getComboItemCheck",
                method: "POST",
                async: false,
                dataType: 'json',
                data: { item_id: item_id },
                success: function (response) {
                    if(response.status == 'success'){
                        let html = '';
                        $.each(response.data.combo_items, function (i, v) { 
                            let old_item_qty = $(`#combo_item_quantity_table_${v.child_combo_item_id}`).text();
                            let old_item_price = $(`#combo_item_price_table_${v.child_combo_item_id}`).text();
                            let old_show_inv = $(`#combo_inv_show_table_${v.child_combo_item_id}`).text();
                            let old_ifsale = $(`#combo_ifsale_table_${v.child_combo_item_id}`).text();
                            let old_seller = $(`#combo_seller_table_${v.child_combo_item_id}`).text();
                            let html2 = '<option value="">Select Employee</option>';
                            $.each(response.data.sellers, function (i, v) { 
                                console.log(old_seller == v.id ? 'Find' : 'Not Find');
                                html2+=`<option ${old_seller ? (old_seller == v.id ? 'selected' : '') : '' } value="${v.id}">${v.full_name}</option>`;
                            });
                            let inv_check = '';
                            if(old_show_inv){
                                inv_check = old_show_inv == 'Yes' ? 'checked' : '';
                            }else{
                                inv_check = '';
                            }
                            let ifsale_check = '';
                            if(old_ifsale){
                                ifsale_check = old_ifsale == 'Yes' ? 'checked' : '';
                            }else{
                                ifsale_check = '';
                            }
                            html +=`<li>
                                <div>${i + 1}</div>
                                <div class="text-center">
                                    <label class="container">
                                        <input type="checkbox" class="show_in_invoice" ${inv_check}>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="text-center">
                                    <label class="container">
                                        <input type="checkbox" class="to_sales_item" ${ifsale_check}>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div>
                                    <p class="combo_name">${v.item_name}</p>
                                    <input type="hidden" class="combo_type" value="${v.type}">
                                    <input type="hidden" class="combo_child_id" value="${v.child_combo_item_id}">
                                    <input type="hidden" class="combo_parent_id" value="${v.combo_parent_id}">
                                </div>
                                <div>
                                    <input type="text" class="form-control combo_quantity  comboCalculation" value="${old_item_qty ? parseFloat(old_item_qty) : parseFloat(v.quantity)}">
                                </div>
                                <div>
                                    <input type="text" class="form-control combo_unit_price  comboCalculation" value="${ old_item_price ? parseFloat(old_item_price) : parseFloat(v.unit_price)}">
                                </div>
                                <div>
                                    <p class="subtotal_combo comboCalculation text-center">${old_item_qty  ? (parseFloat(old_item_qty) * parseFloat(old_item_price)).toFixed(op_precision)  : (parseFloat(v.quantity) * parseFloat(v.unit_price)).toFixed(op_precision)}</p>
                                </div>
                                <div>
                                    <select class="inline_seller_id select2">
                                        ${html2}
                                    </select>
                                </div>
                            </li>`;
                        });
                        setTimeout(function(){
                            $('.combo_product_html_render .combo_modal_body').html('');
                            $('.combo_product_html_render .combo_modal_body').append(html);
                            $('.combo_product_html_render [data-bs-toggle="tooltip"]').tooltip();
                            $(".select2").select2();
                        }, 200);
                    }
                }
            });
        }

        // Item Modal Data Set
        if (last_purchase_price != '' && last_purchase_price != null && view_purchase_price == 'Yes') {
            $("#m_p_price").html(parseFloat(last_purchase_price).toFixed(op_precision));
        } else {
            $("#m_p_price").html(Number(0).toFixed(op_precision));
        }
        if (whole_sale_price != '' && whole_sale_price != null && view_purchase_price == 'Yes') {
            $("#w_s_price").html(parseFloat(whole_sale_price).toFixed(op_precision));
        } else {
            $("#w_s_price").html(Number(0).toFixed(op_precision));
        }
        if (sale_price != '' && sale_price != null) {
            $("#s_price").html(parseFloat(sale_price).toFixed(op_precision));
        } else {
            $("#s_price").html(Number(0).toFixed(op_precision));
        }
        if (discount) {
            $('#modal_discount').val($.trim(discount));
        } else {
            $('#modal_discount').val(Number(0));
        }
        if(price_type == 1 && item_type != 'Service_Product'){
            $('input[name="model_price"][value="modal_sale_price"]').prop('checked', true);
            $('input[name="model_price"][value="modal_whole_sale_price"]').prop('checked', false);
            $('input[name="model_price"][value="modal_purchase_price"]').prop('checked', false);
        }else if(price_type == 2 && item_type != 'Service_Product'){
            $('input[name="model_price"][value="modal_whole_sale_price"]').prop('checked', true);
            $('input[name="model_price"][value="modal_sale_price"]').prop('checked', false);
            $('input[name="model_price"][value="modal_purchase_price"]').prop('checked', false);
        }else{
            $('input[name="model_price"][value="modal_whole_sale_price"]').prop('checked', false);
            $('input[name="model_price"][value="modal_sale_price"]').prop('checked', true);
            $('input[name="model_price"][value="modal_purchase_price"]').prop('checked', false);
        }
        single_item_subtotal = subtotalCalculateByPriceQtyDiscount(currentItemPrice, item_quantity, discount);
        let saleUnitName = $(`#order_for_item_${item_id}`).attr('data-sale-unit');
        $(`#sale_unit_name_modal`).text(saleUnitName);
        $('#modal_item_price_input_field').val(Number($.trim(currentItemPrice)).toFixed(op_precision))
        $('#modal_total_price').text(Number(single_item_subtotal).toFixed(op_precision));
    });

    function editModalFieldHideShowByItemType(item_type){
        if(item_type == 'General_Product'){
            $('.Available_IMEI_Srial').hide();
            $('.variationProductHtmlRenderWrap').hide();
        }else if(item_type == 'Installment_Product'){
            $('.Available_IMEI_Srial').hide();
            $('.variationProductHtmlRenderWrap').hide();
        }else if(item_type == 'IMEI_Product' || item_type == 'Serial_Product'){
            $('.Available_IMEI_Srial').show();
            $('.variationProductHtmlRenderWrap').hide();
            $('#modal_item_price_input_field').prop('readonly', false);
            $('#modal_discount').prop('readonly', false);
            $('#item_quantity_modal_input').prop('readonly', true);
            $('.modal_increase_item_table').prop('disabled', true);
            $('.modal_decrease_item_table').prop('disabled', true);
        }else if(item_type == 'Medicine_Product'){
            $('.Available_IMEI_Srial').show();
            $('.variationProductHtmlRenderWrap').hide();
            $('#modal_item_price_input_field').prop('readonly', false);
            $('#modal_discount').prop('readonly', false);
            $('#item_quantity_modal_input').prop('readonly', false);
            $('.modal_increase_item_table').prop('disabled', false);
            $('.modal_decrease_item_table').prop('disabled', false);
        }else if(item_type == 'Variation_Product' || item_type == '0'){
            $('.Available_IMEI_Srial').hide();
            $('.variationProductHtmlRenderWrap').show();
            $('#modal_item_price_input_field').prop('readonly', false);
            $('#modal_discount').prop('readonly', false);
            $('.modal_increase_item_table').prop('disabled', false);
            $('.modal_decrease_item_table').prop('disabled', false);
            $('#item_quantity_modal_input').prop('readonly', false);
        }else if(item_type == 'Service_Product'){
            $('.Available_IMEI_Srial').hide();
            $('.variationProductHtmlRenderWrap').hide();
            $('#modal_item_price_input_field').prop('readonly', false);
            $('#modal_discount').prop('readonly', false);
            $('.modal_increase_item_table').prop('disabled', false);
            $('.modal_decrease_item_table').prop('disabled', false);
            $('#item_quantity_modal_input').prop('readonly', false);
        }
    }



   
    // Code optimize by Azhar ** Final **
    $(document).on('click', '.close_item_modal', function () {
        $('#item_modal').removeClass("active");
        $(".pos__modal__overlay").fadeOut(300);
        resetItemModalAfterAddToCartOrClose();
    });


    // Code optimize by Azhar ** Final **
    $(document).on('click', '#plus_button', function () {
        if(is_offline_system == '1'){
            $.ajax({
                url: base_url + "Master/checkAccess",
                method: "GET",
                async: false,
                dataType: 'json',
                data: { controller: "147", function: "add" },
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
                        resetAddCustomerModalAfterAddOrClose();
                        $('#customer_discount_modal').val("").change();
                        $('#customer_id_modal').val("");
                        $('#customer_price_type').val(1).change();
                        $('#add_or_edit_text').text('Add Customer');
                        $('#add_customer_modal').addClass('active');
                        $('.pos__modal__overlay').fadeIn(300);
                    }
                }
            });
        }
        
    });

    // Code optimize by Azhar ** Final **
    $(document).on('click', '.cancel_customer_modal', function () {
        $('#add_customer_modal').removeClass('active');
        $('.pos__modal__overlay').fadeOut(300);
    });

    // Code optimize by Azhar ** Final **
    $("#customer_dob_modal").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        maxDate: '0'
    });

    // Code optimize by Azhar ** Final **
    $("#customer_doa_modal").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        maxDate: '0'
    });

    // Code optimize by Azhar ** Final **
    function getLastSale(date_c, customer_c, invoice_c, status) {
        if(is_offline_system == '1'){
            $.ajax({
                url: base_url + "Sale/get_last_10_sales_ajax",
                method: "GET",
                data: { date_c: date_c, customer_c: customer_c, invoice_c: invoice_c, status: status },
                success: function (response) {
                    let orders = JSON.parse(response);
                    let last_10_orders = '';
                    if (orders.length === 0) {
                        last_10_orders += `<div class="op_center op_padding_10">There is no sale found</div>`;
                    } else {
                        for (let key in orders) {
                            last_10_orders += `<div class="single_last_ten_sale fix" id="last_ten_${orders[key].id}" data-selected="unselected">
                                <div class="first_column column fix">${orders[key].sale_no}</div>
                                <div class="second_column column fix">${orders[key].customer_name}</div>
                                <div class="third_column column fix">${opDateFormat(orders[key].sale_date) + ' ' + orders[key].order_time}</div>
                            </div>`;
                        }
                    }
                    $(".last_ten_sales_holder .hold_list_holder .detail_holder ").empty();
                    $(".last_ten_sales_holder .hold_list_holder .detail_holder ").prepend(last_10_orders);
                }
            });
        }else{
            const request = indexedDB.open("off_pos", 2);
            request.onsuccess = function(event) {
                const db = event.target.result;
                // Create a transaction on the 'sales' object store
                const transaction = db.transaction(["sales"], "readonly");
                const objectStore = transaction.objectStore("sales");
                // Use getAll to fetch all records
                const getAllRequest = objectStore.getAll();
                getAllRequest.onsuccess = function(event) {
                    const allRecords = event.target.result; // Contains all the records in 'sales' store
                    if (allRecords.length > 0) {
                        let completedRequests = 0; // To track completed AJAX requests
                        const totalRequests = allRecords.length;
                        let last_10_orders = '';
                        if(totalRequests == 0){
                            last_10_orders += `<div class="op_center op_padding_10">There is no sale found</div>`;
                        }
                        allRecords.forEach(record => {
                            last_10_orders += `<div class="single_last_ten_sale fix" id="last_ten_${record.id}" data-selected="unselected">
                                <div class="first_column column fix">${record.sale_no}</div>
                                <div class="second_column column fix">${record.customer_name}</div>
                                <div class="third_column column fix">${record.sale_date + ' ' + record.sale_time}</div>
                            </div>`;
                        });
                        $(".last_ten_sales_holder .hold_list_holder .detail_holder ").empty();
                        $(".last_ten_sales_holder .hold_list_holder .detail_holder ").prepend(last_10_orders);
                    }
                };
                getAllRequest.onerror = function(event) {
                    console.log("Error fetching records:", event);
                };
            };
            request.onerror = function(event) {
                console.log("Error opening database:", event);
            };
        }
        
    }


    // Code optimize by Azhar ** Final **
    $(document).on('click', '.search_sale', function () {
        if(is_offline_system == '1'){
            let date_c = $("#date_c").val();
            let customer_c = $("#customer_c").val();
            let invoice_c = $("#invoice_c").val();
            getLastSale(date_c, customer_c, invoice_c, ''); 
        }
    });

    // Code optimize by Azhar ** Final **
    function recentSaleModalDataClear(){
        $('#last_10_order_invoice_no').text('');
        $('#last_10_order_date_time').text('');
        $('#last_10_customer_name').text('');
        $('.modifier_item_details_holder').html('');
        $('#sub_total_show_last_10').text(Number(0).toFixed(op_precision));
        $('#total_items_in_cart_last_10').text(Number(0));
        $('#total_items_qty_in_cart_last_10').text(Number(0));
        $('#all_items_vat_last_10').text(Number(0).toFixed(op_precision));
        $('#delivery_charge_last_10').text(Number(0).toFixed(op_precision));
        $('#sub_total_discount_last_10').text(Number(0).toFixed(op_precision));
        $('#all_items_discount_last_10').text(Number(0).toFixed(op_precision));
        $('#total_payable_last_10').text(Number(0).toFixed(op_precision));
        $('#paid_amount_last_10').text(Number(0).toFixed(op_precision));
        $('#due_amount_last_10').text(Number(0).toFixed(op_precision));

        // Other
        $('#last_10_customer_id').text('');
        $("#sub_total_last_10").text(Number(0).toFixed(op_precision));
        $("#total_item_discount_last_10").text(Number(0).toFixed(op_precision));
        $("#discounted_sub_total_amount_last_10").text(Number(0).toFixed(op_precision));
        $("#date_c").val('');
    }


    $(document).on('click', '#last_ten_sales_button', function () {
        if(is_offline_system ==  '1'){
            $.ajax({
                url: base_url + "Master/checkAccess",
                method: "GET",
                async: false,
                dataType: 'json',
                data: { controller: "138", function: "list" },
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
                        recentSaleModalDataClear();
                        holdSaleModalDataClear();
                        $("#show_last_ten_sales_modal").addClass("active");
                        $(".pos__modal__overlay").fadeIn(200);
                        $('.overlayForCalculator').css('display', 'none');
                        $('#calculator_main').css('display', 'none');
                        /**
                         * Add Datepicker in form Search field
                         */
                        let op_current_date = new Date();
                        $(".date_sale")
                            .datepicker({
                                autoclose: true,
                                format: "yyyy-mm-dd",
                                todayHighlight: true,
                            })
                            .datepicker("update", op_current_date);
                        $(".date_sale").on("changeDate", function (event) {
                            $("#date_c").val(event.format());
                        });
                        let date_c = $("#date_c").val();
                        getLastSale(date_c, '', '', 'default');
                    }
                }
            });
        }else{
            recentSaleModalDataClear();
            holdSaleModalDataClear();
            $("#show_last_ten_sales_modal").addClass("active");
            $(".pos__modal__overlay").fadeIn(200);
            $('.overlayForCalculator').css('display', 'none');
            $('#calculator_main').css('display', 'none');
            /**
             * Add Datepicker in form Search field
             */
            let op_current_date = new Date();
            $(".date_sale")
                .datepicker({
                    autoclose: true,
                    format: "yyyy-mm-dd",
                    todayHighlight: true,
                })
                .datepicker("update", op_current_date);
            $(".date_sale").on("changeDate", function (event) {
                $("#date_c").val(event.format());
            });
            let date_c = $("#date_c").val();
            getLastSale(date_c, '', '', 'default');
        }
        
    });


    // Code optimize by Azhar ** Final **
    $(document).on('click', '.last_ten_sales_button', function () {

        $.ajax({
            url: base_url + "Master/checkAccess",
            method: "GET",
            async: false,
            dataType: 'json',
            data: { controller: "138", function: "list" },
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
                    recentSaleModalDataClear();
                    holdSaleModalDataClear();
                    $("#show_last_ten_sales_modal").addClass("active");
                    $(".pos__modal__overlay").fadeIn(200);
                    $('.overlayForCalculator').css('display', 'none');
                    $('#calculator_main').css('display', 'none');
                    /**
                     * Add Datepicker in form Search field
                     */
                    let op_current_date = new Date();
                    $(".date_sale")
                        .datepicker({
                            autoclose: true,
                            format: "yyyy-mm-dd",
                            todayHighlight: true,
                        })
                        .datepicker("update", op_current_date);
                    $(".date_sale").on("changeDate", function (event) {
                        $("#date_c").val(event.format());
                    });
                    let date_c = $("#date_c").val();
                    getLastSale(date_c, '', '', 'default');
                }
            }
        });
    });


    // Code optimize by Azhar ** Final **
    function increaseFreeItemQty(type,qty_cart,s_item_id){
        // iterate over each item in the array
        let is_promo = '';
        let promo_type = '';
        let item_id = 0;
        let promo_qty = 0;
        let promo_get_qty = 0;
        let draw_table_for_order = ''
        let promo_item_name = ''
        let promo_item_id = ''

        let single_item = window.items.find(item => item.item_id == s_item_id);
        if(single_item){
            is_promo = single_item.is_promo;
            promo_type = single_item.promo_type;
            item_id = single_item.item_id;
            promo_item_name = single_item.promo_item_name;
            promo_item_id = single_item.promo_item_id;
            promo_qty = single_item.promo_qty;
            promo_get_qty = single_item.promo_get_qty;
        }
        
        if(is_promo=="Yes" && promo_type==2){
            let counting_qty_cart = (parseInt((qty_cart/promo_qty)) * promo_get_qty);
            if(counting_qty_cart > 0){
                draw_table_for_order +=`<div class="free-item free_item_div_${item_id}"  data-get_fm_id="${item_id}" data-free-item-id="${promo_item_id}"  data-is_free="Yes">
                        <div data-id="${item_id}" class="customer_panel single_order_column first_column">
                            <iconify-icon icon="solar:pen-broken" class="op_cursor_pointer edit_item" width="22" data-parent_id=""></iconify-icon>
                            <span id="free_item_name_table_${item_id}">${promo_item_name}</span>
                        </div>
                        <div class="single_order_column second_column">
                            <span id="free_item_price_table_${item_id}">${Number(0).toFixed(op_precision)}</span>
                        </div>
                        <div class="single_order_column third_column">
                            <iconify-icon icon="uil:minus" class="alert_free_item_increase op_cursor_pointer" id="free_decrease_item_table_${item_id}" width="22"></iconify-icon>
                            <span class="4_cp_qty_${item_id} qty_item_custom" id="free_item_quantity_table_${item_id}">1</span>
                            <iconify-icon icon="uil:plus" class="alert_free_item_increase increase_item_table op_cursor_pointer" id="free_increase_item_table_${item_id}" width="22"></iconify-icon>
                        </div>
                        <div class="single_order_column forth_column fix">
                            <input type="" name="" onfocus="select();" placeholder="Amt or %" class="discount_cart_input" id="free_percentage_table_${item_id}" value="0" disabled>
                        </div>
                        <div class="single_order_column fifth_column">
                            <span id="free_item_total_price_table_${item_id}">${Number(0).toFixed(op_precision)}</span>
                            <iconify-icon icon="solar:trash-bin-minimalistic-broken" data-id="${item_id}" class="free-item-remove removeCartItemFree"></iconify-icon>
                        </div>
                    </div>
                </div>`;
                let free_item_div = $(".free_item_div_"+item_id).attr('data-is_free');
                if(free_item_div=="Yes"){
                    $("#free_item_quantity_table_"+item_id).html(counting_qty_cart);
                }else{
                    $("#order_for_item_"+item_id).append(draw_table_for_order);
                }
            }else{
                $(".free_item_div_"+item_id).remove();
            }
        }
    }


    // Code optimize by Azhar ** Final **
    // when plus sign is clicked in the table ** Optimized Code By Azhar
    $(document).on('click', '.single_order .first_portion .third_column .increase_item_table', function () {
        productSound2.play();
        let item_id = $(this).attr('id').substr(20);
        let item_type = $(this).parent().parent().find('.item_type').text();
        let discount = $('#walk_in_customer').find(':selected').attr('discount');
        let parent_id = $(this).parent().parent().parent().attr('data-variation-parent');
        let percentage_table = $(this).parent().parent().find('.forth_column .inline_dis_column').val();
        cartIncDecButtonEnableDisableByType(item_type, item_id);
        let item_obj = findItemByItemId(item_id);
        if(item_obj.is_promo == "Yes"){
            discount = item_obj.promo_discount != '' ? item_obj.promo_discount : 0;
            $(this).parent().parent().find('.forth_column  .inline_dis_column').prop('readonly', true);
        }else{
            if(discount == 0 || discount == "" || discount == NaN || discount == undefined || discount == null || discount == 'null'){
                discount = 0;
            }else{
                discount = discount;
            }
            if(discount != 0){
                $(this).parent().parent().find('.forth_column .inline_dis_column').prop('readonly', true);
            }else{
                $(this).parent().parent().find('.forth_column .inline_dis_column').prop('readonly', false);
            }
        }
        let itemQty = '';
        if(item_type == 'IMEI_Product' || item_type == 'Serial_Product'){
            itemQty = parseFloat($(this).siblings('.cart_quantity').text());
        }else{
            itemQty = parseFloat($(this).siblings('.cart_quantity').text()) + 1;
        }
        if(percentage_table != '' && percentage_table != 0){
            $(this).parent().parent().find('.forth_column .inline_dis_column').val(percentage_table);
        }else{
            $(this).parent().parent().find('.forth_column .inline_dis_column').val(discount);
        }
        let unit_price = $(this).parent().parent().find('.second_column span').eq(0).text();
        let stock_checker = true;
        if(allow_less_sale=="No" && item_type != 'Service_Product'){
            if(is_offline_system == '1'){
                if(item_type == 'Medicine_Product'){
                    let singleExpiryDate = $.trim($(`#expiry_imei_serial_${item_id}`).text());
                    $.ajax({
                        type: "POST",
                        url: base_url+"Sale/singleExpiryDateStockCheck",
                        async: false,
                        data: {
                            expiry_imei_serial: singleExpiryDate,
                            item_id: item_id,
                        },
                        success: function (response) {
                            if(response.status == 'success'){
                                let return_stock = parseFloat(response.data.stock_quantity);
                                if(parseFloat(return_stock) < parseFloat(itemQty)){
                                    stock_checker = false;
                                    toastr['error'](("Stock Not available!"), '');
                                }
                            }
                        }
                    });
                }else{
                    $.ajax({
                        url: base_url + "Sale/stockCheckingForThisOutletById",
                        method: "POST",
                        async: false,
                        dataType: 'json',
                        data: { item_id: item_id },
                        success: function (response) {
                            if(response.status == 'success'){
                                let return_stock = parseFloat(response.data);
                                if(parseFloat(return_stock) < parseFloat(itemQty)){
                                    stock_checker = false;
                                    toastr['error'](("Stock Not available!"), '');
                                }
                            }else{
                                stock_checker = false;
                                toastr['error'](("Stock checking failed! Something went wrong"), '');
                            }
                            
                        }
                    });
                }
                
            }else {
                // Open a connection to the IndexedDB database
                let request = indexedDB.open('off_pos_2', 2);
                request.onerror = function(event) {
                    console.log("Error opening the database:", event.target.error ? event.target.error.message : "Unknown error");
                };
                request.onsuccess = function(event) {
                    let db = event.target.result;
                    // Start a transaction to read from the database
                    let transaction = db.transaction(['items'], 'readonly');
                    let objectStore = transaction.objectStore('items');
                    // Use getAll() to read all data from the 'items' object store
                    let getAllRequest = objectStore.getAll();
                    getAllRequest.onsuccess = function(event) {
                        let items = event.target.result;
                        let product = items[0].find(function(item) {
                            if(item_type == 'Variation_Product'){
                                return item.id == parent_id;
                            }else{
                                return item.id == item_id;
                            }
                        });
                        if(item_type == 'General_Product' && product.type == 'General_Product'){
                            if((Number(product.stock_qty) - Number(product.out_qty)) < Number(itemQty)){
                                stock_checker = false;
                                toastr['error'](("Stock Not available!"), '');
                            }
                        }else if(item_type == 'Variation_Product' && product.type == 'Variation_Product'){
                            product.variations = product.variations.map(function(variation) {
                                if (variation.vId == item_id) {
                                    if((Number(variation.stock_in) - Number(variation.stock_out)) < Number(itemQty)){
                                        stock_checker = false;
                                        toastr['error'](("Stock Not available!"), '');
                                    }
                                }
                            }).filter(variation => variation.stock_out < variation.stock_in);
                        }else if(item_type == 'Medicine_Product' && product.type == 'Medicine_Product'){
                            let totalAvailableStock = 0;
                            if (product.allexpiry) {
                                product.allexpiry.forEach(function(expiryItem) {
                                    let expiryDate = Object.keys(expiryItem)[0];
                                    let quantity = expiryItem[expiryDate];
                                    totalAvailableStock += Number(quantity);
                                });
                            }
                            if (totalAvailableStock < Number(itemQty)) {
                                stock_checker = false;
                                toastr['error']("Stock Not available for medicine product!", '');
                            }
                        }

                        // console.log(product);
                        if(product){
                            let imeiHtml = '';
                            imeiHtml = `<option value="">Select ${item_type == 'IMEI_Product' ? 'IMEI' : 'Serial'}</option>`;
                            if(product.allimei){
                                product.allimei.map(function(imei_serial) {
                                    imeiHtml += `<option value="${$.trim(imei_serial.single_imei_serial)}">${$.trim(imei_serial.single_imei_serial)}</option>`;
                                });
                            }
                            $('#IMEI_Serial').html('');
                            $('#IMEI_Serial').append(imeiHtml);
                            $('.item-modal-top-header').show();
                            $('.modal_qty_area').removeClass('item_modal_quantity_area_disabled');
                        }
                    };
                    getAllRequest.onerror = function(event) {
                        console.log("Error reading data:", event.target.error.message);
                    };
                };
            }
        }
        if(stock_checker){
            let updated_total_price = (parseFloat(itemQty) * parseFloat(unit_price)).toFixed(op_precision);
            $(this).parent().parent().find('.item_price_without_discount').text(updated_total_price);
            $(this).siblings('.cart_quantity').text(itemQty)
            cartItemCalculationInPOS();
            if(edit_mode == ''){
                storageCartDataInLocal();
            }
        }
        increaseFreeItemQty(2, itemQty, item_id);
    });


    function cartIncDecButtonEnableDisableByType(item_type, item_id){
        if(item_type == 'IMEI_Product' || item_type == 'Serail_Product')
        $(`#increase_item_table_${item_id}`).prop('disabled', true);
    }

    // Code optimize by Azhar ** Final **
    //when minus sign is clicked in the table ** Optimized Code By Azhar
    $(document).on('click', '.single_order .first_portion .third_column .decrease_item_table', function () {
        productSound2.play();
        let item_id = $(this).attr('id').substr(20);
        let discount = $('#walk_in_customer').find(':selected').attr('discount');  
        let percentage_table = $(this).parent().parent().find('.forth_column .inline_dis_column').val();
        let item_obj = findItemByItemId(item_id);
        if(item_obj.is_promo == "Yes"){
            discount = item_obj.promo_discount != '' ? item_obj.promo_discount : 0;
            $(this).parent().parent().find('.forth_column  .inline_dis_column').prop('readonly', true);
        }else{
            if(discount == 0 || discount == "" || discount == NaN || discount == undefined || discount == null || discount == 'null'){
                discount = 0;
            }else{
                discount = discount;
            }
            if(discount != 0){
                $(this).parent().parent().find('.forth_column  .inline_dis_column').prop('readonly', true);
            }else{
                $(this).parent().parent().find('.forth_column  .inline_dis_column').prop('readonly', false);
            }
        }
        let item_quantity = parseFloat($(this).siblings('.cart_quantity').text()) - 1;
        let unit_price = parseFloat($(this).parent().parent().find('.second_column span').eq(0).text());
        if(percentage_table != '' && percentage_table != 0){
            $(this).parent().parent().find('.forth_column  .inline_dis_column').val(percentage_table);
        }else{
            $(this).parent().parent().find('.forth_column  .inline_dis_column').val(discount);
        }
        if (item_quantity >= 1) {
            let updated_total_price = (parseFloat(item_quantity) * parseFloat(unit_price)).toFixed(op_precision);
            $(this).parent().parent().find('.item_price_without_discount').text(updated_total_price);
            $(this).siblings('.cart_quantity').text(item_quantity);
            cartItemCalculationInPOS();
            if(edit_mode == ''){
                storageCartDataInLocal();
            }
        } else {
            $(this).parent().parent().parent().remove();
            cartItemCalculationInPOS();
            if(edit_mode == ''){
                storageCartDataInLocal();
            }
        }
        increaseFreeItemQty(1, item_quantity, item_id);
    });


    // Code optimize by Azhar ** Final **
    //add discount for specific item
    $(document).on('keyup', '.single_order .first_portion .forth_column input', function (e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 96 && e.which != 97 && e.which != 98 && e.which != 99 && e.which != 100 && e.which != 101 && e.which != 102 && e.which != 103 && e.which != 104 && e.which != 105 && e.which != 110 && e.which != 190 && e.which != 16 && e.which != 53 && e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            $(this).val('');
        }
        cartItemCalculationInPOS();
        if(edit_mode == ''){
            storageCartDataInLocal();
        }
    });


    // Code optimize by Azhar ** Final **
    //add discount for specific item in modal
    $(document).on('keyup', '#modal_discount', function (e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 96 && e.which != 97 && e.which != 98 && e.which != 99 && e.which != 100 && e.which != 101 && e.which != 102 && e.which != 103 && e.which != 104 && e.which != 105 && e.which != 110 && e.which != 190 && e.which != 16 && e.which != 53 && e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            $(this).val('');
        }
        updateCartItemPrice();
    });

    // Code optimize by Azhar ** Final **
    $(document).on('keyup', '#sub_total_discount', function (e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 96 && e.which != 97 && e.which != 98 && e.which != 99 && e.which != 100 && e.which != 101 && e.which != 102 && e.which != 103 && e.which != 104 && e.which != 105 && e.which != 110 && e.which != 190 && e.which != 16 && e.which != 53 && e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            $(this).val('');
        }
        cartItemCalculationInPOS();
        if(edit_mode == ''){
            storageCartDataInLocal();
        }
    });

    // Code optimize by Azhar ** Final **
    $(document).on('keyup', '#delivery_charge', function (e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 96 && e.which != 97 && e.which != 98 && e.which != 99 && e.which != 100 && e.which != 101 && e.which != 102 && e.which != 103 && e.which != 104 && e.which != 105 && e.which != 110 && e.which != 190 && e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            $(this).val(0);
        } else {
            $("#show_charge_amount").text(parseFloat($(this).val()).toFixed(op_precision));
        }
        if($(this).val() == ''){
            $('#show_charge_amount').text(parseFloat(0).toFixed(op_precision));
        }
        cartItemCalculationInPOS();
        if(edit_mode == ''){
            storageCartDataInLocal();
        }
    });


    $(document).on('click', '.delivery_charge_submit', function(){
        let delivery = $('#delivery_charge').val();
        $('#show_charge_amount').text(parseFloat(delivery).toFixed(op_precision));
        cartItemCalculationInPOS();
        if(edit_mode == ''){
            storageCartDataInLocal();
        }
    });

    // Code optimize by Azhar ** Final **
    $("#walk_in_customer").select2({
        dropdownCssClass: 'bigdrop',
        dropdownAutoWidth: true,
    });


    // Code optimize by Azhar ** Final **
    $(document).on("click", "#open_finalize_cart_details", function () {
        $("#finalize_cart_details_modal").addClass("active");
        $(".pos__modal__overlay").fadeIn(300);
        let subtotal = $('#sub_total_show').text();
        let total_item = $('#total_items_in_cart_without_quantity').text();
        let total_item_with_qty = $('#total_items_in_cart_with_quantity').text();
        let total_vat = $('#show_vat_modal').text();
        let charge = $('#show_charge_amount').text();
        let all_discount = $('#all_items_discount').text();
        let total_discount = $('#show_discount_amount').text();
        let item_id;
        let itemName;
        let itemPrice;
        let itemQty;
        let itemDis;
        let itemSubTotal;
        let singleItem = '';
        $('.single_order').each(function(){
            item_id = $(this).attr('id').substr(15);
            itemName = $(`.single_order #item_name_table_${item_id}`).text();
            itemPrice = $(`.single_order #item_price_table_${item_id}`).text();
            itemQty = $(`.single_order #item_quantity_table_${item_id}`).text();
            itemDis = $(`.single_order #percentage_table_${item_id}`).val();
            itemSubTotal = $(`.single_order #item_total_price_table_${item_id}`).text();
            singleItem += `<div class="item-cart-details-item-list">
                            <span>${itemName}</span>
                            <span class="text-center">${itemPrice}</span>
                            <span class="text-center">${itemQty}</span>
                            <span class="text-center">${itemDis}</span>
                            <span class="text-center">${itemSubTotal}</span>
                        </div>`;
        });
        $('.finalize_item_details').html('');
        $('.finalize_item_details').append(singleItem);
        $('.cart_details_footer').html('');
        $('.cart_details_footer').html(`
            <div class="item">
                <span><b>Total Item:</b> </span> 
                <span>${Number(total_item)}</span>( <span>${Number(total_item_with_qty)}</span> )
            </div>
            <div class="item">
                <span><b>Sub Total:</b></span>
                <span id="cart_modal_total_subtotal_text">${Number(subtotal).toFixed(op_precision)}</span>
            </div>
            <div class="item">
                <span><b>Discount:</b></span> 
                <span >${Number(total_discount).toFixed(op_precision)}</span>
                </span>
            </div>
            <div class="item">
                <span><b>Total Discount:</b> </span>
                <span>${Number(all_discount).toFixed(op_precision)}</span>
            </div>
            <div class="item">
                <span><b>Tax:</b> </span>
                <span>${Number(total_vat).toFixed(op_precision)}</span>
            </div>
            <div class="item">
                <span><b>Delivery Charge: </b></span>
                <span>${Number(charge).toFixed(op_precision)}</span>
            </div>
        `);
    });

    // Code optimize by Azhar ** Final **
    $(document).on('click', '#place_order_operation', function () {
        $('.pos__modal__overlay').fadeIn();
        $('.finalize_modal_is_mul_currency').hide();

        if(sms_enable_status == '1' && is_offline_system == '1'){
            $('.sms_enable_status').prop('checked', true);
        }else{
            $('.sms_enable_status').prop('checked', false);
        }
        if(smtp_enable_status == '1' && is_offline_system == '1'){
            $('.smtp_enable_status').prop('checked', true);
        }else{
            $('.smtp_enable_status').prop('checked', false);
        }
        if(send_invoice_whatsapp == 'Enable' && is_offline_system == '1'){
            $('.send_invoice_whatsapp').prop('checked', true);
        }else{
            $('.send_invoice_whatsapp').prop('checked', false);
        }
        $('.clear_quick_data').click();
        $('#payment_list_div').html('');

        let currentActivePayment = $('.list-for-payment-type .active').attr('data-type_value');
        if(currentActivePayment != undefined){
            if(currentActivePayment == 'Cash'){
                $('#finalize_given_amount_input').focus();
            }else{
                $('#finalize_amount_input').focus();
                setTimeout(function(){
                    $('#finalize_given_amount_input').val('');
                    $('#finalize_change_amount_input').val('');
                    $('#finalize_amount_input').val('');
                }, 200)
            }
        }else{
            let accType;
            $('.account_type').each(function(){
                accType = $(this).attr('data-type_value');
                if(accType == 'Cash'){
                    $(this).addClass('active');
                    $(this).click();
                }
            });
            $('#finalize_given_amount_input').focus(); 
            $('#finalize_change_amount_input').prop('readonly', true); 
            $('#finalize_amount_input').prop('readonly', true); 
        }
        let is_hold_sale_id = $('#is_hold_sale_id').text();
        let customer_id = $('#walk_in_customer').val();
        let customer_name = $('#walk_in_customer').find(':selected').attr('data-customer-name');
        let customer_phone_number = $('#walk_in_customer').find(':selected').attr('data-phone_number');
        let previous_due = $('#walk_in_customer').find(':selected').attr('data-previous_due');
        let select_employee_id = $('#select_employee_id').val();
        let sub_total = parseFloat($('#sub_total_show').text()).toFixed(op_precision);
        let total_vat = parseFloat($('#show_vat_modal').text()).toFixed(op_precision);
        let total_payable = parseFloat($('#total_payable').text()).toFixed(op_precision);
        let total_item_discount_amount = parseFloat($('#total_item_discount').text()).toFixed(op_precision);
        let sub_total_with_discount = parseFloat($('#discounted_sub_total_amount').text()).toFixed(op_precision);
        let sub_total_discount_amount = parseFloat($('#sub_total_discount_amount').text()).toFixed(op_precision);
        let total_discount_amount = parseFloat($('#all_items_discount').text()).toFixed(op_precision);
        let charge_type = $('#charge_type').find(':selected').val();
        let sale_date = $('#open_date_picker').attr('data-get-date');
        let customer_previous_due = $("#customer_previous_due").val();
        let delivery_charge = ($('#delivery_charge').val() != "") ? parseFloat($('#delivery_charge').val()).toFixed(op_precision) : parseFloat(0).toFixed(op_precision);
        let sub_total_discount_value = $('#sub_total_discount').val();
        let sub_total_discount_type = '';
        let delivery_partner = $.trim($('#delivery_partner_info').attr('data-partner-id'));
        let rounding = $.trim($('#rounding').text());
        let old_sale_id = $('#old_sale_id').val();
        let total_items_in_cart = $('.order_holder .single_order').length;

        $("#finalize_previous_due").html(parseFloat(previous_due).toFixed(op_precision));
        $('.set_value_for').html(Number(customer_previous_due));
        $('.finalize-customer-name').text(`Customr: ${customer_name}`);
        $('.finalize_mobile_customer').text(`${customer_name}`);
        if(previous_due > 0){
            $('#previous_due_show').html('');
            $('#previous_due_show').html(`
                <span class="d-none" id="customer_all_due">${parseFloat(previous_due).toFixed(op_precision)}</span>
                <span>${parseFloat(previous_due).toFixed(op_precision)} (Debit)</span>
            `);
            $('.finalize_mobile_op_balance').text('');
            $('.finalize_mobile_op_balance').text(`${parseFloat(previous_due).toFixed(op_precision)} (Debit)`);
        }
        if(previous_due < 0){
            $('#previous_due_show').html('');
            $('#previous_due_show').html(`
                <span class="d-none" id="customer_all_due">${parseFloat(previous_due).toFixed(op_precision)}</span>
                <span>${parseFloat(Math.abs(previous_due)).toFixed(op_precision)} (Credit)</span>
            `);
            $('.finalize_mobile_op_balance').text('');
            $('.finalize_mobile_op_balance').text(`${parseFloat(previous_due).toFixed(op_precision)} (Credit)`);
        }
        if(previous_due == 0){
            $('#previous_due_show').html('');
            $('#previous_due_show').html(`
                <span class="d-none" id="customer_all_due">${parseFloat(previous_due).toFixed(op_precision)}</span>
                <span>${parseFloat(Math.abs(previous_due)).toFixed(op_precision)}</span>
            `);
            $('.finalize_mobile_op_balance').text('');
            $('.finalize_mobile_op_balance').text(`${parseFloat(Math.abs(previous_due)).toFixed(op_precision)}`);
        }
        
        let sale_vat_objects = [];
        $("#tax_row_show .tax_field").each(function (i, obj) {
            let tax_field_id = $(this).attr("data-tax_field_id");
            let tax_field_type = $(this).attr("data-tax_field_type");
            let tax_field_amount = $(this).attr("data-tax_field_amount");
            sale_vat_objects.push({
                tax_field_id: tax_field_id,
                tax_field_type: tax_field_type,
                tax_field_amount: Number(tax_field_amount).toFixed(op_precision),
            });
        });
        if (total_items_in_cart == 0) {
            $('.order_holder').css({
                'border': '3px solid red',
            });
            if ($(window).width() <= 1366){
                $('.order_holder').css({
                    'height': '89%',
                });
            }else if($(window).width() > 1366){
                $('.order_holder').css({
                    'height': '94.50%',
                });
            }
            setTimeout(function(){
                $('.order_holder').css({
                    'border': 'none',
                    'height': 'unset',
                });
                $('.pos__modal__overlay').css('display', 'none');
            }, 1000);
            alert_sound.play();
            toastr['error']((cart_empty), '');
            return false;
        }
        if (sub_total_discount_value.length > 0 && sub_total_discount_value.substr(sub_total_discount_value.length - 1) == '%') {
            sub_total_discount_type = 'percentage';
        } else {
            sub_total_discount_type = 'plain';
        }
        if (customer_id == null || customer_id == "") {
            toastr['error']((select_a_customer), '');
            $('.pos__modal__overlay').fadeOut(300);
            return false;
        }
        let orderInfo = {
            sale_id: old_sale_id,
            charge_type: charge_type,
            random_code: getRandomCode(15),
            customer_id: customer_id,
            is_hold_sale_id: is_hold_sale_id,
            customer_phone_number: customer_phone_number,
            select_employee_id: select_employee_id,
            total_items_in_cart: total_items_in_cart,
            sub_total: sub_total,
            total_vat: total_vat,
            delivery_partner: delivery_partner,
            rounding: rounding,
            total_payable: Number(total_payable),
            total_item_discount_amount: total_item_discount_amount,
            sub_total_with_discount: sub_total_with_discount,
            sub_total_discount_amount: sub_total_discount_amount,
            total_discount_amount: total_discount_amount,
            delivery_charge: delivery_charge,
            sub_total_discount_value: sub_total_discount_value,
            sub_total_discount_type: sub_total_discount_type,
            sale_date: sale_date,
            sale_vat_objects: sale_vat_objects,
            items: []
        };
          
        if ($('.order_holder .single_order').length > 0) {
            $('.order_holder .single_order').each(function (i, obj) {
            
                let item_id = $(this).attr('id').substr(15);
                let sale_unit_name = $(this).attr('data-sale-unit');
                let freeItemLength = $(this).find('.free-item').length;
                let is_promo = $(this).attr('is_promo');
                let item_name = $(this).find('#item_name_table_' + item_id).text();
                let expiry_date_maintain = $(this).find('#expiry_date_maintain_' + item_id).text();
                let item_seller_id = $(this).find('#item_seller_table' + item_id).text();
                let item_description = $(this).find('.item_modal_description_table_' + item_id).text();
                let item_last_purchase_price = $(this).find('#item_last_purchase_price_table_' + item_id).text();
                let item_vat = $(this).find('.item_vat').text();
                let item_discount = $(this).find('#percentage_table_' + item_id).val();
                let expiry_imei_serial = $(this).find('.expiry_imei_serial_' + item_id).text();
                let item_type = $(this).find('#item_type_table' + item_id).text();
                let discount_type = '';
                if (item_discount.length > 0 && item_discount.substr(item_discount.length - 1) == '%') {
                    discount_type = 'percentage';
                } else {
                    discount_type = 'plain';
                }
                let item_price_without_discount = $(this).find('.item_price_without_discount').text();
                let item_unit_price = $(this).find('#item_price_table_' + item_id).text();
                let item_quantity = $(this).find('#item_quantity_table_' + item_id).text();
                let item_price_with_discount = $(this).find('#item_total_price_table_' + item_id).text();
                let item_details = $(this).find('.item_modal_description_table_' + item_id).text();
                let item_discount_amount = (parseFloat(item_price_without_discount) - parseFloat(item_price_with_discount)).toFixed(op_precision);
                
                // Initialize item object
                let item = {
                    item_seller_id: item_seller_id,
                    item_id: item_id,
                    item_name: item_name,
                    item_last_purchase_price: item_last_purchase_price,
                    item_vat: item_vat,
                    item_discount: item_discount,
                    expiry_imei_serial: expiry_imei_serial,
                    expiry_date_maintain: expiry_date_maintain,
                    item_type: item_type,
                    discount_type: discount_type,
                    item_price_without_discount: item_price_without_discount,
                    item_unit_price: item_unit_price,
                    item_quantity: item_quantity,
                    item_price_with_discount: item_price_with_discount,
                    item_discount_amount: item_discount_amount,
                    item_details: item_details,
                    is_promo_item: is_promo,
                    is_promo_item_exist: freeItemLength,
                    item_description: item_description,
                    sale_unit_name: sale_unit_name,
                    combo_item: [] 
                };

                orderInfo.items.push(item);
                let itemIndex = orderInfo.items.length - 1; 
          
                if (freeItemLength > 0) {
                    let freeItemName = $(`#free_item_name_table_${item_id}`).text();
                    let freeItemQty = $(`#free_item_quantity_table_${item_id}`).text();
                    let freeItemId = $(this).find('.free-item').attr('data-free-item-id');
                    orderInfo.items.push({
                        item_seller_id: item_seller_id,
                        item_id: freeItemId,
                        item_name: freeItemName,
                        item_last_purchase_price: "",
                        item_vat: "",
                        item_discount: "",
                        expiry_imei_serial: "",
                        item_type: "",
                        discount_type: "",
                        item_price_without_discount: "",
                        item_unit_price: "",
                        item_quantity: freeItemQty,
                        item_price_with_discount: "",
                        item_discount_amount: "",
                        item_details: "",
                        is_promo_item: "",
                        is_promo_item_exist: "",
                        item_description: "",
                        sale_unit_name: "",
                    });
                }
        
                // Combo Selector
                let combo_cart_item = $(this).find(`.combo_cart_item`).length;
                if (combo_cart_item > 0) {
                    $(this).find(`.combo_cart_item`).each(function() {
                        let combo_id = $(this).find('.first_column').attr('data-id');
                        let comboItemQty = $(`#combo_item_quantity_table_${combo_id}`).text();
                        let comboItemPrice = $(`#combo_item_price_table_${combo_id}`).text();
                        let comboItemType = $(`#combo_item_type_table_${combo_id}`).text();
                        let comboItemSubtotal = $(`#free_item_total_price_table_${combo_id}`).text();
                        let comboItemSeller = $(`#combo_seller_table_${combo_id}`).text();
                        let comboItemShowInv = $(`#combo_inv_show_table_${combo_id}`).text();
                        orderInfo.items[itemIndex].combo_item.push({
                            combo_item_id: combo_id,
                            combo_item_type: comboItemType,
                            combo_item_qty: comboItemQty,
                            combo_item_price: comboItemPrice,
                            combo_item_subtotal: comboItemSubtotal,
                            combo_item_seller: comboItemSeller,
                            show_in_invoice: comboItemShowInv,
                        });
                    });
                }
            });
        }
        let order_object = JSON.stringify(orderInfo);
        add_sale_by_ajax(order_object, total_payable);
    });


    $(document).on("keyup", "#multi_currency_amount", function (e) {
        let this_value = $.trim($(this).val());
        if (isNaN(this_value)) {
            $(this).val("");
            $(".badge_custom").remove();
        }
        if(this_value==''){
            $(".badge_custom").remove();
        }
    });


    function calMultiCurrency(){
        let conversion_rate  = Number($("#multi_currency").find(':selected').attr('data-multi_currency'));
        $("#multi_currency_rate").val(conversion_rate);
        let finalize_total_payable  = Number($("#finalize_total_payable").html());
        let total_mul_amount = (conversion_rate*finalize_total_payable).toFixed(2);
        if(total_mul_amount){
            $("#multi_currency_amount").val(total_mul_amount);
        }else{
            $("#multi_currency_amount").val('');
        }
        calFinalizeModal('');
    }


    $(document).on("change", "#multi_currency", function (e) {
        calMultiCurrency();
    });






    // Code optimize by Azhar ** Final **
    function getRandomCode(length) {
        let result = '';
        let characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        let charactersLength = characters.length;
        for (let i = 0; i < length; i++) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        return result;
    }


    // Code optimize by Azhar ** Final **
    $(document).on('click', '#last_ten_sales_edit_buttons', function () {
        if ($('.single_last_ten_sale[data-selected=selected]').length > 0) {
            let sale_id = $('.single_last_ten_sale[data-selected=selected]').attr('id').substr(9);
            if(is_offline_system == '1'){
                open(base_url +"Sale/edit_sale/" + bin2hex(sale_id),"_self");
            }else{
                singleRecentSaleSetInCart(sale_id);
            }
        } else {
            toastr['error']((please_select_an_order), '');
        }
    });

    function singleRecentSaleSetInCart(sale_id){
        let db;
        const request = indexedDB.open("off_pos", 2);
        request.onerror = function(event) {
            console.error("Database error: " + event.target.error);
        };
        request.onsuccess = function(event) {
            db = event.target.result;
            const transaction = db.transaction(["sales"], "readonly");
            const objectStore = transaction.objectStore("sales");
            const getRequest = objectStore.getAll();
            getRequest.onerror = function(event) {
                console.log("Error fetching Rcent sale:", event.target.error);
            };
            getRequest.onsuccess = function(event) {
                const recentSale = event.target.result;
                if (recentSale) {
                    let find_this_item = '';
                    recentSale.forEach(record => {
                        if(record.id == parseInt(sale_id)){
                            find_this_item = record;
                            $('#offline_edit_sale').val(sale_id);
                            $('#offline_edit_sale_no').val(record.sale_no);
                            return
                        }
                    });
                    let single_item = JSON.parse(find_this_item.order);

                    let itemCount = 0;
                    let totalQty = 0;
                    let discount_value = '';
                    let draw_table_for_order  = '';
                    let expiry_date_maintain ='';
                    let expiry_imei_serial = '';

                    // Leter
                    let variation_parent = '';
                    single_item.items.forEach(function(this_item){
                        if((this_item.item_type == 'IMEI_Product' || this_item.item_type == 'Serial_Product'|| this_item.item_type == 'Medicine_Product') && this_item.expiry_imei_serial){
                            expiry_imei_serial = `<span class="imei_serial_note" id="expiry_imei_serial">${checkItemShortType(this_item.item_type)}: <span class="expiry_imei_serial_${this_item.item_type}">${this_item.expiry_imei_serial}</span></span>`;
                        }else{
                            expiry_imei_serial = '';
                        }
                        draw_table_for_order += `<div data-sale-unit="${this_item.sale_unit_name}" data-variation-parent="${variation_parent}" class="single_order imei_serial_expiry_${this_item.expiry_imei_serial}" is_promo="${this_item.is_promo_item}" data-qty_default="" id="order_for_item_${this_item.item_id}" data-single-order-row-no="" data_cart_item_id="${this_item.item_id}">
                            <div class="first_portion">
                                <span id="item_seller_table${this_item.item_id}" class="d-none">${this_item.item_seller_id}</span>
                                <span class="item_type d-none" id="item_type_table${this_item.item_id}">${this_item.item_type}</span>
                                <span class="item_vat d-none" id="item_vat_percentage_table${this_item.item_id}">${this_item.item_vat}</span>
                                <span class="item_discount d-none" id="item_discount_table${this_item.item_id}">${percentValueCalculateByPriceQtyDiscount(this_item.item_unit_price, this_item.item_quantity, this_item.item_discount)}</span>
                                <span class="item_price_without_discount d-none" id="item_price_without_discount_${this_item.item_id}">${Number(this_item.item_unit_price) * Number(this_item.item_quantity)}</span>
                                <div class="single_order_column first_column">
                                    <iconify-icon icon="solar:pen-broken" class="op_cursor_pointer edit_item" width="22" id="edit_item_${this_item.item_id}"></iconify-icon>
                                    <span id="item_name_table_${this_item.item_id}">${this_item.item_name}</span>
                                </div>
                                <div class="single_order_column second_column">
                                    <span id="item_price_table_${this_item.item_id}">${this_item.is_promo_item == '' ? parseFloat(0).toFixed(op_precision) : this_item.item_unit_price}</span>
                                </div>
                                <div class="single_order_column third_column ${this_item.item_type == 'Combo_Product' ? 'combo_parent_inc_dec' : ''}">
                                    <iconify-icon icon="uil:minus" class="decrease_item_table op_cursor_pointer" id="decrease_item_table_${this_item.item_id}" width="22"></iconify-icon>
                                    <span class="cart_quantity" id="item_quantity_table_${this_item.item_id}">${this_item.item_quantity}</span> 
                                    <iconify-icon icon="uil:plus" class="increase_item_table op_cursor_pointer" id="increase_item_table_${this_item.item_id}" width="22"></iconify-icon>
                                </div>
                                <div class="single_order_column forth_column ${this_item.item_type == 'Combo_Product' ? 'combo_parent_inc_dec' : ''}">
                                    <input type="" name="" onfocus="select();" inline_dis_column="${this_item.item_id}" placeholder="Amt or %" class="special_textbox access_control inline_dis_column" id="percentage_table_${this_item.item_id}" value="${this_item.is_promo_item == '' ? Number(0) : this_item.item_discount}" >
                                </div>
                                <div class="single_order_column fifth_column">
                                    <span id="item_total_price_table_${this_item.item_id}">${this_item.item_price_with_discount}</span> 
                                    <iconify-icon icon="solar:trash-bin-minimalistic-broken" data-remove-order-row-no="" class="remove_this_item_from_cart" width="22"></iconify-icon>
                                </div>
                            </div>
                            ${expiry_imei_serial}
                            <span class="cart_item_modal_des item_modal_description_table_${this_item.item_id}">${this_item.item_description}</span>
                        </div>`;
                    });
                    $(".order_holder").append('');
                    $(".order_holder").append(draw_table_for_order);
                    $('#show_charge_amount').text(single_item.delivery_charge);
                    $('#show_last_ten_sales_modal').removeClass("active");
                    $(".pos__modal__overlay").fadeOut(300);
                    setTimeout(function(){
                        $("#walk_in_customer").val(single_item.customer_id).trigger("change");
                        cartItemCalculationInPOS();
                    }, 200);

                }
            };
        }; 
    }



    //when change customer  ** Optimized Code By Azhar
    $(document).on('change', '#walk_in_customer', function (e) {
        e.preventDefault();
        let customer_id = $(this).val();
        let draft_sale_customer_status = $('#draft_sale_customer_status').val();
        let priceType = $('option:selected', this).attr('price_type');
        let customer_discount = $('option:selected', this).attr('discount');
        customerChangeEvent(customer_id, priceType, customer_discount, draft_sale_customer_status);
    });

    function customerChangeEvent(customer_id, priceType, customer_discount, default_set_flag){
        if(is_offline_system ==  '1'){
            let discount = 0;
            if(customer_id){
                $.ajax({
                    method: "GET",
                    dataType: 'json',
                    url: base_url+"Sale/findCustomerCreditLimit/"+customer_id,
                    success: function (response) {
                        $("#customer_credit_limit").val(Number(response.credit_limit.credit_limit).toFixed(op_precision));
                        $("#customer_previous_due").val(Number(response.due_amount).toFixed(op_precision));
                    }
                });
                if(edit_mode == '' ){
                    let card_data = $('.order_holder').html();
                    if(card_data != '' && default_set_flag == 'No'){
                        let item_qty = 0;
                        let single_item_subtotal  = 0;
                        let singleItemDiscountSum = 0;
                        let whole_sale_price = 0;
                        let sale_price = 0;
                        let item_id;
                        let itemPrice = 0;
                        let item_type = '';
                        let item_obj;
                        $('.single_order').each(function(i,v){
                            item_id = $(this).attr('id').substr(15);
                            item_obj = findItemByItemId(item_id);
                            if (item_obj && item_obj.whole_sale_price) {
                                whole_sale_price = item_obj.whole_sale_price;
                            }else{
                                whole_sale_price = 0;
                            }
                            sale_price = item_obj.price;
                            item_type = item_obj.item_type;
                            if(whole_sale_price == '0' && priceType == '2'){
                                toastr['error'](("Whole sale is setup for this customer, and whole set is not set up for this product"), '');
                            }
                            if(item_obj.is_promo == "Yes"){
                                discount = item_obj.promo_discount != '' ? item_obj.promo_discount : 0;
                                $(this).find('.forth_column .inline_dis_column').prop('readonly', true);
                            }else{
                                discount = customer_discount;
                                if(discount == 0 || discount == "" || discount == NaN || discount == undefined || discount == null || discount == 'null'){
                                    discount = 0;
                                }else{
                                    discount = discount;
                                }
                                if(discount != 0){
                                    $(this).find('.forth_column .inline_dis_column').prop('readonly', true);
                                }else{
                                    $(this).find('.forth_column .inline_dis_column').prop('readonly', false);
                                }
                            }
                            item_qty = $(this).find('.third_column .cart_quantity').text();
                            let old_sale_id = ($("#old_sale_id").val());
                            if(old_sale_id && edit_sale_customer == customer_id){
                                discount = $(this).find('.forth_column .inline_dis_column').attr("data-discount_for_edit");
                            }
                            $(this).find('.forth_column .inline_dis_column').val(discount);
                            if(priceType == 1 && item_type != 'Service_Product'){
                                $(this).find('.second_column span').eq(0).text(Number(sale_price).toFixed(op_precision));
                                single_item_subtotal = singleSubtotalCalculateByPriceDiscount(sale_price, discount);
                                itemPrice = sale_price;
                            }else if(priceType == 2 && item_type != 'Service_Product'){
                                $(this).find('.second_column span').eq(0).text(Number(whole_sale_price).toFixed(op_precision));
                                single_item_subtotal = singleSubtotalCalculateByPriceDiscount(whole_sale_price, discount);
                                itemPrice = whole_sale_price;
                            }else{
                                $(this).find('.second_column span').eq(0).text(Number(sale_price).toFixed(op_precision));
                                single_item_subtotal = singleSubtotalCalculateByPriceDiscount(sale_price, discount);
                                itemPrice = sale_price;
                            }
                            $(this).find('.fifth_column span').eq(0).text(Number(single_item_subtotal).toFixed(op_precision));
                            $(this).find('.item_price_without_discount').text((Number(itemPrice) * Number(item_qty)).toFixed(op_precision));
                            let mainPrice = $(this).find('.second_column span').eq(0).text();
                            let cartQty = $(this).find('.third_column  .cart_quantity').text();
                            let subTotal = $(this).find('.fifth_column span').eq(0).text();
                            let singleItemDiscount = (Number(mainPrice) * Number(cartQty)) - Number(subTotal);
                            singleItemDiscountSum += singleItemDiscount;
                        });
                        $('#all_items_discount').text(Number(singleItemDiscountSum).toFixed(op_precision));
                        cartItemCalculationInPOS();
                        if(edit_mode == ''){
                            storageCartDataInLocal();
                        }
                    }
                }
            }
        }
    }



    // Code optimize by Azhar ** Final **
    $(document).on('keydown keypress keyup', '.single_order_column access_control', function(){
        e.preventDefault();
    });




    // Code optimize by Azhar ** Need to more optimize
    function getNextSaleNo(currentSaleNo) {
        const prefix = currentSaleNo.match(/[A-Z]+/)[0];
        const numberPart = parseInt(currentSaleNo.match(/\d+/)[0]);
        const nextNumber = numberPart + 1;
        const nextSaleNo = prefix + String(nextNumber).padStart(5, '0');
        return nextSaleNo;
    }


    $('.icon_pick_date').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
    }).on('changeDate', function(selected) {
        let startDate = new Date(selected.date.valueOf());
        let date = new Date(startDate);
        let formattedDate = date.getFullYear() + '-' + 
                            ('0' + (date.getMonth() + 1)).slice(-2) + '-' + 
                            ('0' + date.getDate()).slice(-2);
        $(this).attr('data-get-date', formattedDate);
    });
    




    // Code optimize by Azhar ** Need to more optimize
    $(document).on('click', '#finalize_order_button', function () {
        let cThis = $(this);
        let customer_id = $("#walk_in_customer").val();
        let selected_customer_name = $('option:selected', '#walk_in_customer').attr('data-customer-name');
        let customer_phone_number = $('option:selected', '#walk_in_customer').attr('data-phone_number');
        let charge_type = $("#charge_type").val();
        let send_invoice_email = $('input:checkbox[name=send_invoice_email]:checked').val();
        let send_invoice_sms = $('input:checkbox[name=send_invoice_sms]:checked').val();
        let send_invoice_whatsapp = $('input:checkbox[name=send_invoice_whatsapp]:checked').val();
        let customerCrLimit = $("#customer_credit_limit").val();
        let customer_previous_due = $("#customer_previous_due").val();
        let finalize_total_due = Number($("#finalize_total_due").text());
        let account_type = $("#account_type").val();
        let p_note = $("#account_note_s").val();
        let check_no = $("#bank_check_no").val();
        let check_issue_date = $("#bank_check_issue_date").val();
        let check_expiry_date = $("#bank_check_expiry_date").val();
        let card_holder_name = $("#bank_card_holder_name").val();
        let card_holding_number = $("#bank_card_holding_number").val();
        let mobile_no = $("#bank_mobile_no").val();
        let transaction_no = $("#bank_transaction_no").val();
        let paypal_email = $("#bank_paypal_email").val();
        let stripe_email = $("#bank_stripe_email").val();
        let note = $("#note").val();
        let sub_total_discount_finalize = Number($("#sub_total_discount_finalize").val());
        let invoice_print = $("#invoice_print").val();
        let old_sale_id = $("#offline_edit_sale").val();
        let offline_edit_sale_no = $("#offline_edit_sale_no").val();
        let due_date = $("#due_date").val();
        let status = true;


        if (account_type == "Stripe") {
            if (stripePayementStatus == true) {
              status = true;
            } else {
              status = false;
            }
        }
      
        if (account_type == "Paypal") {
            if (paypalPayementStatus == true) {
              status = true;
            } else {
              status = false;
            }
        }

        if (selected_customer_name == 'Walk-in Customer') {
            if (finalize_total_due) {
                status = false;
            }
        }
        if (status == true) {
            let customer_total_limit = Number(customerCrLimit) - Number(customer_previous_due);
            let creditLimitStatus = '';
            if(customer_total_limit == '0'){
                creditLimitStatus = 'No';
            }else if(customer_total_limit > 0){
                if (customer_total_limit >= finalize_total_due) {
                    creditLimitStatus = 'No';
                }else{
                    creditLimitStatus = 'Yes';
                }
            }else{
                creditLimitStatus = 'No';
            }
            if (creditLimitStatus == 'No') {
                if (send_invoice_sms == undefined) {
                    send_invoice_sms = '';
                }
                if (send_invoice_email == undefined) {
                    send_invoice_email = '';
                }
                if (send_invoice_sms == undefined) {
                    send_invoice_sms = '';
                }
                if (send_invoice_whatsapp == undefined) {
                    send_invoice_whatsapp = '';
                }
                $.when(addSaleFirst()).done(function (res1) {

                });
                function addSaleFirst() {
                    let order_object = $("#order_object").val();
                    let sale_id = 0;
                    if ($('.order_table_holder .order_holder').length > 0) {
                        let sale_id = $('.order_table_holder .order_holder').html();
                    }
                    $('.loader1').slideDown('500');
                    // Payment Method Start
                    let paymentAccountDetails = $('.paymentAccountDetails').map(function() {
                        return $(this).val();
                    }).get();
                    let payment_info = [];
                    if ($(".payment_list_counter").length > 0) {
                        $(".payment_list_counter").each(function(i, obj) {
                            let payment_name = $(this).attr("data-payment_name");
                            let payment_id = $(this).attr("data-payment_id");
                            let amount = $(this).attr("data-amount");
                            let usage_point = $(this).attr("data-usage_point");
                            let paymentDetails = {
                                "payment_id": payment_id,
                                "payment_name": payment_name,
                                "amount": amount,
                                "usage_point": usage_point
                            };
                            payment_info.push(paymentDetails);
                        });
                    }
                    let is_multi_currency = $("#is_multi_currency").val();
                    let multi_currency = $("#multi_currency").val();
                    let multi_currency_rate = $("#multi_currency_rate").val();
                    let multi_currency_amount = $("#multi_currency_amount").val();
                    let payment_object = JSON.stringify(payment_info);
                    let account_note = $('#pay_amount_note_invoice_modal_input').val();
                    let finalize_previous_due = $('#customer_all_due').text();
                    let payment_method_type = $('#finalie_order_payment_method').val();
                    let paid_amount = $('#finalize_total_paid').text();            
                    let finalize_total_due = $('#finalize_total_due').text();
                    let change_amount_div_ = $('#change_amount_div_').text();
                    let given_amount = $('#hidden_given_amount').val();

                    $(cThis).attr('disabled', true);
                    let sale_date = new Date().toLocaleDateString(); 
                    let sale_time = new Date().toLocaleTimeString();
                    if(is_offline_system == '0'){
                        const currentSaleNo = $('#last_sale_no').val();
                        let nextSaleNo = '';
                        if(offline_edit_sale_no){
                            nextSaleNo = offline_edit_sale_no;      
                        }else{
                            nextSaleNo = getNextSaleNo(currentSaleNo);
                        }

                        // ############ Index DB ############
                        let db;
                        const request = indexedDB.open("off_pos", 2);  // Changed from 1 to 2
                        request.onupgradeneeded = function(event) {
                            db = event.target.result;  // Use 'db' consistently
                            if (!db.objectStoreNames.contains("sales")) {  // Check if store already exists
                                db.createObjectStore("sales", { keyPath: "id", autoIncrement: true }); 
                                console.log("Object store 'sales' created");
                            }
                        };

                        request.onsuccess = function(event) {
                            db = event.target.result;
                            // Now that the database is opened, create a transaction and add data
                            const transaction = db.transaction(["sales"], "readwrite");
                            const objectStore = transaction.objectStore("sales");  
                            let oData = {
                                is_online: is_offline_system,
                                order: order_object,
                                due_date: due_date,
                                customer_name: selected_customer_name,
                                customer_phone_number: customer_phone_number,
                                sale_id: sale_id,
                                sale_no: nextSaleNo,
                                csrf_offpos: csrf_value_,
                                account_type: account_type,
                                p_note: p_note,
                                check_no: check_no,
                                check_issue_date: check_issue_date,
                                check_expiry_date: check_expiry_date,
                                card_holder_name: card_holder_name,
                                card_holding_number: card_holding_number,
                                mobile_no: mobile_no,
                                transaction_no: transaction_no,
                                paypal_email: paypal_email,
                                stripe_email: stripe_email,
                                send_invoice_email: send_invoice_email,
                                send_invoice_sms: send_invoice_sms,
                                send_invoice_whatsapp: send_invoice_whatsapp,
                                note: note,
                                charge_type: charge_type,
                                sub_total_discount_finalize: sub_total_discount_finalize,
                                paymentAccountDetails: paymentAccountDetails,
                                is_multi_currency: is_multi_currency,
                                multi_currency: multi_currency,
                                multi_currency_rate: multi_currency_rate,
                                multi_currency_amount: multi_currency_amount,
                                payment_object: payment_object,
                                account_note: account_note,
                                finalize_previous_due: finalize_previous_due,
                                payment_method_type: payment_method_type,
                                paid_amount: paid_amount,
                                due_amount: finalize_total_due,
                                given_amount: given_amount,
                                change_amount: change_amount_div_,
                                sale_date: sale_date,
                                sale_time: sale_time,
                                
                            };

                            // Add or update data based on old_sale_id
                            let requestAdd;
                            if(old_sale_id) {
                                // If old_sale_id exists, update existing record
                                oData.id = parseInt(old_sale_id); // Add id for updating
                                requestAdd = objectStore.put(oData);
                            } else {
                                // If no old_sale_id, add new record
                                requestAdd = objectStore.add(oData);
                            }

                            requestAdd.onsuccess = function(event) {
                                console.log(old_sale_id ? "Data updated successfully" : "Data added successfully");
                                $(cThis).attr('disabled', false);
                                $('#last_sale_no').val('').val(nextSaleNo);
                                if(invoice_print == 'web_browser'){
                                    printOfflineInvoice(oData);
                                }
                            };

                            requestAdd.onerror = function(event) {
                                console.log("Error " + (old_sale_id ? "updating" : "adding") + " data:", event);
                            };
                        };

                        request.onerror = function(event) {
                            console.log("Error opening database:", event);
                        };

                        let parseSaleItem = JSON.parse(order_object);
                        let needItemsInfoRemove = parseSaleItem.items.map(item => ({
                            expiry_imei_serial: item.expiry_imei_serial,
                            vp_item_id: item.vp_item_id,
                            item_id: item.item_id,
                            item_type: item.item_type,
                            item_quantity: item.item_quantity
                        }));

                        // Open a connection to the IndexedDB database
                        let request2 = indexedDB.open('off_pos_2', 2);
                        request2.onerror = function(event) {
                            console.log("Error opening the database:", event.target.error ? event.target.error.message : "Unknown error");
                        };

                        request2.onsuccess = function(event) {
                            let db2 = event.target.result;
                            // Start a transaction to read from the database
                            let transaction2 = db2.transaction(['items'], 'readwrite');
                            let objectStore2 = transaction2.objectStore('items');
                            // Use getAll() to read all data from the 'items' object store
                            let getAllRequest2 = objectStore2.getAll();
                            getAllRequest2.onsuccess = function(event) {
                                let items2 = event.target.result;
                                let itemsArray = items2[0];
                                needItemsInfoRemove.forEach(function(removeItem) {
                                    let itemIndex = itemsArray.findIndex(item => {
                                        if (item.type == 'Variation_Product' && removeItem.item_type == 'Variation_Product') {
                                            return item.id == removeItem.vp_item_id;
                                        } else {
                                            return item.id == removeItem.item_id;
                                        }
                                    });
                                    if (itemIndex !== -1) {
                                        let item = itemsArray[itemIndex];
                                        let oldOutQty = 0;

                                        if(removeItem.item_type == 'General_Product' || removeItem.item_type == 'Installment_Product'){
                                            oldOutQty = parseFloat(item.out_qty) || 0;
                                            item.out_qty = oldOutQty + parseFloat(removeItem.item_quantity);
                                        }else if (removeItem.item_type === 'IMEI_Product' || removeItem.item_type === 'Serial_Product') {
                                            item.allimei = item.allimei.filter(function(val2) {
                                                return val2.single_imei_serial !== removeItem.expiry_imei_serial;
                                            });
                                            oldOutQty = parseFloat(item.out_qty) || 0;
                                            item.out_qty = oldOutQty + 1;
                                        } else if(removeItem.item_type == 'Medicine_Product'){
                                            item.allexpiry = item.allexpiry.map(function(val2) {
                                                let date = Object.keys(val2)[0];
                                                if (date == removeItem.expiry_imei_serial) {
                                                    val2[date] -= removeItem.item_quantity;
                                                }
                                                return val2;
                                            }).filter(val2 => Object.values(val2)[0] > 0);
                                        } else if(removeItem.item_type == "Variation_Product"){
                                            item.variations = item.variations.map(function(variation) {
                                                if (variation.vId == removeItem.item_id) {
                                                    variation.stock_out = (parseFloat(variation.stock_out) || 0) + parseFloat(removeItem.item_quantity);
                                                }
                                                return variation;
                                            }).filter(variation => variation.stock_out < variation.stock_in);
                                        }
                                    } else {
                                        console.log('Item Not Found')
                                    }
                                });

                                // Update the entire array in IndexedDB
                                let updateTransaction = db2.transaction(['items'], 'readwrite');
                                let updateObjectStore = updateTransaction.objectStore('items');
                                let updateRequest = updateObjectStore.put(itemsArray);
                                updateRequest.onerror = function(event) {
                                    console.error("Error updating items in IndexedDB:", event.target.error);
                                };
                                updateRequest.onsuccess = function(event) {
                                    console.log("Items updated successfully in IndexedDB");
                                };
                            };
                            getAllRequest2.onerror = function(event) {
                                console.log("Error reading data:", event.target.error.message);
                            };
                        };

                        $('.order_table_holder .order_holder').empty();
                        $('.loader1').slideUp('500');
                        clearFooterCartCalculation();
                        resetDefaultCustomer();
                        resetFinalizeModal();
                        // ############ Index DB ############
                    } else {
                        $.ajax({
                            url: base_url + "Sale/add_sale_by_ajax",
                            method: "POST",
                            dataType: 'json',
                            data: {
                                is_online: is_offline_system,
                                due_date: due_date,
                                order: order_object,
                                customer_name: selected_customer_name,
                                customer_phone_number: customer_phone_number,
                                sale_id: sale_id,
                                sale_no: '',
                                csrf_offpos: csrf_value_,
                                account_type : account_type,
                                p_note : p_note,
                                check_no : check_no,
                                check_issue_date : check_issue_date,
                                check_expiry_date : check_expiry_date,
                                card_holder_name : card_holder_name,
                                card_holding_number : card_holding_number,
                                mobile_no : mobile_no,
                                transaction_no : transaction_no,
                                paypal_email : paypal_email,
                                stripe_email : stripe_email,
                                send_invoice_email : send_invoice_email,
                                send_invoice_sms : send_invoice_sms,
                                send_invoice_whatsapp : send_invoice_whatsapp,
                                note : note,
                                charge_type : charge_type,
                                sub_total_discount_finalize : sub_total_discount_finalize,
                                paymentAccountDetails: paymentAccountDetails,
                                is_multi_currency: is_multi_currency,
                                multi_currency: multi_currency,
                                multi_currency_rate: multi_currency_rate,
                                multi_currency_amount: multi_currency_amount,
                                payment_object: payment_object,
                                account_note: account_note,
                                finalize_previous_due: finalize_previous_due,
                                payment_method_type: payment_method_type,
                                paid_amount: paid_amount,
                                due_amount: finalize_total_due,
                                given_amount: given_amount,
                                change_amount: change_amount_div_,
                                sale_date: sale_date,
                                sale_time: sale_time,
                            },
                            success: function (response) {
                                $('.order_table_holder .order_holder').empty();
                                $('.loader1').slideUp('500');
                                clearFooterCartCalculation();
                                resetDefaultCustomer();
                                getAllCustomers(default_customer, 0, '');
                                printInvoice(response.sales_id);
                                resetFinalizeModal();
                                $(cThis).attr('disabled', false);
                                $("#last_sale_id").val('').val(response.sales_id);
    
                                // window.location.href = base_url+"Sale/POS";
                                let toastr_title = '';
                                if(response.status == 'success'){
                                    toastr_title = 'Success';
                                }else if(response.status == 'warning'){
                                    toastr_title = 'Warning';
                                }else if(response.status == 'error'){
                                    toastr_title = 'Error';
                                }
                                toastr[response.status](response.message, toastr_title);
                            }, 
                            error: function () {
                                toastr['error']("Something went wrong! Sale Process is not complete!", 'Error');
                            }
                        });
                    }

                }
            }else{
                toastr['error']((`You cannot keep more than ${Number(customerCrLimit).toFixed(op_precision)} dues for this customer, Previous due ${Number(customer_previous_due).toFixed(op_precision)} Credit limit is  ${Number(customerCrLimit).toFixed(op_precision)}`));
            }
        }else{
            toastr['error'](("Due amount not allow for walk in customer!"), '');
        }
    });



    

    
    let printTypeCss = '';
    if(print_format == '56mm'){
        printTypeCss = `#wrapper{max-width:480px;}.short_note{font-size:10px !important;font-style:italic;}
        @media print{#wrapper{max-width:480px;}table tfoot{display:table-row-group;}.table{page-break-inside:auto;}.table tr{page-break-inside:avoid;page-break-after:auto}.print-btn{display:none;}}`;
    }else if(print_format == '80mm'){
        printTypeCss = `#wrapper{max-width:480px;}.short_note{font-size:10px!important;font-style:italic;}@media print{#wrapper{max-width:480px;}table tfoot{display:table-row-group;}.table{page-break-inside:auto;}.table tr{page-break-inside:avoid;page-break-after:auto}.print-btn{display:none;}}`;
    }else if(print_format == 'A4 Print'){
        printTypeCss = `#wrapper{max-width:790px;margin:0 auto;}.shop-name,.invoice-heading{font-size:22px;font-weight:900;}.bill-to,.common-heading{font-size:18px;font-weight:900;}@page{size:A4;margin:0;}@media print{@page{size:A4;margin:0;}#wrapper{width:793.92px;}table tfoot{display:table-row-group;}.table{page-break-inside:auto;}.table tr{page-break-inside:avoid;page-break-after:auto}.print-btn{display:none;}.main-footer{display:none!important;}.justify-content-between{justify-content:space-between!important;}}`;
    }else if(print_format == 'Half A4 Print'){
        printTypeCss = `#wrapper{max-width:561px;margin:0 auto;}.btn{border-radius:0;margin-bottom:5px;}.bootbox .modal-footer{border-top:0;text-align:center;}.shop-name,.invoice-heading{font-size:12px;font-weight:bold;}.bill-to,.common-heading{font-size:10px;font-weight:900;}h4{margin:5px 0;}.order_barcodes img{float:none !important;margin-top:5px;}p{font-size:10px;}table thead tr th{font-size:11px !important;padding-top:5px!important;padding-bottom:5px!important;text-align:left;}table tfoot tr th{font-size:11px !important;padding:4px 0px !important;}table tbody tr td{font-size:11px !important;padding:3px 3px !important;}.short_note{font-size:8px !important;}@page{size:A5;margin:0;}@media print{@page{size:A5;margin:0;}.no-print{display:none;}#wrapper{max-width:561px;min-width:250px;margin:0 auto;}.no-border{border:none !important;}.border-bottom{border-bottom:1px solid #ddd !important;}table tfoot{display:table-row-group;}.tbl{page-break-inside:auto;}.tbl tr{page-break-inside:avoid;page-break-after:auto;}.tbl td{border:1px solid #a2a2a2;font-size:14px;padding:3px 6px 2px !important;}tr.noBorder td{border:0 !important;}.tablePage{page-break-inside:auto;}img{-webkit-print-color-adjust:exact;}table thead tr th,table tbody tr td,table tfoot tr th{border-right:0;border-right:none;}}footer{width:100%;text-align:center;}@media print{.inv_black{-webkit-print-color-adjust:exact;background-color:#000 !important;color:#fff !important;font-weight:bold;color:#fff;font-size:22px;display:table;text-align:center;margin:0 auto;padding:3px 8px;margin-top:10px;border-radius:3px;}.margin-bottom-10{margin-bottom:10px;}footer{position:fixed;bottom:0;}.content-block,p{page-break-inside:avoid;}}.inv_black{-webkit-print-color-adjust:exact;background-color:#000;font-weight:bold;color:#fff;font-size:22px;display:table;text-align:center;margin:0 auto;padding:3px 8px;margin-top:10px;border-radius:3px;}.tbl{page-break-inside:auto;}.tbl tr{page-break-inside:avoid;page-break-after:auto;}.tbl td{border:1px solid #a2a2a2;font-size:14px;padding:3px 6px 2px !important;}tr.noBorder td{border:0 !important;}.tablePage{page-break-inside:auto;}.logo_header{overflow:hidden;display:inline-block;width:100%;}.op_width_60_p{width:60%;}.op_float_left{float:left;}`;
    }else if(print_format == 'Letter Head'){
        printTypeCss = `.page-header{position:fixed;top:0;width:100%;background:rgb(236,236,236)}.page-footer{position:fixed;bottom:0;width:100%;background:rgb(236,236,236)}.page{page-break-after:always}#wrapper{max-width:793.92px;margin:0 auto}.btn{border-radius:0;margin-bottom:5px}.bootbox .modal-footer{border-top:0;text-align:center}.shop-name,.invoice-heading{font-size:12px;font-weight:bold}.bill-to,.common-heading{font-size:10px;font-weight:900}h4{margin:5px 0}.order_barcodes img{float:none!important;margin-top:5px}p{font-size:10px}table thead tr th{font-size:11px!important;padding-top:5px!important;padding-bottom:5px!important;text-align:left}table tfoot tr th{font-size:11px!important;padding:4px 0px!important}table tbody tr td{font-size:11px!important;padding:3px 3px!important}.short_note{font-size:8px!important}@page{size:A4;margin:0}@media print{thead{display:table-header-group}tfoot{display:table-footer-group}button{display:none}body{margin:0}@page{size:A4;margin:0}.no-print{display:none}#wrapper{max-width:793.92px;margin:0 auto}.no-border{border:none!important}.border-bottom{border-bottom:1px solid #ddd!important}table tfoot{display:table-row-group}tr.noBorder td{border:0!important}.tablePage{page-break-inside:auto}img{-webkit-print-color-adjust:exact}table thead tr th,table tbody tr td,table tfoot tr th{border-right:0;border-right:none}}footer{width:100%;text-align:center}@media print{.inv_black{-webkit-print-color-adjust:exact;background-color:#000!important;color:#fff!important;font-weight:bold;color:#fff;font-size:22px;display:table;text-align:center;margin:0 auto;padding:3px 8px;margin-top:10px;border-radius:3px}.margin-bottom-10{margin-bottom:10px}footer{position:fixed;bottom:0}.content-block,p{page-break-inside:avoid}}.inv_black{-webkit-print-color-adjust:exact;background-color:#000;font-weight:bold;color:#fff;font-size:22px;display:table;text-align:center;margin:0 auto;padding:3px 8px;margin-top:10px;border-radius:3px}tr.noBorder td{border:0!important}.tablePage{page-break-inside:auto}.logo_header{overflow:hidden;display:inline-block;width:100%}.op_width_60_p{width:60%}.op_float_left{float:left}`;
    }
    


    let styleCSS = `body{box-sizing:border-box;font-family:'Public Sans',sans-serif}*{margin:0px;padding:0px}p{padding:0px;margin:0px;font-family:'Public Sans',sans-serif}h1,h2,h3,h4,h5,h6{padding:0px;margin:0px;font-family:'Public Sans',sans-serif}table thead tr th{border:0;padding:10px 0px;text-align:left;font-size:14px}table tbody tr:nth-child(even){background-color:#8979790d}.tbl-footer-bg{background-color:rgb(0 0 0 / 27%)!important}table tfoot{border-top:2px solid rgb(94,94,94)!important;border-bottom:2px solid rgb(94,94,94)!important}table tfoot tr th{padding:8px 0px;text-align:left}table tbody tr td{padding:10px 5px;font-size:15px}table tbody tr th{padding:10px 5px}table{border-spacing:0px;border-radius:3px}.text-danger{color:#ff503d}.m-auto{margin:auto!important}.p-5{padding:5px!important}.p-10{padding:10px!important}.p-20{padding:20px!important}.p-30{padding:30px!important}.px-30{padding:0px 30px!important}.py-30{padding:30px 0px!important}.py-5{padding-top:5px!important;padding-bottom:5px!important}.px-5{padding-left:5px!important;padding-right:5px!important}.ps-3{padding-left:3px!important}.pr-3{padding-right:3px!important}.ps-2{padding-left:2px!important}.pr-2{padding-right:2px!important}.py-15{padding-top:15px!important;padding-bottom:15px!important}.my-10{margin-top:10px!important;margin-bottom:10px!important}.br-5{border-radius:5px!important}.d-flex{display:flex!important}.align-items-center{align-items:center!important}.justify-content-between{justify-content:space-between!important}.justify-content-center{justify-content:center!important}.justify-content-end{justify-content:end!important}.flex-wrap{flex-wrap:wrap}.pb-5{padding-bottom:5px!important}.pb-6{padding-bottom:6px!important}.pb-7{padding-bottom:7px!important}.pt-7{padding-top:7px!important}.f-w-500{font-weight:500!important}.f-w-600{font-weight:600!important}.text-center{text-align:center!important}.text-start{text-align:start!important}.mt-15{margin-top:15px!important}.py-10{padding-top:10px!important;padding-bottom:10px!important}.py-20{padding-top:20px!important;padding-bottom:20px!important}.w-1{width:1%!important}.w-2{width:2%!important}.w-3{width:3%!important}.w-4{width:4%!important}.w-5{width:5%!important}.w-6{width:6%!important}.w-7{width:7%!important}.w-8{width:8%!important}.w-9{width:9%!important}.w-10{width:10%!important}.w-11{width:11%!important}.w-12{width:12%!important}.w-13{width:13%!important}.w-14{width:14%!important}.w-15{width:15%!important}.w-16{width:16%!important}.w-17{width:17%!important}.w-18{width:18%!important}.w-19{width:19%!important}.w-20{width:20%!important}.w-21{width:21%!important}.w-22{width:22%!important}.w-23{width:23%!important}.w-24{width:24%!important}.w-25{width:25%!important}.w-26{width:26%!important}.w-27{width:27%!important}.w-28{width:28%!important}.w-29{width:29%!important}.w-30{width:30%!important}.w-31{width:31%!important}.w-32{width:32%!important}.w-33{width:33%!important}.w-34{width:34%!important}.w-35{width:35%!important}.w-36{width:36%!important}.w-37{width:37%!important}.w-38{width:38%!important}.w-39{width:39%!important}.w-40{width:40%!important}.w-41{width:41%!important}.w-42{width:42%!important}.w-43{width:43%!important}.w-44{width:44%!important}.w-45{width:45%!important}.w-46{width:46%!important}.w-47{width:47%!important}.w-48{width:48%!important}.w-49{width:49%!important}.w-50{width:50%!important}.w-51{width:51%!important}.w-52{width:52%!important}.w-53{width:53%!important}.w-54{width:54%!important}.w-55{width:55%!important}.w-56{width:56%!important}.w-57{width:57%!important}.w-58{width:58%!important}.w-59{width:59%!important}.w-60{width:60%!important}.w-61{width:61%!important}.w-62{width:62%!important}.w-63{width:63%!important}.w-64{width:64%!important}.w-65{width:65%!important}.w-66{width:66%!important}.w-67{width:67%!important}.w-68{width:68%!important}.w-69{width:69%!important}.w-70{width:70%!important}.w-71{width:71%!important}.w-72{width:72%!important}.w-73{width:73%!important}.w-74{width:74%!important}.w-75{width:75%!important}.w-76{width:76%!important}.w-77{width:77%!important}.w-78{width:78%!important}.w-79{width:79%!important}.w-80{width:80%!important}.w-81{width:81%!important}.w-82{width:82%!important}.w-83{width:83%!important}.w-84{width:84%!important}.w-85{width:85%!important}.w-86{width:86%!important}.w-87{width:87%!important}.w-88{width:88%!important}.w-89{width:89%!important}.w-90{width:90%!important}.w-91{width:91%!important}.w-92{width:92%!important}.w-93{width:93%!important}.w-94{width:94%!important}.w-95{width:95%!important}.w-96{width:96%!important}.w-97{width:97%!important}.w-98{width:98%!important}.w-99{width:99%!important}.w-100{width:100%!important}.mt-10{margin-top:10px!important}.mb-10{margin-bottom:10px!important}.mt-5{margin-top:5px!important}.mb-5{margin-bottom:5px!important}.mt-20{margin-top:20px!important}.color-white{color:white!important}.bg-00c53{background:#dfdede!important}.color-00c53{color:#dfdede!important}.br-3{border-radius:3px!important}.pt-30{padding-top:30px!important}.pt-10{padding-top:10px!important}.pt-2{padding-top:2px!important}.pb-2{padding-bottom:2px!important}.pb-3{padding-bottom:3px!important}.pt-3{padding-top:3px!important}.mt-2{margin-top:2px!important}.mb-2{margin-bottom:2px!important}.pt-20{padding-top:20px!important}.d-inline{display:inline!important}.b-t-1p-e4e5ea{border-top:1px solid #e4e5ea!important}.p-10{padding:10px!important}.text-rigth{text-align:right!important}.text-danger{color:#ff503d}.bg-240{background-color:rgb(247 247 247)!important}.bt-1-gray{border-top:1px solid gray!important}.bb-1-gray{border-bottom:1px solid gray!important}.bb-1-d5d5d5{border-bottom:1px solid #d5d5d5!important}.pl-5{padding-left:5px!important}.pl-10{padding-left:10px!important}.d-block{display:block!important}.pb-10{padding-bottom:10px!important}.p-15{padding:15px!important}.h-120px{height:120px!important}.m-h-120px-m-h-220px{min-height:120px;max-height:220px}.b-1s-240{border:1px solid rgb(240,240,240)!important}.d-grid{display:grid!important}.g-template-c-32-32-32{grid-template-columns:32% 32% 32%!important}.g-template-c-33-33-33{grid-template-columns:33% 33% 33%!important}.g-template-c-33-33-32{grid-template-columns:33% 33% 32%!important}.g-gap-1{grid-gap:1%}.g-gap-2{grid-gap:2%}.g-template-c-50-40{grid-template-columns:50% 40%!important}.g-template-c-48-48{grid-template-columns:48% 48%!important}.grid-gap-10{grid-gap:10%!important}.grid-gap-4{grid-gap:4%!important}.print-btn{background-color:#8b5cf6;color:white;border:0;padding:12px 25px;font-weight:600;font-size:15px;border-radius:5px;font-family:'Public Sans',sans-serif;cursor:pointer}.mt-40{margin-top:40px}.mt-50{margin-top:50px}.mt-60{margin-top:60px}.mt-70{margin-top:70px}.mt-80{margin-top:80px}.mt-90{margin-top:90px}.mt-100{margin-top:100px}.text-rigth{text-align:right!important}.h-100{height:100px}.w-75{width:75px}.mr-10{margin-right:10px}.float-left{float:left}.img-passport{width:160px!important;height:160px!important;border-radius:3px;object-fit:cover}.h-100px{height:100px!important}.h-150-px{height:150px!important}.font-16{font-size:16px!important}.font-18{font-size:18px!important}.font-20{font-size:20px!important}.font-22{font-size:22px!important}.font-width-700{font-weight:700!important}.d-none{display:none!important}.d-inline-block{display:inline-block!important}.mt-30-minus{margin-top:-30px!important}.mt-30{margin-top:30px!important}.pb-20{padding-bottom:20px!important}.font-size-10{font-size:10px}.font-size-11{font-size:11px}.font-size-12{font-size:12px}.font-size-13{font-size:13px}.font-size-14{font-size:14px}.font-size-15{font-size:15px}.font-size-18{font-size:18px}.font-size-20{font-size:20px}.font-size-20{font-size:20px}.font-size-22{font-size:22px}.wg-available{background:#cfefe4;color:#38ae7b;border-radius:3px;margin-left:5px;font-size:11px;padding:0px 3px;font-weight:600}.wg-expire{background:#f8e2d9;color:#dd6f41;border-radius:3px;margin-left:5px;font-size:11px;padding:0px 3px;font-weight:600}.tharmal_table table thead tr th{font-size:13px!important;border-top:1px dotted gray!important;border-bottom:1px dotted gray!important;padding:5px 0px}.tharmal_table table tbody tr td{font-size:13px!important}.tharmal_table table tfoot tr th{font-size:13px!important;border-top:1px dotted gray!important}.tharmal_table table tbody tr:nth-child(even){background-color:white}.tharmal_table table tbody tr td{padding:4px 5px}.text-right{text-align:right!important}.pr-5{padding-right:5px!important}.pr-10{padding-right:5px!important}.pl-5{padding-left:5px!important}.pr-5{padding-right:5px!important}.pr-10{padding-right:10px!important}.pt-5{padding-top:5px!important}.pb-5{padding-bottom:5px!important}.border-bottom-dotted-gray{border-bottom:1px dotted gray!important}.border-top-dotted-gray{border-top:1px dotted gray!important}.ps-5{padding-left:5px}.top_bottom_border_dotted{border-top:1px dotted;border-bottom:1px dotted}.bg-7c67eb{background:#7c67eb}.text-white{color:white}.p3{padding:3px}.bradius-3{border-radius:3px}.text-left{text-align:left}.padding-y-10{padding-top:10px;padding-bottom:10px}.padding-y-8{padding-top:8px;padding-bottom:8px}.padding-y-5{padding-top:5px;padding-bottom:5px}.short_note{font-size:12px;font-style:italic}.br-1{border-radius:1px}.br-2{border-radius:2px}.br-3{border-radius:3px}.br-4{border-radius:4px}.br-5{border-radius:5px}.success-status{background-color:#60f88947;color:#38c435;border-radius:4px;padding:4px 7px}.pending-status{background-color:#fdd9d9;color:#f3484c;border-radius:4px;padding:4px 7px}`;



    
    // Offline Sync Invoice Print
    function printOfflineInvoice(data){
        let invoice_print =``;
        let invoice_logo =``;
        let collect_tax_string =``;
        let given_amount_html = ``;
        let change_amount_html = ``;
        let items_html = ``;
        let item_note = '';
        let delivery_charge_html = ``;
        let sub_total_discount_html = ``;
        let tax_html = ``;
        let payment_html = ``;
        let loyalty_string = ``;
        let total_discount_amount = 0;
        let total_qty = 0;
        let item_count = 0;
        let sub_total = 0;
        let parsedData = JSON.parse(data.order);

        if(print_format == '56mm' || print_format == '80mm'){
            if(invoice_logo_session != ''){
                invoice_logo = `<img src="${base_url}uploads/site_settings/${invoice_logo_session}">`;
            }
            if(collect_tax == 'Yes'){
                collect_tax_string = `<p class="pb-7 f-w-900 rgb-71">${tax_title}: ${tax_registration_no}</p>`;
            }
            if(data.given_amount){
                given_amount_html = `<div class="d-flex justify-content-center">
                                            <p class="f-w-600 font-size-13">${given_amount_ln}: ${data.given_amount}</p>
                                        </div>`;
            }
            if(data.change_amount){
                change_amount_html = `<div class="d-flex justify-content-center">
                                            <p class="f-w-600 font-size-13">${change_amount_ln}: ${data.change_amount}</p>
                                        </div>`;
            }
            if(parsedData.delivery_charge > 0){
                delivery_charge_html=`<div class="d-flex justify-content-between">
                    <p class="f-w-600 font-size-13">${charge_ln} (${parsedData.charge_type == 'delivery' ? 'Delivery' : 'Service'})</p>
                    <p class="font-size-13">${getAmtPCustom(parseFloat(parsedData.delivery_charge))}</p>
                </div>`
            }
            if(parsedData.sub_total_discount_amount > 0){
                sub_total_discount_html=`<div class="d-flex justify-content-between">
                    <p class="f-w-600 font-size-13">${discount_ln}</p>
                    <p class="font-size-13">${getAmtPCustom(parseFloat(parsedData.sub_total_discount_amount))}</p>
                </div>`
            }
    
            parsedData.items.forEach(function(item) {
                item_count ++;
                total_discount_amount += parseFloat(item.item_discount_amount);
                total_qty += parseFloat(item.item_quantity);
                sub_total += parseFloat(item.item_price_with_discount);
                if((item.item_type == 'IMEI_Product' || item.item_type == 'Serial_Product' || item.item_type == 'Medicine_Product') && item.expiry_imei_serial){
                    item_note=`<p class="short_note">${checkItemShortType(item.item_type)}: ${item.expiry_imei_serial}</p>`;
                }else{
                    item_note = '';
                }
                items_html +=`<tr>
                                <td>${item_count}</td>
                                <td>
                                    ${item.item_name} <br>
                                    ${item_note}
                                </td>
                                <td>${item.item_unit_price}</td>
                                <td>${item.item_quantity} ${item.sale_unit_name}</td>
                                <td class="text-right">${item.item_price_with_discount}</td>
                            </tr>`;
                            
            });
    
    
            if(parsedData.sale_vat_objects){
                parsedData.sale_vat_objects.forEach(function(vat, index){
                    tax_html += `<div class="d-flex justify-content-between border-bottom-dotted-gray ${index == 0 ? 'border-top-dotted-gray' : ''}">
                        <p class="f-w-600 font-size-13">${vat.tax_field_type}</p>
                        <p class="font-size-13">${vat.tax_field_amount}</p>
                    </div>`;
                });
            }
    
            let paymentData = JSON.parse(data.payment_object);
            paymentData.forEach(function(payment){
                if(payment.payment_name == 'Loyalty Point'){
                    loyalty_string = `(Usage: ${payment.usage_point })`;
                }
                payment_html +=`<div class="d-flex justify-content-between">
                    <p class="f-w-600 font-size-13">
                        ${payment.payment_name}
                    </p>
                    <p class="font-size-13">
                        ${payment.amount}
                    </p>
                </div>
                <div class="d-flex justify-content-center pt-5">
                    <p class="font-size-13">${loyalty_string}</p>
                </div>`;
            });
    
            let outlet_email_html = ``;
            if(outlet_email){
                outlet_email_html = `<p class="f-w-500 color-71 font-size-13">${email_ln}: ${outlet_email}</p>`;
            }
            invoice_print+= `<!DOCTYPE html>
                                <html lang="en">
                                <head>
                                    <meta charset="UTF-8">
                                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                    <title>${data.sale_no}</title>
                                    <style>
                                    ${styleCSS}
                                    ${printTypeCss}
                                    </style>
                                </head>
                                <body>
                                    <div id="wrapper" class="m-auto border-2s-e4e5ea br-5 p-15">
                                        <div class="d-flex justify-content-center">
                                            ${invoice_logo}
                                        </div>
                                        <div class="text-center">
                                            <h3 class="font-size-20">${business_name}</h3>
                                            <h4 class="pb-7 font-size-15">${outlet_name}</h4>
                                            <p class="f-w-500 color-71 font-size-13">${outlet_address}</p>
                                            <p class="f-w-500 color-71 font-size-13">${phone_ln}: ${outlet_phone}</p>
                                            ${outlet_email_html}
                                            ${collect_tax_string}
                                        </div>
                                        <div class="text-center py-10">
                                            <h3 class="font-size-20">${invoice_ln}</h3>
                                        </div>
                                        <div>
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <p class="f-w-500 color-71 font-size-13"><span class="f-w-600">${bill_to_ln}:</span> ${data.customer_name}</p>
                                                    <p class="f-w-500 color-71 font-size-13 ${(data.customer_phone_number == '' || data.customer_phone_number == 'null') ? 'd-none' : ''}"><span class="f-w-600">${phone_ln}:</span> ${data.customer_phone_number}</p>
                                                </div>
                                                <div class="text-rigth">
                                                    <p class="f-w-500 color-71 font-size-13"><span class="f-w-600">${invoice_no_ln}:</span> 
                                                    ${data.sale_no}</p>
                                                    <p class="f-w-500 color-71 font-size-13"> <span class="f-w-600">${date_ln}: ${parsedData.sale_date}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tharmal_table">
                                            <table class="table w-100 mt-20">
                                                <thead class="br-3">
                                                    <tr>
                                                        <th class="w-5">${sn_ln}</th>
                                                        <th class="w-30">${item_ln} - ${code_ln} - ${brand_ln}</th>
                                                        <th class="w-20">${unit_price_ln}</th>
                                                        <th class="w-10">${qty_ln}</th>
                                                        <th class="w-20 text-right">${total_ln}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                ${items_html}
                                                </tbody>
                                                <tfoot>
                                                    <th></th>
                                                    <th colspan="2" class="text-right pr-10">${total_ln}</th>
                                                    <th>${item_count}(${total_qty})</th>
                                                    <th class="text-right">${parseFloat(sub_total).toFixed(op_precision)}</th>
                                                </tfoot>
                                            </table>
                                        </div>
                                        ${tax_html}
                                        ${delivery_charge_html}
                                        ${sub_total_discount_html}
                                        <div class="d-flex justify-content-between border-bottom-dotted-gray">
                                            <p class="font-size-13 f-w-600">${total_payable_ln}</p>
                                            <p class="font-size-13">${getAmtPCustom(parseFloat(parsedData.total_payable))}</p>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <p class="f-w-600 font-size-13">${paid_amount_ln}</p>
                                            <p class="font-size-13">${getAmtPCustom(data.paid_amount)}</p>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <p class="f-w-600 font-size-13">${due_amount_ln}</p>
                                            <p class="font-size-13">${getAmtPCustom(parseFloat(data.due_amount))}</p>
                                        </div>
                                        <div class="d-flex justify-content-between border-bottom-dotted-gray border-top-dotted-gray">
                                            <p class="f-w-600 font-size-13">${payment_method_ln}</p>
                                        </div>
                                        ${payment_html}
                                        ${given_amount_html}
                                        ${change_amount_html}
                                        <div class="mt-30">
                                            <p>${term_conditions}</p>
                                        </div>
                                        <div class="d-flex justify-content-center pt-30">
                                            <div>
                                                <p class="font-size-15">${invoice_footer}</p>
                                            </div>
                                        </div>
    
                                        <div class="d-flex justify-content-center pt-30">
                                            <button onclick="window.print();" type="button" class="print-btn">Print</button>
                                        </div>
                                    </div>
                                    <script src="${base_url}assets/bower_components/jquery/dist/jquery.min.js"></script>
                                    <script src="${base_url}frequent_changing/js/onload_print.js"></script>
                                </body>
                            </html>`;
                let popup = window.open("", "popup","width=100","height=600");
                popup.document.write(invoice_print);
                popup.document.close();
                popup.focus();
        }else if(print_format == 'A4 Print'){
            if(invoice_logo_session != ''){
                invoice_logo = `<img src="${base_url}uploads/site_settings/${invoice_logo_session}">`;
            }
            if(collect_tax == 'Yes'){
                collect_tax_string = `<p class="pb-7 f-w-900 rgb-71">${tax_title}: ${tax_registration_no}</p>`;
            }
            if(data.given_amount){
                given_amount_html = `<div class="d-flex justify-content-center">
                                            <p class="f-w-600 font-size-13">${given_amount_ln}: ${data.given_amount}</p>
                                        </div>`;
            }
            if(data.change_amount){
                change_amount_html = `<div class="d-flex justify-content-center">
                                            <p class="f-w-600 font-size-13">${change_amount_ln}: ${data.change_amount}</p>
                                        </div>`;
            }
            if(parsedData.delivery_charge > 0){
                delivery_charge_html=`<div class="d-flex justify-content-between pt-10">
                    <p class="f-w-600">${charge_ln} (${parsedData.charge_type == 'delivery' ? 'Delivery' : 'Service'})</p>
                    <p>${getAmtPCustom(parseFloat(parsedData.delivery_charge))}</p>
                </div>`
            }
            if(parsedData.sub_total_discount_amount > 0){
                sub_total_discount_html=`<div class="d-flex justify-content-between pt-10">
                    <p class="f-w-600">${discount_ln}</p>
                    <p>${getAmtPCustom(parseFloat(parsedData.sub_total_discount_amount))}</p>
                </div>`
            }
            parsedData.items.forEach(function(item) {
                item_count ++;
                total_discount_amount += parseFloat(item.item_discount_amount);
                total_qty += parseFloat(item.item_quantity);
                sub_total += parseFloat(item.item_price_with_discount);
                if((item.item_type == 'IMEI_Product' || item.item_type == 'Serial_Product' || item.item_type == 'Medicine_Product') && item.expiry_imei_serial){
                    item_note=`<p class="short_note">${checkItemShortType(item.item_type)}: ${item.expiry_imei_serial}</p>`;
                }
                items_html +=`<tr>
                                <td>${item_count}</td>
                                <td>
                                    ${item.item_name} <br>
                                    ${item_note}
                                </td>
                                <td>${item.item_unit_price}</td>
                                <td>${item.item_quantity} ${item.sale_unit_name}</td>
                                <td>
                                    ${item.item_discount} ${ item.item_discount ? '(' + item.item_discount_amount + ')' : ''}
                                </td>
                                <td class="text-right">${item.item_price_with_discount}</td>
                            </tr>`;
                            
            });
            if(parsedData.sale_vat_objects){
                parsedData.sale_vat_objects.forEach(function(vat, index){
                    tax_html += `<div class="d-flex justify-content-between pt-5 pb-5 border-bottom-dotted-gray ${index == 0 ? 'border-top-dotted-gray mt-10' : ''}">
                        <p class="f-w-600">${vat.tax_field_type}</p>
                        <p>${vat.tax_field_amount}</p>
                    </div>`;
                });
            }
            let paymentData = JSON.parse(data.payment_object);
            paymentData.forEach(function(payment){
                if(payment.payment_name == 'Loyalty Point'){
                    loyalty_string = `(Usage: ${payment.usage_point })`;
                }
                payment_html +=`<div class="d-flex justify-content-between pb-5">
                    <p class="f-w-600">
                        ${payment.payment_name}
                    </p>
                    <p>
                        ${payment.amount}
                    </p>
                </div>
                <div class="d-flex justify-content-center pt-5">
                    <p>${loyalty_string}</p>
                </div>`;
            });
    
            let outlet_email_html = ``;
            if(outlet_email){
                outlet_email_html = `<p class="pb-7 f-w-500 color-71">${email_ln}: ${outlet_email}</p>`;
            }

            invoice_print+= `<!DOCTYPE html>
                                <html lang="en">
                                <head>
                                    <meta charset="UTF-8">
                                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                    <title>${data.sale_no}</title>
                                    <style>
                                    ${styleCSS}
                                    ${printTypeCss}
                                    </style>
                                </head>
                                <body>
                                    <div id="wrapper" class="m-auto border-2s-e4e5ea br-5 p-30">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h3 class="pb-7 shop-name">${business_name}</h3>
                                                <h4 class="pb-7 common-heading">${outlet_name}</h4>
                                                <p class="pb-7 f-w-500 color-71">${outlet_address}</p>
                                                <p class="pb-7 f-w-500 color-71">${phone_ln}: ${outlet_phone}</p>
                                                ${outlet_email_html}
                                                ${collect_tax_string}
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <div class="m-auto">
                                                    ${invoice_logo}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center py-10">
                                            <h2 class="invoice-heading">${invoice_ln}</h2>
                                        </div>
                                        <div>
                                            <p class="pb-7 color-71"><span class="f-w-600">${bill_to_ln}:</span> ${data.customer_name}</p>
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <p class="pb-7 color-71 ${(data.customer_phone_number == '' || data.customer_phone_number == 'null') ? 'd-none' : ''}"><span class="f-w-600">${phone_ln}:</span> ${data.customer_phone_number}</p>
                                                </div>
                                                <div class="text-rigth">
                                                    <p class="pb-7"><span class="f-w-600">${invoice_no_ln}:</span> 
                                                    ${data.sale_no}</p>
                                                    <p class="pb-7 f-w-500 color-71"><span class="f-w-600">${date_ln}:</span> ${parsedData.sale_date}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <table class="table w-100 mt-20">
                                                <thead class="br-3 bg-00c53">
                                                    <tr>
                                                        <th class="w-5 ps-5">${sn_ln}</th>
                                                        <th class="w-30">${item_ln} - ${code_ln} - ${brand_ln}</th>
                                                        <th class="w-20">${unit_price_ln}</th>
                                                        <th class="w-10">${qty_ln}</th>
                                                        <th class="w-15">${discount_ln}</th>
                                                        <th class="w-20 text-right pr-10">${total_ln}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                ${items_html}
                                                </tbody>
                                                <tfoot>
                                                    <th></th>
                                                    <th colspan="2" class="text-right pr-10">${total_ln}</th>
                                                    <th>${item_count}(${total_qty})</th>
                                                    <th>${total_discount_amount}</th>
                                                    <th class="text-right">${parseFloat(sub_total).toFixed(op_precision)}</th>
                                                </tfoot>
                                            </table>
                                        </div>

                                        <div class="d-grid g-template-c-50-40 grid-gap-10 pt-20">
                                            <div>
                                                <div class="pt-10">
                                                    <h4 class="d-block pb-10">${note_lan}</h4>
                                                    <div class="w-100 bg-240 h-120px p-15 b-1s-240 br-4">
                                                        <p>
                                                            ${data.note}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                ${tax_html}
                                                ${delivery_charge_html}
                                                ${sub_total_discount_html}

                                                <div class="d-flex justify-content-between pt-10 mt-10 p-10 bg-00c53 br-4">
                                                    <p class="f-w-600">${total_payable_ln}</p>
                                                    <p>${getAmtPCustom(parseFloat(parsedData.total_payable))}</p>
                                                </div>
                                                <div class="d-flex justify-content-between pt-10">
                                                    <p class="f-w-600">${paid_amount_ln}</p>
                                                    <p>${getAmtPCustom(data.paid_amount)}</p>
                                                </div>
                                                <div class="d-flex justify-content-between pt-10">
                                                    <p class="f-w-600">${due_amount_ln}</p>
                                                    <p>${getAmtPCustom(parseFloat(data.due_amount))}</p>
                                                </div>
                                                <div class="my-10 d-flex justify-content-between pt-5 pb-5 border-bottom-dotted-gray border-top-dotted-gray">
                                                    <p class="f-w-600">${payment_method_ln}</p>
                                                </div>
                                                ${payment_html}
                                            </div>
                                        </div>
                                        
                                        <div class="d-flex justify-content-end mt-80">
                                            <div>
                                                <p class="color-71 d-inline b-t-1p-e4e5ea pt-10">${authorized_signature_ln}</p>
                                            </div>
                                        </div>
                                                                        
                                        
                                        <div class="mt-80">
                                            <p>${term_conditions}</p>
                                        </div>
                                        <div class="d-flex justify-content-center pt-30">
                                            <div>
                                                <p class="font-size-15">${invoice_footer}</p>
                                            </div>
                                        </div>
    
                                        <div class="d-flex justify-content-center pt-30">
                                            <button onclick="window.print();" type="button" class="print-btn">Print</button>
                                        </div>
                                    </div>
                                    <script src="${base_url}assets/bower_components/jquery/dist/jquery.min.js"></script>
                                    <script src="${base_url}frequent_changing/js/onload_print.js"></script>
                                </body>
                            </html>`;
                let popup = window.open("", "popup","width=100","height=600");
                popup.document.write(invoice_print);
                popup.document.close();
                popup.focus();
        }else if(print_format == 'Half A4 Print'){

            if(invoice_logo_session != ''){
                invoice_logo = `<img src="${base_url}uploads/site_settings/${invoice_logo_session}">`;
            }
            if(collect_tax == 'Yes'){
                collect_tax_string = `<p class="pb-3 f-w-900 rgb-71">${tax_title}: ${tax_registration_no}</p>`;
            }
            if(data.given_amount){
                given_amount_html = `<div class="d-flex justify-content-center">
                                            <p class="f-w-600 font-size-13">${given_amount_ln}: ${data.given_amount}</p>
                                        </div>`;
            }
            if(data.change_amount){
                change_amount_html = `<div class="d-flex justify-content-center">
                                            <p class="f-w-600 font-size-13">${change_amount_ln}: ${data.change_amount}</p>
                                        </div>`;
            }
            if(parsedData.delivery_charge > 0){
                delivery_charge_html=`<div class="d-flex justify-content-between">
                    <p class="f-w-600">${charge_ln} (${parsedData.charge_type == 'delivery' ? 'Delivery' : 'Service'})</p>
                    <p>${getAmtPCustom(parseFloat(parsedData.delivery_charge))}</p>
                </div>`
            }
            if(parsedData.sub_total_discount_amount > 0){
                sub_total_discount_html=`<div class="d-flex justify-content-between">
                    <p class="f-w-600">${discount_ln}</p>
                    <p>${getAmtPCustom(parseFloat(parsedData.sub_total_discount_amount))}</p>
                </div>`
            }
    
            parsedData.items.forEach(function(item) {
                item_count ++;
                total_discount_amount += parseFloat(item.item_discount_amount);
                total_qty += parseFloat(item.item_quantity);
                sub_total += parseFloat(item.item_price_with_discount);
                if((item.item_type == 'IMEI_Product' || item.item_type == 'Serial_Product' || item.item_type == 'Medicine_Product') && item.expiry_imei_serial){
                    item_note=`<p class="short_note">${checkItemShortType(item.item_type)}: ${item.expiry_imei_serial}</p>`;
                }
                items_html +=`<tr>
                                <td>${item_count}</td>
                                <td>
                                    ${item.item_name} <br>
                                    ${item_note}
                                </td>
                                <td>${item.item_unit_price}</td>
                                <td>${item.item_quantity} ${item.sale_unit_name}</td>
                                <td>
                                    ${item.item_discount} ${ item.item_discount ? '(' + item.item_discount_amount + ')' : ''}
                                </td>
                                <td class="text-right">${item.item_price_with_discount}</td>
                            </tr>`;
                            
            });
    
    
            if(parsedData.sale_vat_objects){
                tax_html += `<div class="d-flex justify-content-between pt-2 pb-3 mt-2 mb-2 border-bottom-dotted-gray">
                <div class="d-flex">`;
                parsedData.sale_vat_objects.forEach(function(vat, index){
                    tax_html += `<p class="f-w-600">${vat.tax_field_type}</p>
                        <p>${vat.tax_field_amount} - </p>`;
                });
                tax_html += `</div></div>`;
            }
    
            let paymentData = JSON.parse(data.payment_object);
            payment_html +=`<div class="d-flex">`;
            paymentData.forEach(function(payment){
                if(payment.payment_name == 'Loyalty Point'){
                    loyalty_string = `(Usage: ${payment.usage_point })`;
                }
                payment_html +=`<p class="f-w-600">
                        ${payment.payment_name}
                    </p>
                    <p>
                        ${payment.amount}
                    </p>`;
            });
            payment_html +=`</div>`;

            let outlet_email_html = ``;
            if(outlet_email){
                outlet_email_html = `<p class="pb-3 f-w-500 color-71">${email_ln}: ${outlet_email}</p>`;
            }
            invoice_print+= `<!DOCTYPE html>
                                <html lang="en">
                                <head>
                                    <meta charset="UTF-8">
                                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                    <title>${data.sale_no}</title>
                                    <style>
                                    ${styleCSS}
                                    ${printTypeCss}
                                    </style>
                                </head>
                                <body>
                                    <div id="wrapper" class="m-auto border-2s-e4e5ea br-5 p-30">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h3 class="pb-3 shop-name">${business_name}</h3>
                                                <h4 class="pb-3 common-heading">${outlet_name}</h4>
                                                <p class="pb-3 f-w-500 color-71">${outlet_address}</p>
                                                <p class="pb-3 f-w-500 color-71">${phone_ln}: ${outlet_phone}</p>
                                                ${outlet_email_html}
                                                ${collect_tax_string}
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <div class="m-auto">
                                                    ${invoice_logo}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center py-10">
                                            <h2 class="invoice-heading">${invoice_ln}</h2>
                                        </div>
                                        <div>
                                            <p class="pb-7 color-71"><span class="f-w-600">${bill_to_ln}:</span> ${data.customer_name}</p>
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <p class="pb-7 color-71 ${(data.customer_phone_number == '' || data.customer_phone_number == 'null') ? 'd-none' : ''}"><span class="f-w-600">${phone_ln}:</span> ${data.customer_phone_number}</p>
                                                </div>
                                                <div class="text-rigth">
                                                    <p class="pb-7"><span class="f-w-600">${invoice_no_ln}:</span> 
                                                    ${data.sale_no}</p>
                                                    <p class="pb-7 f-w-500 color-71"><span class="f-w-600">${date_ln}:</span> ${parsedData.sale_date}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <table class="table w-100 mt-20">
                                                <thead class="br-3 bg-00c53">
                                                    <tr>
                                                        <th class="w-5 ps-5">${sn_ln}</th>
                                                        <th class="w-30">${item_ln} - ${code_ln} - ${brand_ln}</th>
                                                        <th class="w-20">${unit_price_ln}</th>
                                                        <th class="w-10">${qty_ln}</th>
                                                        <th class="w-15">${discount_ln}</th>
                                                        <th class="w-20 text-right pr-10">${total_ln}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                ${items_html}
                                                </tbody>
                                                <tfoot class="tbl-footer-bg bt-1-gray bb-1-gray">
                                                    <th></th>
                                                    <th colspan="2" class="text-right pr-10">${total_ln}</th>
                                                    <th>${item_count}(${total_qty})</th>
                                                    <th>${total_discount_amount}</th>
                                                    <th class="text-right">${parseFloat(sub_total).toFixed(op_precision)}</th>
                                                </tfoot>
                                            </table>
                                        </div>
                                            
                                        <div>
                                            ${tax_html}
                                            ${delivery_charge_html}
                                            ${sub_total_discount_html}

                                            <div class="d-flex justify-content-between pt-2 pb-3 mt-2 mb-2 border-bottom-dotted-gray">
                                                <p class="f-w-600">${total_payable_ln}</p>
                                                <p>${getAmtPCustom(parseFloat(parsedData.total_payable))}</p>
                                            </div>
                                            <div class="d-flex justify-content-between pt-2 pb-3 mt-2 mb-2 border-bottom-dotted-gray">
                                                <p class="f-w-600">${paid_amount_ln}</p>
                                                <p>${getAmtPCustom(data.paid_amount)}</p>
                                            </div>
                                            <div class="d-flex justify-content-between pt-2 pb-3 mt-2 mb-2 border-bottom-dotted-gray">
                                                <p class="f-w-600">${due_amount_ln}</p>
                                                <p>${getAmtPCustom(parseFloat(data.due_amount))}</p>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <p class="f-w-600">${payment_method_ln}</p>
                                                ${payment_html}
                                            </div>
                                        </div>
                                        
                                        <div class="d-flex justify-content-end mt-80">
                                            <div>
                                                <p class="color-71 d-inline b-t-1p-e4e5ea pt-10">${authorized_signature_ln}</p>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center pt-30">
                                            <div>
                                                <p class="font-size-15">${invoice_footer}</p>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center pt-30">
                                            <button onclick="window.print();" type="button" class="print-btn">Print</button>
                                        </div>
                                    </div>
                                    <script src="${base_url}assets/bower_components/jquery/dist/jquery.min.js"></script>
                                    <script src="${base_url}frequent_changing/js/onload_print.js"></script>
                                </body>
                            </html>`;
                let popup = window.open("", "popup","width=100","height=600");
                popup.document.write(invoice_print);
                popup.document.close();
                popup.focus();
            
        }else if(print_format == 'Letter Head'){
            if(collect_tax == 'Yes'){
                collect_tax_string = `<p class="pb-7 f-w-900 rgb-71">${tax_title}: ${tax_registration_no}</p>`;
            }
            if(data.given_amount){
                given_amount_html = `<div class="d-flex justify-content-center">
                                            <p class="f-w-600 font-size-13">${given_amount_ln}: ${data.given_amount}</p>
                                        </div>`;
            }
            if(data.change_amount){
                change_amount_html = `<div class="d-flex justify-content-center">
                                            <p class="f-w-600 font-size-13">${change_amount_ln}: ${data.change_amount}</p>
                                        </div>`;
            }
            if(parsedData.delivery_charge > 0){
                delivery_charge_html=`<div class="d-flex justify-content-between pt-2 pb-3 mt-2 mb-2 border-bottom-dotted-gray">
                    <p class="f-w-600">${charge_ln} (${parsedData.charge_type == 'delivery' ? 'Delivery' : 'Service'})</p>
                    <p>${getAmtPCustom(parseFloat(parsedData.delivery_charge))}</p>
                </div>`
            }
            if(parsedData.sub_total_discount_amount > 0){
                sub_total_discount_html=`<div class="d-flex justify-content-between pt-2 pb-3 mt-2 mb-2 border-bottom-dotted-gray">
                    <p class="f-w-600">${discount_ln}</p>
                    <p>${getAmtPCustom(parseFloat(parsedData.sub_total_discount_amount))}</p>
                </div>`
            }
    
            parsedData.items.forEach(function(item) {
                item_count ++;
                total_discount_amount += parseFloat(item.item_discount_amount);
                total_qty += parseFloat(item.item_quantity);
                sub_total += parseFloat(item.item_price_with_discount);
                if((item.item_type == 'IMEI_Product' || item.item_type == 'Serial_Product' || item.item_type == 'Medicine_Product') && item.expiry_imei_serial){
                    item_note=`<p class="short_note">${checkItemShortType(item.item_type)}: ${item.expiry_imei_serial}</p>`;
                }
                items_html +=`<tr>
                                <td>${item_count}</td>
                                <td>
                                    ${item.item_name} <br>
                                    ${item_note}
                                </td>
                                <td>${item.item_unit_price}</td>
                                <td>${item.item_quantity} ${item.sale_unit_name}</td>
                                <td>
                                    ${item.item_discount} ${ item.item_discount ? '(' + item.item_discount_amount + ')' : ''}
                                </td>
                                <td class="text-right">${item.item_price_with_discount}</td>
                            </tr>`;
                            
            });
    

            if(parsedData.sale_vat_objects){
                tax_html += `<div class="d-flex justify-content-between pt-2 pb-3 mt-2 mb-2 border-bottom-dotted-gray">
                <p class="f-w-600">${tax_ln}</p>
                <div class="d-flex">`;
                parsedData.sale_vat_objects.forEach(function(vat, index){
                    tax_html += `
                            <p class="f-w-600">${vat.tax_field_type}</p>
                            <p>${vat.tax_field_amount},</p>
                        `;
                });
                tax_html += `</div></div>`;
            }


            let paymentData = JSON.parse(data.payment_object);
            payment_html +=`<div class="d-flex">`;
            paymentData.forEach(function(payment){
                if(payment.payment_name == 'Loyalty Point'){
                    loyalty_string = `(Usage: ${payment.usage_point })`;
                }
                payment_html +=`
                    <p class="f-w-600  pr-3">
                        ${payment.payment_name}:
                    </p>
                    <p>
                        ${payment.amount}
                    </p>`;
            });
            payment_html +=`</div>`;
    
            let outlet_email_html = ``;
            if(outlet_email){
                outlet_email_html = `<p class="pb-7 f-w-500 color-71">${email_ln}: ${outlet_email}</p>`;
            }
            invoice_print+= `<!DOCTYPE html>
                                <html lang="en">
                                <head>
                                    <meta charset="UTF-8">
                                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                    <title>${data.sale_no}</title>
                                    <style>
                                    ${styleCSS}
                                    ${printTypeCss}
                                    </style>
                                </head>
                                <body>

                                    <div class="page-header" style="height: ${letter_head_gap};">
                                    </div>
                                    <div class="page-footer" style="height: ${letter_footer_gap};">
                                    </div>


                                    <table class="w-100">
                                        <thead>
                                            <tr>
                                                <td>
                                                    <div class="page-header-space" style="height: ${letter_head_gap};"></div>
                                                </td>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td>
                                                <div id="wrapper" class="m-auto border-2s-e4e5ea br-5 br-5 px-30 py-15">
                                                    <div>
                                                        <p class="pb-3 color-71">
                                                            <span class="f-w-600">${bill_to_ln}:</span> ${data.customer_name}
                                                        </p>
                                                        <p class="pb-3 color-71 ${(data.customer_phone_number == '' || data.customer_phone_number == 'null') ? 'd-none' : ''}"><span class="f-w-600">${phone_ln}:</span> ${data.customer_phone_number}</p>
                                                        <div class="d-flex justify-content-between">
                                                            <div>
                                                            </div>
                                                            <div class="text-rigth">
                                                                <p class="pb-3">
                                                                    <span class="f-w-600">${invoice_no_ln}:</span>
                                                                    ${data.sale_no}
                                                                </p>
                                                                <p class="pb-3 f-w-500 color-71"> 
                                                                    <span class="f-w-600">${date_ln}:</span> 
                                                                    ${parsedData.sale_date}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <table class="table w-100">
                                                            <thead class="br-3 bg-00c53">
                                                                <tr>
                                                                    <th class="w-5 ps-5">${sn_ln}</th>
                                                                    <th class="w-30">${item_ln} - ${code_ln} - ${brand_ln}</th>
                                                                    <th class="w-20">${unit_price_ln}</th>
                                                                    <th class="w-10">${qty_ln}</th>
                                                                    <th class="w-15">${discount_ln}</th>
                                                                    <th class="w-20 text-right pr-10">${total_ln}</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            ${items_html}
                                                            </tbody>
                                                            <tfoot class="tbl-footer-bg bt-1-gray bb-1-gray">
                                                                <tr>
                                                                    <th></th>
                                                                    <th class="pr-10 text-right" colspan="2">${total_ln}</th>
                                                                    <th>${item_count}(${total_qty})</th>
                                                                    <th>${total_discount_amount}</th>
                                                                    <th class="text-right pr-10">${parseFloat(sub_total).toFixed(op_precision)}</th>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>

                                                  
                                                    <div class="d-flex justify-content-between pt-2 pb-3 mt-2 mb-2 border-bottom-dotted-gray">
                                                        <p class="f-w-600">${sub_total_ln}</p>
                                                        <p>${parsedData.sub_total}</p>
                                                    </div>
                                                    ${tax_html}
                                                    ${delivery_charge_html}
                                                    ${sub_total_discount_html}
                                                    <div>
                                                        <div class="d-flex justify-content-between pt-2 pb-3 mt-2 mb-2 border-bottom-dotted-gray">
                                                            <p class="f-w-600">${total_payable_ln}</p>
                                                            <p>${getAmtPCustom(parseFloat(parsedData.total_payable))}</p>
                                                        </div>
                                                        
                                                        <div class="d-flex justify-content-between pt-2 pb-3 mt-2 mb-2 border-bottom-dotted-gray">
                                                            <p class="f-w-600">${paid_amount_ln}</p>
                                                            <p>${getAmtPCustom(data.paid_amount)}</p>
                                                        </div>
                                                        <div class="d-flex justify-content-between pt-2 pb-3 mt-2 mb-2 border-bottom-dotted-gray">
                                                            <p class="f-w-600">${due_amount_ln}</p>
                                                            <p>${getAmtPCustom(parseFloat(data.due_amount))}</p>
                                                        </div>
                                                        <div class=" pt-2 pb-3 mt-2 mb-2">
                                                            <div class="d-flex justify-content-between">
                                                                <p class="f-w-600">${payment_method_ln}</p>
                                                                ${payment_html}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-center pt-30">
                                                        <button onclick="window.print();" type="button" class="print-btn no-print">Print</button>
                                                    </div>
                                                </div>  
                                                </td>
                                            </tr>
                                        </tbody>

                                        <tfoot>
                                            <tr>
                                                <td>
                                                    <div class="page-footer-space" style="height: ${letter_head_gap};"></div>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <script src="${base_url}assets/bower_components/jquery/dist/jquery.min.js"></script>
                                    <script src="${base_url}frequent_changing/js/onload_print.js"></script>
                                </body>
                            </html>`;
                let popup = window.open("", "popup","width=100","height=600");
                popup.document.write(invoice_print);
                popup.document.close();
                popup.focus();
        }
        
        
    }
    // Offline synce Challan Print
    function printOfflineChallan(data){
        let invoice_print =``;
        let invoice_logo =``;
        let collect_tax_string =``;
        let given_amount_html = ``;
        let change_amount_html = ``;
        let items_html = ``;
        let item_note = '';
        let delivery_charge_html = ``;
        let sub_total_discount_html = ``;
        let tax_html = ``;
        let payment_html = ``;
        let loyalty_string = ``;
        let total_discount_amount = 0;
        let total_qty = 0;
        let item_count = 0;
        let sub_total = 0;
        let parsedData = JSON.parse(data.order);
        

        if(invoice_logo_session != ''){
            invoice_logo = `<img src="${base_url}uploads/site_settings/${invoice_logo_session}">`;
        }
        if(collect_tax == 'Yes'){
            collect_tax_string = `<p class="pb-7 f-w-900 rgb-71">${tax_title}: ${tax_registration_no}</p>`;
        }
        if(data.given_amount){
            given_amount_html = `<div class="d-flex justify-content-center">
                                        <p class="f-w-600 font-size-13">${given_amount_ln}: ${data.given_amount}</p>
                                    </div>`;
        }
        if(data.change_amount){
            change_amount_html = `<div class="d-flex justify-content-center">
                                        <p class="f-w-600 font-size-13">${change_amount_ln}: ${data.change_amount}</p>
                                    </div>`;
        }
        if(parsedData.delivery_charge > 0){
            delivery_charge_html=`<div class="d-flex justify-content-between pt-10">
                <p class="f-w-600">${charge_ln} (${parsedData.charge_type == 'delivery' ? 'Delivery' : 'Service'})</p>
                <p>${getAmtPCustom(parseFloat(parsedData.delivery_charge))}</p>
            </div>`
        }
        if(parsedData.sub_total_discount_amount > 0){
            sub_total_discount_html=`<div class="d-flex justify-content-between pt-10">
                <p class="f-w-600">${discount_ln}</p>
                <p>${getAmtPCustom(parseFloat(parsedData.sub_total_discount_amount))}</p>
            </div>`
        }

        parsedData.items.forEach(function(item) {
            item_count ++;
            total_discount_amount += parseFloat(item.item_discount_amount);
            total_qty += parseFloat(item.item_quantity);
            sub_total += parseFloat(item.item_price_with_discount);
            if((item.item_type == 'IMEI_Product' || item.item_type == 'Serial_Product' || item.item_type == 'Medicine_Product') && item.expiry_imei_serial){
                item_note=`<p class="short_note">${checkItemShortType(item.item_type)}: ${item.expiry_imei_serial}</p>`;
            }
            items_html +=`<tr>
                            <td>${item_count}</td>
                            <td>
                                ${item.item_name} <br>
                                ${item_note}
                            </td>
                            <td>${item.item_unit_price}</td>
                            <td>${item.item_quantity} ${item.sale_unit_name}</td>
                            <td>
                                ${item.item_discount} ${ item.item_discount ? '(' + item.item_discount_amount + ')' : ''}
                            </td>
                            <td class="text-right">${item.item_price_with_discount}</td>
                        </tr>`;
                        
        });


        if(parsedData.sale_vat_objects){
            parsedData.sale_vat_objects.forEach(function(vat, index){
                tax_html += `<div class="d-flex justify-content-between pt-5 pb-5 border-bottom-dotted-gray ${index == 0 ? 'border-top-dotted-gray mt-10' : ''}">
                    <p class="f-w-600">${vat.tax_field_type}</p>
                    <p>${vat.tax_field_amount}</p>
                </div>`;
            });
        }

        let paymentData = JSON.parse(data.payment_object);
        paymentData.forEach(function(payment){
            if(payment.payment_name == 'Loyalty Point'){
                loyalty_string = `(Usage: ${payment.usage_point })`;
            }
            payment_html +=`<div class="d-flex justify-content-between pb-5">
                <p class="f-w-600">
                    ${payment.payment_name}
                </p>
                <p>
                    ${payment.amount}
                </p>
            </div>
            <div class="d-flex justify-content-center pt-5">
                <p>${loyalty_string}</p>
            </div>`;
        });

        let outlet_email_html = ``;
        if(outlet_email){
            outlet_email_html = `<p class="pb-7 f-w-500 color-71">${email_ln}: ${outlet_email}</p>`;
        }
        invoice_print+= `<!DOCTYPE html>
                            <html lang="en">
                            <head>
                                <meta charset="UTF-8">
                                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                <title>${data.sale_no}</title>
                                ${styleCSS}
                            </head>
                            <body>
                                <div id="wrapper" class="m-auto border-2s-e4e5ea br-5 p-30">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h3 class="pb-7 shop-name">${business_name}</h3>
                                            <h4 class="pb-7 common-heading">${outlet_name}</h4>
                                            <p class="pb-7 f-w-500 color-71">${outlet_address}</p>
                                            <p class="pb-7 f-w-500 color-71">${phone_ln}: ${outlet_phone}</p>
                                            ${outlet_email_html}
                                            ${collect_tax_string}
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="m-auto">
                                                ${invoice_logo}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center py-10">
                                        <h2 class="invoice-heading">${challan_ln}</h2>
                                    </div>
                                    <div>
                                        <p class="pb-7 color-71"><span class="f-w-600">${bill_to_ln}:</span> ${data.customer_name}</p>
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <p class="pb-7 color-71 ${(data.customer_phone_number == '' || data.customer_phone_number == 'null') ? 'd-none' : ''}"><span class="f-w-600">${phone_ln}:</span> ${data.customer_phone_number}</p>
                                            </div>
                                            <div class="text-rigth">
                                                <p class="pb-7"><span class="f-w-600">${invoice_no_ln}:</span> 
                                                ${data.sale_no}</p>
                                                <p class="pb-7 f-w-500 color-71"><span class="f-w-600">${date_ln}:</span> ${parsedData.sale_date}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <table class="table w-100 mt-20">
                                            <thead class="br-3 bg-00c53">
                                                <tr>
                                                    <th class="w-5 ps-5">${sn_ln}</th>
                                                    <th class="w-30">${item_ln} - ${code_ln} - ${brand_ln}</th>
                                                    <th class="w-20">${unit_price_ln}</th>
                                                    <th class="w-10">${qty_ln}</th>
                                                    <th class="w-15">${discount_ln}</th>
                                                    <th class="w-20 text-right pr-10">${total_ln}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            ${items_html}
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    
                                    <div class="d-flex justify-content-end mt-80">
                                        <div>
                                            <p class="color-71 d-inline b-t-1p-e4e5ea pt-10">${authorized_signature_ln}</p>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-center pt-30">
                                        <button onclick="window.print();" type="button" class="print-btn">Print</button>
                                    </div>
                                </div>
                                <script src="${base_url}assets/bower_components/jquery/dist/jquery.min.js"></script>
                                <script src="${base_url}frequent_changing/js/onload_print.js"></script>
                            </body>
                        </html>`;
            let popup = window.open("", "popup","width=100","height=600");
            popup.document.write(invoice_print);
            popup.document.close();
            popup.focus();
        
        
    }


    
    // ############ Index DB ############
    $(document).on('click', '.online_sync', function(){
        if(is_offline_system == '1'){
            offlineSalePushIntoServer();
            offlineHoldSalePushIntoServer();
        }else{
            toastr["warning"]("You are offline, this option will not work at the moment.", "Warning"); 
        }
    });
    function offlineSalePushIntoServer() {
        if(is_offline_system == '1'){
            const request = indexedDB.open("off_pos", 2);
            request.onsuccess = function(event) {
                const db = event.target.result;
                // Create a transaction on the 'sales' object store
                const transaction = db.transaction(["sales"], "readonly");
                const objectStore = transaction.objectStore("sales");
                // Use getAll to fetch all records
                const getAllRequest = objectStore.getAll();
                getAllRequest.onsuccess = function(event) {
                    const allRecords = event.target.result; // Contains all the records in 'sales' store
                    if (allRecords.length > 0) {
                        let completedRequests = 0; // To track completed AJAX requests
                        const totalRequests = allRecords.length;
                        allRecords.forEach(record => {
                            $.ajax({
                                type: "POST",
                                url: base_url + "Sale/add_sale_by_ajax",
                                data: record,
                                async: false,
                                success: function(response) {
                                    completedRequests++;
                                    // If all AJAX requests are done, clear the 'sales' object store
                                    if (completedRequests === totalRequests) {
                                        clearSalesData(db);
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.log("Error sending AJAX request:", error);
                                }
                            });
                        });
                    }
                };
                getAllRequest.onerror = function(event) {
                    console.log("Error fetching records:", event);
                };
            };
            request.onerror = function(event) {
                console.log("Error opening database:", event);
            };
        } else {
            toastr['error'](('Internet connection is not stable!'), 'Error');
        }
        
    }
    function offlineHoldSalePushIntoServer(){
        if(is_offline_system == '1'){
            const request = indexedDB.open("off_pos_3", 3);
            request.onsuccess = function(event) {
                const db = event.target.result;
                // Create a transaction on the 'sales' object store
                const transaction = db.transaction(["draft_sales"], "readonly");
                const objectStore = transaction.objectStore("draft_sales");
                // Use getAll to fetch all records
                const getAllRequest = objectStore.getAll();
                getAllRequest.onsuccess = function(event) {
                    const allRecords = event.target.result; // Contains all the records in 'sales' store
                    if (allRecords.length > 0) {
                        let completedRequests = 0; // To track completed AJAX requests
                        const totalRequests = allRecords.length;
                        allRecords.forEach(record => {
                            $.ajax({
                                url: base_url + "Sale/add_hold_by_ajax",
                                method: "POST",
                                data: {
                                    order: JSON.stringify(record.order),
                                    hold_number: '',
                                    csrf_offpos: '', 
                                },
                                dataType: 'json',
                                async: false,
                                success: function(response) {
                                    completedRequests++;
                                    // If all AJAX requests are done, clear the 'sales' object store
                                    if (completedRequests === totalRequests) {
                                        clearHoldSalesData(db);
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.error("Error sending AJAX request:", error);
                                    console.log("XHR status:", status);
                                    console.log("XHR response text:", xhr.responseText);
                                }
                            });
                        });
                    }
                };
                getAllRequest.onerror = function(event) {
                    console.log("Error fetching records:", event);
                };
            };
            request.onerror = function(event) {
                console.log("Error opening database:", event);
            };
        } else {
            toastr['error'](('Internet connection is not stable!'), 'Error');
        }
    }

    function clearSalesData(db) {
        const transaction = db.transaction(["sales"], "readwrite");
        const objectStore = transaction.objectStore("sales");
        // Clear all records in the 'sales' object store
        const clearRequest = objectStore.clear();
        clearRequest.onsuccess = function(event) {
            console.log("All sales data deleted successfully.");
        };
        clearRequest.onerror = function(event) {
            console.log("Error clearing sales data:", event);
        };
    }
    function clearHoldSalesData(db) {
        const transaction = db.transaction(["draft_sales"], "readwrite");
        const objectStore = transaction.objectStore("draft_sales");
        // Clear all records in the 'draft_sales' object store
        const clearRequest = objectStore.clear();
        clearRequest.onsuccess = function(event) {
            console.log("All draft sales data deleted successfully.");
        };
        clearRequest.onerror = function(event) {
            console.log("Error clearing draft sales data:", event);
        };
    }

    function setItemStockInIndexDB(){
        clearItemData();
        $.ajax({
            type: "POST",
            url: base_url+"Sale/setItemStockInIndexDB",
            dataType: "json",
            success: function (response) {
                let db;
                const request = indexedDB.open("off_pos_2", 2);  // Changed from 1 to 2
                request.onupgradeneeded = function(event) {
                    db = event.target.result;  // Use 'db' consistently
                    if (!db.objectStoreNames.contains("items")) {  // Check if store already exists
                        db.createObjectStore("items", { keyPath: "id", autoIncrement: true }); 
                        console.log("Object store 'items' created");
                    }
                };
                request.onsuccess = function(event) {
                    db = event.target.result;
                    // Now that the database is opened, create a transaction and add data
                    const transaction = db.transaction(["items"], "readwrite");
                    const objectStore = transaction.objectStore("items");  
                    let item_prepare = [];
                    let singleItem;

                    let allimeiArray;
                    let allimeiObjects;

                    let allexpiryArray;
                    let allexpiryObjects;

                    let allVariationArray;
                    let product = '';
                    
                    $.each(response.data, function (ind, val) {
                        let variationProducts = [];
                        if(val.allimei){
                            allimeiArray = val.allimei.split('||');
                            allimeiObjects = allimeiArray.map(function(imei_serial) {
                                return { single_imei_serial: imei_serial };
                            });
                        }
                        if(val.allexpiry){
                            allexpiryArray = val.allexpiry.split('||');
                            allexpiryObjects = allexpiryArray.map(function(expiry) {
                                let [date, stock] = expiry.split('|');  
                                return { [date]: parseInt(stock) };
                            });
                        }
                        if(val.variations){
                            // Step 1: Split the data by '||' to get each product variation
                            allVariationArray = val.variations.split('||');
                            // Step 3: Map over each variation to create the product objects
                            allVariationArray.forEach(function(variation) {
                                // Split the variation by '|' to get the individual pieces of data
                                let productArray = variation.split('|');
                                // Create a product object with the key-value pairs
                                product = {
                                    vId: productArray[0],            // Product id 
                                    name: productArray[1],            // Product name 
                                    code: productArray[2],            // Product code 
                                    lowStock: productArray[3],        // Low stock 
                                    lastThreePAvg: productArray[4],   // Last Three Purchase Avg
                                    stock_in: productArray[5],        // Current Stock
                                    stock_out: productArray[6]        // Stock Out
                                };
                                // Add the product object to the variationProducts array
                                variationProducts.push(product);
                            });
                        }
                        singleItem = {
                            id: val.id,
                            name: val.name,
                            type: val.type,
                            code: val.code,
                            expiry_date_maintain: val.expiry_date_maintain,
                            conversion_rate: val.conversion_rate,
                            sale_unit: val.sale_unit,
                            allimei: allimeiObjects,
                            stock_qty: val.stock_qty,
                            out_qty: val.out_qty,
                            variations: variationProducts,
                            sale_unit: val.sale_unit,
                            allexpiry: allexpiryObjects,
                            parent_id: val.parent_id,
                        }
                        item_prepare.push(singleItem);
                    });
                    // Add the data to the 'sales' object store
                    const requestAdd = objectStore.add(item_prepare);
                    requestAdd.onsuccess = function(event) {
                        console.log("Data added to 'items' successfully");
                    };
                    requestAdd.onerror = function(event) {
                        console.log("Error adding items data ':", event);
                    };
                };
                request.onerror = function(event) {
                    console.log("Error opening database:", event);
                };
            }
        });
    }

    setTimeout(function() {
        setItemStockInIndexDB();
    }, 700);

    function clearItemData() {
        const request = indexedDB.open("off_pos_2", 2);
        request.onsuccess = function(event) {
            const db = event.target.result;
            // Create a transaction with 'readwrite' access
            const transaction = db.transaction(["items"], "readwrite");
            const objectStore = transaction.objectStore("items");
            // Clear all records in the 'items' object store
            const clearRequest = objectStore.clear();
            clearRequest.onsuccess = function(event) {
                console.log("All items data deleted successfully.");
            };
            clearRequest.onerror = function(event) {
                console.log("Error clearing items data:", event);
            };
        };
        request.onerror = function(event) {
            console.log("Error opening database:", event);
        };
    }



    function createOrOpenIndexedDB() {
        const databases = [
            { name: 'off_pos', version: 1, objectStore: 'sales' },
            { name: 'off_pos_2', version: 2, objectStore: 'items' }, 
            { name: 'off_pos_3', version: 3, objectStore: 'draft_sales' }
        ];
        databases.forEach(db => {
            const request = indexedDB.open(db.name, db.version);
            request.onerror = function(event) {
                console.error(`Error opening database ${db.name}:`, event.target.error);
            };
            request.onsuccess = function(event) {
                console.log(`Database ${db.name} opened successfully`);
            };
            request.onupgradeneeded = function(event) {
                const database = event.target.result;
                if (!database.objectStoreNames.contains(db.objectStore)) {
                    database.createObjectStore(db.objectStore, { keyPath: 'id', autoIncrement: true });
                    console.log(`Object store ${db.objectStore} created in ${db.name}`);
                }
            };
        });
    }
    // Call the function to create or open the databases
    createOrOpenIndexedDB();
    // ############ Index DB ############




    // Code optimize by Azhar ** Final **
    $(document).on('click', '#cancel_set_qty_alert_sms_setting', function () {
        $('#show_qty_sms_setting_modal').slideUp('500');
    });

    // Code optimize by Azhar ** Final **
    function getAllCustomers(customer_id='',customer_previous_due_modal='',if_ignore){
        $.ajax({
            url: base_url + "Sale/getAllCustomers",
            method: "GET",
            success: function (response) {
                let option_customers = '';
                option_customers += `<option value="">${select} ${customer}</option>`;
                $.each(response.data, function (i, v) { 
                    option_customers += `<option id="cid_${v.id}" data-same_or_diff_state="${v.same_or_diff_state}" discount="${v.discount}" price_type="${v.price_type}" data-previous_due="${v.opening_balance}" data-phone_number="${v.phone}"  value="${v.id}" data-customer-name="${v.name}" ${v.id == edit_sale_customer ? 'selected' : ''} > ${v.name} ${v.phone != null ? '(' + v.phone + ')' : ''}</option>`;
                });
                $('#walk_in_customer').html(option_customers);
                if(edit_sale_customer){ 
                    if(customer_id && (customer_id == edit_sale_customer)){
                        $('#walk_in_customer').val(edit_sale_customer).change();
                    }else{
                        $('#walk_in_customer').val(customer_id).change();
                    }
                }else{
                    $('#walk_in_customer').val(customer_id).change();
                }
                $('.loader1').slideUp('500');
                if(!if_ignore){
                    $("#add_customer_modal").removeClass("active");
                    $('.pos__modal__overlay').fadeOut(300);
                }
                resetAddCustomerModalAfterAddOrClose();
            }
        });
    }
    if(edit_mode == ''){
        getAllCustomers(default_customer, 0, '');
    }else{
        getAllCustomers(edit_sale_customer, 0, '');
    }


    

    // Code optimize by Azhar ** Final **
    function IsEmail(email) {
        let regex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
        return regex.test(email);
    }

    // Code optimize by Azhar ** Final **
    $(document).on("click", "#add_customer", function(e) {
        $.ajax({
            url: base_url + "Master/checkAccess",
            method: "GET",
            async: false,
            dataType: 'json',
            data: { controller: "147", function: "add" },
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
                    let customer_id = $('#customer_id_modal').val();
                    let customer_name = $('#customer_name_modal').val();
                    let customer_phone = $('#customer_phone_modal').val();
                    let nid = $('#customer_nid_modal').val();
                    let customer_email = $('#customer_email_modal').val();
                    let customer_group_id = $('#customer_group_id_modal').val();
                    let customer_dob = $('#customer_dob_modal').val();
                    let customer_doa = $('#customer_doa_modal').val();
                    let opening_balance = $('#customer_previous_due_modal').val();
                    let opening_balance_type = $('#opening_balance_type').val();
                    let customer_credit_limit_modal = $('#customer_credit_limit_modal').val();
                    let customer_delivery_address = $('#customer_delivery_address_modal').val();
                    let same_or_diff_state = Number($(".same_or_diff_state_modal").val());
                    let customer_gst_number = $('#customer_gst_number_modal').val();
                    let customer_discount_modal = $('#customer_discount_modal').val();
                    let customer_price_type = $('#customer_price_type').val();
                    let error = 0;
                    if (customer_name == "") {
                        $("#name_err_msg").text('The Name field is require');
                        $(".name_err_msg_contnr").show(200).delay(6000).hide(200, function () {});
                        error = 1;
                    }
                    if (customer_phone == "") {
                        $("#phone_err_msg").text('The Phone field is require');
                        $(".phone_err_msg_contnr").show(200).delay(6000).hide(200, function () {});
                        error = 1;
                    }
                    if(customer_email != '' && !IsEmail(customer_email)){
                        $("#email_err_msg").text('The Email should be valid email');
                        $(".email_err_msg_contnr").show(200).delay(6000).hide(200, function () {});
                        error = 1;
                    }
                    if(collect_gst=="Yes"){
                        if (same_or_diff_state == "") {
                            $("#state_err_msg").text('The State field is require');
                            $(".state_err_msg_contnr").show(200).delay(6000).hide(200, function () {});
                            error = 1;
                        }
                        if (customer_gst_number == "") {
                            $("#gst_err_msg").text('The GST field is require');
                            $(".gst_err_msg_conter").show(200).delay(6000).hide(200, function () {});
                            error = 1;
                        }
                    }
                    if (error != 0) {
                        return false;
                    }
                    if(error == 0){
                        $.ajax({
                            url: base_url + "Sale/add_customer_by_ajax",
                            method: "POST",
                            data: {
                                customer_id: customer_id,
                                customer_name: customer_name,
                                nid: nid,
                                customer_phone: customer_phone,
                                customer_email: customer_email,
                                customer_dob: customer_dob,
                                customer_doa: customer_doa,
                                customer_delivery_address: customer_delivery_address,
                                customer_gst_number: customer_gst_number,
                                opening_balance: opening_balance,
                                opening_balance_type: opening_balance_type,
                                credit_limit: customer_credit_limit_modal,
                                same_or_diff_state: same_or_diff_state,
                                group_id: customer_group_id,
                                customer_discount: customer_discount_modal,
                                customer_price_type: customer_price_type,
                                csrf_offpos: csrf_value_
                            },
                            success: function (response) {
                                if(response.status == 'success'){
                                    getAllCustomers(Number(response.customer_id), opening_balance, '');
                                    customerModalFieldRest();
                                    $('.loader1').slideUp('500');
                                }else if(response.status == 'error'){
                                    $.each(response.errors, function (ind, val) { 
                                        if(ind == 'phone' && val != ''){
                                            $("#phone_err_msg").html(`${val}`);
                                            $(".phone_err_msg_contnr").show(200).delay(6000).hide(200, function () {});
                                        }else if(ind == 'email' && val != ''){
                                            $("#email_err_msg").html(`${val}`);
                                            $(".email_err_msg_contnr").show(200).delay(6000).hide(200, function () {});
                                        }
                                    });
                                }
                            }
                        });
                    }
                }
            }
        });
    });


    // Code optimize by Azhar ** Final **
    function customerModalFieldRest(){
        $(".name_err_msg_contnr").hide(200, function () {});
        $(".phone_err_msg_contnr").hide(200, function () {});
        $(".email_err_msg_contnr").hide(200, function () {});
        $(".state_err_msg_contnr").hide(200, function () {});
        $(".gst_err_msg_contnr").hide(200, function () {});
    }


    // Code optimize by Azhar ** Final **
    function checkTaxApply(tax){
        let return_status = true;
        let same_or_diff_state = $('#walk_in_customer').find(":selected").attr('data-same_or_diff_state');
        if(same_or_diff_state==1){
            if(tax=="CGST" || tax=="SGST"){
                return_status = true;
            }else{
                if(tax=="IGST"){
                    return_status = false;
                }else{
                    return_status = true;
                }
            }
        }else if(same_or_diff_state==2){
            if(tax=="IGST"){
                return_status = true;
            }else{
                if(tax=="CGST" || tax=="SGST"){
                    return_status = false;
                }else{
                    return_status = true;
                }
            }
        }
        if(tax_is_gst=="No"){
            if(tax=="CGST" || tax=="SGST" || tax=="IGST"){
                return_status = false;
            }
        }
        return return_status;
    }


    // Code optimize by Azhar ** Final **
    $(document).on('click', '.icon_pick_date', function () {
        $('.search_sale').show().focus().hide();
    });


    //update all price of modal
    function updateCartItemPrice() {
        $('#item_quantity_modal').html($('#item_quantity_modal_input').val());
        let item_quantity = (parseFloat($('#item_quantity_modal').html()) > parseFloat(0)) ? parseFloat($('#item_quantity_modal').html()).toFixed(op_precision) : parseFloat(0).toFixed(op_precision);
        let item_unit_price = parseFloat($('#modal_item_price_input_field').val()).toFixed(op_precision);
        if (item_unit_price == '' || item_unit_price == "NaN") {
            item_unit_price = 0;
        }
        //get item total price without discount
        let item_total_price_without_discount = (parseFloat(item_quantity) * parseFloat(item_unit_price)).toFixed(op_precision);
        //set item total price without discount
        $('#modal_item_price_variable_without_discount').html(item_total_price_without_discount);
        //get discount from modal
        let discount_on_modal = $('#modal_discount').val();
        discount_on_modal = (discount_on_modal != "") ? discount_on_modal : 0;
        //remove last digits if number is more than 2 digits after decimal
        removeLastTwoDigitWithPercentage(discount_on_modal, $('#modal_discount'));
        //get discount actual amount on item price
        let actual_modal_discount_amount = getParticularItemDiscountAmount(discount_on_modal, item_total_price_without_discount);
        //set blank if discount amount is more than item total price without discount
        // if (parseFloat(actual_modal_discount_amount) > parseFloat(item_total_price_without_discount)) {
        //     $('#modal_discount').val('');
        //     actual_modal_discount_amount = parseFloat(0).toFixed(op_precision);
        // }
        //set actual discount amouto hidden modal element
        $('#modal_discount_amount').html(parseFloat(actual_modal_discount_amount).toFixed(op_precision));
        //get item price after discount
        let item_price_after_discount = (parseFloat(item_total_price_without_discount) - parseFloat(actual_modal_discount_amount)).toFixed(op_precision);
        //set item total price with discount
        $('#modal_item_price_variable').html(item_price_after_discount);
        //add items and modifiers price
        let all_price = parseFloat(item_price_after_discount).toFixed(op_precision);
        //show to all total
        $('#modal_total_price').html(all_price);
    }


    // Code optimize by Azhar ** Final **
    function showAllItems(brand_id='',sorting='') {
        $('.specific_category_items_holder').hide();
        // setTimeout(function () {
        let foundItems = searchItemAndConstructGallery('',sorting,'');
        let searched_category_items_to_show = `<div id="searched_item_found" class="specific_category_items_holder"><div class="single-inner-div ${grocery_experience == 'Medicine' || grocery_experience == 'Grocery' ? 'grocery_single_on' : 'grocery_single_off'}">`;
        if(grocery_experience == 'Medicine' || grocery_experience == 'Grocery'){
            let brand_id_tmp = Number(brand_id);
            for (let key in foundItems) {
                if(foundItems[key].item_type != '0'){
                    let tax_information = (IsJsonString(foundItems[key].tax_information)) ? JSON.parse(foundItems[key].tax_information) : '';
                    if (foundItems.hasOwnProperty(key)) {
                        if (brand_id_tmp) {
                            if (brand_id_tmp == foundItems[key].brand_id) {
                                searched_category_items_to_show += `
                                    <div item-type="${foundItems[key].item_type}" expiry_date_maintain="${foundItems[key].expiry_date_maintain}" plain-id="${foundItems[key].item_id}" data-last_purchase_price="${foundItems[key].last_purchase_price}" data-whole_sale_price="${foundItems[key].whole_sale_price}" data-sale_price="${foundItems[key].price}" is_promo="${foundItems[key].is_promo}" class="single_item grocery_medicine_el   all_brand brand_${foundItems[key].brand_id} ${product_display == 'Image View' ? '' : 'bg-box-view'} d-flex align-items-center" id="item_${foundItems[key].item_id}">
                                        <p class="item_name mt-0" data-tippy-content="${foundItems[key].item_name}(${foundItems[key].item_code})">
                                            ${limitWords(foundItems[key].item_name, 3)} (${foundItems[key].item_code}) 
                                            
                                            ${grocery_experience != 'Medicine' ? (limitWords(foundItems[key].brand_name, 3)) : (limitWords(foundItems[key].supplier_name, 3))} 
                                            
                                            ${foundItems[key].generic_name ? '<br> <small class="generic_small">Generic Name: '+limitWords(foundItems[key].generic_name, 2)+'</small>' : ''}
                                        </p>
                                        <p class="d-none generic_name generic_name_gm ${$.trim(foundItems[key].generic_name) ? '' : 'd-none'}" data-tippy-content="${$.trim(foundItems[key].generic_name) ? $.trim(foundItems[key].generic_name) : ''}">Generic Name: ${$.trim(foundItems[key].generic_name) ? $.trim(foundItems[key].generic_name) : ''}</p>
                                        <p class="item_price item_price_gm">
                                            Sale Price: <span id="price_${foundItems[key].item_id}">${parseFloat(foundItems[key].price).toFixed(op_precision)}</span><br>
                                            <span>${ (foundItems[key].rack_name == '' || foundItems[key].rack_name == 'null' || foundItems[key].rack_name == null || foundItems[key].rack_name == 'NULL') ?  '' : 'Rack No :'+foundItems[key].rack_name}</span> 
                                        </p>
                                        <span class="item_vat_percentage d-none">${JSON.stringify(tax_information)}</span>
                                    </div>`;
                            }
                        } else {
                            searched_category_items_to_show += `
                                <div item-type="${foundItems[key].item_type}" expiry_date_maintain="${foundItems[key].expiry_date_maintain}" plain-id="${foundItems[key].item_id}" data-last_purchase_price="${foundItems[key].last_purchase_price}" is_promo="${foundItems[key].is_promo}" data-whole_sale_price="${foundItems[key].whole_sale_price}" data-sale_price="${foundItems[key].price}" class="single_item grocery_medicine_el   all_brand brand_${foundItems[key].brand_id} ${product_display == 'Image View' ? '' : 'bg-box-view'} d-flex align-items-center" id="item_${foundItems[key].item_id}">
                                    <p class="item_name mt-0" data-tippy-content="${foundItems[key].item_name}(${foundItems[key].item_code})">
                                        ${limitWords(foundItems[key].item_name, 3)} (${foundItems[key].item_code}) 

                                        ${grocery_experience != 'Medicine' ? (limitWords(foundItems[key].brand_name, 3)) : (limitWords(foundItems[key].supplier_name, 3))} 
                                        
                                        ${foundItems[key].generic_name ? '<br> <small class="generic_small">Generic Name: '+limitWords(foundItems[key].generic_name, 2)+'</small>' : ''}
                                    </p>
                                    <p class="d-none generic_name generic_name_gm ${$.trim(foundItems[key].generic_name) ? '' : 'd-none'}" data-tippy-content="${$.trim(foundItems[key].generic_name) ? $.trim(foundItems[key].generic_name) : ''}">Generic Name: ${$.trim(foundItems[key].generic_name) ? $.trim(foundItems[key].generic_name) : ''}</p>
                                    <p class="item_price item_price_gm">
                                        Sale Price: <span id="price_${foundItems[key].item_id}">${parseFloat(foundItems[key].price).toFixed(op_precision)}</span><br>
                                        <span>${ (foundItems[key].rack_name == '' || foundItems[key].rack_name == 'null' || foundItems[key].rack_name == null || foundItems[key].rack_name == 'NULL') ?  '' : 'Rack No :'+foundItems[key].rack_name}</span> 
                                    </p>
                                    <span class="item_vat_percentage d-none">${JSON.stringify(tax_information)}</span>
                                </div>`;
                        }
                    }
                }
            }
        }else{
            let brand_id_tmp = Number(brand_id);
            for (let key in foundItems) {
                if(foundItems[key].item_type != '0'){
                    let tax_information = (IsJsonString(foundItems[key].tax_information)) ? JSON.parse(foundItems[key].tax_information) : '';
                    if (foundItems.hasOwnProperty(key)) {
                        if (brand_id_tmp) {
                            if (brand_id_tmp == foundItems[key].brand_id) {
                                searched_category_items_to_show += `
                                    <div item-type="${foundItems[key].item_type}" expiry_date_maintain="${foundItems[key].expiry_date_maintain}" plain-id="${foundItems[key].item_id}" data-last_purchase_price="${foundItems[key].last_purchase_price}" data-whole_sale_price="${foundItems[key].whole_sale_price}" data-sale_price="${foundItems[key].price}" is_promo="${foundItems[key].is_promo}" class="single_item  all_brand brand_${foundItems[key].brand_id} ${product_display == 'Image View' ? '' : 'bg-box-view'}" id="item_${foundItems[key].item_id}">
                                        <div class="single-item-img">
                                            <img src="${foundItems[key].image}" alt="" class="${product_display == 'Image View' ? 'd-block' : 'd-none'}">
                                        </div>
                                        <p class="item_name" data-tippy-content="${foundItems[key].item_name}(${foundItems[key].item_code})">${foundItems[key].item_name}${foundItems[key].brand_name} (${foundItems[key].item_code})</p>
                                        <p class="generic_name ${$.trim(foundItems[key].generic_name) ? '' : 'd-none'}" data-tippy-content="${$.trim(foundItems[key].generic_name) ? $.trim(foundItems[key].generic_name) : ''}">${$.trim(foundItems[key].generic_name) ? $.trim(foundItems[key].generic_name) : ''}</p>
                                        <p class="item_price">SP: <span id="price_${foundItems[key].item_id}">${parseFloat(foundItems[key].price).toFixed(op_precision)}</span></p>
                                        <span class="item_vat_percentage d-none">${JSON.stringify(tax_information)}</span>
                                    </div>`;
                            }
                        } else {
                            searched_category_items_to_show += `
                                <div item-type="${foundItems[key].item_type}" expiry_date_maintain="${foundItems[key].expiry_date_maintain}" plain-id="${foundItems[key].item_id}" data-last_purchase_price="${foundItems[key].last_purchase_price}" is_promo="${foundItems[key].is_promo}" data-whole_sale_price="${foundItems[key].whole_sale_price}" data-sale_price="${foundItems[key].price}" class="single_item  all_brand brand_${foundItems[key].brand_id} ${product_display == 'Image View' ? '' : 'bg-box-view'}" id="item_${foundItems[key].item_id}">
                                    <div class="single-item-img">
                                        <img src="${foundItems[key].image}" alt="" class="${product_display == 'Image View' ? 'd-block' : 'd-none'}">
                                    </div>
                                    <p class="item_name" data-tippy-content="${foundItems[key].item_name}(${foundItems[key].item_code})">${foundItems[key].item_name}${foundItems[key].brand_name} (${foundItems[key].item_code})</p>
                                    <p class="generic_name ${$.trim(foundItems[key].generic_name) ? '' : 'd-none'}" data-tippy-content="${$.trim(foundItems[key].generic_name) ? $.trim(foundItems[key].generic_name) : ''}">${$.trim(foundItems[key].generic_name) ? $.trim(foundItems[key].generic_name) : ''}</p>
                                    <p class="item_price">SP: <span id="price_${foundItems[key].item_id}">${parseFloat(foundItems[key].price).toFixed(op_precision)}</span></p>
                                    <span class="item_vat_percentage d-none">${JSON.stringify(tax_information)}</span>
                                </div>`;
                        }
                    }
                }
            }
        }
        searched_category_items_to_show += `<div></div>`;
        $("#searched_item_found").remove();
        $('.specific_category_items_holder').hide('1000');
        $(".category_items").prepend(searched_category_items_to_show);
        // }, 1000);
    }
    //initialize item list
    // showAllItems('','');

    $(document).on('click', '.sorting_item', function(){
        let sort_id = $(this).attr('data-sort_id');
        let sort_title = $(this).text();
        $('.sorting_item_title').text(sort_title);
        $(this).addClass('sort_active');
        $('.sorting_item').removeClass('sort_active');
        $("#search").val('');
        $('#alternative_item_render').html(`<h6>${Alternative_Medicine_will_shown_here} <iconify-icon icon="solar:smile-circle-broken"></iconify-icon></h6>`);
        showAllItems('',sort_id);
    });

    // Code optimize by Azhar ** Final **
    function showAllItemByCategory(cat_id='') {
        $('.specific_category_items_holder').hide();
        setTimeout(function () {
            let foundItems = searchItemAndConstructGallery('','','');
            let searched_category_items_to_show = `<div id="searched_item_found" class="specific_category_items_holder d-block"><div class="single-inner-div ${grocery_experience == 'Medicine' || grocery_experience == 'Grocery' ? 'grocery_single_on' : 'grocery_single_off'}">`;
            if(grocery_experience == 'Medicine' || grocery_experience == 'Grocery'){
                let cat_id_tmp = Number(cat_id);
                for (let key in foundItems) {
                    if(foundItems[key].item_type != '0'){
                        if (foundItems.hasOwnProperty(key)) {
                            if (cat_id_tmp) {
                                if (cat_id_tmp == foundItems[key].cat_id) {
                                    searched_category_items_to_show += `
                                        <div is_promo="${foundItems[key].is_promo}" item-type="${foundItems[key].item_type}" expiry_date_maintain="${foundItems[key].expiry_date_maintain}" plain-id="${foundItems[key].item_id}" data-last_purchase_price="${foundItems[key].last_purchase_price}" data-whole_sale_price="${foundItems[key].whole_sale_price}" data-sale_price="${foundItems[key].price}" class="single_item grocery_medicine_el   all_brand brand_${foundItems[key].cat_id} ${product_display == 'Image View' ? '' : 'bg-box-view'} d-flex align-items-center" id="item_${foundItems[key].item_id}">
                                            <p class="item_name mt-0" data-tippy-content="${foundItems[key].item_name}(${foundItems[key].item_code})">
                                                ${limitWords(foundItems[key].item_name, 3)} (${foundItems[key].item_code}) 

                                                ${grocery_experience != 'Medicine' ? (limitWords(foundItems[key].brand_name, 3)) : (limitWords(foundItems[key].supplier_name, 3))} 

                                                ${foundItems[key].generic_name ? '<br> <small class="generic_small">Generic Name: '+ limitWords(foundItems[key].generic_name, 2)+'</small>' : ''}

                                            </p>
                                            <p class="d-none generic_name generic_name_gm ${$.trim(foundItems[key].generic_name) ? '' : 'd-none'}" data-tippy-content="${$.trim(foundItems[key].generic_name) ? $.trim(foundItems[key].generic_name) : ''}">Generic Name: ${$.trim(foundItems[key].generic_name) ? $.trim(foundItems[key].generic_name) : ''}</p>
                                            <p class="item_price item_price_gm">
                                                Sale Price: <span id="price_${foundItems[key].item_id}">${parseFloat(foundItems[key].price).toFixed(op_precision)}</span><br>
                                                <span>${ (foundItems[key].rack_name == '' || foundItems[key].rack_name == 'null' || foundItems[key].rack_name == null || foundItems[key].rack_name == 'NULL') ?  '' : 'Rack No :'+foundItems[key].rack_name}</span> 
                                            </p>
                                            <span class="item_vat_percentage d-none">${foundItems[key].vat_percentage}</span>
                                        </div>`;
                                }
                            } else {
                                searched_category_items_to_show += `
                                    <div is_promo="${foundItems[key].is_promo}" item-type="${foundItems[key].item_type}" expiry_date_maintain="${foundItems[key].expiry_date_maintain}" plain-id="${foundItems[key].item_id}" data-last_purchase_price="${foundItems[key].last_purchase_price}" data-whole_sale_price="${foundItems[key].whole_sale_price}" data-sale_price="${foundItems[key].price}" class="single_item grocery_medicine_el   all_brand brand_${foundItems[key].cat_id} ${product_display == 'Image View' ? '' : 'bg-box-view'} d-flex align-items-center" id="item_${foundItems[key].item_id}">
                                        <p class="item_name mt-0" data-tippy-content="${foundItems[key].item_name}(${foundItems[key].item_code})">
                                            ${limitWords(foundItems[key].item_name, 3)} (${foundItems[key].item_code}) 
                
                                            ${grocery_experience != 'Medicine' ? (limitWords(foundItems[key].brand_name, 3)) : (limitWords(foundItems[key].supplier_name, 3))} 

                                            ${foundItems[key].generic_name ? '<br> <small class="generic_small">Generic Name: '+limitWords(foundItems[key].generic_name, 2)+'</small>' : ''}
                                        </p>
                                        <p class="d-none generic_name generic_name_gm ${$.trim(foundItems[key].generic_name) ? '' : 'd-none'}" data-tippy-content="${$.trim(foundItems[key].generic_name) ? $.trim(foundItems[key].generic_name) : ''}">Generic Name: ${$.trim(foundItems[key].generic_name) ? $.trim(foundItems[key].generic_name) : ''}</p>
                                        <p class="item_price item_price_gm">
                                            Sale Price: <span id="price_${foundItems[key].item_id}">${parseFloat(foundItems[key].price).toFixed(op_precision)}</span><br>
                                            <span>${ (foundItems[key].rack_name == '' || foundItems[key].rack_name == 'null' || foundItems[key].rack_name == null || foundItems[key].rack_name == 'NULL') ?  '' : 'Rack No :'+foundItems[key].rack_name}</span> 
                                        </p>
                                        <span class="item_vat_percentage d-none">${foundItems[key].vat_percentage}</span>
                                    </div>`;
                            } 
                        }
                    }
                }
            }else{
                let cat_id_tmp = Number(cat_id);
                for (let key in foundItems) {
                    if(foundItems[key].item_type != '0'){
                        if (foundItems.hasOwnProperty(key)) {
                            if (cat_id_tmp) {
                                if (cat_id_tmp == foundItems[key].cat_id) {
                                    searched_category_items_to_show += `
                                        <div is_promo="${foundItems[key].is_promo}" item-type="${foundItems[key].item_type}" expiry_date_maintain="${foundItems[key].expiry_date_maintain}" plain-id="${foundItems[key].item_id}" data-last_purchase_price="${foundItems[key].last_purchase_price}" data-whole_sale_price="${foundItems[key].whole_sale_price}" data-sale_price="${foundItems[key].price}" class="single_item  all_brand brand_${foundItems[key].cat_id} ${product_display == 'Image View' ? '' : 'bg-box-view'}" id="item_${foundItems[key].item_id}">
                                            <div class="single-item-img">
                                                <img src="${foundItems[key].image}" alt="" class="${product_display == 'Image View' ? 'd-block' : 'd-none'}">
                                            </div>
                                            <p class="item_name" data-tippy-content="${foundItems[key].item_name}(${foundItems[key].item_code})">${foundItems[key].item_name}${foundItems[key].brand_name} (${foundItems[key].item_code})</p>
                                            <p class="generic_name ${$.trim(foundItems[key].generic_name) ? '' : 'd-none'}" data-tippy-content="${$.trim(foundItems[key].generic_name) ? $.trim(foundItems[key].generic_name) : ''}">${$.trim(foundItems[key].generic_name) ? $.trim(foundItems[key].generic_name) : ''}</p>
                                            <p class="item_price">SP: <span id="price_${foundItems[key].item_id}">${parseFloat(foundItems[key].price).toFixed(op_precision)}</span></p>
                                            <span class="item_vat_percentage d-none">${foundItems[key].vat_percentage}</span>
                                        </div>`;
                                }
                            } else {
                                searched_category_items_to_show += `
                                    <div is_promo="${foundItems[key].is_promo}" item-type="${foundItems[key].item_type}" expiry_date_maintain="${foundItems[key].expiry_date_maintain}" plain-id="${foundItems[key].item_id}" data-last_purchase_price="${foundItems[key].last_purchase_price}" data-whole_sale_price="${foundItems[key].whole_sale_price}" data-sale_price="${foundItems[key].price}" class="single_item  all_brand brand_${foundItems[key].cat_id} ${product_display == 'Image View' ? '' : 'bg-box-view'}" id="item_${foundItems[key].item_id}">
                                        <div class="single-item-img">
                                            <img src="${foundItems[key].image}" alt="" class="${product_display == 'Image View' ? 'd-block' : 'd-none'}">
                                        </div>
                                        <p class="item_name" data-tippy-content="${foundItems[key].item_name}(${foundItems[key].item_code})">${foundItems[key].item_name}${foundItems[key].brand_name} (${foundItems[key].item_code})</p>
                                        <p class="generic_name ${$.trim(foundItems[key].generic_name) ? '' : 'd-none'}" data-tippy-content="${$.trim(foundItems[key].generic_name) ? $.trim(foundItems[key].generic_name) : ''}">${$.trim(foundItems[key].generic_name) ? $.trim(foundItems[key].generic_name) : ''}</p>
                                        <p class="item_price">SP: <span id="price_${foundItems[key].item_id}">${parseFloat(foundItems[key].price).toFixed(op_precision)}</span></p>
                                        <span class="item_vat_percentage d-none">${foundItems[key].vat_percentage}</span>
                                    </div>`;
                            } 
                        }
                    }
                }
            }
            searched_category_items_to_show += `<div></div>`;
            $("#searched_item_found").remove();
            $('.specific_category_items_holder').hide('1000');
            $(".category_items").prepend(searched_category_items_to_show);
        }, 100);
    }

    // Code optimize by Azhar ** Final **
    $(document).on('click', '.promo_filter', function(){
        if(is_offline_system == '1'){
            $('#show_all_promo').addClass('active');
            $(".pos__modal__overlay").fadeIn(200);
            $.ajax({
                url: base_url + "get_prom_details",
                method: "POST",
                dataType:'json',
                success: function (response) {
                    $(".promo_modal_body").html(response);
                }
            });
        }
    });


    // Code optimize by Azhar ** Final **
    $(document).on("click", ".get_prom_details", function (e) {
        $("#show_modal_view_promo").addClass("active");
        $(".pos__modal__overlay").fadeIn(200);
        $.ajax({
            url: base_url + "get_prom_details",
            method: "POST",
            dataType:'json',
            success: function (response) {
                $("#body_promo_view").html(response);
            }
        });
    });

    function cartItemCalculationClear(){
        $('#discounted_sub_total_amount').html(Number(0).toFixed(op_precision));
        $('#sub_total_discount').val(Number(0));
        $('#sub_total_discount_amount').html(Number(0).toFixed(op_precision));
        $('#all_items_discount').html(Number(0).toFixed(op_precision));
        $('#delivery_charge').val(Number(0).toFixed(op_precision));
    }

    // add all prices of item and modifiers
    function cartItemCalculationInPOS() {
        let total_items_in_cart = $('.order_holder .single_order').length;
        //if there is no item in cart reset necessary field and value
        if (total_items_in_cart < 1) {
            cartItemCalculationClear();
        }
        // Set Hidden And Visiable Discount
        let this_item_original_price = 0;
        let item_discount_value = 0;
        let actual_discount_amount = 0;
        let discounted_item_price = 0;
        let this_item_discount_amount = 0;
        let total_discount_sum = 0;
        let all_item_total_price = 0;
        let total_items_in_cart_with_quantity = 0;

        let sub_total_sum = 0;
        $('.single_order .first_portion .fifth_column span').each(function (i, obj) {
            this_item_original_price = parseFloat($(this).parent().parent().find('.item_price_without_discount').text()).toFixed(op_precision);
            item_discount_value = $(this).parent().parent().find('.forth_column input').val();
            item_discount_value = (item_discount_value != "") ? item_discount_value : 0;
            actual_discount_amount = getParticularItemDiscountAmount(item_discount_value, this_item_original_price);
            $(this).parent().parent().find('.item_discount').text(actual_discount_amount);
            discounted_item_price = (parseFloat(this_item_original_price) - parseFloat(actual_discount_amount)).toFixed(op_precision);
            $(this).parent().parent().find('.fifth_column span').html(discounted_item_price);
            this_item_discount_amount = (parseFloat($(this).parent().parent().find('.item_discount').html())).toFixed(op_precision);
            total_discount_sum = (parseFloat(total_discount_sum) + parseFloat(this_item_discount_amount)).toFixed(op_precision);
            all_item_total_price = parseFloat($(this).text()).toFixed(op_precision);
            sub_total_sum += parseFloat(all_item_total_price);
            total_items_in_cart_with_quantity += parseFloat($(this).parent().parent().find('.third_column span').eq(0).text());
        });
        $('#total_item_discount').html(total_discount_sum);
        //set total items in cart to view
        $('#total_items_in_cart_without_quantity').html($(".edit_item").length);
        $('#total_items_in_cart_with_quantity').html(total_items_in_cart_with_quantity);
        //set sub total
        $('#sub_total').html(sub_total_sum);
        $('#sub_total_show').html(parseFloat(sub_total_sum).toFixed(op_precision));

        //get the value of the delivery charge amount
        let delivery_charge_amount = ($('#delivery_charge').val() != "") ? $('#delivery_charge').val() : 0;

        //check wether value is valid or not
        removeLastTwoDigitWithoutPercentage(delivery_charge_amount, $('#delivery_charge'));

        //get subtotal amount
        let sub_total_amount = sub_total_sum;

        //get subtotal discount amount
        let sub_total_discount_amount = ($('#sub_total_discount').val() != "") ? $('#sub_total_discount').val() : 0;
        //check wether value is valid or not
        removeLastTwoDigitWithPercentage(sub_total_discount_amount, $('#sub_total_discount'));
        sub_total_discount_amount = getSubTotalDiscountAmount(sub_total_discount_amount, sub_total_amount);

        //if sub total discount amount is greater than subtotal then make it blank
        if (parseFloat(sub_total_discount_amount) > parseFloat(sub_total_amount)) {
            $('#sub_total_discount').val('');
            cartItemCalculationInPOS();
            if(edit_mode == ''){
                storageCartDataInLocal();
            }
            return false;
        }
        //get total item discount amount
        let total_item_discount_amount = (parseFloat(total_discount_sum)).toFixed(op_precision);

        //get all discount of table
        let total_discount = (parseFloat(sub_total_discount_amount) + parseFloat(total_item_discount_amount)).toFixed(op_precision);
        
        //set sub total discount amount
        $('#sub_total_discount_amount').html(sub_total_discount_amount);

        //set sub total amount after discount in a hidden field
        let discounted_sub_total_amount = (parseFloat(sub_total_amount) - parseFloat(sub_total_discount_amount)).toFixed(op_precision);

        $('#discounted_sub_total_amount').html(discounted_sub_total_amount)

        let sub_total_discount_tmp = $("#sub_total_discount").val();
        
        if (sub_total_discount_tmp.indexOf('%') > 0) {
            sub_total_discount_tmp = getSubTotalDiscountAmount(sub_total_discount_tmp,sub_total_amount);
        } else {
            sub_total_discount_tmp = Number(sub_total_discount_tmp).toFixed(op_precision);
        }
         
        $("#show_discount_amount").html(sub_total_discount_tmp);
        //set total discount
        $('#all_items_discount').html(total_discount);
        //get vat amount
        let vat_amount = collect_tax == "Yes" ? getTotalVat() : null;
        let total_vat_section_to_show = "";
        let html_modal = "";
        let total_tax_custom = 0;
        $.each(vat_amount, function (key, value) {
            total_vat_section_to_show +=
                `<span class="tax_field" id="tax_field_${key.substring(key.indexOf("_") + 1)}">${key.substr(0, key.indexOf("_"))}</span>: <span class="tax_field_amount" id="tax_field_amount_${key.substring(key.indexOf("_") + 1)}">${value}</span><br>`;

            html_modal +=`<tr class="tax_field" data-tax_field_id="${key.substr(0, key.indexOf("_"))}" data-tax_field_type="${key.substring(key.indexOf("_") + 1)}" data-tax_field_amount="${value}">
                    <td>${key.substring(key.indexOf("_") + 1)}</td>
                    <td>${value}</td>
                </tr>`;
            total_tax_custom += Number(value);
        });
        if (total_tax_custom) {
            $("#show_vat_modal").text(parseFloat(total_tax_custom).toFixed(op_precision));
        } else {
            $("#show_vat_modal").text(Number(0).toFixed(op_precision));
        }
        $("#tax_row_show").html(html_modal);
        //calculate total payable amount
        let total_vat_amount = 0;
        $.each(vat_amount, function (key, value) {
            total_vat_amount = (parseFloat(total_vat_amount) + parseFloat(value)).toFixed(op_precision);
        });
        let tax_type = Number($("#tax_type").val());
        if (total_vat_amount == "NaN" || tax_type==2) {
            total_vat_amount = 0;
        }
        let total_payable = (parseFloat(discounted_sub_total_amount) + parseFloat(total_vat_amount) + parseFloat(delivery_charge_amount)).toFixed(op_precision);
        //set total payable amount to view and set rounding value.
        let pos_total_payable_type = $('#pos_total_payable_type').val();
        let total_payable_round;
        let decimal_round;
        if(pos_total_payable_type == 0){
            total_payable_round = parseFloat(total_payable);
            decimal_round = 0;
        } else if(pos_total_payable_type == 1){
            total_payable_round = Math.round(total_payable);
            decimal_round = total_payable - total_payable_round;
        }else {
            total_payable_round = customDecimalRound(parseFloat(total_payable), pos_total_payable_type, op_precision);
            decimal_round = total_payable - total_payable_round;
        }
        // let delivery_charge = $('#show_charge_amount').text();
        // if(delivery_charge){
        //     delivery_charge = parseFloat(delivery_charge);
        // }else{
        //     delivery_charge = 0;
        // }
        $('#total_payable').html((parseFloat(total_payable_round)).toFixed(op_precision));
        $('#rounding').text(parseFloat(decimal_round).toFixed(op_precision));
        //set row number for every single item
        setTimeout(function(){
            $('.order_holder .single_order').each(function (i, obj) {
                $(this).attr('data-single-order-row-no', i + 1);
                $(this).find('.first_portion .fifth_column .remove_this_item_from_cart').attr('data-remove-order-row-no', i + 1);
            });
        }, 200)


        put_cart_content();
    }

    
    
    function getTotalVat() {
        let all_item_total_vat_amount = 0;
        let tax_object = {};
        let tax_name = [];
        let customer_id = $('#walk_in_customer').val();
        let customer_gst_number = '';
        let this_customer;
        for (m in window.customers) {
            this_customer = window.customers[m];
            if (this_customer.customer_id == customer_id) {
                customer_gst_number = this_customer.gst_number;
            }
        }
        let tax_type = Number($("#tax_type").val());
        let customer_state_code = (customer_gst_number != "") ? customer_gst_number.substr(0, 2) : '';
        let same_state = false;
        if (customer_state_code == gst_state_code) {
            same_state = true;
        }
        if (customer_state_code == '') {
            same_state = true;
        }
        $('.single_order .first_portion .fifth_column span').each(function (i, obj) {
            let item_total_price = parseFloat($(this).parent().parent().find('.fifth_column span').text()).toFixed(op_precision);
            let item_tax_obj = $(this).parent().parent().find('.item_vat').html();
            if(item_tax_obj){
                let tax_information = JSON.parse(item_tax_obj);
                if(tax_information){                
                    if (tax_information.length > 0) {
                        for(let k in tax_information){
                            if(tax_name.includes(tax_information[k].tax_field_name) && checkTaxApply(tax_information[k].tax_field_name)){
                                let previous_value = tax_object["" + tax_information[k].tax_field_name];
                                let current_value  = 0;
                                if(tax_type == 1){
                                    current_value = parseFloat((parseFloat(parseFloat(tax_information[k].tax_field_percentage)*parseFloat(item_total_price))/parseFloat(100)));
                                }else{
                                    current_value = (parseFloat(item_total_price) - (parseFloat(item_total_price)/(1+(tax_information[k].tax_field_percentage/100)))).toFixed(op_precision);
                                }
                                tax_object["" + tax_information[k].tax_field_name] = (parseFloat(previous_value)+ Number(current_value)).toFixed(op_precision);
                            }else{
                                if(checkTaxApply(tax_information[k].tax_field_name)){
                                    tax_name.push(tax_information[k].tax_field_name);
                                    let current_value  = 0;
                                    if(tax_type == 1){
                                        current_value = parseFloat((parseFloat(parseFloat(tax_information[k].tax_field_percentage)*parseFloat(item_total_price))/parseFloat(100)));
                                    }else{
                                        current_value = (parseFloat(item_total_price) - parseFloat(item_total_price)/(1+(tax_information[k].tax_field_percentage/100))).toFixed(op_precision);
                                    }
                                    tax_object["" + tax_information[k].tax_field_name] = (Number(current_value)).toFixed(op_precision);
                                }
                            }
                        }
                    }
                }
            }
        });
        return tax_object;
    }


    function getParticularItemDiscountAmount(discount, item_price) {
        if (discount.length > 0 && discount.substr(discount.length - 1) == '%') {
            return (((parseFloat(item_price) * parseFloat(discount)) / parseFloat(100))).toFixed(op_precision);
        } else {
            return parseFloat(discount).toFixed(op_precision);
        }
    }

    

    function getSubTotalDiscountAmount(sub_total_discount, sub_total) {
        if (sub_total_discount.length > 0 && sub_total_discount.substr(sub_total_discount.length - 1) == '%') {
            return (((parseFloat(sub_total) * parseFloat(sub_total_discount)) / parseFloat(100))).toFixed(op_precision);
        } else {
            return parseFloat(sub_total_discount).toFixed(op_precision);
        }
    }


    // Code optimize by Azhar ** Final **
    function resetItemModalAfterAddToCartOrClose() {
        $('#item_quantity_modal').text('1');
        $('#item_quantity_modal_input').val('1');
        $('#modal_item_note').val('');
        $('#modal_item_price_variable_without_discount').text(Number(0).toFixed(op_precision))
        $('#modal_item_vat_percentage').text(Number(0).toFixed(op_precision));
        $('#modal_item_row').text(Number(0));
        $('#modal_discount_amount').text(Number(0).toFixed(op_precision));
    }


    // Code optimize by Azhar ** Final **
    function resetAddCustomerModalAfterAddOrClose() {
        $('.customer_add_modal_info_holder')[0].reset();
    }

    
    // Code optimize by Azhar ** Final **
    function clearFooterCartCalculation() {
        $('#sub_total_show').text(Number(0).toFixed(op_precision));
        $('#sub_total').text(Number(0).toFixed(op_precision));
        $('#total_item_discount').text(Number(0).toFixed(op_precision));
        $('#discounted_sub_total_amount').text(Number(0).toFixed(op_precision));
        $('#sub_total_discount').val(Number(0).toFixed(op_precision));
        $('#sub_total_discount_amount').text(Number(0).toFixed(op_precision));
        $('#all_items_vat').text(Number(0).toFixed(op_precision));
        $('#all_items_discount').text(Number(0).toFixed(op_precision));
        $('#delivery_charge').val(Number(0).toFixed(op_precision));
        $('#total_items_in_cart').text(Number(0));
        $('#total_items_in_cart_with_quantity').text(Number(0));
        $('#total_payable').text(Number(0).toFixed(op_precision));
        $('#show_charge_amount').text(Number(0).toFixed(op_precision));
        $('#show_vat_modal').text(Number(0).toFixed(op_precision));
        $('#total_items_in_cart_without_quantity').text(Number(0));
        $('#show_discount_amount').text(Number(0).toFixed(op_precision));
        $('#delivery_partner_info').attr('data-partner-id', '');
        $('#delivery_partner_info').text('');
        $('#rounding').text('');
        localStorage['cart_html'] = '';
        $('#open_date_picker').attr('data-get-date', '');
    }

    // Code optimize by Azhar ** Final **
    function setDefaultPayment(){
        let default_payment_hidden = Number($("#default_payment_hidden").val());
        let acc_type;
        $(".set_payment").each(function (i, obj) {
            let id = Number($(this).attr('data-id'));
            acc_type = $(this).attr('data-type_value');
            if(id == default_payment_hidden){
                $(this).click();
                if(acc_type == 'Cash'){
                    $('#finalize_given_amount_input').focus();
                }else{
                    $('#finalize_amount_input').focus();
                }
            }
        });
    }

    function setAnimation() {
        let imgToDrag = $("#cash_img").eq(0);
        let cart = $(".payment_list_counter").find("span").last();
        if (imgToDrag) {
        let top_ = Number(imgToDrag.offset().top);
        let imgClone = imgToDrag
            .clone()
            .offset({
                top: top_,
                left: imgToDrag.offset().left,
            })
            .css({
                opacity: "0.5",
                position: "absolute",
                height: "150px",
                width: "150px",
                zIndex: "1000",
            })
            .appendTo($("body"))
            .animate({
                    top: cart.offset().top + 10,
                    left: cart.offset().left + 10,
                    width: "75px",
                    height: "75px",
                },
                1000,
                "easeInOutExpo"
            );
            imgClone.animate(
                {
                    width: 0,
                    height: 0,
                },
                function () {
                    $(this).detach();
                }
            );
        }
    }


    // Code optimize by Azhar ** Final **
    function setActivePayment(){
        $(".set_payment").each(function (i, obj) {
            let this_txt = $(this).text();
            let acc_type = $(this).attr('data-type_value');
            if($(this).hasClass('active')){
                $("#payment_preview").html(this_txt);
                $("#payment_preview").attr('data-account_type', acc_type);
                if(this_txt=="Cash"){
                    $(".cash_div").show();
                    $("#finalize_amount_input").prop("readonly", true);
                    $('#finalize_amount_input').css({
                        'cursor': 'not-allowed',
                    });
                    $("#finalize_change_amount_input").prop("readonly",true);
                    $('#finalize_change_amount_input').css({
                        'cursor': 'not-allowed',
                    });
                    $('#finalize_given_amount_input').focus();   
                }else{
                    $('#finalize_amount_input').focus();
                    $("#finalize_amount_input").prop("readonly",false);
                    $('#finalize_amount_input').css({
                        'cursor': 'unset',
                    });
                    $("#finalize_change_amount_input").prop("readonly",false);
                    $('#finalize_change_amount_input').css({
                        'cursor': 'unset',
                    });
                    $(".cash_div").hide();


                    if(acc_type == 'Paypal' || acc_type == 'Stripe'){
                        $('#add_payment').css({
                            'cursor': 'not-allowed',
                        });
                        $('#add_payment').prop('disabled', true);
                        $('.set_default_quick_cach').css({
                            'cursor': 'not-allowed',
                        });
                        $('.set_default_quick_cach').prop('disabled', true);
                    }else{
                        $('#add_payment').css({
                            'cursor': 'unset',
                        });
                        $('#add_payment').prop('disabled', false);
                        $('.set_default_quick_cach').css({
                            'cursor': 'unset',
                        });
                        $('.set_default_quick_cach').prop('disabled', false);
                    }


                }
            }
        });
    }
    

    // Code optimize by Azhar ** Final **
    function checkCashPayment(amount, is_quick = ''){
        $(".set_payment").each(function (i, obj) {
            let id = Number($(this).attr("data-id"));
            if($(this).hasClass('active')){
                let finalize_total_payable = Number($("#finalize_total_due").text());
                if(finalize_total_payable==amount){
                    let check_exist = false;
                    let payment_id = 0 ;
                    $(".set_payment").each(function (i, obj) {
                        let this_txt = $(this).text();
                        if($(this).hasClass('active')){
                            payment_id = Number($(this).attr('data-id'));
                        }
                    });
                    $(".payment_list_counter").each(function (i, obj) {
                        let payment_id_added = Number($(this).attr('data-payment_id'));
                        if(payment_id===payment_id_added){
                            check_exist = true;
                        }
                    });
                    if(check_exist != true){
                        // toastr['error']((already_added), '');
                    // }else{
                        if(is_quick == 'Yes'){
                            $("#add_payment").click();
                        }
                        $(".set_no_access").addClass('no_access');
                    }
                }
            }
        });
    }

    
    // Code optimize by Azhar ** Final **
    function setFinalizeDiscount(){
        let sub_total_discount_finalize = Number($("#sub_total_discount_finalize").val());
        let finalize_total_paid = Number($("#finalize_total_paid").val());
        let finalize_total_payable = Number($("#finalize_total_payable").attr('data-original_payable'));
        let new_finalize_amount = (finalize_total_payable - sub_total_discount_finalize).toFixed(op_precision);
        let new_due = ((finalize_total_payable - sub_total_discount_finalize)-finalize_total_paid).toFixed(op_precision);
        let conversion_rate  = Number($("#multi_currency").find(':selected').attr('data-multi_currency'));
        let cart_modal_total_discount_all_text = Number($("#cart_modal_total_discount_all_text").attr('data-original_discount'));
        $("#cart_modal_total_discount_all_text").html((cart_modal_total_discount_all_text+sub_total_discount_finalize).toFixed(op_precision));
        $("#finalize_total_payable").html(new_finalize_amount);
        if(conversion_rate){
            $("#finalize_total_paid").html(new_finalize_amount);
            $("#paid_amt").html(new_finalize_amount);
            let total_mul_amount = (conversion_rate*new_finalize_amount).toFixed(op_precision);
            if(total_mul_amount){
                $("#multi_currency_amount").val(total_mul_amount);
            }else{
                $("#multi_currency_amount").val('');
            }
        }else{
            $("#finalize_total_due").html(new_due);
        }
    }


    // Code optimize by Azhar ** Final **
    function removePaidListTitle(){
        if($('.paid-list').find('li').length){
            $(document).find('.empty_title').hide();
        }else{
            $(document).find('.empty_title').show();
        }
    }
    $(window).on('load',removePaidListTitle);



    // Code optimize by Azhar ** Final **
    function calFinalizeModal(is_ignore){
        let finalize_total_payable = Number($("#finalize_total_payable").html());
        let is_multi_currency = Number($("#is_multi_currency").val());
        let tmp_total = 0;
        $(".payment_list_amount").each(function (i, obj) {
            let this_txt = Number($(this).text());
            tmp_total+=this_txt;
        });
        let multi_currency_amount = Number($("#multi_currency_amount").val());
        if(is_multi_currency ==1 && multi_currency_amount){
            tmp_total = finalize_total_payable;
        }
        $("#finalize_total_paid").html(tmp_total.toFixed(op_precision));
        $("#paid_amt").html(tmp_total.toFixed(op_precision));

        $("#finalize_total_due").html((finalize_total_payable - tmp_total).toFixed(op_precision));
        let default_remaining_cash = (finalize_total_payable - tmp_total) && (finalize_total_payable - tmp_total)>0?(finalize_total_payable - tmp_total):0;
        $(".set_default_quick_cach").attr("data-amount",(default_remaining_cash).toFixed(op_precision));
        $(".set_default_quick_cach").html((default_remaining_cash).toFixed(op_precision));
    }


    // Code optimize by Azhar ** Final **
    $(document).on("click", ".account_type", function (e) {
        let account_type = $(this).attr('data-type_value');
        $('#account_type').val(account_type);
        if(account_type == 'Cash' && account_type != undefined){
            $('#show_account_type').html(`
                <div class="form-group">
                    <label>${note_lan}</label>
                    <input type="text" name="p_note" class="form-control w-100-p" placeholder="${note_lan}" id="p_note">
                </div>
            `);
            $('#show_account_type').removeClass('show_account_type')
        }else if(account_type == 'Bank_Account' && account_type != undefined){
            $('#show_account_type').html(`
                <div class="form-group">
                    <label>Bank Name</label>
                    <input type="text" name="check_no" class="form-control" placeholder="Bank Name" id="check_no">
                </div>
                <div class="form-group">
                    <label>${check_no_lan}</label>
                    <input type="text" name="check_no" class="form-control" placeholder="${check_no_lan}" id="check_no">
                </div>
                <div class="form-group">
                    <label>${check_issue_date_lan}</label>
                    <input type="text" name="check_issue_date" class="form-control" placeholder="${check_issue_date_lan}" id="check_issue_date">
                </div>
                <div class="form-group">
                    <label>${check_expiry_date_lan}</label>
                    <input type="text" name="check_expiry_date" class="form-control" placeholder="${check_expiry_date_lan}" id="check_expiry_date">
                </div>
            `);
            $('#show_account_type').addClass('show_account_type')
        }else if(account_type == 'Card' && account_type != undefined){
            $('#show_account_type').html(`
                <div class="form-group">
                    <label>${card_holder_name_lan}</label>
                    <input type="text" name="card_holder_name" class="form-control" placeholder="${card_holder_name_lan}" id="card_holder_name">
                </div>
                <div class="form-group">
                    <label>${card_holding_number_lan}</label>
                    <input type="text" name="card_holding_number" class="form-control" placeholder="${card_holding_number_lan}" id="card_holding_number">
                </div>
            `);
            $('#show_account_type').addClass('show_account_type')
        }else if(account_type == 'Mobile_Banking' && account_type != undefined){
            $('#show_account_type').html(`
                <div class="form-group">
                    <label>${mobile_no_lan}</label>
                    <input type="text" name="mobile_no" class="form-control" placeholder="${mobile_no_lan}" id="mobile_no">
                </div>
                <div class="form-group">
                    <label>${transaction_no_lan}</label>
                    <input type="text" name="transaction_no" class="form-control" placeholder="${transaction_no_lan}" id="transaction_no">
                </div>
            `);
            $('#show_account_type').addClass('show_account_type')
        } else if (account_type == "Paypal" && account_type != undefined) {
            $("#show_account_type").html(`
                <div class="form-group">
                    <label>Credit Card No</label>
                    <input type="text" name="credit_card_no" class="form-control" placeholder="Credit Card No" id="credit_card_no">
                </div>
                <div class="form-group">
                    <label>Holder Name</label>
                    <input type="text" name="holder_name" class="form-control" placeholder="Holder Name" id="holder_name">
                </div>
                <div class="form-group">
                    <label>Month</label>
                    <input type="text" name="payment_month" class="form-control" placeholder="Month" id="payment_month">
                </div>
                <div class="form-group">
                    <label>Year</label>
                    <input type="text" name="payment_year" class="form-control" placeholder="Year" id="payment_year">
                </div>
                <div class="form-group">
                    <label>CVC</label>
                    <input type="text" name="payment_cvc" class="form-control" placeholder="CVC" id="payment_cvc">
                </div>
                <div class="btns">
                    <button class="pay_button start_animation set_no_access" id="pay_button"><b>Pay</b></button>
                </div>`);
            $("#show_account_type").addClass("show_account_type");
            $(".select2").select2();
        } else if (account_type == "Stripe" && account_type != undefined) {
            $("#show_account_type").html(`
                <div class="form-group">
                    <label>Credit Card No</label>
                    <input type="text" name="credit_card_no" class="form-control" placeholder="Credit Card No" id="credit_card_no">
                </div>
                <div class="form-group">
                    <label>Holder Name</label>
                    <input type="text" name="holder_name" class="form-control" placeholder="Holder Name" id="holder_name">
                </div>
                <div class="form-group">
                    <label>Month</label>
                    <input type="text" name="payment_month" class="form-control" placeholder="Month" id="payment_month">
                </div>
                <div class="form-group">
                    <label>Year</label>
                    <input type="text" name="payment_year" class="form-control" placeholder="Year" id="payment_year">
                </div>
                <div class="form-group">
                    <label>CVC</label>
                    <input type="text" name="payment_cvc" class="form-control" placeholder="CVC" id="payment_cvc">
                </div>
                <div class="btns">
                    <button class="pay_button start_animation set_no_access" id="pay_button"><b>Pay</b></button>
                </div>`);
            $("#show_account_type").addClass("show_account_type");
            $(".select2").select2();
        } else {
            $('#show_account_type').html('');
        }
    });


    // Code optimize by Azhar ** Final **
    $(document).on("click", ".set_payment", function (e) {
        $("#finalize_amount_input").val('');
        let id = Number($(this).attr('data-id'));
        let acc_type = $(this).attr('data-type_value');
        let amount_txt = $("#amount_txt").val();
        let loyalty_point_txt = $("#loyalty_point_txt").val();
        let loyalty_rate = Number($("#loyalty_rate").val());
        if(acc_type != 'Loyalty Point'){
            $(".previous_due_div").show();
            $(".loyalty_point_div").hide();
            $(".amount_txt").html(amount_txt);
            $("#finalize_amount_input").attr("placeholder", amount_txt);
            if(id!=undefined){
                $('.set_payment').removeClass('active');
                $(this).addClass('active');
            }
            setActivePayment();
            setFinalizeDiscount();
            calFinalizeModal('');
            if(acc_type != 'Cash'){
                $('#finalize_amount_input').attr('readonly', false);
            }else{
                $('#finalize_amount_input').val($('#finalize_given_amount_input').val());
            }
        }else{
            let customer_id_loyalty = Number($("#walk_in_customer").val());
            let selected_customer_name = $('option:selected', '#walk_in_customer').attr('data-customer-name');
            if(selected_customer_name != 'Walk-in Customer'){
                $.ajax({
                    url: base_url + "Sale/getTotalLoyaltyPoint",
                    method: "POST",
                    dataType:'json',
                    data: {
                        customer_id: customer_id_loyalty,
                        customer_name: selected_customer_name,
                    },
                    success: function (response) {
                        if(response.status==true){

                            $('#finalize_amount_input').attr('readonly', false);
                            $('#finalize_amount_input').css({
                                'cursor':'none',
                                'background-color':'white',
                            });

                            $(".previous_due_div").hide();
                            $(".loyalty_point_div").show();
                            $("#available_loyalty_point").html(Number(response.total_point));
                        }else{
                            toastr['error']((response.alert_txt), '');
                        }
                    }
                });
                $(".amount_txt").html(loyalty_point_txt);
                $("#finalize_amount_input").attr("placeholder",loyalty_point_txt);

                let finalize_total_due_ = Number($("#finalize_total_due").html());
                let tool_tip_loyalty_point =  $("#tool_tip_loyalty_point").val();
                $(".set_default_quick_cach").html(((1/loyalty_rate) * finalize_total_due_).toFixed(op_precision)+" &nbsp;&nbsp;<span data-tippy-content='"+tool_tip_loyalty_point+"' class='tool_tip_loyalty_point fa fa-info'></span>");
                $(".set_default_quick_cach").attr('data-amount',((1/loyalty_rate) * finalize_total_due_).toFixed(op_precision));

                tippy(".tool_tip_loyalty_point", {
                    // animation: "scale",
                    allowHTML: true,
                });

                $("#finalize_amount_input").css("border","1px solid #bcbdbe");
                $("#finalize_amount_input").focus();
                if(id!=undefined){
                    $('.set_payment').removeClass('active');
                    $(this).addClass('active');
                }
                setActivePayment();
            }else{
                if(id!=undefined){
                    $('.set_payment').removeClass('active');
                    $(this).addClass('active');
                }
                $(".amount_txt").html(loyalty_point_txt);
                $("#payment_preview").text(acc_type);
                $("#payment_preview").attr('data-account_type', acc_type);
                $('.cash_div').hide();
                $("#finalize_amount_input").attr("placeholder",loyalty_point_txt);
                $('#finalize_amount_input').attr('readonly', true);
                $('#finalize_amount_input').css({
                    'cursor':'not-allowed',
                    'background-color':'#ecf0f1',
                });
                $(".previous_due_div").hide();
                $(".loyalty_point_div").show();
                $("#available_loyalty_point").html(Number(0));
                let loyalty_point_not_applicable = $("#loyalty_point_not_applicable").val();
                toastr['error']((loyalty_point_not_applicable), '');
            }
        }
    });


    function set_finalize_discount(){
        let sub_total_discount_finalize = Number($("#sub_total_discount_finalize").val());
        let finalize_total_paid = Number($("#finalize_total_paid").val());
        let finalize_total_payable = Number($("#finalize_total_payable").attr('data-original_payable'));
  
        let new_finalize_amount = (finalize_total_payable - sub_total_discount_finalize).toFixed(op_precision);
        let new_due = ((finalize_total_payable - sub_total_discount_finalize)-finalize_total_paid).toFixed(op_precision);
  
        $("#finalize_total_payable").html(new_finalize_amount);

        let cart_modal_total_discount_all_text = Number($("#cart_modal_total_discount_all_text").attr('data-original_discount'));
        $("#cart_modal_total_discount_all_text").html((cart_modal_total_discount_all_text+sub_total_discount_finalize).toFixed(op_precision));
  
        let conversion_rate  = Number($("#multi_currency").find(':selected').attr('data-multi_currency'));
        if(conversion_rate){
            $("#finalize_total_paid").html(new_finalize_amount);
            //set multi currency value
            let total_mul_amount = (conversion_rate*new_finalize_amount).toFixed(2);
            if(total_mul_amount){
                $("#multi_currency_amount").val(total_mul_amount);
            }else{
                $("#multi_currency_amount").val('');
            }
        }else{
            $("#finalize_total_due").html(new_due);
        }
    }

    
    $(document).on("click", ".get_quick_cash", function (e) {
        e.preventDefault();
        let finalize_amount_input
        let amount = Number($(this).attr('data-amount'));
        let is_denomination = ($(this).attr('data-is_denomination'));
        if(is_denomination=="yes"){
            let sum = 0;
            finalize_amount_input = $("#finalize_amount_input").val();
            if(finalize_amount_input==''){
                finalize_amount_input = 0;
            }else{
                finalize_amount_input = Number($("#finalize_amount_input").val());
            }
            sum = finalize_amount_input + amount;
            $(".set_payment").each(function (i, obj) {
                let id = ($(this).text());
                if($(this).hasClass('active')){
                    if(id=="Cash"){
                        $("#finalize_given_amount_input").val(sum.toFixed(op_precision));
                    }
                }
            });
            let total_count = $(this).find("span").html();
            let this_amount  = $(this).attr('data-amount');
            if(total_count!=undefined){
                total_count = Number(total_count)+1;
            }else{
                total_count = 1;
            }
            amount = sum;
            $("#finalize_amount_input").val(amount.toFixed(op_precision));
            $(this).html(this_amount+' <span class="badge_custom">'+total_count+'</span>');
        }else{
            $("#finalize_amount_input").val(amount.toFixed(op_precision));
            $(".set_payment").each(function (i, obj) {
                let id = ($(this).text());
                if($(this).hasClass('active')){
                    if(id=="Cash"){
                        $("#finalize_given_amount_input").val(amount.toFixed(op_precision));
                    }
                }
            });
        }
        $(".set_payment").each(function (i, obj) {
            let id = ($(this).text());
            if($(this).hasClass('active')){
                if(id=="Cash"){
                    let finalize_total_payable = Number($("#finalize_total_due").text());
                    let finalize_given_amount_input = Number($("#finalize_given_amount_input").val());
                    let change_amount = (finalize_given_amount_input - finalize_total_payable);
                    $("#finalize_change_amount_input").val((change_amount && change_amount>0?change_amount:0).toFixed(op_precision));
                    let finalize_change_amount_input = Number($("#finalize_change_amount_input").val());
                    if(finalize_change_amount_input){
                        amount = Number($("#finalize_total_due").text());
                        $("#finalize_amount_input").val(amount.toFixed(op_precision));
                    }
                }
            }
        });
        checkCashPayment(amount, 'Yes')
    });



    // Code optimize by Azhar ** Final **
    $(document).on("click", "#add_payment", function (e) {
        let account_note = '';
        let check_no = '';
        let check_issue_date = '';
        let check_expiry_date = '';
        let card_holder_name = '';
        let card_holding_number = '';
        let mobile_no = '';
        let transaction_no = '';
        let swip_card = '';
        let credit_card_no = '';
        let holder_name = '';
        let card_type = '';
        let payment_month = '';
        let payment_year = '';
        let payment_cvc = '';
        let paypal_email = '';
        let stripe_email = '';
        let paymentTypeArr = [];
        let account_type = $('.list-for-payment-type .active').attr('data-type_value');

        let  payment_exist_check = 'No';
        $('.payment_list_counter .payment-type-name').each(function(){
            if($(this).text() == $('.payment_element .active').text()){
                payment_exist_check == 'Yes';
            }
        });
        if(payment_exist_check == 'Yes'){
            return false;
        }


        if(account_type == 'Cash' && account_type != undefined){
            account_note = $('#p_note').val();
            if(account_note != ''){
                account_note = `Note:${account_note}`;
            }
            paymentTypeArr.push(account_note);
        }else if(account_type == 'Bank_Account' && account_type != undefined){
            check_no = $('#check_no').val();
            if(check_no != ''){
                check_no = `Check No: ${check_no}`;
            }
            paymentTypeArr.push(check_no);
            check_issue_date = $('#check_issue_date').val();
            if(check_issue_date != ''){
                check_issue_date = `Check Issue Data: ${check_issue_date}`;
            }
            paymentTypeArr.push(check_issue_date);
            check_expiry_date = $('#check_expiry_date').val();
            if(check_expiry_date != ''){
                check_expiry_date = `Check Expiry Data: ${check_expiry_date}`;
            }
            paymentTypeArr.push(check_expiry_date);
        }else if(account_type == 'Card' && account_type != undefined){
            card_holder_name = $('#card_holder_name').val();
            if(card_holder_name != ''){
                card_holder_name = `Card Holder Name: ${card_holder_name}`;
            }
            paymentTypeArr.push(card_holder_name);
            card_holding_number = $('#card_holding_number').val();
            if(card_holding_number != ''){
                card_holding_number = `Card Holding Number: ${card_holding_number}`;
            }
            paymentTypeArr.push(card_holding_number);
        }else if(account_type == 'Mobile_Banking' && account_type != undefined){
            mobile_no = $('#mobile_no').val();
            if(mobile_no != ''){
                mobile_no = `Mobile No: ${mobile_no}`;
            }
            paymentTypeArr.push(mobile_no);
            transaction_no = $('#transaction_no').val();
            if(transaction_no != ''){
                transaction_no = `Transaction No: ${transaction_no}`;
            }
            paymentTypeArr.push(transaction_no);
        }else if(account_type == 'Paypal' && account_type != undefined){
            swip_card = $('#swip_card').val();
            if(swip_card != ''){
                swip_card = `Swip Card: ${swip_card}`;
            }
            paymentTypeArr.push(swip_card);

            credit_card_no = $('#credit_card_no').val();
            if(credit_card_no != ''){
                credit_card_no = `Credit Card: ${credit_card_no}`;
            }
            paymentTypeArr.push(credit_card_no);

            holder_name = $('#holder_name').val();
            if(holder_name != ''){
                holder_name = `Holder Name: ${holder_name}`;
            }
            paymentTypeArr.push(holder_name);
            
            card_type = $('#card_type').val();
            if(card_type != ''){
                card_type = `Card Type: ${card_type}`;
            }
            paymentTypeArr.push(card_type);

            payment_month = $('#payment_month').val();
            if(payment_month != ''){
                payment_month = `Payment Month: ${payment_month}`;
            }
            paymentTypeArr.push(payment_month);

            payment_year = $('#payment_year').val();
            if(payment_year != ''){
                payment_year = `Payment Year: ${payment_year}`;
            }
            paymentTypeArr.push(payment_year);

            payment_cvc = $('#payment_cvc').val();
            if(payment_cvc != ''){
                payment_cvc = `Payment CVC: ${payment_cvc}`;
            }
            paymentTypeArr.push(payment_cvc);
        }else if(account_type == 'Stripe' && account_type != undefined){
            swip_card = $('#swip_card').val();
            if(swip_card != ''){
                swip_card = `Swip Card: ${swip_card}`;
            }
            paymentTypeArr.push(swip_card);

            credit_card_no = $('#credit_card_no').val();
            if(credit_card_no != ''){
                credit_card_no = `Credit Card: ${credit_card_no}`;
            }
            paymentTypeArr.push(credit_card_no);

            holder_name = $('#holder_name').val();
            if(holder_name != ''){
                holder_name = `Holder Name: ${holder_name}`;
            }
            paymentTypeArr.push(holder_name);
            
            card_type = $('#card_type').val();
            if(card_type != ''){
                card_type = `Card Type: ${card_type}`;
            }
            paymentTypeArr.push(card_type);

            payment_month = $('#payment_month').val();
            if(payment_month != ''){
                payment_month = `Payment Month: ${payment_month}`;
            }
            paymentTypeArr.push(payment_month);

            payment_year = $('#payment_year').val();
            if(payment_year != ''){
                payment_year = `Payment Year: ${payment_year}`;
            }
            paymentTypeArr.push(payment_year);

            payment_cvc = $('#payment_cvc').val();
            if(payment_cvc != ''){
                payment_cvc = `Payment CVC: ${payment_cvc}`;
            }
            paymentTypeArr.push(payment_cvc);
        }else{
        }

        let finalize_amount_input = parseFloat($("#finalize_amount_input").val());
        let usage_point = finalize_amount_input;
        let status = false;
        let check_exist = false;
        let payment_id = 0 ;
        let acc_type = '' ;
        let payment_text = '' ;
        let payment_name = $("#payment_preview").text() ;
        let payment_acc_type = $("#payment_preview").attr('data-account_type') ;
        $(".set_payment").each(function () {
            if($(this).hasClass('active')){
                status = true;
                payment_id = Number($(this).attr('data-id'));
                acc_type = $(this).attr('data-type_value');
                payment_text = $(this).text();
            }
        });
        $("#finalize_given_amount_input").css("border","1px solid #bcbdbe");
        $("#finalize_amount_input").css("border","1px solid #bcbdbe");
        let minimum_point_to_redeem = Number($("#minimum_point_to_redeem").val());
        let loyalty_rate = Number($("#loyalty_rate").val());
        let available_loyalty_point = Number($("#available_loyalty_point").html());
        if((minimum_point_to_redeem > finalize_amount_input) && acc_type === 'Loyalty Point'){
            let minimum_point_to_redeem_is = $("#minimum_point_to_redeem_is").val();
            toastr['error']((minimum_point_to_redeem_is+ " "+minimum_point_to_redeem), '');
        }else if((available_loyalty_point<finalize_amount_input) && acc_type === 'Loyalty Point'){
            let loyalty_point_is_not_available = $("#loyalty_point_is_not_available").val();
            toastr['error']((finalize_amount_input+" "+loyalty_point_is_not_available), '');
        }else{
            $(".payment_list_counter").each(function () {
                let dataAccName = $(this).attr('data-payment_name');
                if(payment_text == dataAccName){
                    check_exist = true;
                }
            });
            if(acc_type==='Loyalty Point'){
                payment_name = payment_name+"(Usage "+finalize_amount_input+")";
                finalize_amount_input = (loyalty_rate * finalize_amount_input);
            }
       

            let tmp_amount_checker = finalize_amount_input;
            if(payment_text == "Cash"){
                tmp_amount_checker = parseFloat($("#finalize_given_amount_input").val());
            }

            setTimeout(() =>{
                let finalize_total_due = Number($("#finalize_total_due").text());
                if(finalize_total_due > 0){
                    $('.due_date_select ').show();
                }else{
                    $('.due_date_select ').hide();
                }
            }, 100);
            

            if(tmp_amount_checker){
                if(status==true){
                    $("#finalize_amount_input").css("border","1px solid #bcbdbe");

                    let html = `<li class="payment_list_counter" data-usage_point="${usage_point}" data-payment_name="${payment_name}" data-account_type="${payment_acc_type}" data-payment_id="${payment_id}" data-amount="${finalize_amount_input.toFixed(op_precision)}">
                        <span class="payment-type-name">${payment_name}</span>
                        <div class="d-flex align-items-center">
                            <span class="payment_list_amount op_padding_right_5">${finalize_amount_input.toFixed(op_precision)}</span>
                            <iconify-icon icon="solar:trash-bin-minimalistic-broken" class="remove_paid_item"></iconify-icon>
                        </div>
                        <input type="hidden" class="paymentAccountDetails" name="sale_payment_info[]" value="${paymentTypeArr}" />
                    </li>`;
                    if(check_exist==true){
                        toastr['error']((already_added), '');
                    }else{
                        $(".set_payment").each(function (i, obj) {
                            if($(this).hasClass('active')){
                                let payment_id_action = Number($(this).attr('data-id'));
                                let name = $(this).text();
                                if(name=="Cash"){
                                    $("#hidden_given_amount").val($("#finalize_given_amount_input").val());
                                    $("#hidden_change_amount").val($("#finalize_change_amount_input").val());
                                    let finalize_given_amount_input = Number($("#finalize_given_amount_input").val());
                                    let finalize_total_payable = Number($("#finalize_total_due").text());
                                    if(finalize_total_payable<finalize_given_amount_input){
                                        $(".set_no_access").addClass('no_access');
                                    }
                                    if(parseFloat($("#finalize_change_amount_input").val())){
                                        $(".change_amount_div").show();
                                        $("#change_amount_div_").text(Number($("#finalize_change_amount_input").val()).toFixed(op_precision));
                                        $(".finalize-changes-amt-mobile").text(`${Number($("#finalize_change_amount_input").val()).toFixed(op_precision)}`);
                                        $('.finalize-changes-amt-mobile').siblings().removeClass('d-none');
                                        $('.finalize-changes-amt-mobile').siblings().addClass('d-block');
                                    }else{
                                        $(".change_amount_div").hide();
                                        $("#change_amount_div_").text(Number(0).toFixed(op_precision));
                                        $(".finalize-changes-amt-mobile").text(Number(0).toFixed(op_precision));
                                    }
                                    $("#finalize_given_amount_input").val('');
                                    $("#finalize_change_amount_input").val('');
                                }
                            }
                        });
                        
                        $(".empty_title").hide();
                        $("#payment_list_div").append(html);
                        $("#finalize_amount_input").val('');
                        $("#finalize_amount_input").focus();
                        $(".badge_custom").remove();
                        setAnimation();
                        calFinalizeModal('');
                        setDefaultPayment();
                    }
                }else{
                    let please_click_a_payment_method_before_add = $("#please_click_a_payment_method_before_add").val();
                    toastr['error']((please_click_a_payment_method_before_add), '');
                }
            }else{
                if(payment_text=="Cash"){
                    $("#finalize_given_amount_input").focus();
                    $("#finalize_given_amount_input").addClass("border-2-red");
                }else{
                    $("#finalize_amount_input").focus();
                    $("#finalize_amount_input").addClass("border-2-red");
                }

            }
        }
    });
    setActivePayment();


    // Multi Currency
    $(document).on("click", "#change_currency_btn", function (e) {
        //for mobile view
        $("#order-split-bill-payment-amount").click();
        if(Number($(".payment_list_counter").length)){
            let your_added_payment_method_will_remove = $("#your_added_payment_method_will_remove").val();
            Swal.fire({
                title: warning + "!",
                text: your_added_payment_method_will_remove,
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: "OK",
                denyButtonText: `Cancel`
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $('.order-payment-list').addClass('pointer-events-none');
                    $('.payment_content_left_side').addClass('pointer-events-none');
                    $('.show_account_type').addClass('pointer-events-none');
                    $('.right-keys').addClass('pointer-events-none');

                    $(".set_no_access").addClass('no_access');
                    $(".finalize_modal_is_mul_currency").show(300);
                    $("#is_multi_currency").val(1);
                    $("#multi_currency").val('').change();
                    $("#multi_currency_amount").val('');
                    $(".empty_title").show();
                    $("#payment_list_div").html('');
                    $("#finalize_amount_input").html('');
                    $(".badge_custom").remove();
                    $(".previous_due_div").show();
                    $(".loyalty_point_div").hide();
                    setDefaultPayment();
                    calFinalizeModal('');
                } else if (result.isDenied) {
                    
                }
            });
        }else{

            $('.order-payment-list').addClass('pointer-events-none');
            $('.payment_content_left_side').addClass('pointer-events-none');
            $('.show_account_type').addClass('pointer-events-none');
            $('.right-keys').addClass('pointer-events-none');

            $(".previous_due_div").show();
            $(".loyalty_point_div").hide();
            $("#multi_currency").val('').change();
            $("#multi_currency_amount").val('');
            $("#is_multi_currency").val(1);
            $(".set_no_access").addClass('no_access');
            $(".finalize_modal_is_mul_currency").show(300);
        }
    });



    $(document).on("click", ".remove_multi_currency", function (e) {

        $('.order-payment-list').removeClass('pointer-events-none');
        $('.payment_content_left_side').removeClass('pointer-events-none');
        $('.show_account_type').removeClass('pointer-events-none');
        $('.right-keys').removeClass('pointer-events-none');

        $(".set_no_access").removeClass('no_access');
        $(".finalize_modal_is_mul_currency").hide(300);
        $("#is_multi_currency").val('');
        $("#multi_currency").val('').change();
        $("#multi_currency_amount").val('');
        $("#sub_total_discount_finalize").val('');
        $(".order-payment-wrapper").find('.order-payment-list').fadeIn(0);
        cal_finalize_modal('');
        set_finalize_discount();
    });


    // Code optimize by Azhar ** Final **
    $(document).on("keyup", "#sub_total_discount_finalize", function (e) {
        let himSelf = $(this);
        let user_id = $('#session_uer_id').val();
        let discount_permission_code = $('.discount_permission_code_f').val();
        let error = false;
        if(discount_permission_code == ''){
            error = true;
            $('.discount_err_message_f').parent().show();
            $('.discount_err_message_f').text(The_discount_code_field_required)
            return false
        }else{
            $.ajax({
                method: "POST",
                url: base_url+"Sale/checUserDiscountPermission",
                data: {
                    user_id: user_id,
                    discount_permission_code: discount_permission_code,
                },
                success: function (response) {
                    if(response.status == 'success'){
                        let discountOriginal = $(himSelf).val();
                        let plainDiscount = discountOriginal.replace('%', '')
                        if(Number(plainDiscount) > 0){
                            let userAssignDiscount = response.data;
                            let userAssignDiscountPlain = userAssignDiscount.replace('%', '');
                            if( Number(plainDiscount) <= Number(userAssignDiscountPlain)){
                                setFinalizeDiscount();
                                calFinalizeModal('');
                            }else{
                                Swal.fire({
                                    title: warning+" !",
                                    text: `This cashier cannot give more than ${response.data} discount`,
                                    showDenyButton: false,
                                    showCancelButton: false,
                                    confirmButtonText: ok,
                                });
                                $(himSelf).val('');
                            }
                        }
                    }else{
                        $('.discount_err_message').text(response.message)
                        $('.discount_err_message').parent().show();
                    }
                }
            });
        }
    });



    // Code optimize by Azhar ** Final **
    $(document).on("click", ".remove_paid_item", function () {

        let finalize_total_due = Number($("#finalize_total_due").text());
        if(finalize_total_due > 0){
            $('.due_date_select ').hide();
        }else{
            $('.due_date_select ').show();
        }

        $(".set_no_access").removeClass('no_access');
        $("#hidden_given_amount").val('');
        $("#hidden_change_amount").val('');
        $("#finalize_given_amount_input").val('');
        $("#finalize_change_amount_input").val('');
        if(Number($("#finalize_change_amount_input").val())){
            $(".change_amount_div").show();
            $("#change_amount_div_").text(Number($("#finalize_change_amount_input").val()).toFixed(op_precision));
            $(".finalize-changes-amt-mobile").text(`${Number($("#finalize_change_amount_input").val()).toFixed(op_precision)}`);
            $('.finalize-changes-amt-mobile').siblings().removeClass('d-none');
            $('.finalize-changes-amt-mobile').siblings().addClass('d-block');
        }else{
            $(".change_amount_div").hide();
            $("#change_amount_div_").text(Number(0).toFixed(op_precision));
            $(".finalize-changes-amt-mobile").text(Number(0).toFixed(op_precision));
        }
        $(this).parent().parent().remove();
        $("#finalize_amount_input").val('');
        removePaidListTitle();
        calFinalizeModal('');
    });

    // Code optimize by Azhar ** Final **
    $(document).on("click", ".remove_discount", function (e) {
        $("#sub_total_discount_finalize").val("");
        setFinalizeDiscount();
        calFinalizeModal('');
    });


    // Code optimize by Azhar ** Final **
    $(document).on('click', '.remove_this_item_from_cart', function () {
        let row_number = $(this).attr('data-remove-order-row-no');
        $('.single_order[data-single-order-row-no=' + row_number + ']').remove();
        productSound3.play();
        cartItemCalculationInPOS();
        if(edit_mode == ''){
            storageCartDataInLocal();
        }
        cartMobileItemCount();
        cartMobileRemoveMsgAndItemCount();
    });




    // Code optimize by Azhar ** Final **
    function add_sale_by_ajax(order_object, total_payable) {
        $("#finalize_order_modal").addClass("active");
        $(".pos__modal__overlay").fadeIn(200);
        // let finalize_previous_due = $('#walk_in_customer option:selected').attr('data-previous_due');
        let finalize_previous_due = 0;
        let finalize_total_payable = (Number(total_payable)).toFixed(op_precision);
        $('#finalize_grand_total').text(total_payable);
        $('#finalize_total_payable').text(finalize_total_payable);
        $("#finalize_total_payable").attr('data-original_payable',finalize_total_payable);
        $('.set_default_quick_cach').text((Number(total_payable) + (Number(finalize_previous_due))).toFixed(op_precision));
        $('.set_default_quick_cach').attr('data-amount', (Number(total_payable) + (Number(finalize_previous_due))).toFixed(op_precision));
        $('#pay_amount_invoice_input').val((Number(total_payable) + (Number(finalize_previous_due))).toFixed(op_precision));
        $("#order_object").val(order_object);
        setDefaultPayment();
    }


    // Code optimize by Azhar ** Final **
    $(document).on('click', '#hold_sale', function () {
        if(is_offline_system == '1'){
            if ($('.order_holder .single_order').length > 0) {
                $.ajax({
                    url: base_url + "Sale/get_new_hold_number_ajax",
                    method: "GET",
                    success: function (response) {
                        $("#generate_sale_hold_modal").addClass("active");
                        $(".pos__modal__overlay").fadeIn(200);
                        $('#hold_generate_input').val(response);
                    }
                });
            } else {
                toastr['error']((cart_empty), '');
            }
        }else{
            if ($('.order_holder .single_order').length > 0) {
                // Open a connection to the IndexedDB database
                let request = indexedDB.open('off_pos_3', 3);
            
                request.onupgradeneeded = function(event) {
                    let db = event.target.result;
                    // Create the 'draft_sale' object store if it doesn't exist
                    if (!db.objectStoreNames.contains('draft_sales')) {
                        db.createObjectStore('draft_sales', { keyPath: 'id', autoIncrement: true });
                    }
                };
            
                request.onsuccess = function(event) {
                    let db = event.target.result;
                    // Check if the 'draft_sale' object store exists
                    if (!db.objectStoreNames.contains('draft_sales')) {
                        console.error("Object store 'draft_sales' not found");
                        $("#generate_sale_hold_modal").addClass("active");
                        $(".pos__modal__overlay").fadeIn(200);
                        $('#hold_generate_input').val(1);
                        return;
                    }
                    let transaction = db.transaction(['draft_sales'], 'readonly');
                    let objectStore = transaction.objectStore('draft_sales');
                    let countRequest = objectStore.count();
                    countRequest.onsuccess = function() {
                        let count = countRequest.result;
                        let newHoldNumber = count + 1;
                        $("#generate_sale_hold_modal").addClass("active");
                        $(".pos__modal__overlay").fadeIn(200);
                        $('#hold_generate_input').val(newHoldNumber);
                    };
                    countRequest.onerror = function(event) {
                        console.error("Count error: " + event.target.error);
                    };
                };
                request.onerror = function(event) {
                    console.error("Database error: " + event.target.error);
                };
                request.onerror = function(event) {
                    console.error("Database error: " + event.target.error);
                };
            } else {
                toastr['error']((cart_empty), '');
            }
        }
    });


    // Code optimize by Azhar ** Final **
    function add_hold_by_ajax(order_object, hold_number) {
        if(is_offline_system == '1'){
            $.ajax({
                url: base_url + "Sale/add_hold_by_ajax",
                method: "POST",
                data: {
                    order: order_object,
                    hold_number: hold_number,
                    csrf_offpos: csrf_value_
                },
                success: function (response) {
                    $("#generate_sale_hold_modal").removeClass('active');
                    $('.order_holder').empty();
                    $('#hold_generate_input').val(Number(0));
                    $('#table_button').attr('disabled', false);
                    $('.main_top').find('button').css('background-color', '#F3F3F3');
                    clearFooterCartCalculation();
                    resetDefaultCustomer();
                    resetFinalizeModal();
                }
            });
        }else{
            let db;
            const request = indexedDB.open("off_pos_3", 3);  
            request.onupgradeneeded = function(event) {
                db = event.target.result; 
                if (!db.objectStoreNames.contains("draft_sales")) {  // Check if store already exists
                    db.createObjectStore("draft_sales", { keyPath: "id", autoIncrement: true }); 
                    console.log("Object store 'draft_sales' created");
                }
            };
            request.onsuccess = function(event) {
                db = event.target.result;
                // Check if the object store exists before creating a transaction
                if (db.objectStoreNames.contains("draft_sales")) {
                    const transaction = db.transaction(["draft_sales"], "readwrite");
                    const objectStore = transaction.objectStore("draft_sales");  
                    // Add the data to the 'draft_sales' object store
                    const requestAdd = objectStore.add({
                        order: JSON.parse(order_object),
                        holdNumber: hold_number
                    });
                    requestAdd.onsuccess = function(event) {
                        console.log("Data added to 'Draft Sale' successfully");
                    };
                    requestAdd.onerror = function(event) {
                        console.log("Error adding data to 'Draft Sales':", event);
                    };
                } else {
                    console.error("Object store 'draft_sales' not found");
                    // Optionally, you could create the object store here if it doesn't exist
                    // db.createObjectStore("draft_sales", { keyPath: "id", autoIncrement: true });
                }
            };
            request.onerror = function(event) {
                console.log("Error opening database:", event);
            };
            $("#generate_sale_hold_modal").removeClass('active');
            $('.order_holder').empty();
            $('#hold_generate_input').val(Number(0));
            $('#table_button').attr('disabled', false);
            $('.main_top').find('button').css('background-color', '#F3F3F3');
            clearFooterCartCalculation();
            resetDefaultCustomer();
            resetFinalizeModal();
        }
        
    }
    

    // Code optimize by Azhar ** Final **
    $(document).on('click', '#hold_cart_info', function () {
        let hold_number = $('#hold_generate_input').val();
        if (hold_number == "") {
            $('#hold_generate_input').css('border', '1px solid #dc3545');
            return false;
        } else {
            $('#hold_generate_input').css('border', '1px solid #a0a0a0');
        }
        let total_items_in_cart = $('.order_holder .single_order').length;
        let sub_total = parseFloat($('#sub_total_show').text()).toFixed(op_precision);
        let total_vat = parseFloat($('#show_vat_modal').text()).toFixed(op_precision);
        let total_payable = parseFloat($('#total_payable').text()).toFixed(op_precision);
        let total_item_discount_amount = parseFloat($('#total_item_discount').text()).toFixed(op_precision);
        let sub_total_with_discount = parseFloat($('#discounted_sub_total_amount').text()).toFixed(op_precision);
        let sub_total_discount_amount = parseFloat($('#sub_total_discount_amount').text()).toFixed(op_precision);
        let total_discount_amount = parseFloat($('#all_items_discount').text()).toFixed(op_precision);
        let delivery_charge = ($('#delivery_charge').val() != "") ? parseFloat($('#delivery_charge').val()).toFixed(op_precision) : parseFloat(0).toFixed(op_precision);
        let customer_id = $('#walk_in_customer').val();
        let customer_name = $('option:selected', '#walk_in_customer').attr('data-customer-name');
        let customer_phone_number = $('option:selected', '#walk_in_customer').attr('data-phone_number');
        let select_employee_id = $('#select_employee_id').val();
        let sub_total_discount_value = $('#sub_total_discount').val();
        let delivery_partner = $.trim($('#delivery_partner_info').attr('data-partner-id'));
        let rounding = $.trim($('#rounding').text());
        let sub_total_discount_type = '';
        let sale_vat_objects = [];
        $('#all_items_vat .tax_field').each(function (i, obj) {
            let tax_field_id = $(this).attr('id').substr(10);
            let tax_field_type = $(this).html();
            let tax_field_amount = $('#tax_field_amount_' + tax_field_id).html();
            sale_vat_objects.push({
                tax_field_id: tax_field_id,
                tax_field_type: tax_field_type,
                tax_field_amount: tax_field_amount
            });
        });
        if (total_items_in_cart == 0) {
            toastr['error']((cart_empty), '');
            return false;
        }
        if (sub_total_discount_value.length > 0 && sub_total_discount_value.substr(sub_total_discount_value.length - 1) == '%') {
            sub_total_discount_type = 'percentage';
        } else {
            sub_total_discount_type = 'plain';
        }
        const sale_date = new Date().toLocaleDateString(); 
        const sale_time = new Date().toLocaleTimeString();
        let orderInfo = {
            "sale_date": sale_date,
            "sale_time": sale_time,
            "customer_id": customer_id,
            "customer_name": customer_name,
            "customer_phone_number": customer_phone_number,
            "select_employee_id": select_employee_id,
            "total_items_in_cart": total_items_in_cart,
            "sub_total": sub_total,
            "total_vat": total_vat,
            "total_payable": total_payable,
            "total_item_discount_amount": total_item_discount_amount,
            "sub_total_with_discount": sub_total_with_discount,
            "sub_total_discount_amount": sub_total_discount_amount,
            "total_discount_amount": total_discount_amount,
            "delivery_charge": delivery_charge,
            "sub_total_discount_value": sub_total_discount_value,
            "sub_total_discount_type": sub_total_discount_type,
            "sale_vat_objects": sale_vat_objects,
            "delivery_partner": delivery_partner,
            "rounding": rounding,
            "items": []
        };
        $('.order_holder .single_order').each(function (i, obj) {
            let item_id = $(this).attr('id').substr(15);
            let freeItemId = '';
            let freeItemName = '';
            let freeItemBuyQty = '';
            let freeItemGetQty = '';
            let freeItemLength = $(this).find('.free-item').length;
            if (freeItemLength) {
                freeItemId = $(this).find('.free-item').attr('data-free-item-id');
                freeItemName = $(`#free_item_name_table_${item_id}`).text();
                freeItemBuyQty = $(`#free_item_buy_table_${item_id}`).text();
                freeItemGetQty = $(`#free_item_get_table_${item_id}`).text();
            }
            
            let is_promo = $(this).attr('is_promo');
            let item_name = $(this).find('#item_name_table_' + item_id).text();
            let item_type_check = $(`#item_type_table${item_id}`).text();
            let menu_taxes = $(`#item_vat_percentage_table${item_id}`).text();
            let item_discount = $(this).find('#percentage_table_' + item_id).val();
            let expiry_imei_serial = $(this).find('.expiry_imei_serial_' + item_id).text();
            let discount_type = (item_discount.length > 0 && item_discount.substr(item_discount.length - 1) == '%') ? 'percentage' : 'plain';
            let item_price_without_discount = $(this).find('.item_price_without_discount').text();
            let item_seller_id = $(`#item_seller_table${item_id}`).text();
            let item_unit_price = $(this).find('#item_price_table_' + item_id).text();
            let item_quantity = $(this).find('#item_quantity_table_' + item_id).text();
            let item_price_with_discount = $(this).find('#item_total_price_table_' + item_id).text();
            let menu_note = $(this).find('.item_modal_description_table_' + item_id).text();
            let item_discount_amount = (parseFloat(item_price_without_discount) - parseFloat(item_price_with_discount)).toFixed(op_precision);
            let item_description = '';


            let item = {
                menu_note: menu_note,
                menu_taxes: menu_taxes,
                item_seller_id: item_seller_id,
                item_id: item_id,
                item_name: item_name,
                item_discount: item_discount,
                expiry_imei_serial: expiry_imei_serial,
                item_type: item_type_check,
                discount_type: discount_type,
                item_price_without_discount: item_price_without_discount,
                item_unit_price: item_unit_price,
                item_quantity: item_quantity,
                item_price_with_discount: item_price_with_discount,
                item_discount_amount: item_discount_amount,
                is_promo_item: is_promo,
                is_promo_item_exist: freeItemLength,
                promo_item_object: '',
                combo_item: [] 
            };

            orderInfo.items.push(item);
            let itemIndex = orderInfo.items.length - 1; 

            if (freeItemLength > 0) {
                let freeItemName = $(`#free_item_name_table_${item_id}`).text();
                let freeItemQty = $(`#free_item_quantity_table_${item_id}`).text();
                let freeItemId = $(this).find('.free-item').attr('data-free-item-id');
                orderInfo.items.push({
                    item_seller_id: item_seller_id,
                    item_id: freeItemId,
                    item_name: freeItemName,
                    item_last_purchase_price: "",
                    item_vat: "",
                    item_discount: "",
                    expiry_imei_serial: "",
                    item_type: "",
                    discount_type: "",
                    item_price_without_discount: "",
                    item_unit_price: "",
                    item_quantity: freeItemQty,
                    item_price_with_discount: "",
                    item_discount_amount: "",
                    item_details: "",
                    is_promo_item: "",
                    is_promo_item_exist: "",
                    item_description: "",
                });
            }
    
            // Combo Selector
            let combo_cart_item = $(this).find(`.combo_cart_item`).length;
            if (combo_cart_item > 0) {
                $(this).find(`.combo_cart_item`).each(function() {
                    let combo_id = $(this).find('.first_column').attr('data-id');
                    let comboItemQty = $(`#combo_item_quantity_table_${combo_id}`).text();
                    let comboItemPrice = $(`#combo_item_price_table_${combo_id}`).text();
                    let comboItemType = $(`#combo_item_type_table_${combo_id}`).text();
                    let comboItemSubtotal = $(`#free_item_total_price_table_${combo_id}`).text();
                    let comboItemSeller = $(`#combo_seller_table_${combo_id}`).text();
                    let comboItemShowInv = $(`#combo_inv_show_table_${combo_id}`).text();
                    orderInfo.items[itemIndex].combo_item.push({
                        combo_item_id: combo_id,
                        combo_item_type: comboItemType,
                        combo_item_qty: comboItemQty,
                        combo_item_price: comboItemPrice,
                        combo_item_subtotal: comboItemSubtotal,
                        combo_item_seller: comboItemSeller,
                        show_in_invoice: comboItemShowInv,
                    });
                });
            }
        });
        let orderObject = JSON.stringify(orderInfo);
        add_hold_by_ajax(orderObject, hold_number);
        $(".pos__modal__overlay").fadeOut(200);
    });

    // Code optimize by Azhar ** Final **
    function resetDefaultCustomer() {
        let customer_id = $('#walk_in_customer > option:contains("Walk-in Customer")').attr('value');
        $("#walk_in_customer").val(customer_id).trigger("change");
        $('#place_edit_order').text(Place_Order);
    }


    // Code optimize by Azhar ** Final **
    function getAllHoldSales() {
        if(is_offline_system == '1'){
            $.ajax({
                url: base_url + "Sale/get_all_holds_ajax",
                method: "GET",
                success: function (response) {
                    let orders = JSON.parse(response);
                    let held_orders = '';
                    let customer_name = '';
                    let customer_phone = '';
                    for (let key in orders) {
                        customer_name = (orders[key].customer_name == null || orders[key].customer_name == "") ? "&nbsp;" : orders[key].customer_name;
                        customer_phone = (orders[key].customer_phone == null || orders[key].customer_phone == "") ? "&nbsp;" : orders[key].customer_phone;
                        held_orders += `<div class="single_hold_sale fix" id="hold_${orders[key].id}" data-selected="unselected">
                            <div class="first_column column fix">${orders[key].hold_no}</div>
                            <div class="second_column column fix">${customer_name} ${customer_phone ? '(' + customer_phone + ')' : ''}</div>
                            <div class="third_column column fix">${opDateFormat(orders[key].sale_date) + ' ' + orders[key].sale_time} </div>
                        </div>`;
                    }
                    $(".hold_list_holder .detail_holder ").empty();
                    $(".hold_list_holder .detail_holder ").prepend(held_orders);
                }
            });
        }else{
            let db;
            const request = indexedDB.open("off_pos_3", 3);
            request.onerror = function(event) {
                console.error("Database error: " + event.target.error);
            };
            request.onsuccess = function(event) {
                db = event.target.result;
                const transaction = db.transaction(["draft_sales"], "readonly");
                const objectStore = transaction.objectStore("draft_sales");
                const getAllRequest = objectStore.getAll();
                getAllRequest.onerror = function(event) {
                    console.log("Error fetching draft sales:", event.target.error);
                };
                getAllRequest.onsuccess = function(event) {
                    const orders = event.target.result;
                    let held_orders = '';
                    let order = '';
                    let customer_phone = '';
                    for (let key in orders) {
                        order = orders[key];
                        customer_phone = (order.order.customer_phone_number == null || order.order.customer_phone_number == 'null' || order.order.customer_phone_number == "") ? '' : order.order.customer_phone_number;

                        held_orders += `<div class="single_hold_sale fix" id="hold_${order.id}" data-selected="unselected">
                            <div class="first_column column fix">${order.holdNumber}</div>
                            <div class="second_column column fix">${order.order.customer_name} ${customer_phone != '' ? '(' + customer_phone + ')' : ''}</div>
                            <div class="third_column column fix">${opDateFormat(order.order.sale_date) + ' ' + order.order.sale_time}</div>
                        </div>`;
                    }
                    $(".hold_list_holder .detail_holder").empty();
                    $(".hold_list_holder .detail_holder").prepend(held_orders);
                };
            };
        } 
    }
 
    // Code optimize by Azhar ** Final **
    function printInvoice(sale_id) {
        if(invoice_print=="live_server_print"){
            $.ajax({
                url: base_url + "Authentication/callPrintServer",
                method: "post",
                dataType: "json",
                data: {
                    sale_id: sale_id,
                },
                success: function (data) {
                    if (data.printer_server_url) {
                        $.ajax({
                            url: data.printer_server_url + "print_server/off_pos_printer_server.php",
                            method: "post",
                            dataType: "json",
                            data: {
                                content_data: JSON.stringify(data.content_data), print_type:data.print_type,
                            },
                            success: function (data) {},
                            error: function () {},
                        });
                    }
                }
            });
        }else{
            if (print_format == "56mm") {
                open(base_url+"Sale/print_invoice/" + sale_id, 'Print Invoice', 'width=480,height=550');
            }else if (print_format == "80mm") {
                open(base_url+"Sale/print_invoice/" + sale_id, 'Print Invoice', 'width=685,height=550');
            } else if (print_format == "A4 Print") {
                open(base_url+"Sale/print_invoice/" + sale_id, 'Print Invoice', 'width=1600,height=550');
            } else if (print_format == "Half A4 Print") {
                open(base_url+"Sale/print_invoice/" + sale_id, 'Print Invoice', 'width=1600,height=550');
            }else if (print_format == "Letter Head") {
                open(base_url+"Sale/print_invoice/" + sale_id, 'Print Invoice', 'width=1600,height=550');
            }
            $("#finalize_order_cancel_button").click();
        }
    }

    // Code optimize by Azhar ** Final **
    function printChallan(sale_id) {
        open(base_url +"Sale/print_challan/" + sale_id, 'Print Challan', 'width=1600,height=550');
        $("#finalize_order_cancel_button").click();
    }

    // Code optimize by Azhar ** Final **
    function getDetailsOfParticularHold(hold_id) {
        if(is_offline_system == '1'){
            let row_number = $('#modal_item_row').html();
            $.ajax({
                url: base_url + "Sale/get_single_hold_info_by_ajax",
                method: "POST",
                async: false,
                data: {
                    hold_id: hold_id,
                    csrf_offpos: csrf_value_
                },
                success: function (response) {
                    response = JSON.parse(response);
                    hold_id = response.id;
                    let draw_table_for_order = '';
                    let itemQty = 0;
                    let totalItem = 0;
                    let item_object;
                    let key;
                    let readonlyAttr = '';
                    let expiry_imei_serial = '';
                    let promotionHtml = '';
                    for (key in response.items) {
                        item_object = response.items[key];

                        let comboHtml = '';
                        let item_unit_price = 0;
                        if(item_object.item_type == 'Combo_Product'){
                            item_unit_price = item_object.menu_price_with_discount;

                            $.ajax({
                                type: "POST",
                                url: base_url+"Sale/getAllHoldComboItems",
                                async: false,
                                data: {
                                    hold_item_id: item_object.id
                                },
                                dataType: "JSON",
                                success: function (response) {
                                    
                                    let comboName = 0;
                                    let comboQty = 0;
                                    let comboUnitPrice = 0;
                                    let combSubTotal = 0;
                                    let combChildId = '';
                                    let comboType = '';
                                    let combParentId = '';
                                    let combSellerId = '';
                                    let combIFSale = '';
                                    let combItemShownInInvoice = '';

                                    $.each(response.data, function (ind, val) { 
                                        comboName = val.item_name;
                                        comboType = val.combo_item_type;
                                        comboQty = val.combo_item_qty;
                                        comboUnitPrice = val.combo_item_price;
                                        combSubTotal = parseFloat(parseFloat(comboUnitPrice) * parseFloat(comboQty)).toFixed(op_precision);
                                        combChildId = val.combo_item_id;
                                        combParentId = item_object.food_menu_id;
                                        combSellerId = val.combo_item_seller_id;
                                        combIFSale = true;
                                        combItemShownInInvoice = val.show_in_invoice == 'Yes' ? true : false;

                                        if(combIFSale){
                                            comboHtml +=`<div class="${ind == 0 ? 'mt_6' : ''} combo_cart_item combo_item_div_${combChildId}"  data-is_combo="Yes">
                                                <div data-id="${combChildId}" class="customer_panel single_order_column first_column">
                                                    <iconify-icon icon="solar:pen-broken" class="op_cursor_pointer" width="22" data-parent_id=""></iconify-icon>
                                                    <span id="combo_item_name_table_${combChildId}">${comboName}</span>
                                                    <span id="combo_item_type_table_${combChildId}">${comboType}</span>
                                                    <span class="d-none" id="combo_seller_table_${combChildId}">${combSellerId}</span>
                                                    <span class="d-none" id="combo_inv_show_table_${combChildId}">${combItemShownInInvoice ? 'Yes' : 'No'}</span>
                                                    <span class="d-none" id="combo_ifsale_table_${combChildId}">${combIFSale ? 'Yes' : 'No'}</span>
                                                </div>
                                                <div class="single_order_column second_column text-center"> 
                                                    <span id="combo_item_price_table_${combChildId}">${parseFloat(comboUnitPrice).toFixed(op_precision)}</span>
                                                </div>
                                                <div class="single_order_column third_column">
                                                    <iconify-icon icon="uil:minus" class="alert_combo_item_increase op_cursor_pointer decrease_item_table" id="combo_decrease_item_table_${combChildId}" width="22"></iconify-icon>
                                                    <span class="4_cp_qty_${combChildId} qty_item_custom cart_quantity" id="combo_item_quantity_table_${combChildId}">${parseFloat(comboQty)}</span> 
                                                    <iconify-icon icon="bitcoin-icons:plus-outline" class="alert_combo_item_increase op_cursor_pointer" id="increase_item_table_${combChildId}" width="22"></iconify-icon>
                                                </div>
                                                <div class="single_order_column forth_column">
                                                    <input type="" name="" onfocus="select();" placeholder="Amt or %" class="discount_cart_input" value="0" disabled>
                                                </div>
                                                <div class="single_order_column fifth_column text-right"> 
                                                    <span id="combo_item_total_price_table_${combChildId}">${parseFloat(combSubTotal).toFixed(op_precision)}</span>
                                                    <iconify-icon icon="solar:trash-bin-minimalistic-broken" data-id="${combChildId}" class="combo-item-remove removeCartItemCombo"></iconify-icon>
                                                </div>
                                            </div>`;
                                        }
                                    });
                                }
                            });
                            
                        }else {
                            item_unit_price = item_object.menu_unit_price;
                        }


                        itemQty += Number(item_object.qty);
                        totalItem++;
                        
                        if(item_object.item_type == 'IMEI_Product' || item_object.item_type == 'Serial_Product'|| item_object.item_type == 'Medicine_Product'){
                            expiry_imei_serial = `<span class="imei_serial_note" id="expiry_imei_serial">${checkItemShortType(item_object.item_type)}: <span class="expiry_imei_serial_${item_object.food_menu_id}">${item_object.expiry_imei_serial}</span></span>`;
                        }else{
                            expiry_imei_serial = '';
                        }
                        if(item_object.is_promo_item == 'Yes'){
                            if(item_object.promo_item_object){
                                let jsonObj = jQuery.parseJSON(item_object.promo_item_object);
                                let itemPromoNo = parseInt(Number(item_object.qty) / Number(jsonObj.promo_item_buy_qty)) * parseInt(jsonObj.promo_item_get_qty);
                                readonlyAttr = 'readonly';
                                if(itemPromoNo > 0){
                                    promotionHtml =`<div class="free-item free_item_div_${item_object.food_menu_id}" data-free-item-id="${jsonObj.promo_item_id}" data-get_fm_id="${item_object.food_menu_id}" data-is_free="Yes">
                                        <div data-id="${item_object.food_menu_id}" class="customer_panel single_order_column first_column">
                                            <iconify-icon icon="solar:pen-broken" width="22" data-parent_id=""></iconify-icon>
                                            <span id="free_item_name_table_${item_object.food_menu_id}">${jsonObj.promo_item_name}</span>
                                            <span class="d-none" id="free_item_buy_table_${item_object.food_menu_id}">${jsonObj.promo_item_buy_qty}</span>
                                            <span class="d-none" id="free_item_get_table_${item_object.food_menu_id}">${jsonObj.promo_item_get_qty}</span>
                                        </div>
                                        <div class="single_order_column second_column text-center"> 
                                            <span id="free_item_price_table_${item_object.food_menu_id}">${Number(0).toFixed(op_precision)}</span>
                                        </div>
                                        <div class="single_order_column third_column">
                                            <iconify-icon icon="uil:minus" class="alert_free_item_increase op_cursor_pointer decrease_item_table" id="free_decrease_item_table_${item_object.food_menu_id}" width="22"></iconify-icon>
                                            <span class="4_cp_qty_${item_object.food_menu_id} qty_item_custom cart_quantity" id="free_item_quantity_table_${item_object.food_menu_id}">${jsonObj.promo_item_get_qty}</span> 
                                            <iconify-icon icon="uil:plus" class="increase_item_table"></iconify-icon>
                                        </div>
                                        <div class="single_order_column forth_column">
                                            <input type="" name="" onfocus="select();" placeholder="Amt or %" class="discount_cart_input" value="${Number(0)}" disabled>
                                        </div>
                                        <div class="single_order_column fifth_column text-right"> 
                                            <span id="free_item_total_price_table_${item_object.food_menu_id}">${Number(0).toFixed(op_precision)}</span>
                                            <iconify-icon icon="solar:trash-bin-minimalistic-broken" data-id="${item_object.food_menu_id}" class="free-item-remove removeCartItemFree"></iconify-icon>
                                        </div>
                                    </div>`;
                                }
                            }
                        }else{
                            promotionHtml = ''
                        }

                        draw_table_for_order +=`<div data-variation-parent="${item_object.parent_id}" class="single_order" is_promo="${item_object.is_promo_item}" data-qty_default="1" data-sale-unit="${item_object.unit_name}" id="order_for_item_${item_object.food_menu_id}" data-single-order-row-no="" data_cart_item_id="${item_object.food_menu_id}">
                            <div class="first_portion">
                                <span class="d-none" id="item_seller_table${item_object.food_menu_id}">${item_object.item_seller_id}</span>
                                <span class="item_type d-none" id="item_type_table${item_object.food_menu_id}">${item_object.item_type}</span>
                                <span class="item_vat d-none" id="item_vat_percentage_table${item_object.food_menu_id}">${item_object.menu_taxes ? item_object.menu_taxes : ''}</span>
                                <span class="item_discount d-none" id="item_discount_table${item_object.food_menu_id}">${item_object.discount_amount}</span>
                                <span class="item_price_without_discount d-none" id="item_price_without_discount_${item_object.food_menu_id}">${parseFloat(item_unit_price).toFixed(op_precision)}</span>
                                <div class="single_order_column first_column">
                                    <iconify-icon icon="solar:pen-broken" class="op_cursor_pointer edit_item" id="edit_item_${item_object.food_menu_id}" width="22"></iconify-icon>
                                    <span id="item_name_table_${item_object.food_menu_id}">${ (item_object.parent_name ? item_object.parent_name + ' ' : '') + item_object.item_name +'('+ item_object.code +')'}</span>
                                </div>
                                <div class="single_order_column second_column">
                                    <span id="item_price_table_${item_object.food_menu_id}">${parseFloat(item_unit_price).toFixed(op_precision)}</span>
                                </div>
                                <div class="single_order_column third_column">
                                    <iconify-icon icon="uil:minus" class="decrease_item_table op_cursor_pointer" id="decrease_item_table_${item_object.food_menu_id}" width="22"></iconify-icon>
                                    <span class="cart_quantity" id="item_quantity_table_${item_object.food_menu_id}">${item_object.qty}</span> 
                                    <iconify-icon icon="uil:plus" class="increase_item_table op_cursor_pointer" id="increase_item_table_${item_object.food_menu_id}" width="22"></iconify-icon>
                                </div>
                                <div class="single_order_column forth_column">
                                    <input type="text" name="" onfocus="select();" placeholder="Amt or %" inline_dis_column="${item_object.food_menu_id}" class="special_textbox access_control inline_dis_column" id="percentage_table_${item_object.food_menu_id}" value="${item_object.menu_discount_value == '' ? Number(0) : item_object.menu_discount_value}">
                                </div>
                                <div class="single_order_column fifth_column">
                                    <span id="item_total_price_table_${item_object.food_menu_id}">${parseFloat(item_object.menu_price_with_discount).toFixed(op_precision)}</span> 
                                    <iconify-icon icon="solar:trash-bin-minimalistic-broken" data-remove-order-row-no="0" class="remove_this_item_from_cart" width="22"></iconify-icon>
                                </div>
                            </div>
                            ${expiry_imei_serial}
                            ${comboHtml}
                            <span class="cart_item_modal_des item_modal_description_table_${item_object.food_menu_id}">${item_object.menu_note}</span>
                            ${promotionHtml}
                        </div>`;
                    }
                    
                    $(".order_holder").prepend(draw_table_for_order);
                    $("#is_hold_sale_id").text(hold_id);
                    $("#total_items_in_cart").text(response.total_items);
                    $("#sub_total_show").text(Number(response.sub_total).toFixed(op_precision));
                    $("#show_charge_amount").text(Number(response.delivery_charge).toFixed(op_precision));
                    $("#sub_total").text(Number(response.sub_total).toFixed(op_precision));
                    $("#show_vat_modal").text(Number(response.vat).toFixed(op_precision));
                    $("#show_discount_amount").text(Number(response.sub_total_discount_amount).toFixed(op_precision));
                    $("#total_item_discount").text(Number(response.total_item_discount_amount).toFixed(op_precision));
                    $("#discounted_sub_total_amount").text(Number(response.sub_total_discount_amount).toFixed(op_precision));
                    $("#sub_total_discount").val(Number(response.sub_total_discount_value));
                    $("#sub_total_discount_amount").text(response.sub_total_with_discount);
                    $("#all_items_discount").text(Number(response.total_discount_amount).toFixed(op_precision));
                    $("#delivery_charge").val(Number(response.delivery_charge));
                    $("#total_payable").text(Number(response.total_payable).toFixed(op_precision));
                    $('#total_items_in_cart_without_quantity').html(totalItem);
                    $('#total_items_in_cart_with_quantity').html(itemQty);
                    $('#delivery_partner_info').attr('data-partner-id',response.delivery_partner_id);
                    $('#delivery_partner_info').text(response.partner_name);
                    $('#rounding').text(response.rounding);
                    // Clear holdsale and recent sale modal data
                    holdSaleModalDataClear();
                    recentSaleModalDataClear();
                    $('#show_sale_hold_modal').removeClass('active');
                    $(".pos__modal__overlay").fadeOut(300);
                    if (response.customer_id == "" || response.customer_id == 0 || response.customer_id == null) {
                        // Function to change the selected option based on data-customer-name attribute
                        function selectCustomerByName(customerName) {
                            $('#walk_in_customer option').each(function() {
                                if ($(this).data('customer-name') == customerName) {
                                    $(this).prop('selected', true);
                                    $('#walk_in_customer').trigger('change'); // Trigger change event if needed
                                    return false; // Break the loop once the option is found and selected
                                }
                            });
                        }
                        // Call the function to select "Walk-in Customer"
                        selectCustomerByName('Walk-in Customer');
                    } else {
                        $("#walk_in_customer").val(response.customer_id).trigger("change");
                        setTimeout(function(){
                            $('#draft_sale_customer_status').val('No');
                        }, 300);
                    }
                    if (response.employee_id == "" || response.employee_id == 0 || response.employee_id == null) {
                    } else {
                        $("#select_employee_id").val(response.employee_id).trigger("change");
                    }
                }
            });
        }else{
            let request = indexedDB.open('off_pos_3', 3);
            request.onerror = function(event) {
                console.error("Database error: " + event.target.error);
            };
            request.onsuccess = function(event) {
                let db = event.target.result;
                let transaction = db.transaction(['draft_sales'], 'readonly');
                let objectStore = transaction.objectStore('draft_sales');
                let getRequest = objectStore.get(parseInt(hold_id));
                
                getRequest.onerror = function(event) {
                    console.error("Error fetching data: " + event.target.error);
                };
                
                getRequest.onsuccess = function(event) {
                    let data = event.target.result;
                    if (data && data.order) {
                        let orderInfo = data.order;
                        // Clear existing orders
                        $(".order_holder").empty();
                        // Populate order holder with retrieved data
                        let draw_table_for_order = '';
                        let totalItem = 0;
                        let itemQty = 0;
                        let expiry_imei_serial = '';
                        let comboHtml = '';
                        let promotionHtml = '';
                        let readonlyAttr = '';
                        if (orderInfo.items && Array.isArray(orderInfo.items)) {
                            let row_key = 0;
                            
                            for (let key in orderInfo.items) {
                                row_key++


                                let single_item = orderInfo.items[key];
                                totalItem++;
                                itemQty += parseFloat(single_item.item_quantity);
                                if(single_item.item_type == 'IMEI_Product' || single_item.item_type == 'Serial_Product'|| single_item.item_type == 'Medicine_Product'){
                                    expiry_imei_serial = `<span class="imei_serial_note" id="expiry_imei_serial">${checkItemShortType(single_item.item_type)}: <span class="expiry_imei_serial_${single_item.item_id}">${single_item.expiry_imei_serial}</span></span>`;
                                }else{
                                    expiry_imei_serial = '';
                                }


                                if(single_item.is_promo_item == 'Yes'){
                                    if(single_item.promo_item_object){
                                        let jsonObj = jQuery.parseJSON(single_item.promo_item_object);
                                        let itemPromoNo = parseInt(Number(single_item.item_quantity) / Number(jsonObj.promo_item_buy_qty)) * parseInt(jsonObj.promo_item_get_qty);
                                        readonlyAttr = 'readonly';
                                        if(itemPromoNo > 0){
                                            promotionHtml =`<div class="free-item free_item_div_${single_item.item_id}" data-free-item-id="${jsonObj.promo_item_id}" data-get_fm_id="${single_item.item_id}" data-is_free="Yes">
                                                <div data-id="${single_item.item_id}" class="customer_panel single_order_column first_column">
                                                    <iconify-icon icon="solar:pen-broken" width="22" data-parent_id=""></iconify-icon>
                                                    <span id="free_item_name_table_${single_item.item_id}">${jsonObj.promo_item_name}</span>
                                                    <span class="d-none" id="free_item_buy_table_${single_item.item_id}">${jsonObj.promo_item_buy_qty}</span>
                                                    <span class="d-none" id="free_item_get_table_${single_item.item_id}">${jsonObj.promo_item_get_qty}</span>
                                                </div>
                                                <div class="single_order_column second_column text-center"> 
                                                    <span id="free_item_price_table_${single_item.item_id}">${Number(0).toFixed(op_precision)}</span>
                                                </div>
                                                <div class="single_order_column third_column">
                                                    <iconify-icon icon="uil:minus" class="alert_free_item_increase op_cursor_pointer decrease_item_table" id="free_decrease_item_table_${single_item.item_id}" width="22"></iconify-icon>
                                                    <span class="4_cp_qty_${single_item.item_id} qty_item_custom cart_quantity" id="free_item_quantity_table_${single_item.item_id}">${jsonObj.promo_item_get_qty}</span> 
                                                    <iconify-icon icon="uil:plus" class="increase_item_table"></iconify-icon>
                                                </div>
                                                <div class="single_order_column forth_column">
                                                    <input type="" name="" onfocus="select();" placeholder="Amt or %" class="discount_cart_input" value="${Number(0)}" disabled>
                                                </div>
                                                <div class="single_order_column fifth_column text-right"> 
                                                    <span id="free_item_total_price_table_${single_item.item_id}">${Number(0).toFixed(op_precision)}</span>
                                                    <iconify-icon icon="solar:trash-bin-minimalistic-broken" data-id="${single_item.item_id}" class="free-item-remove removeCartItemFree"></iconify-icon>
                                                </div>
                                            </div>`;
                                        }
                                    }
                                }else{
                                    promotionHtml = ''
                                }


                                draw_table_for_order +=`<div data-variation-parent="" class="single_order" is_promo="" data-qty_default="1" data-sale-unit="" id="order_for_item_${single_item.item_id}" data-single-order-row-no="${row_key}" data_cart_item_id="${single_item.item_id}">
                                    <div class="first_portion">
                                        
                                        <span class="d-none" id="item_seller_table${single_item.item_id}"></span>
                                        <span class="item_type d-none" id="item_type_table${single_item.item_id}">${single_item.item_type}</span>
                                        <span class="item_vat d-none" id="item_vat_percentage_table${single_item.item_id}">${single_item.menu_taxes ? single_item.menu_taxes : ''}</span>
                                        <span class="item_discount d-none" id="item_discount_table${single_item.item_id}">${single_item.item_discount_amount}</span>
                                        <span class="item_price_without_discount d-none" id="item_price_without_discount_${single_item.item_id}">${parseFloat(single_item.item_price_without_discount).toFixed(op_precision)}</span>
                                        <div class="single_order_column first_column">
                                            <iconify-icon icon="solar:pen-broken" class="op_cursor_pointer edit_item" id="edit_item_${single_item.item_id}" width="22"></iconify-icon>
                                            <span id="item_name_table_${single_item.item_id}">${single_item.item_name}</span>
                                        </div>
                                        <div class="single_order_column second_column">
                                            <span id="item_price_table_${single_item.item_id}">${parseFloat(single_item.item_unit_price).toFixed(op_precision)}</span>
                                        </div>
                                        <div class="single_order_column third_column">
                                            <iconify-icon icon="uil:minus" class="decrease_item_table op_cursor_pointer" id="decrease_item_table_${single_item.item_id}" width="22"></iconify-icon>
                                            <span class="cart_quantity" id="item_quantity_table_${single_item.item_id}">${single_item.item_quantity}</span> 
                                            <iconify-icon icon="uil:plus" class="increase_item_table op_cursor_pointer" id="increase_item_table_${single_item.item_id}" width="22"></iconify-icon>
                                        </div>
                                        <div class="single_order_column forth_column">
                                            <input type="text" name="" onfocus="select();" placeholder="Amt or %" inline_dis_column="${single_item.item_id}" class="special_textbox access_control inline_dis_column" id="percentage_table_${single_item.item_id}" value="${single_item.item_discount == '' ? Number(0) : single_item.item_discount}">
                                        </div>
                                        <div class="single_order_column fifth_column">
                                            <span id="item_total_price_table_${single_item.item_id}">${parseFloat(single_item.item_price_with_discount).toFixed(op_precision)}</span> 
                                            <iconify-icon icon="solar:trash-bin-minimalistic-broken" data-remove-order-row-no="${row_key}" class="remove_this_item_from_cart" width="22"></iconify-icon>
                                        </div>
                                    </div>
                                    ${expiry_imei_serial}
                                    ${comboHtml}
                                    <span class="cart_item_modal_des item_modal_description_table_${single_item.item_id}">${single_item.menu_note}</span>
                                    ${promotionHtml}
                                </div>`;



                            }
                            $(".order_holder").prepend(draw_table_for_order);
                            // Update cart summary
                            $("#total_items_in_cart").text(orderInfo.total_items_in_cart);
                            $("#sub_total_show").text(Number(orderInfo.sub_total).toFixed(op_precision));
                            $("#show_charge_amount").text(Number(orderInfo.delivery_charge).toFixed(op_precision));
                            $("#sub_total").text(Number(orderInfo.sub_total).toFixed(op_precision));
                            $("#show_vat_modal").text(Number(orderInfo.total_vat).toFixed(op_precision));
                            $("#show_discount_amount").text(Number(orderInfo.sub_total_discount_amount).toFixed(op_precision));
                            $("#total_item_discount").text(Number(orderInfo.total_item_discount_amount).toFixed(op_precision));
                            $("#discounted_sub_total_amount").text(Number(orderInfo.sub_total_discount_amount).toFixed(op_precision));
                            $("#sub_total_discount").val(Number(orderInfo.sub_total_discount_value));
                            $("#sub_total_discount_amount").text(orderInfo.sub_total_with_discount);
                            $("#all_items_discount").text(Number(orderInfo.total_discount_amount).toFixed(op_precision));
                            $("#delivery_charge").val(Number(orderInfo.delivery_charge));
                            $("#total_payable").text(Number(orderInfo.total_payable).toFixed(op_precision));
                            $('#total_items_in_cart_without_quantity').html(totalItem);
                            $('#total_items_in_cart_with_quantity').html(itemQty);
                            $('#delivery_partner_info').attr('data-partner-id', orderInfo.delivery_partner);
                            $('#rounding').text(orderInfo.rounding);
                            // Set customer and employee
                            if (orderInfo.customer_id) {
                                $("#walk_in_customer").val(orderInfo.customer_id).trigger("change");
                            } else {
                                selectCustomerByName('Walk-in Customer');
                            }
                            if (orderInfo.select_employee_id) {
                                $("#select_employee_id").val(orderInfo.select_employee_id).trigger("change");
                            }
                            // Clear modals
                            holdSaleModalDataClear();
                            recentSaleModalDataClear();
                            $('#show_sale_hold_modal').removeClass('active');
                            $(".pos__modal__overlay").fadeOut(300);
                        } else {
                            console.error("Invalid or missing items array in orderInfo");
                        }
                    } else {
                        console.log("No data found for the given hold number");
                    }
                };
            };
        }
    }


    // Code optimize by Azhar ** Final **
    //remove last digits if number is more than 2 digits after decimal
    function removeLastTwoDigitWithPercentage(value, object_element) {
        if (value.length > 0 && value.indexOf('.') > 0) {
            let percentage = false;
            let number_without_percentage = value;
            if (value.indexOf('%') > 0) {
                percentage = true;
                number_without_percentage = value.toString().substring(0, value.length - 1);
            }
            let number = number_without_percentage.split('.');
            if (number[1].length > 2) {
                let value = parseFloat(Math.floor(number_without_percentage * 100) / 100);
                let add_percentage = (percentage) ? '%' : '';
                if (isNaN(value)) {
                    object_element.val('');
                } else {
                    object_element.val(value.toString() + add_percentage);
                }

            }
        }
    }


    



    // Code optimize by Azhar ** Final **
    //remove last digits if number is more than 2 digits after decimal
    function removeLastTwoDigitWithoutPercentage(value, object_element) {
        if (value.length > 0 && value.indexOf('.') > 0) {
            let percentage = false;
            let number_without_percentage = value;
            if (value.indexOf('%') > 0) {
                percentage = true;
                number_without_percentage = value.toString().substring(0, value.length - 1);
            }
            let number = number_without_percentage.split('.');
            if (number[1].length > 2) {
                let value = parseFloat(Math.floor(number_without_percentage * 100) / 100);
                let add_percentage = (percentage) ? '%' : '';
                if (isNaN(value)) {
                    object_element.val('');
                } else {
                    object_element.val(value.toString() + add_percentage);
                }
            }
        }
    }


    // Code optimize by Azhar ** Final **
    function resetFinalizeModal() {
        $('#finalize_total_payable').text(Number(0).toFixed(op_precision));
        $("#finalize_order_modal").removeClass("active");
        $(".pos__modal__overlay").fadeOut(300);
        $('#payment_list_div').html('');
        $("#finalie_order_payment_method option:contains(Cash)").attr('selected', true);
        let selected_id = ($("#finalie_order_payment_method option:contains(Cash)").val());
        $("#finalie_order_payment_method").val(selected_id).change();
        $('#pay_amount_invoice_input').val('');
        $('#due_amount_invoice_input').val('');
        $('#modal_finalize_sale_id').html('');
        $('#send_invoice_sms').prop('checked', false);
        $('#send_invoice_email').prop('checked', false);
        $('#finalie_order_payment_method').css('border', '1px solid #B5D6F6');
    }

    

    // Code optimize by Azhar ** Final **
    $(document).on("click", ".overlayForCalculator", function (e) {
        $("#calculator_main").fadeOut(333);
        $(".overlayForCalculator").fadeOut(111);
        $(".main_left").removeClass("active");
        if ($("#show_running_order").attr("data-isActive") === "false") {
            $("#show_running_order").attr("data-isActive", "true");
        } else {
            $("#show_running_order").attr("data-isActive", "false");
        }
    });



    // Code optimize by Azhar ** Final **
    function IsJsonString(str) {
        try {
            JSON.parse(str);
        } catch (e) {
            return false;
        }
        return true;
    }


    // Code optimize by Azhar ** Final **
    function getCustomerForEdit(customer_id) {
        $.ajax({
            url: base_url + "Sale/get_customer_ajax",
            method: "POST",
            data: {
                customer_id: customer_id,
                csrf_offpos: csrf_value_
            },
            success: function (response) {
                response = JSON.parse(response);
                $('#customer_id_modal').val(response.id);
                $('#customer_name_modal').val(response.name);
                $('#customer_phone_modal').val(response.phone);
                $('#customer_nid_modal').val(response.nid);
                $('#customer_email_modal').val(response.email);
                $('#customer_dob_modal').val(response.date_of_birth);
                $('#customer_doa_modal').val(response.date_of_anniversary);
                $('#customer_previous_due_modal').val(response.opening_balance);
                $('#opening_balance_type').val(response.opening_balance_type);
                $('#customer_credit_limit_modal').val(response.credit_limit);
                $('#customer_delivery_address_modal').val(response.address);
                if(response.group_id != 0){
                    $('#customer_group_id_modal').val(response.group_id).change();
                }else{
                    $('#customer_group_id_modal').val('').change();
                }
                $('#customer_discount_modal').val(response.discount).change();
                $('#customer_price_type').val(response.price_type).change();
                if (collect_gst == "Yes") {
                    let gst_no = (response.gst_number == null || response.gst_number == '') ? '' : response.gst_number;
                    $('#customer_gst_number_modal').val(response.gst_number);
                    $('#same_or_diff_state').val(response.same_or_diff_state).change();
                }
                $('#add_customer_modal').addClass('active');
                $('.pos__modal__overlay').fadeIn();
            }
        });
    }

    // Code optimize by Azhar ** Final **
    function findItemByItemId(item_id) {
        let single_item = window.items.find(item => item.item_id == item_id);
        return single_item;
    }
    function findItemInfoByItemCode(item_code) {
        let single_item = window.items.find(item => item.item_code == item_code);
        return single_item;
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
    // Code optimize by Azhar ** Final **
    $(document).on("keyup", "#finalize_given_amount_input", function (e) {
        let this_value = $.trim($(this).val());
        if (isNaN(this_value)) {
            $(this).val('');
        }
        let finalize_total_payable = Number($("#finalize_total_due").text());
        if (isNaN(this_value)) {
            this_value = 0;
        }
        let change_amount = (parseFloat(this_value) - parseFloat(finalize_total_payable));
        change_amount = change_amount && change_amount > 0 ? change_amount : 0;
        if (isNaN(change_amount)) {
            change_amount = 0;
        }
        if(this_value == ''){
            $("#finalize_change_amount_input").val(0);
        }else{
            $("#finalize_change_amount_input").val(parseFloat(change_amount).toFixed(op_precision));
        }
        let finalize_amount = parseFloat(this_value) - parseFloat(change_amount);
        if (isNaN(finalize_amount)) {
            finalize_amount = 0;
        }
        $("#finalize_amount_input").val(finalize_amount.toFixed(op_precision));
        checkCashPayment(finalize_amount, 'No');
    });

    // Code optimize by Azhar ** Final **
    $(document).on("click", ".cancel_modal", function () {
        $(this)
        .parent()
        .parent()
        .parent()
        .removeClass("active")
        .addClass("inActive");
        setTimeout(function () {
            $(".modal").removeClass("inActive");
        }, 1000);
    });

    
    // Code optimize by Azhar ** Final **
    let soundBody = $('body');
    let productSound1 = new Howl({
        src: [base_url + 'assets/media/access.mp3']
    });


    // Code optimize by Azhar ** Final **
    let productSound2 = new Howl({
        src: [base_url + 'assets/media/click.mp3']
    });


    // Code optimize by Azhar ** Final **
    let productSound3 = new Howl({
        src: [base_url + 'assets/media/erase.mp3']
    });

    // Code optimize by Azhar ** Final **
    let alert_sound = new Howl({
        src: [base_url + 'assets/media/alert_alarm.mp3']
    });

    
    // Code optimize by Azhar ** Final **
    soundBody.on('click','.cardBtn',function(){
        productSound1.play();
    });

    // Code optimize by Azhar ** Final **
    soundBody.on('click', '.dd', function () {
        productSound2.play();
    });
    
    // Code optimize by Azhar ** Final **
    soundBody.on('click', '.ii', function () {
        productSound2.play();
    });

    // Code optimize by Azhar ** Final **
    tippy("[data-tippy-content]", {
        // animation: "scale",
    });


    // Code optimize by Azhar ** Final **
    tippy('.time__date', {
        content: '<div class="text-center"><time>21-04-2021</time><br><time>12:23 AM</time></div>',
        allowHTML: true,
        animation: 'scale'
    });

    // Code optimize by Azhar ** Final **
    const ps2 = new PerfectScrollbar('.category_items', {
        wheelSpeed: 2,
        wheelPropagation: true,
        minScrollbarLength: 20
    });
    ps2.update();


    // Code optimize by Azhar ** Final **
    $(document).on("click", ".main_menu", function (e) {
        $(this).children(".sub__menu").toggle();
        $(".languages").children(".sub__menu").hide(100);
        $(document).find('.submenu-wrapper').hide()
    });


    // Code optimize by Azhar ** Final **
    $(document).on("click", ".languages", function (e) {
        $(this).children(".sub__menu").toggle();
        $(".main_menu").children(".sub__menu").hide(100);
        $(document).find('.submenu-wrapper').hide()
    });


    // Code optimize by Azhar ** Final **
    $(window).click(function (event) {
        if ($(event.target).closest("li.has__children").length === 0) {
            $(".has__children").children(".sub__menu").hide();
            $(".has__children").children(".submenu-wrapper").hide();
        }
    });


    // Code optimize by Azhar ** Final **
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


    // Code optimize by Azhar ** Final **
    $(document).on("click", ".fullscreen", function (e) {
        toggleFullscreen();
        $(this).attr("data-tippy-content", "");
        if ($(this).find("i").hasClass("fa-expand-arrows-alt")) {
            $(this)
                .find("i")
                .removeClass("fa-expand-arrows-alt")
                .addClass("fa-times");
            $(this).attr("data-tippy-content", fullscreen_2);
        } else {
            $(this)
                .find("i")
                .removeClass("fa-times")
                .addClass("fa-expand-arrows-alt");
            $(this).attr("data-tippy-content", fullscreen_1);
        }
        tippy(".fullscreen", {
            // animation: "scale",
        });
    });


    // Code optimize by Azhar ** Final **
    let open_invoice_date_hidden = $("#open_invoice_date_hidden").val();
    $(".datepicker_custom").datepicker({
            autoclose: true,
            format: "yyyy-mm-dd",
            // startDate: "0",
            todayHighlight: true,
    }).datepicker("update", open_invoice_date_hidden);


    // Code optimize by Azhar ** Final **
    $(".datepicker_custom").on("changeDate", function (event) {
        $("#sale_date1").val(event.format());
    });


    // Code optimize by Azhar ** Final **
    $(document).on("click", ".pos__modal__overlay", function () {
        $(".pos__modal__overlay").fadeOut(300);
        $("aside#pos__sidebar").removeClass("active");
        $(".modal").removeClass("active");
    });


    // Code optimize by Azhar ** Final **
    $(document).on("click", "#open_discount_modal", function () {
        if(is_offline_system == '1'){
            let sub_total_discount_finalize = $('#sub_total_discount_finalize').val();
            if(sub_total_discount_finalize){
                toastr['error'](('Finalize Discount already given'), '');
            }else{
                let varified_status = $('.discount_permission_code').attr('varified-status');
                if(session_uer_id == '1' && role == '1'){
                    $('.discount_field').show();
                    $('.discunt_check_modal').hide();
                    $.ajax({
                        url: base_url + "Master/checkAccess",
                        method: "GET",
                        async: false,
                        dataType: 'json',
                        data: { controller: "287", function: "discountPermission" },
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
                                let discount = $('#walk_in_customer option:selected').attr('discount');
                                if(discount == 0 || discount == ''){
                                    $("#discount_modal").addClass("active");
                                    $(".pos__modal__overlay").fadeIn(300);
                                }else{
                                    toastr['error'](('This customer has already default discount!'), '');
                                }
                            }
                        }
                    });
    
                }else{
                    if(varified_status == 'Yes'){
                        $('.discount_field').show();
                        $('.discunt_check_modal').hide();
                    }else{
                        $('.discount_field').hide();
                        $('.discount_err_message').parent().hide();
                    }
                    $.ajax({
                        url: base_url + "Master/checkAccess",
                        method: "GET",
                        async: false,
                        dataType: 'json',
                        data: { controller: "287", function: "discountPermission" },
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
                                let discount = $('#walk_in_customer option:selected').attr('discount');
                                if(discount == 0 || discount == ''){
                                    $("#discount_modal").addClass("active");
                                    $(".pos__modal__overlay").fadeIn(300);
                                }else{
                                    toastr['error'](('This customer has already default discount!'), '');
                                }
                            }
                        }
                    });
                }
            }
        }else{
            toastr["warning"]("You are offline, this option will not work at the moment.", "Warning");
        }
    });
    
    $(document).on('click', '#submit_discount_custom', function(){
        let cartItemLength = $('.order_holder .single_order').length;
        let user_id = $('#session_uer_id').val();
        let discount_permission_code = $('.discount_permission_code').val();
        let error = false;
        if(user_id != '1' && discount_permission_code == ''){
            error = true;
            $('.discount_err_message').parent().show();
            $('.discount_err_message').text(The_discount_code_field_required)
            return false
        }else{
            $.ajax({
                method: "POST",
                url: base_url+"Sale/checUserDiscountPermission",
                data: {
                    user_id: user_id,
                    discount_permission_code: discount_permission_code,
                },
                success: function (response) {
                    if(response.status == 'success'){
                        $('.discount_err_message').parent().hide();
                        if(cartItemLength > 0){
                            $('.discount_field').show();
                            let discountOriginal = $('#sub_total_discount').val();
                            let plainDiscount = discountOriginal.replace('%', '')
                            if(Number(plainDiscount) > 0){
                                let userAssignDiscount = response.data;
                                let userAssignDiscountPlain = userAssignDiscount.replace('%', '');
                                if(user_id == '1' && role == '1'){
                                    $('.discount_permission_code').attr('varified-status', 'Yes');
                                    $('#show_discount_amount').text(Number(discountOriginal).toFixed(op_precision));
                                    $("#discount_modal").removeClass("active");
                                    $(".pos__modal__overlay").fadeOut(300);
                                    cartItemCalculationInPOS();
                                    if(edit_mode == ''){
                                        storageCartDataInLocal();
                                    }
                                }else{
                                    if( Number(plainDiscount) <= Number(userAssignDiscountPlain)){
                                        $('.discount_permission_code').attr('varified-status', 'Yes');
                                        $('#show_discount_amount').text(Number(discountOriginal).toFixed(op_precision));
                                        $("#discount_modal").removeClass("active");
                                        $(".pos__modal__overlay").fadeOut(300);
                                        cartItemCalculationInPOS();
                                        if(edit_mode == ''){
                                            storageCartDataInLocal();
                                        }
                                    }else{
                                        Swal.fire({
                                            title: warning+" !",
                                            text: `This cashier cannot give more than ${response.data} discount`,
                                            showDenyButton: false,
                                            showCancelButton: false,
                                            confirmButtonText: ok,
                                        });
                                    }
                                }
                            }
                        }else{
                            Swal.fire({
                                title: warning+" !",
                                text: `The cart is empty!`,
                                showDenyButton: false,
                                showCancelButton: false,
                                confirmButtonText: ok,
                            });
                        }
                    }else{
                        $('.discount_err_message').text(response.message)
                        $('.discount_err_message').parent().show();
                    }
                }
            });
        }
    });

    // Code optimize by Azhar ** Final **
    $(document).on("click", "#open_charge_modal", function () {
        $("#charge_modal").addClass("active");
        $(".pos__modal__overlay").fadeIn(300);
    });

    // Code optimize by Azhar ** Final **
    $(document).on("click", "#open_deliverypartner_modal", function () {
        $("#delivery_partner").addClass("active");
        $(".pos__modal__overlay").fadeIn(300);
    });
    // Code optimize by Azhar ** Final **
    $(document).on("click", "#delivery_partner_submit", function () {
        let deliveryPartner = $("#delivery_partner_list").val();
        let deliveryPartnerName = $('option:selected', '#delivery_partner_list').text();
        $('#delivery_partner_info').text(deliveryPartnerName);
        $('#delivery_partner_info').attr('data-partner-id', deliveryPartner);
        $(".pos__modal__overlay").fadeIn(300);
    });


    // Code optimize by Azhar ** Final **
    $(document).on("click", "#open_note_modal", function () {
        $("#note_modal").addClass("active");
        $(".pos__modal__overlay").fadeIn(300);
    });


    // Code optimize by Azhar ** Final **
    $(document).on("click", "#coupon_discount_modal", function () {
        if(is_offline_system == '1'){
            $("#coupon_discount").addClass("active");
            $(".pos__modal__overlay").fadeIn(300);
            $('.coupon_err_message').parent().hide();
        }else{
            toastr["warning"]("You are offline, this option will not work at the moment.", "Warning");
        }
        
    });


    $(document).on('click', '.coupon_code_submit', function(){
        let couponCode = $('#coupon_code').val();
        let error = false;
        if(couponCode == ''){
            $('.coupon_err_message').parent().show();
            $('.coupon_err_message').text(The_coupon_code_field_required);
            error = true;
        }
        if(error == true){
            return false;
        }else{
            $.ajax({
                method: "POST",
                url: base_url +"Sale/couponCodeValidate",
                data: {
                    couponCode: couponCode,
                },
                success: function (response) {
                    if(response.status == "success"){
                        let cartItemLength = $('.single_order').length;
                        if(cartItemLength > 0){
                            $('.single_order').each(function(){
                                let item_id = $(this).attr('data_cart_item_id');
                                $(`#percentage_table_${item_id}`).val(response.data);
                            });
                            $('#coupon_code').val('');
                            $('.coupon_err_message').parent().hide();
                            $('#coupon_discount').removeClass('active');
                            $(".pos__modal__overlay").fadeOut(300);
                            setTimeout(function(){
                                cartItemCalculationInPOS();
                            }, 100);
                        }else{
                            $('.coupon_err_message').parent().hide();
                            Swal.fire({
                                title: warning + "!",
                                text: 'The cart is empty',
                                confirmButtonColor: "#8b5cf6",
                                confirmButtonText: ok,
                                showCancelButton: false,
                            });
                        }
                    }else{
                        $("#coupon_discount").addClass("active");
                        $('.coupon_err_message').text(response.message);
                        $('.coupon_err_message').parent().show();
                    }
                }
            });
        }
    });


    // Code optimize by Azhar ** Final **
    $(document).on("click", "#open_tax_modal", function () {
        $("#tax_modal").addClass("active");
        $(".pos__modal__overlay").fadeIn(300);
    });


    // Code optimize by Azhar ** Final **
    $(document).on("click", ".cancel", function () {
        $(this).parent().parent().parent().removeClass("active");
        $(".pos__modal__overlay").fadeOut(300);
    });


    // Code optimize by Azhar ** Final **
    $(document).on("click", ".submit", function () {
        $(".modal").removeClass("active");
        $(".pos__modal__overlay").fadeOut(300);
    });


    // Code optimize by Azhar ** Final **
    // Hide Modal When Click to close Icon
    $("body").on("click", ".alertCloseIcon", function () {
        $(this)
            .parent()
            .parent()
            .parent()
            .removeClass("active");
        $(".pos__modal__overlay").fadeOut(300);
    });


    // Code optimize by Azhar ** Final **
    $(document).on("click", "#open__menu", function (e) {
        if(is_offline_system == '1'){
            $("aside#pos__sidebar").addClass("active");
            $(".pos__modal__overlay").fadeIn(200);
        }
    });

    // Code optimize by Azhar ** Final **
    $(document).on('click', '.show_cart_list', function () {
        $('.main_middle').fadeIn(300);
        $('.main_right').hide(0);
        if (grocery_experience == 'Medicine' || grocery_experience == 'Grocery') {
            if (window.matchMedia("(min-width: 320px) and (max-width: 991.98px)").matches) {
                $('.grocery_main_part_on').css({
                    'grid-template-columns': '1fr',
                });
            }
        }
    });

    // Code optimize by Azhar ** Final **
    $(document).on('click', '.show_product', function () {
        $('.main_right').fadeIn(300);
        $('.main_middle').hide();
        if (grocery_experience == 'Medicine' || grocery_experience == 'Grocery') {
            if (window.matchMedia("(min-width: 320px) and (max-width: 991.98px)").matches) {
                $('.grocery_main_part_on').css({
                    'grid-template-columns': '70% 29%',
                    'gap': '1%',
                });
            }
        }
    });


    // Code optimize by Azhar ** Final **
    $(document).on('click', '.radio_btn_label', function () {
        let amount = Number($(this).find("span").html());
        $("#modal_item_price_input_field").val(amount.toFixed(op_precision));
        updateCartItemPrice();
    });

    // Code optimize by Azhar ** Final **
    $(document).on("click", ".show_all_menu", function () {
        if ($(this).find('i').hasClass('fa-bars')) {
            $(this).find('i').removeClass('fa-bars').addClass('fa-times');
            $(".all__menus").slideDown(333);
        } else {
            $(this).find('i').removeClass('fa-times').addClass('fa-bars');
            $(".all__menus").slideUp(333);
        }
    });



    function forMobDevice() {
        if ($(window).width() < 600) {
            $('.cat-view-trigger').on('click', function () {
                $('.slimScrollDivCategory').toggleClass('active');
            });
            $(window).click(function (event) {
                if ($(event.target).closest(".cat-view-trigger").length === 0) {
                    $('.slimScrollDivCategory').removeClass('active');
                }
            });
        }
    }

    $(window).on('load', forMobDevice)
    $(window).on('resize', forMobDevice)




    function shortCustPaymentActive(){
        let payment_type = $('.payment_element .active').attr('data-type_value');
        if(payment_type == 'Cash'){
            $('#finalize_given_amount_input').focus();
        }else{
            $('#finalize_amount_input').focus();
        }
    }


    // Flag to track if Alt key is down
    let altKeyDown = false;
    let shiftKeyDown = false;
    // Key down event listener


    if(grocery_experience == 'Medicine' || grocery_experience == 'Grocery'){
        $(document).on('focus', '#search_barcode', function(){
            let selector = $('.single-inner-div').find('.active_gm');
            selector.removeClass('active_gm');
            selector.addClass('active_gm_temp');
        });
        $(document).on('focus', '#search', function(){
            let selector = $('.single-inner-div').find('.active_gm');
            selector.removeClass('active_gm');
            selector.addClass('active_gm_temp');
        });
        $(document).on('focus', '#search_barcode', function(){
            let selector = $('#alternative_item_render').find('.active_medicine');
            selector.removeClass('active_medicine');
            selector.addClass('active_medicine_temp');
        });
        $(document).on('focus', '#search', function(){
            let selector = $('#alternative_item_render').find('.active_medicine');
            selector.removeClass('active_medicine');
            selector.addClass('active_medicine_temp');
        });
    }


    function show_generic_name_right_item(generic_name='',parent_id){
        if(generic_name){
            let array_as = {};
            let alternativeProduct = '';
            let foundItemsForItems = searchItemAndConstructGalleryAlternative(generic_name,'','');
            for (let key1 in foundItemsForItems) {
                if(foundItemsForItems[key1].item_type != '0'){
                    if (foundItemsForItems.hasOwnProperty(key1)) {
                        let item_details = findItemByItemId(foundItemsForItems[key1].item_id);
                            if(parent_id!=foundItemsForItems[key1].item_id){
                                alternativeProduct+=`<div class="alternative-medicine single_item medicine_el  brand_${item_details.brand_id}" item-type="${item_details.item_type}" plain-id="${item_details.item_id}" data-last_purchase_price="${item_details.last_purchase_price}" data-whole_sale_price="${item_details.whole_sale_price}" data-sale_price="${item_details.price}" id="item_${item_details.item_id}">
                                <p class="item_name" data-tippy-content="${item_details.item_name}(${item_details.item_code})">${item_details.item_name}${item_details.brand_name} (${item_details.item_code})</p>
                                <p class="generic_name ${$.trim(item_details.generic_name) ? '' : 'd-none'}" data-tippy-content="${$.trim(item_details.generic_name) ? $.trim(item_details.generic_name) : ''}">${$.trim(item_details.generic_name) ? $.trim($.trim(item_details.generic_name)) : ''}</p>
                                <p class="item_price">SP: <span id="price_${item_details.item_id}">${parseFloat(item_details.price).toFixed(op_precision)}</span></p>
                                <span class="item_vat_percentage d-none">${item_details.vat_percentage}</span>
                            </div>`;
                            }
                    }
                }
            }
            if(alternativeProduct){
                $('#alternative_item_render').html('');
                $('#alternative_item_render').html(alternativeProduct);
                $('#main_left').addClass('alternative-exist');
            }else{
                $('#main_left').removeClass('alternative-exist');
                $('#alternative_item_render').html(`<h6>${Alternative_Medicine_will_shown_here} <iconify-icon icon="solar:smile-circle-broken"></iconify-icon></h6>`);
            }
        }else{
            $('#alternative_item_render').html(`<h6>${Alternative_Medicine_will_shown_here} <iconify-icon icon="solar:smile-circle-broken"></iconify-icon></h6>`);
            $('#main_left').removeClass('alternative-exist');
            $('#alternative_item_render').html(`<h6>${Alternative_Medicine_will_shown_here} <iconify-icon icon="solar:smile-circle-broken"></iconify-icon></h6>`);
        }
    }


    $(document).keydown(function(e) {
        let item_modal = $('#item_modal').hasClass('active');
        let finalize_order_modal = $('#finalize_order_modal').hasClass('active');
        if((grocery_experience == 'Medicine' || grocery_experience == 'Grocery') && !finalize_order_modal && !item_modal){
            // Main Screen UP & Down
            let generic_medicine_part = $('#main_left').hasClass('main_left_arrow');
            if(!generic_medicine_part){
                if (e.key === 'ArrowDown') {
                    $('#search_barcode').blur();
                    $('#search').blur();
                    let selector = $('.single-inner-div').find('.active_gm_temp');
                    selector.addClass('active_gm');
                    selector.removeClass('active_gm_temp');

                    setTimeout(function(){
                        let selector_gn = $('.single-inner-div').find('.active_gm');
                        let generic_name = selector_gn.find('.generic_name').attr("data-tippy-content");
                        let parent_id = selector_gn.attr("plain-id");
                        show_generic_name_right_item(generic_name,parent_id); 
                        const activeDiv = document.querySelector('.active_gm');
                        const rect = activeDiv.getBoundingClientRect();
                        const viewportHeight = window.innerHeight || document.documentElement.clientHeight;
                        if (rect.bottom > viewportHeight) {
                            $('.category_items').animate({
                                scrollTop: $('.active_gm').offset().top-110
                            },500);
                        }  
                    }, 100);

                    let current = $('.single-inner-div .active_gm');
                    let next = current.next('.grocery_medicine_el');
                    if (next.length) {
                        current.removeClass('active_gm');
                        next.addClass('active_gm');
                        $('.active_gm').focus();
                    } else {
                        current.removeClass('active_gm');
                        $('.single-inner-div .grocery_medicine_el').first().addClass('active_gm');
                        $('.active_gm').focus();
                    }
                }
                if (e.key === 'ArrowUp') {
                    $('#search_barcode').blur();
                    $('#search').blur();
                    let selector = $('.single-inner-div').find('.active_gm_temp');
                    selector.addClass('active_gm');
                    selector.removeClass('active_gm_temp');

                    setTimeout(function(){
                        let selector_gn = $('.single-inner-div').find('.active_gm');
                        let generic_name = selector_gn.find('.generic_name').attr("data-tippy-content");
                        let parent_id = selector_gn.attr("plain-id");
                        show_generic_name_right_item(generic_name,parent_id); 
                    }, 100);
                    
                    let current = $('.single-inner-div .active_gm');
                    let previous = current.prev('.grocery_medicine_el');
                    if (previous.length) {
                        current.removeClass('active_gm');
                        previous.addClass('active_gm');
                        $('.active_gm').focus();
                    } else {
                        current.removeClass('active_gm');
                        $('.single-inner-div .grocery_medicine_el').last().addClass('active_gm');
                        $('.active_gm').focus();
                    }
                }
                if (e.key === 'Enter') {
                    let activeElement = $('.single-inner-div .single_item.active_gm');
                    if (activeElement.length) {
                        activeElement.click();
                    }
                }
            }

            
            if($('#main_left').hasClass('alternative-exist')){
                if(e.key === 'ArrowRight'){
                    let selector = $('.single-inner-div').find('.active_gm');
                    selector.removeClass('active_gm');
                    selector.addClass('active_gm_temp');
                    $('#main_left').addClass('main_left_arrow');
                    setTimeout(function () {
                        let old_active_cls = $('#alternative_item_render .active_medicine_temp').length;
                        if(old_active_cls == 0){
                            $("#alternative_item_render").find(".medicine_el").eq(0).addClass("active_medicine");
                        }else{
                            let selector2 = $('#alternative_item_render').find('.active_medicine_temp');
                            selector2.removeClass('active_medicine_temp');
                            selector2.addClass('active_medicine');
                        }
                    }, 200);
                }
                if(e.key === 'ArrowLeft'){
                    let selector = $('#alternative_item_render').find('.active_medicine');
                    selector.removeClass('active_medicine');
                    selector.addClass('active_medicine_temp');
                    let selector2 = $('.single-inner-div').find('.active_gm_temp');
                    selector2.removeClass('active_gm_temp');
                    selector2.addClass('active_gm');
                    $('#main_left').removeClass('main_left_arrow');
                }
                if($('#main_left').hasClass('main_left_arrow')){
                    if (e.key === 'ArrowDown') {
                        $('#search_barcode').blur();
                        $('#search').blur();
                        let selector = $('#alternative_item_render').find('.active_medicine_temp');
                        selector.addClass('active_medicine');
                        selector.removeClass('active_medicine_temp');
                        let current = $('#alternative_item_render .active_medicine');
                        let next = current.next('.medicine_el');
                        if (next.length) {
                            current.removeClass('active_medicine');
                            next.addClass('active_medicine');
                            $('.active_medicine').focus();
                        } else {
                            current.removeClass('active_medicine');
                            $('#alternative_item_render .medicine_el').first().addClass('active_medicine');
                            $('.active_medicine').focus();
                        }
                    }
                    if (e.key === 'ArrowUp') {
                        $('#search_barcode').blur();
                        $('#search').blur();
                        let selector = $('#alternative_item_render').find('.active_medicine_temp');
                        selector.addClass('active_medicine');
                        selector.removeClass('active_medicine_temp');
                        let current = $('#alternative_item_render .active_medicine');
                        let previous = current.prev('.medicine_el');
                        if (previous.length) {
                            current.removeClass('active_medicine');
                            previous.addClass('active_medicine');
                            $('.active_medicine').focus();
                        } else {
                            current.removeClass('active_medicine');
                            $('#alternative_item_render .medicine_el').last().addClass('active_medicine');
                            $('.active_medicine').focus();
                        }
                    }
                    if (e.key === 'Enter') {
                        let activeElement = $('#alternative_item_render .single_item.active_medicine');
                        if (activeElement.length) {
                            activeElement.click();
                        }
                    }
                }
            }
        }

        // When Item Add Modal Is Active
        if(item_modal){
            if(e.shiftKey){
                if(e.keyCode == 13){
                    $('#add_to_cart').click(); // enter for add to cart
                    setTimeout(function(){
                        posDefaultCursor();
                    }, 100)
                }
                if(e.keyCode == 67){
                    $('#item_modal_close').click(); // shift + c for close modal NB: when item add modal is active
                }
                if(e.keyCode == 65){
                    $('#add_to_cart').click(); // shift + a 
                }
            }
            if ($('#item_quantity_modal_input').is(':focus') && e.key === 'ArrowUp') {
                let modal_qty_selector = $('#item_quantity_modal_input');
                let currentValue = modal_qty_selector.val();
                currentValue = parseInt(currentValue, 10); 
                modal_qty_selector.val(currentValue + 1);
            }
            if ($('#item_quantity_modal_input').is(':focus') && e.key === 'ArrowDown') {
                let modal_qty_selector = $('#item_quantity_modal_input');
                let currentValue = modal_qty_selector.val();
                currentValue = parseInt(currentValue, 10); 
                modal_qty_selector.val(currentValue - 1);
            }
            
        }


        // When Finalize Modal Is Active
        if(finalize_order_modal){
            // Denomination Increase
            let quick_cash = 'No';
            $('.get_quick_cash').each(function(){
                let check_active = $(this).hasClass('d_active');
                if(check_active){
                    quick_cash = 'Yes';
                }
            });
            if(quick_cash == 'No'){
                if(e.keyCode == 13){
                    $('#finalize_order_button').click();//enter for sale
                }
            }
            if (e.key === 'ArrowDown') {
                let current = $('#finalize_payment_method .active_m');
                let next = current.next('.payment_element');
                if (next.length) {
                    current.removeClass('active_m');
                    next.addClass('active_m');
                    $('.active_m a').click();
                    shortCustPaymentActive();
                } else {
                    current.removeClass('active_m');
                    $('#finalize_payment_method .payment_element').first().addClass('active_m');
                    $('.active_m a').click();
                    shortCustPaymentActive();
                }
            }
            if (e.key === 'ArrowUp') {
                let current = $('#finalize_payment_method .active_m');
                let previous = current.prev('.payment_element');
                if (previous.length) {
                    current.removeClass('active_m');
                    previous.addClass('active_m');
                    $('.active_m a').click();
                    shortCustPaymentActive();
                } else {
                    current.removeClass('active_m');
                    $('#finalize_payment_method .payment_element').last().addClass('active_m');
                    $('.active_m a').click();
                    shortCustPaymentActive();
                }
            }
            if(e.shiftKey){
                shiftKeyDown = true;
                if(e.keyCode == "Enter"){
                    $('#finalize_order_button').click();
                }
                if(e.keyCode == 65){
                    $('#add_payment').click(); //shift a
                }
                if(e.keyCode == 81){
                    $('.set_default_quick_cach').click(); //shift q
                }
                if(e.keyCode == 82){
                    $('.clear_quick_data').click(); // shift r
                    setDefaultPayment();
                }
                if(e.keyCode == 67){
                    $('#finalize_order_cancel_button').click(); // shift + c for close modal NB: when finilize modal is active
                }
                if(e.keyCode == 83){
                    $('.send_sms_finalize').click(); // shift + s for send invice via sms
                }
                if(e.keyCode == 69){
                    $('.send_email_finalize').click(); // shift + e for send invice via email
                }
                if(e.keyCode == 87){
                    $('.send_wm_finalize').click(); // shift + w for send invice via whats app
                }
            }
            $(document).on('focus', '.get_quick_cash', function() {
                $(this).addClass('d_active');
            });
            $(document).on('focusout', '.get_quick_cash', function() {
                $(this).removeClass('d_active');
            });
        }

        // POS Screen  Global
        if(e.shiftKey){
            shiftKeyDown = true;
            if(e.keyCode == 80){
                $('#place_order_operation').click(); // shift p
            }
            if(item_modal == false && finalize_order_modal == false){
                if(e.keyCode == 67){
                    $('#cancel_button').click(); // shift + c for cancel or clear cart data
                }
            }
            if(e.keyCode == 70){
                $('#search').focu();
            }
            if(e.keyCode == 66){
                $('#search_barcode').focu();
            }
        }

        // Check if Alt key is pressed
        if (e.altKey) {
            altKeyDown = true; // Set flag to true
            if (e.keyCode == 80) {
                e.preventDefault();
                if(view_purchase_price == 'Yes'){
                    $('.single_item').each(function (i, obj) {
                        let pp = (!isNaN(parseFloat($(this).data("last_purchase_price")).toFixed(op_precision))) ? parseFloat($(this).data("last_purchase_price")).toFixed(op_precision) : parseFloat(0).toFixed(op_precision);
                        let price_list = 'PP: ' + pp;
                        $(this).find(".item_price").html(price_list);
                    });
                }else{
                    toastr['error']('This user is not able to view purchase prices.', '');
                }
            } else if (e.keyCode == 87) {
                e.preventDefault();
                if(view_purchase_price == 'Yes'){
                    $('.single_item').each(function (i, obj) {
                        $('.single_item').each(function (i, obj) {
                            let wp = (!isNaN(parseFloat($(this).data("whole_sale_price")).toFixed(op_precision))) ? parseFloat($(this).data("whole_sale_price")).toFixed(op_precision) : parseFloat(0).toFixed(op_precision);
                            let price_list = ' WP: ' + wp;
                            $(this).find(".item_price").html(price_list);
                        });
                    });
                }else{
                    toastr['error']('This user is not able to view whole sale prices.', '');
                }
            } else if (e.keyCode == 83) {
                e.preventDefault();
                $('.single_item').each(function (i, obj) {
                    let sp = (!isNaN(parseFloat($(this).data("sale_price")).toFixed(op_precision))) ? parseFloat($(this).data("sale_price")).toFixed(op_precision) : parseFloat(0).toFixed(op_precision);
                    let price_list = ' SP: ' + sp;
                    $(this).find(".item_price").html(price_list);
                });
            } else if (e.keyCode == 67) {
                e.preventDefault();
                $('#add_customer_modal').addClass('active');
                $(".pos__modal__overlay").fadeIn(200);
                $('#add_or_edit_text').text('Add Customer');


                // Function to change the selected option based on data-customer-name attribute
                function selectCustomerByName(customerName) {
                    $('#walk_in_customer option').each(function() {
                        if ($(this).data('customer-name') === customerName) {
                            $(this).prop('selected', true);
                            $('#walk_in_customer').trigger('change'); // Trigger change event if needed
                            return false; // Break the loop once the option is found and selected
                        }
                    });
                }
                // Call the function to select "Walk-in Customer"
                selectCustomerByName('Walk-in Customer');

            } else if (e.keyCode == 82) {
                e.preventDefault();
                $('#register_modal').addClass('active');
                $(".pos__modal__overlay").fadeIn(200);
            } else if (e.keyCode == 68) {
                e.preventDefault();
                $('#show_sale_hold_modal').addClass('active');
                $(".pos__modal__overlay").fadeIn(200);
                getAllHoldSales();
            } else if (e.keyCode == 84) {
                e.preventDefault();
                $('#show_last_ten_sales_modal').addClass('active');
                $(".pos__modal__overlay").fadeIn(200);
                let op_current_date = new Date();
                $(".date_sale").datepicker({
                    autoclose: true,
                    format: "yyyy-mm-dd",
                    todayHighlight: true,
                })
                .datepicker("update", op_current_date);
                $(".date_sale").on("changeDate", function (event) {
                    $("#date_c").val(event.format());
                });
                let date_c = $("#date_c").val();
                getLastSale(date_c, '', '', 'default');
            } else if (e.keyCode == 69) {
                e.preventDefault();
                $('#calculator_main').css('display','block');
                $('.overlayForCalculator').css('display','block');
            } else if (e.keyCode == 75) {
                e.preventDefault();
                $('#show_keyboard_short_cut').addClass('active');
                $(".pos__modal__overlay").fadeIn(200);
            }
        }
    });




    // Key up event listener
    $(document).keyup(function(e) {
        // Check if Alt key is released and it was previously down
        if (!e.altKey && altKeyDown) {
            altKeyDown = false; // Reset flag
            e.preventDefault();
            $('.single_item').each(function (i, obj) {
                let sp = (!isNaN(parseFloat($(this).data("sale_price")).toFixed(op_precision))) ? parseFloat($(this).data("sale_price")).toFixed(op_precision) : parseFloat(0).toFixed(op_precision);
                let price_list = ' SP: ' + sp;
                $(this).find(".item_price").html(price_list);
            });
        }
    });
    

    


    $(document).on("click", ".clear_quick_data", function (e) {
        $("#finalize_amount_input").val('');
        $("#finalize_given_amount_input").val('');
        $("#finalize_change_amount_input").val('');
        $(".badge_custom").remove();
        shortCustPaymentActive();
    });


    setTimeout(function () {
        cartItemCalculationInPOS();
        if(edit_mode == ''){
            storageCartDataInLocal();
        }
    }, 300);


    // Main SCREEN
    feather.replace();
    $(window).on('load resize mouseover',function(){
        let h = $('.main_right').height();
        $('.slimScrollDiv').css('height' , h-60);
        $('.slimScrollDivCategory').css('height' , h-60);
    });

    $(".slimScrollBar").css({'width': '7px'});
    $(".slimScrollBar").css({'background': 'rgb(0, 0, 0)'});

    $('table .slimScrollDiv').addClass('nowSlime');
    $('#main_item_holder > .slimScrollDiv').addClass('cat-list-item');

    $('.product-view-trigger').on('click',function(){
        $('.cat-list-item').fadeToggle(555);
    });


    // Items
    function search(nameKey, myArray, sort_id, is_main_search){
        let generic_name_search_option = $('input[name="generic_serch_option_checkbox"]:checked').val();
        if(sort_id){
            if(sort_id==1){
                myArray.sort(function(a, b) {
                    return b.total_sale - a.total_sale;
                });
            }else if(sort_id==2){
                myArray.sort(function(a, b) {
                    return a.total_sale - b.total_sale;
                });
            }
            
        }
        let foundResult = new Array();
        let counter = 0;
       
        for (let i= 0; i < myArray.length; i++) {
            let g_name = 'x';
            if(myArray[i].generic_name && is_main_search!=1){
                g_name = myArray[i].generic_name;
            }
           
            if($('.generic_serch_option_checkbox').is(':checked')){
                g_name = myArray[i].generic_name;
                if (g_name && g_name.toLowerCase().includes(nameKey.toLowerCase())) {
                    foundResult.push(myArray[i]);
                    counter++;
                    if (nameKey && counter == 12) {
                        break;
                    }
                }
            }else{
                if(sort_id==''){
                    if(generic_name_search_option == 'on'){
                        if (myArray[i].item_name.toLowerCase().includes(nameKey.toLowerCase()) || g_name.toLowerCase().includes(nameKey.toLowerCase()) ||  myArray[i].item_code.toLowerCase().includes(nameKey.toLowerCase()) || myArray[i].category_name.toLowerCase().includes(nameKey.toLowerCase())) {
                            foundResult.push(myArray[i]);
                            counter++;
                            if (nameKey && counter == 12) {
                                break;
                            }
                        }
                    }else{
                        if (myArray[i].item_name.toLowerCase().includes(nameKey.toLowerCase()) ||  myArray[i].item_code.toLowerCase().includes(nameKey.toLowerCase()) || myArray[i].category_name.toLowerCase().includes(nameKey.toLowerCase())) {
                            foundResult.push(myArray[i]);
                            counter++;
                            if (nameKey && counter == 12) {
                                break;
                            }
                        }
                    }
                }else{
                    if((sort_id==1 || sort_id==2) && myArray[i].total_sale){
                        if(generic_name_search_option == 'on'){
                            if (myArray[i].item_name.toLowerCase().includes(nameKey.toLowerCase()) || g_name.toLowerCase().includes(nameKey.toLowerCase()) ||  myArray[i].item_code.toLowerCase().includes(nameKey.toLowerCase()) || myArray[i].category_name.toLowerCase().includes(nameKey.toLowerCase())) {
                                foundResult.push(myArray[i]);
                                counter++;
                                if (nameKey && counter == 12) {
                                    break;
                                }
                            }
                        }else{
                            if (myArray[i].item_name.toLowerCase().includes(nameKey.toLowerCase()) ||  myArray[i].item_code.toLowerCase().includes(nameKey.toLowerCase()) || myArray[i].category_name.toLowerCase().includes(nameKey.toLowerCase())) {
                                foundResult.push(myArray[i]);
                                counter++;
                                if (nameKey && counter == 12) {
                                    break;
                                }
                            }
                        }
                        
                    }else if(sort_id==3 && !myArray[i].total_sale){
                        if(generic_name_search_option == 'on'){
                            if (myArray[i].item_name.toLowerCase().includes(nameKey.toLowerCase()) || g_name.toLowerCase().includes(nameKey.toLowerCase()) ||  myArray[i].item_code.toLowerCase().includes(nameKey.toLowerCase()) || myArray[i].category_name.toLowerCase().includes(nameKey.toLowerCase())) {
                                foundResult.push(myArray[i]);
                                counter++;
                                if (nameKey && counter == 12) {
                                    break;
                                }
                            }
                        }else{
                            if (myArray[i].item_name.toLowerCase().includes(nameKey.toLowerCase()) ||  myArray[i].item_code.toLowerCase().includes(nameKey.toLowerCase()) || myArray[i].category_name.toLowerCase().includes(nameKey.toLowerCase())) {
                                foundResult.push(myArray[i]);
                                counter++;
                                if (nameKey && counter == 12) {
                                    break;
                                }
                            }
                        }
                    }
                }
            } 
            
        }
        return foundResult.sort( function(a, b) {
          return parseInt(b.sold_for)-parseInt(a.sold_for);
        });
    }
    function searchAlternative(nameKey, myArray, sort_id, is_main_search){
        let generic_name_search_option = $('input[name="generic_serch_option_checkbox"]:checked').val();
       
        let foundResult = new Array();
        let counter = 0;
       
        for (let i= 0; i < myArray.length; i++) {
            let g_name = 'x';
            if(myArray[i].generic_name && is_main_search!=1){
                g_name = myArray[i].generic_name;
            }
           
            if($('.generic_serch_option_checkbox').is(':checked')){
                
            }else{
                if (g_name.toLowerCase().includes(nameKey.toLowerCase())) {
                    foundResult.push(myArray[i]);
                    counter++;
                    if (nameKey && counter == 12) {
                        break;
                    }
                }
            } 
            
        }
        return foundResult.sort( function(a, b) {
          return parseInt(b.sold_for)-parseInt(a.sold_for);
        });
    }

    // Code optimize by Azhar ** Final **
    $(document).on('keydown', '.integerchkPercent', function(e){
        let keys = e.charCode || e.keyCode || 0;
        // allow backspace, tab, delete, enter, arrows, numbers and keypad numbers ONLY
        // home, end, period, and numpad decimal
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

    // Code optimize by Azhar ** Final **
    $(document).on('keyup', '.integerchkPercent', function(e){
        let input = $(this).val();
        let ponto = input.split('.').length;
        let slash = input.split('-').length;
        if (ponto > 2)
            $(this).val(input.substr(0,(input.length)-1));
        $(this).val(input.replace(/[^0-9.%]/,''));
        if(slash > 2)
            $(this).val(input.substr(0,(input.length)-1));
        if (ponto ==2)
            $(this).val(input.substr(0,(input.indexOf('.')+4)));
        if(input == '.')
            $(this).val("");
    });


    // Code optimize by Azhar ** Final **
    $(document).on('click', '.logOutTrigger', function(){
        if(is_offline_system == '1'){
            let register_status = $('#register_status').val();
            if(register_status == '1'){
                Swal.fire({
                    title: warning + "!",
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
                                toastr['success']((register_close), '');
                                $("#close_register_button").hide();
                                window.location.href = base_url + "Register/openRegister";
                            },
                            error: function () {
                                alert("error");
                            },
                        });
                    }
                });
            }
        }
        
    });


    // Code optimize by Azhar ** Final **
    $(document).on('click', '.show-menu', function(){
        $(this).parent().find('.sub__menu').fadeToggle(100)
    });
    // Code optimize by Azhar ** Final **
    $(document).on('click', '.select2-hidden-accessible', function(){
        $('.select2-container--default').css('top', '107')
    });

    // Code optimize by Azhar ** Final **
    $(document).on('click', '.brand_button', function(){
        $('.brand__sub__menu').css('display', 'none');
    });
    // Code optimize by Azhar ** Final **
    $(document).on('click', '.category_button', function(){
        $(this).addClass('category_active_design');
        $(".category_button").not(this).removeClass("category_active_design");
    });
    // Code optimize by Azhar ** Final **
    $(document).on('click', '.brand_button', function(){
        $(this).addClass('brand_active');
        $(".brand_button").not(this).removeClass("brand_active");
    });
    // Code optimize by Azhar ** Final **
    $(document).on('click', '.button_category_show_all', function(){
        $('.button_category_show_all_left').addClass('category_active_design');
        $(".category_active_trigger").removeClass("category_active_design");
    });

    // Code optimize by Azhar ** Final **
    $(document).on('click', '.brand_all_category', function(){
        $(".brand_all_category").removeClass("category_active_design");
        $('.button_category_show_all_left').addClass('category_active_design');
        $('.brand_button').removeClass('brand_active');
        $('.brand__sub__menu').css('display', 'none');
    });

    // Code optimize by Azhar ** Final **
    $(document).on('click', '.brand_button', function(){
        $(".category_button").removeClass("category_active_design");
    });

    // Code optimize by Azhar ** Final **
    $(document).on('click', '.payment_btn_toggler .payment_ctrl',function() {
        $(".payment_btn_toggler .payment_ctrl").removeClass("active");
        $(this).addClass("active");
    });
    // Code optimize by Azhar ** Final **
    $(document).on('click', '.payment_mthod_ctrl', function(){
        $('.list-for-payment-type').addClass('finalize-p-active');
        $('.list-for-payment-type').removeClass('finalize-p-inactive');
        $('.payment_content_wrap').addClass('finalize-p-inactive');
    });

    // Code optimize by Azhar ** Final **
    $(document).on('click', '.payment_details_ctrl', function(){
        $('.payment_content_wrap').addClass('finalize-p-active');
        $('.payment_content_wrap').removeClass('finalize-p-inactive');
        $('.list-for-payment-type').addClass('finalize-p-inactive');
    });
    // Code optimize by Azhar ** Final **
    $(document).on('click', '.show-menu', function(){
        $('.show-menu').siblings('.sub__menu').css('display', 'none');
        $(this).siblings('.sub__menu').css('display', 'block');
    });

    // Code optimize by Azhar ** Final **
    $(document).on('click', '.sub__menu li a', function(){
        $('.sub__menu').css('display', 'none');
    });
    // Code optimize by Azhar ** Final **
    $(document).on('click', '.show-menu', function(){
        $('.show-menu').siblings('.sub__menu').css('display', 'none');
        $(this).siblings('.sub__menu').css('display', 'block');
    });

    let local_cart_data = localStorage['cart_html'];
    
    if(local_cart_data){
        if(edit_mode == ''){
            $(".order_holder").html(local_cart_data);
        }
        cartItemCalculationInPOS();
    }

    $('.off-pos-open-dropdown-menu').on('click', function(){

        $(document).find('.submenu-wrapper').hide();
        $(this).parent().find('.submenu-wrapper').toggle();
        $(".main_menu").children(".sub__menu").hide();
        $(".languages").children(".sub__menu").hide();

    });
    $('.select2').select2();


    $(document).on('click', '.show_all_menu', function(){
        $('.mobile_other_menu').css('display', 'block');
    });


    $(document).on('click', '.mobile_menu_click_for_hide', function(){
        $('.mobile_other_menu').css('display', 'none');
    });




    // Stripe Payment
    function addPaymentCashToPaid(type) {
        if (type == "stripe" && stripePayementStatus == true) {
            $("#finalize_amount_input").val($("#finalize_total_due").text());
            $("#add_payment").click();
            $('#finalize_order_button').click();
        } else if (type == "paypal" && paypalPayementStatus == true) {
            $("#finalize_amount_input").val($("#finalize_total_due").text());
            $("#add_payment").click();
            $('#finalize_order_button').click();
        } else {
            toastr["error"]("Pay first. Your Payment Not Complete!", "");
        }
    }

    $(document).on("click", ".pay_button", function () {
        // Card Payment info
        let credit_card_no = $("#credit_card_no").val();
        let holder_name = $("#holder_name").val();
        let payment_month = $("#payment_month").val();
        let payment_year = $("#payment_year").val();
        let payment_cvc = $("#payment_cvc").val();
        let account_type = $("#account_type").val();
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



    const html5QrCode = new Html5Qrcode("reader");
    $(document).on('click', '#barcode_open_trigger', function(){
        html5QrCode.start(
            { facingMode: "environment" }, // Use rear camera
            { fps: 10, qrbox: { width: 250, height: 100 } },
            (decodedText, decodedResult) => {
                $("#search_barcode").val(decodedText); 
                //open modal
                $('#barcode_open_modal').removeClass('active');
                $(".pos__modal__overlay").fadeOut(300);

                //trigger enter button
                let e = $.Event( "keyup", { which: 13 } );
                $("#search_barcode").focus(); 
                $('#search_barcode').trigger(e);
                html5QrCode.stop(); // Optional: stop after one scan
                Swal.fire({
                    title: warning + '!',
                    text: 'Do you want to scan the barcode again?',
                    showDenyButton: true,
                    showCancelButton: false,
                    confirmButtonText: yes,
                    denyButtonText: cancel
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $("#barcode_open_trigger").click();
                    }
                });
            },
            (errorMessage) => {
                console.warn(`Error scanning: ${errorMessage}`);
            }
        ).catch((err) => {
            console.error(`Failed to start camera: ${err}`);
        });

        $("#barcode_open_modal").addClass("active");
        $(".pos__modal__overlay").fadeIn(300);

    });

    $(document).on('click', '.cancel_open_camera', function(){
        html5QrCode.stop(); // Optional: stop after one scan
    });

    $(document).on('click', '.pos__modal__overlay', function(){
        html5QrCode.stop(); // Optional: stop after one scan
    });


    function stripeResponseHandler(status, response) {
        if (response.error) {
            toastr["error"](response.error.message, "");
        } else {
            /* token contains id, last4, and card type */
            let token = response["id"];
            let amount = Number($("#finalize_total_due").text());
            $.ajax({
                url: base_url + "Sale/stripePayment",
                method: "POST",
                data: {
                    token: token,
                    amount: amount,
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
                        addPaymentCashToPaid('stripe');
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
        let amount = Number($("#finalize_total_due").text());
        $.ajax({
            url: base_url + "Sale/paypalPayment",
            method: "POST",
            data: {
                info : info,
                amount: amount,
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
                    addPaymentCashToPaid('paypal');
                } else {
                    toastr["error"]("Something Went Wrong! Maybe Wrong Credentials!", "");
                    paypalPayementStatus = false;
                }
            },
        });
    }
    
    // Grocery Experience
    $(document).on('change', '#grocery_experience_el', function(){
        if(is_offline_system == '1'){
            let grocery_value = $(this).val();
            if(grocery_value == ''){
                grocery_value = 'Regular';
            }
            $.ajax({
                type: "POST",
                url: base_url+"Sale/groceryExperience",
                data: {
                    grocery_value : grocery_value,
                },
                success: function (response) {
                    if(response.status == 'success'){
                        toastr["success"](response.message, "");
                        window.location.href = base_url+'Sale/POS';
                    }
                }
            });
        }else{
            toastr["warning"]("You are offline, this option will not work at the moment.", "Warning");
        }
    });

    // Custom Num Pad for POS Added By Azhar 
    let onscreen_keyboard_status = $('#onscreen_keyboard_status').val();
    if(onscreen_keyboard_status == 'Enable'){
        $('.easy-get').on('click', () => {
            let inputVal = $('.easy-put').val();
            show_easy_numpad(inputVal);
        });
        function show_easy_numpad(inputVal) {
            let inputReady = inputVal.replace("%", "");
            if(inputReady > 0){
                inputReady = inputVal;
            }else{
                inputReady = '';
            }
            let easy_numpad = `
                <div class="easy-numpad-frame" id="easy-numpad-frame">
                    <div class="easy-numpad-container">
                        <div class="easy-numpad-output-container">
                            <p class="easy-numpad-output" id="easy-numpad-output">${inputReady}</p>
                        </div>
                        <div class="easy-numpad-number-container">
                            <table>
                                <tr>
                                    <td><a href="javascript:void(0)" class="numberTrigger">7</a></td>
                                    <td><a href="javascript:void(0)" class="numberTrigger">8</a></td>
                                    <td><a href="javascript:void(0)" class="numberTrigger">9</a></td>
                                    <td><a href="javascript:void(0)" class="del" id="del">Del</a></td>
                                </tr>
                                <tr>
                                    <td><a href="javascript:void(0)" class="numberTrigger">4</a></td>
                                    <td><a href="javascript:void(0)" class="numberTrigger">5</a></td>
                                    <td><a href="javascript:void(0)" class="numberTrigger">6</a></td>
                                    <td><a href="javascript:void(0)" class="clear" id="clear">Clear</a></td>
                                </tr>
                                <tr>
                                    <td><a href="javascript:void(0)" class="numberTrigger">1</a></td>
                                    <td><a href="javascript:void(0)" class="numberTrigger">2</a></td>
                                    <td><a href="javascript:void(0)" class="numberTrigger">3</a></td>
                                    <td><a href="javascript:void(0)" class="cancel-n" id="cancel">Cancel</a></td>
                                </tr>
                                <tr>
                                    <td class="numberTrigger"><a href="javascript:void(0)">0</a></td>
                                    <td class="numberTrigger"><a href="javascript:void(0)">%</a></td>
                                    <td class="numberTrigger"><a href="javascript:void(0)">.</a></td>
                                    <td><a href="javascript:void(0)" class="done" id="done">Done</a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            `;
            $('body').append(easy_numpad);
        }
        $(document).on('click', '.numberTrigger', function(){
            easynum();
        });
        function easynum() {
            navigator.vibrate = navigator.vibrate || navigator.webkitVibrate || navigator.mozVibrate || navigator.msVibrate;
            if (navigator.vibrate) {
                navigator.vibrate(60);
            }
            let easy_num_button = $(event.target);
            let easy_num_value = easy_num_button.text();
            $('#easy-numpad-output').append(easy_num_value);
        }
        $(document).on('click', '#done', function(){
            easy_numpad_done();
        });
        function easy_numpad_done() {
            let easy_numpad_output_val = $('#easy-numpad-output').text();
            $('.easy-put').val(easy_numpad_output_val);
            easy_numpad_close();
            $(".set_payment").each(function (i, obj) {
                let id = ($(this).text());
                if($(this).hasClass('active')){
                    if(id=="Cash"){
                        let finalize_total_payable = Number($("#finalize_total_due").text());
                        let finalize_given_amount_input = Number($("#finalize_given_amount_input").val());
                        let change_amount = (finalize_given_amount_input - finalize_total_payable);
                        $("#finalize_change_amount_input").val((change_amount && change_amount>0?change_amount:0).toFixed(op_precision));
                        let finalize_change_amount_input = Number($("#finalize_change_amount_input").val());
                        if(finalize_change_amount_input){
                            let amount = Number($("#finalize_total_due").text());
                            $("#finalize_amount_input").val(amount.toFixed(op_precision));
                        }
                    }
                }
            });
            $("#add_payment").click();
        }
        $(document).on('click', '#cancel', function(){
            easy_numpad_cancel();
        });
        function easy_numpad_cancel() {
            $('#easy-numpad-frame').remove();
            $('.pos__modal__overlay').css('display', 'block');
        }
        $(document).on('click', '#clear', function(){
            easy_numpad_clear();
        });
        function easy_numpad_clear() {
            $('#easy-numpad-output').text("");
        }
        $(document).on('click', '#del', function(){
            easy_numpad_del();
        });
        function easy_numpad_del() {
            let easy_numpad_output_val = $('#easy-numpad-output').text();
            let easy_numpad_output_val_deleted = easy_numpad_output_val.slice(0, -1);
            $('#easy-numpad-output').text(easy_numpad_output_val_deleted);
        }
        function easy_numpad_close() {
            $('#easy-numpad-frame').remove();
        }
    }

    $(window).on("load", function () {
      $(".main-preloader").fadeOut(500);
    });

    $(document).on('click', '.btn_video_tutorial', function(){
        $("#video_tutorial_modal").addClass("active");
        $(".pos__modal__overlay").fadeIn(200);
    })


    $(document).on('change', '.generic_serch_option_checkbox', function(){
        let generic_name = $('input[name="generic_serch_option_checkbox"]:checked').val();
        if(generic_name == 'on'){
            generic_name = 'Yes';
            $('#search').attr('placeholder', pharmacy_search_place_holder_pos);
        }else{
            generic_name = 'No';
            $('#search').attr('placeholder', other_search_place_holder_pos);
        }
        $.ajax({
            type: "POST",
            url: base_url+"Sale/searchByGenericName",
            data: {
                generic_name_search_option : generic_name,
            },
            success: function (response) {
                if(response.status == 'success'){
                    toastr["success"](response.message, "");
                }
            }
        });
    });

    $(document).on('click', '.offline_prevent', function(e){
        if(is_offline_system == '0'){
            e.preventDefault();
            toastr["warning"]("You are offline, this option will not work at the moment.", "Warning");
        }
    });


    $(document).on('click', '.bulk_import_for_sale', function(e){
        $('.error-msg').hide();
        $('.success-msg').hide();
        $("#bulk_import_for_sale").addClass("active");
        $(".pos__modal__overlay").fadeIn(200);
    });

    $('#fileUploadForm').on('submit', function (e) {
        e.preventDefault();
        // Check if a file is selected
        let fileInput = $('#file')[0];
        if (fileInput.files.length === 0) {
            $('.import_error_wrap #import_validation_error').html(`Please select a file to upload`);
            return;
        }
        let item_id = $('#bulk_import_for_sale_item_id').val();
        let item_type = $('#bulk_import_for_sale_item_type').val();
        let file = fileInput.files[0];
        let allowedExtensions = /(\.xlsx)$/i;
        // Validate file type
        if (!allowedExtensions.exec(file.name)) {
            $('.import_error_wrap #import_validation_error').html(`Invalid file type. Please upload an Excel file.`);
            return;
        }
        let formData = new FormData();
        formData.append('file', file);
        formData.append('item_id', item_id);
        formData.append('item_type', item_type);
        // AJAX request
        $.ajax({
            url: base_url+'Sale/bulkImportForSale', // Replace with your PHP file URL
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if(response.status == 'success'){
                    $('.import_error_wrap .success_message').html(`${response.message}`);
                    $('.import_error_wrap  .success-msg').show();
                    $('.import_error_wrap  .error-msg').hide();
                    $('#fileUploadForm')[0].reset();
                    if(response.data){
                        bulkImeiSerialAppendInCart(response.data);
                    }
                }else if(response.status == 'error'){
                    $('.import_error_wrap .import_validation_error').html(`${response.message}`);
                    $('.import_error_wrap  .error-msg').show();
                    $('.import_error_wrap  .success-msg').hide();
                }
            },
            error: function (xhr, status, error) {
                $('.import_error_wrap  .import_validation_error').html(`${error}`);
                $('.import_error_wrap  .success-msg').hide();
            }
        });
    });

    $(document).on('click', '.bulk_import_for_sale_cancel', function(){
        $('#bulk_import_for_sale').removeClass("active");
    });

    function bulkImeiSerialAppendInCart(append_arr = ''){
        let is_promo = $('#modal_is_promo').text();
        let sale_unit_name = $('#modal_item_sale_unit').text();
        let item_id = $('#modal_item_id').text();
        let seller_id = '';
        let expiry_date_maintain = 'No';
        let item_type = $('#modal_item_type').text();
        let item_name = $('#modal_item_name').text();
        let modal_item_vat_percentage = $('#modal_item_vat_percentage').text();
        let modal_discount = $('#modal_discount_amount').text();
        let modal_item_price = $.trim($('#modal_item_price_input_field').val());;
        let item_quantity_modal_input = 1;
        let readonlyAttr = '';
        let item_total_price = modal_item_price;
        let modal_item_note = $.trim($('#modal_item_note').val());;
        
        let draw_table_for_order = '';
        if(append_arr){
            let item_count = 0;
            append_arr.forEach(item => {
                item_count++
                draw_table_for_order += `<div data-variation-parent="" class="single_order imei_serial_expiry_${item}" is_promo="${is_promo}" data-qty_default="1" data-sale-unit="${sale_unit_name}" id="order_for_item_${item_id}" data-single-order-row-no="${item_count}" data_cart_item_id="${item_id}">
                    <div class="first_portion">
                        <span id="item_seller_table${item_id}" class="d-none">${seller_id}</span>
                        <span class="expiry_date_maintain d-none" id="expiry_date_maintain_${item_id}">${expiry_date_maintain}</span>
                        <span class="item_type d-none" id="item_type_table${item_id}">${item_type}</span>
                        <span class="item_vat d-none" id="item_vat_percentage_table${item_id}">${modal_item_vat_percentage}</span>
                        <span class="item_discount d-none" id="item_discount_table${item_id}">${percentValueCalculateByPriceQtyDiscount(modal_item_price, item_quantity_modal_input, modal_discount)}</span>
                        <span class="item_price_without_discount d-none" id="item_price_without_discount_${item_id}">${Number(modal_item_price) * Number(item_quantity_modal_input)}</span>
                        <div class="single_order_column first_column">
                            <iconify-icon icon="solar:pen-broken" class="op_cursor_pointer edit_item" width="22" id="edit_item_${item_id}"></iconify-icon>
                            <span id="item_name_table_${item_id}">${item_name}</span>
                        </div>
                        <div class="single_order_column second_column">
                            <span id="item_price_table_${item_id}">${modal_item_price}</span>
                        </div>
                        <div class="single_order_column third_column ${item_type == 'Combo_Product' ? 'combo_parent_inc_dec' : ''}">
                            <iconify-icon icon="uil:minus" class="decrease_item_table op_cursor_pointer" id="decrease_item_table_${item_id}" width="22"></iconify-icon>
                            <span class="cart_quantity" id="item_quantity_table_${item_id}">${item_quantity_modal_input}</span> 
                            <iconify-icon icon="uil:plus" class="increase_item_table op_cursor_pointer" id="increase_item_table_${item_id}" width="22"></iconify-icon>
                        </div>
                        <div class="single_order_column forth_column ${item_type == 'Combo_Product' ? 'combo_parent_inc_dec' : ''}">
                            <input type="" name="" onfocus="select();" inline_dis_column="${item_id}" placeholder="Amt or %" class="special_textbox access_control inline_dis_column" id="percentage_table_${item_id}" value="${modal_discount == '' ? Number(0) : modal_discount}" ${readonlyAttr}>
                        </div>
                        <div class="single_order_column fifth_column">
                            <span id="item_total_price_table_${item_id}">${item_total_price}</span> 
                            <iconify-icon icon="solar:trash-bin-minimalistic-broken" data-remove-order-row-no="${item_count}" class="remove_this_item_from_cart" width="22"></iconify-icon>
                        </div>
                    </div>
                    <span class="imei_serial_note" id="expiry_imei_serial">${checkItemShortType(item_type)}: <span class="expiry_imei_serial_${item_id}">${item}</span></span>
                    <span class="cart_item_modal_des item_modal_description_table_${item_id}">${modal_item_note}</span>
                </div>`;
            });
            
            $(".order_holder").append(draw_table_for_order);
            $('.bulk_import_for_sale_cancel').click();
            cartItemCalculationInPOS();
            $('.close_item_modal').click();
            toastr['success']('Item Append to cart successfully.', 'Success');
        } 
    }

    $(document).on('keyup', '.inline_dis_column', function(){
        $(this).attr('value', $(this).val());
        storageCartDataInLocal();
    });


    function invoiceConfigurationMessage(){
        if(invoice_configuration == ''){
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
        }
    }
    invoiceConfigurationMessage();


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