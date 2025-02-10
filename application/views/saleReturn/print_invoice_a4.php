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
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/local/google_font.css">
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
                        <img src="<?=base_url()?>uploads/site_settings/<?=escape_output($invoice_logo)?>">
                    <?php
                        endif;
                    ?>
                </div>
            </div>
        </div>

        
        <div class="text-center py-10">
            <h2 class="invoice-heading"><?php echo lang('sale_return_invoice');?></h2>
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
                        <span class="f-w-600"><?php echo lang('reference_no');?>:</span>
                        <?php echo escape_output($sale_return->reference_no);?>
                    </p>
                    <p class="pb-7 f-w-500 color-71"> 
                        <span class="f-w-600"><?php echo lang('date');?>:</span> 
                        <?php echo dateFormat($sale_return->date) ?>
                    </p>
                </div>

            </div>
        </div>
        <div>
            <table class="table w-100 mt-20">
                <thead class="br-3 bg-00c53">
                    <tr>
                        <th class="w-5 text-center"><?php echo lang('sn');?></th>
                        <th class="w-25 text-start"><?php echo lang('item');?> - <?php echo lang('brand');?> - <?php echo lang('code');?></th>
                        <th class="w-20 text-start"><?php echo lang('expiry_IME_Serial');?></th>
                        <th class="w-15 text-center"><?php echo lang('sale_qty_inv');?></th>
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
                            <td class="text-center"><?php echo escape_output($item->sale_quantity_amount); ?> <?php echo escape_output(getSaleUnitNameByItemId($item->item_id));?></td>
                            <td class="text-center"><?php echo escape_output($item->return_quantity_amount); ?> <?php echo escape_output(getSaleUnitNameByItemId($item->item_id));?></td>
                            <td class="text-center"><?php echo getAmtCustom($ln_text=="bangla" ? banglaNumber($item->unit_price_in_sale) : $item->unit_price_in_sale)?></td>
                            <td class="text-right">
                                <?php echo getAmtCustom($ln_text=="bangla" ? banglaNumber($item->unit_price_in_return) : $item->unit_price_in_return)?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="d-grid g-template-c-50-40 grid-gap-10 pt-20">
            <div>
                <?php if($sale_return->note){ ?>
                <div class="pt-10">
                    <h4 class="d-block pb-10"><?php echo lang('note');?></h4>
                    <div class="w-100 bg-240 h-120px p-15 b-1s-240">
                        <p>
                            <?php echo escape_output($sale_return->note);?>
                        </p>
                    </div>
                </div>
                <?php } ?>
            </div>
            <div>
                <div class="d-flex justify-content-between pt-10 mt-10 p-10 bg-00c53 br-3">
                    <p class="f-w-600 "><?php echo lang('total_return_amount');?></p>
                    <p><?php echo getAmtCustom($ln_text=="bangla" ? banglaNumber($sale_return->total_return_amount):$sale_return->total_return_amount) ?></p>
                </div>
                <div class="d-flex justify-content-between pt-10">
                    <p class="f-w-600"><?php echo lang('paid');?></p>
                    <p><?php echo getAmtCustom($ln_text=="bangla" ? banglaNumber($sale_return->paid) : $sale_return->paid)?></p>
                </div>
                <div class="d-flex justify-content-between pt-10">
                    <p class="f-w-600"><?php echo lang('due');?></p>
                    <p><?php echo getAmtCustom($ln_text=="bangla" ? banglaNumber($sale_return->due) : $sale_return->due)?></p>
                </div>
                <div class="d-flex justify-content-between pt-10">
                    <p class="f-w-600 "><?php echo lang('payment_method');?></p>
                    <p><?php echo getAllPaymentMethodById($sale_return->payment_method_id);?></p>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end mt-50">
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