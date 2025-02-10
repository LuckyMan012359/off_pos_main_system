<!DOCTYPE html>
<?php
$base_color = "#6ab04c";
$getCompanyInfo = getCompanyInfo();
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo lang('customer_panel'); ?> || <?php echo isset($getCompanyInfo->business_name) && $getCompanyInfo->business_name?$getCompanyInfo->business_name:''?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- jQuery 3.7.1 -->
        <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/AdminLTE.min.css">
        <!-- Favicon -->
        <!-- Favicon -->
        <link rel="icon" href="<?php echo base_url(); ?>uploads/site_settings/favicon.ico" type="image/x-icon">
        <!-- Sweet alert -->
        <!-- custom login page css -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/login.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/customer_display.css">
        <!-- Favicon -->
        <link rel="icon" href="<?php echo base_url(); ?>uploads/site_settings/favicon.ico" type="image/x-icon">
    </head>
    <body>
        <input type="hidden" value="<?=base_url()?>" id="base_url">
        <input type="hidden" id="op_precision" value="<?php echo escape_output($this->session->userdata('precision'))?>">
        <input type="hidden" id="op_decimals_separator" value="<?php echo escape_output($this->session->userdata('decimals_separator'))?>">
        <input type="hidden" id="op_thousands_separator" value="<?php echo escape_output($this->session->userdata('thousands_separator'))?>">
        <div class="customer_display_wrap">
            <div class="customer-display">
                <h2>
                    <?php echo lang('customer_display');?> 
                    <a href="javascript:void(0)" id="fullscreen" class="icon pull-right">
                        <i class="fa fa-arrows-alt"></i>
                    </a>
                </h2>
                <div class="customer_display_inner_wrapper">
                    <div class="customer_display_header">
                        <div class="customer-item">
                            <span><?php echo lang('item');?></span>
                        </div>
                        <div class="customer-item c-text-center">
                            <span><?php echo lang('price');?></span>
                        </div>
                        <div class="customer-item c-text-center">
                            <span><?php echo lang('quantity');?></span>
                        </div>
                        <div class="customer-item c-text-center">
                            <span><?php echo lang('discount');?></span>
                        </div>
                        <div class="customer-item c-text-right">
                            <span><?php echo lang('subtotal');?></span>
                        </div>
                    </div>
                    <div class="customer_display_body">
                        
                    </div>
                </div>

                <div class="customer_display_footer">
                    <div class="footer-calculate">
                        <div class="subtotal">
                            <span class="footer-header"><?php echo lang('subtotal');?>:</span>
                            <span class="subtotal-amt"></span>
                        </div>
                        <div class="total-item">
                            <span class="footer-header"><?php echo lang('total_item');?>:</span>
                            <span class="item-qty"></span>
                            (<span class="total-item-amt"></span>)
                        </div>
                        <div class="tax">
                            <span class="footer-header"><?php echo lang('tax');?>:</span>
                            <span class="tax-amt"></span>
                        </div>
                        <div class="charge">
                            <span class="footer-header"><?php echo lang('charge');?>:</span>
                            <span class="charge-amt"></span>
                        </div>
                        <div class="discount">
                            <span class="footer-header"><?php echo lang('discount');?></span>
                            <span class="discount-amt"></span>
                            (<span class="total-discount-amt"></span>)
                        </div>
                    </div>
                </div>
                <div class="total-payable">
                    <h2><?php echo lang('total_payable');?>: <span class="total-payable-amt"></span></h2>
                </div>
            </div>
        </div>
        <!-- custom login page js -->
        <script src="<?php echo base_url(); ?>frequent_changing/js/customer_panel.js"></script>
    </body> 
</html>
