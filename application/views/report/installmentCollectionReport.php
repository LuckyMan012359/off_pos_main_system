<input type="hidden" id="The_customer_field_is_required" value="<?php echo lang('The_customer_field_is_required');?>">
<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/report.css">

<div class="main-content-wrapper">

    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('Installment_Collection_Report'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('report'), 'secondSection'=> lang('Installment_Collection_Report')])?>
        </div>
    </section>




    <div class="box-wrapper"> 

        <!-- Report Header Start -->
        <div class="report_header">
            <h3 class="company_name"><?php echo escape_output($this->session->userdata('business_name'));?> </h3>
            <h5 class="outlet_info">
                <strong><?php echo lang('Installment_Collection_Report'); ?></strong>
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
                    <strong><?php echo lang('customer'); ?>: </strong> <?php echo getCustomerName($customer_id) ;?>
                <?php } ?>
            </h5>
            <h5 class="outlet_info">
                <?php if(isset($paid_status) && $paid_status){ ?>
                    <strong><?php echo lang('payment_status'); ?>: </strong> <?php echo $paid_status ;?>
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
                    <table id="datatable" class="table table-bordered table-striped">
                    <input type="hidden" class="datatable_name"  data-filter="yes" data-title="<?php echo lang('Installment_Collection_Report'); ?>" data-id_name="datatable">
                        <thead>
                            <tr>
                                <th class="w-5"><?php echo lang('sn'); ?></th>
                                <th class="w-12"><?php echo lang('invoice_no'); ?></th>
                                <th class="w-12"><?php echo lang('date_and_time'); ?></th>
                                <th class="w-12"><?php echo lang('customer'); ?> (<?php echo lang('phone'); ?>)</th>
                                <th class="w-10"><?php echo lang('product'); ?></th>
                                <th class="w-10 text-center"><?php echo lang('amount_of_installment'); ?></th>
                                <th class="w-12"><?php echo lang('installment_date'); ?></th>
                                <th class="w-10 text-center"><?php echo lang('paid_amount'); ?></th>
                                <th class="w-12"><?php echo lang('paid_date'); ?></th>
                                <th class="w-8"><?php echo lang('payment_status'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $total_amount = 0;
                        $total_paid = 0;
                        if(isset($payments)):
                        foreach ($payments as $key=>$cust) {
                            $total_amount+=$cust->amount_of_payment;
                            $total_paid+=$cust->paid_amount;
                            ?>
                            <tr>
                                <td><?php echo $key+1; ?></td>
                                <td><?php echo escape_output($cust->reference_no); ?></td>
                                <td><?php echo dateFormat($cust->added_date); ?></td>
                                <td><?php echo escape_output($cust->customer_name); ?> (<?php echo escape_output($cust->phone); ?>)</td>
                                <td><?php echo escape_output($cust->item_name); ?></td>
                                <td class="text-center"><?php echo getAmtCustom($cust->amount_of_payment); ?></td>
                                <td><?php echo dateFormat($cust->payment_date); ?></td>
                                <td class="text-center"><?php echo getAmtCustom($cust->paid_amount); ?></td>
                                <td><?php echo dateFormat($cust->paid_date); ?></td>
                                <td><?php echo escape_output($cust->paid_status); ?></td>
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
                            <th class="text-right"><?php echo lang('total'); ?></th>
                            <th class="text-center"><?php echo getAmtCustom($total_amount)?></th>
                            <th></th>
                            <th class="text-center"><?php echo getAmtCustom($total_paid)?></th>
                            <th></th>
                            <th></th>
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
        <?php echo form_open(base_url() . 'Report/installmentReport', $arrayName = array('id' => 'purchaseReportByIngredient')) ?>
        <div class="row">
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <select  class="form-control select2 op_width_100_p" id="customer_id" name="customer_id">
                        <option value=""><?php echo lang('customer'); ?></option>
                        <?php
                        foreach ($customers as $value) {
                            ?>
                            <option value="<?php echo escape_output($value->id) ?>" <?php echo set_select('customer_id', $value->id); ?>><?php echo escape_output($value->name); ?> <?php echo escape_output($value->phone ? '(' . $value->phone . ')' : ''); ?></option>
                        <?php } ?>
                    </select>
                    <div class="alert alert-error error-msg customer_id_err_msg_contnr ">
                        <p id="customer_id_err_msg"></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-2">
                <input type="hidden" name="hide_ins_id" id="hide_ins_id" value="<?php echo set_value('installment_id')?>">
                <div class="form-group">
                    <select  class="form-control select2 op_width_100_p" id="installment_id" name="installment_id">
                        <option value=""><?php echo lang('select_invoice'); ?></option>
                    </select>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <select  class="form-control select2 op_width_100_p" id="paid_status" name="paid_status">
                        <option value=""><?php echo lang('payment_status'); ?></option>
                        <option value="Paid" <?php echo set_select('paid_status', "Paid"); ?>><?php echo lang('paid');?></option>
                        <option value="Unpaid" <?php echo set_select('paid_status', "Unpaid"); ?>><?php echo lang('unpaid');?></option>
                        <option value="Partially Paid" <?php echo set_select('paid_status', "Partially Paid"); ?>><?php echo lang('Partially_Paid');?></option>
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
                <button type="submit" name="submit" value="submit" class="new-btn installmentReport">
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
<script src="<?php echo base_url(); ?>frequent_changing/js/installment_collection_report.js"></script>