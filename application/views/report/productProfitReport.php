<input type="hidden" id="last_three_note" value="<?php echo lang('last_three_calculate_formula'); ?>">
<input type="hidden" id="lat_costing" value="<?php echo lang('lat_costing'); ?>">
<input type="hidden" id="Costing_formula_calculation" value="<?php echo lang('Costing_formula_calculation'); ?>">
<input type="hidden" id="The_items_field_is_required" value="<?php echo lang('The_items_field_is_required'); ?>">
<input type="hidden" id="The_Costing_Method_field_required" value="<?php echo lang('The_Costing_Method_field_required'); ?>">
<input type="hidden" value="<?php echo lang('The_date_field_is_required');?>" id="The_date_field_is_required">


<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/report.css">
<div class="main-content-wrapper">

    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('product_profit_loss_report'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('report'), 'secondSection'=> lang('product_profit_loss_report')])?>
        </div>
    </section>


    <div class="box-wrapper">
        <!-- Report Header Start -->
        <div class="report_header">
            <h3 class="company_name"><?php echo escape_output($this->session->userdata('business_name'));?> </h3>
            <h5 class="outlet_info">
                <strong><?php echo lang('product_profit_loss_report'); ?></strong>
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
                <?php if(isset($item_id) && $item_id != ''){ ?>
                    <strong><?php echo lang('item'); ?>: </strong> <?php echo getItemParentAndChildNameCode($item_id); ?>
                <?php } ?>
            </h5>
            <h5 class="outlet_info">
                <?php if(isset($calculation_formula) && $calculation_formula != ''){ ?>
                    <strong><?php echo lang('costing_method'); ?>: </strong> 
                    <?php 
                    if ($calculation_formula == "AVG"){
                        echo lang('avg_costing_last_3');
                    } else if($calculation_formula == "PP_Price"){
                        echo lang('Last_Purchase_Price');
                    }
                    ?>
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
            <div class="box-body">
            <input type="hidden" class="datatable_name"  data-filter="yes" data-title="<?php echo lang('product_profit_loss_report'); ?>" data-id_name="datatable">
                <table id="datatable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th><?php echo lang('sn'); ?></th>
                            <th><?php echo lang('invoice_no'); ?></th>
                            <th><?php echo lang('date_and_time'); ?></th>
                            <th class="text-center"><?php echo lang('sale_unit_price'); ?></th>
                            <th class="text-center"><?php echo lang('qty'); ?></th>
                            <th class="text-center"><?php echo lang('discount'); ?></th>
                            <th class="text-center"><?php echo lang('total_sale'); ?></th>
                            <th class="text-center"><?php echo lang('costing_price'); ?></th>
                            <th class="text-center"><?php echo lang('total_cost'); ?></th>
                            <th><?php echo lang('profit'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $total = 0;
                    if (isset($productProfitReport)):
                        foreach ($productProfitReport as $key => $value) {
                            $purchasePrice = 0;
                            if($calculation_formula == 'AVG'){
                                if($value->last_three_purchase_avg != ''){
                                    $purchasePrice = (int)$value->last_three_purchase_avg;
                                }else{
                                    $purchasePrice = (int)$value->purchase_price;
                                }
                            }else if ($calculation_formula == 'PP_Price'){
                                if($value->last_purchase_price != ''){
                                    $purchasePrice = (int)$value->last_purchase_price;
                                }else{
                                    $purchasePrice = (int)$value->purchase_price;
                                }
                            }else{
                                $purchasePrice = (int)$value->purchase_price;
                            }
                            $key++;
                            $total_amount = ($value->totalQty*$value->sale_price)-($value->totalQty * $purchasePrice) - $value->discount_amount;
                            $total+=$total_amount;
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $key; ?></td>
                                <td><?php echo escape_output($value->sale_no) ?></td>
                                <td><?php echo dateFormat($value->date_time) ?></td>
                                <td class="text-center"><?php echo getAmtCustom($value->sale_price); ?></td>
                                <td class="text-center"><?php echo escape_output($value->totalQty); ?></td>
                                <td class="text-center"><?php echo getAmtCustom($value->discount_amount); ?></td>
                                <td class="text-center"><?php echo getAmtCustom($value->totalQty*$value->sale_price); ?></td>
                                <td class="text-center"><?php echo getAmtCustom($purchasePrice); ?></td>
                                <td class="text-center"><?php echo getAmtCustom($value->totalQty*$purchasePrice); ?></td>
                                <td><?php echo getAmtCustom($total_amount); ?></td>
                            </tr>
                            <?php
                            
                        }
                    endif;
                    ?>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th class="text-right"><?php echo lang('total'); ?></th>
                        <th><?=getAmtCustom($total)?></th>
                    </tr>
                    </tbody>
                </table>
            </div>
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
        <?php echo form_open(base_url() . 'Report/productProfitReport') ?>
        <div class="row">
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <input  autocomplete="off" type="text" name="startDate" id="startDate" readonly class="form-control customDatepicker" placeholder="<?php echo lang('start_date'); ?>" value="<?php echo set_value('startDate'); ?>">
                </div>
                <div class="alert alert-error error-msg startDate_err_msg_contnr ">
                    <p id="startDate_err_msg"></p>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <input  autocomplete="off" type="text" id="endDate" name="endDate" readonly class="form-control customDatepicker" placeholder="<?php echo lang('end_date'); ?>" value="<?php echo set_value('endDate'); ?>">
                </div>
                <div class="alert alert-error error-msg endDate_err_msg_contnr ">
                    <p id="endDate_err_msg"></p>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <select class="form-control select2 op_width_100_p" name="item_id" id="item_id">
                        <option value=""><?php echo lang('item'); ?></option>
                        <?php foreach ($items as $value) { ?>
                            <option value="<?php echo escape_output($value->id) ?>" <?php echo set_select('item_id', $value->id); ?>><?php echo getItemNameCodeBrandByItemId($value->id) ?></option>
                        <?php } ?>
                    </select>
                    <div class="alert alert-error error-msg item_id_err_msg_contnr ">
                        <p id="item_id_err_msg"></p>
                    </div>
                </div>
            </div>
            <?php if(isLMni()): ?>
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <select  class="form-control select2 ir_w_100" id="outlet_id" name="outlet_id">
                        <?php
                            $role = $this->session->userdata('role');
                            if($role == '1'){
                        ?>
                        <option value=""><?php echo lang('outlet') ?></option>
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
            <?php endif; ?>
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group d-flex justify-content-between align-items-center">
                    <select class="form-control select2 op_width_100_p" name="calculation_formula" id="calculation_formula">
                        <option <?php echo escape_output($calculation_formula) == '' ? 'selected' : '' ?> value=""><?php echo lang('costing_method'); ?></option>
                        <option <?php echo escape_output($calculation_formula) == 'AVG' ? 'selected' : '' ?>  value="AVG"><?php echo lang('avg_costing_last_3');?></option>
                        <option <?php echo escape_output($calculation_formula) == 'PP_Price' ? 'selected' : '' ?> value="PP_Price"><?php echo lang('Last_Purchase_Price'); ?></option>
                    </select>
                    <div class="ms-3 op_right op_font_18 op_cursor_pointer mb-4-px">
                        <div id="toolTipGuide"></div>
                    </div> 
                </div>
                <div class="alert alert-error error-msg calculation_formula_err_msg_contnr ">
                    <p id="calculation_formula_err_msg"></p>
                </div>
            </div>
            <div class="clear-fix"></div>
            <div class="col-12 mb-2">
                <button type="submit" name="submit" value="submit" class="new-btn productProfitReport">
                    <iconify-icon icon="solar:hourglass-broken" width="22"></iconify-icon>
                    <?php echo lang('submit'); ?>
                </button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>



<?php $this->view('updater/reuseJs_w_pagination'); ?>
<script src="<?php echo base_url(); ?>frequent_changing/js/productProfit.js"></script>