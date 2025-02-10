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
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/pdf_common.css">
</head>
<body>
    <div id="wrapper" class="m-auto b-r-5 p-30">
        <table>
            <tr>
                <td class="w-50">
                    <h3 class="pb-7"><?php echo escape_output($this->session->userdata('business_name')); ?></h3>
                    <p class="pb-7 f-w-900 rgb-71"><?php echo escape_output($outlet_info->outlet_name); ?></p>
                    <p class="pb-7 f-w-900 rgb-71"><?php echo escape_output($outlet_info->address); ?></p>
                    <p class="pb-7 f-w-900 rgb-71"><?php echo lang('email');?>: <?php echo escape_output($outlet_info->email); ?></p>
                    <p class="pb-7 f-w-900 rgb-71"><?php echo lang('phone');?>: <?php echo escape_output($outlet_info->phone); ?></p>
                </td>
                <td class="w-50 text-right">
                    <?php
                        $invoice_logo = $this->session->userdata('invoice_logo');
                        if($invoice_logo):
                    ?>
                    <img src="<?php echo base_url()?>uploads/site_settings/<?php echo escape_output($invoice_logo)?>">
                    <?php
                        endif;
                    ?>
                </td>
            </tr>
        </table>
        <div class="text-center pt-10 pb-10">
            <h2 class="color-000000 pt-20 pb-20"><?php echo lang('customer_due_receive');?></h2>
        </div>
        
        <table>
            <tr>
                <td valign="top">
                    <p class="pb-7 color-71"><strong class="f-w-600"><?php echo lang('reference_no');?>:</strong> <?= $receipt_object[0]->reference_no;?></p>
                    <p class="pb-7 color-71"><span class="f-w-600"><?php echo lang('date');?>:</span> <?= dateFormat($receipt_object[0]->date) ?></p>
                    <p class="pb-7 color-71"><span class="f-w-600"><?php echo lang('received_by');?>:</span> <?php echo userName($receipt_object[0]->user_id); ?></p>
                    <p class="pb-7 color-71"><span class="f-w-600"><?php echo lang('customer');?>:</span> <?php echo getCustomerName($receipt_object[0]->customer_id); ?></p>
                </td>
            </tr>
        </table>


        

        <table class="w-100 mt-20">
            <?php
                if($receipt_object[0]->amount && $receipt_object[0]->amount!="0.00"):
            ?>
            <tr class="border-bottom-dotted-gray">
                <td class="w-50 border-bottom-dotted-gray border-top-dotted-gray text-left py-5">
                    <p class="f-w-600"><?php echo lang('paid_amount');?></p>
                </td>
                <td class="w-50 border-bottom-dotted-gray border-top-dotted-gray text-right py-5">
                    <p class="f-w-600"><?php echo getAmtCustom($receipt_object[0]->amount); ?></p>
                </td>
            </tr>
            <?php
                endif;
            ?>
            <?php
                if($receipt_object[0]->amount > 0):
            ?>
            <tr>
                <td class="border-bottom-dotted-gray text-left py-5"><?php echo lang('payment_method');?></td>
                <td class="border-bottom-dotted-gray text-right py-5"><?php echo getName("tbl_payment_methods", $receipt_object[0]->payment_method_id); ?></td>
            </tr>
            <?php
                endif;
            ?>
        </table>


        <table>
            <?php
            if($receipt_object[0]->payment_method_type != ''){
            $payment_method = json_decode($receipt_object[0]->payment_method_type, TRUE);
            foreach($payment_method as $key=>$p_type){ ?>
            <tr>
                <td><?php echo lang($key);?></td>
                <td><?php echo escape_output($p_type);?></td>
            </tr>
            <?php }} ?>
        </table>


        <div class="pt-20">
            <h4 class="d-block pb-10"><?php echo lang('note');?></h4>
            <div class="bg-F5F2F2 border-240">
                <p class="h-180 bg-F0F0F0 color-black">
                    <?php echo escape_output($receipt_object[0]->note) ?>
                </p>
            </div>
        </div>


        <table class="mt-50">
            <tr>
                <td class="w-50">
                </td>
                <td class="w-50 text-right">
                    <p class="rgb-71 d-inline border-top-e4e5ea pt-10"><?php echo lang('authorized_signature');?></p>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>