<input type="hidden" id="last_three_note" value="<?php echo lang('last_three_calculate_formula'); ?>">
<input type="hidden" id="lat_costing" value="<?php echo lang('lat_costing'); ?>">
<input type="hidden" id="Costing_formula_calculation" value="<?php echo lang('Costing_formula_calculation'); ?>">
<input type="hidden" id="The_items_field_is_required" value="<?php echo lang('The_items_field_is_required'); ?>">
<input type="hidden" id="The_Costing_Method_field_required" value="<?php echo lang('The_Costing_Method_field_required'); ?>">

<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/report.css">
<div class="main-content-wrapper">
    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('profit_loss_report'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('report'), 'secondSection'=> lang('profit_loss_report')])?>
        </div>
    </section>


    <div class="box-wrapper">
        <!-- Report Header Start -->
        <div class="report_header">
            <h3 class="company_name"><?php echo escape_output($this->session->userdata('business_name'));?> </h3>
            <h5 class="outlet_info">
                <strong><?php echo lang('profit_loss_report'); ?></strong>
            </h5>
            <?php if(isset($outlet_id) && $outlet_id){
                $outlet_info = getOutletInfoById($outlet_id); 
            }?>
            <h5 class="outlet_info">
                <?php if(isset($outlet_id) && $outlet_id){ ?>
                    <strong><?php echo lang('outlet'); ?>: </strong> <?php echo escape_output($outlet_info->outlet_name); ?>
                <?php }?>
            </h5>
            <h5 class="outlet_info">
                <?php if(isset($outlet_id) && $outlet_id){ ?>
                    <strong><?php echo lang('address'); ?>: </strong> <?php echo escape_output($outlet_info->address); ?>
                <?php } ?>
            </h5>
            <h5 class="outlet_info">
                <?php if(isset($outlet_id) && $outlet_id){ ?>
                    <strong><?php echo lang('email'); ?>: </strong> <?php echo escape_output($outlet_info->email); ?>
                <?php } ?>
            </h5>
            <h5 class="outlet_info">
                <?php if(isset($outlet_id) && $outlet_id){ ?>
                    <strong><?php echo lang('phone'); ?>: </strong> <?php echo escape_output($outlet_info->phone); ?>
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
                <div class="table-responsive">
                <input type="hidden" class="datatable_name"  data-filter="yes" data-title="<?php echo lang('profit_loss_report'); ?>" data-id_name="datatable">
                    <table class="table" id="datatable">
                        <thead>
                            <tr>
                                <th><?php echo lang('date_range'); ?> : ( <?php if(!empty($start_date) && !empty($end_date)){echo date("d-m-Y", strtotime($start_date)) ." ". lang('to') ." ". date("d-m-Y", strtotime($end_date));} ?> )</th>
                                <th><?php echo lang('outlet'); ?> : <?php echo isset($outlet_id) && $outlet_id ? getOutletName($outlet_id) : '' ?></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="w-10">1</td>
                                <td class="w-70">
                                    <?php echo lang('profit_sale_column_with_tax_discount'); ?>
                                </td>
                                <td class="w-20">
                                    <?php 
                                    echo isset($saleReportByDate['profit_sale_with_tax_discount']) ? getAmtCustom($saleReportByDate['profit_sale_with_tax_discount']) : getAmtCustom(0) 
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="w-10">2</td>
                                <td class="w-70"><?php echo lang('profit_cost_of_sale_column'); ?></td>
                                <td class="w-20"><?php echo isset($saleReportByDate['profit_cost_of_sale']) ? getAmtCustom($saleReportByDate['profit_cost_of_sale']) : getAmtCustom(0) ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="w-10">3</td>
                                <td class="w-70"> <?php echo lang('profit_tax_column'); ?></td>
                                <td class="w-20"><?php echo isset($saleReportByDate['profit_total_tax']) ? getAmtCustom($saleReportByDate['profit_total_tax']) : getAmtCustom(0) ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="w-10">4</td>
                                <td class="w-70"><?php echo lang('profit_delivery_service_column'); ?></td>
                                <td class="w-20"><?php echo isset($saleReportByDate['profit_total_delivery']) ? getAmtCustom($saleReportByDate['profit_total_delivery']) : getAmtCustom(0) ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="w-10">5</td>
                                <td class="w-70"><?php echo lang('profit_discount_column'); ?></td>
                                <td class="w-20"><?php echo isset($saleReportByDate['profit_total_discount']) ? getAmtCustom($saleReportByDate['profit_total_discount']) : getAmtCustom(0) ?>
                                </td>
                            </tr>
                            <?php if(!moduleIsHideCheck('Installment Sale-YES')){ ?>
                            <tr>
                                <td class="w-10">6</td>
                                <td class="w-70"><?php echo lang('profit_installment_sale_column'); ?></td>
                                <td class="w-20"><?php echo isset($saleReportByDate['profit_total_installment_sale']) ? getAmtCustom($saleReportByDate['profit_total_installment_sale']) : getAmtCustom(0) ?>
                                </td>
                            </tr>
                            <?php } else{ ?>
                            <tr>
                                <td class="w-10">6</td>
                                <td class="w-70">N/A</td>
                                <td class="w-20">N/A
                                </td>
                            </tr>
                            <?php } ?>
                            <tr>
                                <td class="w-10">7</td>
                                <td class="w-70"><?php echo lang('profit_income_column'); ?></td>
                                <td class="w-20"><?php echo isset($saleReportByDate['profit_total_income']) ? getAmtCustom($saleReportByDate['profit_total_income']) : getAmtCustom(0) ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="w-10">8</td>
                                <td class="w-70"><?php echo lang('profit_sale_return_column'); ?></td>
                                <td class="w-20"><?php echo isset($saleReportByDate['profit_total_sale_return']) ? getAmtCustom($saleReportByDate['profit_total_sale_return']) : getAmtCustom(0) ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="w-10">9</td>
                                <td class="w-70"><?php echo lang('profit_servicing_column'); ?></td>
                                <td class="w-20"><?php echo isset($saleReportByDate['profit_total_servicing']) ? getAmtCustom($saleReportByDate['profit_total_servicing']) : getAmtCustom(0) ?>
                                </td>
                            </tr>
                            <tr class="profit_txt">
                                <td class="w-10">10</td>
                                <td class="w-70"><?php echo lang('profit_gross_column'); ?> (1+4+6+7+9) - (2+3+5+8)</td>
                                <td class="w-20"><?php echo isset($saleReportByDate['profit_gross']) ? getAmtCustom($saleReportByDate['profit_gross']) : getAmtCustom(0) ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="w-10">11</td>
                                <td class="w-70"><?php echo lang('profit_total_salaries_column'); ?></td>
                                <td class="w-20"><?php echo isset($saleReportByDate['profit_total_salaries']) ? getAmtCustom($saleReportByDate['profit_total_salaries']) : getAmtCustom(0) ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="w-10">12</td>
                                <td class="w-70"><?php echo lang('profit_total_expense_column'); ?></td>
                                <td class="w-20"><?php echo isset($saleReportByDate['profit_total_expense']) ? getAmtCustom($saleReportByDate['profit_total_expense']) : getAmtCustom(0) ?>
                                </td>
                            </tr>
                            <tr class="profit_txt">
                                <td class="w-10">13</td>
                                <td class="w-70"><?php echo lang('profit_net_column'); ?> (10) - (11+12)</td>
                                <td class="w-20"><?php echo isset($saleReportByDate['profit_net']) ? getAmtCustom($saleReportByDate['profit_net']) : getAmtCustom(0) ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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
        <?php echo form_open(base_url() . 'Report/profitLossReport') ?>
        <div class="row">
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <input  autocomplete="off" type="text" name="startDate" readonly class="form-control customDatepicker" placeholder="<?php echo lang('start_date'); ?>" value="<?php echo set_value('startDate'); ?>">
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <input  autocomplete="off" type="text" id="endMonth" name="endDate" readonly class="form-control customDatepicker" placeholder="<?php echo lang('end_date'); ?>" value="<?php echo set_value('endDate'); ?>">
                </div>
            </div>
            <?php
                if(isLMni()):
            ?>
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
                            <option <?php echo set_select('outlet_id',$value->id)?>  value="<?php echo escape_output($value->id) ?>"><?php echo escape_output($value->outlet_name) ?></option>
                            <?php
                        endforeach;
                        ?>
                    </select>
                </div>
            </div>
            <?php
                endif;
            ?>
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
                <button type="submit" name="submit" value="submit" class="new-btn profitLossReport">
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

