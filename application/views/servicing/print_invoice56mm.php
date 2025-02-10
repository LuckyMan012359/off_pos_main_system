<?php
$s_status = ((defined('FCCPATH') && FCCPATH) ? FCCPATH : '');
$lng = $this->session->userdata('language');
$ln_text = (isset($lng) && $lng === "bangla") ? "bangla" : '';
$rounding_type = $this->session->userdata('pos_total_payable_type');
$invoice_configuration = $this->session->userdata('invoice_configuration');
$inv_logo_is_show = $this->session->userdata('inv_logo_is_show');
$inv_config = json_decode($invoice_configuration);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo lang('servicing_invoice_of') . escape_output($customer_info->name) . '(' . $customer_info->phone . ')' ?></title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/local/google_font.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/print_invoice56mm.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/inv_common.css">
</head>
<body>
    <div id="wrapper" class="m-auto border-2s-e4e5ea br-5 p-15">
        
        <div class="d-flex justify-content-center">
            <?php
                $invoice_logo = $this->session->userdata('invoice_logo');
                if($s_status == 'Bangladesh' && $invoice_logo){
            ?>
                <img src="<?=base_url()?>uploads/site_settings/<?=escape_output($invoice_logo)?>">
            <?php }else{
                    if($inv_logo_is_show == 'Yes' && $invoice_logo){
            ?>
                <img src="<?=base_url()?>uploads/site_settings/<?=escape_output($invoice_logo)?>">
            <?php } }?>
        </div>
        <div class="text-center">
            <h3 class="font-size-20">
                <?php 
                if($s_status == 'Bangladesh'){
                    echo $this->session->userdata('business_name');
                }else{
                    if($inv_config->show_business_name == 'Yes'){
                        echo $this->session->userdata('business_name') . "<br>";
                        echo $inv_config->business_name_arabic;
                    }
                }?>
            </h3>

            <?php if($outlet_info->outlet_name){?>
                <p class="pb-7 font-size-15"><?php echo escape_output($outlet_info->outlet_name); ?></p>
            <?php } ?>
            <?php if($outlet_info->address){?>
                <p class="f-w-500 color-71 font-size-13"><?php echo escape_output($outlet_info->address); ?></p>
            <?php } ?>
            <?php if($outlet_info->email){?>
                <p class="f-w-500 color-71 font-size-13"><?php echo lang('email');?>: <?php echo escape_output($outlet_info->email); ?></p>
            <?php } ?>
            <?php if($outlet_info->phone){?>
                <p class="f-w-500 color-71 font-size-13"><?php echo lang('phone');?>: <?php echo escape_output($outlet_info->phone); ?></p>
            <?php } ?>
            <?php if($this->session->userdata('collect_tax') == 'Yes' && $inv_config->show_business_tax_number == 'Yes' && $this->session->userdata('tax_registration_no')){ ?>
                <p class="pb-7 f-w-900 rgb-71">
                    <?php echo $inv_config->business_tax_number_label ?>: 
                    <?php echo $this->session->userdata('tax_registration_no'); ?>
                </p>
            <?php } ?>
        </div>

        <div class="text-center py-10">
            <h3 class="font-size-20">
                <?php 
                if($s_status == 'Bangladesh'){
                    echo $inv_config->invoice_heading;
                }else{
                    echo $inv_config->invoice_heading . "<br>";
                    echo $inv_config->invoice_heading_arabic;
                }?>
            </h3>
        </div>

        <?php if($servicing_details->servicing_charge == $servicing_details->paid_amount) { ?>
        <div class="text-center">
            <h2 class="font-size-20 text-underline">
                <?php 
                if($s_status == 'Bangladesh'){
                    echo $inv_config->invoice_heading_paid;
                }else{
                    echo $inv_config->invoice_heading_paid;
                }?>
            </h2>
        </div>
        <?php } else { ?>
        <div class="text-center">
            <h2 class="font-size-20 text-underline">
                <?php 
                if($s_status == 'Bangladesh'){
                    echo $inv_config->invoice_heading_due;
                }else{
                    echo $inv_config->invoice_heading_due;
                }?>
            </h2>
        </div>
        <?php } ?>


        <div>
            <div class="d-flex justify-content-between">
                <div>
                    <?php if($customer_info->name != ''){ ?>
                    <p class="f-w-500 color-71 font-size-13">
                        <span class="f-w-600"><?php echo lang('bill_to');?>:</span> <?php echo escape_output($customer_info->name) ?>
                    </p>
                    <?php } ?>
                    <?php if($inv_config->show_customer_address == 'Yes' && $customer_info->address != ''){?>
                        <p class="f-w-500 color-71 font-size-13">
                            <span class="f-w-600"><?php echo lang('address');?>:</span> <?php echo escape_output($customer_info->address) ?>
                        </p>
                    <?php } ?>
                    <?php if($inv_config->show_customer_phone_number == 'Yes' && $customer_info->phone != ''){?>
                        <p class="f-w-500 color-71 font-size-13">
                            <span class="f-w-600"><?php echo lang('phone');?>:</span> <?php echo escape_output($customer_info->phone) ?>
                        </p>
                    <?php } ?>
                    <?php if($inv_config->show_customer_email == 'Yes' && $customer_info->email != ''){?>
                        <p class="f-w-500 color-71 font-size-13">
                            <span class="f-w-600"><?php echo lang('email');?>:</span> <?php echo escape_output($customer_info->email) ?>
                        </p>
                    <?php } ?>
                    <?php if ($customer_info->gst_number && $s_status != 'Bangladesh') { ?>
                    <p class="f-w-500 color-71 font-size-13">
                        <span class="f-w-600"><?php echo $inv_config->customer_tax_number_label;?>:</span> <?php echo escape_output($customer_info->gst_number) ?>
                    </p>
                    <?php } ?>
                </div>
                
                <div class="text-rigth">
                    <p class="f-w-500 color-71 font-size-13"> 
                        <span class="f-w-600">
                            <?php 
                            if($s_status == 'Bangladesh'){
                                echo $inv_config->invoice_date_label . ': ';
                            }else{
                                if($inv_config->invoice_date_label_arabic){
                                    echo $inv_config->invoice_date_label;
                                    echo "<br>" . $inv_config->invoice_date_label_arabic . ': ';
                                }else{
                                    echo $inv_config->invoice_date_label . ': ';
                                }
                            }?>
                        </span> 
                        <?php echo dateFormat($servicing_details->added_date) ?>
                    </p>
                </div>
            </div>
        </div>



        
        <div class="tharmal_table">
            <table class="table w-100 mt-20">
                <thead class="br-3">
                    <tr>
                        <th class="w-5 ps-5">
                            <?php 
                            if($s_status == 'Bangladesh'){
                                echo $inv_config->invoice_no_label;
                            }else{
                                echo $inv_config->invoice_no_label . "<br>";
                                echo $inv_config->invoice_no_label_arabic;
                            }?>
                        </th>
                        <th class="w-30">
                            <?php 
                            if($s_status == 'Bangladesh'){
                                echo $inv_config->item_label;
                            }else{
                                echo $inv_config->item_label . "<br>";
                                echo $inv_config->item_label_arabic;
                            }?>
                        </th>
                        <th class="w-20">
                            <?php 
                            if($s_status == 'Bangladesh'){
                                echo $inv_config->servicing_charge_label;
                            }else{
                                echo $inv_config->servicing_charge_label . "<br>";
                                echo $inv_config->servicing_charge_label_arabic;
                            }?>
                        </th>
                        <th class="w-15">
                            <?php 
                            if($s_status == 'Bangladesh'){
                                echo $inv_config->paid_amount_label;
                            }else{
                                echo $inv_config->paid_amount_label . "<br>";
                                echo $inv_config->paid_amount_label_arabic;
                            }?>
                        </th>
                        <th class="w-15">
                            <?php 
                            if($s_status == 'Bangladesh'){
                                echo $inv_config->due_amount_label;
                            }else{
                                echo $inv_config->due_amount_label . "<br>";
                                echo $inv_config->due_amount_label_arabic;
                            }?>
                        </th>
                        <th class="w-15 text-right pr-10"><?php echo lang('status');?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo 1; ?></td>
                        <td>
                        <?php
                            echo escape_output($servicing_details->product_name);
                        ?>
                        </td>
                        <td><?php echo getAmtCustom($ln_text=="bangla"?banglaNumber($servicing_details->servicing_charge) : $servicing_details->servicing_charge)?></td>

                        <td><?php echo getAmtCustom($ln_text=="bangla"?banglaNumber($servicing_details->paid_amount) : $servicing_details->paid_amount)?></td>

                        <td>
                            <?php echo getAmtCustom($ln_text=="bangla"?banglaNumber($servicing_details->due_amount) : $servicing_details->due_amount)?>
                        </td>
                        <td class="text-right">
                            <div class="mt-5">
                            <?php if($servicing_details->status == 'Received'){?>
                                <span class="pending-status"><?php echo escape_output($servicing_details->status) ?></span>
                            <?php } else if($servicing_details->status == 'Delivered'){ ?>
                                <span class="success-status"><?php echo escape_output($servicing_details->status) ?></span>
                            <?php } ?>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>


        <div class="mt-30">
            <p><?php echo $this->session->userdata('term_conditions'); ?></p>
        </div>
        <?php
         if(escape_output($this->session->userdata('inv_qr_code_status')) == 'Enable'){ ?>
        <div class="d-flex justify-content-center pt-30">
            <div>
                <img width="80" height="80" src="<?php echo base_url()?>uploads/qr_code/<?php echo escape_output('servicing-' . $servicing_details->id)?>.png">
            </div>
        </div>
        <?php } ?>
        <div class="d-flex justify-content-center pt-30">
            <p class="font-size-15"><?php echo $this->session->userdata('invoice_footer'); ?></p>
        </div>
        <div class="d-flex justify-content-center pt-30">
            <button onclick="window.print();" type="button" class="print-btn"><?php echo lang('print');?></button>
        </div>
    </div>
    <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>frequent_changing/js/onload_print.js"></script>
</body>
</html>