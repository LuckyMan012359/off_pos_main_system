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
    <title><?php echo lang('purchase_no'); ?>:<?=($ln_text=="bangla"?banglaNumber($purchase_details->reference_no):$purchase_details->reference_no)?></title>
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
            <h2 class="invoice-heading"><?php echo lang('Purchase_Invoice');?></h2>
        </div>

        <div class="d-grid g-template-c-33-33-32 g-gap-1">
            <div class="d-flex justify-content-start">
                <div>
                    <h3 class="pb-7 common-heading"><?php echo lang('purchase_info');?></h3>
                    <?php if($purchase_details->reference_no != ''){ ?>
                    <p class="pb-7 f-w-500 color-71"><span class="f-w-600"><?php echo lang('reference_no');?>:</span> <?php echo escape_output($purchase_details->reference_no); ?></p>
                    <?php } ?>
                    <?php if($purchase_details->date != ''){ ?>
                    <p class="pb-7 f-w-500 color-71"><span class="f-w-600"><?php echo lang('date');?>:</span> <?php echo date($this->session->userdata('date_format'), strtotime($purchase_details->date)); ?></p>
                    <?php } ?>
                    <?php if($purchase_details->supplier_id != ''){ ?>
                    <p class="pb-7 f-w-500 color-71"><span class="f-w-600"><?php echo lang('supplier');?>:</span> <?php echo getSupplierNameById($purchase_details->supplier_id); ?></p>
                    <?php } ?>
                    <?php if($purchase_details->invoice_no != ''){ ?>
                    <p class="pb-7 f-w-500 color-71"><span class="f-w-600"><?php echo lang('supplier_invoice_no');?>:</span> <?php echo escape_output($purchase_details->invoice_no) ?></p>
                    <?php } ?>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <div>
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
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <div>
                    <?php $supplier_info = getSupplierInfoById($purchase_details->supplier_id); ?>
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
                </div>
            </div>
        </div>

        <div>
            <table class="table w-100 mt-20">
                <thead class="br-3 bg-00c53">
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
                if ($purchase_items && !empty($purchase_items)) {
                    foreach ($purchase_items as $pi) {
                        $i++;
                        $p_type = '';
                        if ($pi->item_type == 'Medicine_Product' && $pi->expiry_date_maintain == 'Yes'){
                            $p_type = 'Expiry Date:';
                        }else if($pi->item_type == 'IMEI_Product'){
                            $p_type = 'IMEI:';
                        }else if($pi->item_type == 'Serial_Product'){
                            $p_type = 'Serial:';
                        }
                    ?>
                        <tr>
                            <td class="text-center">
                                <span><?php echo  $i ?></span>
                            </td>
                            <td class="text-start">
                                <span><?php echo getItemNameCodeBrandByItemId($pi->item_id) ?></span>
                            </td>
                            <td class="text-start">
                                <span><?php echo $p_type . ' ' . $pi->expiry_imei_serial ?></span>
                            </td>
                            <td class="text-center"><?php echo escape_output($pi->quantity_amount) . ' ' . unitName(getUnitIdByIgId($pi->item_id)) ?></td>
                            <td class="text-center"><?php echo getAmtCustom($pi->unit_price) ?></td>
                            <td class="text-right"><?php echo getAmtCustom($pi->total) ?></td>
                        </tr>
                <?php
                    }
                }
                ?>
                </tbody>
            </table>
        </div>

        <div class="d-grid g-template-c-50-40 grid-gap-10 pt-20">
            <div>
                <div class="pt-10">
                    <?php if($purchase_details->note){ ?>
                    <h4 class="d-block pb-10"><?php echo lang('note');?></h4>
                    <div class="w-100 bg-240 m-h-120px-m-h-220px p-15 b-1s-240">
                        <p>
                            <?php echo escape_output($purchase_details->note) ; ?>
                        </p>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div>
                <div class="d-flex justify-content-between pt-10">
                    <?php
                        $discount  = explode('%',$purchase_details->discount);
                        $discount_ac = '';
                        if(isset($discount[1]) && $discount[1]){
                            $discount_ac = $purchase_details->discount;
                        }else{
                            $getSign = substr($purchase_details->discount, -1);
                            if($getSign == "%"){
                                $discount_ac = $discount[0] . "%";
                            }else{
                                $discount_ac = getAmtCustom($discount[0]);
                            }
                        }
                    ?>
                    <p class="f-w-600"><?php echo lang('discount');?></p>
                    <p><?php echo escape_output($discount_ac) ?></p>
                </div>
                
                <div class="d-flex justify-content-between pt-10">
                    <p class="f-w-600"><?php echo lang('other');?></p>
                    <p><?php echo getAmtCustom($purchase_details->other) ?></p>
                </div>
                <div class="d-flex justify-content-between pt-10 mt-10 p-10 bg-00c53 br-3">
                    <p class="f-w-600"><?php echo lang('grand_total');?></p>
                    <p><?php echo getAmtCustom($purchase_details->grand_total) ?></p>
                </div>
                <div class="d-flex justify-content-between pt-10">
                    <p class="f-w-600"><?php echo lang('paid_amount');?></p>
                    <p><?php echo getAmtCustom($purchase_details->paid) ?></p>
                </div>
                <div class="d-flex justify-content-between pt-10">
                    <p class="f-w-600"><?php echo lang('due_amount');?></p>
                    <p><?php echo getAmtCustom($purchase_details->due_amount) ; ?></p>
                </div>
                <div class="pt-20">
                    <p class="top_bottom_border_dotted f-w-600"><?php echo lang('Payment_Method'); ?></p>
                    <?php foreach ($multi_pay_method as $pay_method){ ?>
                    <div class="d-flex justify-content-between">
                        <p><?php echo escape_output($pay_method->payment_method_name); ?></p>
                        <p><?php echo getAmtCustom($pay_method->amount); ?></p>
                    </div>
                    <?php } ?>
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