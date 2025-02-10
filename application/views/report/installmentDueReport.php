<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/report.css">
<input type="hidden" id="The_customer_field_is_required" value="<?php echo lang('The_customer_field_is_required');?>">
<div class="main-content-wrapper">

    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('installmentDueReport'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('report'), 'secondSection'=> lang('installmentDueReport')])?>
        </div>
    </section>

    <div class="box-wrapper"> 
        <!-- Report Header Start -->
        <div class="report_header">
            <h3 class="company_name"><?php echo escape_output($this->session->userdata('business_name'));?> </h3>
            <h5 class="outlet_info">
                <strong><?php echo lang('installmentDueReport'); ?></strong>
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
                    <strong><?php echo lang('customer'); ?>: </strong> <?php echo getCustomerName($customer_id) ?>
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
                <input type="hidden" class="datatable_name"  data-filter="yes" data-title="<?php echo lang('installmentDueReport'); ?>" data-id_name="datatable">
                    <table id="datatable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="w-5"><?php echo lang('sn'); ?></th>
                                <th class="w-8"><?php echo lang('invoice_no'); ?></th>
                                <th class="w-12"><?php echo lang('sale'); ?> <?php echo lang('date_and_time'); ?></th>
                                <th class="w-12"><?php echo lang('customer'); ?> (<?php echo lang('phone'); ?>)</th>
                                <th class="w-10"><?php echo lang('product'); ?></th>
                                <th class="w-6 text-center"><?php echo lang('price'); ?></th>
                                <th class="w-8 text-center"><?php echo lang('percentage_of_interest'); ?></th>
                                <th class="w-8 text-center"><?php echo lang('amount_of_interest'); ?></th>
                                <th class="w-8 text-center"><?php echo lang('total'); ?></th>
                                <th class="w-8 text-center"><?php echo lang('down_payment'); ?></th>
                                <th class="w-8 text-center"><?php echo lang('total_installment'); ?></th>
                                <th class="w-8 text-center"><?php echo lang('total_paid'); ?></th>
                                <th class="w-8"><?php echo lang('last_payment_date'); ?></th>
                                <th class="w-8 text-center"><?php echo lang('current_due'); ?></th>
                                <th class="w-8"><?php echo lang('actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $total_price = 0;
                        $grandTotal = 0;
                        $grandInterest = 0;
                        $grandDownPayment = 0;
                        $grandtotal_paid = 0;
                        $grandtotal_due = 0;
                        if(isset($installments)):
                        foreach ($installments as $key=>$cust) {
                            $remaining_due = getInstallmentRemainingDue($cust->id);
                            $total_paid = getInstallmentTotalPaid($cust->id);

                            $grandtotal_due += $remaining_due;

                            $total_price += $cust->price;
                            $grandTotal += $cust->total;
                            $grandInterest += ($cust->price*$cust->percentage_of_interest/100);
                            $grandDownPayment += $cust->down_payment;
                            $grandtotal_paid += ($total_paid + $cust->down_payment);
                            ?>
                            <tr>
                                <td class="op_center"><?php echo $key+1; ?></td>
                                <td><?php echo escape_output($cust->reference_no); ?></td>
                                <td><?php echo dateFormat($cust->added_date); ?></td>
                                <td><?php echo escape_output($cust->customer_name); ?> (<?php echo escape_output($cust->phone); ?>)</td>
                                <td><?php echo escape_output($cust->item_name . ' (' . $cust->code . ')'); ?></td>
                                <td class="text-center"><?php echo getAmtCustom($cust->price); ?></td>
                                <td class="text-center"><?php echo escape_output($cust->percentage_of_interest); ?> %</td>
                                <td class="text-center"><?php echo getAmtCustom($cust->price*$cust->percentage_of_interest/100); ?></td>
                                <td class="text-center"><?php echo getAmtCustom($cust->total); ?></td>
                                <td class="text-center"><?php echo getAmtCustom($cust->down_payment); ?></td>
                                <td class="text-center"><?php echo escape_output($cust->number_of_installment); ?></td>
                                <td class="text-center"><?php echo getAmtCustom($total_paid + $cust->down_payment); ?></td>
                                <td><?php echo lastPaymentDate($cust->id); ?></td>
                                <td class="text-center"><?php echo getAmtCustom($remaining_due); ?></td>
                                <td><a href="<?php echo base_url() ?>Installment/viewDetails/<?php echo escape_output($this->custom->encrypt_decrypt($cust->id, 'encrypt')); ?>" ><?php echo lang('view_details'); ?></a></td>
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
                            <th><?php echo lang('total'); ?></th>
                            <th><?php echo getAmtCustom($total_price)?></th>
                            <th></th>
                            <th class="text-center"><?php echo getAmtCustom($grandInterest)?></th>
                            <th class="text-center"><?php echo getAmtCustom($grandTotal)?></th>
                            <th class="text-center"><?php echo getAmtCustom($grandDownPayment)?></th>
                            <th></th>
                            <th class="text-center"><?php echo getAmtCustom($grandtotal_paid)?></th>
                            <th></th>
                            <th class="text-center"><?php echo getAmtCustom($grandtotal_due)?></th>
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
        <?php echo form_open(base_url() . 'Report/installmentDueReport', $arrayName = array('id' => 'purchaseReportByIngredient')) ?>
        <div class="row">
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <select  class="form-control select2 op_width_100_p" id="customer_id" name="customer_id">
                        <option value=""><?php echo lang('select'); ?> <?php echo lang('customer'); ?></option>
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
                <button type="submit" name="submit" value="submit" class="new-btn installmentDueReport">
                    <iconify-icon icon="solar:hourglass-broken" width="22"></iconify-icon>
                    <?php echo lang('submit'); ?>
                </button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>



<?php $this->view('updater/reuseJs_w_pagination'); ?>
<script src="<?php echo base_url(); ?>frequent_changing/js/installment_due_report.js"></script>