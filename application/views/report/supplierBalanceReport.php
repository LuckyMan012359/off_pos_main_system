<input type="hidden" id="The_supplier_field_is_required" value="<?php echo lang('The_supplier_field_is_required');?>">

<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/report.css">
<script src="<?php echo base_url(); ?>frequent_changing/js/supplier-due-report.js"></script>
<div class="main-content-wrapper">
    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('supplier_balance_report'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('report'), 'secondSection'=> lang('supplier_balance_report')])?>
        </div>
    </section>

    <div class="box-wrapper">


        <!-- Report Header Start -->
        <div class="report_header">
            <h3 class="company_name"><?php echo escape_output($this->session->userdata('business_name'));?> </h3>
            <h5 class="outlet_info">
                <strong><?php echo lang('supplier_balance_report'); ?></strong>
            </h5>
            <h5 class="outlet_info">
            <?php if(isset($type) && $type){ ?>
                <strong><?php echo lang('type'); ?>: </strong> <?php echo escape_output($type); ?>
            <?php }?>
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
                <?php if(isset($report_generate_time) && $report_generate_time){
                    echo $report_generate_time;
                } ?>
            </h5>
        </div>
        <!-- Report Header End -->



        <div class="table-box">
            <div class="box-body">
                <div class="table-responsive">
                    <table id="datatable" class="table table-bordered table-striped">
                        <input type="hidden" class="datatable_name"  data-filter="yes" data-title="<?php echo lang('supplier_balance_report'); ?>" data-id_name="datatable">
                        <thead>
                            <tr>
                                <th class="op_width_2_p op_center"><?php echo lang('sn'); ?></th>
                                <th><?php echo lang('supplier'); ?></th>
                                <th class="text-right"><?php echo lang('current_balance'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                        
                            <?php
                            $total_debit = 0;
                            $total_credit = 0;
                            if (isset($suppliers)){
                                foreach ($suppliers as $key => $value) { ?>
                                <tr>
                                    <td class="op_center"><?php echo $key+1; ?></td>
                                    <td><?php echo escape_output($value->name) ?></td>
                                    <?php if($value->opening_balance < 0){ 
                                        $total_debit += absCustom($value->opening_balance); 
                                        ?>
                                        <td class="text-right"><?php echo getAmtCustom(absCustom($value->opening_balance)) . '(Debit)';?></td>
                                    <?php } else if ($value->opening_balance > 0){ 
                                        $total_credit += $value->opening_balance; 
                                        ?>
                                        <td class="text-right"><?php echo getAmtCustom($value->opening_balance) . '(Credit)';?></td>
                                    <?php }else{ ?>
                                        <td class="text-right"><?php echo getAmtCustom($value->opening_balance);?></td>
                                    <?php } ?>
                                </tr>
                            <?php } }?>
                            <?php if (isset($type) && $type){ 
                                if($type == 'Debit'){?>
                                    <tr>
                                        <th></th>
                                        <th class="text-right"><?php echo lang('Total_Debit_Amount'); ?>:</th>
                                        <th class="text-right"><?php echo getAmtCustom($total_debit); ?></th>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                            <?php if (isset($type) && $type){ 
                                if($type == 'Credit'){?>
                                    <tr>
                                        <th></th>
                                        <th class="text-right"><?php echo lang('Total_Credit_Amount'); ?>:</th>
                                        <th class="text-right"><?php echo getAmtCustom($total_credit); ?></th>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                            <?php if (isset($type) && $type == 'All'){ ?>
                                <tr>
                                    <th></th>
                                    <th class="text-right"><?php echo lang('Total_Debit_Amount'); ?>:</th>
                                    <th class="text-right"><?php echo getAmtCustom($total_debit); ?></th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th class="text-right"><?php echo lang('Total_Credit_Amount'); ?>:</th>
                                    <th class="text-right"><?php echo getAmtCustom($total_credit); ?></th>
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
        <?php echo form_open(base_url() . 'Company_report/supplierBalanceReport') ?>
        <div class="row">
            <div class="col-sm-12 col-md-12 mb-2">
                <div class="form-group">
                    <select class="form-control select2 op_width_100_p" name="type" id="type">
                        <option value=""><?php echo lang('type'); ?></option>
                        <option value="All" <?php echo set_select('type', 'All'); ?>><?php echo lang('All');?></option>
                        <option value="Debit" <?php echo set_select('type', 'Debit'); ?>><?php echo lang('Debit');?></option>
                        <option value="Credit" <?php echo set_select('type', 'Credit'); ?>><?php echo lang('Credit');?></option>
                    </select>
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
