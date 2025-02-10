<input type="hidden" id="stock_value_tooltip" value="<?php echo lang('stock_value_tooltip');?>">
<input type="hidden" id="The_items_field_is_required" value="<?php echo lang('The_items_field_is_required');?>">
<input type="hidden" id="The_outlet_field_is_required" value="<?php echo lang('The_outlet_field_is_required');?>">

<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/stock.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/report.css">

<div class="main-content-wrapper">
    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header"><?php echo lang('stock_report'); ?> </h3>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('stock_report'); ?>" data-id_name="datatable">
                <div class="btn_list m-right d-flex">
                    <button type="button" class="dataFilterBy new-btn"><iconify-icon icon="solar:filter-broken"  width="22"></iconify-icon> <?php echo lang('filter_by');?></button>
                </div>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('report'), 'secondSection'=> lang('stock_report')])?>
        </div>
    </section>

    <div class="box-wrapper">
        <!-- Report Header Start -->
        <div class="report_header">
            <h3 class="company_name"><?php echo escape_output($this->session->userdata('business_name'));?> </h3>
            <h5 class="outlet_info">
                <strong><?php echo lang('stock_report'); ?></strong>
            </h5>
            <?php if(isset($outlet_id) && $outlet_id){
                $outlet_info = getOutletInfoById($outlet_id); 
            }?>
            <h5 class="outlet_info">
                <?php if(isset($outlet_id) && $outlet_id){ ?>
                    <strong><?php echo lang('outlet'); ?>: </strong> <?= escape_output($outlet_info->outlet_name); ?>
                <?php }?>
            </h5>
            <h5 class="outlet_info">
                <?php if(isset($outlet_id) && $outlet_id){ ?>
                    <strong><?php echo lang('address'); ?>: </strong> <?= escape_output($outlet_info->address); ?>
                <?php } ?>
            </h5>
            <h5 class="outlet_info">
                <?php if(isset($outlet_id) && $outlet_id){ ?>
                    <strong><?php echo lang('email'); ?>: </strong> <?= escape_output($outlet_info->email); ?>
                <?php } ?>
            </h5>
            <h5 class="outlet_info">
                <?php if(isset($outlet_id) && $outlet_id){ ?>
                    <strong><?php echo lang('phone'); ?>: </strong> <?= escape_output($outlet_info->phone); ?>
                <?php } ?>
            </h5>
            <?php if(isset($start_date) && $start_date != '' && $start_date != '1970-01-01' || isset($end_date) && $end_date != '' && $end_date != '1970-01-01'){ ?>
            <h5 class="outlet_info">
                <strong><?php echo lang('date');?>:</strong>
                <?php
                    if(!empty($start_date) && $start_date != '1970-01-01') {
                        echo dateFormat($start_date);
                    }
                    if((isset($start_date) && isset($end_date)) && ($start_date != '1970-01-01' && $end_date != '1970-01-01')){
                        echo ' - ';
                    }
                    if(!empty($end_date) && $end_date != '1970-01-01') {
                        echo dateFormat($end_date);
                    }
                ?>
            </h5>
            <?php } ?>
            
            <h5 class="outlet_info">
                <?php if(isset($item_code) && $item_code){?>
                    <strong><?php echo lang('item_code'); ?>:</strong> <?php echo escape_output($item_code);?>
                <?php } ?>
            </h5>
            <h5 class="outlet_info">
                <?php if(isset($category_id) && $category_id){?>
                    <strong><?php echo lang('category'); ?>:</strong> <?php echo escape_output(getCategoryName($category_id)); ?>

                <?php } ?>
            </h5>
            <h5 class="outlet_info">
                <?php if(isset($brand_id) && $brand_id){?>
                    <strong><?php echo lang('brand'); ?>:</strong> <?php echo escape_output(getBrand($brand_id)); ?>
                <?php } ?>
            </h5>
            <h5 class="outlet_info">
                <?php if(isset($item_id) && $item_id){?>
                    <strong><?php echo lang('item'); ?>:</strong> <?php echo escape_output(getItemParentAndChildName($item_id)); ?>
                <?php } ?>
            </h5>
            <h5 class="outlet_info">
                <?php if(isset($generic_name) && $generic_name){?>
                    <strong><?php echo lang('generic_name'); ?>:</strong> <?php echo escape_output($generic_name);?>

                <?php } ?>
            </h5>
            <h5 class="outlet_info">
                <?php if(isset($supplier_id) && $supplier_id){?>
                    <strong><?php echo lang('supplier'); ?>:</strong> <?php echo escape_output(getSupplierNameById($supplier_id));?>
                <?php } ?>
            </h5>
            <h5 class="outlet_info">
                <?php if(isset($report_generate_time) && $report_generate_time){
                    echo $report_generate_time;
                } ?>
            </h5>
        </div>
        <!-- Report Header End -->


        <div class="table-box">
            <!-- /.box-header -->
            <div class="table-responsive">
                <table id="datatable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="title op_width_1_p"><?php echo lang('sn'); ?></th>
                            <th class="title op_width_25_p"><?php echo lang('item'); ?>(<?php echo lang('code'); ?>)</th>
                            <th class="title op_width_10_p"><?php echo lang('category'); ?></th>
                            <th class="title op_width_30_p"><?php echo lang('stock_segmentation'); ?></th>
                            <th class="title op_width_15"><?php echo lang('total_stock_quantity'); ?></th>
                            <th class="title op_width_10_p">
                                <?php echo lang('LPP'); ?>/<?php echo lang('PP'); ?> 
                                <i data-tippy-content="<?php echo lang('LPP_PP'); ?>" class="ps-1 fa-regular fa-circle-question tippyBtnCall font-16 theme-color"></i>
                            </th>
                            <th class="title op_width_10_p text-center"><?php echo lang('total'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $alertQtySum = 0;
                        $purchasePriceTotal = 0;
                        $lastThreeAvgGrandSum = 0;
                        if(isset($stock) && $stock){
                            foreach($stock as $key=>$item){
                                $generalStock = 0;
                                $purchasePriceSum = 0;
                                $purchaseUnitSum = 0;
                                $saleUnitSum = 0;
                                $saleUnitSum = 0;
                                $itemStockAlertCls = '';
                                if($item->type != 'Variation_Product'){
                                    if(((int)$item->stock_qty - (int)$item->out_qty) < $item->alert_quantity){
                                        $itemStockAlertCls = '';
                                        $alertQtySum ++;
                                    }
                                }
                                if($item->type == 'General_Product' || $item->type == 'Installment_Product' || ($item->type == 'Medicine_Product' && $item->expiry_date_maintain == 'No')){
                                    $generalStock = ((int)$item->stock_qty - (int)$item->out_qty);
                                    $genConvertedPrice = (float)$item->last_three_purchase_avg / (int)$item->conversion_rate;
                                    $purchasePriceSum = ($genConvertedPrice) * $generalStock;
                                    if($item->unit_type == '1'){
                                        $saleUnitSum = (int)$generalStock;
                                    } else if($item->unit_type == '2'){
                                        $purchaseUnitSum = (int)((int)$generalStock / $item->conversion_rate);
                                        $saleUnitSum = ((int)$generalStock) % $item->conversion_rate;
                                    }
                                }
                        ?>
                        <tr> 
                            <td class="<?php echo $itemStockAlertCls; ?>"><?php echo $key + 1 ?></td>
                            <td class="<?php echo $itemStockAlertCls; ?>"><?php echo escape_output($item->name) . '(' . escapeQuot($item->code) . ')'  ?></td>
                            <td class="<?php echo $itemStockAlertCls; ?>"><?php echo escape_output($item->category_name) ?></td>
                            <td class="<?php echo $itemStockAlertCls; ?>">
                                <?php if($item->type == 'Variation_Product'){ ?>
                                <div id="stockInnerTable">
                                    <ul>
                                        <li>
                                            <div><?php echo lang('item'); ?>(<?php echo lang('code'); ?>)</div>
                                            <div><?php echo lang('quantity'); ?></div>
                                            <div><?php echo lang('LPP'); ?>/<?php echo lang('PP'); ?>
                                            <i data-tippy-content="<?php echo lang('LPP_PP'); ?>" class="ps-1 fa-regular fa-circle-question tippyBtnCall font-16 theme-color"></i></div>
                                        </li>
                                        <?php
                                        if($item->variations){
                                            $variations = explode("||", $item->variations);
                                            foreach($variations as $m=>$variation){
                                                $variation_d = explode("|", $variations[$m]);
                                                $variationStock = ((int)$variation_d[4] + (int)$variation_d[5]); /* $variation_d[4]Stock In - $variation_d[5]Stock Out = Current Stock  */
                                                $generalStock += $variationStock;
                                                $variationAlert = (int)($variation_d[2]); /* $variation_d[2] = Aleart Quantity */
                                                $variationConvertedPrice = ($variation_d[3] / $item->conversion_rate); /* $variation_d[3] = Last 3 Purchase AVG */
                                                $purchasePriceSum +=  $variationConvertedPrice * $variationStock; /* Unit Price * Stock = Stock Amount */
                                                $vItemStockAlertCls = '';
                                                if($variationStock < $variationAlert){
                                                    $vItemStockAlertCls = ''; /* Alert Class */
                                                    $alertQtySum ++;
                                                }
                                                $vQtyWithUnit = '';
                                                if($item->unit_type == '1'){
                                                    $saleUnitSum += $variationStock;
                                                    $vQtyWithUnit = escape_output(getAmtPCustom($variationStock)) . ' ' . $item->sale_unit;
                                                } else if($item->unit_type == '2'){
                                                    $purchaseUnitSum += ((int)$variationStock / $item->conversion_rate);
                                                    $saleUnitSum += (((int)$variationStock) % $item->conversion_rate);
                                                    $vPurchaseUnit = getAmtPCustom((int)($variationStock / $item->conversion_rate)) . ' ' . $item->purchase_unit;
                                                    $vSaleUnit = getAmtPCustom(((int)$variationStock) % $item->conversion_rate) . ' ' . $item->sale_unit;
                                                    $vQtyWithUnit =  $vPurchaseUnit . ' ' . $vSaleUnit;
                                                }
                                        ?>
                                        <li>
                                            <div class="<?php echo $vItemStockAlertCls; ?>"><?php echo $variation_d[0] . '('. $variation_d[1] .')'; ?></div>
                                            <div class="<?php echo $vItemStockAlertCls; ?>">
                                                <?php 
                                                if($item->unit_type == '1'){
                                                    echo $vQtyWithUnit;
                                                } else if($item->unit_type == '2'){
                                                    echo $vQtyWithUnit . ' (' . getAmtPCustom($variationStock) . ' ' . $item->sale_unit . ')';
                                                }
                                                ?>
                                            </div>
                                            <div class="<?php echo $vItemStockAlertCls; ?>"><?php echo getAmtStock(($variation_d[3]) / $item->conversion_rate) ?></div>
                                        </li>
                                        <?php }} ?>
                                    </ul>
                                </div>
                                <?php } else if($item->type == 'IMEI_Product' || $item->type == 'Serial_Product') { ?>
                                    <div id="stockInnerTable">
                                        <ul>
                                            <li>
                                                <div><?php echo lang('type'); ?></div>
                                                <div><?php echo lang('imei_serial_number'); ?></div>
                                            </li>

                                    <?php

                                    $expStock = ((int)$item->stock_qty - (int)$item->out_qty);
                                    $expConvertedPrice = (float)$item->last_three_purchase_avg / (int)$item->conversion_rate;
                                    $purchasePriceSum = ($expConvertedPrice) * $expStock;
                                    $purchaseUnitSum = (int)$expStock;
                                    $saleUnitSum = (int)$expStock;
                                    if($item->allimei){
                                        $imaiSerial = explode("||", $item->allimei);
                                        foreach($imaiSerial as $k=>$v){
                                            $imei_serial_type = $item->type == 'IMEI_Product' ? 'IMEI Number:' : 'Serial Number:';
                                        ?>
                                            <li>
                                                <div><?php echo $imei_serial_type ?></div>
                                                <div><?php echo $v ?></div>
                                            </li>
                                        <?php
                                        }
                                    } ?>
                                        </ul>
                                    </div>
                                <?php } else if($item->type == 'Medicine_Product' && $item->expiry_date_maintain == 'Yes'){ 
                                    $purchasePriceSum = ((float)$item->last_three_purchase_avg / (int)$item->conversion_rate) * ((int)$item->stock_qty - (int)$item->out_qty);
                                ?>
                                <div id="stockInnerTable">
                                    <ul>
                                        <li>
                                            <div><?php echo lang('expiry_date'); ?></div>
                                            <div><?php echo lang('quantity'); ?></div>
                                        </li>
                                        <?php 
                                        if(isset($item->allexpiry) && $item->allexpiry){
                                            $allexpiry = explode("||", $item->allexpiry);
                                            foreach($allexpiry as $ek=>$expiry){
                                                $expiry_d = explode("|", $expiry);
                                                $expSaleQtySum = ((int)$expiry_d[1] % $item->conversion_rate ) * $item->conversion_rate;
                                                $generalStock += $expSaleQtySum;
                                                $expQtyWithUnit = '';
                                                if($item->unit_type == '1'){
                                                    $saleUnitSum += (int)$expiry_d[1]; /* $expiry_d[1] = Expiry Quantity  */
                                                    $expQtyWithUnit = escape_output(getAmtPCustom((int)$expiry_d[1])) . ' ' . $item->sale_unit;
                                                } else if($item->unit_type == '2'){
                                                    $purchaseUnitSum += ((int)$expiry_d[1] / $item->conversion_rate);
                                                    $saleUnitSum += ((int)$expiry_d[1] % $item->conversion_rate);
                                                    $expPurchaseUnit = getAmtPCustom((int)$expiry_d[1] / $item->conversion_rate) . ' ' . $item->purchase_unit;
                                                    $expSaleUnit = getAmtPCustom(((int)$expiry_d[1] % $item->conversion_rate)) . ' ' . $item->sale_unit;
                                                    $expQtyWithUnit =  $expPurchaseUnit . ' ' . $expSaleUnit;
                                                }
                                        ?>
                                        <li>
                                            <div><?php echo dateFormat($expiry_d[0]);?></div>
                                            <div>
                                                <?php 
                                                if($item->unit_type == 1){
                                                    echo $expQtyWithUnit;
                                                }else if($item->unit_type == 2){
                                                    echo $expQtyWithUnit . ' (' . getAmtPCustom($expSaleQtySum) . $item->sale_unit . ')';
                                                }
                                                ?>
                                            </div>
                                        </li>
                                        <?php   } } ?>
                                    </ul>
                                </div>
                                <?php } ?>
                            </td>
                            <td class="<?php echo $itemStockAlertCls; ?>">
                                <?php
                                if($item->unit_type == '1'){
                                    echo getAmtPCustom($saleUnitSum) . ' ' . $item->sale_unit;
                                } else if($item->unit_type == '2'){
                                    echo getAmtPCustom($purchaseUnitSum) . ' ' . $item->purchase_unit . ' ' . getAmtPCustom($saleUnitSum) . ' ' . $item->sale_unit . ' ';
                                    echo '(' . getAmtPCustom($generalStock) . $item->sale_unit . ')';
                                }
                                ?>
                            </td>
                            <td class="<?php echo $itemStockAlertCls; ?>">
                                <?php 
                                    echo getAmtStock((int)$item->last_three_purchase_avg / (int)($item->conversion_rate))
                                ?>
                            </td>
                            <td class="<?php echo $itemStockAlertCls; ?>">
                                <?php
                                    $purchasePriceTotal += $purchasePriceSum;
                                    echo getAmtStock($purchasePriceSum) 
                                ?>
                            </td>
                        </tr>
                        <?php } }?>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th class="text-right"><?php echo lang('total');?>:</th>
                            <th><?php echo getAmtStock($purchasePriceTotal)?></th>
                        </tr>
                    </tbody>
                </table>
                <input type="hidden" id="low_qty" value="<?php echo (isset($alertQtySum) && $alertQtySum ? $alertQtySum : 0) ?>">
                <input type="hidden" id="grandTotal" value="<?php echo (isset($purchasePriceTotal) && $purchasePriceTotal ? $purchasePriceTotal : 0); ?>">
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</div>




<div class="filter-overlay"></div>
<div id="product-filter" class="filter-modal">
    <div class="filter-modal-body">
        <header>
            <h3 class="filter-modal-title"><span><?php echo lang('FilterOptions'); ?></span></h3>
            <button type="button" class="close-filter-modal" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">
                    <i data-feather="x"></i>
                </span>
            </button>
        </header>
        <?php echo form_open(base_url() . 'Report/stockReport') ?>
            <div class="row">
                <div class="col-sm-12 col-md-6 mb-2">
                    <div class="form-group">
                        <select class="form-control select2 op_width_100_p" name="item_code" id="item_code">
                            <option value=""><?php echo lang('code'); ?></option>
                            <?php foreach ($items as $value) { ?>
                                <option value="<?php echo escape_output($value->code) ?>" <?php echo set_select('item_code', $value->code); ?>><?php echo escape_output($value->code) ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 mb-2">
                    <div class="form-group">
                        <select class="form-control select2 category_id op_width_100_p" name="category_id" id="category_id">
                            <option value=""><?php echo lang('select'); ?> <?php echo lang('category'); ?></option>
                            <?php foreach ($item_categories as $value) { ?>
                                <option value="<?php echo escape_output($value->id) ?>" <?php echo set_select('category_id', $value->id); ?>><?php echo escape_output($value->name) ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 mb-2">
                    <div class="form-group">
                        <select class="form-control select2 brand_id op_width_100_p" name="brand_id" id="brand_id">
                            <option value=""><?php echo lang('select'); ?> <?php echo lang('brand'); ?></option>
                            <?php foreach ($brands as $value) { ?>
                                <option value="<?php echo escape_output($value->id) ?>" <?php echo set_select('brand_id', $value->id); ?>><?php echo escape_output($value->name) ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 mb-2">
                    <div class="form-group">
                        <select class="form-control select2 op_width_100_p" name="item_id" id="item_id">
                            <option value=""><?php echo lang('select'); ?> <?php echo lang('item'); ?></option>
                            <?php foreach ($items as $value) { ?>
                                <option value="<?php echo escape_output($value->id) ?>" <?php echo set_select('item_id', $value->id); ?>><?php echo getItemNameById($value->parent_id); ?> <?php echo escape_output($value->name) . "(" . $value->code . ")" ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 mb-2">
                    <div class="form-group">
                        <input type="text" class="form-control" name="generic_name" placeholder="<?php echo lang('generic_name') ?>">
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 mb-2">
                    <div class="form-group">
                        <select  class="form-control select2 op_width_100_p" id="supplier_id" name="supplier_id">
                            <option value=""><?php echo lang('select'); ?> <?php echo lang('supplier'); ?></option>
                            <?php
                            foreach ($suppliers as $splrs) {
                                ?>
                                <option value="<?php echo escape_output($splrs->id) ?>" <?php echo set_select('supplier_id', $splrs->id); ?>><?php echo escape_output($splrs->name) ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 mb-2">
                    <div class="form-group">
                        <select  class="form-control select2 ir_w_100" id="outlet_id" name="outlet_id">
                            <?php
                                $role = $this->session->userdata('role');
                                if($role == '1'){
                            ?>
                            <option value=""><?php echo lang('select_outlet') ?></option>
                            <?php } ?>
                            <?php
                            $outlets = getOutletsForReport();
                            foreach ($outlets as $value):
                                ?>
                                <option <?= set_select('outlet_id',$value->id)?>  value="<?php echo escape_output($value->id) ?>"><?php echo escape_output($value->outlet_name) ?></option>
                                <?php
                            endforeach;
                            ?>
                        </select>
                    </div>
                </div>
                <div class="clear-fix"></div>
                <div class="col-sm-12 col-md-6 mb-2">
                    <button type="submit" name="submit" value="submit" class="new-btn">
                        <iconify-icon icon="solar:hourglass-broken" width="22"></iconify-icon>
                        <?php echo lang('submit'); ?>
                    </button>
                </div>
            </div>
        <?php echo form_close(); ?>
    </div>
</div>


<?php $this->view('updater/reuseJs_w_pagination')?>
<script src="<?php echo base_url(); ?>frequent_changing/js/stock_report.js"></script>
