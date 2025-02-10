<?php
$lng = $this->session->userdata('language');
$ln_text = isset($lng) && $lng && $lng=="bangla"?"bangla":'';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo lang('customer_due_receive'); ?>-<?php echo lang('reference_no'); ?>-<?php echo escape_output($receipt_object[0]->reference_no); ?></title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/inv_font.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/print_invoice_a4.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/inv_common.css">
</head>
<body>
    <div id="wrapper" class="m-auto border-2s-e4e5ea br-5 br-5 p-30">
        <div class="d-flex justify-content-between">
            <div>
                <h3 class="pb-7 shop-name"><?php echo escape_output($this->session->userdata('business_name')); ?></h3>
                <p class="pb-7 common-heading"><?php echo escape_output($outlet_info->outlet_name); ?></p>
                <p class="pb-7 f-w-500 color-71"><?php echo escape_output($outlet_info->address); ?></p>
                <p class="pb-7 f-w-500 color-71"><?php echo lang('email');?>: <?php echo escape_output($outlet_info->email); ?></p>
                <p class="pb-7 f-w-500 color-71"><?php echo lang('phone');?>: <?php echo escape_output($outlet_info->phone); ?></p>
                <?php if($this->session->userdata('collect_tax') == 'Yes'){ ?>
                    <p class="pb-7 f-w-900 rgb-71"><?php echo $this->session->userdata('tax_title'); ?>: <?php echo $this->session->userdata('tax_registration_no'); ?></p>
                <?php } ?>
            </div>
            <div class="d-flex align-items-center">
                <div class="m-auto">
                    <?php
                        $invoice_logo = $this->session->userdata('invoice_logo');
                        if($invoice_logo):
                    ?>
                        <img src="<?=base_url()?>uploads/site_settings/<?=escape_output($invoice_logo)?>">
                    <?php
                        endif;
                    ?>
                </div>
            </div>
        </div>
        <div class="text-center py-10">
            <h2 class="invoice-heading"><?php echo lang('customer_due_receive');?></h2>
        </div>
        <div>
            <div class="d-flex justify-content-between">
                <div>
                    <p class="pb-7 f-w-500 color-71"><span class="f-w-600"><?php echo lang('reference_no');?>:</span> <?= $receipt_object[0]->reference_no;?></p>
                    <p class="pb-7 f-w-500 color-71"><span class="f-w-600"><?php echo lang('date');?>:</span> <?= dateFormat($receipt_object[0]->date) ?></p>
                    <p class="pb-7 f-w-500 color-71"><span class="f-w-600"><?php echo lang('received_by');?>:</span> <?php echo userName($receipt_object[0]->user_id); ?></p>
                    <p class="pb-7 f-w-500 color-71"><span class="f-w-600"><?php echo lang('customer');?>:</span> <?php echo getCustomerName($receipt_object[0]->customer_id); ?></p>
                </div>
            </div>
        </div>
        
        <div class="mt-20">
            <?php
                if($receipt_object[0]->amount && $receipt_object[0]->amount!="0.00"):
            ?>
            <div class="d-flex justify-content-between border-bottom-dotted-gray border-top-dotted-gray padding-y-10">
                <h4><?php echo lang('paid_amount');?></h4>
                <h4><?php echo getAmtCustom($receipt_object[0]->amount); ?></h4>
            </div>
            <?php
                endif;
            ?>
            <?php
                if($receipt_object[0]->amount > 0):
            ?>
            <div class="d-flex justify-content-between border-bottom-dotted-gray padding-y-10">
                <h4><?php echo lang('payment_method');?></h4>
                <h4><?php echo getName("tbl_payment_methods", $receipt_object[0]->payment_method_id); ?></h4>
            </div>
            <?php
                endif;
            ?>
        </div>

        <?php
        if($receipt_object[0]->payment_method_type != ''){
        $payment_method = json_decode($receipt_object[0]->payment_method_type, TRUE);
        foreach($payment_method as $key=>$p_type){ ?>
        <div class="d-flex justify-content-between">
            <p class="f-w-600"><?php echo lang($key);?></p>
            <p><?php echo escape_output($p_type);?></p>
        </div>
        <?php }}  ?>

        <div>
            <?php
            $balance_type = "";
            $customerBalance = getCustomerDue($receipt_object[0]->customer_id);
                if($customerBalance < 0){
                    $balance_type = getAmtCustom(absCustom($customerBalance)) . " (Credit)";

                }else if ($customerBalance > 0){
                    $balance_type = getAmtCustom(absCustom($customerBalance)) . " (Debit)";
                } else {
                    $balance_type = "0";
                }
            ?>
            <div class="d-flex justify-content-between border-bottom-dotted-gray padding-y-10">
                <h4><?php echo lang('current_balance');?></h4>
                <h4><?php echo $balance_type; ?></h4>
            </div>
        </div>



        <div class="pt-20">
            <h4 class="d-block pb-10"><?php echo lang('note'); ?></h4>
            <div class="bg-240 h-120px p-15 b-1s-240">
                <p>
                    <?=$receipt_object[0]->note?>
                </p>
            </div>
        </div>


        <div class="d-flex justify-content-end mt-60">
            <div>
                <p class="color-71 d-inline b-t-1p-e4e5ea pt-10"><?php echo lang('authorized_signature');?></p>
            </div>
        </div>

        <div class="d-flex justify-content-center pt-30">
            <button onclick="window.print();" type="button" class="print-btn"><?php echo lang('print'); ?></button>
        </div>
    </div>
    <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>frequent_changing/js/onload_print.js"></script>
</body>
</html>