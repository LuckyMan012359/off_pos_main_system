<input type="hidden" id="The_customer_field_is_required" value="<?php echo lang('The_customer_field_is_required');?>">
<input type="hidden" id="The_supplier_field_is_required" value="<?php echo lang('The_supplier_field_is_required');?>">
<input type="hidden" id="The_date_field_is_required" value="<?php echo lang('The_date_field_is_required');?>">
<input type="hidden" id="The_outle_field_is_required" value="<?php echo lang('The_outlet_field_is_required');?>">
<input type="hidden" id="The_registerDetails_field_is_required" value="<?php echo lang('The_registerDetails_field_is_required');?>">

<?php 
    
    $show_register_report = "";
    if(isset($register_info) && count($register_info)>0){
        $i = 1;
        foreach($register_info as $single_register_info){
            $opening_details = json_decode($single_register_info->opening_details);
            $op_balance_string = '';
            $count = count($opening_details);
            foreach($opening_details as $key=>$op_balance){
                $op = explode('||', $op_balance);
                $op_balance_string.= $op[1] . ":" . $op[2] . ($count == $key+1 ? '' : ',');
            }

            $html_others = '';
            if(isset($single_register_info->others_currency) && $single_register_info->others_currency){

                $others_details = json_decode($single_register_info->others_currency);
                foreach ($others_details as $key=>$vl){
                    $html_others .= $vl->payment_name.": ".($vl->amount);
                    if($key < (sizeof($others_details) -1)){
                        $html_others .= ", ";
                    }
                }
            }

            $show_register_report .= "<tr>";
            $show_register_report .= '<td>'.$i.'</td>';
            $show_register_report .= '<td>'.$single_register_info->user_name.'</td>';
            $show_register_report .= '<td>'.dateFormat($single_register_info->opening_balance_date_time).'</td>';
            $show_register_report .= '<td>'.$op_balance_string.'</td>';
            $show_register_report .= '<td class="text-center">'.getAmtCustom($single_register_info->sale_paid_amount).'</td>';
            $show_register_report .= '<td class="text-center">'.getAmtCustom($single_register_info->refund_amount).'</td>';
            $show_register_report .= '<td class="text-center">'.getAmtCustom($single_register_info->customer_due_receive).'</td>';
            $show_register_report .= '<td class="text-center">'.getAmtCustom($single_register_info->total_purchase).'</td>';
            $show_register_report .= '<td class="text-center">'.getAmtCustom($single_register_info->total_purchase_return).'</td>';
            $show_register_report .= '<td class="text-center">'.getAmtCustom($single_register_info->total_due_payment).'</td>';
            $show_register_report .= '<td>'.$html_others.'</td>';
            $show_register_report .= '<td class="text-center">'.getAmtCustom($single_register_info->total_expense).'</td>';
            if(!moduleIsHideCheck('Installment Sale-YES')){
                $show_register_report .= '<td class="text-center">'.getAmtCustom($single_register_info->total_downpayment).'</td>';
                $show_register_report .= '<td class="text-center">'.getAmtCustom($single_register_info->total_installmentcollection).'</td>';
            }
            if(!moduleIsHideCheck('Servicing-YES')){
                $show_register_report .= '<td class="text-center">'.getAmtCustom($single_register_info->total_servicing).'</td>';
            }
            $show_register_report .= '<td class="text-center">'.getAmtCustom($single_register_info->closing_balance).'</td>';
            $show_register_report .= '<td>'.dateFormat($single_register_info->closing_balance_date_time).'</td>';
            $show_register_report .= '<td class="text-right">'.(getPayments($single_register_info->opening_balance_date_time,$single_register_info->closing_balance_date_time,$single_register_info->user_id, $single_register_info->outlet_id)).'</td>';
            $show_register_report .= "</tr>";        
            $i++;
        }
    }
    $user_option = '';
    foreach($users as $single_user){
        $user_option .= '<option value="'.$single_user->id.'">'.$single_user->full_name.'</option>';
    }
?>

<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/report.css">
<div class="main-content-wrapper">
    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('register_report'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('report'), 'secondSection'=> lang('register_report')])?>
        </div>
    </section>

    <div class="box-wrapper"> 
        <!-- Report Header Start -->
        <div class="report_header">
            <h3 class="company_name"><?php echo escape_output($this->session->userdata('business_name'));?> </h3>
            <h5 class="outlet_info">
                <strong><?php echo lang('register_report'); ?></strong>
            </h5>
            <?php if(isset($outlet_id) && $outlet_id){
                $outlet_info = getOutletInfoById($outlet_id); 
            }?>
            <h5 class="outlet_info">
                <?php if(isset($outlet_id) && $outlet_id){ ?>
                    <strong><?php echo lang('outlet'); ?>: </strong> <?php echo  escape_output($outlet_info->outlet_name); ?>
                <?php } ?>
            </h5>
            <h5 class="outlet_info">
                <?php if(isset($outlet_id) && $outlet_id){ ?>
                    <strong><?php echo lang('address'); ?>: </strong> <?php echo  escape_output($outlet_info->address); ?>
                    <?php } ?>
            </h5>
            <h5 class="outlet_info">
                <?php if(isset($outlet_id) && $outlet_id){ ?>
                    <strong><?php echo lang('email'); ?>: </strong> <?php echo  escape_output($outlet_info->email); ?>
                    <?php } ?>
            </h5>
            <h5 class="outlet_info">
                <?php if(isset($outlet_id) && $outlet_id){ ?>
                    <strong><?php echo lang('phone'); ?>: </strong> <?php echo  escape_output($outlet_info->phone); ?>
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
                <?php if(isset($user_id) && $user_id){ ?>
                    <strong><?php echo lang('employee'); ?>: </strong> <?php echo  getUserName($user_id); ?>
                <?php }else if(isset($user_id) && $user_id == ''){ ?>
                    <strong><?php echo lang('employee'); ?>: </strong> <?php echo  lang('all'); ?>
                <?php } ?>
            </h5>
            <h5 class="outlet_info">
                <?php if(isset($report_generate_time) && $report_generate_time){
                    echo $report_generate_time;
               } ?>
            </h5>
        </div>
        <!-- Report Header End -->
     
        <!-- general form elements -->
        <div class="table-box"> 
            <!-- /.box-header -->
            <div class="table-responsive">
                <input type="hidden" class="datatable_name"  data-filter="yes" data-title="<?php echo lang('register_report'); ?>" data-id_name="datatable">
                <table id="datatable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="title w-5"><?php echo lang('sn'); ?></th>
                            <th class="title w-10"><?php echo lang('employee'); ?></th>
                            <th class="title w-15"><?php echo lang('opening_date_time'); ?></th>
                            <th class="title w-15 text-center"><?php echo lang('opening_balance'); ?></th>
                            <th class="title w-15 text-center"><?php echo lang('sale'); ?>
                                (<?php echo lang('paid_amount'); ?>)</th>
                            <th class="title w-15 text-center"><?php echo lang('sale'); ?> <?php echo lang('refund_amount'); ?> (-)</th>
                            <th class="title w-15 text-center"><?php echo lang('customer_receive'); ?> (+)</th>
                            <th class="title w-15 text-center"><?php echo lang('purchase'); ?> (-)</th>
                            <th class="title w-15 text-center"><?php echo lang('purchase_return'); ?> (+)</th>
                            <th class="title w-15 text-center"><?php echo lang('supplier_payment'); ?> (-)</th>
                            <th class="title w-15"><?php echo lang('others_currency'); ?></th>
                            <th class="title w-15 text-center"><?php echo lang('expense'); ?>(-)</th>
                            <?php if(!moduleIsHideCheck('Installment Sale-YES')){ ?>
                                <th class="title w-15 text-center"><?php echo lang('down_payment'); ?>(+)</th>
                                <th class="title w-15 text-center"><?php echo lang('installment_collection'); ?>(+)</th>
                            <?php } ?>
                            <?php if(!moduleIsHideCheck('Servicing-YES')){ ?>
                                <th class="title w-15 text-center"><?php echo lang('servicing'); ?>(+)</th>
                            <?php } ?>
                            <th class="title w-15 text-center"><?php echo lang('closing_balance'); ?></th>
                            <th class="title w-10"><?php echo lang('closing_date_time'); ?></th>
                            <th class="title w-15 text-right"><?php echo lang('sale_in_payment_method'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            echo $show_register_report;
                        ?>
                    </tbody>
                </table>
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
        <?php echo form_open(base_url() . 'Report/registerReport', ['id' => 'registerReport']) ?>
        <div class="row">

            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <select  class="form-control select2" id="outlet_id" name="outlet_id">
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
                        <option <?php echo  set_select('outlet_id',$value->id)?>  value="<?php echo escape_output($value->id) ?>"><?php echo escape_output($value->outlet_name) ?></option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                    <div class="alert alert-error error-msg outlet_id_err_msg_contnr ">
                        <p id="outlet_id_err_msg"></p>
                    </div>
                </div>
            </div>


            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <input  autocomplete="off" type="text" id="startDate" name="startDate" readonly class="form-control customDatepicker registerStartDate" placeholder="<?php echo lang('start_date'); ?>" value="<?php echo set_value('startDate'); ?>">
                </div>
                <div class="alert alert-error error-msg startDate_err_msg_contnr ">
                    <p id="startDate_err_msg"></p>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <select  class="form-control select2" id="user_id" name="user_id">
                        <?php
                            $role = $this->session->userdata('role');
                            if($role == '1'){
                        ?>
                        <option value=""><?php echo lang('select_employee') ?></option>
                        <?php } ?>
                        <?php
                        foreach ($users as $value) {
                            ?>
                            <option <?php echo isset($user_id) && $user_id && $user_id==$value->id?'selected':''?> value="<?php echo escape_output($value->id) ?>"><?php echo escape_output($value->full_name) ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <select  class="form-control select2" id="registerDetails" name="registerDetails">
                        <option value=""><?php echo lang('select') ?> <?php echo lang('report') ?></option>
                    </select>
                    <div class="alert alert-error error-msg registerDetails_err_msg_contnr ">
                        <p id="registerDetails_err_msg"></p>
                    </div>
                </div>
            </div>
            <div class="clear-fix"></div>
            <div class="col-12 mb-2">
                <button type="submit" name="submit" value="submit" class="new-btn">
                    <iconify-icon icon="solar:hourglass-broken" width="22"></iconify-icon>
                    <?php echo lang('submit'); ?>
                </button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>

<?php $this->view('updater/reuseJs_w_pagination'); ?>
<script src="<?php echo base_url();?>frequent_changing/js/report-js/register_report_validation.js"></script>
