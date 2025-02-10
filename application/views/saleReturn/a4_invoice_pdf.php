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
    <title><?php echo lang('sale_return_no_inv'); ?>:<?=($ln_text=="bangla"?banglaNumber($sale_return->reference_no):$sale_return->reference_no)?></title>
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
            <h2 class="invoice-heading"><?php echo lang('sale_return_invoice');?></h2>
        </div>


        <table>
            <tr>
                <td>
                    <p class="pb-7 common-heading"><?php echo lang('bill_to');?>: </p>
                </td>
            </tr>
            <tr>
                <td class="w-50" valign="top">
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
                </td>
                <td class="w-50 text-right" valign="top">
                    <p class="pb-7 f-w-500 color-71">
                        <span class="f-w-600"><?php echo lang('reference_no');?>:</span>
                        <?php echo escape_output($sale_return->reference_no);?>
                    </p>
                    <p class="pb-7 f-w-500 color-71"> 
                        <span class="f-w-600"><?php echo lang('date');?>:</span> 
                        <?php echo dateFormat($sale_return->date) ?>
                    </p>
                </td>
            </tr>
        </table>

        <table class="w-100 mt-20">
            <thead class="b-r-3 bg-color-000000 color-white">
                <tr>
                    <th class="w-5 text-center"><?php echo lang('sn');?></th>
                    <th class="w-25 text-start"><?php echo lang('item');?> - <?php echo lang('brand');?> - <?php echo lang('code');?></th>
                    <th class="w-20 text-start"><?php echo lang('expiry_IME_Serial');?></th>
                    <th class="w-15 text-start"><?php echo lang('sale_qty_inv');?></th>
                    <th class="w-10 text-center"><?php echo lang('return_qty_inv');?></th>
                    <th class="w-10 text-center"><?php echo lang('sale_price');?></th>
                    <th class="w-15 text-rigth pr-5"><?php echo lang('return_price');?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($item_name as $key=>$item){?>
                    <tr>
                        <td class="text-center"><?php echo $key+1; ?></td>
                        <td class="text-start">
                            <?php
                                echo getItemNameCodeBrandByItemId($item->item_id);
                            ?>
                        </td>
                        <td class="text-start"><?php echo escape_output($item->expiry_imei_serial) ?></td>
                        <td class="text-start"><?php echo escape_output($item->sale_quantity_amount); ?> <?php echo escape_output(getSaleUnitNameByItemId($item->item_id));?></td>
                        <td class="text-center"><?php echo escape_output($item->return_quantity_amount); ?> <?php echo escape_output(getSaleUnitNameByItemId($item->item_id));?></td>
                        <td class="text-center"><?php echo getAmtCustom($ln_text=="bangla" ? banglaNumber($item->unit_price_in_sale) : $item->unit_price_in_sale)?></td>
                        <td class="text-right">
                            <?php echo getAmtCustom($ln_text=="bangla" ? banglaNumber($item->unit_price_in_return) : $item->unit_price_in_return)?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <table class="mt-20">
            <tr>
                <td valign="top" class="w-48">
                    <?php if($sale_return->note != ''){ ?>
                    <div class="pt-10">
                        <h4 class="d-block pb-10"><?php echo lang('note');?></h4>
                        <div class="w-100 bg-240 h-120px p-15 b-1s-240">
                            <p>
                                <?php echo escape_output($sale_return->note);?>
                            </p>
                        </div>
                    </div>
                    <?php } ?>
                </td>
                <td class="w-4"></td>
                <td valign="top" class="w-48">
                    <table>
                        <tr class="bg-00c53">
                            <td class="w-50">
                                <p class="f-w-600"><?php echo lang('total_return_amount');?></p>
                            </td>
                            <td class="w-50 text-right">
                                <p><?php echo getAmtCustom($ln_text=="bangla" ? banglaNumber($sale_return->total_return_amount) : $sale_return->total_return_amount)?></p>
                            </td>
                        </tr>
                    </table>
                    <table class="pt-10">
                        <tr>
                            <td class="w-50">
                                <p class="f-w-600"><?php echo lang('paid');?></p>
                            </td>
                            <td class="w-50 text-right">
                                <p><?php echo getAmtCustom($ln_text=="bangla" ? banglaNumber($sale_return->paid) : $sale_return->paid)?></p>
                            </td>
                        </tr>
                    </table>
                    <table class="pt-10">
                        <tr>
                            <td class="w-50">
                                <p class="f-w-600"><?php echo lang('due');?></p>
                            </td>
                            <td class="w-50 text-right">
                                <p><?php echo getAmtCustom($ln_text=="bangla" ? banglaNumber($sale_return->due) : $sale_return->due)?></p>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td class="w-50">
                                <p class="f-w-600"><?php echo lang('payment_method');?></p>
                            </td>
                            <td class="w-50 text-right">
                                <p><?php echo getAllPaymentMethodById($sale_return->payment_method_id);?></p>
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