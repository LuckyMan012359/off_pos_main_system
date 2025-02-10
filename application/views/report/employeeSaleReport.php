<input type="hidden" id="The_outle_field_is_required" value="<?php echo lang('The_outlet_field_is_required');?>">
<input type="hidden" value="<?php echo lang('The_date_field_is_required');?>" id="The_date_field_is_required">
<input type="hidden" value="<?php echo lang('The_Employee_field_is_required');?>" id="The_Employee_field_is_required">

<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/report.css">
<div class="main-content-wrapper">

    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('employee_sale_report'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('report'), 'secondSection'=> lang('employee_sale_report')])?>
        </div>
    </section>



    <div class="box-wrapper">
        <!-- Report Header Start -->
        <div class="report_header">
            <h3 class="company_name"><?php echo escape_output($this->session->userdata('business_name'));?> </h3>
            <h5 class="outlet_info">
                <strong><?php echo lang('employee_sale_report'); ?></strong>
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
            <h5 class="outlet_info">
                <?php if(isset($user_id) && $user_id){ ?>
                    <strong><?php echo lang('employee'); ?>: </strong> <?php echo escape_output($userInfo); ?>
                <?php } else if(isset($user_id) && $user_id == ''){?>
                    <strong><?php echo lang('employee'); ?>: </strong> <?php echo lang('all'); ?>
                <?php } ?>
            </h5>
            <h5 class="outlet_info">
                <?php if(isset($product_invoice) && $product_invoice){ ?>
                    <strong><?php echo lang('commission_type'); ?>: </strong> <?php echo str_replace("_"," ",$product_invoice); ?>
                <?php }?>
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
                <?php if(isset($report_generate_time) && $report_generate_time){
                    echo $report_generate_time;
                } ?>
            </h5>
        </div>
        <!-- Report Header End -->

        <div class="table-box">
            <div class="box-body">
                <div class="table-responsive">
                <input type="hidden" class="datatable_name"  data-filter="yes" data-title="<?php echo lang('user_commission_report'); ?>" data-id_name="datatable">
                    <table id="datatable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="w-5"><?php echo lang('sn'); ?></th>
                                <th><?php echo lang('invoice_no'); ?></th>
                                <th><?php echo lang('date_and_time'); ?></th>
                                <th><?php echo lang('customer'); ?></th>
                                <?php if($product_invoice == 'Invoice_Wise'){?>
                                    <th><?php echo lang('items'); ?></th>
                                    <th class="text-center"><?php echo lang('subtotal'); ?></th>
                                <?php }else if($product_invoice == 'Product_Wise'){ ?>
                                    <th><?php echo lang('items'); ?>(<?php echo lang('code'); ?>)-<?php echo lang('quantity'); ?>-<?php echo lang('unit_price'); ?>-<?php echo lang('subtotal'); ?></th>
                                    <th class="text-center"><?php echo lang('item_price'); ?></th>
                                <?php }else{?>
                                    <th><?php echo lang('items'); ?></th>
                                    <th class="text-center"><?php echo lang('subtotal'); ?></th>
                                <?php }?>
                                <th class="text-center"><?php echo lang('commission_percentage'); ?></th>
                                <th><?php echo lang('commission_amount'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $pGrandTotal = 0;
                            $commissionTotal = 0;
                            $commission = 0;
                            if (isset($employeeSaleReport)):
                                foreach ($employeeSaleReport as $key => $value) {


                                    $key++;
                                    if($product_invoice == 'Product_Wise'){
                                        $commission = ($value->total_payable * $value->commission) / 100;
                                    }else if($product_invoice == 'Invoice_Wise'){
                                        $commission = ($value->sub_total * $value->commission) / 100;
                                    }else{
                                        $commission = ($value->total_payable * $value->commission) / 100;
                                    }
                                    $commissionTotal += $commission;
                                    ?>
                                    <tr>
                                        <td><?php echo $key; ?></td>
                                        <td><?php echo escape_output($value->sale_no) ?></td>
                                        <td><?php echo dateFormat($value->date_time) ?></td>
                                        <td><?php echo escape_output($value->customer_name) ?><?php echo escape_output($value->customer_phone) != '' ?  ' (' .$value->customer_phone . ')' : '' ?></td>
                                        <?php if($product_invoice == 'Invoice_Wise'){?>
                                            <td>
                                                <?php $items = getSaleItemsBySaleId($value->id);
                                                echo "<strong>Name(Code)-Qty-Unit Price-Subtotal</strong>" . "<br>";
                                                foreach($items as $item){
                                                    echo escape_output($item->name). '('. $item->code . ')-' . $item->qty . ' ' .$item->unit_name . '-' . getAmtCustom($item->menu_unit_price) . '-'  . getAmtCustom($item->menu_price_with_discount) ."<br>";
                                                }
                                                ?>
                                            </td>
                                        <?php }else if($product_invoice == 'Product_Wise'){?>
                                            <td>
                                                <?php 
                                                echo escape_output($value->item_name) . '(' . $value->code . ')-' . $value->qty . $value->unit_name . '-' . getAmtCustom($value->menu_unit_price) . '-' . getAmtCustom($value->total_payable); ?>
                                            </td>
                                        <?php } else{?>
                                            <td>
                                            <?php 
                                                echo "<strong>Name(Code)-Qty-Unit Price-Total</strong>" . "<br>";
                                                echo escape_output($value->item_name) . '(' . $value->code . ')-' . $value->qty . ' '. $value->unit_name . '-' . getAmtCustom($value->single_price) . '-' . getAmtCustom($value->total_payable); ?>
                                            </td>
                                        <?php } ?>


                                        <?php if($product_invoice == 'Invoice_Wise'){?>
                                            <td class="text-center"><?php echo getAmtCustom($value->sub_total) ?></td>
                                        <?php }else if($product_invoice == 'Product_Wise'){ ?>
                                            <td class="text-center"><?php echo getAmtCustom($value->total_payable) ?></td>
                                        <?php } else{?>
                                            <td class="text-center"><?php echo getAmtCustom($value->total_payable) ?></td>
                                        <?php } ?>
                                        <td class="text-center"><?php echo escape_output($value->commission ? $value->commission . '%' : '') ?></td>
                                        <td><?php echo getAmtCustom($commission) ?></td>
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
                                <th class="text-center"><?php echo lang('total_commisssion');?></th>
                                <th><?php echo getAmtCustom($commissionTotal);?></th>
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
        <?php echo form_open(base_url() . 'Report/employeeSaleReport') ?>
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
                    <select  class="form-control select2 op_width_100_p" id="user_id" name="user_id">
                        <?php
                            $role = $this->session->userdata('role');
                            if($role == '1'){
                        ?>
                        <option value=""><?php echo lang('select_employee') ?></option>
                        <?php } ?>
                        <?php
                        foreach ($users as $value) {
                            ?>
                            <option value="<?php echo escape_output($value->id) ?>" <?php echo set_select('user_id', $value->id); ?>><?php echo escape_output($value->full_name) ?></option>
                        <?php } ?>
                    </select>
                    <div class="alert alert-error error-msg user_id_err_msg_contnr ">
                        <p id="user_id_err_msg"></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <select  class="form-control select2 op_width_100_p" id="product_invoice" name="product_invoice">
                        <option <?php echo escape_output($product_invoice) == 'Invoice_Wise' ? 'selected' : ''  ?> value="Invoice_Wise"><?php echo lang('invoice_wise'); ?></option>
                        <option <?php echo escape_output($product_invoice) == 'Product_Wise' ? 'selected' : ''  ?> value="Product_Wise"><?php echo lang('product_wise'); ?></option>
                        <option <?php echo escape_output($product_invoice) == 'Combo_Product_Wise' ? 'selected' : ''  ?> value="Combo_Product_Wise"><?php echo lang('Combo_Product_Wise'); ?></option>
                    </select>
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
                        <option value=""><?php echo lang('select_outlet') ?></option>
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
            <div class="clear-fix"></div>
            <div class="col-12 mb-2">
                <button type="submit" name="submit" value="submit" class="new-btn employeeSaleReport">
                    <iconify-icon icon="solar:hourglass-broken" width="22"></iconify-icon>
                    <?php echo lang('submit'); ?>
                </button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>


<?php $this->view('updater/reuseJs_w_pagination'); ?>
<script src="<?php echo base_url();?>frequent_changing/js/report-js/master_report_validation.js"></script>