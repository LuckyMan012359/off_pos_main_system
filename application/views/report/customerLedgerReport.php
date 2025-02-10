<input type="hidden" id="The_items_field_is_required" value="<?php echo lang('The_items_field_is_required');?>">
<input type="hidden" id="The_customer_field_is_required" value="<?php echo lang('The_customer_field_is_required');?>">
<input type="hidden" id="The_supplier_field_is_required" value="<?php echo lang('The_supplier_field_is_required');?>">
<input type="hidden" id="The_date_field_is_required" value="<?php echo lang('The_date_field_is_required');?>">

<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/report.css">
<div class="main-content-wrapper">

    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('customer_ledger'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('report'), 'secondSection'=> lang('customer_ledger')])?>
        </div>
    </section>
    
    <div class="box-wrapper">
        <!-- Report Header Start -->
        <div class="report_header">
            <h3 class="company_name"><?php echo escape_output($this->session->userdata('business_name'));?> </h3>
            <h5 class="outlet_info">
                <strong><?php echo lang('customer_ledger'); ?></strong>
            </h5>
            <?php if(isset($outlet_id) && $outlet_id){
                $outlet_info = getOutletInfoById($outlet_id); 
            ?>
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
            <span class="outlet_info">
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
            </span>
            <?php } ?>
            <?php } ?>
        
            <h5 class="outlet_info">
                <?php if(isset($customer_id) && $customer_id){ ?>
                    <strong><?php echo lang('customer'); ?>: </strong> <?php echo getCustomerName($customer_id); ?>
                <?php } ?>
            </h5>
            <h5 class="outlet_info">
                <?php if(isset($type) && $type){ ?>
                    <strong><?php echo lang('type'); ?>: </strong> <?php echo $type; ?>
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
                <input type="hidden" class="datatable_name"  data-filter="yes" data-title="<?php echo lang('customer_ledger'); ?>" data-id_name="datatable">
                <table id="datatable"  class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="w-5"><?php echo lang('sn'); ?></th>
                                <th class="w-15"><?php echo lang('date_and_time'); ?></th>
                                <th class="w-20"><?php echo lang('transaction_type'); ?></th>
                                <th class="w-15"><?php echo lang('transaction_no'); ?></th>
                                <?php if(isset($ledger_type) && $ledger_type == 'Ledger Details'){ ?>
                                <th class="w-15"><?php echo lang('items'); ?></th>
                                <?php } ?>
                                <th class="w-15 text-center"><?php echo lang('debit'); ?></th>
                                <th class="w-15 text-center"><?php echo lang('credit'); ?></th>
                                <th class="w-15"><?php echo lang('outlet'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($type) && $type == 'All'){ ?>
                            <?php
                            $balance = 0; 
                            $sum_of_debit = 0; 
                            $sum_of_credit = 0; 
                            if(isset($customerLedger) && $customerLedger){
                            foreach ($customerLedger as $key=>$customer){
                                if(isset($sum_of_op_before_date) && $key == 0){
                                    if($sum_of_op_before_date > 0){
                                        $balance += $sum_of_op_before_date;
                                        $sum_of_debit += $sum_of_op_before_date;
                                    }else{
                                        $balance -= absCustom($sum_of_op_before_date);
                                        $sum_of_credit += absCustom($sum_of_op_before_date);
                                    } 
                                }else{
                                    if($customer->debit != 0){
                                        $balance += $customer->debit;
                                        $sum_of_debit += $customer->debit;
                                    }else{
                                        $balance -= $customer->credit;
                                        $sum_of_credit += $customer->credit;
                                    } 
                                }
                            ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td>
                                    <?php echo escape_output($customer->date) != '' ? dateFormat($customer->date) : '' ;?>
                                </td>
                                <td><?php echo escape_output($customer->type) ?></td>
                                <td><?php echo escape_output($customer->reference_no) ?></td>
                                <?php if(isset($ledger_type) && $ledger_type == 'Ledger Details'){ ?>
                                <td>
                                <?php 
                                    $details = '';
                                    if($customer->type == 'Sale Due Amount'){
                                        $details = getSaleDetailsBySaleIdForCustomerLedger($customer->id);
                                    }else if($customer->type == 'Sale Return'){
                                        $details = getSaleReturnDetailsBySaleReturnIdForCustomerLedger($customer->id);
                                    }
                                    if($details){
                                        echo "<strong>Name(Code)-Qty(Unit)-Total</strong><br>";
                                        foreach($details as $item){
                                            echo escape_output($item->item_name). '('. $item->item_code . ')-' . $item->quantity . '(' .$item->unit_name . ')-' . getAmtCustom($item->subtotal) . "<br>";
                                        }
                                    }
                                ?>
                                </td>
                                <?php } ?>


                                <?php if(isset($sum_of_op_before_date) && $key == 0){ ?>
                                    <td class="text-center"><?php echo $sum_of_op_before_date > 0 ? getAmtCustom($sum_of_op_before_date) : getAmtCustom(0) ?></td>
                                    <td class="text-center"><?php echo $sum_of_op_before_date < 0 ? getAmtCustom(absCustom($sum_of_op_before_date)) : getAmtCustom(0); ?></td>
                                <?php }else{ ?>
                                    <td class="text-center"><?php echo getAmtCustom(absCustom($customer->debit)) ?></td>
                                    <td class="text-center"><?php echo getAmtCustom(absCustom($customer->credit)) ?></td>
                                <?php } ?>
                                <td><?php echo escape_output($customer->outlet_name); ?></td>
                            </tr>
                            <?php } } ?>
                        <?php }else if($type == 'Credit'){ ?>
                            <?php
                            $balance = 0; 
                            $sum_of_credit = 0; 
                            if(isset($customerLedger) && $customerLedger){
                            foreach ($customerLedger as $key=>$customer){
                                if($customer->debit === '0' && $customer->type != 'Opening Balance'){
                                    $sum_of_credit += $customer->credit;
                            ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td>
                                    <?php echo escape_output($customer->date) != '' ? dateFormat($customer->date) : '' ;?>
                                </td>
                                <td><?php echo escape_output($customer->type) ?></td>
                                <td><?php echo escape_output($customer->reference_no) ?></td>

                                <?php if(isset($ledger_type) && $ledger_type == 'Ledger Details'){ ?>
                                <td>
                                <?php 
                                    $details = '';
                                    if($customer->type == 'Sale Due Amount'){
                                        $details = getSaleDetailsBySaleIdForCustomerLedger($customer->id);
                                    }else if($customer->type == 'Sale Return'){
                                        $details = getSaleReturnDetailsBySaleReturnIdForCustomerLedger($customer->id);
                                    }
                                    if($details){
                                        echo "<strong>Name(Code)-Qty(Unit)-Total</strong><br>";
                                        foreach($details as $item){
                                            echo escape_output($item->item_name). '('. $item->item_code . ')-' . $item->quantity . '(' .$item->unit_name . ')-' . getAmtCustom($item->subtotal) . "<br>";
                                        }
                                    }
                                ?>
                                </td>
                                <?php } ?>


                                <?php if(isset($sum_of_op_before_date) && $key == 0){ ?>
                                    <td class="text-center"><?php echo $sum_of_op_before_date > 0 ? getAmtCustom($sum_of_op_before_date) : getAmtCustom(0) ?></td>
                                    <td class="text-center"><?php echo $sum_of_op_before_date < 0 ? getAmtCustom(absCustom($sum_of_op_before_date)) : getAmtCustom(0); ?></td>
                                <?php }else{ ?>
                                    <td></td>
                                    <td class="text-center"><?php echo getAmtCustom($customer->credit) ?></td>
                                <?php } ?>
                                <td><?php echo escape_output($customer->outlet_name); ?></td>
                            </tr>
                            <?php } } }?>
                        <?php } else if($type == 'Debit'){ ?>
                            <?php
                            $sum_of_debit = 0;
                            if(isset($customerLedger) && $customerLedger){
                            foreach ($customerLedger as $key=>$customer){
                                if($customer->credit === '0' && $customer->type != 'Opening Balance'){
                                    $sum_of_debit += $customer->debit;
                            ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td>
                                    <?php echo escape_output($customer->date) != '' ? dateFormat($customer->date) : '' ;?>
                                </td>
                                <td><?php echo escape_output($customer->type) ?></td>
                                <td><?php echo escape_output($customer->reference_no) ?></td>
                                <?php if(isset($ledger_type) && $ledger_type == 'Ledger Details'){ ?>
                                <td>
                                <?php 
                                    $details = '';
                                    if($customer->type == 'Sale Due Amount'){
                                        $details = getSaleDetailsBySaleIdForCustomerLedger($customer->id);
                                    }else if($customer->type == 'Sale Return'){
                                        $details = getSaleReturnDetailsBySaleReturnIdForCustomerLedger($customer->id);
                                    }
                                    if($details){
                                        echo "<strong>Name(Code)-Qty(Unit)-Total</strong><br>";
                                        foreach($details as $item){
                                            echo escape_output($item->item_name). '('. $item->item_code . ')-' . $item->quantity . '(' .$item->unit_name . ')-' . getAmtCustom($item->subtotal) . "<br>";
                                        }
                                    }
                                ?>
                                </td>
                                <?php } ?>
                                <?php if(isset($sum_of_op_before_date) && $key == 0){ ?>
                                    <td class="text-center"><?php echo $sum_of_op_before_date > 0 ? getAmtCustom($sum_of_op_before_date) : getAmtCustom(0) ?></td>
                                    <td class="text-center"><?php echo $sum_of_op_before_date < 0 ? getAmtCustom(absCustom($sum_of_op_before_date)) : getAmtCustom(0); ?></td>
                                <?php }else{ ?>
                                    <td class="text-center"><?php echo getAmtCustom($customer->debit) ?></td>
                                    <td class="text-center"><?php echo getAmtCustom($customer->credit) ?></td>
                                <?php } ?>
                                <td><?php echo escape_output($customer->outlet_name); ?></td>
                            </tr>
                            <?php } } } ?>
                        <?php } ?>

                            <?php
                                if(isset($type) && $type == 'Credit'){
                            ?>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <?php if(isset($ledger_type) && $ledger_type == 'Ledger Details'){ ?>
                                    <th></th>
                                <?php } ?>
                                <th><?php echo lang('closing_balance');?></th>
                                <th></th>
                                <th class="text-center"><?php echo getAmtCustom(absCustom($sum_of_credit)); ?></th>
                                <th></th>
                            </tr>
                            <?php } ?>
                            <?php
                                if(isset($type) && $type == 'Debit'){
                            ?>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <?php if(isset($ledger_type) && $ledger_type == 'Ledger Details'){ ?>
                                    <th></th>
                                <?php } ?>
                                <th><?php echo lang('closing_balance');?></th>
                                <th class="text-center"><?php echo getAmtCustom(absCustom($sum_of_debit)); ?></th>
                                <th></th>
                                <th></th>
                            </tr>
                            <?php } ?>
                            <?php
                                if(isset($type) && $type == 'All'){
                            ?>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <?php if(isset($ledger_type) && $ledger_type == 'Ledger Details'){ ?>
                                    <th></th>
                                <?php } ?>
                                <th><?php echo lang('closing_balance');?></th>
                                <?php 
                                    $closing_result = 0;
                                    $closing_result =  ($sum_of_debit -  $sum_of_credit); 
                                ?>
                                <?php if($closing_result < 0){?>
                                    <th></th>
                                    <th class="text-center"><?php echo getAmtCustom(absCustom($closing_result)) ?></th>
                                <?php } else if($closing_result > 0){ ?>
                                    <th class="text-center"><?php echo getAmtCustom(absCustom($closing_result)) ?></th>
                                    <th></th>
                                <?php } ?>
                                <th></th>
                            </tr>
                            <?php } ?>
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
        <?php echo form_open(base_url() . 'Company_report/customerLedgerReport', $arrayName = array('id' => 'customerReport')) ?>
        <div class="row">
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <input  autocomplete="off" type="text" id="startDate" name="startDate" readonly class="form-control customDatepicker" placeholder="<?php echo lang('start_date'); ?>" value="<?php echo isset($_POST['startDate']) && $_POST['startDate'] ? $_POST['startDate'] : '' ?>">
                </div>
                <div class="alert alert-error error-msg startDate_err_msg_contnr ">
                    <p id="startDate_err_msg"></p>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <input  autocomplete="off" type="text" id="endDate" name="endDate" readonly class="form-control customDatepicker" placeholder="<?php echo lang('end_date'); ?>" value="<?php echo isset($_POST['endDate']) && $_POST['endDate'] ? $_POST['endDate'] : '' ?>">
                </div>
                <div class="alert alert-error error-msg endDate_err_msg_contnr ">
                    <p id="endDate_err_msg"></p>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <select  class="form-control select2 op_width_100_p"  id="customer_id" name="customer_id">
                        <option value=""><?php echo lang('customer'); ?></option>
                        <?php
                        foreach ($customers as $value) {
                            ?>
                            <option <?php echo isset($_POST['customer_id']) && $_POST['customer_id'] ? ($_POST['customer_id'] == $value->id ? 'selected' : '') : '' ?> value="<?php echo escape_output($value->id) ?>" <?php echo set_select('customer_id', $value->id); ?>><?php echo escape_output($value->name) ?> <?php echo escape_output($value->phone) != '' ? '(' . escape_output($value->phone) . ')' : '' ?></option>
                        <?php } ?>
                    </select>
                    <div class="alert alert-error error-msg customer_id_err_msg_contnr ">
                        <p id="customer_id_err_msg"></p>
                    </div>
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
                            <option <?= set_select('outlet_id',$value->id)?>  value="<?php echo escape_output($value->id) ?>"><?php echo escape_output($value->outlet_name) ?></option>
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
                <div class="form-group">
                    <select  class="form-control select2 op_width_100_p"  id="type" name="type">
                        <option value="All"><?php echo lang('all'); ?></option>
                        <option value="Debit" <?php echo set_select('type', 'Debit'); ?>><?php echo lang('debit') ?></option>
                        <option value="Credit" <?php echo set_select('type', 'Credit'); ?>><?php echo lang('credit') ?></option>
                    </select>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <select  class="form-control select2 op_width_100_p" name="ledger_type">
                        <option value="Only Ledger" <?php echo set_select('ledger_type', 'Only Ledger'); ?>><?php echo lang('Only_Ledger') ?></option>
                        <option value="Ledger Details" <?php echo set_select('ledger_type', 'Ledger Details'); ?>><?php echo lang('Ledger_Details') ?></option>
                    </select>
                </div>
            </div>
            <div class="clear-fix"></div>

            <div class="col-12 mb-2">
                <button type="submit" name="submit" value="submit" class="new-btn customerLedgerReport">
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

