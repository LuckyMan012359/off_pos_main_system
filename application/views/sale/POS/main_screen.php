<?php
$invoice_configuration = $this->session->userdata('invoice_configuration');
$inv_logo_is_show = $this->session->userdata('inv_logo_is_show');
if($invoice_configuration){
    $inv_config = json_decode($invoice_configuration);
    $sale_no_generate = saleNoGenerator();
    $invoice_format_or_size = $inv_config->invoice_format_or_size;
}else{
    $sale_no_generate = '';
    $inv_config = '';
    $invoice_format_or_size = '';
}
$grocery_experience = $this->session->userdata('grocery_experience');
$generic_name_search_option = $this->session->userdata('generic_name_search_option');
$is_collapse = $this->session->userdata('is_collapse');
$getCompanyInfo = getCompanyInfo();
$payment_info = getCompanyPaymentMethod();
$biiPP = biiPP();
if($biiPP){
    $pakl = 'silver';
}else{
    $pakl = '';
}

$wl = getWhiteLabel();
$site_name = '';
$site_footer = '';
$site_title = '';
$site_link = '';
$site_logo = '';
$site_favicon = '';
if($wl){
    if($wl->site_name){
        $site_name = $wl->site_name;
    }
    if($wl->site_footer){
        $site_footer = $wl->site_footer;
    }
    if($wl->site_title){
        $site_title = $wl->site_title;
    }
    if(isset($wl->site_link) && $wl->site_link){
        $site_link = $wl->site_link;
    }
    if($wl->site_logo){
        $site_logo = base_url()."uploads/site_settings/".$wl->site_logo;
    }
    if($wl->site_favicon){
        $site_favicon = base_url()."uploads/site_settings/".$wl->site_favicon;
    }
}
$s_status = ((defined('FCCPATH') && FCCPATH) ? FCCPATH : '');
$company_short_name =  $getCompanyInfo->short_name;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $site_name; ?></title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo $site_favicon ?>" type="image/x-icon">
    <!-- Iconify Font -->
    <script src="<?php echo base_url(); ?>assets/iconify/js/iconify.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/POS/js/jquery-3.3.1.min.js"></script>
    <script src="<?php echo base_url(); ?>frequent_changing/js/barcode-qrcode-scanner_plugin.js"></script>
    <!-- Font Awesome 6.5.1-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/fontawesome-free-6.5.1-web/css/all.min.css?var=1.6">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/POS/css/style.css?var=1.6" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/local/google_font_POS.css?var=1.6" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/POS/css/font_awesome_all.css?var=1.6" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/POS/css/sweetalert2-new.min.css?var=1.6" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/newDesign/lib/perfect-scrollbar/dist/perfect-scrollbar.css?var=1.6">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/select2/dist/css/select2.min.css?var=1.6" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/POS/css/jquery-ui.css?var=1.6" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/POS/css/virtual_keyboard/keyboard.css?var=1.6" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/custom_theme.css?var=1.6" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/main_screen.css?var=1.6" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/pos-screen-loader.css?var=1.6" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/register_details.css?var=1.6" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/customModal.css?var=1.6" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/jquery.dataTables.min.css?var=1.6" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/buttons.dataTables.min.css?var=1.6" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/custom_check_box.css?var=1.6" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/main_screen_finalize.css?var=1.6" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/main_screen_responsive.css?var=1.6" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/newDesign/pos/js/perfect-scrollbar.css?var=1.6" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/notify/toastr.css?var=1.6" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/newDesign/pos/sass/animate.min.css?var=1.6" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/newDesign/pos/lib/date/datepicker.css?var=1.6" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/newDesign/pos/sass/scale.css?var=1.6" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/newDesign/pos/sass/tippy.css?var=1.6" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/POS/css/numpad/jquery.numpad.css?var=1.6">
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/preloader.css?var=1.6">
    <!-- POS Screen Final Responsive CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/pos_responsive.css?var=1.6" type="text/css">
    <style>
        /* for dynamic language font load, used internal css */
        /* for check change of bangla language font */
        <?php 
        if ($this->session->has_userdata('language')) {
            $font_detect = $this->session->userdata('language');
            $bd_font = "bd_font";
        } else {
            $font_detect = 'english';
        }
        if ($font_detect == "bangla") { ?>
            @font-face {
                font-family: bd_font;
                src: url(<?= base_url('/assets/SolaimanLipi.ttf') ?>);
            }
            body,
            h1,
            h2,
            h3,
            h4,
            h5,
            button,
            h6 {
                font-family: <?= $bd_font ?>;
            }
            * {
                font-family: <?= $bd_font ?>;
            }
            .showSweetAlert {
                font-family: <?= $bd_font ?>;
            }
        <?php } else { ?>
            * {
                font-family: Outfit, sans-serif;
            }
            .slimScrollDivCategory .category_button {
                font-family: Outfit, sans-serif;
            }
        <?php } ?>
        .biponi_silver iconify-icon{
            color: #d1440c !important;
            padding-left: 5px;
        }

        #reader {
            width: 100%; 
        }
    </style>
</head>


<body>

    <input type="hidden" id="fccpath" value="<?php echo $s_status?>">
    <!-- Preloader HTML -->
    <div class="main-preloader">
        <div class="loadingio-spinner-spin-nq4q5u6dq7r"><div class="ldio-x2uulkbinbj">
        <div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div></div></div>
    </div>



    <!-- Hidden Input For JS -->
    <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
    <input type="hidden" id="draft_sale_customer_status" value="No">
    <input type="hidden" id="last_sale_id" value="<?php echo escape_output(getLastSaleId()) ?>">
    <input type="hidden" id="role" value="<?php echo escape_output($this->session->userdata('role')); ?>">
    <input type="hidden" id="register_status" value="<?php echo escape_output($this->session->userdata('register_status')); ?>">
    <input type="hidden" id="csrf_value_" value="<?php echo escape_output($this->security->get_csrf_hash()); ?>">
    <input type="hidden" id="currency" value="<?php echo escape_output($this->session->userdata('currency')); ?>">
    <input type="hidden" id="op_precision" value="<?php echo escape_output($this->session->userdata('precision'))?>">
    <input type="hidden" id="op_decimals_separator" value="<?php echo escape_output($this->session->userdata('decimals_separator'))?>">
    <input type="hidden" id="op_thousands_separator" value="<?php echo escape_output($this->session->userdata('thousands_separator'))?>">
    <input type="hidden" id="tax_is_gst" value="<?php echo escape_output($this->session->userdata('tax_is_gst')); ?>">
    <input type="hidden" id="csrf_name_" value="<?php echo escape_output($this->security->get_csrf_token_name()); ?>">
    <input type="hidden" id="collect_tax" value="<?php echo escape_output($this->session->userdata('collect_tax')); ?>">
    <input type="hidden" id="currency_hidden" value="<?php echo escape_output($this->session->userdata('currency'));?>">
    <input type="hidden" id="print_format" value="<?php echo $invoice_format_or_size; ?>">
    <input type="hidden" id="invoice_configuration" value="<?php echo $invoice_configuration; ?>">
    <input type="hidden" id="invoice_print" value="<?php echo escape_output($this->session->userdata('invoice_print')); ?>">
    <input type="hidden" id="op_date_format" value="<?php echo escape_output($this->session->userdata('date_format')); ?>">
    <input type="hidden" id="gst_state_code" value="<?php echo escape_output($this->session->userdata('gst_state_code')); ?>">
    <input type="hidden" id="direct_cart" value="<?php echo escape_output($this->session->userdata('direct_cart')); ?>">
    <input type="hidden" id="default_customer" value="<?php echo escape_output($this->session->userdata('default_customer'));?>">
    <input type="hidden" id="sms_enable_status" value="<?php echo escape_output($getCompanyInfo->sms_enable_status);?>">
    <input type="hidden" id="smtp_enable_status" value="<?php echo escape_output($getCompanyInfo->smtp_enable_status);?>">
    <input type="hidden" id="send_invoice_whatsapp" value="<?php echo escape_output($getCompanyInfo->whatsapp_invoice_enable_status);?>">
    <input type="hidden" id="default_payment_hidden" value="<?php echo escape_output($this->session->userdata('default_payment'));?>">
    <input type="hidden" id="pos_total_payable_type" value="<?php echo escape_output($this->session->userdata('pos_total_payable_type')); ?>">
    <input type="hidden" id="onscreen_keyboard_status" value="<?php echo escape_output($this->session->userdata('onscreen_keyboard_status')); ?>">
    <input type="hidden" id="view_purchase_price" value="<?php echo escape_output($this->session->userdata('view_purchase_price')); ?>">
    <input type="hidden" id="tax_type" value="<?php echo escape_output($this->session->userdata('tax_type')); ?>">
    <input type="hidden" id="stripe_publish_key" value="<?php echo $payment_info->stripe_publishable_key; ?>"><input type="hidden" id="scrollwindow" value="<?php echo base_url()?>">
    <input type="hidden" id="grocery_experience" value="<?php echo escape_output($this->session->userdata('grocery_experience')); ?>">
    <input type="hidden" id="generic_name_search_option" value="<?php echo escape_output($this->session->userdata('generic_name_search_option')); ?>">
    <input type="hidden" id="business_name" value="<?php echo escape_output($this->session->userdata('business_name')); ?>">
    <input type="hidden" id="outlet_address" value="<?php echo escape_output($this->session->userdata('address')); ?>">
    <input type="hidden" id="outlet_name" value="<?php echo escape_output($this->session->userdata('outlet_name')); ?>">
    <input type="hidden" id="outlet_id" value="<?php echo escape_output($this->session->userdata('outlet_id')); ?>">
    <input type="hidden" id="outlet_email" value="<?php echo escape_output($this->session->userdata('outlet_email')); ?>">
    <input type="hidden" id="outlet_phone" value="<?php echo escape_output($this->session->userdata('phone')); ?>">
    <input type="hidden" id="tax_title" value="<?php echo escape_output($this->session->userdata('tax_title')); ?>">
    <input type="hidden" id="tax_registration_no" value="<?php echo escape_output($this->session->userdata('tax_registration_no')); ?>">
    <input type="hidden" id="given_amount_ln" value="<?php echo lang('given_amount') ?>">
    <input type="hidden" id="change_amount_ln" value="<?php echo lang('change_amount') ?>">
    <input type="hidden" id="payment_method_ln" value="<?php echo lang('payment_method') ?>">
    <input type="hidden" id="due_amount_ln" value="<?php echo lang('due_amount') ?>">
    <input type="hidden" id="paid_amount_ln" value="<?php echo lang('paid_amount') ?>">
    <input type="hidden" id="total_payable_ln" value="<?php echo lang('total_payable') ?>">
    <input type="hidden" id="charge_ln" value="<?php echo lang('charge') ?>">

    <div class="d-none" id="term_conditions"><?php echo $this->session->userdata('term_conditions'); ?></div>
    <div class="d-none" id="invoice_footer"><?php echo $this->session->userdata('invoice_footer'); ?></div>

    <input type="hidden" id="letter_head_gap" value="<?php echo $this->session->userdata('letter_head_gap'); ?>">
    <input type="hidden" id="letter_footer_gap" value="<?php echo $this->session->userdata('letter_footer_gap'); ?>">
    
    <input type="hidden" id="order_object">
    <input type="hidden" id="is_offline_system">
    <input type="hidden" id="last_sale_no" value="<?php echo $sale_no_generate;?>">
    <input type="hidden" id="invoice_logo_session" value="<?php echo $this->session->userdata('invoice_logo'); ?>">
    <input type="hidden" id="Place_Order" value="<?php echo lang('Place_Order');?>">
    <input type="hidden" id="tax_ln" value="<?php echo lang('tax');?>">
    <input type="hidden" id="sub_total_ln" value="<?php echo lang('sub_total');?>">
    <input type="hidden" id="finalize_update_type">
    <input type="hidden" id="customer_credit_limit">
    <input type="hidden" id="customer_previous_due">
    <input type="hidden" id="customer" value="<?php echo lang('customer');?>">
    <input type="hidden" id="alert_check" name="alert_check">
    <input type="hidden" id="ok" value="<?php echo lang('ok'); ?>">
    <input type="hidden" id="yes" value="<?php echo lang('yes');?>">
    <input type="hidden" id="dummy_data_delete_alert" value="<?php echo lang('dummy_data_delete_alert');?>">
    <input type="hidden" id="pharmacy_search_place_holder_pos" value="<?php echo lang('pharmacy_search_place_holder_pos');?>">
    <input type="hidden" id="other_search_place_holder_pos" value="<?php echo lang('other_search_place_holder_pos');?>">
    <input type="hidden" id="The" value="<?php echo lang('The'); ?>">
    <input type="hidden" id="selected_invoice_sale_customer" value="">
    <input type="hidden" id="alert" value="<?php echo lang('alert'); ?>">
    <input type="hidden" id="phone_ln" value="<?php echo lang('phone'); ?>">
    <input type="hidden" id="email_ln" value="<?php echo lang('email'); ?>">
    <input type="hidden" id="cancel" value="<?php echo lang('cancel'); ?>">
    <input type="hidden" id="note_lan" value="<?php echo lang('note');?>">
    <input type="hidden" id="no_hold" value="<?php echo lang('no_hold'); ?>">
    <input type="hidden" id="a_error" value="<?php echo lang('a_error'); ?>">
    <input type="hidden" id="select" value="<?php echo lang('select'); ?>">
    <input type="hidden" id="amount_txt" value="<?php echo lang('amount'); ?>">
    <input type="hidden" id="no_access" value="<?php echo lang('no_access'); ?>">
    <input type="hidden" id="check_no_lan" value="<?php echo lang('check_no');?>">
    <input type="hidden" id="cart_empty" value="<?php echo lang('cart_empty'); ?>">
    <input type="hidden" id="mobile_no_lan" value="<?php echo lang('mobile_no');?>">
    <input type="hidden" id="edit_warning" value="<?php echo lang('edit_warning'); ?>">
    <input type="hidden" id="already_added" value="<?php echo lang('Already_added'); ?>">
    <input type="hidden" id="add_to_cart_text" value="<?php echo lang('add_to_cart'); ?>">
    <input type="hidden" id="paypal_email_lan" value="<?php echo lang('paypal_email');?>">
    <input type="hidden" id="stripe_email_lan" value="<?php echo lang('stripe_email');?>">
    <input type="hidden" id="sale_date1" value="<?php echo escape_output(date("Y-m-d"))?>">
    <input type="hidden" id="cart_not_empty" value="<?php echo lang('cart_not_empty'); ?>">
    <input type="hidden" id="loyalty_point_txt" value="<?php echo lang('loyalty_point'); ?>">
    <input type="hidden" id="transaction_no_lan" value="<?php echo lang('transaction_no');?>">
    <input type="hidden" id="register_close_text" value="<?php echo lang('register_close'); ?>">
    <input type="hidden" id="field_is_required" value="<?php echo lang('field_is_required'); ?>">
    <input type="hidden" id="item_modal_status" value="<?php echo lang('item_modal_status'); ?>">
    <input type="hidden" id="select_a_customer" value="<?php echo lang('select_a_customer'); ?>">
    <input type="hidden" id="card_holder_name_lan" value="<?php echo lang('card_holder_name');?>">
    <input type="hidden" id="check_issue_date_lan" value="<?php echo lang('check_issue_date');?>">
    <input type="hidden" id="check_expiry_date_lan" value="<?php echo lang('check_expiry_date');?>">
    <input type="hidden" id="loyalty_point_error" value="<?php echo lang('loyalty_point_error'); ?>">
    <input type="hidden" id="add_at_least_one_qty" value="<?php echo lang('add_at_least_one_qty'); ?>">
    <input type="hidden" id="sure_delete_this_sale" value="<?php echo lang('sure_delete_this_sale');?>">
    <input type="hidden" id="card_holding_number_lan" value="<?php echo lang('card_holding_number');?>">
    <input type="hidden" id="last_future_sale_id" name="last_future_sale_id" class="last_future_sale_id">
    <input type="hidden" id="sure_delete_this_hold" value="<?php echo lang('sure_delete_this_hold'); ?>">
    <input type="hidden" id="sure_delete_this_order" value="<?php echo lang('sure_delete_this_order'); ?>">
    <input type="hidden" id="please_select_an_order" value="<?php echo lang('please_select_an_order'); ?>">
    <input type="hidden" id="tool_tip_loyalty_point" value="<?php echo lang('tool_tip_loyalty_point'); ?>">
    <input type="hidden" id="please_select_hold_sale" value="<?php echo lang('please_select_hold_sale'); ?>">
    <input type="hidden" id="no_permission_for_this_module" value="<?php echo lang('no_permission_for_this_module'); ?>">
    <input type="hidden" id="product_display" value="<?php echo escape_output($this->session->userdata('product_display')); ?>">
    <input type="hidden" id="The_discount_code_field_required" value="<?php echo lang('The_discount_code_field_required'); ?>">
    <input type="hidden" id="The_coupon_code_field_required" value="<?php echo lang('The_coupon_code_field_required'); ?>">
    <input type="hidden" id="cart_not_empty_want_to_clear" value="<?php echo lang('cart_not_empty_want_to_clear'); ?>">
    <input type="hidden" id="are_you_delete_all_hold_sale" value="<?php echo lang('are_you_delete_all_hold_sale'); ?>">
    <input type="hidden" id="loyalty_rate" value="<?php echo escape_output($this->session->userdata('loyalty_rate'))?>">
    <input type="hidden" id="loyalty_point_is_not_available" value="<?php echo lang('loyalty_point_is_not_available'); ?>">
    <input type="hidden" id="Alternative_Medicine_will_shown_here" value="<?php echo lang('Alternative_Medicine_will_shown_here'); ?>">
    <input type="hidden" id="default_cursor_position" value="<?php echo escape_output($this->session->userdata('default_cursor_position')); ?>">
    <input type="hidden" id="your_added_payment_method_will_remove" value="<?php echo lang('your_added_payment_method_will_remove'); ?>">
    <input type="hidden" id="loyalty_point_not_applicable" value="<?php echo lang('loyalty_point_not_applicable_for_walk_in_customer'); ?>">
    <input type="hidden" id="authorized_signature_ln" value="<?php echo lang('authorized_signature'); ?>">
    <input type="hidden" id="challan_ln" value="<?php echo lang('Challan'); ?>">
    <input type="hidden" id="copy_db_exp" value="<?php echo lang('copy'); ?>">
    <input type="hidden" id="print_db_exp" value="<?php echo lang('print'); ?>">
    <input type="hidden" id="excel_db_exp" value="<?php echo lang('excel'); ?>">
    <input type="hidden" id="csv_db_exp" value="<?php echo lang('csv'); ?>">
    <input type="hidden" id="pdf_db_exp" value="<?php echo lang('pdf'); ?>">
    <input type="hidden" id="pdf_db_exp" value="<?php echo lang('pdf'); ?>">
    <input type="hidden" id="invoice_ln" value="<?php echo lang('invoice'); ?>">
    <input type="hidden" id="bill_to_ln" value="<?php echo lang('bill_to'); ?>">
    <input type="hidden" id="invoice_no_ln" value="<?php echo lang('invoice_no'); ?>">
    <input type="hidden" id="date_ln" value="<?php echo lang('date'); ?>">
    <input type="hidden" id="item_ln" value="<?php echo lang('item'); ?>">
    <input type="hidden" id="code_ln" value="<?php echo lang('code'); ?>">
    <input type="hidden" id="brand_ln" value="<?php echo lang('brand'); ?>">
    <input type="hidden" id="sn_ln" value="<?php echo lang('sn'); ?>">
    <input type="hidden" id="unit_price_ln" value="<?php echo lang('unit_price'); ?>">
    <input type="hidden" id="qty_ln" value="<?php echo lang('qty'); ?>">
    <input type="hidden" id="discount_ln" value="<?php echo lang('discount'); ?>">
    <input type="hidden" id="total_ln" value="<?php echo lang('total'); ?>">


    <!-- Hidden Input For JS End -->
    <span class="loader1"></span>
    <span class="loader"></span>
    <span id="stop_refresh_for_search" class="d-none"><?php echo lang('yes'); ?></span>

    <!-- Start Header Wrap -->
    <div class="wrapper fix">
        <!-- Header Desktop Area -->
        <div class="top_header_part">
            <!-- Left Header Menu List -->
            <div class="left_item">
                <div class="header_part_middle">
                    <ul class="icon__menu">
                        <li class="has__children main_menu">
                            <a tabindex="-1" href="javascript:void(0)" class="header_menu_icon dropdown-menu" data-tippy-content="<?php echo lang('Main_Menu');?>">
                                <iconify-icon icon="solar:user-check-broken" width="22"></iconify-icon>
                            </a>
                            <ul class="sub__menu custom_dropdown" role="menu">
                                <li>
                                    <a tabindex="-1" href="<?php echo base_url();?>User/changeProfile" class="offline_prevent"><?php echo lang('change_profile');?></a>
                                </li>
                                <li>
                                    <a tabindex="-1" href="<?php echo base_url();?>User/changePassword" class="offline_prevent"><?php echo lang('change_password');?></a>
                                </li>
                                <li>
                                    <a tabindex="-1" href="<?php echo base_url();?>User/securityQuestion" class="offline_prevent"><?php echo lang('SetSecurityQuestion');?></a>
                                </li>
                                <li>
                                    <a tabindex="-1" class="logOutTrigger offline_prevent" href="javascript:void(0)"><?php echo lang('logout');?></a>
                                </li>
                            </ul>
                        </li>
                        <!-- Langulage -->
                        <li class="has__children languages">
                            <?php $language=$this->session->userdata('language');
                                $icon = "usd";
                            ?>
                            <a tabindex="-1" href="javascript:void(0)" class="header_menu_icon dropdown-menu" data-tippy-content="<?php echo lang('Language');?>">
                            <iconify-icon icon="ion:language" width="22"></iconify-icon>
                            </a>
                            <ul class="sub__menu" role="menu">
                                <?php
                                $dir = glob("application/language/*",GLOB_ONLYDIR);
                                foreach ($dir as $value):
                                    $separete = explode("language/",$value);?>
                                    <li data-lang="English">
                                        <a tabindex="-1" class="offline_prevent" href="<?php echo base_url()?>Authentication/setlanguage/<?php echo escape_output($separete[1])?>"> <span><?php echo ucfirstcustom($separete[1])?></span>
                                        </a>
                                    </li>
                                <?php
                                endforeach;
                                ?>
                            </ul>
                        </li>
                        <!-- Langulage End-->
                        <li>
                            <a tabindex="-1" href="javascript:void(0)" id="open_hold_sales" class="header_menu_icon" data-tippy-content="<?php echo lang('Open_Draft_Sales');?>">
                            <iconify-icon icon="solar:adhesive-plaster-broken" width="22"></iconify-icon>
                            </a>
                        </li>
                        <li><a tabindex="-1" href="javascript:void(0)" class="header_menu_icon" id="print_last_invoice" data-tippy-content="<?php echo lang('print_last_invoice');?>"><iconify-icon icon="solar:printer-broken" width="22"></iconify-icon></a></li>
                        <li>
                            <a tabindex="-1" href="javascript:void(0)" id="last_ten_sales_button" class="header_menu_icon" data-tippy-content="<?php echo lang('Recent_Sales');?>"><iconify-icon icon="solar:history-broken" width="22"></iconify-icon></a>
                        </li>
                        <li>
                            <a tabindex="-1" href="javascript:void(0)" id="calculator_button" class="header_menu_icon calculator_button" data-tippy-content="<?php echo lang('calculator');?>"> <iconify-icon icon="solar:calculator-minimalistic-broken" width="22"></iconify-icon>
                            </a>
                        </li>
                        <li>
                            <a tabindex="-1" href="javascript:void(0)" id="register_details" class="header_menu_icon register_details" data-tippy-content="<?php echo lang('register');?>">
                            <iconify-icon icon="solar:document-add-broken" width="22"></iconify-icon>
                            </a>
                        </li>
                        <li>
                            <a tabindex="-1" href="javascript:void(0)" id="keyboard_short_cut" class="header_menu_icon " data-tippy-content="<?php echo lang('keyboard_short_cut');?>">
                            <iconify-icon icon="solar:keyboard-broken" width="22"></iconify-icon>
                            </a>
                        </li>
                        <li>
                            <a tabindex="-1" href="<?php echo base_url();?>Dashboard/dashboard" target="_blank" class="header_menu_icon offline_prevent" data-tippy-content="<?php echo lang('dashboard');?>">
                            <iconify-icon icon="solar:chart-2-broken" width="22"></iconify-icon>
                            </a>
                        </li>
                        <li>
                            <a tabindex="-1" href="<?php echo base_url()?>customer-panel" class="header_menu_icon offline_prevent" target="_blank" data-tippy-content="<?php echo lang('customer_panel');?>">
                            <iconify-icon icon="solar:monitor-broken" width="22"></iconify-icon>
                            </a>
                        </li>
                    </ul>
                    <ul class="icon__menu">
                        <li>
                            <a tabindex="-1" href="javascript:void(0)" class="time__date">
                            <iconify-icon icon="solar:clock-circle-broken" width="22"></iconify-icon>
                            </a>
                        </li>
                        <li>
                            <a tabindex="-1" href="javascript:void(0)" class="header_menu_icon fullscreen" data-tippy-content="<?php echo lang('Full_Screen');?>">
                                <iconify-icon icon="solar:maximize-square-3-broken" width="22"></iconify-icon>
                            </a>
                        </li>
                        <li>
                            <a tabindex="-1" href="javascript:void(0)" data-tippy-content="<?php echo lang('Main_Menu');?>" id="open__menu" class="header_menu_icon offline_prevent">
                                <iconify-icon icon="ri:menu-fold-fill" width="22"></iconify-icon>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Left Header Menu List End-->

            <!-- Right Header Menu List -->
            <div class="header_part_right">
                <span class="header-outlet">
                    <?php echo limitWords($this->session->userdata('outlet_name'), '1'); ?>
                </span>
                <ul class="btn__menu">
                    <?php if (APPLICATION_MODE == 'demo' && APPLICATION_DEMO_TYPE == 'Pharmacy') {?>
                    <li data-tippy-content="Video Tutorial of Medicine and Grocery Experience">
                        <a href="javascript:void(0)" class="bg__blue btn_video_tutorial">
                            <iconify-icon icon="solar:videocamera-broken" width="22"></iconify-icon>
                        </a>
                    </li>
                    <?php } ?>
                    <li>
                        <div class="switchary_wrap" <?php echo APPLICATION_MODE == 'demo' ? 'data-tippy-content="This button is disabled for demo. to check medicine shop experience please check medicine demo!"' : '' ?>>
                            <select id="grocery_experience_el" class="select2" <?php echo APPLICATION_MODE == 'demo' ? 'disabled' : '' ?>>
                                <option value=""><?php echo lang('POS_Experience');?></option>
                                <option value="Regular" <?php echo $grocery_experience == 'Regular' ? 'selected' : ''?>><?php echo lang('Regular');?></option>
                                <option value="Medicine" <?php echo $grocery_experience == 'Medicine' ? 'selected' : ''?>><?php echo lang('Medicine');?></option>
                                <option value="Grocery" <?php echo $grocery_experience == 'Grocery' ? 'selected' : ''?>><?php echo lang('Grocery');?></option>
                            </select>
                        </div>
                    </li>
                    <li class="has__children">
                        <a tabindex="-1" href="javascript:void(0)" class="bg__green online_sync d-flex align-items-center me-2">
                            <iconify-icon icon="solar:refresh-circle-broken"></iconify-icon>
                            <span class="online_offline_txt">Online</span> 
                            <span class="sync_counter"></span>
                        </a>
                    </li>
                    <li>
                        <a tabindex="-1" href="javascript:void(0)" data-id="" class="bg__blue button_category_show_all"><?php echo lang('all');?></a>
                    </li>
                    <li class="has__children">
                        <a tabindex="-1" href="javascript:void(0)" class="show__brand__list bg__blue off-pos-open-dropdown-menu"><?php echo lang('brand');?></a>
                        <div class="submenu-wrapper">
                            <ul class="sub__menu brand__sub__menu">
                                <li>
                                    <a tabindex="-1" href="javascript:void(0)" data-id="" class="category_button button_category_show_all brand_all_category"><?php echo lang('all');?></a>
                                </li>
                                <?php
                                    $i = 1;
                                    foreach($brands as $brand):
                                        if($brand->name!="N/A"):
                                            if($i = 1):
                                ?>
                                <li>
                                    <a tabindex="-1" href="javascript:void(0)" class="brand_button" id="brand_category_<?=$brand->id?>">
                                    <?=$brand->name?>
                                    </a>
                                </li>
                                <?php else:?>
                                <li>
                                    <a tabindex="-1" href="javascript:void(0)" class="brand_button" id="brand_category_<?=$brand->id?>">
                                    <?=$brand->name?>
                                    </a>
                                </li>
                                <?php endif; endif; endforeach;?>
                            </ul>
                        </div>
                    </li>

                    <li class="has__children sorting_item_wrapper">
                        <a href="javascript:void(0)" class="bg__blue off-pos-open-dropdown-menu sorting_item_title"><?php echo lang('Most_Selling');?></a>
                        <div class="submenu-wrapper">
                            <ul class="sub__menu">
                                <li><a tabindex="-1" data-sort_id="1" class="sorting_item" href="javascript:void(0)"><?php echo lang('Most_Selling');?></a></li>
                                <li><a tabindex="-1" data-sort_id="2" class="sorting_item" href="javascript:void(0)"><?php echo lang('less_selling');?></a></li>
                                <li><a tabindex="-1" data-sort_id="3" class="sorting_item" href="javascript:void(0)"><?php echo lang('not_selling');?></a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="has__children">
                        <a tabindex="-1" href="javascript:void(0)" class="bg__blue promo_filter offline_prevent"><?php echo lang('Promo');?></a>
                    </li>
                </ul>
            </div>
            <!-- Right Header Menu List End -->
        </div>
        <!-- Header Desktop Area End -->


        <!-- Start Mobile  Top Header -->
        <div class="top_header_for_mobile">
            <div class="for-mobile-mode">
                <button type="button" class="show_product bg__grey">
                    <iconify-icon iconify-icon icon="solar:list-heart-minimalistic-linear" width="22"></iconify-icon> <span><?php echo lang('products');?></span>
                </button>
                <button type="button" class="show_cart_list bg_hold">
                    <iconify-icon icon="solar:cart-3-line-duotone" width="22"></iconify-icon>
                    <span><?php echo lang('cart');?></span>
                    <span class="mobile_cart_count"></span>
                </button>
                <button type="button" class="show_all_menu bg__green">
                    <iconify-icon icon="solar:adhesive-plaster-outline" width="22"></iconify-icon>
                    <span><?php echo lang('Others');?></span>
                </button>
            </div>
        </div>
        <!-- End Mobile  Top Header -->


        <!-- Start Main Mart -->
        <div id="main_part" class="<?php echo $grocery_experience == 'Medicine' ? 'grocery_main_part_on' : ($grocery_experience == 'Grocery' ? 'grocery_main_part_on main_part_pharmacy' : ($grocery_experience == 'Regular' ? 'grocery_main_part_off main_part_pharmacy' : ''));?>">
            <div class="main_middle">
                <div class="main_top">
                    <div class="waiter_customer">
                        <div class="single_button_middle_holder">
                            <div class="search-holder">
                                <div class="user_panner">
                                    <select name="select_employee_id" id="select_employee_id" class="select2" tabindex="1">
                                        <option value=""><?php echo lang('select_employee'); ?></option>
                                        <?php
                                        $logedin_user = $this->session->userdata('user_id');
                                        foreach ($waiters as $value):
                                            if($value->id!=1):
                                        ?>
                                        <option <?php echo escape_output($value->id) == $logedin_user ? 'selected' : '' ?> value="<?php echo escape_output($value->id) ?>"><?php echo escape_output($value->full_name)?></option>
                                        <?php
                                        endif;
                                        endforeach;
                                        ?>
                                    </select>
                                </div>
                                <div class="customer_pannel">
                                    <select id="walk_in_customer"  class="select2" tabindex="2">
                                    </select>
                                    <input type="hidden" name="old_sale_id" id="old_sale_id" value="<?php echo isset($sale_id) && $sale_id ? $sale_id : ''; ?>">
                                </div>
                            </div>
                            <div id="edit_add_customer_button_section">
                                <a class="new-btn offline_prevent" id="edit_customer" href="javascript:void(0)">
                                    <iconify-icon icon="solar:pen-broken" width="22"></iconify-icon>
                                </a>
                                <a class="new-btn offline_prevent" id="plus_button" href="javascript:void(0)">
                                    <iconify-icon icon="solar:add-circle-broken" width="22"></iconify-icon>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="main_center">
                    <div class="order_table_holder">
                        <div class="order_table_header_row">
                            <div class="single_header_column" id="single_order_item"><?php echo lang('item'); ?></div>
                            <div class="single_header_column" id="single_order_price"><?php echo lang('price'); ?></div>
                            <div class="single_header_column" id="single_order_qty"><?php echo lang('qty'); ?></div>
                            <div class="single_header_column" id="single_order_discount"><?php echo lang('discount'); ?></div>
                            <div class="single_header_column" id="single_order_total"><?php echo lang('sub_total'); ?></div>
                        </div>
                        
                        <div class="order_holder">
                            <?php
                            if(!empty($sale_item_details)){
                                $loop_iteration = 1;
                                // pre($sale_item_details);
                                foreach($sale_item_details as $sale_details){
                            ?>
                                <div data-variation-parent="<?php echo escape_output($sale_details->parent_id); ?>" class="single_order" is_promo="<?php echo escape_output($sale_details->is_promo_item); ?>" data-qty_default="<?php echo escape_output($sale_details->qty); ?>" data-sale-unit="<?php echo escape_output($sale_details->unit_name); ?>"  id="order_for_item_<?php echo escape_output($sale_details->food_menu_id); ?>" data_cart_item_id="<?php echo escape_output($sale_details->food_menu_id); ?>">
                                    <div class="first_portion">
                                        <span id="item_seller_table<?php echo escape_output($sale_details->food_menu_id); ?>" class="d-none">
                                            <?php echo escape_output($sale_details->item_IMEI_Serial ?? ''); ?>
                                        </span>
                                        <span class="item_type d-none" id="item_type_table<?php echo escape_output($sale_details->food_menu_id); ?>">
                                            <?php echo escape_output($sale_details->type); ?>
                                        </span>
                                        <span class="item_vat d-none" id="item_vat_percentage_table<?php echo escape_output($sale_details->food_menu_id); ?>">
                                            <?php echo escape_output($sale_details->menu_taxes); ?>
                                        </span>
                                        <span class="item_discount d-none" id="item_discount_table<?php echo escape_output($sale_details->food_menu_id); ?>">
                                            <?php echo escape_output($sale_details->discount_amount); ?>
                                        </span>
                                        <span class="item_price_without_discount d-none" id="item_price_without_discount_<?php echo escape_output($sale_details->food_menu_id); ?>">
                                            <?php echo escape_output($sale_details->menu_price_without_discount); ?>
                                        </span>
                                        <div class="single_order_column first_column">
                                            <iconify-icon icon="solar:pen-broken" class="op_cursor_pointer edit_item" id="edit_item_<?php echo escape_output($sale_details->food_menu_id); ?>" width="22"></iconify-icon>
                                            <span id="item_name_table_<?php echo escape_output($sale_details->food_menu_id); ?>">
                                                <?php echo escape_output($sale_details->item_name) . '(' . $sale_details->item_code . ')'; ?>
                                            </span>
                                        </div>
                                        <div class="single_order_column second_column">
                                            <span id="item_price_table_<?php echo escape_output($sale_details->food_menu_id); ?>">
                                                <?php echo getAmtPre($sale_details->menu_unit_price); ?>
                                            </span>
                                        </div>
                                        
                                        <div class="single_order_column third_column">
                                            <iconify-icon icon="uil:minus" class="decrease_item_table op_cursor_pointer" id="decrease_item_table_<?php echo escape_output($sale_details->food_menu_id); ?>" width="22"></iconify-icon>
                                            <span class="cart_quantity" id="item_quantity_table_<?php echo escape_output($sale_details->food_menu_id); ?>">
                                                <?php echo escape_output($sale_details->qty); ?>
                                            </span>
                                            <iconify-icon icon="uil:plus" class="increase_item_table op_cursor_pointer" id="increase_item_table_<?php echo escape_output($sale_details->food_menu_id); ?>" width="22"></iconify-icon>
                                        </div>
                                        <div class="single_order_column forth_column">
                                            <input type=""  onfocus="select();" inline_dis_column="" placeholder="Amt or %" class="special_textbox access_control inline_dis_column" id="percentage_table_<?php echo escape_output($sale_details->food_menu_id); ?>" data-discount_for_edit="<?php echo escape_output($sale_details->menu_discount_value); ?>" value="<?php echo escape_output($sale_details->menu_discount_value); ?>">
                                        </div>
                                        <div class="single_order_column fifth_column">
                                            <span id="item_total_price_table_<?php echo escape_output($sale_details->food_menu_id); ?>">
                                                <?php echo getAmtPre($sale_details->menu_price_with_discount); ?>
                                            </span>
                                            <iconify-icon icon="solar:trash-bin-minimalistic-broken" data-remove-order-row-no="<?php echo $loop_iteration; ?>" class="remove_this_item_from_cart" width="22"></iconify-icon>
                                        </div>
                                    </div>

                                    <!-- IMEI, Serial,Expiry -->
                                    <?php 
                                    if($sale_details->type == 'IMEI_Product' || $sale_details->type == 'Serial_Product' || $sale_details->type == 'Medicine_Product'){ ?>
                                        <span class="imei_serial_note" id="expiry_imei_serial"><?php echo checkItemShortType($sale_details->type) ?>: 
                                            <span class="expiry_imei_serial_<?php echo escape_output($sale_details->food_menu_id); ?>">
                                                <?php echo trim($sale_details->expiry_imei_serial); ?>
                                            </span>
                                        </span>
                                    <?php } ?>
                                    <!-- Item Note -->
                                    <span class="cart_item_modal_des item_modal_description_table_<?php echo escape_output($sale_details->food_menu_id); ?>">
                                        <?php if($sale_details->menu_note != ''){echo trim($sale_details->menu_note);}?>
                                    </span>

                                    <!-- Promotion And Discount -->
                                    <?php 
                                    if($sale_details->is_promo_item == 'Yes'){
                                        $getFreeItem = getFreeItemBySaleDetailsId($sale_details->id);
                                        if($getFreeItem){
                                            foreach($getFreeItem as $f_item){
                                        ?>
                                        <div class="free-item free_item_div_<?php echo escape_output($sale_details->food_menu_id) ?>" data-free-item-id="<?php echo escape_output($f_item->food_menu_id) ?>" data-get_fm_id="<?php echo escape_output($f_item->promo_parent_id) ?>" data-is_free="Yes">
                                            <div data-id="<?php echo escape_output($f_item->food_menu_id) ?>" class="customer_panel single_order_column first_column">
                                                <iconify-icon icon="solar:pen-broken" class="op_cursor_pointer free_edit_item" width="22" data-parent_id=""></iconify-icon>
                                                <span class="4_cp_name_<?php echo escape_output($sale_details->food_menu_id) ?>" id="free_item_name_table_<?php echo escape_output($sale_details->food_menu_id) ?>"><?php echo escape_output($sale_details->item_name) . '(' . $sale_details->item_code . ')'; ?></span>
                                            </div>
                                            <div class="single_order_column second_column text-center"> 
                                                <span id="free_item_price_table_<?php echo escape_output($sale_details->food_menu_id) ?>"><?php echo getAmtPre(0);?></span>
                                            </div>
                                            <div class="single_order_column third_column">
                                                <i class="fas fa-minus alert_free_item_increase decrease_item_table"></i> 
                                                <span class="4_cp_qty_<?php echo escape_output($sale_details->food_menu_id) ?> qty_item_custom cart_quantity" id="free_item_quantity_table_<?php echo escape_output($sale_details->food_menu_id) ?>"><?php echo escape_output($f_item->qty);?></span> 
                                                <i class="fas fa-plus alert_free_item_increase increase_item_table"></i>
                                            </div>
                                            <div class="single_order_column forth_column">
                                                <input type=""  onfocus="select();" placeholder="Amt or %" class="discount_cart_input" value="0" disabled>
                                            </div>
                                            <div class="single_order_column fifth_column text-right"> 
                                                <span id="free_item_total_price_table_<?php echo escape_output($sale_details->food_menu_id) ?>"><?php echo getAmtPre(0);?></span>
                                                <i data-id="<?php echo escape_output($sale_details->food_menu_id) ?>" class="free-item-remove fas fa-times-circle removeCartItemFree"></i>
                                            </div>
                                        </div>
                                    <?php } } } ?>
                                    <!-- Promotion And Discount End-->

                                    <!-- Combo Product -->
                                    <?php
                                    if($sale_details->item_type == 'Combo_Product'){
                                    $combo_items = getComboItemsBySaleDetailsId($sale_details->id);
                                    if($combo_items){
                                        foreach($combo_items as $combo){
                                    ?>
                                    <div class="combo_cart_item combo_item_div_<?php echo $combo->combo_item_id ?>"  data-is_combo="Yes">
                                        <div data-id="<?php echo $combo->combo_item_id ?>" class="customer_panel single_order_column first_column">
                                            <iconify-icon icon="solar:pen-broken" class="op_cursor_pointer" width="22" data-parent_id=""></iconify-icon>
                                            <span id="combo_item_name_table_<?php echo $combo->combo_item_id ?>"><?php echo $combo->item_name ?></span>
                                            <span id="combo_item_type_table_<?php echo $combo->combo_item_id ?>"><?php echo $combo->combo_item_type ?></span>
                                            <span class="d-none" id="combo_seller_table_<?php echo $combo->combo_item_id ?>"><?php echo $combo->combo_item_seller_id ?></span>
                                            <span class="d-none" id="combo_inv_show_table_<?php echo $combo->combo_item_id ?>"><?php echo $combo->show_in_invoice ?></span>
                                            <span class="d-none" id="combo_ifsale_table_<?php echo $combo->combo_item_id ?>">Yes</span>
                                        </div>
                                        <div class="single_order_column second_column text-center"> 
                                            <span id="combo_item_price_table_<?php echo $combo->combo_item_id ?>"><?php echo $combo->combo_item_price ?></span>
                                        </div>
                                        <div class="single_order_column third_column">
                                            <iconify-icon icon="uil:minus" class="alert_combo_item_increase op_cursor_pointer decrease_item_table" id="combo_decrease_item_table_<?php echo $combo->combo_item_id ?>" width="22"></iconify-icon>
                                            <span class="4_cp_qty_<?php echo $combo->combo_item_id ?> qty_item_custom cart_quantity" id="combo_item_quantity_table_<?php echo $combo->combo_item_id ?>"><?php echo $combo->combo_item_qty ?></span> 
                                            <iconify-icon icon="bitcoin-icons:plus-outline" class="alert_combo_item_increase op_cursor_pointer" id="increase_item_table_<?php echo $combo->combo_item_id ?>" width="22"></iconify-icon>
                                        </div>
                                        <div class="single_order_column forth_column">
                                            <input type="" name="" onfocus="select();" placeholder="Amt or %" class="discount_cart_input" value="0" disabled>
                                        </div>
                                        <div class="single_order_column fifth_column text-right"> 
                                            <span id="combo_item_total_price_table_<?php echo $combo->combo_item_id ?>"><?php echo $combo->combo_item_qty *  $combo->combo_item_price ?></span>
                                            <iconify-icon icon="solar:trash-bin-minimalistic-broken" data-id="<?php echo $combo->combo_item_id ?>" class="combo-item-remove removeCartItemCombo"></iconify-icon>
                                        </div>
                                    </div>
                                    <?php } } }?>
                                    <!-- Combo Product End-->
                                </div>
                            <?php
                                $loop_iteration ++ ;
                                }
                                }
                            ?>
                        </div>
                        <input type="hidden" id="edit_sale_customer" value="<?php echo isset($sale_item) && $sale_item->customer_id ? $sale_item->customer_id : '' ?>">
                        <input type="hidden" id="edit_sale_customer_name" value="<?php echo isset($sale_item) && $sale_item->customer_id ? getCustomerName($sale_item->customer_id) : '' ?>">
                        <input type="hidden" id="offline_edit_sale" value="">
                        <input type="hidden" id="offline_edit_sale_no" value="">
                    </div>
                </div>

                <!-- End Top Items -->
                <div id="bottom_absolute">
                    <div class="bottom__info">
                        <div class="footer__content">
                            <div class="item d-flex">
                                <span class="mr-10">
                                    <iconify-icon data-tippy-content="Note" id="open_note_modal" icon="solar:notebook-linear" class="op_cursor_pointer bottom-iconify-color" width="22"></iconify-icon>
                                </span>
                                <span class="mr-10">
                                    <iconify-icon data-get-date="" data-tippy-content="Invoice Date" id="open_date_picker" icon="solar:calendar-broken" class="icon_pick_date input-group date op_cursor_pointer datepicker_custom bottom-iconify-color" width="22"></iconify-icon>
                                </span>
                                <?php if(!moduleIsHideCheck('Promotion-YES')){ ?>
                                <span class="mr-10">
                                    <iconify-icon data-tippy-content="Coupon Discount" icon="gridicons:coupon" class="op_cursor_pointer bottom-iconify-color" id="coupon_discount_modal" width="22"></iconify-icon>
                                </span>
                                <?php } ?>
                            </div>
                            <div class="item">
                                <span class="cart-footer-title"><?php echo lang('total'); ?>: </span>
                                <span class="p-l-3" id="sub_total_show"><?php echo getAmtPre(0)?> </span>
                                <span id="sub_total" class="op_display_none"> <?php echo getAmtPre(0)?></span>
                                <span id="total_item_discount" class="op_display_none">0</span>
                                <span id="discounted_sub_total_amount" class="op_display_none"><?php echo getAmtPre(0)?></span>
                            </div>
                            <!-- End Sub Total -->
                            <div class="item">
                                <div>
                                    <span class="cart-footer-title">
                                        <?php echo lang('total_item'); ?>:
                                    </span>
                                    <span id="total_items_in_cart_without_quantity">0</span> (<span id="total_items_in_cart_with_quantity">0</span>)
                                </div>
                                <span id="total_items_in_cart" class="ir_display_none">0</span>
                                <span id="is_hold_sale_id" class="d-none">0</span>
                            </div>
                            <div class="item">
                                <span class="cart-footer-title"><?php echo lang('tax');?>:</span>
                                <iconify-icon icon="solar:eye-broken" class="bottom-iconify-color px-3 cursor-pointer" id="open_tax_modal" width="22"></iconify-icon>
                                <span id="show_vat_modal"><?php echo getAmtPre(0)?></span>
                            </div>
                            <div class="item">
                                <span class="cart-footer-title"><?php echo lang('charge'); ?>: </span>
                                <iconify-icon icon="solar:chat-round-money-broken" class="px-3 bottom-iconify-color" width="22" id="open_charge_modal"></iconify-icon>
                                <span id="show_charge_amount"><?php echo getAmtPre(isset($sale_item) && $sale_item->delivery_charge ? $sale_item->delivery_charge : 0)?></span>
                            </div>
                            <div class="item no-need-for-waiter">
                                <span class="cart-footer-title">
                                    <?php echo lang('discount'); ?>:
                                </span>
                                <iconify-icon icon="solar:chat-round-money-broken" width="22" id="open_discount_modal" class="bottom-iconify-color px-3"></iconify-icon>
                                <span id="show_discount_amount"><?php echo getAmtPre(0)?></span>
                                    (<span id="all_items_discount"><?php echo getAmtPre(0)?></span>)
                            </div>
                            <?php if(!moduleIsHideCheck('Delivery Partner-YES')){ ?>
                            <div class="item">
                                <span class="cart-footer-title"><?php echo lang('delivery_partner'); ?>: </span>
                                <iconify-icon icon="solar:users-group-rounded-broken" class="bottom-iconify-color px-3 cursor-pointer" width="22" id="open_deliverypartner_modal"></iconify-icon>
                                <span id="delivery_partner_info" data-partner-id="<?php echo (isset($sale_item) && $sale_item->delivery_partner_id ? $sale_item->delivery_partner_id : 0)?>"><?php echo getPartnerName(isset($sale_item) && $sale_item->delivery_partner_id ? $sale_item->delivery_partner_id : '') ?></span>
                            </div>
                            <?php } ?>
                            <div class="item">
                                <span class="cart-footer-title"><?php echo lang('rounding'); ?>: </span>
                                <span id="rounding" class="p-l-3"><?php echo getAmtPCustom(isset($sale_item) && $sale_item->rounding ? $sale_item->rounding : '') ?></span>
                            </div>
                            <!-- End Total Item -->
                        </div>
                        <div class="payable">
                            <h1><?php echo lang('total_payable'); ?>:  <span id="total_payable"><?php echo getAmtPre(0)?></span></h1>
                        </div>
                        <div class="main_bottom p-0">
                            <div class="button_group">
                                <div class="cart_bottom_button">
                                    <button class="bg__red off-btn d-flex align-items-center justify-content-center" id="cancel_button">
                                        <iconify-icon icon="solar:close-circle-line-duotone" width="22"></iconify-icon>
                                        <span class="p-l-3">
                                            <?php echo lang('cancel'); ?>
                                        </span>
                                    </button>
                                </div>
                                <div class="cart_bottom_buttons">
                                    <button id="hold_sale" class="bg_hold off-btn d-flex align-items-center justify-content-center">
                                        <iconify-icon icon="solar:rocket-2-line-duotone" width="22"></iconify-icon>
                                        <span class="p-l-3">
                                            <?php echo lang('hold'); ?>
                                        </span>
                                    </button>
                                </div>
                                <div class="cart_bottom_buttons">
                                    <button class="off-btn bg__green d-flex align-items-center justify-content-center" id="place_order_operation">
                                        <iconify-icon icon="solar:wad-of-money-broken" width="22"></iconify-icon>
                                        <span id="place_edit_order" class="p-l-3">
                                            <?php echo lang('payment'); ?>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Left Area -->
            <div class="main_right <?php echo ($grocery_experience == 'Medicine' || $grocery_experience == 'Grocery') ? 'main_right_m' : ''?>">
                <div class="right_side_search_add_item">
                    <div class="filter-form">
                        <div>
                            <i class="fas fa-search"></i>
                            <input class="op_dim_placeholder" type="text" autocomplete="off" name="search" id="search" autofocus placeholder="<?php echo lang('Name_or_Code_or_Category'); ?>" onfocus="this.select();">
                        </div>
                        <?php if($grocery_experience == 'Medicine'){?>
                        <div class="generic_serch_option_area">
                            <div data-tippy-content="Keep Selected to Search By Genericname">
                                <label class="container op_color_dim_grey">
                                    <input class="generic_serch_option_checkbox" type="checkbox" name="generic_serch_option_checkbox" <?php echo $generic_name_search_option == 'Yes' ? 'checked' : ''?>>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                        <?php } else{?>
                            <div></div>
                        <?php } ?>
                        <div>
                            <i class="fas fa-barcode"></i>
                            <input type="text" autocomplete="off" name="search" class="search_barcode_p" id="search_barcode" placeholder="<?php echo lang('barcode'); ?>" onfocus="this.select();">
                            <button class="bg__blue h-40 m-l-5" id="barcode_open_trigger">Barcode</button>
                        </div>
                    </div>
                </div>
                <div class="op_position_relative" id="main_item_holder">
                    <?php if($grocery_experience == 'Regular') { ?>
                    <div class="slimScrollDivCategory">
                        <button class="category_button op_margin_bottom_5 op_box_shadow op_mb_10 element element-2 button_category_show_all button_category_show_all_left category_active_design" data-id=""><?php echo lang('All'); ?></button>
                        <?php
                        $i = 1;
                        foreach($item_categories as $single_category):
                            if($single_category->name!="N/A"):
                                if($i = 1):
                        ?>
                        <button class="category_button category_active_trigger op_width_100_p op_margin_bottom_6 op_box_shadow op_mb_10" data-id="<?=$single_category->id?>"><?=$single_category->name?></button>
                        <?php
                                else:
                        ?>
                        <button class="category_button category_active_trigger op_width_100_p op_margin_bottom_6 op_box_shadow op_mb_10" data-id="<?=$single_category->id?>"><?=$single_category->name?></button>
                        <?php
                                endif;
                            endif;
                        endforeach;
                        ?>
                    </div>
                    <?php } ?>

                    <div class="item">
                        <div id="secondary_item_holder">
                            <div class="category_items">
                                
                            </div>
                        </div>
                    </div>
                </div>
                <?php if($grocery_experience == 'Medicine' || $grocery_experience == 'Grocery'){?>
                <div class="cart-medicine-counter">
                    <p>Products Loaded: <span class="item_counter"></span></p>
                </div>
                <?php } ?>
            </div>
            <?php if($grocery_experience == 'Medicine'){ ?>
            <div id="main_left">
                <h6 class="alternatives-header"><?php echo lang('Alternatives');?></h6>
                <div id="alternative_item_render">
                    <h6><?php echo lang('Alternative_Medicine_will_shown_here');?> <iconify-icon icon="solar:smile-circle-broken"></iconify-icon></h6>
                </div>
            </div>
            <?php } ?>
        </div>
        <!-- End Main Mart -->
    </div>
    <!-- End Header Wrap -->

    <!-- Start Add Item Modal -->
    <div id="video_tutorial_modal" class="modal">
        <div class="modal-content">
            <h1 class="main_header">
                <?php echo lang('video_tutorial_of_medicine_grocery_experience'); ?>
                <a href="javascript:void(0)" class="alertCloseIcon close_item_modal">
                    <i data-feather="x"></i>
                </a>
            </h1>
            <div class="modal-body">
                <!-- How to work for medicine -->
                <iframe width="100%" height="500px" src="https://youtu.be/LtmKicqTp7M?si=K3nPbWdfmYARpgqp" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
        </div>
    </div>
    <!-- End Add Item Modal -->

    <!-- Start Add Item Modal -->
    <div id="barcode_open_modal" class="modal">
        <div class="modal-content">
            <h1 class="main_header">
                Barcode/QRcode Reader
                <a href="javascript:void(0)" class="alertCloseIcon close_item_modal cancel_open_camera">
                    <i data-feather="x"></i>
                </a>
            </h1>
            <div class="modal-body">
                    <div class="main-content-wrapper">
                        <div id="reader"></div>
                    </div>
            </div>

            <div class="btn__box">
                <button type="button" class="cancel_open_camera cancel px-20 bg__red"><?php echo lang('cancel'); ?></button>
            </div>
        </div>
    </div>
    <!-- End Add Item Modal -->


    <!-- Start Add Item Modal -->
    <div id="item_modal" class="modal">
        <div class="modal-content" id="add_to_cart_item_modal_content">
            <h1 class="modal-header-custom main_header">
                <span id="edit_item_modal_header">&nbsp;</span>
                <a href="javascript:void(0)" class="alertCloseIcon close_item_modal">
                    <i data-feather="x"></i>
                </a>
            </h1>
            <div class="item-modal-body">
                <span id="variation_parent" class="op_display_none"></span>
                <span id="modal_item_name" class="op_display_none"></span>
                <span id="modal_is_promo" class="op_display_none"></span>
                <span id="modal_promo_buy_qty" class="op_display_none"></span>
                <span id="modal_promo_get_qty" class="op_display_none"></span>
                <span id="modal_promo_discount" class="op_display_none"></span>
                <span id="modal_promo_item_id" class="op_display_none"></span>
                <span id="modal_promo_type" class="op_display_none"></span>
                <span id="modal_item_row" class="op_display_none">0</span>
                <span id="modal_item_id" class="op_display_none"></span>
                <span id="modal_item_type" class="op_display_none"></span>
                <span id="modal_item_sale_unit" class="op_display_none"></span>
                <span id="modal_item_price" class="op_display_none"></span>
                <span id="modal_item_vat_percentage" class="op_display_none"></span>
                <div class="sec1_inside" id="sec1_2"><span id="item_quantity_modal" class="op_display_none">1</span></div>
                <div class="sec1_inside op_display_none" id="sec1_3"> <span id="modal_item_price_variable" class="op_display_none">0</span><span id="modal_item_price_variable_without_discount">0</span><span id="modal_discount_amount" class="op_display_none">0</span>
                </div>
                <input type="hidden" id="sale_usal_qty_modal" name="sale_usal_qty_modal" value="">
                <input type="hidden" id="allow_less_sale" name="allow_less_sale" value="<?php echo escape_output($this->session->userdata('allow_less_sale')); ?>">

                <div class="combo_product_html_render">
                    <ul class="combo_modal_header">
                        <li><?php echo lang('sn');?></li>
                        <li class="text-center d-flex align-items-center justify-content-center" data-tippy-content="Click on checkbox to show this item in invoice.">INV <iconify-icon icon="solar:info-circle-bold"></iconify-icon></li>
                        <li class="text-center d-flex align-items-center justify-content-center" data-tippy-content="Click on checkbox to sale this items."><?php echo lang('cart');?> <iconify-icon icon="solar:info-circle-bold"></iconify-icon></li>
                        <li><?php echo lang('name');?></li>
                        <li><?php echo lang('quantity');?></li>
                        <li><?php echo lang('unit_price');?></li>
                        <li><?php echo lang('subtotal');?></li>
                        <li><?php echo lang('seller');?></li>
                    </ul>
                    <ul class="combo_modal_body"></ul>
                </div>

                <div class="variationProductHtmlRenderWrap">
                    <b class="op_margin_bottom_10 op_display_block item_type_variation_heading"></b>
                    <div class="variationProductHtmlRender">
                    </div>
                </div>

                <div class="bulk_imei_serial_upload">
                    <div class="uplod_imei_el bulk_import_for_sale">
                        <iconify-icon icon="solar:upload-minimalistic-broken" width="18" height="18"></iconify-icon>
                        <p><?php echo lang('Bulk_Import_For_Sale');?></p>
                    </div>
                </div>

                <div class="op_display_none" id="modal_discount_section"><p class="op_modal_discount"><?php echo lang('Discount'); ?></p></div>
                <div class="item-modal-top-header">
                    <div class="expiry_imei_serial Available_IMEI_Srial">
                        <b class="op_margin_bottom_10 op_display_block item_type_heading"></b>
                        <select name="expiry_imei_serial" id="IMEI_Serial" class="form-control select2">
                        </select>
                        <div class="alert pos_error_counter alert-error error-msg expiry_imei_serial_msg_contnr ">
                            <p id="expiry_imei_serial_err_msg"></p>
                        </div>
                    </div>
                    <div class="modal_stock_wrapper">
                        <b class="op_margin_bottom_10">&nbsp;</b>
                        <p><b><?php echo lang('current_stock'); ?></b>: <span class="current_stock_t">0</span></p>
                        <input type="hidden" id="current_stock_hidden">
                    </div>
                    <div id="seller_wrapper">
                        <b class="op_margin_bottom_10 op_display_block"><?php echo lang('employee'); ?></b>
                        <select id="seller_id" class="select2">
                            <option value=""><?php echo lang('select_employee'); ?></option>
                            <?php
                            foreach ($waiters as $value):
                                if($value->id!=1):
                            ?>
                                <option value="<?php echo escape_output($value->id); ?>"><?php echo escape_output($value->full_name); ?></option>
                            <?php
                                endif;
                            endforeach;
                            ?>
                        </select>
                    </div>
                </div>

                <!-- Promotion -->
                <div class="promotion-wrap text-center">
                    <div class="promotion-text" id="promotion-text"></div>
                </div>
                <!-- Promotion End -->
                <?php
                    $purchase_price_show_hide = $this->session->userdata('purchase_price_show_hide');
                    $whole_price_show_hide = $this->session->userdata('whole_price_show_hide');
                ?>
                
                <ul class="model_price_list">
                    <li>
                        <input tabindex="-1" id="radio_btn_3" type="radio" class="sale_price_class" name="model_price" value="modal_sale_price">
                        <label tabindex="-1" for="radio_btn_3" class="sale_price_active radio_btn_label model_price_three" data-tippy-content="<?php echo lang('Sale_Price'); ?>: ">
                            <?php echo lang('Sale_Price');?>:
                            <span class="s_sale"  id="s_price"></span>
                        </label>
                    </li>
                    <li class="service_disabled">
                        <?php if ($this->session->userdata('role')=='1'||checkAccess(4,'change_price')){ ?>
                        <input tabindex="-1" id="radio_btn_2" type="radio" class="whole_price_class" name="model_price" value="modal_whole_sale_price"><?php } ?>
                        <label tabindex="-1" for="radio_btn_2" data-tippy-content="<?php echo lang('whole_sale_price'); ?>: " class="model_price_three whole_price_active radio_btn_label <?=isset($whole_price_show_hide) && $whole_price_show_hide=="Yes"?'':'op_display_none'?>"  <?php if ($this->session->userdata('role')=='1'||checkAccess(4,'change_price')){ ?> <?php } ?>>
                            <?php echo lang('WSP');?>:  <span class="s_sale"  id="w_s_price"></span>
                        </label>
                    </li>
                    <li class="service_disabled">
                        <?php if ($this->session->userdata('role')=='1'||checkAccess(4,'change_price')){ ?>
                        <input tabindex="-1" disabled id="radio_btn_1" type="radio" name="model_price" value="modal_purchase_price"><?php } ?>
                        <label tabindex="-1" data-tippy-content="<?php echo lang('last_purchase_price'); ?>/ <?php echo lang('purchase_price'); ?>: " for="radio_btn_1" class="model_price_three radio_btn_label <?=isset($purchase_price_show_hide) && $purchase_price_show_hide=="Yes"?'':'op_display_none'?>"  <?php if ($this->session->userdata('role')=='1'||checkAccess(4,'change_price')){ ?> <?php } ?>>
                            LPP/PP: <span class="s_sale"  id="m_p_price"></span>
                        </label>
                    </li>
                </ul>

                <ul class="price_input_field op_margin_bottom_10">
                    <?php 
                    $sale_price_modify = $this->session->userdata('sale_price_modify');
                    ?>
                    <li>
                        <b class="op_margin_bottom_10 op_display_block"><?php echo lang('Price'); ?></b>
                        <input type="hidden" id="modal_item_last_purchase_price_input_field" value="">
                        <input tabindex="0" type="text" autocomplete="off" id="modal_item_price_input_field" onfocus="select();" class="op_width_100_p op_center" value="" <?php echo $sale_price_modify == 'No' ? 'readonly' : '' ?>>
                    </li>
                    <li class="modal_qty_area">
                        <b class="op_margin_bottom_10 op_display_block"><?php echo lang('quantity'); ?></b>
                        <div class="input-group">
                            <button tabindex="-1" type="button" class="new-btn input-group-text modal_decrease_item_table decrease item_enable_disable">
                                <iconify-icon icon="solar:minus-circle-broken" width="22"></iconify-icon>
                            </button>
                            <input tabindex="0" type="text" autocomplete="off" id="item_quantity_modal_input" onfocus="select();" class="op_width_100_p op_center integerchk item_enable_disable" value="1">
                            <button tabindex="-1" type="button" class="new-btn input-group-text modal_increase_item_table increase item_enable_disable">
                                <iconify-icon icon="solar:add-circle-broken" width="22"></iconify-icon>
                            </button>
                            <span class="input-group-text" id="sale_unit_name_modal">N/A</span>
                        </div>
                    </li>
                    <li>
                        <b class="op_margin_bottom_10 op_display_block"><?php echo lang('Discount'); ?></b>
                        <input tabindex="0" type="text" class="op_width_100_p op_center" autocomplete="off"   onfocus="select();"  id="modal_discount" placeholder="<?php echo lang('discount_10_p_or_10');?>">
                    </li>
                </ul>
                
                <div class="margin-top-10 text-right"><b ><?php echo lang('Total'); ?></b>&nbsp;&nbsp;&nbsp; <span id="modal_total_price">0</span></div>
                <div>
                    <div class="op_margin_bottom_10"><b><?php echo lang('Note'); ?></b></div>
                    <textarea tabindex="0" name="item_note" id="modal_item_note" placeholder="<?php echo lang('note');?>" maxlength="500" class="w-100"></textarea>
                    <input type="hidden" name="modal_item_g_w" id="modal_item_g_w">
                </div>
                <div id="variation_items">
                </div>
                <div class="modal-footer mt-10">
                    <button tabindex="0" class="cardBtn off_pos_btn bg__base" id="add_to_cart"><?php echo lang('add_to_cart'); ?></button>
                    <button tabindex="0" class="close_item_modal off_pos_btn bg__red" id="item_modal_close"><?php echo lang('cancel'); ?></button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Add Item Modal -->


    <!-- Bulk Import For Sale Modal -->
    <div id="bulk_import_for_sale" class="modal">
        <div class="modal-content">
            <h1 class="modal-header-custom">
                <span><?php echo lang('Bulk_Import_For_Sale');?></span>
            </h1>
            <div class="bulk_import_for_sale_body padding-10">
                <div class="import_error_wrap">
                    <div class="alert pos_error_counter alert-error error-msg">
                        <p class="import_validation_error"></p>
                    </div>
                    <div class="alert success_message_counter success-msg">
                        <p class="success_message"></p>
                    </div>
                </div>
                <form id="fileUploadForm" enctype="multipart/form-data">
                    <div class="customer_section">
                        <p class="input_level"><?php echo lang('Select_Bulk_Import_File');?></p>
                        <input type="hidden" id="bulk_import_for_sale_item_id">
                        <input type="hidden" id="bulk_import_for_sale_item_type">
                        <div class="input-group custom-file-button">
                            <label class="input-group-text" for="file"><?php echo lang('Choose_File');?></label>
                            <input type="file" class="form-control" id="file" name="file" accept=".xlsx">
                        </div>
                    </div>
                    <div class="modal-footer mt-10">
                        <button type="submit" tabindex="0" class="off_pos_btn bg__base"><?php echo lang('submit');?></button>
                        <a tabindex="0" class="off_pos_btn bg__base" href="<?php echo base_url() ?>Authentication/downloadPDF/Bulk_Import_For_Sale.xlsx">
                            <?php echo lang('download_sample'); ?>
                        </a>
                        <button tabindex="0" class="bg__red bulk_import_for_sale_cancel"><?php echo lang('cancel'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Modal -->

    <!--Start Add Customer modal -->
    <div id="add_customer_modal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <h1 class="main_header">
                <span id="add_or_edit_text">&nbsp;</span>
                <a href="javascript:void(0)" class="alertCloseIcon">
                    <i data-feather="x"></i>
                </a>
            </h1>
            <form  class="customer_add_modal_info_holder">
                <input type="hidden" id="customer_id_modal" value="">
                <div class="customer_section">
                    <p class="input_level"><?php echo lang('name'); ?> <span class="op_color_red">*</span></p>
                    <input type="text" autocomplete="off" class="add_customer_modal_input" id="customer_name_modal" placeholder="<?php echo lang('name'); ?>" required>
                    <div class="alert alert-error error-msg name_err_msg_contnr modal_err_msg">
                        <p id="name_err_msg"></p>
                    </div>
                </div>
                <div class="customer_section">
                    <p class="input_level"><?php echo lang('phone'); ?> <span class="op_color_red">*</span></p>
                    <input type="text" autocomplete="off" class="add_customer_modal_input" id="customer_phone_modal" placeholder="<?php echo lang('phone'); ?>" required>
                    <div class="alert alert-error error-msg phone_err_msg_contnr modal_err_msg">
                        <p id="phone_err_msg"></p>
                    </div>
                </div>
                <div class="customer_section">
                    <p class="input_level"><?php echo lang('email'); ?></p>
                    <input type="email" class="add_customer_modal_input" id="customer_email_modal" placeholder="<?php echo lang('email'); ?>">
                    <div class="alert alert-error error-msg email_err_msg_contnr modal_err_msg">
                        <p id="email_err_msg"></p>
                    </div>
                </div>
                <div class="customer_section">
                    <div class="customer_balance_type">
                        <div>
                            <p class="input_level"><?php echo lang('opening_balance'); ?></p>
                            <input type="text" autocomplete="off" class="add_customer_modal_input integerchk" id="customer_previous_due_modal" placeholder="<?php echo lang('opening_balance'); ?>">
                        </div>
                        <div class="mr_15">
                            <p class="input_level"><?php echo lang('opening_balance_type'); ?></p>
                            <select class="form-control select2" name="opening_balance_type" id="opening_balance_type">
                                <option value="Debit" <?php echo set_select('opening_balance_type', "Debit"); ?>><?php echo lang('Debit');?></option>
                                <option value="Credit" <?php echo set_select('opening_balance_type', "Credit"); ?>><?php echo lang('Credit');?></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="customer_section">
                    <p class="input_level"><?php echo lang('credit_limit'); ?></p>
                    <input type="text" autocomplete="off" class="add_customer_modal_input integerchk" id="customer_credit_limit_modal" placeholder="<?php echo lang('credit_limit'); ?>">
                </div>
                <div class="customer_section">
                    <p class="input_level"><?php echo lang('default_discount'); ?></p>
                    <input type="text" autocomplete="off" class="add_customer_modal_input integerchkPercent" id="customer_discount_modal" placeholder="<?php echo lang('discount_type'); ?>">
                    <div class="alert alert-error error-msg discount_err_msg_contnr modal_err_msg">
                        <p id="discount_err_msg"></p>
                    </div>
                </div>
                <div class="customer_section">
                    <p class="input_level"><?php echo lang('price_type'); ?></p>
                    <select  class="form-control  select2 op_width_100_p" id="customer_price_type" name="customer_price_type">
                            <option value="1" selected="selected"><?php echo lang('retail') ?></option>
                            <option value="2" ><?php echo lang('wholesale') ?></option>
                    </select>
                </div>
                <div class="customer_section">
                    <p class="input_level"><?php echo lang('group'); ?></p>
                    <select  class="form-control  select2 op_width_100_p" id="customer_group_id_modal" name="customer_group_id_modal">
                        <option value=""><?php echo lang('select'); ?></option>
                        <?php
                        foreach ($groups as $splrs) {
                            ?>
                            <option value="<?php echo escape_output($splrs->id) ?>" <?php echo set_select('group_id', $splrs->id); ?>><?php echo escape_output($splrs->group_name) ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="customer_section">
                    <p class="input_level"><?php echo lang('delivery_address'); ?></p>
                    <input type="text" class="add_customer_modal_input" id="customer_delivery_address_modal" placeholder="<?php echo lang('delivery_address'); ?>">
                </div>
                <?php if(collectGST()=="Yes"){?>
                    <div class="customer_section">
                        <p class="input_level"><?php echo lang('same_or_diff_state'); ?> <span class="required_star">*</span></p>
                        <select class="form-control irp_width_100 select2 same_or_diff_state_modal" name="same_or_diff_state" id="same_or_diff_state">
                            <option value=""><?php echo lang('select'); ?></option>
                            <option value="1"><?php echo lang('same_state'); ?></option>
                            <option value="2"><?php echo lang('different_state'); ?></option>
                        </select>
                        <div class="alert alert-error error-msg state_err_msg_contnr modal_err_msg">
                            <p id="state_err_msg"></p>
                        </div>
                    </div>
                    
                <?php } ?>
                <?php if(collectGST()=="Yes"){?>
                    <div class="customer_section">
                        <p class="input_level"><?php echo lang('gst_number'); ?> <span class="required_star">*</span></p>
                        <input type="text" autocomplete="off" class="add_customer_modal_input" id="customer_gst_number_modal" placeholder="<?php echo lang('gst_number'); ?>">
                        <div class="alert alert-error error-msg gst_err_msg_conter modal_err_msg">
                            <p id="gst_err_msg"></p>
                        </div>
                    </div>
                <?php } ?>
                <div class="customer_section">
                    <p class="input_level"><?php echo lang('date_of_birth'); ?></p>
                    <input autocomplete="off" placeholder="<?php echo lang('date_of_birth'); ?>" type="text" readonly class="add_customer_modal_input " id="customer_dob_modal" data-datable="yyyymmdd"  data-datable-divider=" - ">
                </div>
                <div class="customer_section">
                    <p class="input_level"><?php echo lang('date_of_anniversary'); ?></p>
                    <input placeholder="<?php echo lang('date_of_anniversary'); ?>" autocomplete="off" type="text" readonly class="add_customer_modal_input " id="customer_doa_modal" data-datable="yyyymmdd"  data-datable-divider=" - ">
                </div>
                
                
            </form>
            <div class="p-10">
                <button id="add_customer" class="bg__base px-25"><?php echo lang('Submit'); ?></button>
                <button class="bg__red px-25 cancel_customer_modal"><?php echo lang('cancel'); ?></button>
            </div>
        </div>
    </div>
    <!--End Add Customer modal -->

    <!-- Start SMS setting modal -->
    <div id="show_qty_sms_setting_modal" class="modal op_padding_top_20">
        <div class="modal-content">
            <h2 class="op_center op_margin_top_1"><?php echo lang('POS Settings'); ?></h2>
            <div class="customedr_add_modal_info_holder">
                <?php
                $sms_setting_check = $this->session->userdata('sms_setting_check');
                $qty_setting_check = $this->session->userdata('qty_setting_check');
                ?>
                <label class="op_cursor_pointer op_padding_left_17">
                    <input  <?=isset($qty_setting_check) && $qty_setting_check=="Yes"?'checked':''?> type="checkbox" name="qty_setting_check" value="Yes" id="qty_setting_check"> <?php echo lang('Check stock when selling'); ?>
                </label>
            </div>
            <div class="section7 fix">
                <div class="sec7_inside op_float_left op_display_inline" id="sec7_1"><button class="op_padding_left_28 op_padding_right_28" id="cancel_set_qty_alert_sms_setting"><?php echo lang('cancel'); ?></button></div>
                <div class="sec7_inside op_float_right op_display_inline" id="sec7_2"><button class="op_padding_left_28 op_padding_right_28" id="add_post_setting"><?php echo lang('Submit'); ?></button></div>
            </div>
        </div>
    </div>
    <!-- End SMS setting modal -->

    <!-- Start Sale Hold Modal -->
    <div id="show_sale_hold_modal" class="modal">
        <div class="modal-content">
            <h1 class="main_header"><?php echo lang('after_sale'); ?> <a href="javascript:void(0)" class="alertCloseIcon">
                <i data-feather="x"></i>
                </a>
            </h1>
            <div class="hold_sale_modal_info_holder fix">
                <div class="detail_hold_sale_holder fix">
                    <div class="hold_sale_left fix">
                        <div class="hold_list_holder fix">
                            <div class="header_row fix">
                                <div class="first_column column fix text-left pl-1"><?php echo lang('no'); ?></div>
                                <div class="second_column column fix"><?php echo lang('customer'); ?></div>
                                <div class="third_column column fix"><?php echo lang('date_time'); ?></div>
                            </div>
                            <div class="detail_holder fix">
                            </div>
                            <div class="delete_all_hold_sales_container fix">
                                <button class="bg__red" id="delete_all_hold_sales_button"><?php echo lang('delete_all_after_sales'); ?></button>
                            </div>
                        </div>
                    </div>
                    <div class="hold_sale_right fix">
                        <div class="top">
                            <div class="top_middle">
                                <h1><?php echo lang('order_details'); ?></h1>
                                <div class="waiter_customer_table">
                                    <div class="customer fix"><span class="op_font_weight_b"><?php echo lang('customer'); ?>: </span><span class="op_display_none" id="hold_customer_id"></span><span id="hold_customer_name"></span></div>
                                </div>
                                <div class="item_modifier_details item_modifier_body">
                                    <div class="modifier_item_header">
                                        <div class="first_column_header column_hold"><?php echo lang('item'); ?></div>
                                        <div class="second_column_header column_hold text-center"><?php echo lang('price'); ?></div>
                                        <div class="third_column_header column_hold text-center"><?php echo lang('qty'); ?></div>
                                        <div class="forth_column_header column_hold text-center"><?php echo lang('discount'); ?></div>
                                        <div class="fifth_column_header column_hold text-right"><?php echo lang('total'); ?></div>
                                    </div>
                                    <div class="modifier_item_details_holder hold_sale_height">
                                    </div>
                                </div>
                                <div class="item_modifier_details">
                                    <div class="bottom_total_calculation_hold footer-content-hold">
                                        <div class="item">
                                            <span><?php echo lang('sub_total')?>: </span>
                                            <span id="sub_total_show_hold"><?php echo getAmtPre(0)?></span>
                                        </div>
                                        <div class="item">
                                            <span><?php echo lang('total_item')?>: </span>
                                            <span id="total_items_in_cart_hold">0</span> (<span id="total_items_qty_in_cart_hold">0</span>)
                                            <span id="sub_total_hold" class="ir_display_none"><?php echo getAmtPre(0)?></span>
                                            <span id="total_item_discount_hold" class="ir_display_none"><?php echo getAmtPre(0)?></span>
                                            <span id="discounted_sub_total_amount_hold" class="ir_display_none"><?php echo getAmtPre(0)?></span>
                                        </div>
                                        <div class="item">
                                            <span><?php echo lang('tax')?>: </span>
                                            <span id="hold_all_tax_amount"></span>
                                        </div>
                                        <div class="item">
                                            <span><?php echo lang('charge')?>: </span>
                                            <span id="delivery_charge_hold"> <?php echo getAmtPre(0)?></span>
                                        </div>
                                        <div class="item">
                                            <span><?php echo lang('discount')?>: </span>
                                            <span>
                                                <span id="sub_total_discount_hold"><?php echo getAmtPre(0) ?? 0?></span> (<span id="all_items_discount_hold"><?php echo getAmtPre(0)?></span>)
                                            </span>
                                        </div>
                                    </div>
                                    <h1 class="modal_payable">
                                        <span><?php echo lang('total_payable')?>: </span>
                                        <span id="total_payable_hold"><?php echo getAmtPre(0)?></span>
                                    </h1>
                                </div>
                            </div>
                        </div>
                        <div class="button_holder hold_sale_right_buttom">
                            <button class="bg__green" id="hold_edit_in_cart_button"><?php echo lang('edit_in_cart'); ?></button>
                            <button class="bg__red" id="hold_delete_button"><?php echo lang('Delete'); ?></button>
                            <button class="bg_hold" id="hold_sales_close_button"><?php echo lang('cancel'); ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Sale Hold Modal -->

    <!-- Start Keyboard Shortcut Modal -->
    <div id="show_keyboard_short_cut" class="modal">
        <div class="modal-content">
            <h1 class="main_header"><?php echo lang('keyboard_short_cut'); ?> <a href="javascript:void(0)" class="alertCloseIcon">
                <i data-feather="x"></i>
                </a>
            </h1>
            <div class="keyboard_short_cut_modal_body">
                <table class="table table-striped w-100">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th class="text-left" scope="col">Key</th>
                            <th class="text-left" scope="col">Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="my-10">
                            <th scope="row">1</th>
                            <td>Alt + p</td>
                            <td>Purchase Price</td>
                        </tr>
                        <tr class="my-10">
                            <th scope="row">2</th>
                            <td>Alt + s</td>
                            <td>Sale Price</td>
                        </tr>
                        <tr class="my-10">
                            <th scope="row">3</th>
                            <td>Alt + w</td>
                            <td>Whole Sale Price</td>
                        </tr>
                        <tr class="my-10">
                            <th scope="row">4</th>
                            <td>Alt + c</td>
                            <td>Add Customer</td>
                        </tr>
                        <tr class="my-10">
                            <th scope="row">5</th>
                            <td>Alt + d</td>
                            <td>Draft Sale</td>
                        </tr>
                        <tr class="my-10">
                            <th scope="row">6</th>
                            <td>Alt + t</td>
                            <td>Last Ten Sale</td>
                        </tr>
                        <tr class="my-10">
                            <th scope="row">7</th>
                            <td>Alt + r</td>
                            <td>View Register</td>
                        </tr>
                        <tr class="my-10">
                            <th scope="row">8</th>
                            <td>Alt + e</td>
                            <td>Open Calculator</td>
                        </tr>
                        <tr class="my-10">
                            <th scope="row">9</th>
                            <td>Alt + k</td>
                            <td>Open Shortcut</td>
                        </tr>
                        <tr>
                            <th colspan="3"><h3 class="text-start">Sale Shortcut</h3></th>
                        </tr>
                        <tr class="my-10">
                            <th scope="row">10</th>
                            <td>Shift + p</td>
                            <td>Payment or Place Order</td>
                        </tr>
                        <tr class="my-10">
                            <th scope="row">11</th>
                            <td>Shift + c</td>
                            <td>Cancel or clear cart data</td>
                        </tr>
                        <tr>
                            <th colspan="3"><h3 class="text-start">Sale Shortcut when grocery experience is active</h3></th>
                        </tr>
                        <tr class="my-10">
                            <th scope="row">12</th>
                            <td>ArrowDown</td>
                            <td>Move to next item</td>
                        </tr>
                        <tr class="my-10">
                            <th scope="row">13</th>
                            <td>ArrowUp</td>
                            <td>Move to previous item</td>
                        </tr>
                        <tr class="my-10">
                            <th scope="row">14</th>
                            <td>ArrowRight</td>
                            <td>Move to generic medicine</td>
                        </tr>
                        <tr class="my-10">
                            <th scope="row">15</th>
                            <td>ArrowRight</td>
                            <td>Move to main product</td>
                        </tr>
                        <tr class="my-10">
                            <th scope="row">16</th>
                            <td>Enter</td>
                            <td>Enter to go sale next step</td>
                        </tr>
                        <tr>
                            <th colspan="3"><h3 class="text-start">Sale Shortcut when item modal is active</h3></th>
                        </tr>
                        <tr class="my-10">
                            <th scope="row">17</th>
                            <td>Shift + Enter</td>
                            <td>Item add to cart</td>
                        </tr>
                        <tr class="my-10">
                            <th scope="row">18</th>
                            <td>Shift + c</td>
                            <td>Close item modal</td>
                        </tr>
                        <tr class="my-10">
                            <th scope="row">19</th>
                            <td>Tab</td>
                            <td>swith 1 element to another</td>
                        </tr>
                        <tr>
                            <th colspan="3"><h3 class="text-start">Sale Shortcut when finalize payment modal active</h3></th>
                        </tr>
                        <tr class="my-10">
                            <th scope="row">20</th>
                            <td>ArrowDown</td>
                            <td>Move to next payment</td>
                        </tr>
                        <tr class="my-10">
                            <th scope="row">21</th>
                            <td>ArrowUp</td>
                            <td>Move to previous payment</td>
                        </tr>
                        <tr class="my-10">
                            <th scope="row">22</th>
                            <td>Shift + a</td>
                            <td>Add Payment</td>
                        </tr>
                        <tr class="my-10">
                            <th scope="row">23</th>
                            <td>Shift + q</td>
                            <td>Quick Payment</td>
                        </tr>
                        <tr class="my-10">
                            <th scope="row">24</th>
                            <td>Shift + r</td>
                            <td>Clar Quick Payment</td>
                        </tr>
                        <tr class="my-10">
                            <th scope="row">25</th>
                            <td>Shift + s</td>
                            <td>Active SMS Check Box</td>
                        </tr>
                        <tr class="my-10">
                            <th scope="row">26</th>
                            <td>Shift + e</td>
                            <td>Active Email Check Box</td>
                        </tr>
                        <tr class="my-10">
                            <th scope="row">27</th>
                            <td>Shift + w</td>
                            <td>Active Whatsapp Check Box</td>
                        </tr>
                        <tr class="my-10">
                            <th scope="row">28</th>
                            <td>Shift + c</td>
                            <td>Cancel Finalize Modal</td>
                        </tr>

                        <tr>
                            <th colspan="3"><h3 class="text-start">Other</h3></th>
                        </tr>
                        <tr class="my-10">
                            <th scope="row">29</th>
                            <td>Shift + F</td>
                            <td>Focus Search Box</td>
                        </tr>
                        <tr class="my-10">
                            <th scope="row">30</th>
                            <td>Shift + B</td>
                            <td>Focus Barcode Box</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- End Keyboard Shortcut Modal -->

    <!-- Start Last 10 Sale Modal -->
    <div id="show_last_ten_sales_modal" class="modal op_max_width_1050">
        <div class="modal-content modal-xl" id="modal_content_last_ten_sales">
            <h1 class="main_header"><?php echo lang('last_ten_sales'); ?> <a href="javascript:void(0)" class="alertCloseIcon">
                <i data-feather="x"></i>
                </a>
            </h1>
            <div class="last_ten_sales_modal_info_holder">
                <div class="mobile_last_ten_sale op_display_flex op_justify_space_between op_margin_bottom_10">
                    <input type="text" name="date_c" id="date_c" placeholder="Date" autocomplete="off" class="form-control date_sale op_width_100_p">
                    <select class="select2 op_width_100_p" name="customer_c" id="customer_c">
                        <option value=""><?php echo lang('customer'); ?></option>
                        <?php foreach($customers as $customer){?>
                        <option value="<?php echo escape_output($customer->id); ?>"><?php echo escape_output($customer->name); ?> <?php echo escape_output($customer->phone != '' ? '(' . $customer->phone . ')' : ''); ?></option>
                        <?php } ?>
                    </select>
                    <input  autocomplete="off" type="text" id="invoice_c" name="invoice_c" placeholder="Invoice No" class="form-control op_width_100_p">
                    <button class="search_sale bg__blue offline_prevent">
                        <?php echo lang('search'); ?>
                    </button>
                </div>

                <div class="last_ten_sales_holder fix">
                    <div class="hold_sale_left fix hold_sale_left_height">
                        <div class="hold_list_holder fix">
                            <div class="header_row fix">
                                <div class="first_column column fix"><?php echo lang('invoice_no'); ?></div>
                                <div class="second_column column fix"><?php echo lang('customer'); ?></div>
                                <div class="third_column column fix"><?php echo lang('date_time'); ?></div>
                            </div>
                            <div class="detail_holder fix op_overflow_auto">
                            </div>
                        </div>
                    </div>
                    <div class="hold_sale_right fix hold_sale_right_height">
                        <div class="top fix">
                            <div class="top_middle fix">
                                <h1><?php echo lang('order_details'); ?></h1>
                                <div class="waiter_customer_table fix">
                                    <div class="fix op_sale_details_info">
                                        <span class="op_font_weight_b"><?php echo lang('invoice_no'); ?>: </span>
                                        <span id="last_10_order_invoice_no"></span>
                                    </div>
                                    <div class="fix op_sale_details_info">
                                        <span class="op_font_weight_b"><?php echo lang('date_time'); ?>: </span>
                                        <span id="last_10_order_date_time"></span>
                                    </div>
                                </div>
                                <div class="waiter_customer_table fix">
                                    <div class="customer fix"><span class="op_font_weight_b"><?php echo lang('customer'); ?>: </span><span class="op_display_none" id="last_10_customer_id"></span><span id="last_10_customer_name"></span> <span id="last_ten_customer_mobile"></span></div>
                                </div>
                                <div class="item_modifier_details item_modifier_details_body fix">
                                    <div class="modifier_item_header">
                                        <div class="first_column_header column_hold"><?php echo lang('item'); ?></div>
                                        <div class="second_column_header column_hold"><?php echo lang('price'); ?></div>
                                        <div class="third_column_header column_hold"><?php echo lang('qty'); ?></div>
                                        <div class="forth_column_header column_hold"><?php echo lang('discount'); ?></div>
                                        <div class="fifth_column_header column_hold"><?php echo lang('total'); ?></div>
                                    </div>
                                    <div class="modifier_item_details_holder last_10_sel_height">
                                    </div>
                                </div>
                                <div class="item_modifier_details fix">
                                    <div class="bottom_total_calculation_hold footer-content op_padding_10_important">
                                        <div class="single_row">
                                            <div class="label"><?php echo lang('sub_total'); ?>:</div>
                                            <div class="third_column"> <span id="sub_total_show_last_10"><?php echo getAmtPre(0)?></span>
                                                <span id="sub_total_last_10" class="op_display_none"><?php echo getAmtPre(0)?></span>
                                                <span id="total_item_discount_last_10" class="op_display_none"><?php echo getAmtPre(0)?></span>
                                                <span id="discounted_sub_total_amount_last_10" class="op_display_none"><?php echo getAmtPre(0)?></span>
                                            </div>
                                        </div>
                                        <div class="single_row">
                                            <div class="label"><?php echo lang('total_item'); ?>: <span id="total_items_in_cart_last_10"><?php echo getAmtPre(0)?></span> (<span id="total_items_qty_in_cart_last_10"><?php echo getAmtPre(0)?></span>)</div>
                                        </div>
                                        
                                        <div class="single_row">
                                            <div class="label"><?php echo lang('tax'); ?>:</div>
                                            <span id="all_items_vat_last_10" class="op_overflow_auto op_display_block op_height_20"><?php echo getAmtPre(0)?></span>
                                        </div>
                                        <div class="single_row">
                                            <div class="label"><?php echo lang('charge'); ?>:</div>
                                            <span id="delivery_charge_last_10"><?php echo getAmtPre(0)?></span>
                                        </div>
                                        <div class="single_row">
                                            <div class="label"><?php echo lang('discount'); ?>:</div>
                                            <span id="sub_total_discount_last_10"><?php echo getAmtPre(0)?></span> 
                                            (<span id="all_items_discount_last_10"><?php echo getAmtPre(0)?></span>)
                                        </div>
                                    </div>
                                    <div class="total_payable">
                                        <span class="label"><?php echo lang('total_payable'); ?></span>
                                        <span class="second_column"><span id="total_payable_last_10"><?php echo getAmtPre(0)?></span></span>
                                    </div>
                                    <div class="footer-content bottom_total_calculation_hold">
                                        <div class="single_row">
                                            <div class="label"><?php echo lang('paid_amount'); ?>:</div>
                                            <div class="second_column"> <span id="paid_amount_last_10"><?php echo getAmtPre(0)?></span></div>
                                        </div>
                                        <div class="single_row">
                                            <div class="label"><?php echo lang('due_amount'); ?>:</div>
                                            <div class="third_column"> <span id="due_amount_last_10"><?php echo getAmtPre(0)?></span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="button_holder hold_sale_right_bottom">
                            <button id="last_ten_print_invoice_button" class="bg__grey"><?php echo lang('print_invoice'); ?></button>
                            <button id="last_ten_print_challan_button" class="bg__grey"><?php echo lang('print_challan'); ?></button>
                            <button id="last_ten_sales_edit_buttons" class="bg_hold"><?php echo lang('edit'); ?></button>
                            <button id="last_ten_delete_button" class="bg__red"><?php echo lang('delete'); ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- Start Last 10 Sale Modal -->

    <!-- Start Keyboard Shortcut Modal -->
    <div id="show_keyboard_shortcut_modal" class="modal">
        <div class="modal-content" id="modal_content_keyboard_shortcut">
            <h1 class="main_header"><?php echo lang('keyboard_shortcuts'); ?> <a href="javascript:void(0)" class="alertCloseIcon">
                <i data-feather="x"></i>
                </a>
            </h1>
            <div class="last_ten_sales_modal_info_holder fix">
                <div class="last_ten_sales_holder fix">
                    <div class="header_row fix">
                        <table class="w-100">
                            <tr>
                                <td class="op_center op_width_30_p">Ctrl+Alt+C</td>
                                <td class="op_center op_width_10_p">=</td>
                                <td class="op_left op_width_49_p"><?php echo lang('Select Customer'); ?></td>
                            </tr>

                            <tr>
                                <td class="op_center op_width_49_p">Ctrl+Alt+S</td>
                                <td class="op_center op_width_2_p">=</td>
                                <td class="op_left op_width_49_p"><?php echo lang('Search Product'); ?></td>
                            </tr>

                            <tr>
                                <td class="op_center op_width_49_p">Ctrl+Alt+B</td>
                                <td class="op_center op_width_2_p">=</td>
                                <td class="op_left op_width_49_p"><?php echo lang('Select Customer'); ?></td>
                            </tr>

                            <tr>
                                <td class="op_center op_width_49_p">Ctrl+Alt+P</td>
                                <td class="op_center op_width_2_p">=</td>
                                <td class="op_left op_width_49_p"><?php echo lang('Payment'); ?></td>
                            </tr>

                            <tr>
                                <td class="op_center op_width_49_p">Ctrl+Alt+H</td>
                                <td class="op_center op_width_2_p">=</td>
                                <td class="op_left op_width_49_p"><?php echo lang('Hold a Sale'); ?></td>
                            </tr>

                            <tr>
                                <td class="op_center op_width_49_p">Ctrl+Alt+O</td>
                                <td class="op_center op_width_2_p">=</td>
                                <td class="op_left op_width_49_p"><?php echo lang('Open Hold Sales'); ?></td>
                            </tr>

                            <tr>
                                <td class="op_center op_width_49_p">Ctrl+Alt+A</td>
                                <td class="op_center op_width_2_p">=</td>
                                <td class="op_left op_width_49_p"><?php echo lang('Cancel a Sale'); ?></td>
                            </tr>
                        </table>
                        <p>&nbsp;</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Keyboard Shortcut Modal -->

    <!-- Start sale hold modal -->
    <div id="generate_sale_hold_modal" class="modal">
        <div class="modal-content" id="modal_content_generate_hold_sales">
            <h1 class="main_header"><?php echo lang('hold'); ?> <a href="javascript:void(0)" class="alertCloseIcon">
                <i data-feather="x"></i>
                </a>
            </h1>
            <div class="generate_hold_sale_modal_info_holder fix">
                <label><?php echo lang('hold_number'); ?> <span class="op_color_red">*</span></label>
                <input type="text" autocomplete="off"  id="hold_generate_input" placeholder="<?php echo lang('hold_number'); ?>">
                <div class="d-felx margin-top-10">
                    <button id="hold_cart_info" class="bg__blue"><?php echo lang('submit'); ?></button>
                    <button id="close_hold_modal" class="bg__red"><?php echo lang('cancel'); ?></button>
                </div>
            </div>
            
        </div>
    </div>
    <!-- End sale hold modal -->

    <!-- The table modal please read -->
    <div id="please_read_modal" class="modal">
        <div class="modal-content" id="modal_please_read_details">
            <p class="cross_button_to_close" id="please_read_close_button_cross">&times;</p>
            <h1 id="please_read_modal_header"><?php echo lang('please_read'); ?></h1>
            <div class="help_modal_info_holder fix">
                <p class="para_type_1"><?php echo lang('please_read_text_1'); ?>:</p>
                <p class="para_type_2"><?php echo lang('please_read_text_2'); ?></p>
                <p class="para_type_1"><?php echo lang('please_read_text_3'); ?>:</p>
                <p class="para_type_2"><?php echo lang('please_read_text_4'); ?></p>
                <button id="please_read_close_button"><?php echo lang('close'); ?></button>
            </div>
        </div>
    </div>
    <!-- End table modal please read modal -->

    <!-- Finalize Order Modal Start -->
    <div id="finalize_order_modal" class="modal">
        <div class="modal-content" id="modal_finalize_order_details">
            <h1 id="modal_finalize_header">
                <?php echo lang('finalize_order');?>
                <a href="javascript:void(0)" class="alertCloseIcon">
                    <i data-feather="x"></i>
                </a>
            </h1>

            <span id="modal_finalize_sale_id" class="op_display_none"></span>
            <div class="finalize_order_body">
                <div class="payment-list order-payment-list">
                    <div class="finalize-button-wrap">
                        <div class="payment_btn_toggler">
                            <button type="button" class="btn payment_ctrl payment_mthod_ctrl active">Payment Method</button>
                            <button type="button" class="btn payment_ctrl payment_details_ctrl">Payment Details</button>
                        </div>
                    </div>
                    <ul class="list-for-payment-type ps finalize-p-active" id="finalize_payment_method">
                        <li class="head">
                            <b><?php echo lang('payment_method'); ?></b>
                        </li>
                            <?php foreach ($payment_methods as $value):
                            $selected = "";
                            $is_cash = "";
                            $selected2 = '';
                            $default_payment = $getCompanyInfo->default_payment;
                            $is_loyalty_enable = $getCompanyInfo->is_loyalty_enable;
                            if($value->id==$default_payment){
                                $selected = "active";
                                $selected2 = "active_m";
                            }
                            if($value->name != 'Cash'){
                                $is_cash = "set_no_access";
                            }
                            if($is_loyalty_enable!='enable'):
                                if($value->name != 'Loyalty Point'):
                            ?>
                            <li class="f-item">
                                <a data-type_value="<?php echo escape_output($value->account_type); ?>" class="<?php echo escape_output($is_cash)?> <?php echo escape_output($selected)?> set_payment account_type" data-id="<?php echo escape_output($value->id)?>" href="javascript:void(0)"><?php echo escape_output($value->name)?></a>
                            </li>
                            <?php
                                endif;
                            else:?>
                            <li class="payment_element <?php echo $selected2 ?>">
                                <a data-type_value="<?php echo escape_output($value->account_type); ?>" class="<?php echo escape_output($is_cash)?> <?php echo escape_output($selected)?> set_payment account_type" data-id="<?php echo escape_output($value->id)?>" href="javascript:void(0)"><?php echo escape_output($value->name)?></a>
                            </li>
                            <?php endif;?>
                            <?php endforeach;?>
                            <li class=""> <a  id="change_currency_btn" class="change_currency_btn" href="javascript:void(0)"><?php echo lang('change_currency'); ?></a> </li>
                    </ul>
                    <!-- <ul id="list">
                        <li class="trigger active">
                            <a href="javascript:void(0)">A</a>
                        </li>
                        <li class="trigger">
                            <a href="javascript:void(0)">B</a>
                        </li>
                        <li class="trigger">
                            <a href="javascript:void(0)">C</a>
                        </li>
                        <li class="trigger">
                            <a href="javascript:void(0)">A</a>
                        </li>
                    </ul> -->
                    <input type="hidden" id="account_type" name="account_type">
                </div>
                <div class="payment_content_wrap finalize-p-inactive">
                    <div class="customer_previous_due_mobile op_mb_7">
                        <div class="finalize-mobile-view">
                            <p><b><?php echo lang('customer');?>:</b> <span class="finalize_mobile_customer"></span></p>
                            <div class="text-rigth">
                                <p class="text-red"><b><?php echo lang('opening_balance');?>:</b> <span class="finalize_mobile_op_balance"></span></p>
                                <p class="d-flex justify-content-end text-red"><span class="d-none"><b><?php echo lang('change_amount');?>:</b></span> <span class="finalize-changes-amt-mobile"></span></p>
                            </div>
                        </div>
                    </div>
                    <div class="payment_content_left_side">
                        <div class="payment_top">
                            <div class="c_d_flex justify-content-between">
                                <h4 class="name-of-payment set_no_access my-0" id="payment_preview"><?php echo lang('Cash_Payment'); ?></h4>
                                <div class="customer_and_previous_due_info">
                                    <div class="previous_due_div">
                                        <div class="d-flex" id="previous_due_wrap">
                                            <div class="finalize-customer-name mr-10"></div>
                                            <span class="change_amount_color mr-10"><?php echo lang('opening_balance');?>: </span>&nbsp;
                                            <span class="change_amount_color" id="previous_due_show"></span>
                                            <img id="cash_img" alt="cash image" src="<?php echo base_url()?>assets/media/dollar_sign.png">
                                        </div>
                                    </div>
                                    <div class="loyalty_point_div">
                                        <div class="d-flex">
                                            <span class="change_amount_color mr-10"><?php echo lang('available_loyalty_point'); ?>: </span>&nbsp;
                                            <span class="change_amount_color" id="available_loyalty_point"></span>
                                        </div>
                                    </div>
                                    <div class="previous_due_div">
                                        <div class="change_amount_color text-center">
                                            <b><span class="change_amount_div display_none change_amount_p ml-10"><?php echo lang('change_amount'); ?></span></b><br>
                                            <span class="change_amount_font change_amount_div display_none change_amount_p" id="change_amount_div_">0</span>
                                            <input type="hidden" id="hidden_given_amount" class="d-none"></input>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="payment_field_wrap">
                                <div class="input-field cash_div f_focus easy-get">
                                    <label class="label set_no_access"><?php echo lang('given_amount'); ?></label>
                                    <input type="text" placeholder="<?php echo lang('given_amount'); ?>" onfocus="select();" class="add_customer_modal_input set_no_access easy-put" id="finalize_given_amount_input">
                                </div>
                                <div class="input-field cash_div">
                                    <label class="label set_no_access"><?php echo lang('change_amount'); ?></label>
                                    <input tabindex="-1" type="text" placeholder="<?php echo lang('change_amount'); ?>" onfocus="select();" class="add_customer_modal_input set_no_access" id="finalize_change_amount_input">
                                </div>
                                <div class="input-field easy-get">
                                    <label class="label set_no_access amount_txt"><?php echo lang('amount'); ?></label>
                                    <input tabindex="-1" type="text" placeholder="<?php echo lang('amount'); ?>" class="add_customer_modal_input set_no_access easy-put" id="finalize_amount_input">
                                </div>
                                <div class="btns">
                                    <button class="add-btn start_animation set_no_access" id="add_payment"><b><?php echo lang('add'); ?></b></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="show_account_type" class="show_account_type">
                    </div>

                    <!-- Due Date -->
                    <div class="due_date_select margin-top-10">
                        <div class="form-group">
                            <label for="due_date"><?php echo lang('Due_Date');?></label>
                            <input  autocomplete="off" type="text" id="due_date" name="due_date" readonly class="form-control datepicker_custom due_date_field" placeholder="<?php echo lang('Due_Date');?>">
                        </div>
                    </div>
                    <!-- End Top Payment AddPart -->

                    <div>
                        <ul class="finalize_modal_is_mul_currency">
                            <li class="w-48 pe-3">
                                <select class="form-control select2 multi_currency w-100" id="multi_currency">
                                    <option data-multi_currency="0" value=""><?php echo lang('change_currency') ?></option>
                                    <?php foreach ($multipleCurrencies as $value): ?>
                                        <option data-multi_currency="<?php echo escape_output($value->conversion_rate)?>" value="<?php echo escape_output($value->currency)?>"><?php echo escape_output($value->currency)?></option>
                                    <?php endforeach;?>
                                </select>
                            </li>
                            <li class="w-2"></li>
                            <li class="w-45">
                                <input type="text" placeholder="<?php echo lang('amount') ?>" onfocus="select();"  readonly id="multi_currency_amount" class="custom_field w-100">
                            </li>
                            <li class="w-5 remove_multi_currency_wrap  color-red">
                                <iconify-icon icon="solar:trash-bin-minimalistic-broken" data-id="${item_id}" class="remove_multi_currency ps-1"></iconify-icon>
                            </li>
                        </ul>
                    </div>
                    <div class="key-pad">
                        <div class="left-keys">
                            <input type="hidden" value="" id="is_multi_currency">
                            <input type="hidden" value="" id="multi_currency_rate">
                            <div class="paid-list-wrapper">
                                <div class="w_100_p">
                                    <p class="empty_title"><?php echo lang('payment_show_tooltip_pos') ?></p>
                                    <ul class="paid-list pl-0" id="payment_list_div">
                                    </ul>
                                </div>
                                <div class="right-content">
                                    <div class="item">
                                        <h3 class="title"><?php echo lang('Payable') ?></h3>
                                        <p><span data-original_payable="" id="finalize_total_payable"><?php echo getAmt(0)?></span></p>
                                    </div>

                                    <div class="item">
                                        <h3 class="title"><?php echo lang('paid') ?></h3>
                                        <p><span class="spincrement" id="finalize_total_paid"><?php echo getAmt(0)?></span></p>
                                    </div>

                                    <div class="item">
                                        <h3 class="title"><?php echo lang('due') ?></h3>
                                        <p><span class="spincrement" id="finalize_total_due"><?php echo getAmt(0)?></span></p>
                                    </div>
                                    <button type="button" class="new-btn justify-content-center" id="open_finalize_cart_details"><?php echo lang('Cart_Details') ?></button>
                                </div>
                            </div>
                        </div>
                        <div class="right-keys">
                            <ul class="key-list">
                                <li><a id="open_finalize_discount" href="javascript:void(0)"><?php echo lang('discount') ?></a></li>
                                <li><a data-amount="" data-is_denomination="" class="set_no_access get_quick_cash set_default_quick_cach" href="javascript:void(0)"><?php echo getAmtPCustom(0)?></a></li>
                                <li class="third">
                                    <ul>
                                        <?php
                                        if(isset($denominations) && $denominations):
                                            foreach ($denominations as $value):
                                            ?>
                                            <li><a  data-is_denomination="yes"  data-amount="<?=escape_output($value->amount)?>" class="set_no_access get_quick_cash" href="javascript:void(0)"><?php echo escape_output($value->amount)?></a></li>
                                        <?php
                                            endforeach;
                                            endif;
                                        ?>
                                    </ul>
                                </li>
                                <li class="clear">
                                    <a href="javascript:void(0)" class="new-btn-danger justify-content-center clear-btn clear_quick_data set_no_access"><?php echo lang('Clear') ?></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="sms-email-mobile d-flex justify-content-end my-20">
                        
                        <label class="container op_margin_top_6 op_color_dim_grey mr-10 send_sms_finalize"> <?php echo lang('send_invoice_via_sms'); ?>
                            <input class="sms_enable_status" type="checkbox" name="send_invoice_sms" <?php echo escape_output($getCompanyInfo->sms_enable_status) == "1" ? 'checked'  : '' ?>>
                            <span class="checkmark"></span>
                        </label>
                        <label class="container op_margin_top_6 op_color_dim_grey  mr-10 send_email_finalize"> <?php echo lang('send_invoice_via_email'); ?>
                            <input class="smtp_enable_status" type="checkbox" name="send_invoice_email" <?php echo escape_output($getCompanyInfo->smtp_enable_status) == "1" ? 'checked'  : '' ?>>
                            <span class="checkmark"></span>
                        </label>
                        <?php if($getCompanyInfo->whatsapp_invoice_enable_status == 'Enable'){?>
                        <label class="container op_margin_top_6 op_color_dim_grey send_wm_finalize"> <?php echo lang('send_invoice_via_whatsapp'); ?>
                            <input class="send_invoice_whatsapp" type="checkbox" name="send_invoice_whatsapp" <?php echo escape_output($getCompanyInfo->whatsapp_invoice_enable_status) == "Enable" ? 'checked'  : '' ?>>
                            <span class="checkmark"></span>
                        </label>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="btn__box ">
                <button class="bg__red" id="finalize_order_cancel_button"><?php echo lang('cancel'); ?></button>
                <button class="bg__green" id="finalize_order_button"><?php echo lang('submit'); ?></button>
            </div>
        </div>
    </div>
    <!-- Finalize Order Modal End -->

    <!-- Start Mobile View All Menu -->
    <div class="all__menus mobile_other_menu">
        <ul class="menu__list">
            <div>
                <li class="it_has_children no-need-for-waiter">
                    <a href="javascript:void(0)">
                        <iconify-icon icon="solar:user-check-broken" width="18"></iconify-icon>
                        <?php echo lang('Main_Menu');?>
                    </a>
                    <ul class="sub_menu" role="menu">
                        <li>
                            <a href="<?php echo base_url();?>User/changeProfile" class="offline_prevent">
                            <?php echo lang('change_profile');?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url();?>User/changePassword" class="offline_prevent">
                            <?php echo lang('change_password');?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url();?>User/securityQuestion" class="offline_prevent">
                            <?php echo lang('SetSecurityQuestion');?></a>
                        </li>
                        <li>
                            <a class="logOutTrigger" href="javascript:void(0)"><?php echo lang('logout');?></a>
                        </li>
                    </ul>
                </li>
                <li class="mobile_menu_click_for_hide">
                    <a href="javascript:void(0)" class="open_hold_sales">
                        <iconify-icon icon="solar:adhesive-plaster-broken" width="18"></iconify-icon>
                        <?php echo lang('Open_Draft_Sales');?>
                    </a>
                </li>
                <li class="mobile_menu_click_for_hide">
                    <a href="javascript:void(0)" class="last_ten_sales_button">
                        <iconify-icon icon="solar:history-broken" width="18"></iconify-icon>
                        <?php echo lang('Recent_Sales');?>
                    </a>
                </li>
                <li class="mobile_menu_click_for_hide">
                    <a href="javascript:void(0)" class="register_details">
                        <iconify-icon icon="solar:document-add-broken" width="18"></iconify-icon>
                        <?php echo lang('register');?>
                    </a>
                </li>
                <li class="mobile_menu_click_for_hide">
                    <a href="<?php echo base_url();?>Dashboard/dashboard" class="offline_prevent">
                    <iconify-icon icon="solar:chart-2-broken" width="18"></iconify-icon>
                    <?php echo lang('dashboard');?></a></a>
                </li>
            </div>
            <div>
                <li class="it_has_children languages">
                    <a href="javascript:void(0)" class="header_menu_icon dropdown-menu" data-tippy-content="Language">
                        <iconify-icon icon="ion:language" width="18"></iconify-icon>
                        <?php echo lang('Language');?>
                    </a>
                    <ul class="sub_menu mobile_ln_submenu" role="menu">
                        <?php
                        $dir = glob("application/language/*",GLOB_ONLYDIR);
                        foreach ($dir as $value):
                            $separete = explode("language/",$value);?>
                            <li data-lang="English">
                                <a href="<?php echo base_url()?>Authentication/setlanguage/<?php echo escape_output($separete[1])?>"> <span><?php echo ucfirstcustom($separete[1])?></span>
                                </a>
                            </li>
                        <?php
                        endforeach;
                        ?>
                    </ul>
                </li>
                <li class="mobile_menu_click_for_hide">
                    <a href="javascript:void(0)" class="print_last_invoice">
                        <iconify-icon icon="solar:printer-broken" width="18"></iconify-icon>
                        <?php echo lang('print_last_invoice');?>
                    </a> 
                </li>
                <li class="mobile_menu_click_for_hide">
                    <a href="javascript:void(0)" id="calculator_button" class="calculator_button">
                        <iconify-icon icon="solar:calculator-minimalistic-broken" width="18"></iconify-icon>
                        <?php echo lang('Calculator');?>
                    </a>
                </li>
                <li class="mobile_menu_click_for_hide">
                    <a href="javascript:void(0)" class="keyboard_short_cut">
                        <iconify-icon icon="solar:keyboard-broken" width="18"></iconify-icon>
                        <?php echo lang('keyboard_short_cut');?>
                    </a>
                </li>
                <li class="mobile_menu_click_for_hide">
                    <a href="<?php echo base_url();?>customer-panel">
                        <iconify-icon icon="solar:monitor-broken" width="18"></iconify-icon>
                        <?php echo lang('customer_panel');?>
                    </a>
                </li>       
            </div>
        </ul>
    </div>
    <!-- End Mobile View All Menu -->




    <div class="overlayForCalculator"></div>
    <div id="calculator_main">
        <div class="calculator">
            <input type="text" autocomplete="off" readonly>
            <div class="row">
                <div class="key">1</div>
                <div class="key">2</div>
                <div class="key">3</div>
                <div class="key last">0</div>
            </div>
            <div class="row">
                <div class="key">4</div>
                <div class="key">5</div>
                <div class="key">6</div>
                <div class="key last action instant">cl</div>
            </div>
            <div class="row">
                <div class="key">7</div>
                <div class="key">8</div>
                <div class="key">9</div>
                <div class="key last action instant">=</div>
            </div>
            <div class="row">
                <div class="key action">+</div>
                <div class="key action">-</div>
                <div class="key action">x</div>
                <div class="key action">/</div>
            </div>
        </div>
    </div>

    <input type="hidden" value="2" name="cal_open_status" id="cal_open_status">
    <div id="modify_button_tool_tip" class="op_choose_this">
        <h1 class="title op_choose_this_title"><?php echo lang('Choose_This_For');?>:</h1>
        <p class="op_choose_this_for"><?php echo lang('Add_New_Item_1');?></p>
        <p class="op_choose_this_for"><?php echo lang('Change_Table_2');?></p>
        <p class="op_choose_this_for"><?php echo lang('Change_anything_in_an_Order_3');?></p>
    </div>
    <div id="direct_invoice_button_tool_tip" class="op_choose_this">
        <h1 class="title op_choose_this_title"><?php echo lang('For_Fast_Food_Restaurants');?></h1>
    </div>

    <!-- New Custom Animated Modal Start -->
    <div class="pos__modal__overlay"></div>
    <div class="pos__modal__overlay2"></div>
    <!-- New Custom Animated Modal End -->

    <!-- Discount Modal Start -->
    <div id="discount_modal" class="modal">
        <div class="modal-content">
            <h1 class="modal-header-custom"><?php echo lang('discount'); ?>
                <a href="javascript:void(0)" class="alertCloseIcon">
                    <i data-feather="x"></i>
                </a>
            </h1>
            <div class="main-content-wrapper">
                <div class="discunt_check_modal">
                    <label><?php echo lang('discount_permission_code')?></label>
                    <input type="text" onfocus="select()" class="form-control discount_permission_code" value="" placeholder="<?php echo lang('discount_permission_code'); ?>">
                    <div class="alert pos_error_counter alert-error error-msg">
                        <p class="discount_err_message"></p>
                    </div>
                </div>
                <div class="easy-get discount_field">
                    <label><?php echo lang('discount_in_parcentage');?></label>
                    <input type="text" onfocus="select()" class="form-control total_disc easy-put" placeholder="<?php echo lang('10_p_or_10'); ?>"
                        id="sub_total_discount">
                    <span class="ir_display_none" id="sub_total_discount_amount"></span>
                </div>
            </div>
            <div class="btn__box">
                <button type="button" id="submit_discount_custom" class="bg__blue px-20 bg__blue"><?php echo lang('submit'); ?></button>
                <button type="button" id="cancel_discount_modal" class="cancel px-20 bg__red"><?php echo lang('cancel'); ?></button>
            </div>
        </div>
    </div>
    <!-- Discount Modal End -->

    <!-- Finalize Discount Modal Start -->
    <div id="finalize_discount_modal" class="modal">
        <div class="modal-content">
            <h1 class="modal-header-custom"><?php echo lang('discount'); ?>
                <a href="javascript:void(0)" class="alertCloseIcon">
                    <i data-feather="x"></i>
                </a>
            </h1>
            <div class="main-content-wrapper">
                <div class="discunt_check_modal px_10">
                    <label><?php echo lang('discount_permission_code')?></label>
                    <input type="text" onfocus="select()" class="form-control discount_permission_code_f" value="" placeholder="<?php echo lang('discount_permission_code'); ?>">
                    <div class="alert pos_error_counter alert-error error-msg">
                        <p class="discount_err_message"></p>
                    </div>
                </div>

                <div class="px_10 margin-top-10">
                    <label><?php echo lang('value')?> (<?php echo lang('discount_10_or_30'); ?>)</label>
                    <input type="text" class="integerchk" placeholder="<?php echo lang('discount_10_or_30'); ?>"
                        id="sub_total_discount_finalize">
                    <span class="ir_display_none"></span>
                </div>
            </div>
            <div class="btn__box">
                <button type="button" class="finalize_dis_submit bg__blue"><?php echo lang('submit'); ?></button>
                <button type="button" class="cancel_modal bg__red remove_discount"><?php echo lang('cancel'); ?></button>
            </div>
        </div>
    </div>
    <!-- Finalize Discount Modal End -->


    <!-- Finalize Cart Details -->
    <div id="finalize_cart_details_modal" class="modal">
        <input type="hidden" id="cart_modal_total_item" value="">
        <input type="hidden" id="cart_modal_total_subtotal" value="">
        <input type="hidden" id="cart_modal_total_discount" value="">
        <input type="hidden" id="cart_modal_total_discount_all" value="">
        <input type="hidden" id="cart_modal_total_discount_for_subtotal" value="">
        <input type="hidden" id="cart_modal_total_tax" value="">
        <input type="hidden" id="cart_modal_total_charge" value="">
        <input type="hidden" id="cart_modal_total_tips" value="">
        <input type="hidden" id="cart_modal_total_rounding" value="">
        <!-- Modal content -->
        <div class="modal-content">
            <h1 class="modal-header-custom">
                <?php echo lang('Cart_Details');?>
                <a href="javascript:void(0)" class="alertCloseIcon">
                    <i data-feather="x"></i>
                </a>
            </h1>
            <div class="modal-body-content">
                <div class="item-cart-details-item-list item_cart_details_header">
                    <span><b><?php echo lang('item');?></b></span>
                    <span class="text-center"><b><?php echo lang('price');?></b></span>
                    <span class="text-center"><b><?php echo lang('quantity');?></b></span>
                    <span class="text-center"><b><?php echo lang('discount');?></b></span>
                    <span class="text-center"><b><?php echo lang('subtotal');?></b></span>
                </div>
                <div class="finalize_item_details">
                </div>
                <div class="item-cart-details-item-list cart_details_footer">
                </div>
            </div>
            <div class="btn__box">
                <button type="button" class="cancel_modal bg__red"><?php echo lang('cancel'); ?></button>
            </div>
        </div>
    </div>
    <!-- Finalize Cart Details End -->

    <!-- Open Service Charge Modal Start -->
    <div id="charge_modal" class="modal">
        <div class="modal-content">
            <h1 class="modal-header-custom">
                <?php echo lang('charge');?>
                <a href="javascript:void(0)" class="alertCloseIcon">
                    <i data-feather="x"></i>
                </a>
            </h1>
            <div class="main-content-wrapper">
                <div class="form-group mt-3">
                    <!-- <?php
                        $service_type = $this->session->userdata('service_type');
                        $service_amount = $this->session->userdata('service_amount');
                    ?> -->
                    <label for="charge_type"><?php echo lang('type'); ?></label>
                    <select id="charge_type" class="select2">
                        <option <?php echo isset($sale_item) && $sale_item->charge_type=="delivery"?'selected':''?> value="delivery"><?php echo lang('delivery'); ?></option>
                        <option <?php echo isset($sale_item) && $sale_item->charge_type=="service"?'selected':''?> value="service"><?php echo lang('service'); ?></option>
                    </select>
                </div>
                <div class="form-group margin-top-15 easy-get">
                    <label><?php echo lang('amount'); ?></label>
                    <input type="text"  autocomplete="off" class="form-control easy-put integerchk"
                        placeholder="<?php echo lang('amount'); ?>" value="<?php echo getAmtPre(isset($sale_item) && $sale_item->delivery_charge ? $sale_item->delivery_charge : 0)?>" id="delivery_charge">
                </div>
            </div>
            <div class="btn__box">
                <button type="button" class="submit bg__blue px-20 delivery_charge_submit"><?php echo lang('submit'); ?></button>
                <button type="button" class="cancel bg__red px-20"><?php echo lang('cancel'); ?></button>
            </div>
        </div>
    </div>
    <!-- Open Service Charge Modal End -->


    <!-- Open Delivery Partner Modal Start -->
    <div id="delivery_partner" class="modal">
        <div class="modal-content">
            <h1 class="modal-header-custom">
                <?php echo lang('delivery_partner');?>
                <a href="javascript:void(0)" class="alertCloseIcon">
                    <i data-feather="x"></i>
                </a>
            </h1>
            <div class="main-content-wrapper">
                <div class="form-group mt-3">
                    <label for="delivery_partner_list"><?php echo lang('delivery_partner'); ?></label>
                    <select id="delivery_partner_list" class="select2 form-control">
                        <option><?php echo lang('select'); ?></option>
                        <?php if(isset($delivery_partners) && $delivery_partners){
                            foreach($delivery_partners as $key=>$partner){
                        ?>
                        <option <?php echo isset($sale_item) && $sale_item->charge_type=="delivery"?'selected':''?> value="<?php echo escape_output($partner->id) ?>"><?php echo escape_output($partner->partner_name); ?></option>
                        <?php }} ?>
                    </select>
                </div>
            </div>
            <div class="btn__box">
                <button type="button" class="submit bg__blue px-20" id="delivery_partner_submit"><?php echo lang('submit'); ?></button>
                <button type="button" class="cancel bg__red px-20"><?php echo lang('cancel'); ?></button>
            </div>
        </div>
    </div>
    <!-- Open Delivery Partner Modal Modal End -->

    <!-- Note Modal Start -->
    <div id="note_modal" class="modal">
        <div class="modal-content">
            <h1 class="modal-header-custom">
                <?php echo lang('note');?>
                <a href="javascript:void(0)" class="alertCloseIcon">
                    <i data-feather="x"></i>
                </a>
            </h1>
            <div class="main-content-wrapper">
                <div class="op_margin_top_10">
                    <label for="note"><?php echo lang('note');?></label>
                    <textarea class="op_height_80"  autocomplete="off"
                        placeholder="Note" id="note"></textarea>
                </div>
            </div>
            <div class="btn__box">
                <button type="button" class="submit bg__blue px-20"><?php echo lang('submit'); ?></button>
                <button type="button" class="cancel bg__red px-20"><?php echo lang('cancel'); ?></button>
            </div>
        </div>
    </div>
    <!-- Note Modal End -->


    <!-- Coupon Discount Modal Start -->
    <div id="coupon_discount" class="modal">
        <div class="modal-content">
            <h1 class="modal-header-custom">
                <?php echo lang('discount_coupon_entire');?>
                <a href="javascript:void(0)" class="alertCloseIcon">
                    <i data-feather="x"></i>
                </a>
            </h1>
            <div class="main-content-wrapper">
                <div class="op_margin_top_10 form-group">
                    <label for="coupon_code"><?php echo lang('coupon_code');?></label>
                    <input type="text" class="op_height_80 form-control" name="coupon_code" autocomplete="off"
                        placeholder="<?php echo lang('coupon_code');?>" id="coupon_code">
                </div>
                <div class="alert pos_error_counter alert-error error-msg">
                    <p class="coupon_err_message"></p>
                </div>
            </div>
            <div class="btn__box">
                <button type="button" class="bg__blue px-20 coupon_code_submit"><?php echo lang('submit'); ?></button>
                <button type="button" class="cancel bg__red px-20"><?php echo lang('cancel'); ?></button>
            </div>
        </div>
    </div>
    <!-- Coupon Discount End -->

    <!-- Ragister Modal Start -->
    <div class="cus_pos_modal modal" id="register_modal">
        <h1 class="main_header">
            <?php echo lang('register_details');?>
            <a href="javascript:void(0)" class="alertCloseIcon pos__modal__close">
                <i data-feather="x"></i>
            </a>
        </h1>

        <div class="pos__modal__body scrollbar-macosx">
            <div class="default_inner_body" id="register_details_content_o">
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('register_details'); ?>" data-id_name="datatable">
                <div class="html_content">
                </div>
            </div>
        </div>
        <footer class="pos__modal__footer">
            <div class="right_box">
                <button type="button"  id="register_close" class="btn bg__grey"><?php echo lang('close_register'); ?></button>
                <button type="button" class="modal_hide_register btn bg__red"><?php echo lang('cancel'); ?></button>
            </div>
        </footer>
    </div>
    <!-- Ragister Modal End -->

    <!-- Tax Modal Start -->
    <div id="tax_modal" class="modal">
        <div class="modal-content">
            <h1 class="modal-header-custom"><?php echo lang('tax_details');?>
                <a href="javascript:void(0)" class="alertCloseIcon">
                    <i data-feather="x"></i>
                </a>
            </h1>
            <div class="main-content-wrapper">
                <div class="content">
                    <table class="tax-modal-table">
                        <thead>
                            <tr>
                                <th><?php echo lang('tax_name');?></th>
                                <th><?php echo lang('tax_percent');?></th>
                            </tr>
                        </thead>
                        <tbody id="tax_row_show">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="btn__box">
                <button type="button" class="cancel bg__red"><?php echo lang('cancel'); ?></button>
            </div>
        </div>
    </div>
    <!-- Tax Modal End -->



    <!-- Promo Modal -->
    <div id="show_all_promo" class="modal">
        <div class="modal-content modal_content_hold_sales">
            <h1 class="main_header"><?php echo lang('Promotion_Items');?> <a href="javascript:void(0)" class="alertCloseIcon">
                <i data-feather="x"></i>
                </a>
            </h1>
            <div class="main-content-wrapper">
                <div class="promo_modal_wrap">
                    <div class="promo_modal_header">
                        <div class="promo-h-item">
                            <h5><?php echo lang('title');?></h5>
                        </div>
                        <div class="promo-h-item">
                            <h5><?php echo lang('type');?></h5>
                        </div>
                        <div class="promo-h-item">
                            <h5><?php echo lang('item');?></h5>
                        </div>
                        <div class="promo-h-item">
                            <h5><?php echo lang('discount');?></h5>
                        </div>
                    </div>
                    <div class="promo_modal_body">
                    </div>
                </div>
            </div>
            <div class="btn__box">
                <button type="button" class="cancel bg__red"><?php echo lang('cancel'); ?></button>
            </div>
        </div>
    </div>
    <!-- Promo Modal End -->

    <!-- POS Sidebar Start -->
    <aside id="pos__sidebar">
        <div class="brand__logo op_center">
            <a href="<?php echo base_url();?>Authentication/userProfile">
                <img src="<?php echo $site_logo;?>" width="150" alt="Logo Image">
            </a>
        </div>
        <ul class="pos__menu__list">
            <li class="have_sub_menu2">
                <a href="<?php echo base_url(); ?>Authentication/userProfile" class="child-menu">
                    <iconify-icon icon="solar:home-broken" width="22"></iconify-icon>
                    <span> <?php echo lang('home'); ?></span>
                </a>
            </li>
            <?php if(isServiceAccess('','','sGmsJaFJE') && (defined('FCCPATH') && FCCPATH != 'Bangladesh')){ ?>
            <li class="have_sub_menu">
                <a href="javascript:void(0)">
                    <iconify-icon icon="solar:floor-lamp-broken" width="22"></iconify-icon>
                    <span><?php echo lang('saas'); ?></span>
                </a>
                
                <ul class="sub__menu__list">
                    <li data-access="list-25" class="menu_assign_class">
                        <a class="child-menu " href="<?php echo base_url(); ?>Service/addEditCompany">
                            
                            <?php echo lang('add_company'); ?>
                        </a>
                    </li>
                    <li data-access="list-25" class="menu_assign_class">
                        <a class="child-menu " href="<?php echo base_url(); ?>Service/companies">
                            
                            <?php echo lang('list_company'); ?>
                        </a>
                    </li>
                    <li data-access="list-25" class="menu_assign_class">
                        <a class="child-menu " href="<?php echo base_url(); ?>Service/addManualPayment">
                            
                            <?php echo lang('add_manual_payment'); ?>
                        </a>
                    </li>
                    <li data-access="list-25" class="menu_assign_class">
                        <a class="child-menu " href="<?php echo base_url(); ?>Service/paymentHistory">
                            
                            <?php echo lang('list_manual_payment'); ?>
                        </a>
                    </li>
                    <li data-access="list-25" class="menu_assign_class">
                        <a class="child-menu " href="<?php echo base_url(); ?>Service/addPricingPlan">
                            
                            <?php echo lang('add_pricing_plan'); ?>
                        </a>
                    </li>
                    <li data-access="list-25" class="menu_assign_class">
                        <a class="child-menu " href="<?php echo base_url(); ?>Service/pricingPlans">
                            
                            <?php echo lang('list_pricing_plan'); ?>
                        </a>
                    </li>
                    <li data-access="edit-23" class="menu_assign_class <?= getWhiteLabelStatus() == 1 ?  'd-block' : 'd-none'?>">
                        <a class="child-menu " href="<?php echo base_url(); ?>WhiteLabel/index">
                            <?php echo lang('white_label'); ?>
                        </a>
                    </li>
                    <li class="sub__menu__list">
                        <a class="child-menu " href="<?php echo base_url(); ?>Authentication/logingPage">
                            <?php echo lang('login_page'); ?>
                        </a>
                    </li>
                </ul>
            </li>
            <?php } ?>
            <li class="have_sub_menu">
                <a href="javascript:void(0)">
                    <iconify-icon icon="solar:widget-2-broken" width="22"></iconify-icon>
                    <span><?php echo lang('outlets'); ?></span>
                </a>
                <ul class="sub__menu__list">
                    <li data-access="add-25" class="menu_assign_class" module-is-hide="Outlet-YES">
                        <a class="child-menu" href="<?php echo base_url(); ?>Outlet/addEditOutlet">
                            <?php echo lang('add_outlet'); ?>
                        </a>
                    </li>
                    <li data-access="list-25" class="menu_assign_class" module-is-hide="Outlet-YES">
                        <a class="child-menu" href="<?php echo base_url(); ?>Outlet/outlets">
                            <?php echo lang('list_outlet'); ?>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="have_sub_menu">
                <a href="javascript:void(0)">
                    <iconify-icon icon="solar:cart-large-broken" width="22"></iconify-icon>
                    <span><?php echo lang('sale'); ?></span>
                </a>
                
                <ul class="sub__menu__list">
                    <li data-access="pos-138" class="menu_assign_class" module-is-hide="Sale-YES">
                        <a class="child-menu" href="<?php echo base_url(); ?>Sale/POS">
                            <?php echo lang('pos_screen'); ?>
                        </a>
                    </li>
                    <li data-access="list-138" class="menu_assign_class" module-is-hide="Sale-YES">
                        <a class="child-menu" href="<?php echo base_url(); ?>Sale/sales">
                            <?php echo lang('list_sale'); ?>
                        </a>
                    </li>
                    <li data-access="add-147" class="menu_assign_class" module-is-hide="Customer-YES">
                        <a class="child-menu" href="<?php echo base_url(); ?>Customer/addEditCustomer">
                            <?php echo lang('add_customer'); ?>
                        </a>
                    </li>
                    <li data-access="list-147" class="menu_assign_class" module-is-hide="Customer-YES">
                        <a class="child-menu" href="<?php echo base_url(); ?>Customer/customers">
                            <?php echo lang('list_customer'); ?>
                        </a>
                    </li>
                    <li data-access="add-154" class="menu_assign_class" module-is-hide="Customer Group-YES">
                        <a class="child-menu" href="<?php echo base_url(); ?>Group/addEditGroup">
                            <?php echo lang('add_customer_group'); ?>
                        </a>
                    </li>
                    <li data-access="list-154" class="menu_assign_class" module-is-hide="Customer Group-YES">
                        <a class="child-menu" href="<?php echo base_url(); ?>Group/groups">
                            <?php echo lang('list_customer_group'); ?>
                        </a>
                    </li>
                    <li data-access="add-133" class="menu_assign_class " module-is-hide="Promotion-YES">
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Promotion/addEditPromotion'?>">
                            <?php echo lang('add_promotion'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <li data-access="add-133" class="menu_assign_class " module-is-hide="Promotion-YES">
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Promotion/promotions'?>">
                            <?php echo lang('list_promotion'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <li data-access="add-159" class="menu_assign_class " module-is-hide="Delivery Partner-YES">
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Delivery_partner/addEditPartner'?>">
                            <?php echo lang('add_delivery_partner'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <li data-access="add-159" class="menu_assign_class " module-is-hide="Delivery Partner-YES">
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Delivery_partner/listPartner'?>">
                            <?php echo lang('list_delivery_partner'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="have_sub_menu">
                <a href="javascript:void(0)" class="align-middle">
                    <iconify-icon icon="solar:list-heart-broken" width="22"></iconify-icon>
                    <span><?php echo lang('Item_Product'); ?></span>
                </a>
                
                <ul class="sub__menu__list">
                    <li data-access="add-49" class="menu_assign_class" module-is-hide="Item-YES">
                        <a class="child-menu " href="<?php echo base_url(); ?>Item/addEditItem">
                            <?php echo lang('add_item'); ?>
                        </a>
                    </li>
                    <li data-access="list-49" class="menu_assign_class" module-is-hide="Item-YES">
                        <a class="child-menu " href="<?php echo base_url(); ?>Item/items">
                            <?php echo lang('list_item'); ?>
                        </a>
                    </li>
                    
                    <li data-access="list-49" class="menu_assign_class " module-is-hide="Item-YES">
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Item/bulkItemUpdate'?>">
                            <?php echo lang('bulk_item_update'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>


                    <li data-access="add-60" class="menu_assign_class" module-is-hide="Item Category-YES">
                        <a class="child-menu " href="<?php echo base_url(); ?>Category/addEditItemCategory">
                            <?php echo lang('add_item_category'); ?>
                        </a>
                    </li>
                    <li data-access="list-60" class="menu_assign_class" module-is-hide="Item Category-YES">
                        <a class="child-menu " href="<?php echo base_url(); ?>Category/itemCategories">
                            <?php echo lang('list_item_category'); ?>
                        </a>
                    </li>

                    <li data-access="add-304" class="menu_assign_class " module-is-hide="Rack-YES">
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Rack/addEditRack'?>">
                            <?php echo lang('add_rack'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <li data-access="list-304" class="menu_assign_class " module-is-hide="Rack-YES">
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Rack/rackList'?>">
                            <?php echo lang('list_rack'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <li data-access="add-65" class="menu_assign_class" module-is-hide="Unit-YES">
                        <a class="child-menu " href="<?php echo base_url(); ?>Unit/addEditUnit">
                            <?php echo lang('add_unit'); ?>
                        </a>
                    </li>
                    <li data-access="list-65" class="menu_assign_class" module-is-hide="Unit-YES">
                        <a class="child-menu " href="<?php echo base_url(); ?>Unit/units">
                            <?php echo lang('list_unit'); ?>
                        </a>
                    </li>

                    <li data-access="add-70" class="menu_assign_class " module-is-hide="Variation Attribute-YES">
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Variation/addEditVariation'?>">
                            <?php echo lang('add_variation_attribute'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>

                    <li data-access="list-70" class="menu_assign_class " module-is-hide="Variation Attribute-YES">
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Variation/variations'?>">
                            <?php echo lang('list_variation_attribute'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>

                    <li data-access="add-297" class="menu_assign_class" module-is-hide="Brand-YES">
                        <a class="child-menu " href="<?php echo base_url(); ?>Brand/addEditBrand">
                            <?php echo lang('add_brand'); ?>
                        </a>
                    </li>
                    <li data-access="list-297" class="menu_assign_class" module-is-hide="Brand-YES">
                        <a class="child-menu " href="<?php echo base_url(); ?>Brand/brands">
                            <?php echo lang('list_brand'); ?>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="have_sub_menu2 menu_assign_class" data-access="view-30" module-is-hide="Dashboard-YES">
                <a class="child-menu offline_prevent" href="<?php echo base_url(); ?>Dashboard/dashboard">
                    <iconify-icon icon="solar:chart-2-broken" width="22"></iconify-icon> 
                    <span><?php echo lang('dashboard'); ?></span>
                </a>
            </li>
            <li class="have_sub_menu2 menu_assign_class" data-access="view-164" module-is-hide="Stock-YES">
                <a class="child-menu " href="<?php echo base_url(); ?>Stock/stock">
                    <iconify-icon icon="solar:database-broken" width="22"></iconify-icon> 
                    <span><?php echo lang('stock'); ?></span>
                </a>
            </li>
            <li class="have_sub_menu">
                <a href="javascript:void(0)">
                    <iconify-icon icon="solar:archive-broken" width="22"></iconify-icon>
                    <span><?php echo lang('purchase'); ?></span>
                </a>
                
                <ul class="sub__menu__list">
                    <li data-access="add-109" class="menu_assign_class" module-is-hide="Purchase-YES">
                        <a class="child-menu " href="<?php echo base_url(); ?>Purchase/addEditPurchase">
                            <?php echo lang('add_purchase'); ?>
                        </a>
                    </li>
                    <li data-access="list-109" class="menu_assign_class" module-is-hide="Purchase-YES">
                        <a class="child-menu " href="<?php echo base_url(); ?>Purchase/purchases">
                            <?php echo lang('list_purchase'); ?>
                        </a>
                    </li>
                    <li data-access="add-117" class="menu_assign_class" module-is-hide="Supplier-YES">
                        <a class="child-menu " href="<?php echo base_url(); ?>Supplier/addEditSupplier">
                            <?php echo lang('add_supplier'); ?>
                        </a>
                    </li>
                    <li data-access="list-117" class="menu_assign_class" module-is-hide="Supplier-YES">
                        <a class="child-menu " href="<?php echo base_url(); ?>Supplier/suppliers">
                            <?php echo lang('list_supplier'); ?>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="have_sub_menu">
                <a href="javascript:void(0)">
                    <iconify-icon icon="solar:card-recive-broken" width="22"></iconify-icon>
                    <span><?php echo lang('customer_receive'); ?></span>
                </a>
                
                <ul class="sub__menu__list">
                    <li data-access="add-198" class="menu_assign_class" module-is-hide="Customer Receive-YES">
                        <a class="child-menu " href="<?php echo base_url(); ?>Customer_due_receive/addCustomerDueReceive">
                            <?php echo lang('add_customer_due_receive'); ?>
                        </a>
                    </li>
                    <li data-access="list-198" class="menu_assign_class" module-is-hide="Customer Receive-YES">
                        <a class="child-menu " href="<?php echo base_url(); ?>Customer_due_receive/customerDueReceives">
                            <?php echo lang('list_customer_due_receive'); ?>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="have_sub_menu">
                <a href="javascript:void(0)">
                    <iconify-icon icon="solar:card-send-broken" width="22"></iconify-icon>
                    <span><?php echo lang('supplier_payment'); ?></span>
                </a>
                
                <ul class="sub__menu__list">
                    <li data-access="add-192" class="menu_assign_class" module-is-hide="Supplier Payment-YES">
                        <a class="child-menu " href="<?php echo base_url(); ?>SupplierPayment/addSupplierPayment">
                            <?php echo lang('add_supplier_payment'); ?>
                        </a>
                    </li>
                    <li data-access="list-192" class="menu_assign_class" module-is-hide="Supplier Payment-YES">
                        <a class="child-menu " href="<?php echo base_url(); ?>SupplierPayment/supplierPayments">
                            <?php echo lang('list_supplier_payment'); ?>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="have_sub_menu">
                <a href="javascript:void(0)">
                    <iconify-icon icon="solar:wallet-money-broken" width="22"></iconify-icon>
                    <span><?php echo lang('Accounting'); ?></span> 
                </a>
                
                <ul class="sub__menu__list">
                    <li data-access="add-218" class="menu_assign_class" module-is-hide="Account-YES">
                        <a class="child-menu " href="<?php echo base_url(); ?>PaymentMethod/addEditPaymentMethod">
                            <?php echo lang('add_account'); ?>
                        </a>
                    </li>
                    <li data-access="list-218" class="menu_assign_class" module-is-hide="Account-YES">
                        <a class="child-menu " href="<?php echo base_url(); ?>PaymentMethod/paymentMethods">
                            <?php echo lang('list_account'); ?>
                        </a>
                    </li>
                    <li data-access="add-223" class="menu_assign_class " module-is-hide="Diposit-YES">
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Deposit/addEditDeposit'?>">
                            <?php echo lang('add_deposit_or_withdraw'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>

                    <li data-access="list-223" class="menu_assign_class " module-is-hide="Diposit-YES">
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Deposit/deposits'?>">
                            <?php echo lang('list_deposit_or_withdraw'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <li data-access="list-228" class="menu_assign_class " module-is-hide="Balance Sheet-YES">
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Accounting/balanceStatement'?>">
                            <?php echo lang('Balance_Statement'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <li data-access="list-230" class="menu_assign_class " module-is-hide="Trial Balance-YES">
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Accounting/trialBalance'?>">
                            <?php echo lang('Trial_Balance'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <li data-access="list-232" class="menu_assign_class " module-is-hide="Balance Statement-YES">
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Accounting/balanceSheet'?>">
                            <?php echo lang('Balance_Sheet'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    
                </ul>
            </li>
            <li class="have_sub_menu">
                <a href="javascript:void(0)">
                    <iconify-icon icon="solar:clock-square-broken" width="22"></iconify-icon>
                    <span><?php echo lang('attendance'); ?></span>
                </a>
                
                <ul class="sub__menu__list">

                    <li data-access="add-234" class="menu_assign_class " module-is-hide="Attendance-YES">
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Attendance/addEditAttendance'?>">
                            <?php echo lang('add_attendance'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <li data-access="list-234" class="menu_assign_class " module-is-hide="Attendance-YES">
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Attendance/attendances'?>">
                            <?php echo lang('list_attendance'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    
                </ul>
            </li>
            <li class="have_sub_menu">
                <a href="javascript:void(0)">
                    <iconify-icon icon="solar:diagram-down-broken" width="22"></iconify-icon>
                    <span><?php echo lang('report'); ?></span>
                </a>
                
                <ul class="sub__menu__list">
                    <li data-access="register_report-249" class="menu_assign_class " module-is-hide="Register Report-YES">
                        <a class="child-menu " href="<?php echo base_url(); ?>Report/registerReport">
                            <?php echo lang('register_report'); ?>
                        </a>
                    </li>

                    <li data-access="zReport-249" class="menu_assign_class " module-is-hide="Z Report-YES">
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Report/zReport'?>">
                            <?php echo lang('z_report'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <li data-access="daily_summary_report-249" class="menu_assign_class " module-is-hide="Daily Summary Report-YES">
                        <a class="child-menu " href="<?php echo base_url(); ?>Report/dailySummaryReport">
                            <?php echo lang('daily_summary_report'); ?>
                        </a>
                    </li>
                    <li data-access="sale_report-249" class="menu_assign_class" module-is-hide="Sale Report-YES">
                        <a class="child-menu " href="<?php echo base_url(); ?>Report/saleReport">
                            <?php echo lang('sale_report'); ?>
                        </a>
                    </li>
                    <li data-access="sale_report-249" class="menu_assign_class" module-is-hide="Sale Report-YES">
                        <a class="child-menu " href="<?php echo base_url(); ?>Report/dueSaleReport">
                            <?php echo lang('due_sale_report'); ?>
                        </a>
                    </li>

                    <li data-access="service_sale_report-249" class="menu_assign_class" module-is-hide="Service Sale Report-YES">
                        <a class="child-menu " href="<?php echo base_url(); ?>Report/serviceSaleReport">
                            <?php echo lang('service_sale_report'); ?>
                        </a>
                    </li>
                    <li data-access="service_sale_report-249" class="menu_assign_class " module-is-hide="Combo Service Report-YES">
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Report/comboServiceReport'?>">
                            <?php echo lang('combo_service_report'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <li data-access="stock_report-249" class="menu_assign_class" module-is-hide="Stock Report-YES">
                        <a class="child-menu " href="<?php echo base_url(); ?>Report/stockReport">
                            <?php echo lang('stock_report'); ?>
                        </a>
                    </li>
                    <li data-access="stock_report-249" class="menu_assign_class " module-is-hide="Stock Report-YES">
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Report/expiryStock'?>">
                            <?php echo lang('medicine_expire_report'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <li data-access="employee_sale_report-249" class="menu_assign_class " module-is-hide="Employee Sale Report-YES">
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Report/employeeSaleReport'?>">
                            <?php echo lang('employee_sale_report'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <li data-access="customer_receive_report-249" class="menu_assign_class" module-is-hide="Customer Receive Report-YES">
                        <a class="child-menu " href="<?php echo base_url(); ?>Report/customerDueReceiveReport">
                            <?php echo lang('customer_due_receive_report'); ?>
                        </a>
                    </li>

                    <li data-access="attendance_report-249" class="menu_assign_class " module-is-hide="Attandance Report-YES">
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Report/attendanceReport'?>">
                            <?php echo lang('attendance_report'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <li data-access="product_profit_report-249" class="menu_assign_class " module-is-hide="Product Profit Report-YES">
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Report/productProfitReport'?>">
                            <?php echo lang('productProfitReport'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    
                    <li data-access="supplier_ledger-249" class="menu_assign_class" module-is-hide="Supplier Ledger Report-YES">
                        <a class="child-menu " href="<?php echo base_url(); ?>Company_report/supplierLedgerReport">
                            <?php echo lang('supplier_ledger_report'); ?>
                        </a>
                    </li>
                    <li data-access="supplier_balance_report-249" class="menu_assign_class " module-is-hide="Supplier Balance Report-YES">
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Company_report/supplierBalanceReport'?>">
                            <?php echo lang('supplier_balance_report'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <li data-access="customer_ledger-249" class="menu_assign_class " module-is-hide="Customer Ledger Report-YES">
                        <a class="child-menu " href="<?php echo base_url(); ?>Company_report/customerLedgerReport">
                            <?php echo lang('customer_ledger_report'); ?>
                        </a>
                    </li>
                    <li data-access="customer_balance_report-249" class="menu_assign_class " module-is-hide="Customer Balance Report-YES">
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Company_report/customerBalanceReport'?>">
                            <?php echo lang('customer_balance_report'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <?php if(!moduleIsHideCheck('Servicing-YES')){ ?>
                    <li data-access="servicing_report-249" class="menu_assign_class " module-is-hide="Servicing Report-YES">
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Report/servicingReport'?>">
                            <?php echo lang('servicing_report'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <?php } ?>
                    <li data-access="product_sale_report-249" class="menu_assign_class " module-is-hide="Product Sale Report-YES">
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Report/productSaleReport'?>">
                            <?php echo lang('productSaleReport'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <?php 
                    $collect_tax = $this->session->userdata('collect_tax');
                    if($collect_tax=="Yes"){
                    ?>
                    <li data-access="tax_report-249" class="menu_assign_class " module-is-hide="Tax Report-YES">
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Report/taxReport'?>">
                            <?php echo lang('tax'); ?> <?php echo lang('report'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <?php } ?>
                    <li data-access="detailed_sale_report-249" class="menu_assign_class " module-is-hide="Detailed Sale Report-YES">
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Report/detailedSaleReport'?>">
                            <?php echo lang('detailed_sale_report'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <li data-access="low_stock_report-249" class="menu_assign_class " module-is-hide="Low Stock Report-YES">
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Report/getStockAlertList'?>">
                            <?php echo lang('low_stock_report'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    
                    <li data-access="profit_loss_report-249" class="menu_assign_class" module-is-hide="Profit Loss Report-YES">
                        <a class="child-menu " href="<?php echo base_url(); ?>Report/profitLossReport">
                            <?php echo lang('profit_loss_report'); ?>
                        </a>
                    </li>
                    <li data-access="purchase_report-249" class="menu_assign_class " module-is-hide="Purchase Report-YES">
                        <a class="child-menu " href="<?php echo base_url(); ?>Report/purchaseReportByDate">
                            <?php echo lang('purchase_report'); ?>
                        </a>
                    </li>
                    <li data-access="product_purchase_report-249" class="menu_assign_class " module-is-hide="Product Purchase Report-YES">
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Report/productPurchaseReport'?>">
                            <?php echo lang('productPurchaseReport'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <li data-access="expense_report-249" class="menu_assign_class" module-is-hide="Expense Report-YES">
                        <a class="child-menu " href="<?php echo base_url(); ?>Report/expenseReport">
                            <?php echo lang('expense_report'); ?>
                        </a>
                    </li>
                    <li data-access="income_report-249" class="menu_assign_class " module-is-hide="Income Report-YES">
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Report/incomeReport'?>">
                            <?php echo lang('income_report'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <li data-access="salary_report-249" class="menu_assign_class " module-is-hide="Salary Report-YES">
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Report/salaryReport'?>">
                            <?php echo lang('salary_report'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <li data-access="purchase_return_report-249" class="menu_assign_class " module-is-hide="Purchase Return Report-YES">
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Report/purchaseReturnReport'?>">
                            <?php echo lang('purchase_return_report'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <li data-access="sale_return_report-249" class="menu_assign_class " module-is-hide="Sale Return Report-YES">
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Report/saleReturnReport'?>">
                            <?php echo lang('sale_return_report'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <?php if(!moduleIsHideCheck('Damage-YES')){ ?>
                    <li data-access="damage_report-249" class="menu_assign_class " module-is-hide="Damage Report-YES">
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Report/damageReport'?>">
                            <?php echo lang('damage_report'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <?php } ?>
                    <?php if(!moduleIsHideCheck('Installment-YES')){ ?>
                    <li data-access="installment_report-249" class="menu_assign_class " module-is-hide="Installment Report-YES">
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Report/installmentReport'?>">
                            <?php echo lang('Installment Report'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <li data-access="installment_due_report-249" class="menu_assign_class " module-is-hide="Installment Due Report-YES">
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Report/installmentDueReport'?>">
                            <?php echo lang('installmentDueReport'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <?php } ?>
                    
                    <li data-access="item_tracing_report-249" class="menu_assign_class " module-is-hide="Item Tracing Report-YES">
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Report/itemMoving'?>">
                            <?php echo lang('Item_Tracing'); ?> <?php echo lang('report'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <li data-access="price_history_report-249" class="menu_assign_class " module-is-hide="Price History Report-YES">
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Report/priceHistory'?>">
                            <?php echo lang('price_history'); ?> <?php echo lang('report'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <li data-access="cash_flow_report-249" class="menu_assign_class " module-is-hide="Cash Flow Report-YES">
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Company_report/cashFlowReport'?>">
                            <?php echo lang('cash_flow'); ?> <?php echo lang('report'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <li data-access="available_loyalty_point-249" class="menu_assign_class " module-is-hide="Available Loyalty Point Report-YES">
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Report/availableLoyaltyPointReport'?>">
                            <?php echo lang('available_loyalty_point_report'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <li data-access="usage_loyalty_point-249" class="menu_assign_class " module-is-hide="Usages Loyalty Point Report-YES">
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Report/usageLoyaltyPointReport'?>">
                            <?php echo lang('usage_loyalty_point_report'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="have_sub_menu">
                <a href="javascript:void(0)">
                    <iconify-icon icon="solar:rewind-forward-broken" width="22"></iconify-icon>
                    <span><?php echo lang('expense'); ?></span> 
                </a>
                
                <ul class="sub__menu__list">
                    <li data-access="add-172" class="menu_assign_class" module-is-hide="Expense-YES">
                        <a class="child-menu " href="<?php echo base_url(); ?>Expense/addEditExpense">
                            <?php echo lang('add_expense'); ?>
                        </a>
                    </li>
                    <li data-access="list-172" class="menu_assign_class" module-is-hide="Expense-YES">
                        <a class="child-menu " href="<?php echo base_url(); ?>Expense/expenses">
                            <?php echo lang('list_expense'); ?>
                        </a>
                    </li>
                    <li data-access="add-177" class="menu_assign_class" module-is-hide="Expense Category-YES">
                        <a class="child-menu " href="<?php echo base_url(); ?>ExpenseItem/addEditExpenseItem">
                            <?php echo lang('add_expense_item'); ?>
                        </a>
                    </li>
                    <li data-access="list-177" class="menu_assign_class" module-is-hide="Expense Category-YES">
                        <a class="child-menu " href="<?php echo base_url(); ?>ExpenseItem/expenseItems">
                            <?php echo lang('list_expense_item'); ?>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="have_sub_menu">
                <a href="javascript:void(0)">
                    <iconify-icon icon="solar:rewind-back-broken" width="22"></iconify-icon>
                    <span><?php echo lang('income'); ?></span>
                </a>
                
                <ul class="sub__menu__list ">
                    <li data-access="add-182" class="menu_assign_class " module-is-hide="Income-YES">
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Income/addEditIncome'?>">
                            <?php echo lang('add_income'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <li data-access="list-182" class="menu_assign_class " module-is-hide="Income-YES">
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Income/incomes'?>">
                            <?php echo lang('list_income'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <li data-access="add-187" class="menu_assign_class " module-is-hide="Income Category-YES">
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'IncomeItem/addEditIncomeItem'?>">
                            <?php echo lang('add_income_item'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <li data-access="list-187" class="menu_assign_class " module-is-hide="Income Category-YES">
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'IncomeItem/incomeItems'?>">
                            <?php echo lang('list_income_item'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="have_sub_menu ">
                <a href="javascript:void(0)">
                    <iconify-icon icon="solar:multiple-forward-left-broken" width="22"></iconify-icon>
                    <span><?php echo lang('sale_return'); ?></span>
                </a>
                
                <ul class="sub__menu__list">
                    <li data-access="add-204" class="menu_assign_class " module-is-hide="Sale Return-YES">
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Sale_return/addEditSaleReturn'?>">
                            <?php echo lang('add_sale_return'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <li data-access="list-204" class="menu_assign_class " module-is-hide="Sale Return-YES">
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Sale_return/saleReturns'?>">
                            <?php echo lang('list_sale_return'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="have_sub_menu ">
                <a href="javascript:void(0)">
                    <iconify-icon icon="solar:multiple-forward-right-broken" width="22"></iconify-icon>
                    <span><?php echo lang('purchase_ruturn'); ?></span>
                </a>
                <ul class="sub__menu__list">


                    <li data-access="add-211" class="menu_assign_class " module-is-hide="Purchase Return-YES">
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Purchase_return/addEditPurchaseReturn'?>">
                            <?php echo lang('add_purchase_ruturn'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <li data-access="list-211" class="menu_assign_class " module-is-hide="Purchase Return-YES">
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Purchase_return/purchaseReturns'?>">
                            <?php echo lang('list_purchase_ruturn'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="have_sub_menu">
                <a href="javascript:void(0)" class="child-menu ">
                    <iconify-icon icon="solar:settings-broken" width="22"></iconify-icon>
                    <span><?php echo lang('setting'); ?></span>
                </a>
                <ul class="sub__menu__list">
                    <?php 
                    $user_id = $this->session->userdata('user_id');
                    $company_id = $this->session->userdata('company_id');
                    if(isServiceAccess2($user_id, $company_id, 'sGmsJaFJE') == 'Saas Company'){ ?>
                    <li data-access="edit-1" class="menu_assign_class ">
                        <a class="child-menu " href="<?php echo base_url(); ?>Service/planDetails">
                            <?php echo lang('plan_details'); ?>
                        </a>
                    </li>
                    <?php } ?>
                    <li data-access="edit-1" class="menu_assign_class" module-is-hide="Setting-YES">
                        <a class="child-menu" href="<?php echo base_url(); ?>Setting/index">
                            <?php echo lang('setting'); ?>
                        </a>
                    </li>
                    <li data-access="edit-1" class="menu_assign_class" module-is-hide="Setting-YES">
                        <a class="child-menu" href="<?php echo base_url(); ?>Setting/invoiceSetting">
                            <?php echo lang('invoice_configuration'); ?>
                        </a>
                    </li>
                    <li data-access="edit-1" class="menu_assign_class ">
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Setting/moduleManagement'?>">
                            <?php echo lang('module_management'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <li data-access="whatsappSetting-327" class="menu_assign_class " module-is-hide="Whatsapp Setting-YES"> 
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Setting/whatsappSetting'?>">
                            <?php echo lang('whatsapp_setting'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <li data-access="add-3" class="menu_assign_class" module-is-hide="Denomination-YES">
                        <a class="child-menu " href="<?php echo base_url(); ?>Denomination/addEditDenomination">
                            <?php echo lang('add'); ?> <?php echo lang('denomination'); ?>
                        </a>
                    </li>
                    <li data-access="list-3" class="menu_assign_class" module-is-hide="Denomination-YES">
                        <a class="child-menu " href="<?php echo base_url(); ?>Denomination/denominations"> 
                            <?php echo lang('list'); ?> <?php echo lang('denomination'); ?>
                        </a>
                    </li>
                    <li data-access="add-340" class="menu_assign_class" module-is-hide="Counter-YES">
                        <a class="child-menu " href="<?php echo base_url(); ?>Counter/addEditCounter">
                            <?php echo lang('add_counter'); ?>
                        </a>
                    </li>
                    <li data-access="list-340" class="menu_assign_class" module-is-hide="Counter-YES">
                        <a class="child-menu " href="<?php echo base_url(); ?>Counter/counters">
                            <?php echo lang('list_counter'); ?>
                        </a>
                    </li>
                    <li data-access="edit-8" class="menu_assign_class " module-is-hide="Tax Setting-YES"> 
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Tax_setting/tax'?>">
                            <?php echo lang('Tax_Setting'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <li data-access="edit-10" class="menu_assign_class " module-is-hide="Email Setting-YES"> 
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Email_setting/emailConfiguration'?>">
                            <?php echo lang('Email_Setting'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <li data-access="edit-12" class="menu_assign_class " module-is-hide="SMS Setting-YES"> 
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Short_message_service/smsService'?>">
                            <?php echo lang('SMS_Setting'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <li data-access="edit-14" class="menu_assign_class " module-is-hide="Printer Setup-YES"> 
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Printer/printerSetup'?>">
                            <?php echo lang('printer_setup'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>

                    <?php if(!isServiceAccess('','','sGmsJaFJE') && (defined('FCCPATH') && FCCPATH != 'Bangladesh')){ ?>
                    <li data-access="edit-23" class="menu_assign_class <?= getWhiteLabelStatus() == 1 ?  'd-block' : 'd-none'?>" module-is-hide="White Label-YES">
                        <a class="child-menu " href="<?php echo base_url(); ?>WhiteLabel/index">
                            <?php echo lang('white_label'); ?>
                        </a>
                    </li>
                    <li data-access="edit-23" class="menu_assign_class " module-is-hide="Login Page-YES">
                        <a class="child-menu " href="<?php echo base_url(); ?>Authentication/logingPage">
                            <?php echo lang('login_page'); ?>
                        </a>
                    </li>
                    <?php } ?>

                    <li data-access="edit-335" class="menu_assign_class " module-is-hide="Payment Getway-YES"> 
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Payment_getway/paymentGetway'?>">
                            <?php echo lang('payment_getway'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>

                    <li data-access="edit-311" class="menu_assign_class " module-is-hide="Multiple Currency-YES"> 
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'MultipleCurrency/addEditMultipleCurrency'?>">
                            <?php echo lang('add_multiple_currency'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <li data-access="edit-311" class="menu_assign_class " module-is-hide="Multiple Currency-YES"> 
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'MultipleCurrency/multipleCurrencies'?>">
                            <?php echo lang('list_multiple_currency'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <li data-access="add_dummy_data-325" class="menu_assign_class " module-is-hide="Import Dummy Data-YES"> 
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : 'add_dummy_data'?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Setting/add_dummy_data'?>">
                            <?php echo lang('add_dummy_data'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <li data-access="deleteDummyData-329" class="menu_assign_class " module-is-hide="Delete Dummy Data-YES"> 
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : 'delete'?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Setting/deleteDummyData'?>">
                            <?php echo lang('delete_dummy_data'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <li data-access="wipeTransactionalData-331" class="menu_assign_class " module-is-hide="Wipe Transactional Data-YES"> 
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : 'delete'?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Setting/wipeTransactionalData'?>">
                            <?php echo lang('wipe_transactional_data'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <li data-access="wipeAllData-333" class="menu_assign_class " module-is-hide="Wipe All Data-YES"> 
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : 'delete'?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Setting/wipeAllData'?>">
                            <?php echo lang('wipe_all_data'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="have_sub_menu">
                <a href="javascript:void(0)">
                    <iconify-icon icon="solar:shield-keyhole-minimalistic-broken" width="22"></iconify-icon>
                    <span><?php echo lang('authentication'); ?></span>
                </a>
                
                <ul class="sub__menu__list">
                    <li data-access="add-282" class="menu_assign_class" module-is-hide="Role Management-YES">
                        <a class="child-menu " href="<?php echo base_url(); ?>Role/addEditRole">
                            <?php echo lang('add_role'); ?>
                        </a>
                    </li>
                    <li data-access="list-282" class="menu_assign_class" module-is-hide="Role Management-YES">
                        <a class="child-menu " href="<?php echo base_url(); ?>Role/listRole">
                            <?php echo lang('list_role'); ?>
                        </a>
                    </li>
                    <li data-access="add-287" class="menu_assign_class" module-is-hide="Employee Management-YES">
                        <a class="child-menu " href="<?php echo base_url(); ?>User/addEditUser">
                            <?php echo lang('add_employee'); ?>
                        </a>
                    </li>
                    <li data-access="list-287" class="menu_assign_class" module-is-hide="Employee Management-YES">
                        <a class="child-menu " href="<?php echo base_url(); ?>User/users">
                            <?php echo lang('list_employee'); ?>
                        </a>
                    </li>
                    <li data-access="change_profile-287" class="menu_assign_class" module-is-hide="Employee Management-YES">
                        <a class="child-menu " href="<?php echo base_url(); ?>User/changeProfile">
                            <?php echo lang('change_profile'); ?>
                        </a>
                    </li>
                    <li data-access="change_password-287" class="menu_assign_class" module-is-hide="Employee Management-YES">
                        <a class="child-menu " href="<?php echo base_url(); ?>User/changePassword">
                            <?php echo lang('change_password'); ?>
                        </a>
                    </li>
                    <li data-access="set_security_quatation-287" class="menu_assign_class" module-is-hide="Employee Management-YES">
                        <a class="child-menu " href="<?php echo base_url(); ?>User/securityQuestion">
                            <?php echo lang('SetSecurityQuestion'); ?>
                        </a>
                    </li>
                </ul>
            </li>
            
            <?php
            $i_sale = $this->session->userdata('i_sale');
            if(isset($i_sale) && $i_sale=="Yes"){ ?>
                <li class="have_sub_menu">
                    <a href="javascript:void(0)">
                        <iconify-icon icon="solar:layers-broken" width="22"></iconify-icon>
                        <span><?php echo lang('installment_sales'); ?></span>
                    </a>
                    
                    <ul class="sub__menu__list">
                        
                        <li data-access="add-93" class="menu_assign_class " module-is-hide="Installment Customer-YES"> 
                            <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Installment/addEditCustomer'?>">
                                <?php echo lang('add_installment_customer'); ?>
                                <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                            </a>
                        </li>
                        <li data-access="list-93" class="menu_assign_class " module-is-hide="Installment Customer-YES"> 
                            <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Installment/customers'?>">
                                <?php echo lang('list_installment_customer'); ?>
                                <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                            </a>
                        </li>
                        <li data-access="add-100" class="menu_assign_class " module-is-hide="Installment Sale-YES"> 
                            <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Installment/addEditInstallmentSale'?>">
                                <?php echo lang('add_installment_sale'); ?>
                                <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                            </a>
                        </li>
                        <li data-access="list-100" class="menu_assign_class " module-is-hide="Installment Sale-YES"> 
                            <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Installment/installmentSales'?>">
                                <?php echo lang('list_installment_sales'); ?>
                                <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                            </a>
                        </li>
                        <li data-access="installment_collection-100" class="menu_assign_class " module-is-hide="Installment Sale-YES"> 
                            <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Installment/installmentCollections'?>">
                                <?php echo lang('installment_collection'); ?>
                                <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                            </a>
                        </li>
                        <li data-access="due_installment-100" class="menu_assign_class " module-is-hide="Installment Sale-YES"> 
                            <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Installment/listDueInstallment'?>">
                                <?php echo lang('installment_collection'); ?>
                                <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                            </a>
                        </li>
                        
                    </ul>
                </li>
            <?php } ?>
            <li class="have_sub_menu">
                <a href="javascript:void(0)">
                    <iconify-icon icon="solar:sunset-broken" width="22"></iconify-icon>
                    <span><?php echo lang('warranty_servicing'); ?></span>
                </a>
                
                <ul class="sub__menu__list">
                    <li data-access="add-75" class="menu_assign_class" module-is-hide="Servicing-YES">
                        <a class="child-menu " href="<?php echo base_url();?>Servicing/addEditServicing">
                            <?php echo lang('add_servicing'); ?>
                        </a>
                    </li>
                    <li data-access="list-75" class="menu_assign_class" module-is-hide="Servicing-YES">
                        <a class="child-menu " href="<?php echo base_url();?>Servicing/listServicing">
                            <?php echo lang('list_servicing'); ?>
                        </a>
                    </li>
                    
                    <li data-access="filter-85" class="menu_assign_class " module-is-hide="Warranty-YES"> 
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Warranty/checkWarranty'?>">
                            <?php echo lang('warranty_checking'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <li data-access="add-80" class="menu_assign_class " module-is-hide="Warranty-YES"> 
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'WarrantyProducts/addEditWarrantyProduct'?>">
                            <?php echo lang('add_warranty'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <li data-access="list-80" class="menu_assign_class " module-is-hide="Warranty-YES"> 
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'WarrantyProducts/listWarrantyProduct'?>">
                            <?php echo lang('list_warranty'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="have_sub_menu ">
                <a href="javascript:void(0)">
                    <iconify-icon icon="solar:transmission-broken" width="22"></iconify-icon>
                    <span><?php echo lang('salary_payroll'); ?></span>
                </a>
                
                <ul class="sub__menu__list">
                    <li data-access="list-87" class="menu_assign_class " module-is-hide="Salary-YES"> 
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Salary/generate'?>">
                            <?php echo lang('list_salary_payroll'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="have_sub_menu ">
                <a href="javascript:void(0)" class="align-middle">
                    <iconify-icon icon="solar:cassette-broken" width="22"></iconify-icon>
                    <span><?php echo lang('fixed_assets'); ?></span>
                </a>
                
                <ul class="sub__menu__list">
                    <li data-access="add-32" class="menu_assign_class " module-is-hide="Fixed Item-YES"> 
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Fixed_assets/addEditItem'?>">
                            <?php echo lang('add_item'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <li data-access="list-32" class="menu_assign_class " module-is-hide="Fixed Item-YES"> 
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Fixed_assets/listItem'?>">
                            <?php echo lang('list_item'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <li data-access="add-37" class="menu_assign_class " module-is-hide="Stock In-YES"> 
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Fixed_asset_stock/addEditStock'?>">
                            <?php echo lang('add_stock_in'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <li data-access="list-37" class="menu_assign_class " module-is-hide="Stock In-YES"> 
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Fixed_asset_stock/listStock'?>">
                            <?php echo lang('list_stock_in'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <li data-access="add-42" class="menu_assign_class " module-is-hide="Stock Out-YES"> 
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Fixed_asset_stock_out/addEditStockOut'?>">
                            <?php echo lang('add_stock_out'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <li data-access="list-42" class="menu_assign_class " module-is-hide="Stock Out-YES"> 
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Fixed_asset_stock_out/listStockOut'?>">
                            <?php echo lang('list_stock_out'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <li data-access="view-47" class="menu_assign_class " module-is-hide="Stock Out-YES"> 
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Fixed_asset_stock/stocks'?>">
                            <?php echo lang('stock'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="have_sub_menu ">
                <a href="javascript:void(0)">
                    <iconify-icon icon="solar:ruler-pen-broken" width="22"></iconify-icon>
                    <span><?php echo lang('quotation'); ?></span>
                </a>
                
                <ul class="sub__menu__list">
                    <li data-access="add-239" class="menu_assign_class " module-is-hide="Quatation-YES"> 
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Quotation/addEditQuotation'?>">
                            <?php echo lang('add_quotation'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <li data-access="list-239" class="menu_assign_class " module-is-hide="Quatation-YES"> 
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Quotation/quotations'?>">
                            <?php echo lang('list_quotation'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="have_sub_menu ">
                <a href="javascript:void(0)">
                    <iconify-icon icon="solar:bicycling-round-broken" width="22"></iconify-icon>
                    <span><?php echo lang('transfer'); ?></span>
                </a>
                
                <ul class="sub__menu__list">
                    <li data-access="add-125" class="menu_assign_class " module-is-hide="Transfer-YES"> 
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Transfer/addEditTransfer'?>">
                            <?php echo lang('add_transfer'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <li data-access="list-125" class="menu_assign_class " module-is-hide="Transfer-YES"> 
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Transfer/transfers'?>">
                            <?php echo lang('list_transfer'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="have_sub_menu ">
                <a href="javascript:void(0)">
                    <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="22"></iconify-icon>
                    <span><?php echo lang('damage'); ?></span>
                </a>
                
                <ul class="sub__menu__list">
                    <li data-access="add-166" class="menu_assign_class " module-is-hide="Damage-YES"> 
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Damage/addEditDamage'?>">
                            <?php echo lang('add_damage'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                    <li data-access="list-166" class="menu_assign_class " module-is-hide="Damage-YES"> 
                        <a class="child-menu <?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'biponi_silver' : ''?>" href="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? 'javascript:void(0)' : base_url().'Damage/damages'?>">
                            <?php echo lang('list_damage'); ?>
                            <iconify-icon icon="solar:crown-star-line-duotone" class="<?php echo ($s_status == 'Bangladesh' && $pakl == 'silver') ? '' : 'd-none'?>"></iconify-icon>
                        </a>
                    </li>
                </ul>
            </li>
            <?php 
            $company_id = $this->session->userdata('company_id');
            $user_id = $this->session->userdata('user_id');
            if((isServiceAccess2($user_id, $company_id,'sGmsJaFJE') == 'Not SaaS') && FCCPATH != 'Bangladesh'){ ?>
            <li data-access="update-247" class=" have_sub_menu2 menu_assign_class" module-is-hide="Update Software-YES">
                <a class="child-menu " href="<?php echo base_url(); ?>Update/index">
                    <iconify-icon icon="solar:cloud-download-broken" width="22"></iconify-icon>
                    <span><?php echo lang('update_software'); ?></span>
                </a>
            </li>
            <li data-access="uninstall-318" class=" have_sub_menu2 menu_assign_class" module-is-hide="Uninstall Licence-YES">
                <a class="child-menu " href="<?php echo base_url(); ?>Update/UninstallLicense">
                    <iconify-icon icon="solar:cloud-cross-broken" width="22"></iconify-icon>
                    <span><?php echo lang('UninstallLicense') ?></span>
                </a>
            </li>
            <?php }  ?>

            <?php if((defined('FCCPATH') && FCCPATH == 'Bangladesh')){?>
            <li data-access="uninstall-318" class=" have_sub_menu2 menu_assign_class" module-is-hide="Uninstall Licence-YES">
                <a class="child-menu " href="<?php echo base_url(); ?>Update/upgradeLicense">
                    <iconify-icon icon="solar:cloud-download-broken" width="22"></iconify-icon>
                    <span><?php echo lang('upgrade_package') ?></span>
                </a>
            </li>
            <?php }  ?>
        </ul>
    </aside>

    <div id="message-modal" class="message-modal">
        <div class="modal-content">
            <span class="close" id="closeModalBtn">&times;</span>
            <h2 class="d-flex align-items-center"><iconify-icon icon="solar:shield-warning-broken"></iconify-icon> Invoice Not Configure!</h2>
            <h4 class="pb-4">Your invoice is not configured, please configure the invoice, otherwise the sale number will insert incorrect. <a href="<?php echo base_url();?>Setting/invoiceSetting" target="_blank" class="link-color">Configure here</a>.</h4>
        </div>
    </div>

    <!-- TOP Start-->
    <script src="<?php echo base_url(); ?>assets/POS/js/jquery-3.3.1.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/POS/js/jquery-ui.js"></script>
    <script src="<?php echo base_url(); ?>assets/POS/js/jquery.slimscroll.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/POS/js/sweetalert2-new.all.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/bower_components/select2/dist/js/select2.full.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/POS/js/calculator.js"></script>
    <script src="<?php echo base_url(); ?>assets/POS/js/virtual_keyboard/jquery.keyboard.js"></script>
    <script src="<?php echo base_url(); ?>assets/POS/js/virtual_keyboard/jquery.mousewheel.js"></script>
    <script src="<?php echo base_url(); ?>assets/POS/js/virtual_keyboard/jquery.keyboard.extension-typing.js"></script>
    <script src="<?php echo base_url(); ?>assets/POS/js/virtual_keyboard/jquery.keyboard.extension-autocomplete.js"></script>
    <script src="<?php echo base_url(); ?>assets/POS/js/virtual_keyboard/jquery.keyboard.extension-caret.js"></script>
    <!-- TOP End-->
    <script src="<?php echo base_url(); ?>assets/notify/toastr.js"></script>
    <script src="<?php echo base_url(); ?>assets/POS/js/marquee.js"></script>
    <script src="<?php echo base_url(); ?>assets/POS/js/datable.js"></script>
    <script src="<?php echo base_url(); ?>assets/POS/js/jquery.cookie.js"></script>
    <script src="<?php echo base_url(); ?>assets/feather/feather.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/POS/js/howler.min.js"></script>
    <script src="<?php echo base_url(); ?>frequent_changing/newDesign/lib/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script>
    <script src="<?php echo base_url(); ?>frequent_changing/newDesign/pos/js/popper.js"></script>
    <script src="<?php echo base_url(); ?>frequent_changing/newDesign/pos/js/tippy.js"></script>
    <script src="<?php echo base_url(); ?>frequent_changing/newDesign/pos/lib/date/datepicker.js"></script>
    <script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/buttons.html5.min.js"></script>
    <script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/buttons.print.min.js"></script>
    <script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/jszip.min.js"></script>
    <script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/pdfmake.min.js"></script>
    <!-- Plugin Js End -->
    <!-- Custom JS Start -->
    <script src="<?php echo base_url(); ?>frequent_changing/js/stripe.js"></script>
    <script src="<?php echo base_url(); ?>frequent_changing/js/pos_script.js"></script>
    <script src="<?php echo base_url(); ?>frequent_changing/js/register_details.js"></script>
    <!-- Custom JS End -->

    <!-- ################ Script Start ################ -->
    <?php
    //generating object for access module show/hide
    $j = 1;
    $menu_objects = "";
    $access = $this->session->userdata('function_access');
    if(isset($access) && $access):
        foreach($access as $value){
            if($j==count($access)){
                $menu_objects .="'".$value."'";
            }else{
                $menu_objects .="'".$value."',";
            }
            $j++;
        }
    endif;
    ?>
    <script>
        window.menu_objects = [<?php echo ($menu_objects);?>];
    </script>
</body>
</html>
