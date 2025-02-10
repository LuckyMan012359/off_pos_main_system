<?php
$lng = $this->session->userdata('language');
$ln_text = isset($lng) && $lng && $lng=="bangla"?"bangla":'';
$tax = '';
if($sale_object->sale_vat_objects != ''){
    $tax = json_decode($sale_object->sale_vat_objects);
}


$return_status = '';
if($purchase_return->return_status == 'draft'){
    $return_status = 'Draft';
}else if($purchase_return->return_status == 'taken_by_sup_pro_not_returned'){
    $return_status = 'Taken by supplier product not returned';

}else if($purchase_return->return_status == 'taken_by_sup_money_returned'){
    $return_status = 'Taken by supplier money returned';

}else if($purchase_return->return_status == 'taken_by_sup_pro_returned'){
    $return_status = 'Taken by supplier product returned';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo lang('purchase_return_no'); ?>:<?=($ln_text=="bangla"?banglaNumber($purchase_return->reference_no):$purchase_return->reference_no)?></title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/pdf_common.css">
</head>
<body>
    <div id="wrapper" class="m-auto b-r-5 p-30">
        <table>
            <tr>
                <td class="w-50">
                    <h3 class="pb-7 shop-name"><?php echo escape_output($this->session->userdata('business_name')); ?></h3>
                    <p class="pb-7 common-heading"><?php echo escape_output($outlet_info->outlet_name); ?></p>
                    <p class="pb-7 f-w-500 color-71"><?php echo escape_output($outlet_info->address); ?></p>
                    <p class="pb-7 f-w-500 color-71"><?php echo lang('email');?>: <?php echo escape_output($outlet_info->email); ?></p>
                    <p class="pb-7 f-w-500 color-71"><?php echo lang('phone');?>: <?php echo escape_output($outlet_info->phone); ?></p><?php if($this->session->userdata('collect_tax') == 'Yes'){ ?>
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
            <h2 class="invoice-heading"><?php echo lang('Purchase_Return_Invoice');?></h2>
        </div>


        <table>
            <tr>
                <td valign="top" class="w-33">
                    <h3 class="pb-7 ommon-heading"><?php echo lang('purchase_return_info');?></h3>
                    <?php if($purchase_return->reference_no != ''){ ?>
                    <p class="pb-7 f-w-500 color-71"><span class="f-w-600"><?php echo lang('reference_no');?>:</span> <?php echo escape_output($purchase_return->reference_no); ?></p>
                    <?php } ?>
                    <?php if($purchase_return->date != ''){ ?>
                    <p class="pb-7 f-w-500 color-71"><span class="f-w-600"><?php echo lang('date');?>:</span> <?php echo date($this->session->userdata('date_format'), strtotime($purchase_return->date)); ?></p>
                    <?php } ?>
                    <?php if($purchase_return->pur_ref_no != ''){ ?>
                    <p class="pb-7 f-w-500 color-71"><span class="f-w-600"><?php echo lang('Purchase_Ref_No');?>:</span> <?php echo escape_output($purchase_return->pur_ref_no); ?></p>
                    <?php } ?>
                    <?php if($purchase_return->purchase_date != ''){ ?>
                    <p class="pb-7 f-w-500 color-71"><span class="f-w-600"><?php echo lang('Purchase_Date');?>:</span> <?php echo escape_output($purchase_return->purchase_date); ?></p>
                    <?php } ?>
                    
                    <?php if($purchase_return->supplier_id != ''){ ?>
                    <p class="pb-7 f-w-500 color-71"><span class="f-w-600"><?php echo lang('supplier');?>:</span> <?php echo getSupplierNameById($purchase_return->supplier_id); ?></p>
                    <?php } ?>
                    <?php if($purchase_return->return_status != ''){ ?>
                    <p class="pb-7 f-w-500 color-71"><span class="f-w-600"><?php echo lang('return_status');?>:</span> <?php echo $return_status; ?></p>
                    <?php } ?>
                </td>
                <td valign="top" class="w-33">
                    <h3 class="pb-7 common-heading"><?php echo lang('company_info');?></h3>
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
                    <?php $supplier_info = getSupplierInfoById($purchase_return->supplier_id); ?>
                    <h3 class="pb-7 common-heading"><?php echo lang('Supplier_Info');?></h3>
                    <?php if($supplier_info->name != ''){ ?>
                    <p class="pb-7 f-w-500 color-71"><span class="f-w-600"><?php echo lang('name');?>:</span> <?php echo escape_output($supplier_info->name); ?></p>
                    <?php } ?>
                    <?php if($supplier_info->phone != ''){ ?>
                    <p class="pb-7 f-w-500 color-71"><span class="f-w-600"><?php echo lang('phone');?>:</span> <?php echo escape_output($supplier_info->phone); ?></p>
                    <?php } ?>
                    <?php if($supplier_info->address != ''){ ?>
                    <p class="pb-7 f-w-500 color-71"><span class="f-w-600"><?php echo lang('address');?>:</span> <?php echo escape_output($supplier_info->address); ?></p>
                    <?php } ?>
                </td>
            </tr>
        </table>

        <table class="w-100 mt-20">
            <thead class="b-r-3 bg-color-000000 color-white">
                <tr>
                    <th class="w-5 text-center"><?php echo lang('sn');?></th>
                    <th class="w-25 text-start"><?php echo lang('item');?> - <?php echo lang('brand');?> - <?php echo lang('code');?></th>
                    <th class="w-25 text-start"><?php echo lang('expiry_IME_Serial');?></th>
                    <th class="w-15 text-center"><?php echo lang('unit_price');?></th>
                    <th class="w-10 text-center"><?php echo lang('qty');?></th>
                    <th class="w-20 text-right pr-5"><?php echo lang('Total');?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $i = 0;
                    if ($purchase_return_details && !empty($purchase_return_details)) {
                        foreach ($purchase_return_details as $key=>$pi) {
                            $i++;

                            $p_type = '';
                            if ($pi->item_type == 'Medicine_Product' && getItemExpiryStatus($pi->id) == 'Yes'){
                                $p_type = 'Expiry Date:';
                            }else if($pi->item_type == 'IMEI_Product'){
                                $p_type = 'IMEI:';
                            }else if($pi->item_type == 'Serial_Product'){
                                $p_type = 'Serial:';
                            }
                            ?>

                            <tr>
                                <td class="text-center"><?php echo $key+1 ?></td>
                                <td class="text-start">
                                    <span><?php echo getItemNameCodeBrandByItemId($pi->item_id) ?></span>
                                </td>
                                <td class="text-start">
                                    <span><?php echo $p_type . ' ' . $pi->expiry_imei_serial ?></span>
                                </td>
                                <td class="text-center"><?php echo getAmtCustom($pi->unit_price) ?></td>
                                <td class="text-center"><?php echo escape_output($pi->return_quantity_amount) . ' ' .  escape_output(getSaleUnitNameByItemId($pi->item_id)) ?></td>
                                <td class="text-right"><?php echo getAmtCustom($pi->total) ?></td>
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
                        <?php if($purchase_return->note){ ?>
                        <h4 class="d-block pb-10"><?php echo lang('note');?></h4>
                        <div class="bg-F5F2F2 border-240">
                            <p class="h-180 bg-F0F0F0 color-black">
                                <?php echo escape_output($purchase_return->note) ; ?>
                            </p>
                        </div>
                        <?php } ?>
                    </div>
                </td>
            <td class="w-4"></td>
                <td class="w-48">
                    <table class="pt-10">
                        <tr class="bg-00c53">
                            <td class="w-50">
                                <p class="f-w-600 p-10"><?php echo lang('grand_total');?></p>
                            </td>
                            <td class="w-50 text-right">
                                <p class="p-10"><?php echo getAmtCustom($purchase_return->total_return_amount) ?></p>
                            </td>
                        </tr>
                    </table>

                    <table class="mt-10">
                        <tr>
                            <td class="w-50 border-top-dotted-gray border-bottom-dotted-gray py-5">
                                <p class="f-w-600"><?php echo lang('Payment_Method');?></p>
                            </td>
                            <td class="w-50 border-top-dotted-gray border-bottom-dotted-gray py-5 text-right">
                                <p class="f-w-600"><?php echo getAllPaymentMethodById($purchase_return->payment_method_id);?></p>
                            </td>
                        </tr>
                    </table>

                    <table class="mt-10 mb-10">
                    <?php
                        if($purchase_return->payment_method_type){
                        $payment_method = json_decode($purchase_return->payment_method_type, TRUE);
                        foreach($payment_method as $key=>$p_type){ ?>
                        <tr>
                            <td>
                                <p class="f-w-600"><?php echo $key;?></p>
                            </td>
                            <td>
                                <p class="f-w-600"><?php echo escape_output($p_type);?></p>
                            </td>
                        </tr>
                        <?php }}  ?>
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