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
    <title><?php echo lang('quotation_no'); ?>:<?=($ln_text=="bangla"?banglaNumber($quotation_details->reference_no):$quotation_details->reference_no)?></title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/pdf_common.css">
</head>
<body>
    <div id="wrapper" class="m-auto b-r-5">
        <table>
            <tr>
                <td class="w-50">
                    <h3 class="pb-7"><?php echo escape_output($this->session->userdata('business_name')); ?></h3>
                    <p class="pb-7 f-w-900 rgb-71"><?php echo escape_output($outlet_info->outlet_name); ?></p>
                    <p class="pb-7 f-w-900 rgb-71"><?php echo escape_output($outlet_info->address); ?></p>
                    <p class="pb-7 f-w-900 rgb-71"><?php echo lang('email');?>: <?php echo escape_output($outlet_info->email); ?></p>
                    <p class="pb-7 f-w-900 rgb-71"><?php echo lang('phone');?>: <?php echo escape_output($outlet_info->phone); ?></p>
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
            <h2 class="invoice-heading"><?php echo lang('quotation');?></h2>
        </div>
        
        <table>
            <tr>
                <td valign="top" class="w-33">
                    <h3 class="pb-7"><?php echo lang('quotation_info');?></h3>
                    <?php if($quotation_details->reference_no != ''){ ?>
                    <p class="pb-7 f-w-500 color-71"><span class="f-w-600"><?php echo lang('reference_no');?>:</span> <?php echo escape_output($quotation_details->reference_no); ?></p>
                    <?php } ?>
                    <?php if($quotation_details->date != ''){ ?>
                    <p class="pb-7 f-w-500 color-71"><span class="f-w-600"><?php echo lang('date');?>:</span> <?php echo date($this->session->userdata('date_format'), strtotime($quotation_details->date)); ?></p>
                    <?php } ?>
                    <?php if($quotation_details->customer_id != ''){ ?>
                    <p class="pb-7 f-w-500 color-71"><span class="f-w-600"><?php echo lang('customer');?>:</span> <?php echo getCustomerName($quotation_details->customer_id); ?></p>
                    <?php } ?>
                </td>
                <td valign="top" class="w-33">
                    <h3 class="pb-7"><?php echo lang('company_info');?></h3>
                    <?php if($company_info->business_name != ''){ ?>
                    <p class="pb-7 f-w-500 color-71"><span class="f-w-600"><?php echo lang('name');?>:</span> <?php echo escape_output($company_info->business_name); ?></p>
                    <?php } ?>
                    <?php if($company_info->phone != ''){ ?>
                    <p class="pb-7 f-w-500 color-71"><span class="f-w-600"><?php echo lang('phone');?>:</span> <?php echo escape_output($company_info->phone); ?></p>
                    <?php } ?>
                    <?php if($company_info->email != ''){ ?>
                    <p class="pb-7 f-w-500 color-71"><span class="f-w-600"><?php echo lang('email');?>:</span> <?php echo escape_output($company_info->email); ?></p>
                    <?php } ?>
                    <?php if($company_info->website != ''){ ?>
                    <p class="pb-7 f-w-500 color-71"><span class="f-w-600"><?php echo lang('website');?>:</span> <?php echo escape_output($company_info->website); ?></p>
                    <?php } ?>
                </td>
                <td valign="top" class="w-33">
                    <?php $customer_info = getCustomeInfo($quotation_details->customer_id); ?>
                    <h3 class="pb-7"><?php echo lang('customer_info');?></h3>
                    <?php if($customer_info->name != ''){ ?>
                    <p class="pb-7 f-w-500 color-71"><span class="f-w-600"><?php echo lang('name');?>:</span> <?php echo escape_output($customer_info->name); ?></p>
                    <?php } ?>
                    <?php if($customer_info->phone != ''){ ?>
                    <p class="pb-7 f-w-500 color-71"><span class="f-w-600"><?php echo lang('phone');?>:</span> <?php echo escape_output($customer_info->phone); ?></p>
                    <?php } ?>
                    <?php if($customer_info->address != ''){ ?>
                    <p class="pb-7 f-w-500 color-71"><span class="f-w-600"><?php echo lang('address');?>:</span> <?php echo escape_output($customer_info->address); ?></p>
                    <?php } ?>
                </td>
            </tr>
        </table>


        <table class="w-100 mt-20">
            <thead class="b-r-3 color-white">
                <tr>
                    <th class="w-5 text-center"><?php echo lang('sn');?></th>
                    <th class="w-30 text-start"><?php echo lang('item');?>-<?php echo lang('code');?>-<?php echo lang('brand');?></th>
                    <th class="w-15 text-start"><?php echo lang('expiry_IME_Serial');?></th>
                    <th class="w-15 text-center"><?php echo lang('qty');?></th>
                    <th class="w-15 text-center"><?php echo lang('unit_price');?></th>
                    <th class="w-20 text-right pr-5"><?php echo lang('total');?></th>
                </tr>
            </thead>
            <tbody>
            <?php
                $i = 0;
                if ($quotation_items && !empty($quotation_items)) {
                    foreach ($quotation_items as $qi) {
                        $i++;
                        $p_type = '';
                        if ($qi->item_type == 'Medicine_Product'){
                            $p_type = 'Medicine';
                        }else if($qi->item_type == 'IMEI_Product'){
                            $p_type = 'IMEI';
                        }else if($qi->item_type == 'Serial_Product'){
                            $p_type = 'Serial';
                        }
                    ?>
                        <tr>
                            <td class="text-center">
                                <span><?php echo  $i ?></span>
                            </td>
                            <td class="text-start">
                                <span><?php echo getItemNameCodeBrandByItemId($qi->item_id) ?></span>
                            </td>
                            <td class="text-start">
                                <span><?php echo $p_type . ' ' . $qi->expiry_imei_serial ?></span>
                            </td>
                            <td class="text-center"><?php echo escape_output($qi->quantity_amount) . ' ' . unitName(getUnitIdByIgId($qi->item_id)) ?></td>
                            <td class="text-center"><?php echo getAmtCustom($qi->unit_price) ?></td>
                            <td class="text-right"><?php echo getAmtCustom($qi->total) ?></td>
                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>

        <table class="mt-20">
            <tr>
                <td valign="top" class="w-48">
                    <div class="pt-10">
                        <?php if($quotation_details->note){ ?>
                        <h4 class="d-block pb-10"><?php echo lang('note');?></h4>
                        <div>
                            <p class="h-180 color-black">
                                <?php echo escape_output($quotation_details->note) ; ?>
                            </p>
                        </div>
                        <?php } ?>
                    </div>
                </td>
                <td class="w-4"></td>
                <td class="w-48">
                    <table class="pt-10">
                        <tr>
                            <?php
                                $discount  = explode('%',$quotation_details->discount);
                                $discount_ac = '';
                                if(isset($discount[1]) && $discount[1]){
                                    $discount_ac = $quotation_details->discount;
                                }else{
                                    $getSign = substr($quotation_details->discount, -1);
                                    if($getSign == "%"){
                                        $discount_ac = $discount[0] . "%";
                                    }else{
                                        $discount_ac = getAmtCustom($discount[0]);
                                    }
                                }
                            ?>
                            <td class="w-50">
                                <p class="f-w-600"><?php echo lang('discount');?></p>
                            </td>
                            <td class="w-50 text-right">
                                <p><?php echo escape_output($discount_ac) ?></p>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td class="w-50">
                                <p class="f-w-600"><?php echo lang('other');?></p>
                            </td>
                            <td class="w-50 text-right">
                                <p><?php echo getAmtCustom($quotation_details->other) ?></p>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr class="bg-00c53">
                            <td class="w-50">
                                <p class="f-w-600"><?php echo lang('grand_total');?></p>
                            </td>
                            <td class="w-50 text-right">
                                <p><?php echo getAmtCustom($quotation_details->grand_total) ?></p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
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