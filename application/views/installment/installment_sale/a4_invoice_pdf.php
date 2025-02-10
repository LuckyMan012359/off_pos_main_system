<?php 
$outletInfo = getOutletInfoById($this->session->userdata('outlet_id'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo lang('Installment_Sale_Invoice'); ?>-<?php echo escape_output($installment->reference_no); ?></title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/pdf_common.css">
</head>
<body>
    <div id="wrapper" class="m-auto b-r-5">
        <table>
            <tr>
                <td class="w-50">
                    <h3 class="pb-7 shop-name"><?php echo escape_output($this->session->userdata('business_name')); ?></h3>
                    <p class="pb-7 common-heading"><?php echo escape_output($outlet_info->outlet_name); ?></p>
                    <p class="pb-7 f-w-500 color-71"><?php echo escape_output($outlet_info->address); ?></p>
                    <p class="pb-7 f-w-500 color-71"><?php echo lang('email');?>: <?php echo escape_output($outlet_info->email); ?></p>
                    <p class="pb-7 f-w-500 color-71"><?php echo lang('phone');?>: <?php echo escape_output($outlet_info->phone); ?></p>
                    <?php if($this->session->userdata('collect_tax') == 'Yes'){ ?>
                        <p class="pb-7 f-w-900 rgb-71"><?php echo $this->session->userdata('tax_title'); ?>: <?php echo $this->session->userdata('tax_registration_no'); ?></p>
                    <?php } ?>
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

        <div class="text-center py-10">
            <h2 class="invoice-heading"><?php echo lang('Installment_Sale_Invoice');?></h2>
        </div>

        <table>
            <tr>
                <td class="w-100"><h3 class="pb-10 common-heading"><?php echo lang('Customer_Information');?></h3></td>
            </tr>
            <tr>
                <td class="w-27">
                    <?php
                        if($info->photo){
                            $customer_thumb =  base_url('uploads/customers/'.$info->photo);
                        }else{
                            $customer_thumb =  base_url('uploads/site_settings/Gallery-PNG-File.png');
                        }
                    ?>
                    <img class="img-passport mr-10" src="<?php echo escape_output($customer_thumb)?>">
                </td>
                <td class="73">
                    <p class="pb-7"><?php echo lang('name');?>: <?php echo escape_output($info->name); ?></p>
                    <p class="pb-7"><?php echo lang('phone');?>: <?php echo escape_output($info->phone); ?></p>
                    <p class="pb-7"><?php echo lang('address');?>: <?php echo escape_output($info->address); ?></p>
                    <p class="pb-7"><?php echo lang('Permanent_Address');?>: <?php echo escape_output($info->permanent_address); ?></p>
                    <p class="pb-7"><?php echo lang('Work_Address');?>: <?php echo escape_output($info->work_address); ?></p>
                </td>
            </tr>
        </table>

        <table class="mt-10">
            <tr>
                <td class="w-100"><h3 class="pb-10 common-heading"><?php echo lang('Guarantor_Information');?></h3></td>
            </tr>
            <tr>
                <td class="w-27">
                    <?php
                        if($info->g_photo){
                            $customer_thumb =  base_url('uploads/customers/'.$info->g_photo);
                        }else{
                            $customer_thumb =  base_url('uploads/site_settings/Gallery-PNG-File.png');
                        }
                    ?>
                    <img class="img-passport mr-10" src="<?php echo escape_output($customer_thumb)?>">
                </td>
                <td class="73">
                    <p class="pb-7"><?php echo lang('name');?>: <?php echo escape_output($info->g_name); ?></p>
                    <p class="pb-7"><?php echo lang('mobile');?>: <?php echo escape_output($info->g_mobile); ?></p>
                    <p class="pb-7"><?php echo lang('address');?>: <?php echo escape_output($info->address); ?></p>
                    <p class="pb-7"><?php echo lang('present_address');?>: <?php echo escape_output($info->g_pre_address); ?></p>
                    <p class="pb-7"><?php echo lang('Permanent_Address');?>: <?php echo escape_output($info->g_permanent_address); ?></p>
                    <p class="pb-7"><?php echo lang('Work_Address');?>: <?php echo escape_output($info->g_work_address); ?></p>
                </td>
            </tr>
        </table>

        
        <table class="mt-30">
            <tr>
                <td><h3 class="pb-10 common-heading"><?php echo lang('sale_information');?></h3></td>
            </tr>
            <tr>
                <td>
                    <table>
                        <tr>
                            <td>
                                <p class="pb-7"><?php echo lang('sale_date');?>: <?php echo dateFormat($installment->date); ?></p>
                                <p class="pb-7"><?php echo lang('price');?>: <?php echo getAmtCustom($installment->price); ?></p>
                                <p class="pb-7"><?php echo lang('down_payment');?>: <?php echo getAmtCustom($installment->down_payment); ?></p>
                            </td>
                            <td>
                                <p class="pb-7"><?php echo lang('ref_no');?>: <?php echo escape_output($installment->reference_no); ?></p>
                                <p class="pb-7"><?php echo lang('percentage_of_interest');?>: <?php echo escape_output($installment->percentage_of_interest); ?>%</p>
                                <p class="pb-7"><?php echo lang('no_of_installment');?>: <?php echo escape_output($installment->number_of_installment); ?></p>
                            </td>
                            <td>
                                <p class="pb-7"><?php echo lang('product');?>: <?php echo escape_output($product->name . '(' . $product->code . ')')?></p>
                                <p class="pb-7"><?php echo lang('amount_of_interest');?>: <?php echo getAmtCustom((int)$installment->price * (int)$installment->percentage_of_interest/100); ?></p>
                                <?php
                                    $remaining_due = getInstallmentRemainingDue($installment->id);
                                ?>
                                <p class="pb-7 "><?php echo lang('total_remaining_due');?>: <?php echo getAmtCustom($remaining_due); ?></p>
                            </td>
                        </tr>
                    </table>
                    
                </td>
            </tr>
        </table>

        <table class="w-100 mt-20">
            <thead class="b-r-3 bg-color-000000 color-white">
                <tr>
                    <th class="w-4 pl-5"><?php echo lang('sl');?></th>
                    <th class="w-20"><?php echo lang('installment_date');?></th>
                    <th class="w-16"><?php echo lang('paid_date');?></th>
                    <th class="w-22 text-center"><?php echo lang('installment_amount');?></th>
                    <th class="w-19 text-center"><?php echo lang('paid_amount');?></th>
                    <th class="w-19 text-right pr-5"><?php echo lang('remaining_due');?></th>
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
                    <td class="text-center"><?php echo getAmtCustom($row->amount_of_payment); ?></td>
                    <td class="text-center"><?php echo getAmtCustom($row->paid_amount); ?></td>
                    <td class="text-right pr-5"><?php echo getAmtCustom($row->amount_of_payment - $row->paid_amount); ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>


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