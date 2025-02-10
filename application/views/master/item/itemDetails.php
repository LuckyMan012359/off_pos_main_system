<?php 
    $warranty_date = '';
    if($item_details->warranty_date == "day"){
        $warranty_date = "Day";
    }elseif($item_details->warranty_date == "month"){
        $warranty_date = "Month";
    }elseif($item_details->warranty_date == "year"){
        $warranty_date = "Year";
    }
 
    $guarantee_date = '';
    if($item_details->guarantee_date == "day"){
        $guarantee_date = "Day";
    }elseif($item_details->guarantee_date == "month"){
        $guarantee_date = "Month";
    }elseif($item_details->guarantee_date == "year"){
        $guarantee_date = "Year";
    }
?>


<div class="main-content-wrapper">
    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('item_details'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('item'), 'secondSection'=> lang('item_details')])?>
        </div>
    </section>


    <div class="box-wrapper">
        <div class="table-box">
            <div class="box-body" id="printableArea">
                <div class="row" id="item_details2">
                    <div class="col-xl-6 col-lg-6 col-md-10 col-sm-12">
                        <table class="table view_details_table">
                            <tr>
                                <td colspan="2">
                                    <h4 class="m-0"><?php echo lang('details');?> <?php echo lang('of');?> <?php echo escape_output($item_details->name);?></h4>
                                </td>
                            </tr>
                            <tr>
                                <td class="view_detail_border_right"><b><?php echo lang('product_name')?>:</b> <?= escape_output($item_details->name)?></td>
                                <td class="view_detail_border_right"> 
                                    <?php if($item_details->photo != ''){?>
                                        <img src="<?php echo base_url();?>/uploads/items/<?php echo escape_output($item_details->photo);?>" alt="" height="150" width="150">
                                    <?php } else { ?>
                                        <img src="<?php echo base_url();?>/uploads/site_settings/image_blank.png" alt="" height="150" width="150">
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="view_detail_border_right"><strong><?php echo lang('type');?></strong></td>
                                <td class="view_detail_border_right"> <?php echo escape_output(checkSingleItemType($item_details->type)); ?></td>
                            </tr>
                            
                            <?php if($item_details->type == 'Variation_Product') { ?>
                            <tr>
                                <td class="view_detail_border_right"><strong><?php echo lang('item_variation');?></strong></td>
                                <td class="view_detail_border_right">
                                    <?php 
                                    $getVariatins = getRelatedVariation($item_details->id);
                                    if ($getVariatins){
                                    ?>
                                    <table class="mb-4 mt-0">
                                        <tr>
                                            <th><?php echo lang('name');?>(<?php echo lang('code');?>)</th>
                                            <th><?php echo lang('purchase_price');?></th>
                                            <th><?php echo lang('sale_price');?></th>
                                        </tr>
                                        <?php foreach ($getVariatins as $variation):?>
                                        <tr>
                                            <td class="view_detail_border_right"><?= $variation->name; ?>(<?= $variation->code; ?>)</td>
                                            <td class="view_detail_border_right"><?= getAmtCustom($variation->purchase_price); ?></td>
                                            <td class="view_detail_border_right"><?= getAmtCustom($variation->sale_price); ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </table>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php } ?>
                            <tr>
                                <td class="view_detail_border_right"><strong><?php echo lang('code');?></strong></td>
                                <td class="view_detail_border_right"> <?= escape_output($item_details->code)?></td>
                            </tr>
                            <tr>
                                <td class="view_detail_border_right"><strong><?php echo lang('category');?></strong></td>
                                <td class="view_detail_border_right"> <?= (getCategoryName($item_details->category_id))?></td>
                            </tr>
                            <?php
                            $brand_name = getBrand($item_details->brand_id);
                            if($brand_name){
                            ?>
                            <tr>
                                <td class="view_detail_border_right"><strong><?php echo lang('brand');?></strong></td>
                                <td class="view_detail_border_right"> <?= escape_output($brand_name)?></td>
                            </tr>
                            <?php } ?>
                            <?php
                            $supplier_name = getSupplierName($item_details->supplier_id);
                            if($supplier_name){
                            ?>
                            <tr>
                                <td class="view_detail_border_right"><strong><?php echo lang('supplier');?></strong></td>
                                <td class="view_detail_border_right"> <?= escape_output($supplier_name)?></td>
                            </tr>
                            <?php } ?>
                            <tr>
                                <td class="view_detail_border_right"><strong><?php echo lang('sale_price');?></strong></td>
                                <td class="view_detail_border_right"> <?= (getAmtCustom($item_details->sale_price))?></td>
                            </tr>
                            <tr>
                                <td class="view_detail_border_right"><strong><?php echo lang('purchase_price');?></strong></td>
                                <td class="view_detail_border_right"> <?= (getAmtCustom($item_details->purchase_price))?></td>
                            </tr>
                            <tr>
                                <td class="view_detail_border_right"><strong><?php echo lang('profit_margin');?></strong></td>
                                <td class="view_detail_border_right"> <?= (getAmtCustom($item_details->profit_margin))?></td>
                            </tr>
                            <tr>
                                <td class="view_detail_border_right"><strong><?php echo lang('whole_sale_price');?></strong></td>
                                <td class="view_detail_border_right"> <?= (getAmtCustom($item_details->whole_sale_price))?></td>
                            </tr>
                            <?php if($item_details->type != 'Service_Product'){?>
                            <tr>
                                <td class="view_detail_border_right"><strong><?php echo lang('opening_stock');?></strong></td>
                                <td class="view_detail_border_right"> 
                                    <?php 
                                        $string_match = '';
                                        $outlet_stock = 0;
                                        $total_stock = 0;
                                        foreach($item_opening_stock as $op_stock){
                                            $total_stock +=1;
                                            if($item_details->type == 'IMEI_Product' || $item_details->type == 'Serial_Product'){
                                                if($op_stock->outlet_name != $string_match){
                                                    $string_match = $op_stock->outlet_name;
                                                    echo "<b>" . escape_output($string_match) . "</b>";
                                                }
                                            }
                                        ?>
                                        <div class="d-flex">
                                            <?php if($item_details->type == 'General_Product' || $item_details->type == 'Installment_Product' || $item_details->type == 'Medicine_Product'){ ?>
                                            <b><span class="pe-1"><?php echo escape_output($op_stock->outlet_name); ?>:</span></b>
                                            <?php } ?>
                                            <span>
                                                <?php if($item_details->unit_type == 1){ ?>
                                                    <?php 
                                                        if($item_details->type == 'IMEI_Product' || $item_details->type == 'Serial_Product'){
                                                            echo ' - ';
                                                        }
                                                    ?>
                                                    <?php
                                                        echo escape_output((int)$op_stock->stock_quantity); 
                                                    ?> 
                                                    <?= escape_output(unitName($item_details->sale_unit_id))?> 

                                                    <?php if($item_details->type == 'IMEI_Product' || $item_details->type == 'Serial_Product'){?>
                                                        - <b><?php echo escape_output($item_details->type) == 'IMEI_Product' ? 'IMEI Number' : 'Serial Number' ?></b>: <?php echo escape_output($op_stock->item_description);?>
                                                    <?php } else if($item_details->type == 'Medicine_Product'){ ?>
                                                        - <b><?php echo lang('Expiry_Date');?>:</b> <?php echo date($this->session->userdata('date_format'), strtotime($op_stock->item_description != '' ? $op_stock->item_description : '')); ?>
                                                    <?php } else{ ?>

                                                    <?php } ?>

                                                <?php }else{?>
                                                    <?php
                                                        $double_convert = (int) ($op_stock->stock_quantity / $item_details->conversion_rate); 
                                                        echo $double_convert ? $double_convert : 0;
                                                    ?> 
                                                    <?= escape_output(unitName($item_details->purchase_unit_id))?>
                                                    <?php echo escape_output($op_stock->stock_quantity) ? getAmtP($op_stock->stock_quantity % $item_details->conversion_rate) : getAmtP(0); ?>
                                                    <?= escape_output(unitName($item_details->sale_unit_id))?>

                                                    <?php if($item_details->type == 'Medicine_Product'){ ?>
                                                        - <b><?php echo lang('Expiry_Date');?>:</b> <?php echo date($this->session->userdata('date_format'), strtotime($op_stock->item_description != '' ? $op_stock->item_description : '')); ?>
                                                    <?php } else{ ?>

                                                    <?php } ?>

                                                <?php } ?>
                                            </span>
                                        </div>
                                    <?php } ?>

                                    <?php if($item_details->type == 'IMEI_Product' || $item_details->type == 'Serial_Product'){ ?>
                                    <div class="details_total_item">
                                        <b><?php echo lang('Total_Quantity');?></b>: <?php echo $total_stock;?> 
                                        <?php if($item_details->unit_type == 1){ ?>
                                            <?= escape_output(unitName($item_details->sale_unit_id))?> 
                                        <?php } ?>
                                    </div>
                                    <?php } ?>


                                    <?php 
                                        $getVariatins = getRelatedVariation($item_details->id);
                                        if ($getVariatins){ 
                                        foreach ($getVariatins as $variation){
                                            $opening_stocks = getItemOpeningStock($variation->id);
                                    ?>
                                    <b><div><?php echo escape_output($variation->name); ?>(<?php echo escape_output($variation->code); ?>)</div></b>
                                    <?php foreach($opening_stocks as $stock){?>
                                        <div class="d-flex">
                                            <b><span class="pe-1"> - <?php echo escape_output($stock->outlet_name); ?>:</span></b>
                                            <?php if($item_details->unit_type == 1){ ?>
                                            <?php
                                                echo escape_output((int)$stock->stock_quantity); 
                                            ?> 
                                            <?= escape_output(unitName($item_details->sale_unit_id))?> 
                                            <?php }else{?>
                                                <?php
                                                    $double_convert = (int) ($stock->stock_quantity / $item_details->conversion_rate); 
                                                    echo $double_convert ? $double_convert : 0;
                                                ?> 
                                                <?= escape_output(unitName($item_details->purchase_unit_id))?>
                                                <?php echo escape_output($stock->stock_quantity) ? getAmtP($stock->stock_quantity % $item_details->conversion_rate) : getAmtP(0); ?>
                                                <?= escape_output(unitName($item_details->sale_unit_id))?>
                                                <?php } ?>
                                        </div>
                                    <?php } ?>
                                    <?php } }?>

                                </td>
                            </tr>
                            <?php } ?>
                                                
                            <tr>
                                <td class="view_detail_border_right"><strong><?php echo lang('alert_quantity');?></strong></td>
                                <td class="view_detail_border_right"> <?php echo escape_output($item_details->alert_quantity == 0 ? getAmtPCustom('0'): getAmtPCustom($item_details->alert_quantity)); ?> <?= escape_output(unitName($item_details->sale_unit_id))?></td>
                            </tr>
                            <?php if($item_details->warranty){?>
                            <tr>
                                <td class="view_detail_border_right"><strong><?php echo lang('warranty');?></strong></td>
                                <td class="view_detail_border_right"> <?= escape_output(($item_details->warranty))?> <?php echo escape_output($warranty_date); ?></td>
                            </tr>
                            <?php } ?>

                            <?php if($item_details->guarantee){?>
                            <tr>
                                <td class="view_detail_border_right"><strong><?php echo lang('guarantee');?></strong></td>
                                <td class="view_detail_border_right"> <?= escape_output(($item_details->guarantee))?> <?php echo escape_output($guarantee_date); ?></td>
                            </tr>
                            <?php } ?>

                            <?php if($item_details->warranty){?>
                            <tr>
                                <td class="view_detail_border_right"><strong><?php echo lang('unit_type');?></strong></td>
                                <td class="view_detail_border_right"><?php echo escape_output($item_details->unit_type) == 1 ? lang('single_unit') : lang('double_unit'); ?></td>
                            </tr>
                            <?php } ?>

                            <?php if($item_details->unit_type == 1) { ?>
                                <?php 
                                    $sale_unit = unitName($item_details->sale_unit_id);
                                    if($sale_unit){ ?>
                                <tr>
                                    <td class="view_detail_border_right"><strong><?php echo lang('unit');?></strong></td>
                                    <td class="view_detail_border_right"> <?= escape_output($sale_unit)?></td>
                                </tr>
                                <?php } ?>
                            <?php }else { ?>
                                <?php if($item_details->purchase_unit_id != ''){ ?>
                                <tr>
                                    <td class="view_detail_border_right"><strong><?php echo lang('purchase_unit');?></strong></td>
                                    <td class="view_detail_border_right"> <?= escape_output(unitName($item_details->purchase_unit_id))?></td>
                                </tr>
                                <?php } ?>
                                <?php if($item_details->sale_unit_id != ''){ ?>
                                <tr>
                                    <td class="view_detail_border_right"><strong><?php echo lang('sale_unit');?></strong></td>
                                    <td class="view_detail_border_right"> <?= escape_output(unitName($item_details->sale_unit_id))?></td>
                                </tr>
                                <?php } ?>
                                <tr>
                                    <td class="view_detail_border_right"><strong><?php echo lang('conversion_rate');?></strong></td>
                                    <td class="view_detail_border_right"> <?= escape_output(($item_details->conversion_rate))?></td>
                                </tr>
                            <?php } ?>
                            <?php if($item_details->description){?>
                            <tr>
                                <td class="view_detail_border_right"><strong><?php echo lang('description');?></strong></td>
                                <td class="view_detail_border_right"> <?= escape_output(($item_details->description))?></td>
                            </tr>
                            <?php } ?>
                            <?php $collect_tax = $this->session->userdata('collect_tax');
                            if($collect_tax == "Yes"){
                                if($item_details->tax_information != ''){
                                $tax_information = json_decode($item_details->tax_information);
                                foreach($tax_information as $tax_field){ ?>
                                <tr>
                                    <td class="view_detail_border_right"><strong><?php echo escape_output($tax_field->tax_field_name); ?><strong></td>
                                    <td class="view_detail_border_right"> <?php echo escape_output($tax_field->tax_field_percentage); ?>%</td>
                                </tr>
                            <?php } } }?>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <a href="javascript:void(0)" class="btn bg-blue-btn" id="print_trigger"><?php echo lang('print'); ?></a>
                <a class="btn bg-blue-btn" href="<?php echo base_url() ?>Item/items"><?php echo lang('back'); ?></a>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>frequent_changing/js/print_trigger.js"></script>
