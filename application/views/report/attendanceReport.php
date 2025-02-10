<input type="hidden" id="The_items_field_is_required" value="<?php echo lang('The_items_field_is_required');?>">
<input type="hidden" id="The_customer_field_is_required" value="<?php echo lang('The_customer_field_is_required');?>">
<input type="hidden" id="The_supplier_field_is_required" value="<?php echo lang('The_supplier_field_is_required');?>">
<input type="hidden" id="The_date_field_is_required" value="<?php echo lang('The_date_field_is_required');?>">
<input type="hidden" value="<?php echo lang('The_Employee_field_is_required');?>" id="The_Employee_field_is_required">


<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/report.css">
<div class="main-content-wrapper">

    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('attendance_report'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('report'), 'secondSection'=> lang('attendance_report')])?>
        </div>
    </section>

    <div class="box-wrapper">
    
        <!-- Report Header Start -->
        <div class="report_header">
            <h3 class="company_name"><?php echo escape_output($this->session->userdata('business_name'));?> </h3>
            <h5 class="outlet_info">
                <strong><?php echo lang('attendance_report'); ?></strong>
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
                <?php if(isset($employee_id) && $employee_id){ ?>
                    <strong><?php echo lang('employee'); ?>: </strong> <?= getUserName($employee_id); ?>
                <?php }else if(isset($employee_id) && $employee_id == ''){ ?>
                    <strong><?php echo lang('employee'); ?>: </strong> <?= lang('all'); ?>
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
                <input type="hidden" class="datatable_name"  data-filter="yes" data-title="<?php echo lang('attendance_report'); ?>" data-id_name="datatable">
                    <table id="datatable"  class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="w-5"><?php echo lang('sn'); ?></th>
                                <th class="w-10"><?php echo lang('ref_no'); ?></th>
                                <th class="w-15"><?php echo lang('date_and_time'); ?></th>
                                <th class="w-20"><?php echo lang('employee'); ?></th>
                                <th class="w-15"><?php echo lang('in_time'); ?></th>
                                <th class="w-15"><?php echo lang('out_time'); ?></th>
                                <th class="w-20"><?php echo lang('time_count'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total_hours = 0;
                            if (!empty($attendanceReport)) {
                                $i = count($attendanceReport);
                            foreach ($attendanceReport as $value) {
                                ?>
                                <tr>
                                    <td><?php echo $i--; ?></td>
                                    <td><?php echo escape_output($value->reference_no); ?></td>
                                    <td><?php echo dateFormat($value->added_date); ?></td>
                                    <td><?php echo escape_output($value->employee_name); ?></td>
                                    <td><?php echo escape_output($value->in_time); ?></td>
                                    <td>
                                        <?php
                                        if($value->out_time == '00:00:00'){
                                            echo 'N/A<br>';
                                        }else{
                                            echo escape_output($value->out_time);
                                        }
                                        ?>
                                    </td>
                                    <td class="text-right">
                                        <?php
                                        if($value->out_time == '00:00:00'){
                                            echo 'N/A';
                                        }else{
                                            $to_time = strtotime($value->out_time);
                                            $from_time = strtotime($value->in_time);
                                            $minute = round(absCustom($to_time - $from_time) / 60,2);
                                            $hour = round(absCustom($minute) / 60,2);
                                            echo $hour." ".lang('hour');
                                            $total_hours += $hour;
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            } }
                            ?>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-right"><b><?php echo lang('total'); ?> <?php echo lang('hours'); ?></b></td>
                                <td><?php echo $total_hours . " ".lang('hours'); ?></td>
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
        <?php echo form_open(base_url() . 'Report/attendanceReport') ?>
        <div class="row">
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <input  autocomplete="off" type="text" id="startDate" name="startDate" readonly class="form-control customDatepicker" placeholder="<?php echo lang('start_date'); ?>" value="<?php echo set_value('startDate'); ?>">
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
                    <select  class="form-control select2 op_width_100_p" id="employee_id" name="employee_id">
                        <?php
                            $role = $this->session->userdata('role');
                            if($role == '1'){
                        ?>
                        <option value=""><?php echo lang('select_employee') ?></option>
                        <?php } ?>
                        <?php
                        foreach ($employees as $value) {
                            ?>
                            <option value="<?php echo escape_output($value->id) ?>" <?php echo set_select('employee_id', $value->id); ?>><?php echo escape_output($value->full_name) ?></option>
                        <?php } ?>
                    </select>
                    <div class="alert alert-error error-msg employee_id_err_msg_contnr ">
                        <p id="employee_id_err_msg"></p>
                    </div>
                </div>
            </div>
            <div class="clear-fix"></div>
            <div class="col-12 mb-2">
                <button type="submit" name="submit" value="submit" class="new-btn attendanceReport">
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