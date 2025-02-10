<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/report.css">

<section class="main-content-wrapper">
    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('usage_loyalty_point_report') ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('report'), 'secondSection'=> lang('usage_loyalty_point_report')])?>
        </div>
    </section>


    <div class="box-wrapper">
        <!-- Report Header Start -->
        <div class="report_header">
            <h3 class="company_name"><?php echo escape_output($this->session->userdata('business_name'));?> </h3>
            <h5 class="outlet_info">
                <strong><?php echo lang('usage_loyalty_point_report'); ?></strong>
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
                <?php if(isset($customer_id) && $customer_id){ ?>
                    <strong><?php echo lang('customer'); ?>: </strong> <?php echo escape_output(getCustomerName($customer_id)); ?>
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
            <div class="table-responsive">
                <input type="hidden" class="datatable_name"  data-filter="yes" data-title="<?php echo lang('usage_loyalty_point_report'); ?>" data-id_name="datatable">
                <table id="datatable" class="datatable table">
                    <thead>
                    <tr>
                        <th><?php echo lang('sn'); ?></th>
                        <th><?php echo lang('date_time'); ?></th>
                        <th><?php echo lang('sale_no'); ?></th>
                        <th><?php echo lang('customer'); ?>(<?php echo lang('phone'); ?>)</th>
                        <th class="text-center"><?php echo lang('usage_point'); ?></th>
                        <th><?php echo lang('redeemed_amount'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (isset($customers)):
                        $is_loyalty_enable = $this->session->userdata('is_loyalty_enable');
                        $counter =1;
                        foreach ($customers as $key => $value) {
                            $redeemed_point = 0;
                            $available_point = 0;
                            if (isset($is_loyalty_enable) && $is_loyalty_enable == "enable"):
                                $available_point = $value->usage_point;
                                $redeemed_point = $value->amount;
                            endif;
                            if($available_point):
                                $key++;
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo escape_output($counter); ?></td>
                                    <td><?php echo dateFormat($value->date_time)?></td>
                                    <td><?php echo escape_output($value->sale_no) ?></td>
                                    <td><?php echo escape_output($value->name) ?><?php echo escape_output($value->phone ? '(' . $value->phone . ')' : '') ?></td>
                                    <td class="text-center"><?php echo escape_output($available_point) ?></td>
                                    <td><?php echo getAmtCustom($redeemed_point) ?></td>
                                </tr>
                                <?php
                                $counter++;
                            endif;
                        }
                    endif;
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>


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
        <?php echo form_open(base_url() . 'Report/usageLoyaltyPointReport') ?>
        <div class="row">
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <input  autocomplete="off" type="text" name="startDate" readonly
                        class="form-control customDatepicker" placeholder="<?php echo lang('start_date'); ?>"
                        value="<?php echo set_value('startDate'); ?>">
                    <?php if (form_error('startDate')) { ?>
                    <div class="callout callout-danger my-2">
                        <span class="error_paragraph"><?php echo form_error('startDate'); ?></span>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <input  autocomplete="off" type="text" id="endMonth" name="endDate" readonly
                        class="form-control customDatepicker" placeholder="<?php echo lang('end_date'); ?>"
                        value="<?php echo set_value('endDate'); ?>">
                    <?php if (form_error('endDate')) { ?>
                    <div class="callout callout-danger my-2">
                        <span class="error_paragraph"><?php echo form_error('endDate'); ?></span>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <select  class="form-control select2 op_width_100_p" id="customer_id" name="customer_id">
                        <option value=""><?php echo lang('select'); ?> <?php echo lang('customer'); ?></option>
                        <?php
                        foreach ($customers_dropdown as $value) {
                            ?>
                            <option value="<?php echo escape_output($value->id) ?>" <?php echo set_select('customer_id', $value->id); ?>><?php echo escape_output($value->name); ?> <?php echo escape_output($value->phone ? '(' . $value->phone . ')' : ''); ?></option>
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
            <?php
                endif;
            ?>
            <div class="clear-fix"></div>
            <div class="col-12 mb-2">
                <button type="submit" name="submit" value="submit" class="new-btn itemMoving">
                    <iconify-icon icon="solar:hourglass-broken" width="22"></iconify-icon>
                    <?php echo lang('submit'); ?>
                </button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>





<!-- DataTables -->
<?php $this->view('updater/reuseJs_w_pagination'); ?>
<script src="<?php echo base_url();?>frequent_changing/js/report-js/master_report_validation.js"></script>