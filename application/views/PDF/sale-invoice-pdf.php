<?php
$lng = $this->session->userdata('language');
$ln_text = isset($lng) && $lng && $lng=="bangla"?"bangla":'';
$tax = '';
$inv_prev_due = 0;
if($sale_object->sale_vat_objects != ''){
    $tax = json_decode($sale_object->sale_vat_objects);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo escape_output($sale_object->sale_no); ?></title>
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
        <div class="text-center pt-10 pb-10">
            <h2 class="color-000000 pt-20 pb-20"><?php echo lang('invoice');?></h2>
        </div>
        <table>
            <tr>
                <td class="w-50">
                    <h4 class="pb-7"><?php echo lang('bill_to');?>: </h4>
                    <p class="pb-7"><?php echo escape_output($sale_object->customer_name) ?></p>
                    <p class="pb-7 f-w-900 rgb-71"><?php echo escape_output($customer_info->address) ?></p>
                    <p class="pb-7 f-w-900 rgb-71"><?php echo lang('phone');?>: <?php echo escape_output($customer_info->phone) ?></p>
                    <?php if ($customer_info->gst_number != 'NULL') { ?>
                    <p class="pb-7 f-w-900 rgb-71"><?php echo lang('gst_no');?>: <?php echo escape_output($customer_info->gst_number) ?></p>
                    <?php } ?>
                </td>
                <td class="w-50 text-right">
                    <p class="pb-7">
                        <span class="f-w-600"><?php echo lang('invoice_no');?>:</span>
                        <?php echo escape_output($sale_object->sale_no);?>
                    </p>
                    <p class="pb-7 f-w-900 rgb-71"> 
                        <span class="f-w-600"><?php echo lang('date');?>:</span> 
                        <?php echo date($this->session->userdata('date_format'), strtotime($sale_object->sale_date ?? '')) ?>
                    </p>
                    <p class="pb-7 f-w-900 rgb-71">
                        <span class="f-w-600"><?php echo lang('Due_Date');?>:</span> 
                        <?php echo date($this->session->userdata('date_format'), strtotime($sale_object->due_date_time ?? '')) ?>
                    </p>
                </td>
            </tr>
        </table>

        <table class="w-100 mt-20">
            <thead class="b-r-3 bg-color-000000 color-white">
                <tr>
                    <th class="w-5 text-center"><?php echo lang('sn');?></th>
                    <th class="w-30 text-start"><?php echo lang('item_name');?></th>
                    <th class="w-15"><?php echo lang('unit_price');?></th>
                    <th class="w-15"><?php echo lang('qty');?></th>
                    <th class="w-15"><?php echo lang('discount');?></th>
                    <th class="w-20 text-right pr-5"><?php echo lang('total');?></th>
                </tr>
            </thead>
            <tbody>
            <?php
                    if (isset($sale_object->items)) :
                        $i = 1;
                        $totalItems = 0;
                        $unitprice_sum = 0;
                        $discount_sum = 0;
                        $qty_sum = 0;
                        $taxSum = 0;
                        $total_discount_amount = 0;
                        foreach ($sale_object->items as $row) :
                            $totalItems++;
                            $unitprice_sum = $unitprice_sum + $row->menu_unit_price;
                            $total_discount_amount += $row->discount_amount;
                            $qty_sum = $qty_sum+=$row->qty;
                        ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td>
                                <?php
                                    echo getItemNameCodeBrandByItemId($row->food_menu_id); echo escape_output($row->alternative_name) ? ' (' . $row->alternative_name . ')' : '';
                                ?>
                                <?php if($row->menu_note){ ?>
                                <div class="short_note">
                                    <?=isset($row->menu_note) && $row->menu_note? lang('note').": " .$row->menu_note.", ":''?>
                                </div>
                                <?php } ?>

                                <?php if(($row->item_type == 'IMEI_Product' || $row->item_type == 'Serial_Product' || $row->item_type == 'Medicine_Product') && $row->expiry_imei_serial){ ?>
                                    <p class="short_note"><?php echo checkItemShortType($row->item_type)  ?>: <?php echo trim($row->expiry_imei_serial); ?></p>
                                <?php } ?>
                                

                                <?php 
                                $warranty_date = '';
                                if($row->warranty_date == "day"){
                                    $warranty_date = "Day";
                                }elseif($row->warranty_date == "month"){
                                    $warranty_date = "Month";
                                }elseif($row->warranty_date == "year"){
                                    $warranty_date = "Year";
                                }
                                ?>
                                <?php if($row->warranty != 0){ ?>
                                <p class="text-muted short_note">
                                    <?php echo lang('warranty');?>: <?php echo escape_output($row->warranty) . ' ' . $row->warranty_date ?><?php echo escape_output($row->warranty) > 3 ? 's' : '' ?>
                                </p> 
                                <p class="text-muted short_note">
                                    <?php echo lang('will_expire');?> <?= date($this->session->userdata('date_format'), strtotime(dateMonthYearFinder($row->warranty, $warranty_date, $sale_object->sale_date))) ?>
                                </p>
                                <?php } ?>
                                <?php 
                                $guarantee_date = '';
                                if($row->guarantee_date == "day"){
                                    $guarantee_date = "Day";
                                }elseif($row->guarantee_date == "month"){
                                    $guarantee_date = "Month";
                                }elseif($row->guarantee_date == "year"){
                                    $guarantee_date = "Year";
                                }
                                ?>
                                <?php if($row->guarantee != 0){ ?>
                                <p class="text-muted short_note">
                                    <?php echo lang('guarantee');?>: <?php echo escape_output($row->guarantee) . ' ' . $row->guarantee_date ?><?php echo escape_output($row->guarantee) > 3 ? 's' : '' ?>
                                </p>
                                <p class="text-muted short_note">
                                    <?php echo lang('will_expire');?> <?= date($this->session->userdata('date_format'), strtotime(dateMonthYearFinder($row->guarantee, $guarantee_date, $sale_object->sale_date))) ?>
                                </p>
                                <?php } ?>
                            </td>
                            <td class="text-center">
                                <?=getAmtCustom($ln_text=="bangla"?banglaNumber($row->menu_unit_price):$row->menu_unit_price)?>
                            </td>
                            <td class="text-center">
                                <?=($ln_text=="bangla"?banglaNumber($row->qty):$row->qty)?> <?=unitName(getSaleUnitIdByIgId($row->food_menu_id))?>
                            </td>
                            <td class="text-center">
                                <?php 
                                    echo escape_output($row->menu_discount_value). ' (' . getAmtCustom($row->discount_amount) . ')';
                                ?>
                            </td>
                            <td class="text-right pr-10">
                                <?php echo getAmtCustom($ln_text=="bangla"?banglaNumber($row->menu_price_with_discount):$row->menu_price_with_discount); ?>
                            </td>
                        </tr>
                <?php   
                    endforeach;
                    endif;
                ?>
            </tbody>
            <tfoot class="bg-rgb-240 border-top-gray border-bottom-gray">
                <tr>
                    <th></th>
                    <th class="pl-10 text-right" colspan="2"><?php echo lang('total');?></th>
                    <th><?=($ln_text=="bangla"?banglaNumber($totalItems):$totalItems)?> (<?=($ln_text=="bangla"?banglaNumber($qty_sum):$qty_sum)?>)</th>
                    <th><?php echo getAmtCustom($total_discount_amount); ?></th>
                    <th class="text-right pr-10"><?php echo getAmtCustom($ln_text=="bangla"?banglaNumber($sale_object->sub_total):$sale_object->sub_total)?></th>
                </tr>
            </tfoot>
        </table>
        
        <table>
            <tr>
                <td valign="top" class="w-50">
                    <div class="pt-20">
                        <h4 class="d-block pb-10"><?php echo lang('terms_and_condition');?></h4>
                        <div class="bg-F5F2F2 border-240">
                            <p class="h-180 bg-F0F0F0 color-black">
                            </p>
                        </div>
                    </div>
                </td>
                <td class="w-50">
                    <?php
                        if($sale_object->previous_due > 0){
                            $inv_prev_due = absCustom($sale_object->previous_due);
                    ?>
                        <table>
                            <tr>
                                <td class="w-50">
                                    <p class="f-w-600"><?php echo lang('previous_balance');?></p>
                                </td>
                                <td class="w-50 text-right">
                                    <p><?php echo getAmtCustom($ln_text=="bangla"?banglaNumber($inv_prev_due):  $inv_prev_due)?> (Debit)</p>
                                </td>
                            </tr>
                        </table>
                    <?php } else if ($sale_object->previous_due < 0){ 
                        $inv_prev_due = absCustom($sale_object->previous_due);
                        ?>
                        <table>
                            <tr>
                                <td class="w-50">
                                    <p class="f-w-600"><?php echo lang('previous_balance');?></p>
                                </td>
                                <td class="w-50 text-right">
                                    <p><?php echo getAmtCustom($ln_text=="bangla"?banglaNumber($inv_prev_due):  $inv_prev_due)?> (Credit)</p>
                                </td>
                            </tr>
                        </table>
                    <?php } else{ ?>
                        <table>
                            <tr>
                                <td class="w-50">
                                    <p class="f-w-600"><?php echo lang('previous_balance');?></p>
                                </td>
                                <td class="w-50 text-right">
                                    <p><?php echo getAmtCustom($ln_text=="bangla"?banglaNumber($sale_object->previous_due):  $sale_object->previous_due)?></p>
                                </td>
                            </tr>
                        </table>
                    <?php } ?>


                    <?php 
                    if($sale_object->sub_total){
                    ?>
                    <table>
                        <tr>
                            <td class="w-50">
                                <p class="f-w-600"><?php echo lang('subtotal');?></p>
                            </td>
                            <td class="w-50 text-right">
                                <p><?php echo getAmtCustom($ln_text=="bangla"?banglaNumber($sale_object->sub_total):$sale_object->sub_total)?></p>
                            </td>
                        </tr>
                    </table>
                    <?php 
                        }
                    ?>

                    <?php if($tax) {
                        $i = 0;
                        foreach($tax as $t){ 
                            if($t->tax_field_amount > 0){  
                                $i++;
                                $taxSum += $t->tax_field_amount;
                    ?>
                    <table>
                        <tr>
                            <td class="w-50 border-bottom-dotted-gray <?php echo escape_output($i) == 1 ? 'border-top-dotted-gray mt-10' : '' ?>">
                                <p class="f-w-600"><?php echo escape_output($t->tax_field_type) ?></p>
                            </td>
                            <td class="w-50 text-right border-bottom-dotted-gray <?php echo escape_output($i) == 1 ? 'border-top-dotted-gray mt-10' : '' ?>">
                                <p><?php echo getAmtCustom($t->tax_field_amount);?></p>
                            </td>
                        </tr>
                    </table>
                    <?php } } } ?>


                    <?php 
                        if($sale_object->delivery_charge){
                    ?>
                    <table>
                        <tr>
                            <td class="w-50">
                                <p class="f-w-600"><?php echo lang('charge');?> (<?php echo escape_output($sale_object->charge_type) == 'delivery' ? 'Delivery' : 'Service'; ?>)</p>
                            </td>
                            <td class="w-50 text-right">
                                <p><?php echo getAmtCustom($ln_text=="bangla" ? banglaNumber($sale_object->delivery_charge) : $sale_object->delivery_charge)?></p>
                            </td>
                        </tr>
                    </table>
                    <?php } ?>


                    <?php 
                        if($sale_object->sub_total_discount_amount){
                    ?>
                    <table>
                        <tr>
                            <td class="w-50">
                                <p class="f-w-600"><?php echo lang('discount');?></p>
                            </td>
                            <td class="w-50 text-right">
                                <p><?php echo getAmtCustom($sale_object->sub_total_discount_amount);?></p>
                            </td>
                        </tr>
                    </table>
                    <?php } ?>


                    <?php 
                        if($sale_object->total_payable){
                    ?>
                    <table>
                        <tr>
                            <td class="w-50">
                                <p class="f-w-600"><?php echo lang('total_payable');?></p>
                                <?php 
                                    $totalpayable = ($sale_object->total_payable);
                                ?>
                            </td>
                            <td class="w-50 text-right">
                                <p><?php echo getAmtCustom($ln_text=="bangla"?banglaNumber($totalpayable):$totalpayable) ?></p>
                            </td>
                        </tr>
                    </table>
                    <?php } ?>


                    <?php 
                        if($sale_object->paid_amount){
                    ?>
                    <table>
                        <tr>
                            <td class="w-50">
                                <p class="f-w-600"><?php echo lang('paid_amount');?></p>
                            </td>
                            <td class="w-50 text-right">
                                <p><?php echo getAmtCustom($ln_text=="bangla"?banglaNumber($sale_object->paid_amount):$sale_object->paid_amount) ?></p>
                            </td>
                        </tr>
                    </table>
                    <?php 
                        }
                    ?>

                    <?php
                        if($sale_object->due_amount > 0) {
                    ?>
                    <table>
                        <tr>
                            <td class="w-50">
                                <p class="f-w-600"><?php echo lang('due_amount');?></p>
                            </td>
                            <td class="w-50 text-right">
                                <p><?php echo getAmtCustom($ln_text=="bangla"?banglaNumber($sale_object->due_amount):$sale_object->due_amount) ?></p>
                            </td>
                        </tr>
                    </table>
                    <?php } else { ?>
                        <table>
                            <tr>
                                <td class="w-50">
                                    <p class="f-w-600"><?php echo lang('due_amount');?></p>
                                </td>
                                <td class="w-50 text-right">
                                    <p><?php echo getAmtCustom($ln_text=="bangla"?banglaNumber(0):0) ?></p>
                                </td>
                            </tr>
                        </table>
                    <?php } ?>

                    <?php
                    if($sale_object->due_amount < 0) {  
                        $due_reveive  = 0;
                        $advance_receive = 0;
                        if(absCustom($sale_object->due_amount) <= $inv_prev_due){
                            $due_reveive  = $sale_object->due_amount;
                        }
                        if(absCustom($sale_object->due_amount) > $inv_prev_due){
                            $due_reveive = $inv_prev_due;
                            $advance_receive = absCustom($sale_object->due_amount) - $inv_prev_due;
                        } ?>
                        <table>
                            <tr>
                                <td class="w-50">
                                    <p class="f-w-600"><?php echo lang('due_receive');?></p>
                                </td>
                                <td class="w-50 text-right">
                                    <p><?php echo getAmtCustom($ln_text=="bangla"?banglaNumber(absCustom($due_reveive) ? absCustom($due_reveive) : 0 ): (absCustom($due_reveive) ? absCustom($due_reveive) : 0)); ?></p>
                                </td>
                            </tr>
                        </table>
                        <table>
                            <tr>
                                <td class="w-50">
                                    <p class="f-w-600"><?php echo lang('advance_receive');?></p>
                                </td>
                                <td class="w-50 text-right">
                                    <p><?php echo getAmtCustom($ln_text=="bangla"?banglaNumber(absCustom($advance_receive) ? absCustom($advance_receive) : 0 ): (absCustom($advance_receive) ? absCustom($advance_receive) : 0)); ?></p>
                                </td>
                            </tr>
                        </table>
                    <?php } ?>


                    <table class="mt-10 mb-10">
                        <tr>
                            <td class="w-100 border-top-dotted-gray border-bottom-dotted-gray">
                                <p class="f-w-600"><?php echo lang('payment_method');?> :</p>
                            </td>
                        </tr>
                    </table>
                    <?php
                        $outlet_id = $this->session->userdata('outlet_id');
                        $salePaymentDetails = salePaymentDetails($sale_object->id,$outlet_id);
                        if(isset($salePaymentDetails) && $salePaymentDetails):
                        foreach($salePaymentDetails as $p_name):
                            $payment_details = explode(",",$p_name->payment_details);
                    ?>
                    <table>
                        <tr>
                            <td class="w-50">
                                <p class="f-w-600">
                                    <?php echo escape_output($p_name->payment_name); ?> 
                                    <?php 
                                    if($p_name->payment_details != ''){
                                        foreach($payment_details as $key=>$details){
                                        ?> 
                                        <span class="font-10"><?php echo $details != '' ? ($key === array_key_last($payment_details) ? $details : $details . ',' ) : '';?>
                                        </span>
                                    <?php } }?>
                                </p>
                            </td>
                            <td class="w-50 text-right">
                                <p><?php echo getAmtCustom($p_name->amount); ?></p>
                            </td>
                        </tr>
                    </table>
                    <?php
                        endforeach;
                        endif;
                    ?>
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