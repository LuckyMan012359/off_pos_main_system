<?php 
$outletInfo = getOutletInfoById($this->session->userdata('outlet_id'));

$wl = getWhiteLabel();
$site_name = '';
$site_logo = '';
$site_favicon = '';
if($wl){
    if($wl->site_name){
        $site_name = $wl->site_name;
    }
    if($wl->site_footer){
        $site_footer = $wl->site_footer;
    }
    if($wl->site_logo){
        $site_logo = base_url()."uploads/site_settings/".$wl->site_logo;
    }
    if($wl->site_favicon){
        $site_favicon = base_url()."uploads/site_settings/".$wl->site_favicon;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo lang('Installment_Sale_Invoice'); ?>: <?php echo escape_output($installment->reference_no); ?></title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo escape_output($site_favicon); ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/inv_font.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/print_invoice_a4.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/inv_common.css">
</head>
<body>
    <div id="wrapper" class="m-auto border-2s-e4e5ea br-5 p-30">
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
                        <img src="<?php echo base_url()?>uploads/site_settings/<?php echo escape_output($invoice_logo)?>">
                    <?php
                        endif;
                    ?>
                </div>
            </div>
        </div>
        <div class="text-center py-10">
            <h2 class="invoice-heading"><?php echo lang('Installment_Sale_Invoice');?></h2>
        </div>
        <div>
            <h3 class="pb-10 common-heading"><?php echo lang('Customer_Information');?></h3>
            <div class="d-flex">
                <div>
                    <?php
                        if($info->photo){
                            $customer_thumb =  base_url('uploads/customers/'.$info->photo);
                        }else{
                            $customer_thumb =  base_url('uploads/site_settings/Gallery-PNG-File.png');
                        }
                    ?>
                    <img class="img-passport mr-10 float-left" src="<?php echo escape_output($customer_thumb)?>">
                </div>
                <div>
                    <p class="pb-7"><?php echo lang('name');?>: <?php echo escape_output($info->name); ?></p>
                    <p class="pb-7"><?php echo lang('phone');?>: <?php echo escape_output($info->phone); ?></p>
                    <p class="pb-7"><?php echo lang('address');?>: <?php echo escape_output($info->address); ?></p>
                    <p class="pb-7"><?php echo lang('Permanent_Address');?>: <?php echo escape_output($info->permanent_address); ?></p>
                    <p class="pb-7"><?php echo lang('Work_Address');?>: <?php echo escape_output($info->work_address); ?></p>
                </div>
                
            </div>
        </div>
        <div class="pt-10">
            <h3 class="pb-10 common-heading"><?php echo lang('Guarantor_Information');?></h3>
            <div class="d-flex">
            <div>
                    <?php
                        if($info->g_photo){
                            $customer_thumb =  base_url('uploads/customers/'.$info->g_photo);
                        }else{
                            $customer_thumb =  base_url('uploads/site_settings/Gallery-PNG-File.png');
                        }
                    ?>
                    <img class="img-passport mr-10 float-left" src="<?php echo escape_output($customer_thumb)?>">
                </div>
                <div>
                    <p class="pb-7"><?php echo lang('name');?>: <?php echo escape_output($info->g_name); ?></p>
                    <p class="pb-7"><?php echo lang('mobile');?>: <?php echo escape_output($info->g_mobile); ?></p>
                    <p class="pb-7"><?php echo lang('address');?>: <?php echo escape_output($info->address); ?></p>
                    <p class="pb-7"><?php echo lang('present_address');?>: <?php echo escape_output($info->g_pre_address); ?></p>
                    <p class="pb-7"><?php echo lang('Permanent_Address');?>: <?php echo escape_output($info->g_permanent_address); ?></p>
                    <p class="pb-7"><?php echo lang('Work_Address');?>: <?php echo escape_output($info->g_work_address); ?></p>
                </div>
                
            </div>
        </div>


        <div class="pt-20">
            <h3 class="pb-10 common-heading"><?php echo lang('sale_information');?></h3>
            <div class="d-grid g-template-c-32-32-32 g-gap-1">
                <p class="pb-7"><?php echo lang('sale_date');?>: <?php echo dateFormat($installment->date); ?></p>
                <p class="pb-7"><?php echo lang('ref_no');?>: <?php echo escape_output($installment->reference_no); ?></p>
                <p class="pb-7"><?php echo lang('product');?>: <?php echo escape_output($product->name . '(' . $product->code . ')')?></p>
                <p class="pb-7"><?php echo lang('price');?>: <?php echo getAmtCustom($installment->price); ?></p>
                <p class="pb-7"><?php echo lang('percentage_of_interest');?>: <?php echo escape_output($installment->percentage_of_interest); ?>%</p>
                <p class="pb-7"><?php echo lang('amount_of_interest');?>: <?php echo getAmtCustom((int)$installment->price * (int)$installment->percentage_of_interest/100); ?></p>
                <p class="pb-7"><?php echo lang('down_payment');?>: <?php echo getAmtCustom($installment->down_payment); ?></p>
                <p class="pb-7"><?php echo lang('no_of_installment');?>: <?php echo escape_output($installment->number_of_installment); ?></p>
                <?php
                    $remaining_due = getInstallmentRemainingDue($installment->id);
                ?>
                <p class="pb-7 "><?php echo lang('total_remaining_due');?>: <?php echo getAmtCustom($remaining_due); ?></p>
            </div>
        </div>

        <div>
            <table class="table w-100 mt-20">
                <thead class="br-3 bg-00c53">
                    <tr>
                        <th class="w-5 pl-5"><?php echo lang('sl');?></th>
                        <th class="w-20"><?php echo lang('installment_date');?></th>
                        <th class="w-20"><?php echo lang('paid_date');?></th>
                        <th class="w-20"><?php echo lang('installment_amount');?></th>
                        <th class="w-15"><?php echo lang('paid_amount');?></th>
                        <th class="w-20 text-right pr-5"><?php echo lang('remaining_due');?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $grandInstallment = 0;
                    $grandPaidAmount = 0;
                    foreach($installment_payments as $key=>$row){  
                        $grandInstallment += $row->amount_of_payment;
                        $grandPaidAmount += $row->paid_amount;
                    ?>
                    <tr>
                        <td><?php echo $key + 1 ?></td>
                        <td><?php echo dateFormat($row->payment_date); ?></td>
                        <td><?php echo dateFormat($row->paid_date); ?></td>
                        <td><?php echo getAmtCustom($row->amount_of_payment); ?></td>
                        <td><?php echo getAmtCustom($row->paid_amount); ?></td>
                        <td class="text-right pr-5"><?php echo getAmtCustom($row->amount_of_payment - $row->paid_amount); ?></td>
                    </tr>
                    <?php } ?>
                    
                </tbody>
                <tfoot>
                    <th></th>
                    <th></th>
                    <th class="text-center"><?php echo lang('total');?></th>
                    <th class="text-left"><?php echo getAmtCustom($grandInstallment) ?></th>
                    <th class="text-left"><?php echo getAmtCustom($grandPaidAmount) ?></th>
                    <th class="text-right"><?php echo getAmtCustom($remaining_due) ?></th>
                </tfoot>
            </table>
        </div>
        <div class="d-flex justify-content-end mt-100">
            <div>
                <p class="color-71 d-inline b-t-1p-e4e5ea pt-10"><?php echo lang('authorized_signature');?></p>
            </div>
        </div>
        <div class="d-flex justify-content-center pt-30">
            <button onclick="window.print();" type="button" class="print-btn"><?php echo lang('print');?></button>
        </div>
    </div>

    <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>frequent_changing/js/onload_print.js"></script>
</body>
</html>