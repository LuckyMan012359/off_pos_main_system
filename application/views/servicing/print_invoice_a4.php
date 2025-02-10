<?php
$s_status = ((defined('FCCPATH') && FCCPATH) ? FCCPATH : '');
$lng = $this->session->userdata('language');
$ln_text = (isset($lng) && $lng === "bangla") ? "bangla" : '';
$rounding_type = $this->session->userdata('pos_total_payable_type');
$invoice_configuration = $this->session->userdata('invoice_configuration');
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
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/print_invoice_a4.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/inv_common.css">
</head>
<body>
    <div id="wrapper" class="m-auto border-2s-e4e5ea br-5 p-30">
        <div class="d-flex justify-content-between">
            <div>
                <h3 class="pb-7 shop-name">
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
                    <p class="pb-7 common-heading"><?php echo escape_output($outlet_info->outlet_name); ?></p>
                <?php } ?>
                <?php if($outlet_info->address){?>
                    <p class="pb-7 f-w-500 color-71"><?php echo escape_output($outlet_info->address); ?></p>
                <?php } ?>
                <?php if($outlet_info->email){?>
                    <p class="pb-7 f-w-500 color-71"><?php echo lang('email');?>: <?php echo escape_output($outlet_info->email); ?></p>
                <?php } ?>
                <?php if($outlet_info->phone){?>
                    <p class="pb-7 f-w-500 color-71"><?php echo lang('phone');?>: <?php echo escape_output($outlet_info->phone); ?></p>
                <?php } ?>

                <?php if($this->session->userdata('collect_tax') == 'Yes' && $inv_config->show_business_tax_number == 'Yes' && $this->session->userdata('tax_registration_no')){ ?>
                    <p class="pb-7 f-w-900 rgb-71">
                        <?php echo $inv_config->business_tax_number_label ?>: 
                        <?php echo $this->session->userdata('tax_registration_no'); ?>
                    </p>
                <?php } ?>
            </div>
            <div class="d-flex align-items-center">
                <div class="m-auto">
                    <?php
                        $invoice_logo = $this->session->userdata('invoice_logo');
                        if($s_status == 'Bangladesh' && $invoice_logo){
                    ?>
                        <img src="<?=base_url()?>uploads/site_settings/<?=($invoice_logo)?>">
                    <?php }else{
                            if($inv_logo_is_show == 'Yes' && $invoice_logo){
                    ?>
                        <img src="<?=base_url()?>uploads/site_settings/<?=($invoice_logo)?>">
                    <?php } }?>
                </div>
            </div>
        </div>



        <div class="text-center py-10">
            <h2 class="invoice-heading"><?php echo lang('invoice');?></h2>
        </div>
        <div>
            <h4 class="pb-7 common-heading"><?php echo lang('bill_to');?>: </h4>
            <div class="d-flex justify-content-between">
                <div>
                    <?php if($customer_info->name != '') {?>
                    <p class="pb-7 color-71">
                        <span class="f-w-600"><?php echo lang('name');?>:</span> <?php echo escape_output($customer_info->name) ?>
                    </p>
                    <?php } ?>
                    <?php if($customer_info->address != '') {?>
                    <p class="pb-7 color-71">
                        <span class="f-w-600"><?php echo lang('address');?>:</span> <?php echo escape_output($customer_info->address) ?>
                    </p>
                    <?php } ?>
                    <?php if($customer_info->phone != '') {?>
                    <p class="pb-7 color-71">
                        <span class="f-w-600"><?php echo lang('phone');?>:</span> <?php echo escape_output($customer_info->phone) ?>
                    </p>
                    <?php } ?>
                    <?php if ($customer_info->gst_number != '') { ?>
                    <p class="pb-7 color-71">
                        <span class="f-w-600"><?php echo lang('gst_no');?>:</span> <?php echo escape_output($customer_info->gst_number) ?>
                    </p>
                    <?php } ?>
                </div>
                <div class="text-rigth">
                    <p class="pb-7 f-w-500 color-71"> 
                        <span class="f-w-600"><?php echo lang('date');?>:</span> 
                        <?php echo dateFormat($servicing_details->added_date);?>
                    </p>
                </div>
            </div>
        </div>
        <div>
            <table class="table w-100 mt-20">
                <thead class="br-3 bg-00c53">
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
                        <th class="w-20 text-center">
                            <?php 
                            if($s_status == 'Bangladesh'){
                                echo $inv_config->servicing_charge_label;
                            }else{
                                echo $inv_config->servicing_charge_label . "<br>";
                                echo $inv_config->servicing_charge_label_arabic;
                            }?>
                        </th>
                        <th class="w-15 text-center">
                            <?php 
                            if($s_status == 'Bangladesh'){
                                echo $inv_config->paid_amount_label;
                            }else{
                                echo $inv_config->paid_amount_label . "<br>";
                                echo $inv_config->paid_amount_label_arabic;
                            }?>
                        </th>
                        <th class="w-15 text-center">
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
                        <td><?php echo 1 ?></td>
                        <td><?php echo escape_output($servicing_details->product_name);?></td>
                        <td class="text-center">
                            <?php echo getAmtCustom($ln_text=="bangla" ? banglaNumber($servicing_details->servicing_charge) : $servicing_details->servicing_charge)?>
                        </td>
                        <td class="text-center">
                            <?php echo getAmtCustom($ln_text=="bangla" ? banglaNumber($servicing_details->paid_amount) : $servicing_details->paid_amount) ?>
                        </td>
                        <td class="text-center">
                            <?php echo getAmtCustom($ln_text=="bangla" ? banglaNumber($servicing_details->due_amount) : $servicing_details->due_amount) ?>
                        </td>
                        <td class="text-right">
                            <?php if($servicing_details->status == 'Received'){?>
                                <span class="pending-status"><?php echo escape_output($servicing_details->status) ?></span>
                            <?php } else if($servicing_details->status == 'Delivered'){ ?>
                                <span class="success-status"><?php echo escape_output($servicing_details->status) ?></span>
                            <?php } ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end mt-80">
            <div>
                <p class="color-71 d-inline b-t-1p-e4e5ea pt-10"><?php echo lang('authorized_signature');?></p>
            </div>
        </div>
        <div class="mt-80">
            <p><?php echo $this->session->userdata('term_conditions'); ?></p>
        </div>
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